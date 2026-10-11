@extends('layouts.app')
@section('title', 'Panduan Musim Wisata Indonesia — NusantaraGuide')
@section('styles')
<style>

    body .hero{background:linear-gradient(135deg,#0d1b35 0%,#1a2d6a 100%);padding:56px 8% 48px;text-align:center;}
    .hero h1{font-family:'Playfair Display',serif;font-size:clamp(28px,5vw,48px);color:white;font-weight:900;margin-bottom:10px;}
    .hero p{font-size:16px;color:rgba(255,255,255,0.75);max-width:560px;margin:0 auto 32px;}
    body .picker-wrap{max-width:700px;margin:0 auto;}
    body .picker-card{background:white;border-radius:16px;padding:28px;box-shadow:0 8px 40px rgba(0,0,0,0.15);}
    .picker-card h3{font-size:16px;font-weight:700;color:var(--ink);margin-bottom:16px;}
    .picker-form{display:flex;gap:12px;}
    .picker-select{flex:1;padding:12px 16px;border:1.5px solid #e0dbd2;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:15px;color:var(--ink);background:var(--cream);outline:none;}
    .picker-btn{background:var(--coral);color:white;border:none;padding:12px 28px;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:15px;font-weight:700;cursor:pointer;white-space:nowrap;transition:background 0.2s;}
    .picker-btn:hover{background:#d4604a;}
    .main{padding:60px 8%;}
    .section-tag{font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--jade);display:flex;align-items:center;gap:8px;margin-bottom:10px;}
    .section-tag::before{content:'';width:20px;height:2px;background:var(--jade);}
    .section-title{font-family:'Playfair Display',serif;font-size:clamp(22px,3vw,32px);color:var(--forest);margin-bottom:28px;}
    .month-now{font-size:15px;color:var(--muted);margin-bottom:32px;}
    .month-now strong{color:var(--jade);}
    body .quick-cards{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px;margin-bottom:48px;}
    .quick-card{background:white;border-radius:16px;overflow:hidden;box-shadow:var(--card-shadow);text-decoration:none;color:inherit;display:block;transition:all 0.3s;}
    .quick-card:hover{transform:translateY(-5px);box-shadow:0 12px 32px rgba(26,58,42,0.15);}
    .qc-img{height:160px;position:relative;overflow:hidden;background:linear-gradient(135deg,var(--jade),var(--forest));}
    .qc-img img{width:100%;height:100%;object-fit:cover;}
    .qc-now-badge{position:absolute;top:12px;right:12px;background:var(--coral);color:white;font-size:11px;font-weight:700;padding:4px 10px;border-radius:20px;}
    .qc-body{padding:16px 18px;}
    .qc-name{font-family:'Playfair Display',serif;font-size:17px;font-weight:700;color:var(--forest);margin-bottom:6px;}
    .qc-status{display:flex;align-items:center;gap:6px;font-size:13px;color:var(--muted);}
    .weather-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0;}
    .dot-cerah{background:#22c55e;}
    .dot-berawan{background:#f59e0b;}
    .dot-hujan{background:#3b82f6;}
    .crowd-bar{height:4px;background:#f0ede8;border-radius:2px;overflow:hidden;margin-top:8px;}
    .crowd-fill{height:100%;border-radius:2px;}
    .fill-sepi{background:#22c55e;width:25%;}
    .fill-sedang{background:#f59e0b;width:55%;}
    .fill-ramai{background:#f97316;width:75%;}
    .fill-sangat{background:#ef4444;width:95%;}
    .info-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;}
    .info-card{background:white;border-radius:14px;padding:22px;box-shadow:var(--card-shadow);text-align:center;}
    .info-icon{font-size:32px;margin-bottom:10px;}
    .info-title{font-size:14px;font-weight:700;color:var(--forest);margin-bottom:6px;}
    .info-text{font-size:13px;color:var(--muted);line-height:1.6;}
    @media(max-width:700px){.picker-form{flex-direction:column;}.info-grid{grid-template-columns:1fr;}}
</style>
@endsection
@section('content')
<div class="hero">
    <h1>🗓️ Panduan Musim Wisata</h1>
    <p>Kapan waktu terbaik mengunjungi setiap provinsi di Indonesia? Temukan panduan cuaca, keramaian, harga, dan festival.</p>
    <div class="picker-wrap">
        <div class="picker-card">
            <h3>Pilih Destinasimu</h3>
            <form action="{{ route('seasonal.show') }}" method="GET" class="picker-form">
                <select name="province" class="picker-select" required>
                    <option value="">Pilih provinsi...</option>
                    @foreach($provinces as $p)
                    <option value="{{ $p->slug }}">{{ $p->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="picker-btn">Lihat Panduan →</button>
            </form>
        </div>
    </div>
</div>

<div class="main">
    <div class="section-tag">Sekarang</div>
    @php
    $monthNames = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
    @endphp
    <div class="section-title">Kondisi Sekarang — {{ $monthNames[$currentMonth] }}</div>
    <p class="month-now">Bulan ini adalah <strong>{{ $monthNames[$currentMonth] }}</strong>. Berikut kondisi terkini di destinasi populer:</p>

    <div class="quick-cards">
        @foreach($provinces->take(8) as $p)
        @php
        $seasonal = \App\Http\Controllers\SeasonalGuideController::SEASONAL_DATA[$p->slug]
            ?? \App\Http\Controllers\SeasonalGuideController::SEASONAL_DATA['default'];
        $monthData = $seasonal['monthly'][$currentMonth];
        $isBest = in_array($currentMonth, $seasonal['best_months']);
        @endphp
        <a href="{{ route('seasonal.show', ['province'=>$p->slug]) }}" class="quick-card">
            <div class="qc-img">
                @if($p->image_url)<img src="{{ asset($p->image_url) }}" alt="{{ $p->name }}" onerror="this.style.display='none'">@endif
                @if($isBest)<span class="qc-now-badge">✓ Waktu Terbaik</span>@endif
            </div>
            <div class="qc-body">
                <div class="qc-name">{{ $p->name }}</div>
                <div class="qc-status">
                    <span class="weather-dot dot-{{ $monthData['weather'] }}"></span>
                    {{ ucfirst($monthData['weather']) }} · Harga {{ $monthData['price'] }}
                </div>
                <div class="crowd-bar"><div class="crowd-fill fill-{{ str_replace(' ','',strtolower($monthData['crowd'])) }}"></div></div>
                <div style="font-size:11px;color:var(--muted);margin-top:4px;">Keramaian: {{ $monthData['crowd'] }}</div>
            </div>
        </a>
        @endforeach
    </div>

    <div class="section-tag">Tips Umum</div>
    <div class="section-title">Memahami Musim di Indonesia</div>
    <div class="info-grid">
        <div class="info-card"><div class="info-icon">☀️</div><div class="info-title">Musim Kering (Apr–Okt)</div><div class="info-text">Waktu terbaik untuk sebagian besar destinasi. Cuaca cerah, ideal untuk pantai, gunung, dan wisata outdoor.</div></div>
        <div class="info-card"><div class="info-icon">🌧️</div><div class="info-title">Musim Hujan (Nov–Mar)</div><div class="info-text">Harga lebih murah 30–50%, destinasi lebih sepi. Cocok untuk wisata budaya, spa, dan alam yang tetap indah meski hujan.</div></div>
        <div class="info-card"><div class="info-icon">🎉</div><div class="info-title">Festival & Libur Nasional</div><div class="info-text">Lebaran, Natal, dan tahun baru selalu ramai dan mahal. Pesan tiket 2-3 bulan lebih awal untuk harga terbaik.</div></div>
    </div>
</div>
@endsection