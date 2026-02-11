<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'site_name' => Setting::get('site_name', 'Publisher'),
            'site_description' => Setting::get('site_description', 'Platform Manajemen Penerbitan'),
            'site_tagline' => Setting::get('site_tagline', 'Your Ultimate Book Destination'),
            'site_logo' => Setting::get('site_logo', ''),
            'site_favicon' => Setting::get('site_favicon', ''),
            'contact_email' => Setting::get('contact_email', ''),
            'contact_phone' => Setting::get('contact_phone', ''),
            'contact_address' => Setting::get('contact_address', ''),
            'whatsapp_number' => Setting::get('whatsapp_number', ''),
            'facebook_url' => Setting::get('facebook_url', ''),
            'twitter_url' => Setting::get('twitter_url', ''),
            'instagram_url' => Setting::get('instagram_url', ''),
            'youtube_url' => Setting::get('youtube_url', ''),
            'linkedin_url' => Setting::get('linkedin_url', ''),
            'meta_keywords' => Setting::get('meta_keywords', ''),
            'meta_description' => Setting::get('meta_description', ''),
            'google_analytics' => Setting::get('google_analytics', ''),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'site_logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site_favicon' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,ico,x-icon|max:1024',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string',
            'whatsapp_number' => 'nullable|string|max:50',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'google_analytics' => 'nullable|string',
        ]);

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            // Delete old logo if exists
            $oldLogo = Setting::get('site_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            // Store new logo
            $logoPath = $request->file('site_logo')->store('settings', 'public');
            Setting::set('site_logo', $logoPath, 'image');
        }

        // Handle favicon upload
        if ($request->hasFile('site_favicon')) {
            // Delete old favicon if exists
            $oldFavicon = Setting::get('site_favicon');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }

            // Store new favicon
            $faviconPath = $request->file('site_favicon')->store('settings', 'public');
            Setting::set('site_favicon', $faviconPath, 'image');
        }

        // Save all settings
        $settingsToSave = [
            'site_name' => 'text',
            'site_tagline' => 'text',
            'site_description' => 'textarea',
            'contact_email' => 'text',
            'contact_phone' => 'text',
            'contact_address' => 'textarea',
            'whatsapp_number' => 'text',
            'facebook_url' => 'text',
            'twitter_url' => 'text',
            'instagram_url' => 'text',
            'youtube_url' => 'text',
            'linkedin_url' => 'text',
            'meta_keywords' => 'textarea',
            'meta_description' => 'textarea',
            'google_analytics' => 'textarea',
        ];

        foreach ($settingsToSave as $key => $type) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key), $type);
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
