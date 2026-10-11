@extends('layouts.app')

@section('title', 'Booking Saya — NusantaraGuide')

@section('styles')
<style>
    .page-hero h1{font-family:'Playfair Display',serif;font-size:36px;color:white;font-weight:900;margin-bottom:6px;}
    .page-hero p{font-size:15px;color:rgba(255,255,255,0.7);}
    .tab-bar{background:white;border-bottom:2px solid #f0ede8;padding:0 8%;display:flex;position:sticky;top:64px;z-index:50;}
    .tab-btn{padding:16px 24px;font-size:14px;font-weight:600;color:var(--muted);background:none;border:none;border-bottom:3px solid transparent;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all 0.2s;margin-bottom:-2px;}
    .tab-btn.active{color:var(--jade);border-bottom-color:var(--jade);}
    .tab-content{display:none;}
    .tab-content.active{display:block;}
    .booking-list{display:flex;flex-direction:column;gap:16px;}
    .booking-card:hover{box-shadow:0 8px 32px rgba(26,58,42,0.15);}
    .booking-card-icon.flight-icon{background:linear-gradient(135deg,#0d1b35,#1a2d6a);}
    .booking-card-icon.train-icon{background:linear-gradient(135deg,#1a1a35,#2d1a6a);}
    .booking-meta-item{font-size:13px;color:var(--muted);}
    .booking-meta-item strong{color:var(--ink);}
    .btn-sm-danger:hover{background:var(--coral);color:white;}
    .empty-state .icon{font-size:48px;margin-bottom:14px;}
    .empty-state h3{font-family:'Playfair Display',serif;font-size:20px;color:var(--ink);margin-bottom:6px;}
    .empty-state p{font-size:14px;color:var(--muted);margin-bottom:20px;}
    .btn-explore{background:var(--jade);color:white;padding:12px 28px;border-radius:10px;font-size:14px;font-weight:600;text-decoration:none;display:inline-block;}
</style>
@endsection

@section('content')
<div class="page-hero">
    <h1>Booking Saya</h1>
    <p>Semua pemesanan hotel dan transportasimu dalam satu tempat.</p>
</div>

<div class="tab-bar">
    <button class="tab-btn active" onclick="switchTab('hotel',this)">🏨 Hotel ({{ $bookings->total() }})</button>
    <button class="tab-btn" onclick="switchTab('flight',this)">✈️ Pesawat ({{ $flightBookings->count() }})</button>
    <button class="tab-btn" onclick="switchTab('train',this)">🚆 Kereta ({{ $trainBookings->count() }})</button>
</div>

<div class="main">
    @if(session('success'))<div class="alert-success">✓ {{ session('success') }}</div>@endif

    <div class="tab-content active" id="tab-hotel">
        @if($bookings->count())
        <div class="booking-list">
            @foreach($bookings as $b)
            <div class="booking-card">
                <div class="booking-card-icon">🏨</div>
                <div class="booking-card-body">
                    <div class="booking-main-title">{{ $b->place->name ?? '-' }}</div>
                    <div class="booking-sub">🛏️ {{ $b->room->name ?? '-' }}</div>
                    <div class="booking-meta">
                        <div class="booking-meta-item">📅 <strong>{{ $b->check_in->isoFormat('D MMM Y') }}</strong> → <strong>{{ $b->check_out->isoFormat('D MMM Y') }}</strong></div>
                        <div class="booking-meta-item">👥 {{ $b->guests }} tamu · {{ $b->nights }} malam</div>
                    </div>
                </div>
                <div class="booking-card-right">
                    <span class="status-pill" style="background:{{ $b->status_color }}22;color:{{ $b->status_color }};border:1px solid {{ $b->status_color }}44;">{{ $b->status_label }}</span>
                    <div><div class="booking-total">{{ $b->total_label }}</div><div class="booking-code">{{ $b->booking_code }}</div></div>
                    <div class="booking-actions">
                        <a href="{{ route('bookings.show', $b->id) }}" class="btn-sm btn-sm-primary">Detail</a>
                        @if($b->status === 'pending')
                        <form action="{{ route('booking.cancel', $b->id) }}" method="POST" onsubmit="return confirm('Batalkan?')">
                            @csrf<button type="submit" class="btn-sm btn-sm-danger" style="width:100%;">Batalkan</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div style="margin-top:24px;">{{ $bookings->links() }}</div>
        @else
        <div class="empty-state"><div class="icon">🏨</div><h3>Belum ada booking hotel</h3><p>Temukan hotel terbaik di Indonesia.</p><a href="{{ route('places.browse', ['category'=>3]) }}" class="btn-explore">Cari Hotel →</a></div>
        @endif
    </div>

    <div class="tab-content" id="tab-flight">
        @if($flightBookings->count())
        <div class="booking-list">
            @foreach($flightBookings as $b)
            <div class="booking-card">
                <div class="booking-card-icon flight-icon">✈️</div>
                <div class="booking-card-body">
                    <div class="booking-main-title">{{ optional($b->flight->origin)->city ?? '-' }} → {{ optional($b->flight->destination)->city ?? '-' }}</div>
                    <div class="booking-sub">{{ $b->flight->airline->name }} · {{ $b->flight->flight_number }}</div>
                    <div class="booking-meta">
                        <div class="booking-meta-item">📅 <strong>{{ $b->travel_date->isoFormat('D MMM Y') }}</strong></div>
                        <div class="booking-meta-item">🕐 {{ substr($b->flight->departure_time,0,5) }}</div>
                        <div class="booking-meta-item">👥 {{ $b->passengers }} penumpang</div>
                    </div>
                </div>
                <div class="booking-card-right">
                    <span class="status-pill" style="background:{{ $b->status_color }}22;color:{{ $b->status_color }};border:1px solid {{ $b->status_color }}44;">{{ $b->status_label }}</span>
                    <div><div class="booking-total">{{ $b->total_label }}</div><div class="booking-code">{{ $b->booking_code }}</div></div>
                    <div class="booking-actions">
                        @if($b->status === 'pending')
                        <form action="{{ route('transportation.flight.cancel', $b->id) }}" method="POST" onsubmit="return confirm('Batalkan tiket?')">
                            @csrf<button type="submit" class="btn-sm btn-sm-danger" style="width:100%;">Batalkan</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state"><div class="icon">✈️</div><h3>Belum ada tiket pesawat</h3><p>Cari dan pesan tiket ke seluruh Indonesia.</p><a href="{{ route('transportation.index', ['type'=>'flight']) }}" class="btn-explore">Cari Pesawat →</a></div>
        @endif
    </div>

    <div class="tab-content" id="tab-train">
        @if($trainBookings->count())
        <div class="booking-list">
            @foreach($trainBookings as $b)
            <div class="booking-card">
                <div class="booking-card-icon train-icon">🚆</div>
                <div class="booking-card-body">
                    <div class="booking-main-title">{{ $b->train->name }}</div>
                    <div class="booking-sub">{{ optional($b->train->origin)->city ?? '-' }} → {{ optional($b->train->destination)->city ?? '-' }}</div>
                    <div class="booking-meta">
                        <div class="booking-meta-item">📅 <strong>{{ $b->travel_date->isoFormat('D MMM Y') }}</strong></div>
                        <div class="booking-meta-item">🕐 {{ substr($b->train->departure_time,0,5) }}</div>
                        <div class="booking-meta-item">👥 {{ $b->passengers }} penumpang · {{ $b->train->class }}</div>
                    </div>
                </div>
                <div class="booking-card-right">
                    <span class="status-pill" style="background:{{ $b->status_color }}22;color:{{ $b->status_color }};border:1px solid {{ $b->status_color }}44;">{{ $b->status_label }}</span>
                    <div><div class="booking-total">{{ $b->total_label }}</div><div class="booking-code">{{ $b->booking_code }}</div></div>
                    <div class="booking-actions">
                        @if($b->status === 'pending')
                        <form action="{{ route('transportation.train.cancel', $b->id) }}" method="POST" onsubmit="return confirm('Batalkan tiket?')">
                            @csrf<button type="submit" class="btn-sm btn-sm-danger" style="width:100%;">Batalkan</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state"><div class="icon">🚆</div><h3>Belum ada tiket kereta</h3><p>Pesan tiket kereta api lintas kota.</p><a href="{{ route('transportation.index', ['type'=>'train']) }}" class="btn-explore">Cari Kereta →</a></div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
function switchTab(tab, btn) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.add('active');
    btn.classList.add('active');
}
</script>
@endsection