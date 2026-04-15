{{-- resources/views/layouts/footer.blade.php --}}
@unless(Request::is('login', 'register', 'admin/login', 'admin/*'))

<!-- Footer -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-grid">
            <!-- Brand Info -->
            <div class="footer-brand">
                <div class="footer-logo">
                    <div class="logo-circle">
                        <span class="logo-text">CK</span>
                    </div>
                    <span class="logo-brand">Café Kopitiam33</span>
                </div>
                <p class="footer-description">
                    Menyajikan cita rasa Indonesia dengan sentuhan modern. Nikmati suasana hangat dan nyaman di tengah kota.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="footer-links">
                <h3 class="footer-title">Navigasi</h3>
                <ul class="footer-nav-list">
                    <li><a href="{{ url('/') }}" class="footer-link">Dashboard</a></li>
                    <li><a href="{{ url('/home') }}" class="footer-link">Home</a></li>
                    <li><a href="{{ url('/menu') }}" class="footer-link">Menu</a></li>
                    <li><a href="{{ url('/about') }}" class="footer-link">Tentang Kami</a></li>
                    <li><a href="{{ url('/gallery') }}" class="footer-link">Galeri</a></li>
                    <li><a href="{{ url('/contact') }}" class="footer-link">Kontak</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-contact">
                <h3 class="footer-title">Kontak Kami</h3>
                <div class="contact-list">
                    <p class="contact-item">
                        <span>Jl. Patuan Nagari No. 5, Sangkar Nihuta, Kota Balige</span>
                    </p>
                    <p class="contact-item">
                        <span>+62 853-5908-7858</span>
                    </p>
                    <p class="contact-item">
                        <span>kopitiam33@gmail.com</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Café Kopitiam33. All rights reserved.</p>
            <p class="footer-credit">Made with ☕ in Toba</p>
        </div>
    </div>
</footer>

<!-- Order Success Modal -->
<div id="orderModal" class="modal hidden">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Pesanan Berhasil!</h3>
            <p class="modal-message" id="orderMessage"></p>
        </div>
        <button onclick="closeOrderModal()" class="modal-btn">Tutup</button>
    </div>
</div>

<style>
    /* ========== FOOTER STYLES ========== */
    .footer {
        background: var(--sage, #8BA888);
        color: white;
        margin-top: 4rem;
    }
    
    .footer-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }
    
    .footer-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    @media (min-width: 768px) {
        .footer-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    /* Brand Section */
    .footer-brand {
        margin-bottom: 1rem;
    }
    
    .footer-logo {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .logo-circle {
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .logo-text {
        color: var(--sage, #8BA888);
        font-weight: bold;
        font-size: 1.25rem;
    }
    
    .logo-brand {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 600;
        color: white;
    }
    
    .footer-description {
        color: var(--cream, #F5EFE6);
        line-height: 1.6;
    }
    
    /* Links Section */
    .footer-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .footer-nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .footer-nav-list li {
        margin-bottom: 0.5rem;
    }
    
    .footer-link {
        color: var(--cream, #F5EFE6);
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .footer-link:hover {
        color: white;
    }
    
    /* Contact Section */
    .contact-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .contact-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--cream, #F5EFE6);
        margin: 0;
    }
    
    /* Footer Bottom */
    .footer-bottom {
        border-top: 1px solid rgba(245, 239, 230, 0.3);
        margin-top: 2rem;
        padding-top: 2rem;
        text-align: center;
        color: var(--cream, #F5EFE6);
    }
    
    .footer-credit {
        margin-top: 0.5rem;
    }
    
    /* ========== MODAL STYLES ========== */
    .modal {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 50;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    
    .modal.show {
        display: flex;
    }
    
    .modal-content {
        background: white;
        border-radius: 1rem;
        max-width: 448px;
        width: 100%;
        padding: 1.5rem;
        animation: slideUp 0.3s ease;
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .modal-header {
        text-align: center;
        margin-bottom: 1.5rem;
    }
    
    .modal-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--wood, #A67B5B);
        margin-bottom: 0.5rem;
    }
    
    .modal-message {
        color: #6b7280;
    }
    
    .modal-btn {
        width: 100%;
        background: var(--accent, #D97642);
        color: white;
        padding: 0.75rem;
        border: none;
        border-radius: 0.5rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
    }
    
    .modal-btn:hover {
        background: var(--wood, #A67B5B);
    }
    
    /* Hidden utility */
    .hidden {
        display: none;
    }
</style>

<script>
    // Modal functions
    function openOrderModal(message) {
        const modal = document.getElementById('orderModal');
        const messageEl = document.getElementById('orderMessage');
        
        if (modal && messageEl) {
            messageEl.textContent = message || 'Pesanan Anda telah diterima. Silakan lanjutkan ke kasir untuk pembayaran.';
            modal.classList.add('show');
            modal.style.display = 'flex';
        }
    }
    
    function closeOrderModal() {
        const modal = document.getElementById('orderModal');
        if (modal) {
            modal.classList.remove('show');
            modal.style.display = 'none';
        }
    }
    
    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('orderModal');
        if (modal && modal.style.display === 'flex') {
            if (e.target === modal) {
                closeOrderModal();
            }
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeOrderModal();
        }
    });
</script>

@endunless