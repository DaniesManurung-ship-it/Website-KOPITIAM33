@if(isset($popupPromo) && $popupPromo)
<style>
    /* Popup Promo Styles */
    .promo-popup-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        backdrop-filter: blur(4px);
    }

    .promo-popup-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    .promo-popup-content {
        background: white;
        border-radius: 12px;
        width: 85%;
        max-width: 380px;
        position: relative;
        transform: scale(0.9) translateY(20px);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .promo-popup-overlay.show .promo-popup-content {
        transform: scale(1) translateY(0);
    }

    .promo-popup-close {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(255, 255, 255, 0.9);
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        color: var(--wood);
        transition: all 0.2s;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .promo-popup-close:hover {
        background: white;
        transform: scale(1.1);
        color: #ef4444;
    }

    .promo-popup-img {
        width: 100%;
        height: 140px;
        object-fit: cover;
    }

    .promo-popup-body {
        padding: 16px;
        text-align: center;
    }

    .promo-popup-title {
        font-family: 'Playfair Display', serif;
        color: var(--wood);
        font-size: 1.25rem;
        margin-bottom: 6px;
        font-weight: 700;
    }

    .promo-popup-desc {
        color: #4b5563;
        font-size: 0.85rem;
        margin-bottom: 12px;
        line-height: 1.4;
    }

    .promo-popup-dates {
        display: inline-block;
        background: #f3f4f6;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        color: #6b7280;
        margin-bottom: 12px;
        font-weight: 500;
    }

    .promo-popup-box {
        position: relative;
        margin: 10px auto;
        width: 100px;
        height: 80px;
        cursor: pointer;
        transition: transform 0.3s;
    }

    .promo-popup-box:hover {
        transform: translateY(-5px) scale(1.05);
    }

    /* Box Animation Elements */
    .box-lid {
        width: 100px;
        height: 35px;
        background: var(--sage);
        border-radius: 8px;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 2;
        transform-origin: bottom center;
        transition: transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .box-lid::before {
        content: '🎁';
        font-size: 1.25rem;
    }

    .box-body {
        width: 90px;
        height: 60px;
        background: var(--matcha);
        border-radius: 0 0 8px 8px;
        position: absolute;
        bottom: 0;
        left: 5px;
        z-index: 1;
        box-shadow: inset 0 10px 20px rgba(0,0,0,0.1);
    }

    .promo-popup-box.opened .box-lid {
        transform: rotateX(120deg) translateY(-20px);
        opacity: 0;
    }

    .voucher-reveal {
        display: none;
        opacity: 0;
        transform: translateY(10px) scale(0.9);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        background: white;
        padding: 12px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        border: 2px dashed var(--sage);
        margin: 0 auto;
        width: 90%;
    }

    .voucher-reveal.show {
        display: block;
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    .voucher-code-text {
        font-family: monospace;
        font-size: 1.25rem;
        font-weight: bold;
        color: var(--wood);
        letter-spacing: 1px;
        margin: 6px 0;
    }

    .voucher-discount {
        color: #10b981;
        font-weight: bold;
        font-size: 1rem;
    }

    .btn-claim {
        background: var(--wood);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        width: 100%;
        cursor: pointer;
        transition: background 0.3s;
        margin-top: 10px;
    }

    .btn-claim:hover {
        background: #5a3c22;
    }

    .guest-message {
        background: #fef3c7;
        color: #92400e;
        padding: 12px;
        border-radius: 8px;
        font-size: 0.9rem;
        margin-top: 16px;
        font-weight: 500;
    }
</style>

<div class="promo-popup-overlay" id="promoPopupOverlay">
    <div class="promo-popup-content">
        <button class="promo-popup-close" id="promoPopupClose" aria-label="Close">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        @if($popupPromo->image)
            <img src="{{ asset($popupPromo->image) }}" alt="{{ $popupPromo->title }}" class="promo-popup-img" onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}'; this.style.display='none';">
        @else
            <div class="promo-popup-img" style="background: var(--cream); display:flex; align-items:center; justify-content:center;">
                <span style="font-size:4rem;">🎉</span>
            </div>
        @endif

        <div class="promo-popup-body">
            <h2 class="promo-popup-title">{{ $popupPromo->title }}</h2>
            <p class="promo-popup-desc">{{ $popupPromo->description }}</p>
            <div class="promo-popup-dates">
                🗓️ Berlaku: {{ \Carbon\Carbon::parse($popupPromo->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($popupPromo->end_date)->format('d M Y') }}
            </div>

            @auth
                <div id="claimSection">
                    <p style="font-weight: 600; color: var(--wood); margin-bottom: 10px;">Klik kotak di bawah untuk klaim!</p>
                    <div class="promo-popup-box" id="promoBox">
                        <div class="box-lid"></div>
                        <div class="box-body"></div>
                    </div>
                    <div class="voucher-reveal" id="voucherReveal">
                        <div style="font-size: 0.75rem; color: #6b7280; text-transform: uppercase;">Kode Voucher Anda</div>
                        <div class="voucher-code-text" id="voucherCodeText">{{ $popupPromo->voucher_code }}</div>
                        <div class="voucher-discount">Diskon {{ $popupPromo->discount_percent }}%</div>
                        <button onclick="copyPromoCode()" class="btn-claim" id="copyBtn" style="margin-top: 10px; padding: 6px 12px; font-size: 0.85rem; background: var(--sage); display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                            </svg>
                            Salin Kode
                        </button>
                    </div>
                    <p id="claimInstruction" style="font-size: 0.75rem; color: #6b7280; display: none; margin-top: 15px;">
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

    // Close when clicking outside
    overlay.addEventListener('click', function(e) {
        if (e.target === overlay) {
            overlay.classList.remove('show');
            sessionStorage.setItem(storageKey, 'true');
        }
    });

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
