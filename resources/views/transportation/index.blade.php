@extends('layouts.app')
@section('title', 'Transportasi — NusantaraGuide')
@section('styles')
<style>

    .hero {
        background: linear-gradient(135deg,#0d1b35 0%,#1a2d6a 100%);
        padding: 52px 8% 0 !important;
        text-align: center !important;
        min-height: auto !important;
        height: auto !important;
        display: block !important;
        align-items: unset !important;
        padding-left: 8% !important;
    }
    .hero h1{font-family:'Playfair Display',serif;font-size:clamp(28px,5vw,48px);color:white;font-weight:900;margin-bottom:10px;}
    .hero p{font-size:15px;color:rgba(255,255,255,0.7);margin-bottom:32px;}
    body .type-tabs{display:inline-flex;background:rgba(255,255,255,0.1);border-radius:12px;padding:4px;margin-bottom:28px;}
    body .type-tab{padding:10px 28px;border-radius:9px;font-size:14px;font-weight:600;cursor:pointer;text-decoration:none;color:rgba(255,255,255,0.65);transition:all 0.2s;}
    .type-tab.active{background:white;color:var(--ink);}
    body .search-card{background:white;border-radius:18px 18px 0 0;padding:28px 32px;max-width:900px;margin:0 auto;box-shadow:0 -4px 32px rgba(0,0,0,0.1);}
    .search-grid{display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:12px;align-items:end;}
    .form-group label{display:block;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-bottom:6px;}
    .form-group select,.form-group input{width:100%;padding:12px 14px;border:1.5px solid #e0dbd2;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--ink);background:var(--cream);outline:none;transition:border-color 0.2s;}
    .form-group select:focus,.form-group input:focus{border-color:var(--jade);background:white;}
    .passengers-row{display:flex;gap:12px;margin-top:12px;align-items:center;}
    .passengers-row label{font-size:12px;color:var(--muted);font-weight:600;}
    .passengers-row select{padding:8px 12px;border:1.5px solid #e0dbd2;border-radius:8px;font-size:13px;background:var(--cream);}
    .class-toggle{display:flex;gap:8px;}
    .class-btn{padding:8px 16px;border-radius:8px;border:1.5px solid #e0dbd2;font-size:13px;font-weight:600;cursor:pointer;background:white;color:var(--muted);font-family:'DM Sans',sans-serif;transition:all 0.2s;}
    .class-btn.active,.class-btn:hover{background:var(--jade);color:white;border-color:var(--jade);}
    .search-btn{background:var(--coral);color:white;border:none;padding:13px 28px;border-radius:10px;font-size:15px;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;white-space:nowrap;transition:background 0.2s;height:48px;}
    .search-btn:hover{background:#d4604a;}
    .results-section{padding:0 8% 60px;max-width:1100px;margin:0 auto;}
    .results-header{padding:24px 0 20px;display:flex;align-items:center;justify-content:space-between;}
    .results-title{font-family:'Playfair Display',serif;font-size:22px;font-weight:700;color:var(--forest);}
    .results-count{font-size:14px;color:var(--muted);}
    .transport-card{background:white;border-radius:16px;padding:24px;box-shadow:var(--card-shadow);margin-bottom:16px;display:flex;align-items:center;gap:24px;transition:all 0.2s;}
    .transport-card:hover{box-shadow:0 8px 32px rgba(26,58,42,0.15);transform:translateY(-2px);}
    .airline-logo{width:52px;height:52px;border-radius:10px;background:var(--cream);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:var(--jade);border:1px solid #e8e3da;flex-shrink:0;text-align:center;line-height:1.3;}
    .flight-times{flex:1;}
    .time-row{display:flex;align-items:center;gap:16px;}
    .time-big{font-family:'Playfair Display',serif;font-size:26px;font-weight:900;color:var(--ink);}
    .time-arrow{flex:1;display:flex;align-items:center;gap:8px;color:var(--muted);}
    .time-arrow::before,.time-arrow::after{content:'';flex:1;height:1px;background:#e0dbd2;}
    .duration-label{font-size:12px;color:var(--muted);white-space:nowrap;}
    .airport-label{font-size:12px;color:var(--muted);margin-top:3px;}
    .flight-info{display:flex;gap:16px;margin-top:8px;flex-wrap:wrap;}
    .flight-badge{font-size:11px;background:var(--cream);color:var(--muted);padding:3px 10px;border-radius:20px;font-weight:600;}
    .price-col{text-align:right;flex-shrink:0;min-width:160px;}
    .price-from{font-size:11px;color:var(--muted);margin-bottom:2px;}
    .price-amount{font-family:'Playfair Display',serif;font-size:22px;font-weight:900;color:var(--forest);}
    .price-class{font-size:11px;color:var(--muted);margin-bottom:12px;}
    .book-btn{display:block;background:var(--coral);color:white;padding:10px 20px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;text-align:center;transition:background 0.2s;}
    .book-btn:hover{background:#d4604a;}
    .book-btn-outline{display:block;background:white;color:var(--jade);border:1.5px solid var(--jade);padding:8px 20px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;text-align:center;margin-top:6px;transition:all 0.2s;}
    .book-btn-outline:hover{background:var(--jade);color:white;}
    .train-name{font-size:16px;font-weight:700;color:var(--ink);margin-bottom:2px;}
    .train-class-badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;margin-bottom:10px;}
    .eksekutif{background:rgba(233,196,106,0.2);color:#a0760a;}
    .bisnis{background:rgba(45,106,79,0.1);color:var(--jade);}
    .ekonomi{background:rgba(107,124,114,0.1);color:var(--muted);}
    .no-results{text-align:center;padding:60px 20px;background:white;border-radius:16px;}
    .no-results .icon{font-size:48px;margin-bottom:14px;}
    .no-results h3{font-family:'Playfair Display',serif;font-size:20px;color:var(--ink);margin-bottom:6px;}
    .no-results p{font-size:14px;color:var(--muted);}
    .intro-section{padding:40px 8% 60px;text-align:center;}
    .intro-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:20px;max-width:900px;margin:32px auto 0;}
    .intro-card{background:white;border-radius:14px;padding:24px;box-shadow:var(--card-shadow);}
    .intro-card .icon{font-size:36px;margin-bottom:12px;}
    .intro-card h3{font-size:16px;font-weight:700;color:var(--forest);margin-bottom:6px;}
    .intro-card p{font-size:13px;color:var(--muted);line-height:1.6;}
    @media(max-width:768px){.search-grid{grid-template-columns:1fr;}.transport-card{flex-direction:column;align-items:flex-start;}.price-col{text-align:left;width:100%;}.results-section{padding:0 5% 40px;}}
</style>
@endsection
@section('content')
<div class="hero">
    <h1>✈️ Cari Transportasi</h1>
    <p>Pesan tiket pesawat dan kereta api ke seluruh Indonesia</p>
    <div class="type-tabs">
        <a href="{{ route('transportation.index', array_merge(request()->all(), ['type'=>'flight'])) }}" class="type-tab {{ $type === 'flight' ? 'active' : '' }}">✈️ Pesawat</a>
        <a href="{{ route('transportation.index', array_merge(request()->all(), ['type'=>'train'])) }}" class="type-tab {{ $type === 'train' ? 'active' : '' }}">🚆 Kereta Api</a>
    </div>
    <div class="search-card">
        <form action="{{ route('transportation.index') }}" method="GET" id="searchForm">
            <input type="hidden" name="type" value="{{ $type }}">
            @if($type === 'flight')
            <div class="search-grid">
                <div class="form-group"><label>Dari</label><select name="from" required><option value="">Pilih bandara asal</option>@foreach($airports as $ap)<option value="{{ $ap->id }}" {{ request('from') == $ap->id ? 'selected' : '' }}>{{ $ap->code }} — {{ $ap->city }}</option>@endforeach</select></div>
                <div class="form-group"><label>Ke</label><select name="to" required><option value="">Pilih bandara tujuan</option>@foreach($airports as $ap)<option value="{{ $ap->id }}" {{ request('to') == $ap->id ? 'selected' : '' }}>{{ $ap->code }} — {{ $ap->city }}</option>@endforeach</select></div>
                <div class="form-group"><label>Tanggal Berangkat</label><input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required></div>
                <button type="submit" class="search-btn">🔍 Cari</button>
            </div>
            <div class="passengers-row">
                <label>Penumpang:</label>
                <select name="passengers">@for($i=1;$i<=9;$i++)<option value="{{ $i }}" {{ request('passengers',1)==$i?'selected':'' }}>{{ $i }} orang</option>@endfor</select>
                <label style="margin-left:16px;">Kelas:</label>
                <div class="class-toggle">
                    <button type="button" class="class-btn {{ request('class','economy')==='economy'?'active':'' }}" onclick="setClass('economy',this)">Ekonomi</button>
                    <button type="button" class="class-btn {{ request('class')==='business'?'active':'' }}" onclick="setClass('business',this)">Bisnis</button>
                    <input type="hidden" name="class" id="classInput" value="{{ request('class','economy') }}">
                </div>
            </div>
            @else
            <div class="search-grid">
                <div class="form-group"><label>Dari</label><select name="from" required><option value="">Pilih stasiun asal</option>@foreach($stations as $st)<option value="{{ $st->id }}" {{ request('from') == $st->id ? 'selected' : '' }}>{{ $st->name }} ({{ $st->city }})</option>@endforeach</select></div>
                <div class="form-group"><label>Ke</label><select name="to" required><option value="">Pilih stasiun tujuan</option>@foreach($stations as $st)<option value="{{ $st->id }}" {{ request('to') == $st->id ? 'selected' : '' }}>{{ $st->name }} ({{ $st->city }})</option>@endforeach</select></div>
                <div class="form-group"><label>Tanggal Berangkat</label><input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required></div>
                <button type="submit" class="search-btn">🔍 Cari</button>
            </div>
            <div class="passengers-row">
                <label>Penumpang:</label>
                <select name="passengers">@for($i=1;$i<=9;$i++)<option value="{{ $i }}" {{ request('passengers',1)==$i?'selected':'' }}>{{ $i }} orang</option>@endfor</select>
            </div>
            @endif
        </form>
    </div>
</div>
<div class="results-section">
    @if($searched)
        @if($type === 'flight')
            @if($flights->count())
            <div class="results-header">
                <div class="results-title">{{ $flights->count() }} Penerbangan Tersedia</div>
                <div class="results-count">{{ \Carbon\Carbon::parse(request('date'))->isoFormat('D MMMM YYYY') }}</div>
            </div>
            @foreach($flights as $flight)
            <div class="transport-card">
                <div class="airline-logo">{{ $flight->airline->code }}<br>✈</div>
                <div class="flight-times" style="flex:1;">
                    <div class="time-row">
                        <div><div class="time-big">{{ substr($flight->departure_time,0,5) }}</div><div class="airport-label">{{ $flight->origin->code }} · {{ $flight->origin->city }}</div></div>
                        <div class="time-arrow"><span class="duration-label">{{ $flight->duration_label }}</span></div>
                        <div style="text-align:right;"><div class="time-big">{{ substr($flight->arrival_time,0,5) }}</div><div class="airport-label" style="text-align:right;">{{ $flight->destination->code }} · {{ $flight->destination->city }}</div></div>
                    </div>
                    <div class="flight-info"><span class="flight-badge">{{ $flight->airline->name }}</span><span class="flight-badge">{{ $flight->flight_number }}</span><span class="flight-badge">Langsung</span></div>
                </div>
                <div class="price-col">
                    <div class="price-from">Mulai dari</div>
                    <div class="price-amount">{{ $flight->price_economy_label }}</div>
                    <div class="price-class">/ orang · Ekonomi</div>
                    @auth
                    <a href="{{ route('transportation.flight.book', ['flight'=>$flight->id,'date'=>request('date'),'class'=>request('class','economy'),'passengers'=>request('passengers',1)]) }}" class="book-btn">Pesan →</a>
                    @if($flight->price_business)<a href="{{ route('transportation.flight.book', ['flight'=>$flight->id,'date'=>request('date'),'class'=>'business','passengers'=>request('passengers',1)]) }}" class="book-btn-outline">Bisnis {{ $flight->price_business_label }}</a>@endif
                    @else
                    <a href="{{ route('login') }}" class="book-btn">Login untuk Pesan</a>
                    @endauth
                </div>
            </div>
            @endforeach
            @else
            <div class="no-results" style="margin-top:24px;"><div class="icon">✈️</div><h3>Tidak ada penerbangan ditemukan</h3><p>Coba tanggal lain atau rute berbeda.</p></div>
            @endif
        @else
            @if($trains->count())
            <div class="results-header">
                <div class="results-title">{{ $trains->count() }} Kereta Tersedia</div>
                <div class="results-count">{{ \Carbon\Carbon::parse(request('date'))->isoFormat('D MMMM YYYY') }}</div>
            </div>
            @foreach($trains as $train)
            <div class="transport-card">
                <div class="airline-logo" style="font-size:24px;">🚆</div>
                <div style="flex:1;">
                    <div class="train-name">{{ $train->name }}</div>
                    <span class="train-class-badge {{ strtolower($train->class) }}">{{ $train->class }}</span>
                    <div class="time-row">
                        <div><div class="time-big">{{ substr($train->departure_time,0,5) }}</div><div class="airport-label">{{ $train->origin->name }}</div></div>
                        <div class="time-arrow"><span class="duration-label">{{ $train->duration_label }}</span></div>
                        <div style="text-align:right;"><div class="time-big">{{ substr($train->arrival_time,0,5) }}</div><div class="airport-label" style="text-align:right;">{{ $train->destination->name }}</div></div>
                    </div>
                </div>
                <div class="price-col">
                    <div class="price-from">Harga</div>
                    <div class="price-amount">{{ $train->price_label }}</div>
                    <div class="price-class">/ orang</div>
                    @auth
                    <a href="{{ route('transportation.train.book', ['train'=>$train->id,'date'=>request('date'),'passengers'=>request('passengers',1)]) }}" class="book-btn">Pesan →</a>
                    @else
                    <a href="{{ route('login') }}" class="book-btn">Login untuk Pesan</a>
                    @endauth
                </div>
            </div>
            @endforeach
            @else
            <div class="no-results" style="margin-top:24px;"><div class="icon">🚆</div><h3>Tidak ada kereta ditemukan</h3><p>Coba rute atau tanggal berbeda.</p></div>
            @endif
        @endif
    @else
    <div class="intro-section">
        <p style="color:var(--muted);font-size:15px;">Pilih asal, tujuan, dan tanggal untuk melihat jadwal dan harga.</p>
        <div class="intro-grid">
            <div class="intro-card"><div class="icon">✈️</div><h3>Pesawat</h3><p>6 maskapai, 16 rute tersedia ke kota-kota utama Indonesia.</p></div>
            <div class="intro-card"><div class="icon">🚆</div><h3>Kereta Api</h3><p>12 jadwal kereta dari Eksekutif hingga Ekonomi lintas Jawa.</p></div>
            <div class="intro-card"><div class="icon">🔖</div><h3>E-Tiket</h3><p>Kode booking langsung tersimpan di akunmu.</p></div>
        </div>
    </div>
    @endif
</div>
@endsection
@section('scripts')
<script>
function setClass(val, btn) {
    document.getElementById('classInput').value = val;
    document.querySelectorAll('.class-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}
</script>
@endsection