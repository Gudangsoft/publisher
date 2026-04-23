<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('parent', 'children')->whereNull('parent_id')->orderBy('display_order', 'asc')->get();
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $parentMenus = Menu::whereNull('parent_id')->orderBy('display_order')->get();
        return view('admin.menus.form', compact('parentMenus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'icon' => 'nullable|string|max:255',
            'target' => 'required|in:_self,_blank',
            'display_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'location' => 'required|in:header,footer,both',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['display_order'] = $request->display_order ?? 0;

        Menu::create($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        $parentMenus = Menu::whereNull('parent_id')->where('id', '!=', $menu->id)->orderBy('display_order')->get();
        return view('admin.menus.form', compact('menu', 'parentMenus'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'icon' => 'nullable|string|max:255',
            'target' => 'required|in:_self,_blank',
            'display_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'location' => 'required|in:header,footer,both',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['display_order'] = $request->display_order ?? $menu->display_order;

        $menu->update($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil diupdate!');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil dihapus!');
    }
}
