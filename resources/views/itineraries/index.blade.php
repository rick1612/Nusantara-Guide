@extends('layouts.app')
@section('title', 'Itinerary Komunitas — NusantaraGuide')
@section('styles')
<style>
    .page-hero{background:linear-gradient(135deg,var(--forest) 0%,var(--jade) 100%);padding:72px 8% 60px;}
    .page-hero h1{font-family:'Playfair Display',serif;font-size:clamp(32px,5vw,54px);color:white;font-weight:900;margin-bottom:12px;}
    .page-hero p{font-size:17px;color:rgba(255,255,255,0.7);max-width:560px;line-height:1.7;}
    .filter-bar{background:white;padding:20px 8%;border-bottom:1px solid #eee;position:sticky;top:64px;z-index:50;box-shadow:0 2px 12px rgba(0,0,0,0.05);}
    .filter-form{display:flex;gap:12px;flex-wrap:wrap;align-items:center;}
    .filter-form input,.filter-form select{padding:9px 14px;border:1px solid #e0e0e0;border-radius:8px;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--ink);background:white;outline:none;transition:border-color 0.2s;}
    .filter-form input:focus,.filter-form select:focus{border-color:var(--jade);}
    .filter-form input[name="search"]{min-width:220px;flex:1;}
    .filter-btn{background:var(--jade);color:white;border:none;padding:9px 22px;border-radius:8px;cursor:pointer;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;transition:background 0.2s;}
    .filter-btn:hover{background:var(--forest);}
    .filter-reset{color:var(--muted);font-size:13px;text-decoration:none;}
    .filter-reset:hover{color:var(--coral);}
    .tag-scroll{padding:16px 8%;background:white;border-bottom:1px solid #f0f0f0;display:flex;gap:8px;overflow-x:auto;}
    .tag-scroll::-webkit-scrollbar{display:none;}
    .tag-pill{white-space:nowrap;padding:6px 16px;border-radius:20px;border:1px solid #e0e0e0;font-size:13px;text-decoration:none;color:var(--muted);transition:all 0.2s;background:white;}
    .tag-pill:hover,.tag-pill.active{background:var(--forest);color:white;border-color:var(--forest);}
    .main-content{padding:48px 8%;}
    .results-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px;}
    .results-count{font-size:15px;color:var(--muted);}
    .results-count strong{color:var(--ink);}
    .iti-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:28px;margin-bottom:48px;}
    .iti-card{background:white;border-radius:18px;overflow:hidden;box-shadow:var(--card-shadow);text-decoration:none;color:inherit;display:flex;flex-direction:column;transition:all 0.3s;}
    .iti-card:hover{transform:translateY(-7px);box-shadow:0 20px 48px rgba(26,58,42,0.15);}
    .iti-cover{height:220px;position:relative;overflow:hidden;background:linear-gradient(135deg,var(--jade),var(--forest));display:flex;align-items:center;justify-content:center;font-size:64px;}
    .iti-cover img{width:100%;height:100%;object-fit:cover;transition:transform 0.4s;}
    .iti-card:hover .iti-cover img{transform:scale(1.04);}
    .iti-cover-badges{position:absolute;top:14px;left:14px;right:14px;display:flex;justify-content:space-between;align-items:flex-start;}
    .badge-style{background:rgba(255,255,255,0.92);backdrop-filter:blur(4px);padding:5px 12px;border-radius:20px;font-size:12px;font-weight:600;color:var(--forest);}
    .badge-duration{background:var(--coral);color:white;padding:5px 12px;border-radius:20px;font-size:12px;font-weight:600;}
    .iti-body{padding:22px;flex:1;display:flex;flex-direction:column;}
    .iti-author{display:flex;align-items:center;gap:10px;margin-bottom:14px;}
    .iti-avatar{width:36px;height:36px;border-radius:50%;background:var(--lime);display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:var(--forest);flex-shrink:0;}
    .iti-author-name{font-size:13px;font-weight:600;color:var(--forest);}
    .iti-location{font-size:12px;color:var(--muted);}
    .iti-title{font-family:'Playfair Display',serif;font-size:19px;font-weight:700;color:var(--ink);margin-bottom:8px;line-height:1.3;}
    .iti-summary{font-size:14px;color:var(--muted);line-height:1.65;flex:1;}
    .iti-tags{display:flex;gap:6px;flex-wrap:wrap;margin-top:14px;}
    .iti-tag{background:rgba(45,106,79,0.08);color:var(--jade);padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;}
    .iti-footer{display:flex;align-items:center;justify-content:space-between;margin-top:16px;padding-top:16px;border-top:1px solid #f0f0f0;}
    .iti-stats{display:flex;gap:16px;}
    .iti-stat{font-size:13px;color:var(--muted);}
    .iti-budget{font-size:13px;font-weight:600;color:var(--forest);}
    .empty-state{text-align:center;padding:80px 20px;grid-column:1/-1;}
    .empty-state p{font-size:40px;margin-bottom:16px;}
    .empty-state h3{font-family:'Playfair Display',serif;font-size:24px;color:var(--ink);margin-bottom:8px;}
    .empty-state span{font-size:15px;color:var(--muted);}
    .pagination-wrap{display:flex;justify-content:center;}
    @media(max-width:768px){.filter-form{flex-direction:column;}.main-content{padding:32px 5%;}.iti-grid{grid-template-columns:1fr;}}
</style>
@endsection
@section('content')
<div class="page-hero">
    <h1>Itinerary Komunitas</h1>
    <p>Temukan inspirasi perjalanan dari traveler nyata — lengkap dengan rencana harian, estimasi biaya, dan tips eksklusif.</p>
</div>

<div class="filter-bar">
    <form action="{{ route('itinerary.index') }}" method="GET" class="filter-form">
        <input type="text" name="search" placeholder="Cari itinerary..." value="{{ request('search') }}">
        <select name="region">
            <option value="">Semua Wilayah</option>
            @foreach($regions as $region)
            <option value="{{ $region->id }}" {{ request('region')==$region->id?'selected':'' }}>{{ $region->name }} ({{ $region->province->name??'' }})</option>
            @endforeach
        </select>
        <select name="style">
            <option value="">Semua Gaya</option>
            <option value="backpacker" {{ request('style')=='backpacker'?'selected':'' }}>🎒 Backpacker</option>
            <option value="budget" {{ request('style')=='budget'?'selected':'' }}>💰 Budget</option>
            <option value="mid-range" {{ request('style')=='mid-range'?'selected':'' }}>🏡 Mid-range</option>
            <option value="luxury" {{ request('style')=='luxury'?'selected':'' }}>💎 Luxury</option>
            <option value="family" {{ request('style')=='family'?'selected':'' }}>👨‍👩‍👧 Keluarga</option>
            <option value="solo" {{ request('style')=='solo'?'selected':'' }}>🧍 Solo</option>
            <option value="couple" {{ request('style')=='couple'?'selected':'' }}>👫 Couple</option>
        </select>
        <select name="max_days">
            <option value="">Semua Durasi</option>
            <option value="2" {{ request('max_days')=='2'?'selected':'' }}>1-2 hari</option>
            <option value="5" {{ request('max_days')=='5'?'selected':'' }}>3-5 hari</option>
            <option value="7" {{ request('max_days')=='7'?'selected':'' }}>1 minggu</option>
            <option value="14" {{ request('max_days')=='14'?'selected':'' }}>2 minggu</option>
        </select>
        <button type="submit" class="filter-btn">Filter</button>
        @if(request()->anyFilled(['search','region','style','max_days','tag']))
        <a href="{{ route('itinerary.index') }}" class="filter-reset">Reset ×</a>
        @endif
    </form>
</div>

<div class="tag-scroll">
    <a href="{{ route('itinerary.index') }}" class="tag-pill {{ !request('tag')?'active':'' }}">Semua</a>
    @foreach($tags as $tag)
    <a href="{{ route('itinerary.index', ['tag'=>$tag->slug]+request()->except('tag')) }}" class="tag-pill {{ request('tag')==$tag->slug?'active':'' }}">{{ $tag->name }}</a>
    @endforeach
</div>

<div class="main-content">
    <div class="results-header">
        <div class="results-count">Menampilkan <strong>{{ $itineraries->total() }}</strong> itinerary</div>
        @auth
        <a href="{{ route('itinerary.create') }}" style="background:var(--coral);color:white;padding:10px 22px;border-radius:8px;text-decoration:none;font-size:14px;font-weight:600;">+ Bagikan Itinerary</a>
        @endauth
    </div>

    <div class="iti-grid">
        @forelse($itineraries as $iti)
        <a href="{{ route('itinerary.show', $iti->slug) }}" class="iti-card">
            <div class="iti-cover">
                @if($iti->cover_image)<img src="{{ asset('storage/'.$iti->cover_image) }}" alt="{{ $iti->title }}">@else 🗺️@endif
                <div class="iti-cover-badges">
                    <span class="badge-style">{{ $iti->travel_style_label }}</span>
                    <span class="badge-duration">{{ $iti->duration_days }} Hari</span>
                </div>
            </div>
            <div class="iti-body">
                <div class="iti-author">
                    <div class="iti-avatar">{{ strtoupper(substr($iti->user->name,0,1)) }}</div>
                    <div>
                        <div class="iti-author-name">{{ $iti->user->name }}</div>
                        <div class="iti-location">📍 {{ $iti->region->name??'Indonesia' }}, {{ $iti->region->province->name??'' }}</div>
                    </div>
                </div>
                <div class="iti-title">{{ $iti->title }}</div>
                <div class="iti-summary">{{ Str::limit($iti->summary,110) }}</div>
                @if($iti->tags->count())
                <div class="iti-tags">@foreach($iti->tags->take(3) as $tag)<span class="iti-tag">{{ $tag->name }}</span>@endforeach</div>
                @endif
                <div class="iti-footer">
                    <div class="iti-stats">
                        <span class="iti-stat">❤️ {{ $iti->likes_count??0 }}</span>
                        <span class="iti-stat">👁 {{ $iti->views }}</span>
                    </div>
                    <span class="iti-budget">{{ $iti->budget_label }}</span>
                </div>
            </div>
        </a>
        @empty
        <div class="empty-state">
            <p>🗺️</p>
            <h3>Belum ada itinerary</h3>
            <span>
                @auth Jadilah yang pertama berbagi perjalananmu!<br><br><a href="{{ route('itinerary.create') }}" style="color:var(--jade);font-weight:600;">Buat Itinerary →</a>
                @else <a href="{{ route('login') }}" style="color:var(--jade);">Login</a> untuk berbagi itinerary pertamamu.
                @endauth
            </span>
        </div>
        @endforelse
    </div>

    <div class="pagination-wrap">{{ $itineraries->withQueryString()->links() }}</div>
</div>
@endsection