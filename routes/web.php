<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

// Authentication routes (provided by Laravel UI)
Auth::routes(['verify' => true]);

// Protected routes (require authentication)
Route::middleware(['auth', 'verified'])->group(function () {
    // User profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create/{service}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::delete('/bookings/{booking}', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // User management
    Route::resource('users', UserManagementController::class);

    // Categories management
    Route::resource('categories', AdminCategoryController::class);

    // Services management
    Route::resource('services', ServiceController::class)->except(['show']);

    // Bookings management
    Route::get('/bookings', [BookingController::class, 'adminIndex'])->name('bookings.index');
    Route::put('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.status');
});

// Redirect root
Route::get('/', [UserDashboardController::class, 'index'])->name('user.dashboard');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// User Only
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/bookings', [App\Http\Controllers\BookingController::class, 'myBookings'])->name('user.bookings');
});


// Layanan dan kategori (public dan authenticated)
Route::get('/services/filter', [ServiceController::class, 'filter'])->name('services.filter');
Route::resource('services', ServiceController::class);
Route::resource('categories', CategoryController::class)->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/bookings/create/{service}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
});

Route::delete('/bookings/{booking}', [App\Http\Controllers\BookingController::class, 'destroy'])
    ->middleware('auth')
    ->name('bookings.destroy');

