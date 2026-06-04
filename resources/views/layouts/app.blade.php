<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Café Kopitiam33') }} - @yield('title')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">
    
    @stack('styles')
</head>
<body>

@unless(Route::is('login', 'register', 'admin.login*', 'admin.register*'))
    @include('layouts.navbar')
@endunless

<!-- Main Content -->
<main class="main-content">
    @yield('content')
</main>

<!-- Testimoni Widget -->
<div x-data="testimoniWidget()" x-init="init()" class="testimoni-widget-wrapper">
    <button @click="toggleDropdown()" class="testimoni-widget-btn">
        <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
        </svg>
        <span x-show="testimonialCount > 0" x-cloak class="testimoni-badge" x-text="testimonialCount"></span>
    </button>
    
    <div x-show="dropdownOpen" x-cloak @click.away="dropdownOpen = false" class="testimoni-widget-dropdown">
        <div class="testimoni-dropdown-header">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-white/20 rounded-full flex items-center justify-center">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                </div>
                <h4>Testimoni Pelanggan</h4>
            </div>
        </div>
        
        <div class="testimoni-dropdown-body">
            <div x-show="testimonials.length > 0" class="testimoni-list">
                <template x-for="testimonial in testimonials" :key="testimonial.id">
                    <div class="testimoni-item">
                        <div class="testimoni-header">
                            <div class="testimoni-user">
                                <div class="user-avatar">
                                    <span x-text="testimonial.name.charAt(0).toUpperCase()"></span>
                                </div>
                                <div class="user-info">
                                    <span class="user-name" x-text="testimonial.name"></span>
                                    <div class="testimoni-rating">
                                        <template x-for="star in 5">
                                            <span class="testimoni-star" :class="{ 'active': star <= testimonial.rating }">★</span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <span class="testimoni-date" x-text="formatDate(testimonial.created_at)"></span>
                        </div>
                        <div class="testimoni-message" x-text="testimonial.message"></div>
                    </div>
                </template>
            </div>
        </div>
        
        <div class="testimoni-dropdown-footer">
            @auth
                <button @click="openModal()" class="btn-give-testimoni">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span>Tulis Testimoni</span>
                </button>
            @else
                <a href="{{ route('login') }}" class="btn-give-testimoni">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Login untuk Testimoni</span>
                </a>
            @endauth
            
            <a href="{{ route('testimonials.index') }}" class="btn-view-all">
                <span>Lihat Semua Testimoni</span>
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</div>

<!-- Testimonial Modal -->
<div id="testimonialModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header">
            <div class="modal-title">
                <div class="modal-title-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h3>Beri Testimoni</h3>
            </div>
            <button onclick="closeTestimonialModal()" class="modal-close">&times;</button>
        </div>
        
        <form action="{{ route('testimonials.store') }}" method="POST" id="testimonialForm">
            @csrf
            <div class="form-group">
                <label class="form-label">Rating Anda</label>
                <div class="rating-stars" id="ratingStars">
                    <span class="star-rating" data-rating="1">★</span>
                    <span class="star-rating" data-rating="2">★</span>
                    <span class="star-rating" data-rating="3">★</span>
                    <span class="star-rating" data-rating="4">★</span>
                    <span class="star-rating" data-rating="5">★</span>
                </div>
                <input type="hidden" name="rating" id="rating" value="5">
            </div>
            
            <div class="form-group">
                <label class="form-label">Testimoni</label>
                <textarea name="message" id="testimonialMessage" rows="3" class="form-textarea" placeholder="Ceritakan pengalaman Anda di Café Kopitiam33..."></textarea>
                <small class="text-danger" id="messageError" style="display: none; color: #dc2626; font-size: 0.7rem; margin-top: 0.25rem;">Testimoni minimal 10 karakter</small>
            </div>
            
            <div class="form-buttons">
                <button type="submit" class="btn-submit">Kirim Testimoni</button>
                <button type="button" onclick="closeTestimonialModal()" class="btn-cancel">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Order Success Modal -->
