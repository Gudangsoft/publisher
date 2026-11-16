<?php

namespace App\Services;

use Normalizer;

/**
 * Pemeriksa konten ulasan publik.
 *
 * Mendeteksi promosi judi online (judol), tautan, nomor kontak, konten dewasa,
 * dan trik penyamaran yang biasa dipakai spammer: huruf unicode "fancy"
 * (𝐒𝐋𝐎𝐓), karakter tak terlihat, huruf Kiril yang mirip Latin,
 * huruf dipisah-pisah (s.l.o.t / g a c o r), dan angka pengganti huruf (g4c0r).
 *
 * Hasil: skor + daftar alasan. Skor >= BLOCK_SCORE dianggap spam dan
 * dikarantina (tidak pernah tampil ke publik).
 */
class ReviewContentGuard
{
    public const BLOCK_SCORE = 100;

    /** Istilah yang hampir pasti promosi judol/dewasa — dicocokkan pada teks tanpa spasi. */
    private const HARD_COMPACT = [
        'gacor', 'togel', 'maxwin', 'sbobet', 'judol', 'judionline', 'judiol',
        'slotonline', 'slotgacor', 'situsslot', 'situsjudi', 'situstoto', 'situsgacor',
        'agenslot', 'agenjudi', 'agentogel', 'bandarjudi', 'bandartogel', 'bandarslot',
        'mahjongways', 'scatterhitam', 'pragmaticplay', 'pgsoft', 'gatesofolympus', 'sweetbonanza',
        'bonusnewmember', 'linkalternatif', 'depositpulsa', 'depopulsa', 'rtpslot', 'rtplive',
        'dominoqq', 'pokeronline', 'bolatangkas', 'sabungayam', 'livecasino', 'freechip', 'freebet',
        'polaslot', 'akungacor', 'slotdemo', 'cheatslot', 'tokenslot', 'jackpotslot',
        'bokep', 'pornhub', 'xvideos', 'videocallsex', 'pinjolcepat',
    ];

    /** Pola regex keras pada teks ternormalisasi (dengan spasi). */
    private const HARD_PATTERNS = [
        '/\b(slot|toto|togel|win|bet|hoki|mpo|gacor|cuan|jp|bos|raja|dewa|king)\s?\d{2,4}\b/' => 'nama situs judi (kata+angka)',
        '/\b(casino|kasino)\b/' => 'kasino',
        '/\bopen\s?(bo|vcs)\b/' => 'konten dewasa',
        '/\b(vcs|sange|ngewe)\b/' => 'konten dewasa',
    ];

    /** Kata yang mencurigakan bila muncul bersamaan (masing-masing berbobot). */
    private const SOFT_WORDS = [
        'slot' => 50, 'judi' => 40, 'taruhan' => 40, 'jackpot' => 40, 'scatter' => 50,
        'deposit' => 35, 'depo' => 45, 'withdraw' => 40, 'wd' => 45, 'jp' => 35,
        'rtp' => 45, 'toto' => 30, 'poker' => 40, 'bet' => 30, 'betting' => 50,
        'pinjol' => 40, 'daftar' => 15, 'login' => 20, 'link' => 30, 'bio' => 20,
        'promo' => 20, 'bonus' => 25, 'member' => 15, 'admin' => 15, 'cuan' => 30,
        'hoki' => 25, 'menang' => 15, 'dijamin' => 20, 'terpercaya' => 20, 'gampang' => 10,
        'viagra' => 60, 'crypto' => 30, 'airdrop' => 40, 'trading' => 20,
    ];

    /** Domain email sekali-pakai yang umum. */
    private const DISPOSABLE_DOMAINS = [
        'mailinator.com', 'guerrillamail.com', '10minutemail.com', 'tempmail.com', 'temp-mail.org',
        'yopmail.com', 'trashmail.com', 'sharklasers.com', 'getnada.com', 'dispostable.com',
        'maildrop.cc', 'throwawaymail.com', 'fakeinbox.com', 'mohmal.com', 'emailondeck.com',
    ];

    private const LEET = [
        '0' => 'o', '1' => 'i', '3' => 'e', '4' => 'a', '5' => 's', '7' => 't',
        '8' => 'b', '9' => 'g', '@' => 'a', '$' => 's', '!' => 'i', '|' => 'l', '€' => 'e',
    ];

    /**
     * @return array{score:int, reasons:array<int,string>, spam:bool}
     */
    public function inspect(string $name, string $text, ?string $email = null): array
    {
        $reasons = [];
        $score = 0;

        $add = function (int $points, string $reason) use (&$score, &$reasons) {
            $score += $points;
            $reasons[] = $reason;
        };

        foreach (['nama' => $name, 'ulasan' => $text] as $field => $raw) {
            // 1. Karakter tak terlihat / penyamaran unicode
            if (preg_match('/[\x{200B}-\x{200F}\x{202A}-\x{202E}\x{2060}-\x{2064}\x{FEFF}\x{00AD}]/u', $raw)) {
                $add(100, "karakter tersembunyi pada {$field}");
            }
            if (preg_match('/[\x{1D400}-\x{1D7FF}\x{FF01}-\x{FF5E}\x{24B6}-\x{24E9}\x{1F130}-\x{1F189}]/u', $raw)) {
                $add(60, "huruf unicode hias pada {$field}");
            }
            if ($this->hasMixedScript($raw)) {
                $add(100, "campuran huruf Latin & Kiril/Yunani pada {$field}");
            }

            // 2. HTML / skrip
            if (preg_match('/<\s*\/?\s*[a-z][^>]*>|&lt;|javascript:|\[url|\[link/i', $raw)) {
                $add(100, "tag HTML/BBCode pada {$field}");
            }

            $norm = $this->normalize($raw);
            $deleet = strtr($norm, self::LEET);
            $joined = $this->joinSpacedLetters($deleet);
            $tokens = preg_split('/[^a-z0-9]+/', $joined, -1, PREG_SPLIT_NO_EMPTY);

            // 3. Tautan & domain (termasuk "nama dot com", "nama . xyz")
            if (preg_match('/(https?:|www\s*\.|\bbit\s*\.?\s*ly\b|\bs\s*\.\s*id\b|wa\s*\.\s*me|t\s*\.\s*me\b|linktr\s*\.?\s*ee)/i', $norm)
                || preg_match('/\b[a-z0-9-]{2,}\s*(\.|\(\.\)|\[\.\]|\bdot\b|\(dot\)|\[dot\])\s*(com|net|org|xyz|id|io|co|site|online|top|vip|link|me|info|biz|club|pro|live|bet|win|asia|cc|ly|app|store|shop|fun|games?|icu|sbs|cfd|lol)\b/i', $norm)) {
                $add(100, "tautan/domain pada {$field}");
            }

            // 4. Nomor kontak (WA/telepon) dan ajakan kontak
            if (preg_match_all('/(?:\+?\s*62|\b0)\s*8[\d\s\.\-\(\)]{7,18}\d/', $norm, $phones)) {
                foreach ($phones[0] as $phone) {
                    $len = strlen(preg_replace('/\D/', '', $phone));
                    if ($len >= 10 && $len <= 15) {
                        $add(100, "nomor telepon pada {$field}");
                        break;
                    }
                }
            }
            if (preg_match('/\b(whatsapp|wa|telegram|tele|tg|line|dm|inbox|ig|instagram)\b.{0,15}\b(admin|kami|saya|aku|ya|sekarang|langsung)\b/', $norm)) {
                $add(40, "ajakan menghubungi kontak pada {$field}");
            }
            if (preg_match('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}/i', $raw)) {
                $add(60, "alamat email di dalam {$field}");
            }

            // 5. Kata kunci judol / dewasa
            if ($term = $this->findHardTerm($tokens)) {
                $add(100, "kata terlarang \"{$term}\" pada {$field}");
            }
            foreach (self::HARD_PATTERNS as $pattern => $label) {
                if (preg_match($pattern, $joined) || preg_match($pattern, $norm)) {
                    $add(100, "{$label} pada {$field}");
                    break;
                }
            }

            $words = array_count_values($tokens);
            $soft = 0;
            $softHits = [];
            foreach (self::SOFT_WORDS as $word => $weight) {
                if (isset($words[$word])) {
                    $soft += $weight;
                    $softHits[] = $word;
                }
            }
            if ($soft > 0) {
                $add($soft, 'kata mencurigakan (' . implode(', ', $softHits) . ") pada {$field}");
            }
        }

        // 6. Ciri teks spam/bot pada isi ulasan
        $letters = preg_replace('/[^\p{L}]/u', '', $text);
        $letterCount = mb_strlen($letters);
        if ($letterCount >= 20) {
            $upper = preg_match_all('/\p{Lu}/u', $letters);
            if ($upper / $letterCount > 0.7) {
                $add(20, 'didominasi huruf kapital');
            }
        }
        if (preg_match('/(.)\1{5,}/u', $text)) {
            $add(20, 'karakter berulang berlebihan');
        }
        $emoji = preg_match_all('/[\x{1F300}-\x{1FAFF}\x{2600}-\x{27BF}]/u', $text);
        if ($emoji > 5) {
            $add(25, 'emoji berlebihan');
        }
        $tokens = preg_split('/\s+/u', mb_strtolower(trim($text)), -1, PREG_SPLIT_NO_EMPTY);
        if (count($tokens) >= 8 && count(array_unique($tokens)) / count($tokens) < 0.4) {
            $add(30, 'kata diulang-ulang');
        }
        if ($letterCount > 0 && preg_match_all('/\d/', $text) / max(1, mb_strlen($text)) > 0.3) {
            $add(30, 'terlalu banyak angka');
        }

        // 7. Email sekali-pakai
        if ($email) {
            $domain = strtolower(substr(strrchr($email, '@') ?: '', 1));
            if (in_array($domain, self::DISPOSABLE_DOMAINS, true)) {
                $add(40, 'email sekali-pakai');
            }
        }

        return [
            'score' => min($score, 65535),
            'reasons' => array_values(array_unique($reasons)),
            'spam' => $score >= self::BLOCK_SCORE,
        ];
    }

    /** NFKC (𝐒𝐋𝐎𝐓 → SLOT, ｇａｃｏｒ → gacor), hapus diakritik & karakter tak terlihat, huruf kecil. */
    public function normalize(string $text): string
    {
        $text = preg_replace('/[\x{200B}-\x{200F}\x{202A}-\x{202E}\x{2060}-\x{2064}\x{FEFF}\x{00AD}]/u', '', $text);

        if (class_exists(Normalizer::class)) {
            $text = Normalizer::normalize($text, Normalizer::FORM_KC) ?: $text;
            // Lingkaran/kotak huruf (Ⓢ, 🅂) tidak terurai NFKC — petakan manual
            $text = preg_replace_callback('/[\x{24B6}-\x{24E9}]/u', function ($m) {
                $cp = mb_ord($m[0]);
                return chr(($cp <= 0x24CF ? $cp - 0x24B6 : $cp - 0x24D0) + 97);
            }, $text);
            $text = preg_replace_callback('/[\x{1F130}-\x{1F149}\x{1F150}-\x{1F169}\x{1F170}-\x{1F189}]/u', function ($m) {
                $cp = mb_ord($m[0]);
                $base = $cp >= 0x1F170 ? 0x1F170 : ($cp >= 0x1F150 ? 0x1F150 : 0x1F130);
                return chr($cp - $base + 97);
            }, $text);
            $decomposed = Normalizer::normalize($text, Normalizer::FORM_D);
            if ($decomposed !== false) {
                $text = preg_replace('/\p{Mn}/u', '', $decomposed);
            }
        }

        $text = mb_strtolower($text);
        // Petakan huruf Kiril/Yunani yang mirip Latin
        $text = strtr($text, [
            'а' => 'a', 'е' => 'e', 'о' => 'o', 'р' => 'p', 'с' => 'c', 'у' => 'y', 'х' => 'x',
            'і' => 'i', 'ј' => 'j', 'ѕ' => 's', 'к' => 'k', 'м' => 'm', 'т' => 't', 'в' => 'b', 'н' => 'h',
            'α' => 'a', 'ο' => 'o', 'ε' => 'e', 'ι' => 'i', 'κ' => 'k', 'ν' => 'v', 'τ' => 't', 'ρ' => 'p',
        ]);

        return $text;
    }

    /**
     * Cari istilah terlarang: di dalam satu kata ("gacorrr", "xgacorx") atau
     * gabungan kata berurutan yang diawali batas kata ("situs slot", "slot gacor").
     * Tidak menyambung potongan kata ("foto gelap" ≠ "togel").
     */
    private function findHardTerm(array $tokens): ?string
    {
        $count = count($tokens);
        foreach ($tokens as $i => $token) {
            foreach (self::HARD_COMPACT as $term) {
                if (str_contains($token, $term)) {
                    return $term;
                }
            }
            $concat = $token;
            for ($j = $i + 1; $j < min($i + 4, $count); $j++) {
                $concat .= $tokens[$j];
                foreach (self::HARD_COMPACT as $term) {
                    if (str_starts_with($concat, $term) && strlen($concat) - strlen($tokens[$j]) < strlen($term)) {
                        return $term;
                    }
                }
            }
        }

        return null;
    }

    /** "s l o t", "g.a.c.o.r", "j-u-d-i" → "slot", "gacor", "judi". */
    private function joinSpacedLetters(string $text): string
    {
        return preg_replace_callback(
            '/(?<![a-z0-9])(?:[a-z0-9][\s\.\-_\*\/\\\\,]+){2,}[a-z0-9](?![a-z0-9])/u',
            fn ($m) => preg_replace('/[^a-z0-9]/', '', $m[0]),
            $text
        );
    }

    /** Satu kata yang mengandung huruf Latin sekaligus Kiril/Yunani = penyamaran. */
    private function hasMixedScript(string $text): bool
    {
        foreach (preg_split('/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY) as $word) {
            if (preg_match('/\p{Latin}/u', $word) && preg_match('/[\p{Cyrillic}\p{Greek}]/u', $word)) {
                return true;
            }
        }

        return false;
    }
}
