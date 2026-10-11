@extends('layouts.app')
@section('title', 'Jelajahi Tempat — NusantaraGuide')
@section('styles')
<style>

    .page-hero{background:linear-gradient(135deg,var(--forest) 0%,var(--jade) 100%);padding:52px 8% 44px;}
    .page-hero h1{font-family:'Playfair Display',serif;font-size:clamp(28px,5vw,48px);color:white;font-weight:900;margin-bottom:10px;}
    .page-hero p{font-size:16px;color:rgba(255,255,255,0.7);max-width:500px;}
    body .search-section{background:white;padding:24px 8%;border-bottom:1px solid #eee;position:sticky;top:64px;z-index:50;box-shadow:0 2px 12px rgba(0,0,0,0.06);}
    .search-row{display:flex;gap:10px;flex-wrap:wrap;}
    .search-input-wrap{display:flex;flex:1;min-width:240px;background:var(--cream);border:1.5px solid #e0dbd2;border-radius:10px;overflow:hidden;transition:border-color 0.2s;}
    .search-input-wrap:focus-within{border-color:var(--jade);}
    .search-input-wrap input{flex:1;padding:11px 16px;border:none;background:transparent;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--ink);outline:none;}
    .search-input-wrap button{background:var(--jade);color:white;border:none;padding:0 20px;font-size:16px;cursor:pointer;transition:background 0.2s;}
    .search-input-wrap button:hover{background:var(--forest);}
    .filter-select{padding:11px 14px;border:1.5px solid #e0dbd2;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--ink);background:var(--cream);outline:none;cursor:pointer;transition:border-color 0.2s;}
    .filter-select:focus{border-color:var(--jade);}
    .reset-link{align-self:center;font-size:13px;color:var(--muted);text-decoration:none;padding:4px 8px;}
    .reset-link:hover{color:var(--coral);}
    .cat-pills{padding:14px 8%;background:white;border-bottom:1px solid #f0f0f0;display:flex;gap:8px;overflow-x:auto;}
    .cat-pills::-webkit-scrollbar{display:none;}
    .cat-pill{white-space:nowrap;padding:7px 18px;border-radius:20px;border:1.5px solid #e0dbd2;font-size:13px;text-decoration:none;color:var(--muted);transition:all 0.2s;background:white;font-weight:500;}
    .cat-pill:hover{border-color:var(--jade);color:var(--jade);}
    .cat-pill.active{background:var(--forest);color:white;border-color:var(--forest);}
    .main{padding:40px 8%;width:100%;}
    .results-bar{display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px;}
    /* Hide Laravel's "Showing X to Y" text */
    .pagination-wrap > div > p { display: none !important; }
    .pagination-wrap > p { display: none !important; }
    p.showing-text { display: none !important; }
    .results-info{font-size:15px;color:var(--muted);}
    .results-info strong{color:var(--ink);}
    .place-grid {
        display: grid !important;
        grid-template-columns: repeat(3, minmax(0,1fr)) !important;
        gap: 24px !important;
        margin-bottom: 48px !important;
        width: 100% !important;
    }
    body .place-card{background:white;border-radius:16px;overflow:hidden;box-shadow:var(--card-shadow);transition:all 0.3s;display:flex;flex-direction:column;}
    body .place-card:hover{transform:translateY(-6px);box-shadow:0 16px 40px rgba(26,58,42,0.15);}
    .place-card-img{position:relative;}
    .place-card-img img{width:100%;height:200px;object-fit:cover;display:block;}
    .place-cat-badge{position:absolute;top:12px;left:12px;background:rgba(255,255,255,0.92);backdrop-filter:blur(4px);padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;color:var(--forest);}
    .place-fav-btn{position:absolute;top:12px;right:12px;background:rgba(255,255,255,0.9);border:none;border-radius:50%;width:36px;height:36px;font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;}
    .place-fav-btn:hover{transform:scale(1.15);}
    body .place-card-body{padding:18px 20px;flex:1;display:flex;flex-direction:column;}
    .place-location{font-size:12px;color:var(--muted);margin-bottom:6px;}
    .place-card-body h3{font-size:17px;font-weight:600;color:var(--ink);margin-bottom:6px;line-height:1.3;}
    .place-card-body p{font-size:13px;color:var(--muted);line-height:1.6;flex:1;}
    body .place-card-footer{display:flex;align-items:center;justify-content:space-between;margin-top:14px;padding-top:14px;border-top:1px solid #f5f5f5;}
    .place-price{font-size:14px;font-weight:700;color:var(--forest);}
    .place-rating{font-size:13px;color:var(--gold);font-weight:600;}
    .btn-detail{font-size:13px;font-weight:600;color:white;background:var(--jade);padding:7px 16px;border-radius:8px;text-decoration:none;transition:background 0.2s;}
    .btn-detail:hover{background:var(--forest);}
    .empty-state{text-align:center;padding:80px 20px;grid-column:1/-1;}
    .empty-state .icon{font-size:56px;margin-bottom:16px;}
    .empty-state h3{font-family:'Playfair Display',serif;font-size:22px;color:var(--ink);margin-bottom:8px;}
    .empty-state p{font-size:15px;color:var(--muted);}
    /* Override old pagination-wrapper styles */
    .pagination-wrapper { display: none !important; }
    .pagination-wrap{display:flex;justify-content:center;margin-top:32px;}
    .pagination-wrap nav{width:100%;}
    .pagination-wrap nav > div:first-child{display:none;}
    .pagination-wrap ul,.pagination-wrap .flex{display:flex;justify-content:center;gap:6px;list-style:none;flex-wrap:wrap;align-items:center;}
    .pagination-wrap a,.pagination-wrap span,.pagination-wrap button{display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 12px;border-radius:8px;font-size:14px;font-weight:500;text-decoration:none;border:1.5px solid #e0dbd2;background:white;color:var(--ink);transition:all 0.2s;cursor:pointer;}
    .pagination-wrap a:hover{border-color:var(--jade);color:var(--jade);}
    .pagination-wrap [aria-current="page"] span,.pagination-wrap span.font-bold{background:var(--jade);color:white;border-color:var(--jade);}
    .pagination-wrap span[aria-disabled="true"],.pagination-wrap span.cursor-default{color:#ccc;border-color:#eee;cursor:default;}
    @media(max-width:768px){.search-row{flex-direction:column;}.main{padding:28px 5%;}.place-grid{grid-template-columns:1fr !important;}}
    /* Hide "Showing X to Y of Z results" paragraph from Laravel pagination */
    .pagination-wrap nav > div:first-child,
    .pagination-wrap nav p,
    .pagination-wrap > nav > div:first-child { display: none !important; }
    /* Ensure pagination numbers are centered and full width */
    .pagination-wrap nav { width: 100%; display: flex; justify-content: center; }
    .pagination-wrap nav > div:last-child { display: flex; justify-content: center; width: 100%; }
</style>
@endsection
@section('content')
<div class="page-hero">
    <h1>Jelajahi Tempat</h1>
    <p>Temukan wisata, restoran, hotel, dan tempat menarik dari seluruh Indonesia.</p>
</div>
<div class="search-section">
    <form action="{{ route('places.browse') }}" method="GET" id="filterForm">
        <div class="search-row">
            <div class="search-input-wrap">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama tempat, kota, atau alamat...">
                <button type="submit">🔍</button>
            </div>
            <select name="province" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                <option value="">Semua Provinsi</option>
                @foreach($provinces as $prov)
                <option value="{{ $prov->id }}" {{ request('province') == $prov->id ? 'selected' : '' }}>{{ $prov->name }}</option>
                @endforeach
            </select>
            <select name="region" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                <option value="">Semua Wilayah</option>
                @foreach($regions as $region)
                <option value="{{ $region->id }}" {{ request('region') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                @endforeach
            </select>
            <select name="sort" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                <option value="popular" {{ request('sort','popular')=='popular'?'selected':'' }}>Terpopuler</option>
                <option value="rating" {{ request('sort')=='rating'?'selected':'' }}>Rating Tertinggi</option>
                <option value="newest" {{ request('sort')=='newest'?'selected':'' }}>Terbaru</option>
                <option value="price" {{ request('sort')=='price'?'selected':'' }}>Harga Terendah</option>
            </select>
            @if(request()->anyFilled(['search','province','region','category','sort']))
            <a href="{{ route('places.browse') }}" class="reset-link">Reset ×</a>
            @endif
        </div>
    </form>
</div>
<div class="cat-pills">
    <a href="{{ route('places.browse', request()->except('category')) }}" class="cat-pill {{ !request('category') ? 'active' : '' }}">Semua</a>
    @foreach($categories as $cat)
    <a href="{{ route('places.browse', array_merge(request()->all(), ['category' => $cat->id])) }}" class="cat-pill {{ request('category') == $cat->id ? 'active' : '' }}">{{ $cat->icon ?? '' }} {{ $cat->name }}</a>
    @endforeach
</div>
<div class="main">
    <div class="results-bar">
        <div class="results-info">Menampilkan <strong>{{ $places->total() }}</strong> tempat @if(request('search'))untuk "<strong>{{ request('search') }}</strong>"@endif</div>
    </div>
    <div class="place-grid">
        @forelse($places as $place)
        <div class="place-card">
            <div class="place-card-img">
                <img src="{{ asset($place->image_url ?? 'images/default.jpg') }}" alt="{{ $place->name }}" onerror="this.src='';this.style.height='200px';this.style.background='#e8f4ee';">
                @if($place->category)<span class="place-cat-badge">{{ $place->category->icon ?? '' }} {{ $place->category->name }}</span>@endif
                @auth
                <form action="{{ route('favorite.toggle', $place->id) }}" method="POST" style="display:contents;">
                    @csrf
                    <button type="submit" class="place-fav-btn">{{ $favorites->contains($place->id) ? '❤️' : '🤍' }}</button>
                </form>
                @endauth
            </div>
            <div class="place-card-body">
                <div class="place-location">📍 {{ $place->region->name ?? 'Indonesia' }}@if($place->region->province ?? null), {{ $place->region->province->name }}@endif</div>
                <h3>{{ $place->name }}</h3>
                <p>{{ Str::limit($place->description, 90) }}</p>
                <div class="place-card-footer">
                    <div>
                        <div class="place-price">@if($place->price_start == 0)Gratis @else Rp {{ number_format($place->price_start,0,',','.') }}@endif</div>
                        @if($place->reviews_avg_rating)<div class="place-rating">★ {{ number_format($place->reviews_avg_rating,1) }}</div>@endif
                    </div>
                    <a href="{{ route('place.show', $place->id) }}" class="btn-detail">Lihat Detail →</a>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state"><div class="icon">🔍</div><h3>Tidak ada tempat ditemukan</h3><p>Coba ubah kata kunci atau filter pencarianmu.</p></div>
        @endforelse
    </div>
    @php
        // Remove "Showing X to Y" from pagination by using simple links
        $paginator = $places->withQueryString();
    @endphp
    <div class="pagination-wrap">
        {{ $paginator->links() }}
    </div>
</div>
@endsection