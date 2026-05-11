<?php

use App\Http\Controllers\AboutsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CarouselsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentCategoriesController;
use App\Http\Controllers\DocumentLandingpageController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\LandingpageController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostCategoriesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLandingpageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkProgramController;
use App\Models\Service;
use Illuminate\Support\Facades\Route;

// Route Landingpage
Route::get('/', [LandingpageController::class, 'index']);

// Posts Landingpage
Route::get('/all-posts', [PostLandingpageController::class, 'posts'])->name('post.all');
Route::get('/all-post-categories', [PostLandingpageController::class, 'categoryPostAll'])->name('post.allCategory');
Route::get('/category/{slug}', [PostLandingpageController::class, 'category'])->name('posts.category');
Route::get('/post/{slug}', [PostLandingpageController::class, 'show'])->name('post.show');
Route::get('/posts/author/{author:name}', [PostLandingpageController::class, 'byAuthor'])->name('posts.byAuthor');
Route::get('/posts/category/{category:slug}', [PostLandingpageController::class, 'byCategory'])->name('posts.byCategory');
Route::get('/posts/suggestions/{slug?}', [PostLandingpageController::class, 'postSuggestions'])
    ->name('post.suggestions');
// posts landingpage end

// message route
Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
// message end

// Route Document
Route::get('/all-document', [DocumentLandingpageController::class, 'documents'])->name('document.all');
Route::get('/all-document-categories', [DocumentLandingpageController::class, 'categoryDocumentAll'])->name('document.allCategory');
Route::get('/document-category/{slug}', [DocumentLandingpageController::class, 'documentCategory'])->name('document.category');
Route::get('/documents/suggestions/{slug?}', [DocumentLandingpageController::class, 'documentSuggestions'])
    ->name('document.suggestions');
// End Route Document

Route::get('/abouts', [LandingpageController::class, 'abouts'])->name('about.landingpage.index');
Route::get('/visi-misi', [LandingpageController::class, 'visiMisi'])->name('about.landingpage.visi-misi');
Route::get('/teams', [LandingpageController::class, 'teams'])->name('organizational-structure.index');

// Document Download 

Route::get('/documents/download/{id}', [DocumentLandingpageController::class, 'download'])
    ->name('documents.download');

Route::post('/documents/verify-password', [DocumentLandingpageController::class, 'verifyPassword'])
    ->name('documents.verifyPassword');

Route::get('documents/download-verified', [DocumentLandingpageController::class, 'downloadVerified'])
    ->name('documents.downloadVerified');

// Route Timeline Work Programs
Route::get('/program-kerja', [LandingpageController::class, 'timeline'])->name('work-programs.timeline');
// Route Timeline Work Programs End 

// route service
Route::get('/service', function () {
    $services = Service::latest()->get();
    $title = 'Semua Layanan';

    return view('landingpage.semua-service', compact('services', 'title'));
});
// route service end

Route::fallback(function () {
    abort(404);
});



// Auth Routes
Route::get('/login', [AuthController::class, 'index']);
Route::post('/authenticate', [AuthController::class, 'authenticate'])->middleware('single.session');
Route::get('/heartbeat', function () {
    return response()->json(['status' => 'alive']);
})->middleware('auth');



Route::middleware(['admin.auth'])->group(function () {

    Route::middleware(['role.access:superadmin'])->group(function () {

        // User Management Routes
        Route::resource('users-management', UserController::class)
            ->parameters(['users-management' => 'user']);

        // User Management Routes End


        // Carousels Management Routes
        Route::post('/carousels-management/reorder', [CarouselsController::class, 'reorder'])
            ->name('carousels-management.reorder');
        Route::resource('carousels-management', CarouselsController::class)
            ->parameters(['carousels-management' => 'carousels']);
        // Carousels Management Routes End


        // DocumentsCategory Management Routes
        Route::resource('documents-categories', DocumentCategoriesController::class)
            ->parameters(['documents-categories' => 'documentCategories']);
        Route::post('documents-categories/reorder', [DocumentCategoriesController::class, 'updateOrder'])
            ->name('documents-categories.reorder');
        // DocumentsCategory Management Routes End


        // Post-Categories Management Routes
        Route::resource('posts-categories', PostCategoriesController::class)
            ->parameters(['posts-categories' => 'postCategories']);
        Route::post('posts-categories/reorder', [PostCategoriesController::class, 'updateOrder'])
            ->name('posts-categories.reorder');
        // Post-Categories Management Routes End


        // About Settings Routes
        Route::get('/about-settings', [AboutsController::class, 'index'])->name('about.index');
        Route::put('/about-update/{id}', [AboutsController::class, 'update'])->name('about.update');
        // About Settings Routes End


        // Service Routes
        Route::resource('/services', ServiceController::class)
            ->parameters(['/services' => 'service']);
        // Service Routes End

        // Members Routes
        Route::resource('/members', MemberController::class)
            ->parameters(['/members' => 'member']);
        Route::post('members/reorder', [MemberController::class, 'updateOrder'])
            ->name('members.reorder');
        // Members Routes End

        // Route Menu Navbar
        Route::get('/menu-setting', [MenuController::class, 'index'])->name('menu.index');
        Route::get('/menu/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit');
        Route::put('/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
        //Route Menu Navbar End 

        // Banner Route 
        Route::get('/banner-setting', [BannerController::class, 'index'])->name('banner.index');
        Route::get('/banner/{id}/edit', [BannerController::class, 'edit'])->name('banner.edit');
        Route::post('/banner/{id}', [BannerController::class, 'update'])->name('banner.update');
        // Banner Route End

    });

    // Work Program Route
    Route::resource('/work-programs', WorkProgramController::class)
        ->parameters(['/work-programs' => 'workProgram']);
    // Work Program Route end

    Route::get('/messages', [MessageController::class, 'index'])->name('admin.messages.index');
    Route::get('/messages/{id}', [MessageController::class, 'show'])->name('admin.messages.show');
    Route::delete('/messagesDelete/{id}', [MessageController::class, 'deleteMessage'])->name('admin.messages.delete');
    Route::delete('/messagesDeleteAll', [MessageController::class, 'deleteAll'])->name('admin.messages.deleteAll');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/logout', [AuthController::class, 'logout']);
    // Auth Routes End

    // Documents Management Routes
    Route::resource('documents-management', DocumentsController::class)
        ->parameters(['documents-management' => 'documents']);
    // Documents Management Routes End

    // Post Management Routes
    Route::resource('posts-management', PostController::class)
        ->parameters(['posts-management' => 'posts']);
    // Post Management Routes End


    // Route edit Profile

    Route::get('/profile', [UserController::class, 'profile'])->name('profile.index');
    Route::put('/profile/{id}', [UserController::class, 'updateProfile'])->name('profile.update');
    // Route edit Profile end

});
