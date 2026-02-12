<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ThemeController extends Controller
{
    // Predefined color presets
    private $colorPresets = [
        'orange' => [
            'name' => 'Orange (Default)',
            'primary' => '#ee6d26',
            'shades' => [
                50 => '#fef6ee', 100 => '#fdebd8', 200 => '#fad4b0', 300 => '#f6b67d',
                400 => '#f18d49', 500 => '#ee6d26', 600 => '#df521c', 700 => '#b93d19',
                800 => '#93321d', 900 => '#762b19',
            ],
        ],
        'blue' => [
            'name' => 'Biru',
            'primary' => '#3b82f6',
            'shades' => [
                50 => '#eff6ff', 100 => '#dbeafe', 200 => '#bfdbfe', 300 => '#93c5fd',
                400 => '#60a5fa', 500 => '#3b82f6', 600 => '#2563eb', 700 => '#1d4ed8',
                800 => '#1e40af', 900 => '#1e3a8a',
            ],
        ],
        'green' => [
            'name' => 'Hijau',
            'primary' => '#22c55e',
            'shades' => [
                50 => '#f0fdf4', 100 => '#dcfce7', 200 => '#bbf7d0', 300 => '#86efac',
                400 => '#4ade80', 500 => '#22c55e', 600 => '#16a34a', 700 => '#15803d',
                800 => '#166534', 900 => '#14532d',
            ],
        ],
        'red' => [
            'name' => 'Merah',
            'primary' => '#ef4444',
            'shades' => [
                50 => '#fef2f2', 100 => '#fee2e2', 200 => '#fecaca', 300 => '#fca5a5',
                400 => '#f87171', 500 => '#ef4444', 600 => '#dc2626', 700 => '#b91c1c',
                800 => '#991b1b', 900 => '#7f1d1d',
            ],
        ],
        'purple' => [
            'name' => 'Ungu',
            'primary' => '#a855f7',
            'shades' => [
                50 => '#faf5ff', 100 => '#f3e8ff', 200 => '#e9d5ff', 300 => '#d8b4fe',
                400 => '#c084fc', 500 => '#a855f7', 600 => '#9333ea', 700 => '#7e22ce',
                800 => '#6b21a8', 900 => '#581c87',
            ],
        ],
        'teal' => [
            'name' => 'Teal',
            'primary' => '#14b8a6',
            'shades' => [
                50 => '#f0fdfa', 100 => '#ccfbf1', 200 => '#99f6e4', 300 => '#5eead4',
                400 => '#2dd4bf', 500 => '#14b8a6', 600 => '#0d9488', 700 => '#0f766e',
                800 => '#115e59', 900 => '#134e4a',
            ],
        ],
        'indigo' => [
            'name' => 'Indigo',
            'primary' => '#6366f1',
            'shades' => [
                50 => '#eef2ff', 100 => '#e0e7ff', 200 => '#c7d2fe', 300 => '#a5b4fc',
                400 => '#818cf8', 500 => '#6366f1', 600 => '#4f46e5', 700 => '#4338ca',
                800 => '#3730a3', 900 => '#312e81',
            ],
        ],
        'rose' => [
            'name' => 'Rose',
            'primary' => '#f43f5e',
            'shades' => [
                50 => '#fff1f2', 100 => '#ffe4e6', 200 => '#fecdd3', 300 => '#fda4af',
                400 => '#fb7185', 500 => '#f43f5e', 600 => '#e11d48', 700 => '#be123c',
                800 => '#9f1239', 900 => '#881337',
            ],
        ],
    ];

    // Available font options
    private $fontOptions = [
        'inter' => ['name' => 'Inter', 'family' => 'Inter', 'url' => 'Inter:wght@300;400;500;600;700;800'],
        'poppins' => ['name' => 'Poppins', 'family' => 'Poppins', 'url' => 'Poppins:wght@300;400;500;600;700;800'],
        'roboto' => ['name' => 'Roboto', 'family' => 'Roboto', 'url' => 'Roboto:wght@300;400;500;700;900'],
        'nunito' => ['name' => 'Nunito', 'family' => 'Nunito', 'url' => 'Nunito:wght@300;400;500;600;700;800'],
        'lato' => ['name' => 'Lato', 'family' => 'Lato', 'url' => 'Lato:wght@300;400;700;900'],
        'opensans' => ['name' => 'Open Sans', 'family' => 'Open Sans', 'url' => 'Open+Sans:wght@300;400;500;600;700;800'],
        'montserrat' => ['name' => 'Montserrat', 'family' => 'Montserrat', 'url' => 'Montserrat:wght@300;400;500;600;700;800'],
        'sourcesans' => ['name' => 'Source Sans 3', 'family' => 'Source Sans 3', 'url' => 'Source+Sans+3:wght@300;400;500;600;700;800'],
    ];

    // Display font options
    private $displayFontOptions = [
        'playfair' => ['name' => 'Playfair Display', 'family' => 'Playfair Display', 'url' => 'Playfair+Display:wght@700;800;900'],
        'merriweather' => ['name' => 'Merriweather', 'family' => 'Merriweather', 'url' => 'Merriweather:wght@700;900'],
        'lora' => ['name' => 'Lora', 'family' => 'Lora', 'url' => 'Lora:wght@700'],
        'dmserif' => ['name' => 'DM Serif Display', 'family' => 'DM Serif Display', 'url' => 'DM+Serif+Display'],
        'none' => ['name' => 'Sama dengan Body Font', 'family' => '', 'url' => ''],
    ];

    // Layout options
    private $layoutOptions = [
        'default' => 'Default (Full Width)',
        'boxed' => 'Boxed (Terbatas)',
    ];

    public function index()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $settings = [
            'theme_color' => Setting::get('theme_color', 'orange'),
            'theme_font' => Setting::get('theme_font', 'inter'),
            'theme_display_font' => Setting::get('theme_display_font', 'playfair'),
            'theme_layout' => Setting::get('theme_layout', 'default'),
            'theme_navbar_style' => Setting::get('theme_navbar_style', 'light'),
            'theme_footer_style' => Setting::get('theme_footer_style', 'dark'),
            'theme_hero_style' => Setting::get('theme_hero_style', 'slider'),
            'theme_border_radius' => Setting::get('theme_border_radius', 'rounded'),
            'theme_custom_css' => Setting::get('theme_custom_css', ''),
        ];

        return view('admin.theme.index', [
            'settings' => $settings,
            'colorPresets' => $this->colorPresets,
            'fontOptions' => $this->fontOptions,
            'displayFontOptions' => $this->displayFontOptions,
            'layoutOptions' => $this->layoutOptions,
        ]);
    }

    public function update(Request $request)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'theme_color' => 'required|string|in:' . implode(',', array_keys($this->colorPresets)),
            'theme_font' => 'required|string|in:' . implode(',', array_keys($this->fontOptions)),
            'theme_display_font' => 'required|string|in:' . implode(',', array_keys($this->displayFontOptions)),
            'theme_layout' => 'required|string|in:' . implode(',', array_keys($this->layoutOptions)),
            'theme_navbar_style' => 'required|string|in:light,dark,transparent',
            'theme_footer_style' => 'required|string|in:light,dark',
            'theme_hero_style' => 'required|string|in:slider,static,minimal',
            'theme_border_radius' => 'required|string|in:none,rounded,pill',
            'theme_custom_css' => 'nullable|string|max:10000',
        ]);

        $settingsToSave = [
            'theme_color', 'theme_font', 'theme_display_font', 'theme_layout',
            'theme_navbar_style', 'theme_footer_style', 'theme_hero_style',
            'theme_border_radius', 'theme_custom_css',
        ];

        foreach ($settingsToSave as $key) {
            Setting::set($key, $request->input($key, ''), 'text');
        }

        return redirect()->route('admin.theme.index')
            ->with('success', 'Pengaturan tema berhasil diperbarui!');
    }

    /**
     * Get theme config as array (for use in layouts)
     */
    public static function getThemeConfig(): array
    {
        $colorKey = Setting::get('theme_color', 'orange');
        $fontKey = Setting::get('theme_font', 'inter');
        $displayFontKey = Setting::get('theme_display_font', 'playfair');

        $controller = new self();

        $colorPreset = $controller->colorPresets[$colorKey] ?? $controller->colorPresets['orange'];
        $font = $controller->fontOptions[$fontKey] ?? $controller->fontOptions['inter'];
        $displayFont = $controller->displayFontOptions[$displayFontKey] ?? $controller->displayFontOptions['playfair'];

        return [
            'color' => $colorPreset,
            'font' => $font,
            'displayFont' => $displayFont,
            'layout' => Setting::get('theme_layout', 'default'),
            'navbarStyle' => Setting::get('theme_navbar_style', 'light'),
            'footerStyle' => Setting::get('theme_footer_style', 'dark'),
            'heroStyle' => Setting::get('theme_hero_style', 'slider'),
            'borderRadius' => Setting::get('theme_border_radius', 'rounded'),
            'customCss' => Setting::get('theme_custom_css', ''),
        ];
    }
}
