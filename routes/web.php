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
use App\Http\Controllers\MenuSpesialController;
use App\Http\Controllers\CartController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\MenuSpesialController as AdminMenuSpesialController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\ReservasiController as AdminReservasiController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;

// ========== GUEST ROUTES (Customer Frontend - Bisa dilihat semua) ==========
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);

// Customer Menu Routes (Hanya untuk melihat)
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu-spesial', [MenuSpesialController::class, 'index'])->name('menu-spesial');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

// Static Pages
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/cart/data', [CartController::class, 'getCart'])->name('cart.get');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');
});

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
    // ========== NOTIFICATION ROUTES ==========
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/unread-count', [App\Http\Controllers\NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/latest', [App\Http\Controllers\NotificationController::class, 'getLatest'])->name('notifications.latest');
    Route::delete('/notifications/{id}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
    
    // Customer Reservasi (Aksi yang memerlukan login)
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
    Route::get('/reservasi/history', [ReservasiController::class, 'history'])->name('reservasi.history');
    Route::get('/reservasi/{id}/edit', [ReservasiController::class, 'edit'])->name('reservasi.edit');
    Route::put('/reservasi/{id}', [ReservasiController::class, 'update'])->name('reservasi.update');
    Route::post('/reservasi/{id}/reply', [ReservasiController::class, 'replyMessage'])->name('reservasi.reply');
    Route::delete('/reservasi/{id}', [ReservasiController::class, 'destroy'])->name('reservasi.destroy');
    
    // Customer Testimonial (Hanya untuk yang login)
    Route::post('/testimonial/store', [TestimonialController::class, 'store'])->name('testimonial.store');
    Route::get('/testimonial/my', [TestimonialController::class, 'myTestimonials'])->name('testimonial.my');
    Route::put('/testimonial/{id}', [TestimonialController::class, 'update'])->name('testimonial.update');
    Route::delete('/testimonial/{id}', [TestimonialController::class, 'destroy'])->name('testimonial.destroy');
    
    // Customer Order (Hanya untuk yang login)
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/history', [OrderController::class, 'history'])->name('orders.history');
    Route::get('/order/{id}/payment', [OrderController::class, 'payment'])->name('order.payment');
    Route::post('/order/{id}/payment', [OrderController::class, 'uploadPayment'])->name('order.payment.upload');
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
    try {
        $testimonials = App\Models\Testimonial::where('is_archived', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $testimonials
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal memuat testimoni',
            'data' => []
        ], 500);
    }
})->name('testimonials.latest');

// ========== ADMIN ROUTES (Protected - Hanya admin yang login) ==========
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifications/counts', [App\Http\Controllers\Admin\AdminNotificationController::class, 'getCounts'])->name('admin.notifications.counts');
    
    // Menu Management
    Route::resource('menu', AdminMenuController::class);
    Route::patch('menu/{id}/toggle-available', [AdminMenuController::class, 'toggleAvailable'])->name('menu.toggle');
    
    // Menu Spesial Management
    Route::get('/menu-spesial', [AdminMenuSpesialController::class, 'index'])->name('menu-spesial');
    Route::patch('/menu-spesial/{id}/toggle-featured', [AdminMenuSpesialController::class, 'toggleFeatured'])->name('menu-spesial.toggle-featured');
    Route::patch('/menu-spesial/{id}/toggle-status', [AdminMenuSpesialController::class, 'toggleStatus'])->name('menu-spesial.toggle-status');
    
    // Popup Promo Management
    Route::get('/popup-promo', [\App\Http\Controllers\Admin\PopupPromoController::class, 'index'])->name('popup-promo');
    Route::post('/popup-promo', [\App\Http\Controllers\Admin\PopupPromoController::class, 'store'])->name('popup-promo.store');
    Route::put('/popup-promo/{id}', [\App\Http\Controllers\Admin\PopupPromoController::class, 'update'])->name('popup-promo.update');
    Route::delete('/popup-promo/{id}', [\App\Http\Controllers\Admin\PopupPromoController::class, 'destroy'])->name('popup-promo.destroy');
    Route::patch('/popup-promo/{id}/toggle', [\App\Http\Controllers\Admin\PopupPromoController::class, 'toggleStatus'])->name('popup-promo.toggle');
    
    // Gallery Management
    Route::get('/gallery', [AdminGalleryController::class, 'index'])->name('gallery');
    Route::post('/gallery', [AdminGalleryController::class, 'store'])->name('gallery.store');
    Route::delete('/gallery/{id}', [AdminGalleryController::class, 'destroy'])->name('gallery.destroy');
    Route::get('/gallery/{id}/edit', [AdminGalleryController::class, 'edit'])->name('gallery.edit');
    Route::put('/gallery/{id}', [AdminGalleryController::class, 'update'])->name('gallery.update');
    
    // Reservasi Management
    Route::get('/reservasi', [AdminReservasiController::class, 'index'])->name('reservasi');
    Route::patch('/reservasi/{id}/status', [AdminReservasiController::class, 'updateStatus'])->name('reservasi.status');
    Route::post('/reservasi/{id}/message', [AdminReservasiController::class, 'sendMessage'])->name('reservasi.message');
    Route::delete('/reservasi/{id}', [AdminReservasiController::class, 'destroy'])->name('reservasi.destroy');
    Route::patch('/reservasi/{id}/restore', [AdminReservasiController::class, 'restore'])->name('reservasi.restore');
    Route::post('/reservasi/bulk', [AdminReservasiController::class, 'bulkAction'])->name('reservasi.bulk');
    Route::get('/reservasi/{id}/edit', [AdminReservasiController::class, 'edit'])->name('admin.reservasi.edit');
    Route::put('/reservasi/{id}', [AdminReservasiController::class, 'update'])->name('admin.reservasi.update');
    Route::get('/reservasi/export', [AdminReservasiController::class, 'export'])->name('admin.reservasi.export');
    // Pesanan Management (Order)
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan');
    Route::patch('/pesanan/{id}/status', [PesananController::class, 'updateStatus'])->name('pesanan.status');
    Route::patch('/pesanan/{id}/confirm-payment', [PesananController::class, 'confirmPayment'])->name('pesanan.confirm-payment');
    Route::delete('/pesanan/{id}', [PesananController::class, 'destroy'])->name('pesanan.destroy');
    Route::patch('/pesanan/{id}/restore', [PesananController::class, 'restore'])->name('pesanan.restore');
    
    // Testimonial Management (Admin)
    Route::get('/testimonial', [AdminTestimonialController::class, 'index'])->name('testimonial');
    Route::delete('/testimonial/{id}', [AdminTestimonialController::class, 'destroy'])->name('testimonial.destroy');
    Route::patch('/testimonial/{id}/archive', [AdminTestimonialController::class, 'archive'])->name('testimonial.archive');
    Route::patch('/testimonial/{id}/restore', [AdminTestimonialController::class, 'archive'])->name('testimonial.restore');
});