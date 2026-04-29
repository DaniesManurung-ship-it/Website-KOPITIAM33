@extends('layouts.app')

@section('title', 'Testimoni Customer - Café Kopitiam33')

@section('content')
<section class="py-12 bg-gradient-to-r from-sage to-wood text-white">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-serif font-bold mb-4">💬 Testimoni Customer</h1>
        <p class="text-lg max-w-2xl mx-auto opacity-90">
            Apa kata mereka tentang Café Kopitiam33
        </p>
    </div>
</section>

<div class="container mx-auto px-4 py-12">
    {{-- Debug: Tampilkan jumlah testimoni --}}
    @php
        \Log::info('Total testimoni di view: ' . $testimonials->total());
    @endphp
    
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-700 rounded-xl">
            {{ session('error') }}
        </div>
    @endif
    
    @if($testimonials->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($testimonials as $testimonial)
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-all">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-sage to-wood flex items-center justify-center text-white font-bold text-lg">
                        {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-semibold text-wood">{{ $testimonial->name }}</h4>
                        <p class="text-xs text-gray-400">{{ $testimonial->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="flex gap-1 mb-3">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="text-lg {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                    @endfor
                </div>
                <p class="text-gray-600 leading-relaxed">{{ $testimonial->message }}</p>
            </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $testimonials->links() }}
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-xl">
            <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            <p class="text-gray-500 text-lg mb-2">Belum ada testimoni</p>
            <p class="text-gray-400 text-sm mb-4">Jadilah yang pertama memberikan testimoni!</p>
            @auth
                <button onclick="openTestimonialModal()" class="bg-sage text-white px-6 py-2 rounded-lg hover:bg-wood transition">
                    ✍️ Beri Testimoni
                </button>
            @else
                <a href="{{ route('login') }}" class="inline-block bg-sage text-white px-6 py-2 rounded-lg hover:bg-wood transition">
                    🔒 Login untuk memberi testimoni
                </a>
            @endauth
        </div>
    @endif
</div>

<!-- Modal Testimoni -->
<div id="testimonialModal" class="fixed inset-0 bg-black/50 z-[1000] hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-wood">✍️ Beri Testimoni</h3>
            <button onclick="closeTestimonialModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        
        <form action="{{ route('testimonials.store') }}" method="POST" id="testimonialForm">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Rating Anda</label>
                <div class="flex gap-2 text-3xl" id="ratingStars">
                    <span class="star-rating cursor-pointer text-gray-300 hover:text-yellow-400 transition" data-rating="1">★</span>
                    <span class="star-rating cursor-pointer text-gray-300 hover:text-yellow-400 transition" data-rating="2">★</span>
                    <span class="star-rating cursor-pointer text-gray-300 hover:text-yellow-400 transition" data-rating="3">★</span>
                    <span class="star-rating cursor-pointer text-gray-300 hover:text-yellow-400 transition" data-rating="4">★</span>
                    <span class="star-rating cursor-pointer text-gray-300 hover:text-yellow-400 transition" data-rating="5">★</span>
                </div>
                <input type="hidden" name="rating" id="rating" value="5">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Testimoni</label>
                <textarea name="message" id="message" rows="4" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sage focus:border-transparent"
                    placeholder="Bagikan pengalaman Anda di Café Kopitiam33..." required></textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-sage text-white py-2 rounded-lg font-medium hover:bg-wood transition">
                    Kirim Testimoni
                </button>
                <button type="button" onclick="closeTestimonialModal()" class="flex-1 bg-gray-100 text-gray-700 py-2 rounded-lg font-medium hover:bg-gray-200 transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openTestimonialModal() {
        document.getElementById('testimonialModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    
    function closeTestimonialModal() {
        document.getElementById('testimonialModal').style.display = 'none';
        document.body.style.overflow = 'auto';
        document.getElementById('testimonialForm').reset();
        // Reset rating ke 5
        document.getElementById('rating').value = 5;
        const stars = document.querySelectorAll('.star-rating');
        stars.forEach((star, index) => {
            if (index < 5) {
                star.classList.add('active');
                star.style.color = '#fbbf24';
            }
        });
    }
    
    // Star rating functionality
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star-rating');
        const ratingInput = document.getElementById('rating');
        
        if (stars.length > 0 && ratingInput) {
            // Set default active stars (rating 5)
            stars.forEach((star, index) => {
                if (index < 5) {
                    star.classList.add('active');
                    star.style.color = '#fbbf24';
                }
            });
            
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    ratingInput.value = rating;
                    
                    stars.forEach((s, idx) => {
                        if (idx < rating) {
                            s.classList.add('active');
                            s.style.color = '#fbbf24';
                        } else {
                            s.classList.remove('active');
                            s.style.color = '#d1d5db';
                        }
                    });
                });
                
                star.addEventListener('mouseenter', function() {
                    const rating = parseInt(this.dataset.rating);
                    stars.forEach((s, idx) => {
                        s.style.color = idx < rating ? '#fbbf24' : '#d1d5db';
                    });
                });
                
                star.addEventListener('mouseleave', function() {
                    const currentRating = parseInt(ratingInput.value);
                    stars.forEach((s, idx) => {
                        s.style.color = idx < currentRating ? '#fbbf24' : '#d1d5db';
                    });
                });
            });
        }
        
        // Handle form submission with AJAX to avoid page reload
        const form = document.getElementById('testimonialForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const rating = document.getElementById('rating').value;
                const message = document.getElementById('message').value;
                
                if (!message || message.length < 10) {
                    alert('Testimoni minimal 10 karakter');
                    return;
                }
                
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        rating: rating,
                        message: message
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        closeTestimonialModal();
                        // Reload page to show new testimonial
                        window.location.reload();
                    } else {
                        alert(data.message || 'Gagal mengirim testimoni');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan, silakan coba lagi');
                });
            });
        }
        
        // Close modal when clicking outside
        const modal = document.getElementById('testimonialModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeTestimonialModal();
                }
            });
        }
    });
</script>

<style>
    .star-rating.active { color: #fbbf24; }
</style>
@endsection