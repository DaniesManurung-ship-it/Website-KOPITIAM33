@if(isset($popupPromo) && $popupPromo)
<link rel="stylesheet" href="{{ asset('css/components/promo_popup.css') }}">

<div class="promo-popup-overlay" id="promoPopupOverlay">
    <div class="promo-popup-content">
        <button class="promo-popup-close" id="promoPopupClose" aria-label="Close">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <div class="promo-popup-img-container">
            @if($popupPromo->image)
                <img src="{{ asset($popupPromo->image) }}" alt="{{ $popupPromo->title }}" class="promo-popup-img" onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}'; this.style.display='none';">
            @else
                <div class="promo-popup-img" style="background: var(--cream); display:flex; align-items:center; justify-content:center; height: 100%;">
                    <span style="font-size:4rem;">🎉</span>
                </div>
            @endif
        </div>

        <div class="promo-popup-body">
            <h2 class="promo-popup-title">{{ $popupPromo->title }}</h2>
            <p class="promo-popup-desc">{{ $popupPromo->description }}</p>
            <div class="promo-popup-dates">
                🌟 Berlaku: {{ \Carbon\Carbon::parse($popupPromo->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($popupPromo->end_date)->format('d M Y') }}
            </div>

            @auth
                <div id="claimSection">
                    <p style="font-weight: 800; color: #D4AF37; margin-bottom: 5px; font-size: 1rem; text-transform: uppercase; letter-spacing: 1.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">Klik Amplop Untuk Klaim!</p>
                    <div class="promo-popup-box" id="promoBox">
                        <div class="envelope-flap"></div>
                        <div class="envelope-letter">
                            <div class="envelope-letter-line" style="width: 40%;"></div>
                            <div class="envelope-letter-line" style="width: 80%;"></div>
                            <div class="envelope-letter-line" style="width: 60%;"></div>
                        </div>
                        <div class="envelope-left"></div>
                        <div class="envelope-right"></div>
                        <div class="envelope-bottom"></div>
                        <div class="envelope-seal">❤️</div>
                    </div>
                    <div class="voucher-reveal" id="voucherReveal">
                        <div style="font-size: 0.8rem; color: #8B4513; text-transform: uppercase; font-weight: 700;">Kode Voucher Anda</div>
                        <div class="voucher-code-text" id="voucherCodeText">{{ $popupPromo->voucher_code }}</div>
                        <div class="voucher-discount">Diskon {{ $popupPromo->discount_percent }}%</div>
                        <button onclick="copyPromoCode()" class="btn-claim" id="copyBtn" style="margin-top: 15px; padding: 10px 16px; font-size: 0.9rem; display: inline-flex; align-items: center; justify-content: center; gap: 8px; background: linear-gradient(to right, #4caf50, #2e7d32); color: white; box-shadow: 0 4px 10px rgba(76, 175, 80, 0.4);">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                            </svg>
                            Salin Kode
                        </button>
                    </div>
                    <p id="claimInstruction" style="font-size: 0.8rem; color: #A0A0A0; display: none; margin-top: 20px; font-style: italic;">
                        Gunakan kode di atas saat checkout pemesanan.
                    </p>
                </div>
            @else
                <div class="guest-message">
                    <span>🔒</span> Login atau Register sekarang untuk klaim promo eksklusif ini!
                </div>
                <a href="{{ route('login') }}" class="btn-claim" style="display: block; text-decoration: none; margin-top: 16px;">
                    Login untuk Klaim
                </a>
            @endauth
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const overlay = document.getElementById('promoPopupOverlay');
    const closeBtn = document.getElementById('promoPopupClose');
    const promoBox = document.getElementById('promoBox');
    const promoId = '{{ $popupPromo->id }}';
    const storageKey = 'promo_closed_' + promoId;

    // Check if user has closed this specific promo before
    if (!sessionStorage.getItem(storageKey)) {
        // Show after a small delay
        setTimeout(() => {
            overlay.classList.add('show');
        }, 1000);
    }

    // Close popup
    closeBtn.addEventListener('click', function() {
        overlay.classList.remove('show');
        sessionStorage.setItem(storageKey, 'true'); // Save to session storage so it doesn't appear again in this session
    });

    // Prevent closing when clicking outside (overlay click event removed as requested)

    // Animation box click
    if (promoBox) {
        promoBox.addEventListener('click', function() {
            if (!this.classList.contains('opened')) {
                this.classList.add('opened');
                
                setTimeout(() => {
                    this.style.display = 'none';
                    const reveal = document.getElementById('voucherReveal');
                    if (reveal) reveal.classList.add('show');
                    document.getElementById('claimInstruction').style.display = 'block';
                }, 500);
                
                // Implicit copy
                const code = '{{ $popupPromo->voucher_code }}';
                navigator.clipboard.writeText(code).catch(err => {
                    console.log('Failed to auto-copy', err);
                });
            }
        });
    }

    // Explicit copy function for the button
    window.copyPromoCode = function() {
        const code = '{{ $popupPromo->voucher_code }}';
        navigator.clipboard.writeText(code).then(() => {
            const btn = document.getElementById('copyBtn');
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '✅ Berhasil Disalin!';
            btn.style.background = '#10b981';
            
            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.style.background = 'var(--sage)';
            }, 2000);
        }).catch(err => {
            console.error('Failed to copy', err);
            alert('Gagal menyalin kode. Silakan blok tulisan dan salin manual.');
        });
    };
});
</script>
@endif
