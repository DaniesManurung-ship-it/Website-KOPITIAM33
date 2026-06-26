@extends('layouts.app')

@section('title', 'Pembayaran Pesanan - Café Kopitiam33')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/order_payment.css') }}">
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
