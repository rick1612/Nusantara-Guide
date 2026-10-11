@extends('layouts.app')
@section('title', 'Itinerary Saya — NusantaraGuide')
@section('styles')
<style>
    .page-hero{background:linear-gradient(135deg,var(--forest) 0%,var(--jade) 100%);padding:52px 8% 44px;}
    .page-hero h1{font-family:'Playfair Display',serif;font-size:clamp(28px,5vw,42px);color:white;font-weight:900;margin-bottom:8px;}
    .page-hero p{font-size:15px;color:rgba(255,255,255,0.72);}

    .tab-bar{background:white;border-bottom:2px solid #f0ede8;padding:0 8%;display:flex;position:sticky;top:64px;z-index:50;}
    .tab-btn{padding:16px 24px;font-size:14px;font-weight:600;color:var(--muted);background:none;border:none;border-bottom:3px solid transparent;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all 0.2s;margin-bottom:-2px;}
    .tab-btn.active{color:var(--jade);border-bottom-color:var(--jade);}
    .tab-content{display:none;} .tab-content.active{display:block;}

    .main-content{padding:40px 8%;max-width:1200px;}

    /* MY POSTS */
    .iti-list{display:flex;flex-direction:column;gap:16px;}
    .iti-row{background:white;border-radius:16px;box-shadow:var(--card-shadow);overflow:hidden;display:grid;grid-template-columns:140px 1fr auto;transition:box-shadow 0.2s;}
    .iti-row:hover{box-shadow:0 8px 32px rgba(26,58,42,0.15);}
    .iti-thumb{height:100%;min-height:120px;background:linear-gradient(135deg,var(--jade),var(--forest));display:flex;align-items:center;justify-content:center;font-size:40px;position:relative;overflow:hidden;}
    .iti-thumb img{width:100%;height:100%;object-fit:cover;position:absolute;inset:0;}
    .iti-body{padding:18px 22px;display:flex;flex-direction:column;justify-content:space-between;}
    .iti-title-row{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:6px;}
    .iti-title{font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:var(--ink);}
    .iti-badge{padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;}
    .badge-published{background:rgba(116,198,157,0.15);color:var(--jade);}
    .badge-draft{background:rgba(107,124,114,0.1);color:var(--muted);}
    .badge-verified{background:rgba(116,198,157,0.2);color:var(--jade);border:1px solid rgba(116,198,157,0.4);}
    .iti-meta{display:flex;gap:16px;flex-wrap:wrap;font-size:13px;color:var(--muted);margin-bottom:10px;}
    .iti-stats{display:flex;gap:14px;font-size:13px;color:var(--muted);}
    .iti-actions{padding:18px 20px;display:flex;flex-direction:column;gap:8px;align-items:flex-end;justify-content:center;border-left:1px solid #f5f5f5;min-width:130px;}
    .btn-edit{display:block;padding:9px 18px;background:var(--jade);color:white;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;text-align:center;transition:background 0.2s;}
    .btn-edit:hover{background:var(--forest);}
    .btn-view{display:block;padding:9px 18px;background:white;color:var(--jade);border:1.5px solid var(--jade);border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;text-align:center;transition:all 0.2s;}
    .btn-view:hover{background:var(--jade);color:white;}
    .btn-delete{display:block;padding:9px 18px;background:white;color:var(--coral);border:1.5px solid var(--coral);border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;text-align:center;width:100%;transition:all 0.2s;}
    .btn-delete:hover{background:var(--coral);color:white;}

    /* COPIED ITINERARIES */
    .copied-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:20px;}
    .copied-card{background:white;border-radius:16px;box-shadow:var(--card-shadow);overflow:hidden;text-decoration:none;color:inherit;display:flex;flex-direction:column;transition:all 0.3s;}
    .copied-card:hover{transform:translateY(-5px);box-shadow:0 12px 32px rgba(26,58,42,0.15);}
    .copied-cover{height:160px;background:linear-gradient(135deg,var(--jade),var(--forest));display:flex;align-items:center;justify-content:center;font-size:48px;position:relative;overflow:hidden;}
    .copied-cover img{width:100%;height:100%;object-fit:cover;}
    .copied-body{padding:18px;}
    .copied-by{font-size:12px;color:var(--muted);margin-bottom:5px;}
    .copied-title{font-family:'Playfair Display',serif;font-size:16px;font-weight:700;color:var(--ink);margin-bottom:8px;line-height:1.3;}
    .copied-meta{display:flex;gap:12px;font-size:12px;color:var(--muted);}
    .copied-date{font-size:11px;color:var(--muted);margin-top:10px;padding-top:10px;border-top:1px solid #f5f5f5;}
    .original-link{display:inline-flex;align-items:center;gap:4px;font-size:12px;font-weight:600;color:var(--jade);text-decoration:none;margin-top:8px;}
    .original-link:hover{text-decoration:underline;}

    /* EMPTY STATE */
    .empty-box{background:white;border-radius:16px;padding:60px 24px;text-align:center;box-shadow:var(--card-shadow);}
    .empty-box .empty-icon{font-size:52px;margin-bottom:16px;}
    .empty-box h3{font-family:'Playfair Display',serif;font-size:22px;color:var(--ink);margin-bottom:8px;}
    .empty-box p{font-size:15px;color:var(--muted);margin-bottom:24px;max-width:380px;margin-left:auto;margin-right:auto;}
    .btn-create{display:inline-block;background:var(--coral);color:white;padding:13px 32px;border-radius:10px;font-size:15px;font-weight:700;text-decoration:none;transition:background 0.2s;}
    .btn-create:hover{background:#d4604a;}

    @media(max-width:768px){
        .iti-row{grid-template-columns:1fr;}
        .iti-thumb{min-height:160px;}
        .iti-actions{flex-direction:row;border-left:none;border-top:1px solid #f5f5f5;padding:14px 18px;}
        .main-content{padding:28px 5%;}
        .copied-grid{grid-template-columns:1fr;}
    }
</style>
@endsection
@section('content')

<div class="page-hero">
    <h1>Itinerary Saya</h1>
    <p>Kelola semua itinerary yang kamu buat dan simpan dari komunitas.</p>
</div>

<div class="tab-bar">
    <button class="tab-btn active" onclick="switchTab('mine', this)">
        ✍️ Buatan Saya ({{ $itineraries->total() }})
    </button>
    <button class="tab-btn" onclick="switchTab('copied', this)">
        📋 Disalin ({{ $copiedItineraries->count() }})
    </button>
</div>

<div class="main-content">
    @if(session('success'))
    <div class="alert-success" style="margin-bottom:24px;">✓ {{ session('success') }}</div>
    @endif

    {{-- TAB 1: MY OWN ITINERARIES --}}
    <div class="tab-content active" id="tab-mine">
        @if($itineraries->count())
        <div class="iti-list">
            @foreach($itineraries as $iti)
            <div class="iti-row">
                <div class="iti-thumb">
                    @if($iti->cover_image)
                        <img src="{{ asset('storage/'.$iti->cover_image) }}" alt="{{ $iti->title }}">
                    @else
                        🗺️
                    @endif
                </div>
                <div class="iti-body">
                    <div>
                        <div class="iti-title-row">
                            <span class="iti-title">{{ $iti->title }}</span>
                            <span class="iti-badge {{ $iti->status === 'published' ? 'badge-published' : 'badge-draft' }}">
                                {{ $iti->status === 'published' ? '✓ Dipublikasi' : '📝 Draft' }}
                            </span>
                            @if($iti->is_verified)
                            <span class="iti-badge badge-verified">✓ Perjalanan Nyata</span>
                            @endif
                        </div>
                        <div class="iti-meta">
                            <span>📅 {{ $iti->duration_days }} hari</span>
                            <span>{{ $iti->travel_style_label }}</span>
                            <span>{{ $iti->budget_label }}</span>
                            @if($iti->region)
                            <span>📍 {{ $iti->region->name }}</span>
                            @endif
                        </div>
                        <p style="font-size:13px;color:var(--muted);line-height:1.6;">{{ Str::limit($iti->summary, 120) }}</p>
                    </div>
                    <div class="iti-stats" style="margin-top:12px;">
                        <span>❤️ {{ $iti->likes_count ?? 0 }} suka</span>
                        <span>💬 {{ $iti->comments_count ?? 0 }} komentar</span>
                        <span>📋 {{ $iti->copies_count ?? 0 }} disalin</span>
                        <span>👁 {{ $iti->views ?? 0 }} dilihat</span>
                        <span style="margin-left:auto;font-size:12px;">{{ \Carbon\Carbon::parse($iti->created_at)->isoFormat('D MMM YYYY') }}</span>
                    </div>
                </div>
                <div class="iti-actions">
                    @if($iti->status === 'published')
                    <a href="{{ route('itinerary.show', $iti->slug) }}" class="btn-view">Lihat</a>
                    @endif
                    <a href="{{ route('itinerary.edit', $iti->slug) }}" class="btn-edit">Edit</a>
                    <form action="{{ route('itinerary.destroy', $iti->slug) }}" method="POST"
                          onsubmit="return confirm('Yakin hapus itinerary ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-delete">Hapus</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        <div style="margin-top:28px;">{{ $itineraries->links() }}</div>

        @else
        <div class="empty-box">
            <div class="empty-icon">✍️</div>
            <h3>Belum ada itinerary</h3>
            <p>Bagikan pengalaman perjalananmu kepada komunitas NusantaraGuide!</p>
            <a href="{{ route('itinerary.create') }}" class="btn-create">+ Buat Itinerary Pertamamu</a>
        </div>
        @endif
    </div>

    {{-- TAB 2: COPIED ITINERARIES --}}
    <div class="tab-content" id="tab-copied">
        @if($copiedItineraries->count())
        <div class="copied-grid">
            @foreach($copiedItineraries as $copy)
            @php $iti = $copy->originalItinerary; @endphp
            @if($iti)
            <a href="{{ route('itinerary.show', $iti->slug) }}" class="copied-card">
                <div class="copied-cover">
                    @if($iti->cover_image)
                        <img src="{{ asset('storage/'.$iti->cover_image) }}" alt="{{ $iti->title }}">
                    @else
                        🗺️
                    @endif
                </div>
                <div class="copied-body">
                    <div class="copied-by">oleh {{ $iti->user->name ?? 'Pengguna' }}</div>
                    <div class="copied-title">{{ $iti->title }}</div>
                    <div class="copied-meta">
                        <span>📅 {{ $iti->duration_days }} hari</span>
                        <span>{{ $iti->travel_style_label }}</span>
                        <span>{{ $iti->budget_label }}</span>
                    </div>
                    @if($iti->region)
                    <div style="font-size:12px;color:var(--muted);margin-top:6px;">
                        📍 {{ $iti->region->name }}@if($iti->region->province), {{ $iti->region->province->name }}@endif
                    </div>
                    @endif
                    <div class="copied-date">
                        Disalin {{ \Carbon\Carbon::parse($copy->copied_at)->isoFormat('D MMMM YYYY') }}
                    </div>
                </div>
            </a>
            @endif
            @endforeach
        </div>

        @else
        <div class="empty-box">
            <div class="empty-icon">📋</div>
            <h3>Belum ada itinerary yang disalin</h3>
            <p>Temukan itinerary menarik dari komunitas dan salin sebagai inspirasimu.</p>
            <a href="{{ route('itinerary.index') }}" class="btn-create">Jelajahi Itinerary Komunitas</a>
        </div>
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