<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Services\ReviewContentGuard;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Ulasan / penilaian layanan dari masyarakat (mendukung indikator pelayanan publik WBK).
 *
 * Lapisan pengamanan:
 *  1. CSRF (bawaan Laravel)
 *  2. Rate limit per IP & global (AppServiceProvider: "review-submit")
 *  3. Honeypot field tersembunyi
 *  4. Time-trap terenkripsi (bot yang mengirim < 5 detik ditolak diam-diam)
 *  5. Captcha gambar (atau Cloudflare Turnstile bila dikonfigurasi)
 *  6. Validasi ketat nama/teks + maksimal 2 ulasan per IP per 24 jam + tolak duplikat
 *  7. Filter konten judol/tautan/nomor kontak (ReviewContentGuard) → karantina spam
 *  8. Semua ulasan wajib dimoderasi admin sebelum tampil; output selalu di-escape
 */
class PublicReviewController extends Controller
{
    private const MIN_FILL_SECONDS = 5;
    private const MAX_FORM_AGE = 7200;
    private const MAX_PER_IP_PER_DAY = 2;

    public function index()
    {
        $approved = Review::approved();

        $total = (clone $approved)->count();
        $average = $total ? round((clone $approved)->avg('rating'), 2) : 0;
        $distribution = (clone $approved)
            ->selectRaw('rating, COUNT(*) as total')
            ->groupBy('rating')
            ->pluck('total', 'rating');
        $satisfied = $total ? round(((clone $approved)->where('rating', '>=', 4)->count() / $total) * 100, 1) : 0;

        $reviews = Review::approved()
            ->with('book:id,title')
            ->latest()
            ->paginate(9)
            ->fragment('daftar-ulasan');

        return view('reviews.index', [
            'reviews' => $reviews,
            'total' => $total,
            'average' => $average,
            'distribution' => $distribution,
            'satisfied' => $satisfied,
            'formToken' => Crypt::encryptString((string) time()),
            'turnstileKey' => config('services.turnstile.site_key'),
            'roles' => Review::ROLES,
        ]);
    }

