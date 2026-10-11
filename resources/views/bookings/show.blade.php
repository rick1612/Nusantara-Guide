@extends('layouts.app')
@section('title', 'Detail Booking — NusantaraGuide')
@section('styles')
<style>
    .success-banner h1{font-family:'Playfair Display',serif;font-size:26px;margin-bottom:8px;}
    .success-banner p{font-size:15px;opacity:0.8;}
    .detail-card h2{font-size:16px;font-weight:700;color:var(--forest);margin-bottom:20px;padding-bottom:12px;border-bottom:2px solid var(--cream);}
    .detail-row:last-child{border-bottom:none;}
    .detail-row .label{font-size:13px;color:var(--muted);}
    .detail-row .value{font-size:14px;font-weight:600;color:var(--ink);text-align:right;max-width:60%;}
    .status-badge{display:inline-flex;align-items:center;gap:8px;padding:8px 20px;border-radius:20px;font-size:14px;font-weight:600;}
    .total-highlight .tl{font-size:13px;opacity:0.75;}
    .total-highlight .tv{font-family:'Playfair Display',serif;font-size:24px;font-weight:900;}
    .actions{display:flex;gap:12px;flex-wrap:wrap;}
    .btn-primary:hover{background:var(--forest);}
    .btn-outline:hover{background:var(--coral);color:white;}
    .btn-ghost:hover{border-color:var(--jade);color:var(--jade);}
</style>
@endsection
@section('content')
<div class="page-wrap">
    @if(session('success'))
    <div class="success-banner">
        <div class="success-icon">🎉</div>
        <h1>Pemesanan Berhasil!</h1>
        <p>Booking kamu sudah masuk dan sedang menunggu konfirmasi dari hotel.</p>
        <div class="booking-code-badge">{{ $booking->booking_code }}</div>
    </div>
    @endif
    <div class="detail-card" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div>
            <div style="font-size:12px;color:var(--muted);margin-bottom:4px;">Kode Booking</div>
            <div style="font-size:20px;font-weight:700;color:var(--ink);letter-spacing:1px;">{{ $booking->booking_code }}</div>
        </div>
        <span class="status-badge" style="background:{{ $booking->status_color }}22;color:{{ $booking->status_color }};border:1px solid {{ $booking->status_color }}44;">{{ $booking->status_label }}</span>
    </div>
    <div class="detail-card">
        <h2>Detail Hotel</h2>
        <div class="detail-row"><span class="label">Hotel</span><span class="value"><a href="{{ route('place.show', $booking->place_id) }}" style="color:var(--jade);">{{ $booking->place->name }}</a></span></div>
        <div class="detail-row"><span class="label">Tipe Kamar</span><span class="value">{{ $booking->room->name }}</span></div>
        <div class="detail-row"><span class="label">Alamat</span><span class="value">{{ $booking->place->address }}</span></div>
    </div>
    <div class="detail-card">
        <h2>Detail Pemesanan</h2>
        <div class="detail-row"><span class="label">Check-in</span><span class="value">{{ $booking->check_in->isoFormat('dddd, D MMMM YYYY') }}</span></div>
        <div class="detail-row"><span class="label">Check-out</span><span class="value">{{ $booking->check_out->isoFormat('dddd, D MMMM YYYY') }}</span></div>
        <div class="detail-row"><span class="label">Durasi</span><span class="value">{{ $booking->nights }} malam</span></div>
        <div class="detail-row"><span class="label">Jumlah Tamu</span><span class="value">{{ $booking->guests }} orang</span></div>
        @if($booking->special_requests)<div class="detail-row"><span class="label">Permintaan Khusus</span><span class="value">{{ $booking->special_requests }}</span></div>@endif
        <div class="detail-row"><span class="label">Harga per malam</span><span class="value">{{ $booking->room->price_label }}</span></div>
        <div class="total-highlight"><span class="tl">Total Pembayaran</span><span class="tv">{{ $booking->total_label }}</span></div>
    </div>
    <div class="detail-card">
        <div class="actions">
            <a href="{{ route('bookings.my') }}" class="btn-primary">📋 Semua Booking Saya</a>
            <a href="{{ route('place.show', $booking->place_id) }}" class="btn-ghost">Kembali ke Hotel</a>
            @if($booking->status === 'pending')
            <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                @csrf<button type="submit" class="btn-outline">Batalkan Booking</button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection