@extends('layouts.app')

@section('title', 'Ulasan & Penilaian Layanan')
@section('meta_description', 'Ulasan dan penilaian masyarakat terhadap layanan penerbit. Sampaikan pengalaman Anda untuk membantu kami meningkatkan kualitas pelayanan publik.')

@section('content')
@php
    $star = 'M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z';
@endphp

<!-- Header -->
<section class="bg-gradient-to-br from-primary-600 to-primary-800 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-4 py-1.5 bg-white/15 rounded-full text-sm font-semibold mb-4">PENILAIAN PELAYANAN PUBLIK</span>
        <h1 class="text-3xl lg:text-5xl font-display font-bold mb-4">Ulasan &amp; Penilaian Masyarakat</h1>
        <p class="text-lg text-primary-100 max-w-2xl mx-auto">
            Pendapat Anda membantu kami meningkatkan kualitas layanan. Setiap ulasan diverifikasi sebelum ditampilkan.
        </p>
    </div>
</section>

<!-- Ringkasan -->
<section class="py-12 bg-white border-b border-gray-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-8 items-center">
            <div class="text-center">
                <div class="text-6xl font-bold text-gray-900">{{ number_format($average, 1, ',', '.') }}</div>
                <div class="flex justify-center space-x-1 my-2" aria-label="Rata-rata {{ $average }} dari 5 bintang">
                    @for($i = 1; $i <= 5; $i++)
                    <svg class="w-6 h-6 fill-current {{ $i <= round($average) ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 20 20"><path d="{{ $star }}"/></svg>
                    @endfor
                </div>
                <div class="text-gray-600">dari {{ number_format($total, 0, ',', '.') }} ulasan terverifikasi</div>
            </div>

            <div class="space-y-2">
                @for($r = 5; $r >= 1; $r--)
                @php $n = (int) ($distribution[$r] ?? 0); $pct = $total ? round($n / $total * 100) : 0; @endphp
                <div class="flex items-center gap-3 text-sm">
                    <span class="w-14 text-gray-700">{{ $r }} bintang</span>
                    <div class="flex-1 h-2.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-yellow-400 rounded-full" style="width: {{ $pct }}%"></div>
                    </div>
                    <span class="w-8 text-right text-gray-500">{{ $n }}</span>
                </div>
                @endfor
            </div>

            <div class="text-center">
                <div class="text-5xl font-bold text-green-600">{{ number_format($satisfied, 1, ',', '.') }}%</div>
                <div class="text-gray-600 mt-2">responden menyatakan <strong>puas</strong><br><span class="text-xs">(memberi 4–5 bintang)</span></div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-5 gap-10">

        <!-- Formulir -->
        <div class="lg:col-span-2" id="form-ulasan">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 lg:p-8 lg:sticky lg:top-28">
                <h2 class="text-2xl font-bold text-gray-900 mb-1">Kirim Ulasan Anda</h2>
                <p class="text-sm text-gray-600 mb-6">Ulasan akan tampil setelah diverifikasi admin.</p>

                @if(session('review_success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm" role="status">
                    {{ session('review_success') }}
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm" role="alert">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('reviews.store') }}" method="POST" class="space-y-5" autocomplete="off"
                      x-data="{ rating: {{ (int) old('rating', 0) }}, hover: 0, len: {{ mb_strlen((string) old('review_text', '')) }}, sending: false }"
                      @submit="sending = true">
                    @csrf
                    <input type="hidden" name="_ft" value="{{ $formToken }}">

                    {{-- Honeypot: disembunyikan dari manusia, sering diisi bot --}}
                    <div aria-hidden="true" style="position:absolute;left:-10000px;top:auto;width:1px;height:1px;overflow:hidden;">
                        <label for="website">Website</label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off" value="">
                        <label for="fax_number">Fax</label>
                        <input type="text" id="fax_number" name="fax_number" tabindex="-1" autocomplete="off" value="">
                    </div>

                    <!-- Rating -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Penilaian Anda <span class="text-red-500">*</span></label>
                        <div class="flex items-center space-x-1" role="radiogroup" aria-label="Penilaian bintang">
                            @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer" @mouseenter="hover = {{ $i }}" @mouseleave="hover = 0">
                                <input type="radio" name="rating" value="{{ $i }}" class="sr-only" x-model.number="rating" {{ (int) old('rating') === $i ? 'checked' : '' }} required>
                                <svg class="w-9 h-9 fill-current transition-colors" :class="(hover || rating) >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300'" viewBox="0 0 20 20"><path d="{{ $star }}"/></svg>
                                <span class="sr-only">{{ $i }} bintang</span>
                            </label>
                            @endfor
                            <span class="ml-3 text-sm text-gray-600" x-text="['Pilih bintang','Sangat kurang','Kurang','Cukup','Baik','Sangat baik'][hover || rating]"></span>
                        </div>
                    </div>

                    <div>
                        <label for="reviewer_name" class="block text-sm font-semibold text-gray-700 mb-2">Nama <span class="text-red-500">*</span></label>
                        <input type="text" id="reviewer_name" name="reviewer_name" value="{{ old('reviewer_name') }}" required minlength="3" maxlength="60"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>

                    <div>
                        <label for="reviewer_role" class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                        <select id="reviewer_role" name="reviewer_role" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="">Pilih kategori</option>
                            @foreach($roles as $role)
                            <option value="{{ $role }}" @selected(old('reviewer_role') === $role)>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="reviewer_email" class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-gray-400 font-normal">(opsional, tidak ditampilkan)</span></label>
                        <input type="email" id="reviewer_email" name="reviewer_email" value="{{ old('reviewer_email') }}" maxlength="120"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>

                    <div>
                        <label for="review_text" class="block text-sm font-semibold text-gray-700 mb-2">Ulasan <span class="text-red-500">*</span></label>
                        <textarea id="review_text" name="review_text" rows="5" required minlength="20" maxlength="1000"
                                  @input="len = $event.target.value.length"
                                  placeholder="Ceritakan pengalaman Anda dengan layanan kami…"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('review_text') }}</textarea>
                        <div class="flex justify-between text-xs mt-1">
                            <span class="text-gray-500">Tanpa tautan, nomor telepon, atau promosi.</span>
                            <span :class="len < 20 ? 'text-gray-400' : 'text-gray-600'"><span x-text="len"></span>/1000</span>
                        </div>
                    </div>

                    <!-- Verifikasi -->
                    <div>
                        <label for="captcha" class="block text-sm font-semibold text-gray-700 mb-2">Verifikasi keamanan <span class="text-red-500">*</span></label>
                        @if($turnstileKey)
                            <div class="cf-turnstile" data-sitekey="{{ $turnstileKey }}" data-language="id"></div>
                        @else
                            <div class="flex items-center gap-3" x-data="{ v: Date.now() }">
                                <img :src="'{{ route('reviews.captcha') }}?v=' + v" src="{{ route('reviews.captcha') }}" alt="Soal hitungan keamanan" width="170" height="48" class="rounded-lg border border-gray-200">
                                <button type="button" @click="v = Date.now()" class="p-2 text-gray-500 hover:text-primary-600" title="Ganti soal">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                </button>
                                <input type="text" id="captcha" name="captcha" inputmode="numeric" pattern="[0-9]*" maxlength="3" required placeholder="Hasil"
                                       class="w-24 px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            </div>
                        @endif
                    </div>

                    <label class="flex items-start gap-3 text-sm text-gray-600">
                        <input type="checkbox" name="consent" value="1" required @checked(old('consent')) class="mt-0.5 w-4 h-4 text-primary-600 border-gray-300 rounded">
                        <span>Saya menyatakan ulasan ini jujur berdasarkan pengalaman pribadi, dan setuju nama, kategori, serta isi ulasan ditampilkan publik setelah diverifikasi. Email tidak akan dipublikasikan.</span>
                    </label>

                    <button type="submit" :disabled="sending"
                            class="w-full inline-flex justify-center items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 disabled:opacity-60 text-white rounded-lg font-semibold transition-colors">
                        <span x-show="!sending">Kirim Ulasan</span>
                        <span x-show="sending" x-cloak>Mengirim…</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Daftar ulasan -->
        <div class="lg:col-span-3" id="daftar-ulasan">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Ulasan Terverifikasi</h2>

            @forelse($reviews as $review)
            <article class="bg-white p-6 rounded-2xl border border-gray-200 mb-5">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex space-x-1" aria-label="{{ $review->rating }} dari 5 bintang">
                        @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 fill-current {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 20 20"><path d="{{ $star }}"/></svg>
                        @endfor
                    </div>
                    <time class="text-xs text-gray-500" datetime="{{ $review->created_at->toDateString() }}">{{ $review->created_at->translatedFormat('d F Y') }}</time>
                </div>
                <p class="text-gray-700 leading-relaxed mb-4 whitespace-pre-line break-words">{{ $review->review_text }}</p>
                <div class="flex items-center">
                    @if($review->reviewer_photo)
                    <img src="{{ asset('storage/' . $review->reviewer_photo) }}" alt="" class="w-10 h-10 rounded-full mr-3 object-cover">
                    @else
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-bold mr-3">{{ $review->initial }}</div>
                    @endif
                    <div>
                        <div class="font-semibold text-gray-900">{{ $review->reviewer_name }}</div>
                        <div class="text-sm text-primary-600">
                            {{ $review->reviewer_role ?: 'Pembaca' }}@if($review->book) · {{ $review->book->title }}@endif
                        </div>
                    </div>
                </div>
            </article>
            @empty
            <div class="bg-white p-10 rounded-2xl border border-dashed border-gray-300 text-center text-gray-600">
                Belum ada ulasan terverifikasi. Jadilah yang pertama memberikan penilaian!
            </div>
            @endforelse

            <div class="mt-6">{{ $reviews->links() }}</div>
        </div>
    </div>
</section>
@if($turnstileKey)
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
@endif
@endsection