<div id="orderModal" class="order-modal-overlay">
    <div class="order-modal-container">
        <div class="order-modal-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h3 class="order-modal-title">Pesanan Berhasil!</h3>
        <p class="order-modal-message" id="orderMessage"></p>
        
        <div class="order-modal-detail">
            <div class="order-modal-detail-row">
                <span class="order-modal-detail-label" id="modalItemName">Nasi Goreng Spesial</span>
                <span class="order-modal-detail-value" id="modalItemPrice">Rp 35.000</span>
            </div>
            <div style="margin-top: 0.5rem;">
                <span>Jumlah: </span>
                <span id="modalItemQuantity">1</span>
                <span> porsi</span>
            </div>
        </div>
        
        <div class="order-modal-footer">
            <p>Silakan lakukan pembayaran di kasir.</p>
            <p style="font-size: 0.75rem; margin-top: 0.25rem;">Pesanan Anda telah dicatat dalam sistem kami.</p>
        </div>
        
        <button onclick="closeOrderModal()" class="order-modal-close">Tutup</button>
    </div>
</div>

<script>
    // Order Modal Functions
    function openOrderModal(itemName, itemPrice, itemQuantity = 1) {
        const modal = document.getElementById('orderModal');
        if (modal) {
            document.getElementById('modalItemName').textContent = itemName;
            document.getElementById('modalItemPrice').textContent = formatPrice(itemPrice);
            document.getElementById('modalItemQuantity').textContent = itemQuantity;
            document.getElementById('orderMessage').textContent = `"${itemName}" telah ditambahkan ke pesanan Anda.`;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }
    
    function closeOrderModal() {
        const modal = document.getElementById('orderModal');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    }
    
    // Testimonial Modal Functions
    function openTestimonialModal() {
        const modal = document.getElementById('testimonialModal');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }
    
    function closeTestimonialModal() {
        const modal = document.getElementById('testimonialModal');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
            const form = document.getElementById('testimonialForm');
            if (form) form.reset();
            const ratingInput = document.getElementById('rating');
            if (ratingInput) ratingInput.value = 5;
            const stars = document.querySelectorAll('.star-rating');
            stars.forEach((star, index) => {
                if (index < 5) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
            // Sembunyikan pesan error jika ada
            const errorMsg = document.getElementById('messageError');
            if (errorMsg) errorMsg.style.display = 'none';
        }
    }
    
    // Format price to Indonesian Rupiah
    function formatPrice(price) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(price);
    }
    
    // Close modal on outside click
    document.getElementById('orderModal')?.addEventListener('click', function(event) {
        if (event.target === this) {
            closeOrderModal();
        }
    });
    
    document.getElementById('testimonialModal')?.addEventListener('click', function(event) {
        if (event.target === this) {
            closeTestimonialModal();
        }
    });
    
    // Testimoni Widget Alpine Component
    function testimoniWidget() {
        return {
            dropdownOpen: false,
            testimonials: [],
            testimonialCount: 0,
            
            init() {
                this.fetchTestimonials();
            },
            
            toggleDropdown() {
                this.dropdownOpen = !this.dropdownOpen;
                if (this.dropdownOpen && this.testimonials.length === 0) {
                    this.fetchTestimonials();
                }
            },
            
            fetchTestimonials() {
                fetch('/testimonials/latest')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('API Error: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Handle both array response and object with data property
                        const testimonials = Array.isArray(data) ? data : (data.data || []);
                        this.testimonials = testimonials;
                        this.testimonialCount = testimonials.length;
                    })
                    .catch(error => {
                        console.warn('Testimonials widget: Failed to load testimonials', error);
                        this.testimonials = [];
                        this.testimonialCount = 0;
                    });
            },
            
            formatDate(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const diffTime = Math.abs(now - date);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                if (diffDays === 1) return 'Kemarin';
                if (diffDays < 7) return `${diffDays} hari lalu`;
                if (diffDays < 30) return `${Math.floor(diffDays / 7)} minggu lalu`;
                return `${Math.floor(diffDays / 30)} bulan lalu`;
            },
            
            openModal() {
                this.dropdownOpen = false;
                openTestimonialModal();
            }
        }
    }
    
    document.addEventListener('alpine:init', () => {
        Alpine.data('testimoniWidget', testimoniWidget);
    });
    
    // Star Rating Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star-rating');
        const ratingInput = document.getElementById('rating');
        
        if (stars.length > 0 && ratingInput) {
            // Set default rating 5
            stars.forEach((star, index) => {
                if (index < 5) {
                    star.classList.add('active');
                }
            });
            
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    ratingInput.value = rating;
                    
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                });
                
                star.addEventListener('mouseenter', function() {
                    const rating = parseInt(this.dataset.rating);
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.style.color = '#fbbf24';
                        } else {
                            s.style.color = '#d1d5db';
                        }
                    });
                });
                
                star.addEventListener('mouseleave', function() {
                    const currentRating = parseInt(ratingInput.value);
                    stars.forEach((s, index) => {
                        if (index < currentRating) {
                            s.style.color = '#fbbf24';
                        } else {
                            s.style.color = '#d1d5db';
                        }
                    });
                });
            });
        }
        
        // PERBAIKAN: Testimonial Form Validation
        const form = document.getElementById('testimonialForm');
        const messageTextarea = document.getElementById('testimonialMessage');
        const messageError = document.getElementById('messageError');
        
        if (form) {
            // Hilangkan validasi default HTML
            messageTextarea?.removeAttribute('required');
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Ambil nilai message dengan benar
                const message = messageTextarea ? messageTextarea.value.trim() : '';
                const rating = document.getElementById('rating').value;
                
                // Debug: console log untuk cek nilai
                console.log('Message length:', message.length);
                console.log('Message value:', message);
                
                // Validasi: message harus diisi dan minimal 10 karakter
                if (!message || message.length === 0) {
                    if (messageError) {
                        messageError.textContent = 'Testimoni tidak boleh kosong!';
                        messageError.style.display = 'block';
                        messageTextarea?.focus();
                    }
                    return;
                }
                
                if (message.length < 10) {
                    if (messageError) {
                        messageError.textContent = 'Testimoni minimal 10 karakter (saat ini ' + message.length + ' karakter)';
                        messageError.style.display = 'block';
                        messageTextarea?.focus();
                    }
                    return;
                }
                
                // Sembunyikan error jika valid
                if (messageError) messageError.style.display = 'none';
                
                // Kirim form dengan AJAX
                const formData = new FormData();
                formData.append('rating', rating);
                formData.append('message', message);
                formData.append('_token', document.querySelector('input[name="_token"]').value);
                
                const submitBtn = form.querySelector('.btn-submit');
                const originalText = submitBtn?.textContent || 'Kirim Testimoni';
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = '⏳ Mengirim...';
                }
                
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('✓ ' + data.message);
                        closeTestimonialModal();
                        // Refresh testimoni widget jika ada
                        const widgetElement = document.querySelector('[x-data="testimoniWidget()"]');
                        if (widgetElement && widgetElement.__x) {
                            widgetElement.__x.$data.fetchTestimonials();
                        }
                    } else {
                        alert('✗ ' + (data.message || 'Gagal mengirim testimoni'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan: ' + error.message);
                })
                .finally(() => {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    }
                });
            });
        }
        
        // Real-time validation on input
        if (messageTextarea && messageError) {
            messageTextarea.addEventListener('input', function() {
                const message = this.value.trim();
                if (message.length >= 10 || message.length === 0) {
                    messageError.style.display = 'none';
                } else if (message.length > 0 && message.length < 10) {
                    messageError.textContent = 'Testimoni minimal 10 karakter (saat ini ' + message.length + ' karakter)';
                    messageError.style.display = 'block';
                }
            });
        }
    });
</script>

@stack('scripts')
</body>
</html>