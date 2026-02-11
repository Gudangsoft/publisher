<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSliderController extends Controller
{
    public function index()
    {
        $sliders = HeroSlider::orderBy('display_order', 'asc')->get();
        return view('admin.hero-sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.hero-sliders.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('hero-sliders', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['display_order'] = $request->display_order ?? 0;

        HeroSlider::create($validated);

        return redirect()->route('admin.hero-sliders.index')
            ->with('success', 'Hero slider berhasil ditambahkan.');
    }

    public function edit(HeroSlider $heroSlider)
    {
        return view('admin.hero-sliders.form', compact('heroSlider'));
    }

    public function update(Request $request, HeroSlider $heroSlider)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($heroSlider->image) {
                Storage::disk('public')->delete($heroSlider->image);
            }
            $validated['image'] = $request->file('image')->store('hero-sliders', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['display_order'] = $request->display_order ?? $heroSlider->display_order;

        $heroSlider->update($validated);

        return redirect()->route('admin.hero-sliders.index')
            ->with('success', 'Hero slider berhasil diupdate.');
    }

    public function destroy(HeroSlider $heroSlider)
    {
        if ($heroSlider->image) {
            Storage::disk('public')->delete($heroSlider->image);
        }

        $heroSlider->delete();

        return redirect()->route('admin.hero-sliders.index')
            ->with('success', 'Hero slider berhasil dihapus.');
    }
}
