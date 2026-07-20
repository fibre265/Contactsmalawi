<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaidProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboordControler; // Corrected controller class name spelling
use App\Http\Controllers\DonationController;
use Illuminate\Support\Facades\Route;
use App\Models\Region;
use App\Models\District;
use App\Models\User;
use App\Http\Controllers\StoryController;
use App\Models\Category;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\AdminBroadcastController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactVerificationController;
use App\Http\Controllers\BulkImportController;

Route::get('/admin/import', [BulkImportController::class, 'index'])->name('admin.import.index');
Route::post('/admin/import', [BulkImportController::class, 'upload'])->name('admin.import.upload');

Route::post('/contacts/{id}/verify', [ContactVerificationController::class, 'submitVote'])->name('contacts.verify');

// Public routes for anonymous users
Route::get('/', [HomeController::class, 'home'])->name('home.show');
Route::get('/about', [AboutController::class, 'index'])->name('about');



Route::get('/stories', [StoryController::class, 'index'])->name('stories.index'); // View stories
Route::post('/stories', [StoryController::class, 'store'])->name('stories.store'); // Submit a story

Route::post('/newsletter/subscribe', [SubscriberController::class, 'subscribe'])->name('newsletter.subscribe');

// Donation routes
Route::get('/donate', [DonationController::class, 'showForm'])->name('donate.form');
Route::post('/donate/initialize', [DonationController::class, 'initializePayment'])->name('donate.initialize');
Route::get('/donate/callback', [DonationController::class, 'callback'])->name('donate.callback');

// Search & Profile exploration
Route::get('/search_category/{id}', [SearchController::class, 'searchByCategory'])->name('search.category');
Route::get('/allCategories', [CategoryController::class, 'allCategories'])->name('search.allcategories');
Route::get('/search_region/{id}', [ProfileController::class, 'search_in_region'])->name('users.region');
Route::get('/search_in_district/{id}', [ProfileController::class, 'search_in_district'])->name('users.district');
Route::get('/user/{user}', [ProfileController::class, 'show'])->name('users.show');

// Paid profiles exploration
Route::get('/paid', [PaidProfileController::class, 'show'])->name('users.paid');
Route::get('/search_in_district_paid/{id}', [PaidProfileController::class, 'search_in_district_paid'])->name('users.district');

// Authenticated & Verified Routes
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Admin & Dashboard Core
    Route::get('/dashboard', [DashboordControler::class, 'dashboard'])->name('dashboard');
    
    // User Management Control
    Route::get('/users/{id}/edit', [DashboordControler::class, 'edit'])->name('users.edit');
    Route::post('users/{id}', [DashboordControler::class, 'tikonzecontrollermethod'])->name('tikonzeroutename');
    Route::post('/users/{id}/approve', [DashboordControler::class, 'toggleApproval'])->name('profile.approve');
    Route::delete('/users/{id}', [DashboordControler::class, 'destroyUser'])->name('users.destroy');

    // Save Dynamic About Settings From Dashboard Form
    Route::post('/admin/settings/update', [DashboordControler::class, 'updateSettings'])->name('admin.settings.update');

    // Admin Broadcast System
    Route::get('/admin/broadcast', [DashboordControler::class, 'showBroadcastingForm'])->name('admin.broadcast.form'); 
    Route::post('/admin/broadcast/send', [DashboordControler::class, 'sendBroadcast'])->name('admin.broadcast.send');

    // Categories Management
    Route::get('/categories', [CategoryController::class, 'categories'])->name('categories');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/categories/{id}', [CategoryController::class, 'delete'])->name('categories.destroy');
    Route::patch('/categories/{id}/approve', [CategoryController::class, 'approve'])->name('categories.approve');
    Route::post('/categories/{id}/like', [CategoryController::class, 'like'])->name('categories.like');
    Route::get('/pendingCategories', [CategoryController::class, 'pendingCategories'])->name('categories.pendingCategories');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');

    // Admin Stories Management Routes
    Route::get('/admin/stories-data', [StoryController::class, 'getStoriesData'])->name('admin.stories.data');
    Route::get('/admin/stories/{id}/edit', [StoryController::class, 'edit'])->name('admin.stories.edit');
    Route::put('/admin/stories/{id}', [StoryController::class, 'update'])->name('admin.stories.update');
    Route::post('/admin/stories/{id}/approve', [StoryController::class, 'approve'])->name('admin.stories.approve');
    Route::delete('/admin/stories/{id}', [StoryController::class, 'destroy'])->name('admin.stories.destroy');
});

// Profile management for normal users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/submit_searches', [SearchController::class, 'index'])->name('submit_searches');

require __DIR__.'/auth.php';