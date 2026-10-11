@extends('layouts.app')
@section('title', 'Pesan Kereta — NusantaraGuide')
@section('styles')
<style>
    .breadcrumb a{color:var(--jade);text-decoration:none;}
    .form-card h2{font-size:18px;font-weight:700;color:var(--forest);margin-bottom:24px;padding-bottom:16px;border-bottom:2px solid var(--cream);}
    .form-group label{display:block;font-size:13px;font-weight:600;color:var(--ink);margin-bottom:7px;}
    .form-group input,.form-group select{width:100%;padding:12px 16px;border:1.5px solid #e0dbd2;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--ink);background:var(--cream);outline:none;transition:border-color 0.2s;}
    .form-group input:focus,.form-group select:focus{border-color:var(--jade);background:white;}
    .submit-btn:hover{background:var(--forest);transform:translateY(-2px);}
    .summary-card h3{font-size:16px;font-weight:700;color:var(--forest);margin-bottom:20px;}
    .train-icon-big{width:100%;height:120px;background:linear-gradient(135deg,#0d1b35,#1a2d6a);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:56px;margin-bottom:18px;}
    .summary-name{font-size:16px;font-weight:700;color:var(--ink);margin-bottom:4px;}
    .summary-class{font-size:13px;color:var(--jade);font-weight:600;margin-bottom:4px;}
    .summary-row:last-of-type{border-bottom:none;}
    .summary-row .label{color:var(--muted);}
    .summary-row .value{font-weight:600;color:var(--ink);}
    .total-box .total-label{font-size:12px;opacity:0.7;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;}
    .total-box .total-value{font-family:'Playfair Display',serif;font-size:26px;font-weight:900;}
    .total-box .total-note{font-size:12px;opacity:0.6;margin-top:4px;}
    @media(max-width:800px){}
</style>
@endsection
@section('content')
<div class="page-wrap">
    <div class="breadcrumb">
        <a href="{{ route('transportation.index') }}">Transportasi</a> /
        <a href="{{ route('transportation.index', ['type'=>'train']) }}">Kereta Api</a> /
        <span>Pesan Tiket</span>
    </div>
    <div class="page-title">Pesan Tiket Kereta 🚆</div>
    <div class="booking-layout">
        <div class="form-card">
            <h2>Detail Pemesanan</h2>
            @if($errors->any())
            <div style="background:rgba(231,111,81,0.1);border:1px solid var(--coral);border-radius:10px;padding:14px 18px;margin-bottom:20px;font-size:14px;color:var(--coral);">{{ $errors->first() }}</div>
            @endif
            <form action="{{ route('transportation.train.store') }}" method="POST">
                @csrf
                <input type="hidden" name="train_id" value="{{ $train->id }}">
                <input type="hidden" name="travel_date" value="{{ $date }}">
                <div style="background:var(--cream);border-radius:10px;padding:16px;margin-bottom:20px;">
                    <div style="font-size:12px;font-weight:700;color:var(--muted);letter-spacing:1px;text-transform:uppercase;margin-bottom:8px;">Jadwal Perjalanan</div>
                    <div style="font-size:15px;font-weight:700;color:var(--ink);">{{ $train->origin->name }} → {{ $train->destination->name }}</div>
                    <div style="font-size:13px;color:var(--muted);margin-top:4px;">{{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM YYYY') }} · {{ substr($train->departure_time,0,5) }} – {{ substr($train->arrival_time,0,5) }} ({{ $train->duration_label }})</div>
                </div>
                <div class="form-group">
                    <label>Jumlah Penumpang</label>
                    <select name="passengers" id="passengers" onchange="calculateTotal()">
                        @for($i=1;$i<=9;$i++)<option value="{{ $i }}" {{ old('passengers',1)==$i?'selected':'' }}>{{ $i }} penumpang</option>@endfor
                    </select>
                </div>
                <div class="form-group">
                    <label>Nama Penumpang (sesuai KTP)</label>
                    <input type="text" name="passenger_name" value="{{ old('passenger_name', Auth::user()->name) }}" required placeholder="Nama lengkap sesuai identitas">
                    @error('passenger_name')<div class="error-msg">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Nomor KTP / Paspor</label>
                    <input type="text" name="passenger_id_number" value="{{ old('passenger_id_number') }}" required placeholder="16 digit nomor KTP">
                    @error('passenger_id_number')<div class="error-msg">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="tel" name="contact_phone" value="{{ old('contact_phone') }}" required placeholder="08xxxxxxxxxx">
                    @error('contact_phone')<div class="error-msg">{{ $message }}</div>@enderror
                </div>
                <div style="background:var(--cream);border-radius:10px;padding:16px;margin-bottom:20px;">
                    <div style="font-size:12px;font-weight:700;color:var(--muted);letter-spacing:1px;text-transform:uppercase;margin-bottom:8px;">Data Pemesan</div>
                    <div style="font-size:14px;font-weight:600;color:var(--ink);">{{ Auth::user()->name }}</div>
                    <div style="font-size:13px;color:var(--muted);">{{ Auth::user()->email }}</div>
                </div>
                <button type="submit" class="submit-btn">Konfirmasi Pemesanan →</button>
            </form>
        </div>
        <div>
            <div class="summary-card">
                <h3>Ringkasan</h3>
                <div class="train-icon-big">🚆</div>
                <div class="summary-name">{{ $train->name }}</div>
                <div class="summary-class">{{ $train->class }} · KA {{ $train->train_number }}</div>
                <div class="summary-row"><span class="label">Rute</span><span class="value">{{ $train->origin->city }} → {{ $train->destination->city }}</span></div>
                <div class="summary-row"><span class="label">Berangkat</span><span class="value">{{ substr($train->departure_time,0,5) }}</span></div>
                <div class="summary-row"><span class="label">Tiba</span><span class="value">{{ substr($train->arrival_time,0,5) }}</span></div>
                <div class="summary-row"><span class="label">Durasi</span><span class="value">{{ $train->duration_label }}</span></div>
                <div class="summary-row"><span class="label">Harga/orang</span><span class="value">{{ $train->price_label }}</span></div>
                <div class="total-box">
                    <div class="total-label">Total Harga</div>
                    <div class="total-value" id="total-display">{{ $train->price_label }}</div>
                    <div class="total-note" id="total-note">1 penumpang × {{ $train->price_label }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
const pricePerPax = {{ $train->price }};
function calculateTotal() {
    const pax = parseInt(document.getElementById('passengers').value);
    const total = pax * pricePerPax;
    document.getElementById('total-display').textContent='Rp '+total.toLocaleString('id-ID');
    document.getElementById('total-note').textContent=pax+' penumpang × Rp '+pricePerPax.toLocaleString('id-ID');
}
</script>
@endsection