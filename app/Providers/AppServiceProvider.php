<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Formulir ulasan publik: per IP maks. 10 percobaan/jam & 20/hari,
        // dan batas global 20/menit agar serangan massal tidak membanjiri antrean moderasi.
        RateLimiter::for('review-submit', function (Request $request) {
            $tooMany = fn () => redirect()->to(route('reviews.index') . '#form-ulasan')->withInput($request->except(['captcha', '_ft']))->withErrors([
                'review_text' => 'Terlalu banyak pengiriman. Silakan coba lagi nanti.',
            ]);

            return [
                Limit::perHour(10)->by('review-h:' . $request->ip())->response($tooMany),
                Limit::perDay(20)->by('review-d:' . $request->ip())->response($tooMany),
                Limit::perMinute(20)->by('review-global')->response($tooMany),
            ];
        });

        RateLimiter::for('review-captcha', fn (Request $request) => Limit::perMinute(20)->by($request->ip()));
    }
}
