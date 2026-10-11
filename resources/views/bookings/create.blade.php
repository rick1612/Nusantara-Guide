@extends('layouts.app')
@section('title', 'Pesan Kamar — NusantaraGuide')
@section('styles')
<style>
    .breadcrumb a{color:var(--jade);text-decoration:none;}
    .breadcrumb a:hover{text-decoration:underline;}
    .form-card h2{font-size:18px;font-weight:700;color:var(--forest);margin-bottom:24px;padding-bottom:16px;border-bottom:2px solid var(--cream);}
    .form-group label{display:block;font-size:13px;font-weight:600;color:var(--ink);margin-bottom:7px;}
    .form-group input,.form-group select,.form-group textarea{width:100%;padding:12px 16px;border:1.5px solid #e0dbd2;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--ink);background:var(--cream);outline:none;transition:border-color 0.2s;}
    .form-group input:focus,.form-group select:focus,.form-group textarea:focus{border-color:var(--jade);background:white;}
    .form-group textarea{resize:vertical;min-height:80px;}
    .submit-btn:hover{background:#d4604a;transform:translateY(-2px);}
    .summary-card h3{font-size:16px;font-weight:700;color:var(--forest);margin-bottom:20px;}
    .hotel-thumb{width:100%;height:160px;object-fit:cover;border-radius:12px;margin-bottom:18px;background:var(--cream);display:block;}
    .summary-hotel{font-size:15px;font-weight:700;color:var(--ink);margin-bottom:4px;}
    .summary-room{font-size:13px;color:var(--jade);font-weight:600;margin-bottom:16px;}
    .summary-row:last-of-type{border-bottom:none;}
    .summary-row .label{color:var(--muted);}
    .summary-row .value{font-weight:600;color:var(--ink);}
    .total-box .total-label{font-size:12px;opacity:0.7;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;}
    .total-box .total-value{font-family:'Playfair Display',serif;font-size:26px;font-weight:900;}
    .total-box .total-note{font-size:12px;opacity:0.6;margin-top:4px;}
    .policy-note{font-size:12px;color:var(--muted);margin-top:14px;line-height:1.6;}
    .policy-note strong{color:var(--ink);}
    @media(max-width:800px){}
</style>
@endsection
@section('content')
<div class="page-wrap">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a> /
        <a href="{{ route('place.show', $place->id) }}">{{ $place->name }}</a> /
        <span>Pesan Kamar</span>
    </div>
    <div class="page-title">Pesan Kamar 🏨</div>
    <div class="booking-layout">
        <div class="form-card">
            <h2>Detail Pemesanan</h2>
            @if($errors->any())
            <div style="background:rgba(231,111,81,0.1);border:1px solid var(--coral);border-radius:10px;padding:14px 18px;margin-bottom:20px;font-size:14px;color:var(--coral);">{{ $errors->first() }}</div>
            @endif
            <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                @csrf
                <input type="hidden" name="room_id" value="{{ $room->id }}">
                <div class="form-row">
                    <div class="form-group">
                        <label>Check-in</label>
                        <input type="date" name="check_in" id="check_in" value="{{ old('check_in') }}" min="{{ date('Y-m-d') }}" required onchange="calculateTotal()">
                        @error('check_in')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Check-out</label>
                        <input type="date" name="check_out" id="check_out" value="{{ old('check_out') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required onchange="calculateTotal()">
                        @error('check_out')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Jumlah Tamu</label>
                    <select name="guests" id="guests" onchange="calculateTotal()">
                        @for($i=1;$i<=$room->max_guests;$i++)<option value="{{ $i }}" {{ old('guests')==$i?'selected':'' }}>{{ $i }} tamu</option>@endfor
                    </select>
                </div>
                <div class="form-group">
                    <label>Permintaan Khusus <span style="font-weight:400;color:var(--muted);">(opsional)</span></label>
                    <textarea name="special_requests" placeholder="Contoh: kamar lantai atas, extra bed, dll...">{{ old('special_requests') }}</textarea>
                </div>
                <div style="background:var(--cream);border-radius:10px;padding:16px;margin-bottom:20px;">
                    <div style="font-size:12px;font-weight:700;color:var(--muted);letter-spacing:1px;text-transform:uppercase;margin-bottom:10px;">Data Pemesan</div>
                    <div style="font-size:14px;font-weight:600;color:var(--ink);">{{ Auth::user()->name }}</div>
                    <div style="font-size:13px;color:var(--muted);">{{ Auth::user()->email }}</div>
                </div>
                <button type="submit" class="submit-btn">Konfirmasi Pemesanan →</button>
            </form>
        </div>
        <div>
            <div class="summary-card">
                <h3>Ringkasan Pemesanan</h3>
                <img src="{{ asset($place->image_url ?? 'images/default.jpg') }}" class="hotel-thumb" alt="{{ $place->name }}" onerror="this.style.background='#e8f4ee';this.style.display='none';">
                <div class="summary-hotel">{{ $place->name }}</div>
                <div class="summary-room">🛏️ {{ $room->name }}</div>
                <div class="summary-row"><span class="label">Harga per malam</span><span class="value">{{ $room->price_label }}</span></div>
                <div class="summary-row"><span class="label">Maks. tamu</span><span class="value">{{ $room->max_guests }} orang</span></div>
                <div class="summary-row" id="nights-row" style="display:none;"><span class="label">Jumlah malam</span><span class="value" id="nights-display">-</span></div>
                <div class="total-box">
                    <div class="total-label">Total Harga</div>
                    <div class="total-value" id="total-display">Pilih tanggal</div>
                    <div class="total-note" id="total-note"></div>
                </div>
                <p class="policy-note"><strong>Kebijakan pembatalan:</strong> Pemesanan dapat dibatalkan selama status masih <em>Menunggu Konfirmasi</em>.</p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
const pricePerNight = {{ $room->price_per_night }};
function calculateTotal() {
    const checkIn = document.getElementById('check_in').value;
    const checkOut = document.getElementById('check_out').value;
    if (!checkIn || !checkOut) return;
    const d1 = new Date(checkIn), d2 = new Date(checkOut);
    const nights = Math.round((d2-d1)/(1000*60*60*24));
    if (nights <= 0) { document.getElementById('total-display').textContent='Tanggal tidak valid'; return; }
    const total = nights * pricePerNight;
    document.getElementById('nights-row').style.display='flex';
    document.getElementById('nights-display').textContent=nights+' malam';
    document.getElementById('total-display').textContent='Rp '+total.toLocaleString('id-ID');
    document.getElementById('total-note').textContent=nights+' malam × Rp '+pricePerNight.toLocaleString('id-ID');
    document.getElementById('check_out').min=checkIn;
}
calculateTotal();
</script>
@endsection