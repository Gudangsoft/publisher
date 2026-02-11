<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\JournalController;
use App\Http\Controllers\Admin\HeroSliderController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\MenuController as PublicMenuController;

// Public Routes
Route::get('/', function () {
    $heroSliders = \App\Models\HeroSlider::where('is_active', true)
        ->orderBy('display_order', 'asc')
        ->get();
    
    $statistics = \App\Models\Statistic::where('is_active', true)
        ->orderBy('display_order', 'asc')
        ->get();
    
    $latestNews = \App\Models\News::with('category')
        ->whereNotNull('published_at')
        ->orderBy('published_at', 'desc')
        ->take(3)
        ->get();
    
    $featuredBooks = \App\Models\Book::with('category')
        ->latest()
        ->take(4)
        ->get();
    
    $featuredJournals = \App\Models\Journal::with('category')
        ->where('is_published', true)
        ->latest('publication_date')
        ->take(3)
        ->get();
    
    return view('home', compact('heroSliders', 'statistics', 'latestNews', 'featuredBooks', 'featuredJournals'));
})->name('home');

// Books Routes
Route::get('/books', function () {
    $query = \App\Models\Book::with('category');
    
    // Filter by category if provided
    if (request('category')) {
        $query->where('category_id', request('category'));
    }
    
    // Search if provided
    if (request('search')) {
        $search = request('search');
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('author', 'like', '%' . $search . '%')
              ->orWhere('isbn', 'like', '%' . $search . '%');
        });
    }
    
    $books = $query->paginate(20);
    return view('books.index', compact('books'));
})->name('books.index');

Route::get('/books/{book}', function (\App\Models\Book $book) {
    $book->load('category');
    return view('books.show', compact('book'));
})->name('books.show');

// News Routes
Route::get('/news', function () {
    $query = \App\Models\News::with('category')->whereNotNull('published_at');
    
    // Filter by category if provided
    if (request('category')) {
        $query->where('category_id', request('category'));
    }
    
    // Search if provided
    if (request('search')) {
        $search = request('search');
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('summary', 'like', '%' . $search . '%')
              ->orWhere('content', 'like', '%' . $search . '%');
        });
    }
    
    $newsItems = $query->orderBy('published_at', 'desc')->paginate(12);
    return view('news.index', compact('newsItems'));
})->name('news.index');

Route::get('/news/{news}', function (\App\Models\News $news) {
    $news->load('category');
    return view('news.show', compact('news'));
})->name('news.show');

// Journals Routes
Route::get('/journals', function () {
    $query = \App\Models\Journal::with('category')->where('is_published', true);
    
    // Filter by category if provided
    if (request('category')) {
        $query->where('category_id', request('category'));
    }
    
    // Search if provided
    if (request('search')) {
        $search = request('search');
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('abstract', 'like', '%' . $search . '%')
              ->orWhere('authors', 'like', '%' . $search . '%')
              ->orWhere('keywords', 'like', '%' . $search . '%');
        });
    }
    
    $journals = $query->latest('publication_date')->paginate(12);
    return view('journals.index', compact('journals'));
})->name('journals.index');

Route::get('/journals/{journal}', function (\App\Models\Journal $journal) {
    // Increment view count
    $journal->increment('views');
    $journal->load('category');
    return view('journals.show', compact('journal'));
})->name('journals.show');

Route::post('/journals/{journal}', function (\App\Models\Journal $journal) {
    // Increment download count
    $journal->increment('downloads');
    return response()->json(['success' => true]);
})->name('journals.download');

// Menu Routes
Route::get('/menus', [PublicMenuController::class, 'index'])->name('menus.index');
Route::get('/menus/{menu}', [PublicMenuController::class, 'show'])->name('menus.show');

// Author Routes
Route::get('/authors', function () {
    $query = \App\Models\Author::withCount('books');
    
    // Search if provided
    if (request('search')) {
        $search = request('search');
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('biography', 'like', '%' . $search . '%');
        });
    }
    
    $authors = $query->ordered()->paginate(12);
    return view('authors.index', compact('authors'));
})->name('authors.index');

Route::get('/authors/{author:slug}', function (\App\Models\Author $author) {
    $author->load(['books.category']);
    return view('authors.show', compact('author'));
})->name('authors.show');

// Page Routes
Route::get('/pages/{page:slug}', function (\App\Models\Page $page) {
    if (!$page->is_published) {
        abort(404);
    }
    return view('pages.show', compact('page'));
})->name('pages.show');

// About & Contact Routes
Route::get('/about', function () {
    $page = \App\Models\Page::where('slug', 'about')->published()->first();
    if ($page) {
        return view('pages.show', compact('page'));
    }
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', function () {
    return redirect()->back()->with('success', 'Terima kasih! Pesan Anda telah terkirim. Kami akan menghubungi Anda segera.');
})->name('contact.submit');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes (simple admin check is implemented in controllers)
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', function () { return view('admin.dashboard'); })->name('admin.dashboard');

    Route::resource('books', BookController::class, ['as' => 'admin']);
    Route::resource('news', NewsController::class, ['as' => 'admin']);
    Route::resource('journals', JournalController::class, ['as' => 'admin']);
    Route::resource('categories', CategoryController::class, ['as' => 'admin']);
    Route::post('categories/quick-store', [CategoryController::class, 'storeQuick'])->name('admin.categories.quick-store');
    Route::resource('hero-sliders', HeroSliderController::class, ['as' => 'admin']);
    Route::resource('statistics', StatisticController::class, ['as' => 'admin']);
    Route::resource('menus', MenuController::class, ['as' => 'admin']);
    Route::resource('pages', AdminPageController::class, ['as' => 'admin']);
    Route::resource('authors', AuthorController::class, ['as' => 'admin']);
    Route::resource('reviews', ReviewController::class, ['as' => 'admin']);
    Route::resource('users', UserController::class, ['as' => 'admin']);
    Route::resource('orders', OrderController::class, ['as' => 'admin'])->only(['index', 'show', 'update', 'destroy']);
    Route::get('settings', [SettingsController::class, 'index'])->name('admin.settings.index');
    Route::post('settings', [SettingsController::class, 'update'])->name('admin.settings.update');
    Route::get('reports', [ReportController::class, 'index'])->name('admin.reports.index');
});
