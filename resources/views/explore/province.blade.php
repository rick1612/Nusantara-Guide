@extends('layouts.app')
@section('title', $province->name . ' — NusantaraGuide')
@section('styles')
<style>
    .page-hero{background:linear-gradient(160deg,rgba(13,27,19,0.78) 0%,rgba(26,58,42,0.62) 100%),url('https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1400&q=80') center/cover no-repeat;padding:64px 8% 52px;}
    .breadcrumb{font-size:13px;color:rgba(255,255,255,0.6);display:flex;align-items:center;gap:8px;margin-bottom:16px;flex-wrap:wrap;}
    .breadcrumb a{color:rgba(255,255,255,0.6);text-decoration:none;}
    .breadcrumb a:hover{color:var(--lime);}
    .page-hero h1{font-family:'Playfair Display',serif;font-size:clamp(32px,5vw,56px);color:white;font-weight:900;margin-bottom:12px;}
    .page-hero p{font-size:16px;color:rgba(255,255,255,0.75);max-width:560px;line-height:1.7;}
    .regions-section{padding:48px 8% 0;}
    .section-label{font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--muted);margin-bottom:16px;}
    .regions-row{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:48px;}
    .region-chip{padding:9px 20px;border-radius:24px;border:1.5px solid #e0dbd2;font-size:14px;font-weight:500;color:var(--ink);text-decoration:none;background:white;transition:all 0.2s;display:flex;align-items:center;gap:8px;}
    .region-chip:hover{background:var(--jade);color:white;border-color:var(--jade);}
    .chip-count{background:var(--cream);color:var(--muted);font-size:11px;padding:2px 7px;border-radius:10px;font-weight:600;}
    .region-chip:hover .chip-count{background:rgba(255,255,255,0.2);color:white;}
    .places-section{padding:0 8% 60px;}
    .section-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px;}
    .section-title{font-family:'Playfair Display',serif;font-size:28px;font-weight:700;color:var(--forest);}
    .see-all-link{font-size:14px;font-weight:600;color:var(--jade);text-decoration:none;transition:gap 0.2s;display:flex;align-items:center;gap:4px;}
    .see-all-link:hover{gap:8px;}
    .place-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:22px;}
    .place-card{background:white;border-radius:16px;overflow:hidden;box-shadow:var(--card-shadow);transition:all 0.3s;display:flex;flex-direction:column;}
    .place-card:hover{transform:translateY(-6px);box-shadow:0 16px 40px rgba(26,58,42,0.15);}
    .place-card-img{position:relative;}
    .place-card-img img{width:100%;height:190px;object-fit:cover;display:block;}
    .place-cat-badge{position:absolute;top:12px;left:12px;background:rgba(255,255,255,0.92);backdrop-filter:blur(4px);padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;color:var(--forest);}
    .place-card-body{padding:18px 20px;flex:1;display:flex;flex-direction:column;}
    .place-region-tag{font-size:12px;color:var(--muted);margin-bottom:5px;}
    .place-card-body h3{font-size:16px;font-weight:600;color:var(--ink);margin-bottom:5px;line-height:1.3;}
    .place-card-body p{font-size:13px;color:var(--muted);line-height:1.6;flex:1;}
    .place-card-footer{display:flex;align-items:center;justify-content:space-between;margin-top:14px;padding-top:12px;border-top:1px solid #f5f5f5;}
    .place-price{font-size:14px;font-weight:700;color:var(--forest);}
    .btn-detail{font-size:13px;font-weight:600;color:white;background:var(--jade);padding:7px 16px;border-radius:8px;text-decoration:none;transition:background 0.2s;}
    .btn-detail:hover{background:var(--forest);}
    .empty-state{text-align:center;padding:60px 20px;grid-column:1/-1;}
    .empty-state .icon{font-size:48px;margin-bottom:14px;}
    .empty-state h3{font-family:'Playfair Display',serif;font-size:20px;color:var(--ink);margin-bottom:6px;}
    .empty-state p{font-size:14px;color:var(--muted);}
    @media(max-width:768px){.regions-section,.places-section{padding-left:5%;padding-right:5%;}.place-grid{grid-template-columns:1fr;}}
</style>
@endsection
@section('content')
<div class="page-hero">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a> /
        <a href="{{ route('explore') }}">Explore</a> /
        <span style="color:rgba(255,255,255,0.9);">{{ $province->name }}</span>
    </div>
    <h1>{{ $province->name }}</h1>
    <p>{{ $province->description ?? 'Temukan destinasi wisata terbaik di ' . $province->name . '.' }}</p>
</div>
<div class="regions-section">
    <div class="section-label">Wilayah di {{ $province->name }}</div>
    <div class="regions-row">
        <a href="{{ route('province.show', $province->slug) }}" class="region-chip" style="{{ !request('region') ? 'background:var(--forest);color:white;border-color:var(--forest);' : '' }}">
            Semua Wilayah <span class="chip-count">{{ $places->count() }}</span>
        </a>
        @foreach($regions as $region)
        <a href="{{ route('region.show', [$province->slug, $region->slug ?? $region->id]) }}" class="region-chip">
            {{ $region->name }} <span class="chip-count">{{ $region->places_count }}</span>
        </a>
        @endforeach
    </div>
</div>
<div class="places-section">
    <div class="section-header">
        <div class="section-title">Tempat Wisata di {{ $province->name }}</div>
        <a href="{{ route('places.browse', ['province' => $province->id]) }}" class="see-all-link">Lihat Semua →</a>
    </div>
    <div class="place-grid">
        @forelse($places as $place)
        <div class="place-card">
            <div class="place-card-img">
                <img src="{{ asset($place->image_url ?? 'images/default.jpg') }}" alt="{{ $place->name }}" onerror="this.style.height='190px';this.style.background='#e8f4ee';this.style.display='none';">
                @if($place->category)
                <span class="place-cat-badge">{{ $place->category->icon ?? '' }} {{ $place->category->name }}</span>
                @endif
            </div>
            <div class="place-card-body">
                <div class="place-region-tag">📍 {{ $place->region->name ?? '' }}</div>
                <h3>{{ $place->name }}</h3>
                <p>{{ Str::limit($place->description, 85) }}</p>
                <div class="place-card-footer">
                    <span class="place-price">@if($place->price_start == 0)Gratis @else Rp {{ number_format($place->price_start,0,',','.') }}@endif</span>
                    <a href="{{ route('place.show', $place->id) }}" class="btn-detail">Lihat Detail →</a>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state"><div class="icon">🗺️</div><h3>Belum ada tempat</h3><p>Belum ada destinasi yang terdaftar di {{ $province->name }}.</p></div>
        @endforelse
    </div>
</div>
@endsection