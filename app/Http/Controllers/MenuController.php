<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::active()
            ->parents()
            ->with(['children' => function($query) {
                $query->active()->ordered();
            }])
            ->ordered()
            ->get();

        return view('menus.index', compact('menus'));
    }

    public function show($id)
    {
        $menu = Menu::active()->findOrFail($id);
        
        return view('menus.show', compact('menu'));
    }
}
