@extends('layouts.app')
@section('title', 'Eksplorasi Indonesia — NusantaraGuide')
@section('styles')
<style>
    .page-hero{background:linear-gradient(135deg,var(--forest) 0%,#2d5a3d 100%);padding:60px 8% 50px;text-align:center;}
    .page-hero h1{font-family:'Playfair Display',serif;font-size:clamp(32px,5vw,56px);color:white;font-weight:900;margin-bottom:12px;}
    .page-hero p{font-size:17px;color:rgba(255,255,255,0.72);max-width:520px;margin:0 auto 28px;line-height:1.7;}
    .island-stats{display:flex;justify-content:center;gap:48px;flex-wrap:wrap;}
    .island-stat{text-align:center;}
    .island-stat .num{font-family:'Playfair Display',serif;font-size:32px;color:var(--gold);font-weight:900;}
    .island-stat .lbl{font-size:12px;color:rgba(255,255,255,0.55);letter-spacing:1px;text-transform:uppercase;margin-top:4px;}
    .section{padding:56px 8%;}
    .section-tag{font-size:12px;font-weight:600;letter-spacing:2px;text-transform:uppercase;color:var(--jade);display:flex;align-items:center;gap:8px;margin-bottom:10px;}
    .section-tag::before{content:'';width:24px;height:2px;background:var(--jade);}
    .section-title{font-family:'Playfair Display',serif;font-size:clamp(24px,4vw,36px);font-weight:700;color:var(--forest);margin-bottom:36px;}
    .province-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:22px;}
    .province-card{border-radius:18px;overflow:hidden;position:relative;height:220px;text-decoration:none;display:block;transition:transform 0.3s,box-shadow 0.3s;background:var(--forest);}
    .province-card:hover{transform:translateY(-7px);box-shadow:0 20px 48px rgba(0,0,0,0.22);}
    .province-card img{width:100%;height:100%;object-fit:cover;opacity:0.75;transition:transform 0.4s,opacity 0.3s;}
    .province-card:hover img{transform:scale(1.06);opacity:0.65;}
    .province-card-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(13,27,19,0.88) 0%,rgba(0,0,0,0.05) 55%);padding:20px;display:flex;flex-direction:column;justify-content:flex-end;}
    .province-name{font-family:'Playfair Display',serif;font-size:21px;color:white;font-weight:700;line-height:1.2;}
    .province-meta{display:flex;align-items:center;gap:12px;margin-top:6px;}
    .province-count{font-size:13px;color:rgba(255,255,255,0.65);}
    .province-arrow{margin-left:auto;background:rgba(255,255,255,0.15);border-radius:50%;width:32px;height:32px;display:flex;align-items:center;justify-content:center;font-size:14px;color:white;transition:background 0.2s;}
    .province-card:hover .province-arrow{background:var(--coral);}
    .gradient-card{width:100%;height:100%;display:block;}
    @media(max-width:768px){.section{padding:40px 5%;}.province-grid{grid-template-columns:1fr 1fr;gap:14px;}.province-card{height:160px;}.island-stats{gap:24px;}}
</style>
@endsection
@section('content')
<div class="page-hero">
    <h1>Explore Indonesia 🌏</h1>
    <p>Dari Sabang sampai Merauke — temukan keindahan di setiap sudut Nusantara.</p>
    <div class="island-stats">
        <div class="island-stat"><div class="num">34</div><div class="lbl">Provinsi</div></div>
        <div class="island-stat"><div class="num">17.504</div><div class="lbl">Pulau</div></div>
        <div class="island-stat"><div class="num">500+</div><div class="lbl">Destinasi</div></div>
    </div>
</div>
<div class="section">
    <div class="section-tag">Destinasi</div>
    <div class="section-title">Semua Provinsi</div>
    <div class="province-grid">
        @forelse($provinces as $province)
        <a href="{{ route('province.show', $province->slug) }}" class="province-card">
            @if($province->image_url)
                <img src="{{ asset($province->image_url) }}" alt="{{ $province->name }}">
            @else
                <div class="gradient-card" style="background:linear-gradient(135deg,{{ ['#1a3a2a','#2d4a3a','#1e4a34','#2a3d2a','#163020','#243828','#1c3a24','#2d3e30','#1a2e22','#263a2c'][$loop->index % 10] }},{{ ['#2d6a4f','#3d7a5f','#257a4f','#3a6a4f','#265a3f','#346054','#2a6044','#3a5a44','#2a5a3a','#336048'][$loop->index % 10] }});"></div>
            @endif
            <div class="province-card-overlay">
                <div class="province-name">{{ $province->name }}</div>
                <div class="province-meta">
                    <span class="province-count">{{ $province->regions_count ?? 0 }} wilayah</span>
                    <span class="province-arrow">→</span>
                </div>
            </div>
        </a>
        @empty
        <p style="color:var(--muted);grid-column:1/-1;">Belum ada data provinsi.</p>
        @endforelse
    </div>
</div>
@endsection