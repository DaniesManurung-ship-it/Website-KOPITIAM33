<?php
// routes/web.php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\MenuSpesialController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\MenuSpesialController as AdminMenuSpesialController;
use App\Http\Controllers\Admin\PromoController as AdminPromoController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\ReservasiController as AdminReservasiController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\PesananReservasiController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;

// ========== GUEST ROUTES (Customer Frontend - Bisa dilihat semua) ==========
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);

// Customer Menu Routes (Hanya untuk melihat)
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/promo', [PromoController::class, 'index'])->name('promo');
Route::get('/menu-spesial', [MenuSpesialController::class, 'index'])->name('menu-spesial');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

// Static Pages
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/cart', 'cart')->name('cart');

// Halaman Reservasi (hanya view, tanpa aksi)
Route::get('/reservasi', [ReservasiController::class, 'index'])->name('reservasi');

// ========== AUTH ROUTES ==========
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ========== ROUTES YANG MEMERLUKAN LOGIN (Customer yang sudah login) ==========
Route::middleware(['auth'])->group(function () {
    
    // Customer Reservasi (Aksi yang memerlukan login)
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
    Route::get('/reservasi/history', [ReservasiController::class, 'history'])->name('reservasi.history');
    Route::get('/reservasi/{id}/edit', [ReservasiController::class, 'edit'])->name('reservasi.edit');
    Route::put('/reservasi/{id}', [ReservasiController::class, 'update'])->name('reservasi.update');
    Route::delete('/reservasi/{id}', [ReservasiController::class, 'destroy'])->name('reservasi.destroy');
    
    // Customer Testimonial (Hanya untuk yang login)
    Route::post('/testimonial/store', [TestimonialController::class, 'store'])->name('testimonial.store');
    Route::get('/testimonial/my', [TestimonialController::class, 'myTestimonials'])->name('testimonial.my');
    Route::delete('/testimonial/{id}', [TestimonialController::class, 'destroy'])->name('testimonial.destroy');
    
    // Customer Order (Hanya untuk yang login)
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/history', [OrderController::class, 'history'])->name('orders.history');
    Route::patch('/order/{id}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
    
    // Testimonial Routes untuk user yang login
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::delete('/testimonials/{id}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
});

// ========== TESTIMONIAL PUBLIC ROUTES (Bisa diakses semua orang) ==========
// Halaman testimonial untuk public (guest dan customer bisa lihat)
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');

// API endpoint untuk mengambil testimonial terbaru (tanpa auth, untuk dropdown widget)
Route::get('/testimonials/latest', function() {
    return App\Models\Testimonial::where('is_approved', true)
        ->where('is_archived', false)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
})->name('testimonials.latest');

// ========== ADMIN ROUTES (Protected - Hanya admin yang login) ==========
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Menu Management
    Route::resource('menu', AdminMenuController::class);
    Route::patch('menu/{id}/toggle-available', [AdminMenuController::class, 'toggleAvailable'])->name('menu.toggle');
    
    // Menu Spesial Management
    Route::get('/menu-spesial', [AdminMenuSpesialController::class, 'index'])->name('menu-spesial');
    Route::post('/menu-spesial', [AdminMenuSpesialController::class, 'store'])->name('menu-spesial.store');
    Route::get('/menu-spesial/{id}/edit', [AdminMenuSpesialController::class, 'edit'])->name('menu-spesial.edit');
    Route::put('/menu-spesial/{id}', [AdminMenuSpesialController::class, 'update'])->name('menu-spesial.update');
    Route::delete('/menu-spesial/{id}', [AdminMenuSpesialController::class, 'destroy'])->name('menu-spesial.destroy');
    Route::patch('/menu-spesial/{id}/toggle-featured', [AdminMenuSpesialController::class, 'toggleFeatured'])->name('menu-spesial.toggle-featured');
    Route::patch('/menu-spesial/{id}/toggle-status', [AdminMenuSpesialController::class, 'toggleStatus'])->name('menu-spesial.toggle-status');
    
    // Promo Management
    Route::get('/promo', [AdminPromoController::class, 'index'])->name('promo');
    Route::post('/promo', [AdminPromoController::class, 'store'])->name('promo.store');
    Route::get('/promo/{id}/edit', [AdminPromoController::class, 'edit'])->name('promo.edit');
    Route::put('/promo/{id}', [AdminPromoController::class, 'update'])->name('promo.update');
    Route::delete('/promo/{id}', [AdminPromoController::class, 'destroy'])->name('promo.destroy');
    Route::patch('/promo/{id}/toggle', [AdminPromoController::class, 'toggleStatus'])->name('promo.toggle');
    
    // Gallery Management
    Route::get('/gallery', [AdminGalleryController::class, 'index'])->name('gallery');
    Route::post('/gallery', [AdminGalleryController::class, 'store'])->name('gallery.store');
    Route::delete('/gallery/{id}', [AdminGalleryController::class, 'destroy'])->name('gallery.destroy');
    Route::get('/gallery/{id}/edit', [AdminGalleryController::class, 'edit'])->name('gallery.edit');
    Route::put('/gallery/{id}', [AdminGalleryController::class, 'update'])->name('gallery.update');
    
    // Reservasi Management
    Route::get('/reservasi', [AdminReservasiController::class, 'index'])->name('reservasi');
    Route::patch('/reservasi/{id}/status', [AdminReservasiController::class, 'updateStatus'])->name('reservasi.status');
    Route::delete('/reservasi/{id}', [AdminReservasiController::class, 'destroy'])->name('reservasi.destroy');
    Route::patch('/reservasi/{id}/restore', [AdminReservasiController::class, 'restore'])->name('reservasi.restore');
    Route::post('/reservasi/bulk', [AdminReservasiController::class, 'bulkAction'])->name('reservasi.bulk');
    
    // Pesanan Management (Order)
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan');
    Route::patch('/pesanan/{id}/status', [PesananController::class, 'updateStatus'])->name('pesanan.status');
    Route::delete('/pesanan/{id}', [PesananController::class, 'destroy'])->name('pesanan.destroy');
    Route::patch('/pesanan/{id}/restore', [PesananController::class, 'restore'])->name('pesanan.restore');
    
    // Pesanan Reservasi
    Route::get('/pesanan-reservasi', [PesananReservasiController::class, 'index'])->name('pesanan-reservasi');
    
    // Testimonial Management (Admin)
    Route::get('/testimonial', [AdminTestimonialController::class, 'index'])->name('testimonial');
    Route::patch('/testimonial/{id}/status', [AdminTestimonialController::class, 'updateStatus'])->name('testimonial.status');
    Route::delete('/testimonial/{id}', [AdminTestimonialController::class, 'destroy'])->name('testimonial.destroy');
    Route::patch('/testimonial/{id}/archive', [AdminTestimonialController::class, 'archive'])->name('testimonial.archive');
});