    public function store(Request $request, ReviewContentGuard $guard)
    {
        $ipHash = hash_hmac('sha256', (string) $request->ip(), (string) config('app.key'));
        $success = fn () => redirect()->to(route('reviews.index') . '#form-ulasan')
            ->with('review_success', 'Terima kasih! Ulasan Anda telah diterima dan akan tampil setelah diverifikasi oleh admin.');

        // 3. Honeypot: manusia tidak melihat field ini. Pura-pura sukses agar bot tidak belajar.
        if (filled($request->input('website')) || filled($request->input('fax_number'))) {
            $this->logBlocked($ipHash, 'honeypot terisi');
            return $success();
        }

        // 4. Time-trap
        try {
            $issuedAt = (int) Crypt::decryptString((string) $request->input('_ft'));
        } catch (DecryptException) {
            $this->logBlocked($ipHash, 'token formulir tidak valid');
            return $this->backToForm()->withErrors(['review_text' => 'Sesi formulir tidak valid. Silakan muat ulang halaman.']);
        }
        $elapsed = time() - $issuedAt;
        if ($elapsed < self::MIN_FILL_SECONDS) {
            $this->logBlocked($ipHash, "terlalu cepat ({$elapsed} dtk)");
            return $success();
        }
        if ($elapsed > self::MAX_FORM_AGE) {
            return $this->backToForm()->withErrors(['review_text' => 'Formulir kedaluwarsa. Silakan muat ulang halaman lalu kirim kembali.']);
        }

        // 6. Validasi
        $request->merge([
            'reviewer_name' => preg_replace('/\s+/u', ' ', trim((string) $request->input('reviewer_name'))),
            'review_text' => trim(preg_replace("/\n{3,}/", "\n\n", str_replace("\r", '', strip_tags((string) $request->input('review_text'))))),
            'reviewer_email' => strtolower(trim((string) $request->input('reviewer_email'))) ?: null,
        ]);

        $validator = Validator::make($request->all(), [
            'reviewer_name' => ['required', 'string', 'min:3', 'max:60', 'regex:/^[\pL][\pL\s\.\'\-,]*$/u'],
            'reviewer_role' => ['required', Rule::in(Review::ROLES)],
            'reviewer_email' => ['nullable', 'email:rfc', 'max:120'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'review_text' => ['required', 'string', 'min:20', 'max:1000'],
            'consent' => ['accepted'],
        ], [
            'reviewer_name.regex' => 'Nama hanya boleh berisi huruf, spasi, titik, koma, apostrof, atau tanda hubung.',
            'reviewer_name.min' => 'Nama minimal 3 karakter.',
            'review_text.min' => 'Ulasan minimal 20 karakter agar bermanfaat bagi pembaca lain.',
            'review_text.max' => 'Ulasan maksimal 1000 karakter.',
            'consent.accepted' => 'Anda perlu menyetujui ketentuan pengiriman ulasan.',
            'rating.required' => 'Silakan pilih jumlah bintang.',
            'reviewer_role.required' => 'Silakan pilih kategori Anda.',
        ]);

        if ($validator->fails()) {
            return $this->backToForm()->withErrors($validator);
        }
        $validated = $validator->validated();

        // 5. Captcha / Turnstile
        if (! $this->passesHumanCheck($request)) {
            return $this->backToForm()->withErrors(['captcha' => 'Verifikasi keamanan tidak sesuai. Silakan coba lagi.']);
        }

        // 6b. Batas per IP & duplikat
        $recentFromIp = Review::where('ip_hash', $ipHash)
            ->where('created_at', '>=', now()->subDay())
            ->count();
        if ($recentFromIp >= self::MAX_PER_IP_PER_DAY) {
            $this->logBlocked($ipHash, 'melebihi batas harian per IP');
            return $this->backToForm()->withErrors(['review_text' => 'Anda sudah mengirim ulasan hari ini. Silakan coba lagi besok.']);
        }

        $contentHash = hash('sha256', preg_replace('/[^a-z0-9]/', '', $guard->normalize($validated['review_text'])));
        if (Review::where('content_hash', $contentHash)->exists()) {
            $this->logBlocked($ipHash, 'konten duplikat');
            return $this->backToForm()->withErrors(['review_text' => 'Ulasan dengan isi yang sama sudah pernah dikirim.']);
        }

        // 7. Filter konten
        $check = $guard->inspect($validated['reviewer_name'], $validated['review_text'], $validated['reviewer_email']);

        Review::create([
            'reviewer_name' => $validated['reviewer_name'],
            'reviewer_role' => $validated['reviewer_role'],
            'reviewer_email' => $validated['reviewer_email'],
            'review_text' => $validated['review_text'],
            'rating' => (int) $validated['rating'],
            'type' => 'publisher',
            'source' => 'public',
            'is_approved' => false,
            'is_featured' => false,
            'is_spam' => $check['spam'],
            'spam_score' => $check['score'],
            'spam_reasons' => $check['reasons'] ?: null,
            'ip_hash' => $ipHash,
            'user_agent' => mb_substr((string) $request->userAgent(), 0, 255),
            'content_hash' => $contentHash,
        ]);

        if ($check['spam']) {
            $this->logBlocked($ipHash, 'dikarantina: ' . implode('; ', $check['reasons']));
        }

        // Respon sama untuk spam & bukan spam — spammer tidak tahu bahwa kirimannya dikarantina.
        return $success();
    }

    /** Captcha gambar aritmatika sederhana (tanpa layanan pihak ketiga). */
    public function captcha(Request $request)
    {
        $a = random_int(2, 9);
        $b = random_int(1, 9);
        $useMinus = random_int(0, 1) === 1 && $a > $b;
        $answer = $useMinus ? $a - $b : $a + $b;
        $request->session()->put('review_captcha', $answer);

        $text = $a . ($useMinus ? ' - ' : ' + ') . $b . ' = ?';

        // Gambar kecil lalu diperbesar → huruf tampak "kasar" dan sulit di-OCR sederhana
        $small = imagecreatetruecolor(80, 22);
        imagefill($small, 0, 0, imagecolorallocate($small, 241, 245, 249));
        $x = 4;
        foreach (str_split($text) as $char) {
            $color = imagecolorallocate($small, random_int(20, 90), random_int(20, 90), random_int(60, 140));
            imagestring($small, 5, $x, random_int(1, 6), $char, $color);
            $x += $char === ' ' ? 5 : 9;
        }

        $img = imagecreatetruecolor(170, 48);
        imagecopyresampled($img, $small, 0, 0, 0, 0, 170, 48, 80, 22);
        imagedestroy($small);

        for ($i = 0; $i < 6; $i++) {
            $c = imagecolorallocatealpha($img, random_int(80, 200), random_int(80, 200), random_int(80, 200), 60);
            imageline($img, random_int(0, 170), random_int(0, 48), random_int(0, 170), random_int(0, 48), $c);
        }
        for ($i = 0; $i < 250; $i++) {
            $c = imagecolorallocate($img, random_int(120, 220), random_int(120, 220), random_int(120, 220));
            imagesetpixel($img, random_int(0, 169), random_int(0, 47), $c);
        }

        ob_start();
        imagepng($img);
        imagedestroy($img);
        $png = ob_get_clean();

        return response($png, 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
        ]);
    }

    private function passesHumanCheck(Request $request): bool
    {
        $secret = config('services.turnstile.secret');

        if ($secret && config('services.turnstile.site_key')) {
            $token = (string) $request->input('cf-turnstile-response');
            if ($token === '') {
                return false;
            }
            try {
                return (bool) Http::asForm()->timeout(8)
                    ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                        'secret' => $secret,
                        'response' => $token,
                        'remoteip' => $request->ip(),
                    ])->json('success');
            } catch (\Throwable $e) {
                Log::warning('Turnstile verify gagal: ' . $e->getMessage());
                return false;
            }
        }

        // Jawaban captcha sekali pakai: selalu dihapus dari sesi (mencegah replay)
        $expected = $request->session()->pull('review_captcha');
        $given = trim((string) $request->input('captcha'));

        return $expected !== null && $given !== '' && ctype_digit($given) && (int) $given === (int) $expected;
    }

    /** Selalu kembali ke formulir (bukan back(): URL sebelumnya bisa berupa gambar captcha). */
    private function backToForm()
    {
        return redirect()->to(route('reviews.index') . '#form-ulasan')
            ->withInput(request()->except(['captcha', '_ft', 'website', 'fax_number']));
    }

    private function logBlocked(string $ipHash, string $reason): void
    {
        Log::warning('[ulasan-publik] ' . $reason, ['ip_hash' => substr($ipHash, 0, 16)]);
    }
}
