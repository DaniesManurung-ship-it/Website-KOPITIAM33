<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Brand Section -->
            <div class="footer-brand">
                <div class="footer-logo">
                    <div class="logo-circle">
                        <span class="logo-text">CK</span>
                    </div>
                    <span class="logo-brand">Café Kopitiam33</span>
                </div>
                <p class="footer-desc">
                    Café Kopitiam33 hadir untuk menyajikan pengalaman kuliner autentik dengan cita rasa Nusantara yang dipadukan dengan sentuhan modern.
                </p>
                <div class="footer-social">
                    <a href="https://www.instagram.com/kopitiam33_balige/" target="_blank" class="social-link" aria-label="Instagram">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/>
                        </svg>
                    </a>

                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-links">
                <h4 class="footer-title">Menu Cepat</h4>
                <ul class="footer-list">
                    <li><a href="{{ route('menu') }}">🍽️ Semua Menu</a></li>
                    <li><a href="{{ route('menu-spesial') }}">⭐ Menu Spesial</a></li>
                    <li><a href="{{ route('reservasi') }}">📅 Reservasi</a></li>
                </ul>
            </div>

            <!-- Information -->
            <div class="footer-links">
                <h4 class="footer-title">Informasi</h4>
                <ul class="footer-list">
                    <li><a href="{{ route('about') }}">📖 Tentang Kami</a></li>
                    <li><a href="{{ route('gallery') }}">🖼️ Galeri</a></li>
                    <li><a href="{{ route('contact') }}">📞 Kontak</a></li>
                    <li><a href="{{ route('testimonials.index') }}">💬 Testimoni</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-contact">
                <h4 class="footer-title">Hubungi Kami</h4>
                <ul class="footer-list">
                    <li>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Jl. Patuan Nagari No.5, Balige, Toba, Sumatera Utara 22312</span>
                    </li>
                    <li>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <a href="tel:+6212112345678">(021) 1234-5678</a>
                    </li>
                    <li>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <a href="mailto:hello@kopitiam33.id">hello@kopitiam33.id</a>
                    </li>
                    <li>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>07:00 - 22:00 WIB</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Café Kopitiam33. All rights reserved.</p>
        </div>
    </div>
</footer>
<link rel="stylesheet" href="{{ asset('css/layouts/footer.css') }}">
