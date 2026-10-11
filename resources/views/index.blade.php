@extends('layouts.app')
@section('title', 'NusantaraGuide — Jelajahi Indonesia')
@section('styles')
<style>
    .hero{min-height:calc(100vh - 64px);background:linear-gradient(160deg,rgba(13,27,19,0.72) 0%,rgba(26,58,42,0.55) 100%),url('https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1600&q=80') center/cover no-repeat;display:flex;flex-direction:column;justify-content:center;padding:100px 8% 60px;position:relative;overflow:hidden;}
    .hero::after{content:'';position:absolute;bottom:0;left:0;right:0;height:120px;background:linear-gradient(to top,var(--cream),transparent);}
    .hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(233,196,106,0.2);border:1px solid rgba(233,196,106,0.4);color:var(--gold);padding:6px 16px;border-radius:20px;font-size:13px;font-weight:600;letter-spacing:0.5px;margin-bottom:24px;width:fit-content;}
    .hero h1{font-family:'Playfair Display',serif;font-size:clamp(42px,7vw,80px);font-weight:900;color:white;line-height:1.1;margin-bottom:20px;max-width:700px;}
    .hero h1 em{color:var(--gold);font-style:normal;}
    .hero p{font-size:18px;color:rgba(255,255,255,0.8);max-width:520px;line-height:1.7;margin-bottom:40px;}
    .hero-actions{display:flex;gap:16px;flex-wrap:wrap;position:relative;z-index:1;}
    .btn-primary{background:var(--coral);color:white;padding:16px 36px;border-radius:8px;font-size:16px;font-weight:600;text-decoration:none;transition:all 0.2s;display:inline-block;}
    .btn-primary:hover{background:#d4604a;transform:translateY(-2px);}
    .btn-outline{background:rgba(255,255,255,0.1);color:white;padding:16px 36px;border-radius:8px;font-size:16px;font-weight:600;text-decoration:none;transition:all 0.2s;border:1px solid rgba(255,255,255,0.35);}
    .btn-outline:hover{background:rgba(255,255,255,0.2);}
    .search-wrap{max-width:620px;margin-bottom:32px;display:flex;gap:0;background:white;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.2);}
    .search-wrap input{flex:1;padding:16px 20px;font-size:15px;border:none;outline:none;font-family:'DM Sans',sans-serif;color:var(--ink);}
    .search-wrap button{background:var(--coral);color:white;border:none;padding:0 28px;font-size:15px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;transition:background 0.2s;}
    .search-wrap button:hover{background:#d4604a;}
    .stats-bar{background:var(--forest);color:white;display:flex;justify-content:center;gap:0;overflow:hidden;}
    .stat-item{padding:20px 48px;text-align:center;border-right:1px solid rgba(255,255,255,0.08);}
    .stat-item:last-child{border-right:none;}
    .stat-num{font-family:'Playfair Display',serif;font-size:28px;color:var(--gold);font-weight:700;}
    .stat-label{font-size:12px;color:rgba(255,255,255,0.5);margin-top:2px;letter-spacing:0.5px;text-transform:uppercase;}
    .section{padding:80px 8%;}
    .section + .section{padding-top:40px;}
    .section-header{margin-bottom:48px;}
    .section-tag{font-size:12px;font-weight:600;letter-spacing:2px;text-transform:uppercase;color:var(--jade);display:flex;align-items:center;gap:8px;margin-bottom:12px;}
    .section-tag::before{content:'';width:24px;height:2px;background:var(--jade);}
    .section-title{font-family:'Playfair Display',serif;font-size:clamp(28px,4vw,42px);font-weight:700;color:var(--forest);line-height:1.2;}
    .section-header-row{display:flex;align-items:flex-end;justify-content:space-between;gap:20px;flex-wrap:wrap;}
    .see-all{font-size:14px;font-weight:600;color:var(--jade);text-decoration:none;display:flex;align-items:center;gap:4px;white-space:nowrap;transition:gap 0.2s;}
    .see-all:hover{gap:8px;}
    .province-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px;}
    .province-card{border-radius:16px;overflow:hidden;position:relative;height:200px;cursor:pointer;text-decoration:none;transition:transform 0.3s,box-shadow 0.3s;background:var(--forest);}
    .province-card:hover{transform:translateY(-6px);box-shadow:0 20px 40px rgba(0,0,0,0.2);}
    .province-card img{width:100%;height:100%;object-fit:cover;transition:transform 0.4s;}
    .province-card:hover img{transform:scale(1.05);}
    .province-card-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(13,27,19,0.8) 0%,rgba(0,0,0,0.1) 60%);padding:20px;display:flex;flex-direction:column;justify-content:flex-end;}
    .province-name{font-family:'Playfair Display',serif;font-size:20px;color:white;font-weight:700;}
    .province-count{font-size:13px;color:rgba(255,255,255,0.65);margin-top:4px;}
    .place-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:24px;}
    .place-card{background:white;border-radius:16px;overflow:hidden;box-shadow:var(--card-shadow);transition:all 0.3s;display:flex;flex-direction:column;}
    .place-card:hover{transform:translateY(-6px);box-shadow:0 16px 40px rgba(26,58,42,0.15);}
    .place-card img{width:100%;height:210px;object-fit:cover;}
    .place-card-body{padding:20px;flex:1;display:flex;flex-direction:column;}
    .place-meta{display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;}
    .place-cat{font-size:11px;font-weight:600;letter-spacing:1px;text-transform:uppercase;color:var(--jade);background:rgba(45,106,79,0.08);padding:3px 10px;border-radius:20px;}
    .place-location{font-size:12px;color:var(--muted);}
    .place-card h3{font-size:18px;font-weight:600;color:var(--ink);margin-bottom:8px;}
    .place-card p{font-size:14px;color:var(--muted);line-height:1.6;flex:1;}
    .place-card-footer{display:flex;align-items:center;justify-content:space-between;margin-top:16px;padding-top:16px;border-top:1px solid #f0f0f0;}
    .place-price{font-size:14px;font-weight:600;color:var(--forest);}
    .btn-view{font-size:13px;font-weight:600;color:var(--jade);text-decoration:none;transition:color 0.2s;}
    .btn-view:hover{color:var(--coral);}
    .itinerary-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:24px;}
    .iti-card{background:white;border-radius:16px;overflow:hidden;box-shadow:var(--card-shadow);text-decoration:none;color:inherit;display:flex;flex-direction:column;transition:all 0.3s;}
    .iti-card:hover{transform:translateY(-6px);box-shadow:0 16px 40px rgba(26,58,42,0.15);}
    .iti-cover{height:200px;background:linear-gradient(135deg,var(--jade),var(--forest));display:flex;align-items:center;justify-content:center;font-size:56px;position:relative;overflow:hidden;}
    .iti-cover img{width:100%;height:100%;object-fit:cover;}
    .iti-style-badge{position:absolute;top:16px;right:16px;background:rgba(255,255,255,0.9);backdrop-filter:blur(4px);padding:5px 12px;border-radius:20px;font-size:12px;font-weight:600;color:var(--forest);}
    .iti-body{padding:22px;flex:1;display:flex;flex-direction:column;}
    .iti-author{display:flex;align-items:center;gap:10px;margin-bottom:14px;}
    .iti-avatar{width:32px;height:32px;border-radius:50%;background:var(--lime);display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:var(--forest);}
    .iti-author-name{font-size:13px;font-weight:600;color:var(--forest);}
    .iti-author-location{font-size:12px;color:var(--muted);}
    .iti-title{font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:var(--ink);margin-bottom:8px;line-height:1.3;}
    .iti-summary{font-size:13px;color:var(--muted);line-height:1.6;flex:1;}
    .iti-footer{display:flex;align-items:center;justify-content:space-between;margin-top:16px;padding-top:16px;border-top:1px solid #f0f0f0;}
    .iti-stats{display:flex;gap:16px;}
    .iti-stat{font-size:13px;color:var(--muted);}
    .iti-duration{font-size:12px;font-weight:600;color:var(--jade);}
    .cta-banner{background:linear-gradient(135deg,var(--jade) 0%,var(--forest) 100%);padding:80px 8%;text-align:center;position:relative;overflow:hidden;}
    .cta-banner::before{content:'🌴';font-size:180px;opacity:0.06;position:absolute;right:5%;top:50%;transform:translateY(-50%);}
    .cta-banner h2{font-family:'Playfair Display',serif;font-size:clamp(28px,4vw,42px);color:white;margin-bottom:16px;}
    .cta-banner p{font-size:17px;color:rgba(255,255,255,0.75);margin-bottom:36px;max-width:500px;margin-left:auto;margin-right:auto;}
    .favorites-section{background:white;border-bottom:1px solid #f0ede8;}
    @media(max-width:768px){.section{padding:60px 5%;}.stat-item{flex:1;min-width:120px;padding:16px 20px;}.stats-bar{flex-wrap:wrap;}}
</style>
@endsection
@section('content')
<section class="hero">
    <div class="hero-badge">🌏 17.000+ Pulau Menanti Kamu</div>
    <h1>Jelajahi <em>Indonesia</em>,<br>Temukan Ceritamu</h1>
    <p>Panduan wisata lengkap + komunitas traveler. Temukan tempat, baca itinerary nyata, dan bagikan perjalananmu.</p>
    <div class="search-wrap" style="margin-bottom:32px;">
        <form action="{{ route('places.browse') }}" method="GET" style="display:contents;">
            <input type="text" name="search" placeholder="Cari tempat, kota, atau aktivitas...">
            <button type="submit">🔍 Cari</button>
        </form>
    </div>
    <div class="hero-actions">
        <a href="{{ route('explore') }}" class="btn-primary">Jelajahi Destinasi</a>
        <a href="{{ route('itinerary.index') }}" class="btn-outline">Lihat Itinerary</a>
    </div>
</section>

<div class="stats-bar">
    <div class="stat-item"><div class="stat-num">34</div><div class="stat-label">Provinsi</div></div>
    <div class="stat-item"><div class="stat-num">500+</div><div class="stat-label">Destinasi</div></div>
    <div class="stat-item"><div class="stat-num">200+</div><div class="stat-label">Itinerary</div></div>
    <div class="stat-item"><div class="stat-num">10K+</div><div class="stat-label">Traveler</div></div>
</div>

@if(Auth::check() && isset($favorites) && $favorites->count() > 0)
<section class="section favorites-section">
    <div class="section-header">
        <div class="section-tag">Tersimpan</div>
        <div class="section-title">⭐ Favorit Kamu</div>
    </div>
    <div class="place-grid">
        @foreach($favorites->take(3) as $place)
        <div class="place-card">
            <img src="{{ asset($place->image_url ?? 'images/default.jpg') }}" alt="{{ $place->name }}">
            <div class="place-card-body">
                <div class="place-meta"><span class="place-cat">{{ $place->category->name ?? 'Wisata' }}</span></div>
                <h3>{{ $place->name }}</h3>
                <p>{{ Str::limit($place->description, 90) }}</p>
                <div class="place-card-footer">
                    <span class="place-price">@if($place->price_start == 0)Gratis @else Rp {{ number_format($place->price_start,0,',','.') }}@endif</span>
                    <a href="{{ route('place.show', $place->id) }}" class="btn-view">Lihat →</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

<section class="section">
    <div class="section-header-row section-header">
        <div><div class="section-tag">Destinasi</div><div class="section-title">Jelajahi Nusantara</div></div>
        <a href="{{ route('explore') }}" class="see-all">Lihat Semua Provinsi →</a>
    </div>
    <div class="province-grid">
        @forelse($provinces as $province)
        <a href="{{ route('province.show', $province->slug) }}" class="province-card">
            <img src="{{ asset($province->image_url ?? 'https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=400&q=60') }}" alt="{{ $province->name }}" onerror="this.src='https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=400&q=60'">
            <div class="province-card-overlay">
                <div class="province-name">{{ $province->name }}</div>
                <div class="province-count">{{ $province->regions_count ?? 0 }} wilayah</div>
            </div>
        </a>
        @empty
        <p style="color:var(--muted);">Belum ada data provinsi.</p>
        @endforelse
    </div>
</section>

<section class="section" style="background:white;margin-top:0;">
    <div class="section-header-row section-header">
        <div><div class="section-tag">Populer</div><div class="section-title">Tempat Paling Disukai</div></div>
        <a href="{{ route('places.browse') }}" class="see-all">Lihat Semua →</a>
    </div>
    <div class="place-grid">
        @forelse($featuredPlaces as $place)
        <div class="place-card">
            <img src="{{ asset($place->image_url ?? 'images/default.jpg') }}" alt="{{ $place->name }}" onerror="this.style.display='none'">
            <div class="place-card-body">
                <div class="place-meta">
                    <span class="place-cat">{{ $place->category->name ?? '' }}</span>
                    <span class="place-location">📍 {{ $place->region->name ?? '' }}</span>
                </div>
                <h3>{{ $place->name }}</h3>
                <p>{{ Str::limit($place->description, 90) }}</p>
                <div class="place-card-footer">
                    <span class="place-price">@if($place->price_start == 0)Gratis @else Rp {{ number_format($place->price_start,0,',','.') }}@endif</span>
                    <a href="{{ route('place.show', $place->id) }}" class="btn-view">Lihat Detail →</a>
                </div>
            </div>
        </div>
        @empty
        <p style="color:var(--muted);">Belum ada tempat.</p>
        @endforelse
    </div>
</section>


<section class="section" style="background:linear-gradient(135deg,#0d1b35 0%,#1a2d6a 100%);padding:60px 8%;">
    <div style="max-width:900px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:40px;align-items:center;">
        <div>
            <div style="font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--lime);margin-bottom:12px;">Fitur Unggulan</div>
            <h2 style="font-family:'Playfair Display',serif;font-size:clamp(24px,4vw,36px);color:white;font-weight:900;margin-bottom:14px;line-height:1.2;">Rencanakan Budget<br>Perjalananmu 💰</h2>
            <p style="font-size:15px;color:rgba(255,255,255,0.7);line-height:1.7;margin-bottom:24px;">Estimasi biaya hotel, makan, aktivitas, dan transportasi ke seluruh Indonesia — disesuaikan dengan gaya perjalananmu.</p>
            <a href="{{ route('budget.index') }}" style="display:inline-block;background:var(--coral);color:white;padding:14px 32px;border-radius:10px;font-size:15px;font-weight:700;text-decoration:none;transition:background 0.2s;">Hitung Budget Sekarang →</a>
            <a href="{{ route('seasonal.index') }}" style="display:inline-block;background:rgba(255,255,255,0.1);color:white;padding:14px 24px;border-radius:10px;font-size:15px;font-weight:600;text-decoration:none;margin-left:10px;border:1px solid rgba(255,255,255,0.25);">🗓️ Panduan Musim</a>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
            <div style="background:rgba(255,255,255,0.08);border-radius:14px;padding:20px;border:1px solid rgba(255,255,255,0.1);">
                <div style="font-size:28px;margin-bottom:8px;">🎒</div>
                <div style="font-size:14px;font-weight:700;color:white;margin-bottom:4px;">Backpacker</div>
                <div style="font-size:13px;color:rgba(255,255,255,0.6);">Rp 230–550rb/hari</div>
            </div>
            <div style="background:rgba(255,255,255,0.08);border-radius:14px;padding:20px;border:1px solid rgba(255,255,255,0.1);">
                <div style="font-size:28px;margin-bottom:8px;">🏡</div>
                <div style="font-size:14px;font-weight:700;color:white;margin-bottom:4px;">Mid-range</div>
                <div style="font-size:13px;color:rgba(255,255,255,0.6);">Rp 1,1–2,8jt/hari</div>
            </div>
            <div style="background:rgba(255,255,255,0.08);border-radius:14px;padding:20px;border:1px solid rgba(255,255,255,0.1);">
                <div style="font-size:28px;margin-bottom:8px;">💰</div>
                <div style="font-size:14px;font-weight:700;color:white;margin-bottom:4px;">Budget</div>
                <div style="font-size:13px;color:rgba(255,255,255,0.6);">Rp 575rb–1,3jt/hari</div>
            </div>
            <div style="background:rgba(255,255,255,0.08);border-radius:14px;padding:20px;border:1px solid rgba(255,255,255,0.1);">
                <div style="font-size:28px;margin-bottom:8px;">💎</div>
                <div style="font-size:14px;font-weight:700;color:white;margin-bottom:4px;">Luxury</div>
                <div style="font-size:13px;color:rgba(255,255,255,0.6);">Rp 3,5–15,5jt/hari</div>
            </div>
        </div>
    </div>
</section>

<section class="section" style="background:var(--cream);">
    <div class="section-header-row section-header">
        <div><div class="section-tag">Komunitas</div><div class="section-title">Itinerary Terbaru dari Traveler</div></div>
        <a href="{{ route('itinerary.index') }}" class="see-all">Lihat Semua →</a>
    </div>
    <div class="itinerary-grid">
        @forelse($latestItineraries as $iti)
        <a href="{{ route('itinerary.show', $iti->slug) }}" class="iti-card">
            <div class="iti-cover">
                @if($iti->cover_image)<img src="{{ asset('storage/'.$iti->cover_image) }}" alt="{{ $iti->title }}">@else 🗺️@endif
                <span class="iti-style-badge">{{ $iti->travel_style_label }}</span>
            </div>
            <div class="iti-body">
                <div class="iti-author">
                    <div class="iti-avatar">{{ strtoupper(substr($iti->user->name,0,1)) }}</div>
                    <div>
                        <div class="iti-author-name">{{ $iti->user->name }}</div>
                        <div class="iti-author-location">📍 {{ $iti->region->name ?? 'Indonesia' }}</div>
                    </div>
                </div>
                <div class="iti-title">{{ $iti->title }}</div>
                <div class="iti-summary">{{ Str::limit($iti->summary, 100) }}</div>
                <div class="iti-footer">
                    <div class="iti-stats">
                        <span class="iti-stat">❤️ {{ $iti->likes_count ?? 0 }}</span>
                        <span class="iti-stat">{{ $iti->views ?? 0 }} views</span>
                    </div>
                    <span class="iti-duration">{{ $iti->duration_days }} hari</span>
                </div>
            </div>
        </a>
        @empty
        <div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--muted);">
            <p style="font-size:18px;">Belum ada itinerary. <a href="{{ route('itinerary.create') }}" style="color:var(--jade);">Jadilah yang pertama!</a></p>
        </div>
        @endforelse
    </div>
</section>

@guest
<div class="cta-banner">
    <h2>Punya pengalaman traveling?<br>Bagikan itinerarymu!</h2>
    <p>Bantu ribuan traveler lain merencanakan perjalanan impian mereka dengan berbagi cerita perjalananmu.</p>
    <a href="{{ route('register') }}" class="btn-primary" style="font-size:15px;padding:14px 36px;">Daftar Gratis Sekarang →</a>
</div>
@endguest
@endsection