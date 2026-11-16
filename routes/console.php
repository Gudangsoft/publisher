<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Hapus otomatis ulasan spam yang dikarantina > 30 hari (lihat Review::prunable)
\Illuminate\Support\Facades\Schedule::command('model:prune', ['--model' => [\App\Models\Review::class]])->daily();
