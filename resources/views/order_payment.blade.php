@extends('layouts.app')

@section('title', 'Pembayaran Pesanan - Café Kopitiam33')

@push('styles')
<style>
    .payment-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 30px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        text-align: center;
    }
    .payment-header h2 {
        color: var(--wood);
        margin-bottom: 10px;
    }
    .payment-total {
        font-size: 24px;
        font-weight: bold;
        color: var(--sage);
        margin: 20px 0;
        padding: 15px;
        background: var(--cream);
        border-radius: 8px;
    }
    .qris-container {
        margin: 30px 0;
        padding: 20px;
        border: 2px dashed #e2e8f0;
        border-radius: 12px;
    }
    .qris-image {
        max-width: 250px;
        height: auto;
        margin-bottom: 15px;
    }
    .upload-section {
        margin-top: 30px;
        text-align: left;
    }
    .upload-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--wood);
    }
    .file-input {
        display: block;
        width: 100%;
        padding: 10px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .submit-btn {
        width: 100%;
        padding: 14px;
        background: var(--sage);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s;
    }
    .submit-btn:hover {
        background: #7a9677;
    }
    .alert-error {
        background: #fee2e2;
        color: #dc2626;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: left;
    }
    .payment-instructions {
        text-align: left;
        margin: 20px 0;
        padding: 15px;
        background: #f8fafc;
        border-radius: 8px;
        font-size: 14px;
    }
    .payment-instructions ol {
        margin-left: 20px;
        margin-top: 10px;
    }
    .payment-instructions li {
        margin-bottom: 5px;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="payment-container">
        <div class="payment-header">
            <h2>Selesaikan Pembayaran Anda</h2>
            <p>Pesanan <strong>{{ $order->order_number }}</strong></p>
        </div>

        @if(session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="payment-total">
            Total Tagihan: Rp {{ number_format($order->subtotal, 0, ',', '.') }}
        </div>

        <div class="qris-container">
            <h3>Scan QRIS</h3>
            <p style="color: #64748b; font-size: 14px; margin-bottom: 15px;">Gunakan aplikasi M-Banking atau e-Wallet favorit Anda</p>
            
            <!-- Menggunakan gambar QRIS dari folder public. Pastikan menyimpan file asli dengan nama qris.jpg di folder public/images/ -->
            <img src="{{ asset('images/QR.png') }}" onerror="this.onerror=null; this.src='https: alt="QRIS KOPITIAM33" class="qris-image">
            
            <p style="font-weight: bold; color: var(--wood);">a.n. KOPITIAM 33</p>
        </div>

        <div class="payment-instructions">
            <strong>Cara Pembayaran:</strong>
            <ol>
                <li>Buka aplikasi M-Banking atau e-Wallet Anda (Gopay, OVO, Dana, dll).</li>
                <li>Pilih menu Scan QRIS.</li>
                <li>Scan barcode di atas atau simpan gambar dan upload dari galeri.</li>
                <li>Pastikan nama merchant adalah <strong>KOPITIAM 33</strong> dan masukkan nominal sesuai total tagihan.</li>
                <li>Screenshot bukti pembayaran jika sudah berhasil.</li>
            </ol>
        </div>

        <form action="{{ route('order.payment.upload', $order->id) }}" method="POST" enctype="multipart/form-data" class="upload-section">
            @csrf
            <label for="payment_proof" class="upload-label">Upload Bukti Pembayaran <span style="color: red;">*</span></label>
            <input type="file" name="payment_proof" id="payment_proof" class="file-input" accept="image/jpeg,image/png,image/jpg" required>
            <small style="display: block; margin-top: -15px; margin-bottom: 20px; color: #64748b;">Format yang didukung: JPG, JPEG, PNG. Maksimal 5MB.</small>
            
            <button type="submit" class="submit-btn">Kirim Bukti Pembayaran</button>
        </form>
    </div>
</div>
@endsection
