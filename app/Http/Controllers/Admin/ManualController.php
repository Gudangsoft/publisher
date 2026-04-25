<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManualController extends Controller
{
    /**
     * Display the manual ebook page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.manual.index');
    }
}
