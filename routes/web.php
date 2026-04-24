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
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\Admin\SubmissionController as AdminSubmissionController;
use App\Http\Controllers\Admin\BookTemplateController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\GalleryAlbumController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\MenuController as PublicMenuController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\InvoiceController;

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
        ->where('is_featured', true)
        ->latest('publication_date')
        ->take(3)
        ->get();

    // Fallback to latest published if no featured journals exist yet
    if ($featuredJournals->isEmpty()) {
        $featuredJournals = \App\Models\Journal::with('category')
            ->where('is_published', true)
            ->latest('publication_date')
            ->take(3)
            ->get();
    }
    
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
    
    $featuredNews = \App\Models\News::whereNotNull('published_at')->where('is_featured', true)->orderBy('published_at', 'desc')->first() 
        ?? \App\Models\News::whereNotNull('published_at')->orderBy('published_at', 'desc')->first();
    $categories = \App\Models\Category::where('type', 'news')->get();
    
    return view('news.index', compact('newsItems', 'featuredNews', 'categories'));
})->name('news.index');

Route::get('/news/{news}', function (\App\Models\News $news) {
    $news->load('category');
    
    // Get related news (same category, excluding current, max 3)
    $relatedNews = \App\Models\News::with('category')
        ->where('category_id', $news->category_id)
        ->where('id', '!=', $news->id)
        ->whereNotNull('published_at')
        ->latest('published_at')
        ->take(3)
        ->get();
        
    // If not enough related news in the same category, fill with latest news
    if ($relatedNews->count() < 3) {
        $moreNews = \App\Models\News::with('category')
            ->where('id', '!=', $news->id)
            ->whereNotIn('id', $relatedNews->pluck('id'))
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->take(3 - $relatedNews->count())
            ->get();
        $relatedNews = $relatedNews->concat($moreNews);
    }

    $categories = \App\Models\Category::where('type', 'news')->withCount('news')->get();
    
    $popularNews = \App\Models\News::with('category')
        ->where('id', '!=', $news->id)
        ->whereNotNull('published_at')
        ->orderBy('views', 'desc')
        ->latest('published_at')
        ->take(4)
        ->get();
    
    return view('news.show', compact('news', 'relatedNews', 'categories', 'popularNews'));
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

// Submission Routes (Public)
Route::get('/submissions/create', [SubmissionController::class, 'create'])->name('submissions.create');
Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
Route::get('/submissions/success/{submissionNumber}', [SubmissionController::class, 'success'])->name('submissions.success');
Route::get('/submissions/track', [SubmissionController::class, 'track'])->name('submissions.track');
Route::get('/templates/{template}/download', [SubmissionController::class, 'downloadTemplate'])->name('templates.download');

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

// Gallery Route
Route::get('/gallery', function () {
    $query = \App\Models\Gallery::with('album')->active();
    
    if (request('type')) {
        $query->where('type', request('type'));
    }
    
    if (request('album')) {
        $query->where('gallery_album_id', request('album'));
    }
    
    $galleries = $query->ordered()->paginate(12);
    $albums = \App\Models\GalleryAlbum::active()->ordered()
        ->withCount(['galleries' => function($q) {
            $q->where('is_active', true);
        }])
        ->having('galleries_count', '>', 0)
        ->get();
    
    return view('gallery', compact('galleries', 'albums'));
})->name('gallery');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Dashboard routes (for logged-in users)
Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/submissions', [UserDashboardController::class, 'submissions'])->name('submissions');
    Route::get('/submissions/{id}', [UserDashboardController::class, 'showSubmission'])->name('submissions.show');
    Route::post('/submissions/{id}/revise', [UserDashboardController::class, 'reviseSubmission'])->name('submissions.revise');
    Route::get('/orders', [UserDashboardController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [UserDashboardController::class, 'showOrder'])->name('orders.show');
    Route::get('/orders/{id}/invoice', [InvoiceController::class, 'downloadUserInvoice'])->name('orders.invoice');
    Route::get('/orders/{id}/invoice/view', [InvoiceController::class, 'streamInvoice'])->name('orders.invoice.view');
});

// Admin routes (simple admin check is implemented in controllers)
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

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
    Route::post('users/{user}/login-as', [UserController::class, 'loginAs'])->name('admin.users.login-as');
    Route::post('users/switch-back', [UserController::class, 'switchBack'])->name('admin.users.switch-back');
    Route::resource('orders', OrderController::class, ['as' => 'admin'])->only(['index', 'show', 'update', 'destroy']);
    Route::get('orders/{order}/invoice', [InvoiceController::class, 'downloadAdminInvoice'])->name('admin.orders.invoice');
    Route::get('settings', [SettingsController::class, 'index'])->name('admin.settings.index');
    Route::post('settings', [SettingsController::class, 'update'])->name('admin.settings.update');
    Route::get('reports', [ReportController::class, 'index'])->name('admin.reports.index');

    // Export routes
    Route::get('export/orders', [ExportController::class, 'orders'])->name('admin.export.orders');
    Route::get('export/submissions', [ExportController::class, 'submissions'])->name('admin.export.submissions');
    Route::get('export/books', [ExportController::class, 'books'])->name('admin.export.books');
    Route::get('export/users', [ExportController::class, 'users'])->name('admin.export.users');

    // Profile routes
    Route::get('profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('admin.profile.password');

    // Theme routes
    Route::get('theme', [ThemeController::class, 'index'])->name('admin.theme.index');
    Route::put('theme', [ThemeController::class, 'update'])->name('admin.theme.update');

    // Book Template routes
    Route::get('templates', [BookTemplateController::class, 'index'])->name('admin.templates.index');
    Route::get('templates/create', [BookTemplateController::class, 'create'])->name('admin.templates.create');
    Route::post('templates', [BookTemplateController::class, 'store'])->name('admin.templates.store');
    Route::get('templates/{template}', [BookTemplateController::class, 'show'])->name('admin.templates.show');
    Route::get('templates/{template}/edit', [BookTemplateController::class, 'edit'])->name('admin.templates.edit');
    Route::put('templates/{template}', [BookTemplateController::class, 'update'])->name('admin.templates.update');
    Route::delete('templates/{template}', [BookTemplateController::class, 'destroy'])->name('admin.templates.destroy');
    Route::get('templates/{template}/download', [BookTemplateController::class, 'download'])->name('admin.templates.download');
    Route::patch('templates/{template}/toggle', [BookTemplateController::class, 'toggleActive'])->name('admin.templates.toggle');

    // Submission routes
    Route::get('submissions', [AdminSubmissionController::class, 'index'])->name('admin.submissions.index');
    Route::get('submissions/{submission}', [AdminSubmissionController::class, 'show'])->name('admin.submissions.show');
    Route::put('submissions/{submission}', [AdminSubmissionController::class, 'update'])->name('admin.submissions.update');
    Route::delete('submissions/{submission}', [AdminSubmissionController::class, 'destroy'])->name('admin.submissions.destroy');
    Route::get('submissions/{submission}/download/{fileType}', [AdminSubmissionController::class, 'download'])->name('admin.submissions.download');

    // Gallery (Individual photos/videos without specific album UI)
    Route::resource('galleries', GalleryController::class, ['as' => 'admin']);
    Route::patch('galleries/{gallery}/toggle', [GalleryController::class, 'toggleActive'])->name('admin.galleries.toggle');

    // Gallery Album routes (unified gallery management)
    Route::resource('gallery-albums', GalleryAlbumController::class, ['as' => 'admin']);
    Route::patch('gallery-albums/{gallery_album}/toggle', [GalleryAlbumController::class, 'toggleActive'])->name('admin.gallery-albums.toggle');
    Route::post('gallery-albums/{gallery_album}/photos', [GalleryAlbumController::class, 'addPhotos'])->name('admin.gallery-albums.add-photos');
    Route::post('gallery-albums/{gallery_album}/video', [GalleryAlbumController::class, 'addVideo'])->name('admin.gallery-albums.add-video');
    Route::delete('gallery-albums/{gallery_album}/photos/{gallery}', [GalleryAlbumController::class, 'deletePhoto'])->name('admin.gallery-albums.delete-photo');
});
