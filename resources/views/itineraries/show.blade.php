@extends('layouts.app')
@section('title', $itinerary->title . ' — NusantaraGuide')
@section('styles')
<style>
    /* HERO */
    .iti-hero{position:relative;height:440px;background:linear-gradient(135deg,var(--forest),var(--jade));overflow:hidden;}
    .iti-hero img{width:100%;height:100%;object-fit:cover;opacity:0.55;}
    .iti-hero-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(13,27,19,0.92) 0%,rgba(0,0,0,0.1) 60%);padding:36px 4%;display:flex;flex-direction:column;justify-content:flex-end;}
    .iti-badges{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px;}
    .iti-badge{padding:5px 14px;border-radius:20px;font-size:12px;font-weight:700;}
    .badge-style{background:rgba(255,255,255,0.15);color:white;backdrop-filter:blur(4px);}
    .badge-verified{background:rgba(116,198,157,0.25);color:var(--lime);border:1px solid rgba(116,198,157,0.4);}
    .badge-region{background:rgba(255,255,255,0.12);color:rgba(255,255,255,0.85);}
    .iti-hero h1{font-family:'Playfair Display',serif;font-size:clamp(24px,5vw,44px);color:white;font-weight:900;margin-bottom:10px;line-height:1.2;}
    .iti-hero-meta{display:flex;align-items:center;gap:20px;flex-wrap:wrap;}
    .iti-author{display:flex;align-items:center;gap:8px;color:rgba(255,255,255,0.8);font-size:14px;}
    .author-avatar{width:32px;height:32px;border-radius:50%;background:var(--jade);display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:white;}
    .iti-date{font-size:13px;color:rgba(255,255,255,0.6);}
    .iti-stats-row{display:flex;gap:16px;margin-top:12px;}
    .iti-stat{font-size:13px;color:rgba(255,255,255,0.7);display:flex;align-items:center;gap:5px;}

    /* LAYOUT */
    .page-body{max-width:1400px;margin:0 auto;padding:40px 4% 80px;display:grid;grid-template-columns:1fr 300px;gap:28px;}

    /* CARDS */
    .card{background:white;border-radius:16px;padding:26px;box-shadow:var(--card-shadow);margin-bottom:22px;}
    .card h2{font-family:'Playfair Display',serif;font-size:18px;color:var(--forest);margin-bottom:18px;padding-bottom:12px;border-bottom:2px solid var(--cream);}

    /* SUMMARY GRID */
    .summary-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
    .summary-item{background:var(--cream);border-radius:10px;padding:14px;}
    .summary-icon{font-size:20px;margin-bottom:6px;}
    .summary-value{font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:var(--forest);}
    .summary-label{font-size:12px;color:var(--muted);margin-top:2px;}

    /* TIMELINE */
    .day-section{margin-bottom:32px;}
    .day-header{display:flex;align-items:center;gap:14px;margin-bottom:20px;padding:16px 20px;background:var(--forest);border-radius:12px;color:white;}
    .day-num{width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;font-weight:900;font-size:15px;flex-shrink:0;}
    .day-title{font-family:'Playfair Display',serif;font-size:17px;font-weight:700;}
    .day-notes{font-size:13px;opacity:0.75;margin-top:3px;}
    .timeline{position:relative;padding-left:32px;}
    .timeline::before{content:'';position:absolute;left:13px;top:0;bottom:0;width:2px;background:linear-gradient(to bottom,var(--lime),rgba(116,198,157,0.1));}

    /* STOP CARD */
    .stop-item{position:relative;margin-bottom:8px;}
    .stop-dot{position:absolute;left:-32px;top:18px;width:26px;height:26px;border-radius:50%;background:white;border:2px solid var(--lime);display:flex;align-items:center;justify-content:center;font-size:13px;z-index:1;box-shadow:0 2px 8px rgba(0,0,0,0.1);}
    .stop-card{background:white;border-radius:14px;border:1.5px solid #e8e3da;overflow:hidden;transition:border-color 0.2s;}
    .stop-card:hover{border-color:var(--jade);}
    .stop-header{display:flex;align-items:center;gap:12px;padding:14px 18px;background:var(--cream);border-bottom:1px solid #f0ede8;}
    .stop-type{font-size:20px;}
    .stop-name{font-size:15px;font-weight:700;color:var(--ink);flex:1;}
    .stop-time{font-size:13px;color:var(--muted);display:flex;align-items:center;gap:6px;}
    .stop-time-badge{background:white;border:1px solid #e0dbd2;padding:3px 10px;border-radius:8px;font-size:12px;font-weight:600;color:var(--ink);}
    .stop-body{padding:16px 18px;}
    .stop-description{font-size:14px;color:#555;line-height:1.75;margin-bottom:12px;}
    .stop-meta-row{display:flex;gap:16px;flex-wrap:wrap;}
    .stop-meta{font-size:13px;color:var(--muted);display:flex;align-items:center;gap:5px;}
    .stop-meta strong{color:var(--ink);}
    .stop-tip{background:rgba(116,198,157,0.1);border-left:3px solid var(--lime);border-radius:0 8px 8px 0;padding:10px 14px;font-size:13px;color:var(--jade);margin-top:12px;font-style:italic;}

    /* TRANSPORT CONNECTOR */
    .transport-connector{display:flex;align-items:center;gap:10px;padding:8px 0 8px 4px;}
    .connector-line{width:2px;height:28px;background:linear-gradient(to bottom,var(--lime),rgba(116,198,157,0.2));margin-left:11px;flex-shrink:0;}
    .connector-pill{display:flex;align-items:center;gap:8px;background:rgba(116,198,157,0.08);border:1px dashed rgba(116,198,157,0.4);border-radius:20px;padding:5px 14px;font-size:12px;color:var(--muted);}

    /* ACTIONS */
    .action-bar{display:flex;gap:10px;margin-bottom:24px;flex-wrap:wrap;}
    .action-btn{display:flex;align-items:center;gap:7px;padding:11px 20px;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;border:none;transition:all 0.2s;text-decoration:none;}
    .btn-like{background:var(--cream);color:var(--muted);border:1.5px solid #e0dbd2;}
    .btn-like.liked{background:rgba(231,111,81,0.1);color:var(--coral);border-color:var(--coral);}
    .btn-like:hover{border-color:var(--coral);color:var(--coral);}
    .btn-save{background:var(--cream);color:var(--muted);border:1.5px solid #e0dbd2;}
    .btn-save.saved{background:rgba(45,106,79,0.1);color:var(--jade);border-color:var(--jade);}
    .btn-share{background:var(--cream);color:var(--muted);border:1.5px solid #e0dbd2;}
    .btn-share:hover{border-color:var(--jade);color:var(--jade);}

    /* SIDEBAR */
    .sb-card{background:white;border-radius:16px;padding:22px;box-shadow:var(--card-shadow);margin-bottom:20px;}
    .sb-card h3{font-family:'Playfair Display',serif;font-size:16px;color:var(--forest);margin-bottom:16px;}
    .budget-box{background:linear-gradient(135deg,var(--forest),var(--jade));border-radius:12px;padding:18px;color:white;text-align:center;margin-bottom:16px;}
    .budget-amount{font-family:'Playfair Display',serif;font-size:28px;font-weight:900;}
    .budget-note{font-size:12px;opacity:0.7;margin-top:4px;}
    .stat-item{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid #f5f5f5;font-size:14px;}
    .stat-item:last-child{border-bottom:none;}
    .stat-label{color:var(--muted);}
    .stat-value{font-weight:700;color:var(--ink);}

    /* COMMENTS */
    .comment-item{padding:16px 0;border-bottom:1px solid #f5f5f5;}
    .comment-item:last-child{border-bottom:none;}
    .comment-author{font-size:13px;font-weight:700;color:var(--ink);margin-bottom:4px;}
    .comment-date{font-size:11px;color:var(--muted);margin-left:8px;font-weight:400;}
    .comment-text{font-size:14px;color:#555;line-height:1.6;}
    .comment-form textarea{width:100%;padding:12px;border:1.5px solid #e0dbd2;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:14px;resize:vertical;min-height:80px;outline:none;}
    .comment-form textarea:focus{border-color:var(--jade);}
    .comment-submit{background:var(--jade);color:white;border:none;padding:10px 24px;border-radius:8px;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;cursor:pointer;margin-top:10px;transition:background 0.2s;}
    .comment-submit:hover{background:var(--forest);}

    /* RELATED */
    .related-card{display:flex;gap:14px;padding:12px 0;border-bottom:1px solid #f5f5f5;text-decoration:none;color:inherit;transition:opacity 0.2s;}
    .related-card:last-child{border-bottom:none;}
    .related-card:hover{opacity:0.75;}
    .related-thumb{width:70px;height:70px;border-radius:10px;object-fit:cover;background:var(--cream);flex-shrink:0;}
    .related-title{font-size:14px;font-weight:700;color:var(--ink);margin-bottom:4px;line-height:1.3;}
    .related-meta{font-size:12px;color:var(--muted);}

    @media(max-width:900px){.page-body{grid-template-columns:1fr;}.sb-card{position:static;}.summary-grid{grid-template-columns:1fr 1fr 1fr;}}
    @media(max-width:600px){.summary-grid{grid-template-columns:1fr 1fr;}.action-bar{flex-direction:column;}}
</style>
@endsection
@section('content')

{{-- HERO --}}
<div class="iti-hero">
    @if($itinerary->cover_image)
    <img src="{{ asset('storage/'.$itinerary->cover_image) }}" alt="{{ $itinerary->title }}">
    @endif
    <div class="iti-hero-overlay">
        <div class="iti-badges">
            <span class="iti-badge badge-style">{{ $itinerary->travel_style_label }}</span>
            @if($itinerary->is_verified)
            <span class="iti-badge badge-verified">✓ Perjalanan Nyata</span>
            @endif
            @if($itinerary->region)
            <span class="iti-badge badge-region">📍 {{ $itinerary->region->name }}{{ $itinerary->region->province ? ', '.$itinerary->region->province->name : '' }}</span>
            @endif
        </div>
        <h1>{{ $itinerary->title }}</h1>
        <div class="iti-hero-meta">
            <div class="iti-author">
                <div class="author-avatar">{{ strtoupper(substr($itinerary->user->name ?? 'U', 0, 1)) }}</div>
                {{ $itinerary->user->name ?? 'Anonim' }}
            </div>
            <div class="iti-date">{{ \Carbon\Carbon::parse($itinerary->created_at)->isoFormat('D MMMM YYYY') }}</div>
        </div>
        <div class="iti-stats-row">
            <span class="iti-stat">👁 {{ $itinerary->views ?? 0 }} dilihat</span>
            <span class="iti-stat">❤️ {{ $likesCount }} suka</span>
            <span class="iti-stat">💬 {{ $comments->count() }} komentar</span>
            <span class="iti-stat">📋 {{ $itinerary->copies_count ?? 0 }} disalin</span>
        </div>
    </div>
</div>

<div class="page-body">

    {{-- LEFT COLUMN --}}
    <div>

        {{-- ACTION BAR --}}
        <div class="action-bar">
            @auth
            <button class="action-btn btn-like {{ $isLiked ? 'liked' : '' }}" id="likeBtn"
                    onclick="toggleLike({{ $itinerary->id }})">
                <span id="likeHeart">{{ $isLiked ? '❤️' : '🤍' }}</span>
                <span id="likeCount">{{ $likesCount }}</span> Suka
            </button>
            <button class="action-btn btn-save {{ $isSaved ? 'saved' : '' }}" id="saveBtn"
                    onclick="toggleSave({{ $itinerary->id }})">
                {{ $isSaved ? '📌 Tersimpan' : '📋 Salin Itinerary' }}
            </button>
            @endauth
            <button class="action-btn btn-share" onclick="copyLink()">
                🔗 Bagikan
            </button>
        </div>

        {{-- SUMMARY --}}
        @if($itinerary->summary)
        <div class="card">
            <h2>📖 Ringkasan</h2>
            <p style="font-size:15px;color:#444;line-height:1.8;">{{ $itinerary->summary }}</p>
        </div>
        @endif

        {{-- TRIP SUMMARY STATS --}}
        <div class="card">
            <h2>📊 Ringkasan Perjalanan</h2>
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-icon">📅</div>
                    <div class="summary-value">{{ $itinerary->duration_days }} Hari</div>
                    <div class="summary-label">Durasi</div>
                </div>
                <div class="summary-item">
                    <div class="summary-icon">💰</div>
                    <div class="summary-value">{{ $itinerary->budget_label }}</div>
                    <div class="summary-label">Budget Aktual</div>
                </div>
                <div class="summary-item">
                    <div class="summary-icon">{{ $itinerary->travel_style === 'backpacker' ? '🎒' : ($itinerary->travel_style === 'luxury' ? '💎' : '🏡') }}</div>
                    <div class="summary-value">{{ ucfirst($itinerary->travel_style) }}</div>
                    <div class="summary-label">Gaya</div>
                </div>
                <div class="summary-item">
                    <div class="summary-icon">📍</div>
                    <div class="summary-value" style="font-size:14px;">Rp {{ number_format($totalCost,0,',','.') }}</div>
                    <div class="summary-label">Total Stop</div>
                </div>
            </div>
            @if($itinerary->trip_rating)
            <div style="margin-top:16px;padding-top:16px;border-top:1px solid var(--cream);">
                <div style="font-size:13px;color:var(--muted);margin-bottom:6px;">Rating Perjalanan</div>
                <div style="font-size:24px;">
                    @for($i=1;$i<=5;$i++)
                    {{ $i <= $itinerary->trip_rating ? '⭐' : '☆' }}
                    @endfor
                </div>
            </div>
            @endif
            @if($itinerary->tags->count())
            <div style="margin-top:16px;padding-top:16px;border-top:1px solid var(--cream);display:flex;gap:8px;flex-wrap:wrap;">
                @foreach($itinerary->tags as $tag)
                <span style="background:var(--cream);border:1px solid #e0dbd2;padding:4px 12px;border-radius:20px;font-size:13px;color:var(--muted);">{{ $tag->name }}</span>
                @endforeach
            </div>
            @endif
        </div>

        {{-- DAILY ITINERARY --}}
        @foreach($itinerary->days as $day)
        <div class="day-section">
            <div class="day-header">
                <div class="day-num">{{ $day->day_number }}</div>
                <div>
                    <div class="day-title">{{ $day->title ?? 'Hari '.$day->day_number }}</div>
                    @if($day->notes)
                    <div class="day-notes">{{ $day->notes }}</div>
                    @endif
                </div>
            </div>

            <div class="timeline">
                @foreach($day->stops->sortBy('visit_order') as $i => $stop)

                {{-- Transport connector (not before first stop) --}}
                @if($i > 0 && $stop->transport_mode)
                <div class="transport-connector">
                    <div class="connector-line"></div>
                    <div class="connector-pill">
                        🚗 {{ $stop->transport_mode }}
                        @if($stop->transport_cost > 0)
                        · Rp {{ number_format($stop->transport_cost,0,',','.') }}
                        @endif
                    </div>
                </div>
                @endif

                <div class="stop-item">
                    <div class="stop-dot">{{ $stop->icon }}</div>
                    <div class="stop-card">
                        <div class="stop-header">
                            <span class="stop-type">{{ $stop->icon }}</span>
                            <span class="stop-name">{{ $stop->display_name }}</span>
                            @if($stop->time_start)
                            <div class="stop-time">
                                <span class="stop-time-badge">{{ substr($stop->time_start,0,5) }}</span>
                                @if($stop->time_end)
                                <span style="font-size:11px;color:var(--muted);">→</span>
                                <span class="stop-time-badge">{{ substr($stop->time_end,0,5) }}</span>
                                @endif
                            </div>
                            @endif
                        </div>
                        <div class="stop-body">
                            @if($stop->custom_description)
                            <p class="stop-description">{{ $stop->custom_description }}</p>
                            @endif

                            <div class="stop-meta-row">
                                @if($stop->custom_place_name && $stop->stop_type !== 'custom')
                                <span class="stop-meta">📍 {{ $stop->custom_place_name }}</span>
                                @endif
                                @if($stop->cost > 0)
                                <span class="stop-meta">💰 <strong>Rp {{ number_format($stop->cost,0,',','.') }}</strong></span>
                                @endif
                                @if($stop->flightBooking)
                                <span class="stop-meta" style="color:var(--jade);">✓ Booking Terkonfirmasi</span>
                                @endif
                                @if($stop->trainBooking)
                                <span class="stop-meta" style="color:var(--jade);">✓ Tiket Kereta</span>
                                @endif
                                @if($stop->hotelBooking)
                                <span class="stop-meta" style="color:var(--jade);">✓ Hotel Terkonfirmasi</span>
                                @endif
                            </div>

                            @if($stop->tip)
                            <div class="stop-tip">💡 {{ $stop->tip }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        {{-- FULL STORY --}}
        @if($itinerary->body)
        <div class="card">
            <h2>📖 Cerita Lengkap</h2>
            <div style="font-size:15px;color:#444;line-height:1.85;white-space:pre-line;">{{ $itinerary->body }}</div>
        </div>
        @endif

        {{-- TIPS --}}
        @if($itinerary->trip_tips)
        <div class="card">
            <h2>💡 Tips untuk Traveler Lain</h2>
            <div style="font-size:15px;color:#444;line-height:1.85;white-space:pre-line;">{{ $itinerary->trip_tips }}</div>
        </div>
        @endif

        {{-- COMMENTS --}}
        <div class="card">
            <h2>💬 Komentar ({{ $comments->count() }})</h2>
            @if($comments->count())
            @foreach($comments as $c)
            <div class="comment-item">
                <div class="comment-author">
                    {{ $c->user->name ?? 'Anonim' }}
                    <span class="comment-date">{{ \Carbon\Carbon::parse($c->created_at)->isoFormat('D MMM YYYY') }}</span>
                </div>
                <div class="comment-text">{{ $c->comment }}</div>
            </div>
            @endforeach
            @else
            <p style="color:var(--muted);font-size:14px;">Belum ada komentar. Jadilah yang pertama!</p>
            @endif

            @auth
            <div class="comment-form" style="margin-top:20px;padding-top:20px;border-top:1px solid var(--cream);">
                <form action="{{ route('itinerary.comment', $itinerary->id) }}" method="POST">
                    @csrf
                    <textarea name="content" placeholder="Tulis komentarmu..." required></textarea>
                    <button type="submit" class="comment-submit">Kirim Komentar</button>
                </form>
            </div>
            @else
            <p style="margin-top:16px;font-size:13px;color:var(--muted);">
                <a href="{{ route('login') }}" style="color:var(--jade);">Login</a> untuk meninggalkan komentar.
            </p>
            @endauth
        </div>
    </div>

    {{-- RIGHT SIDEBAR --}}
    <div>
        <div class="sb-card">
            <h3>💰 Estimasi Biaya</h3>
            <div class="budget-box">
                <div class="budget-amount">Rp {{ number_format($totalCost,0,',','.') }}</div>
                <div class="budget-note">Total dari semua aktivitas</div>
            </div>
            @if($itinerary->estimated_budget)
            <div class="stat-item">
                <span class="stat-label">Estimasi Awal</span>
                <span class="stat-value">Rp {{ number_format($itinerary->estimated_budget,0,',','.') }}</span>
            </div>
            @endif
            @if($itinerary->actual_budget)
            <div class="stat-item">
                <span class="stat-label">Budget Aktual</span>
                <span class="stat-value">Rp {{ number_format($itinerary->actual_budget,0,',','.') }}</span>
            </div>
            @endif
            <div class="stat-item">
                <span class="stat-label">Durasi</span>
                <span class="stat-value">{{ $itinerary->duration_days }} hari</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Per hari</span>
                <span class="stat-value">Rp {{ $itinerary->duration_days > 0 ? number_format($totalCost/$itinerary->duration_days,0,',','.') : 0 }}</span>
            </div>
        </div>

        @if($related->count())
        <div class="sb-card">
            <h3>🗺️ Itinerary Serupa</h3>
            @foreach($related as $r)
            <a href="{{ route('itinerary.show', $r->slug) }}" class="related-card">
                @if($r->cover_image)
                <img src="{{ asset('storage/'.$r->cover_image) }}" class="related-thumb" alt="{{ $r->title }}">
                @else
                <div class="related-thumb" style="display:flex;align-items:center;justify-content:center;font-size:24px;">🗺️</div>
                @endif
                <div>
                    <div class="related-title">{{ Str::limit($r->title,50) }}</div>
                    <div class="related-meta">{{ $r->duration_days }} hari · {{ $r->likes_count }} suka</div>
                </div>
            </a>
            @endforeach
        </div>
        @endif

        <div class="sb-card">
            <h3>🔗 Bagikan</h3>
            <button onclick="copyLink()" style="width:100%;padding:11px;background:var(--cream);border:1.5px solid #e0dbd2;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;cursor:pointer;color:var(--muted);transition:all 0.2s;" onmouseover="this.style.borderColor='var(--jade)';this.style.color='var(--jade)'" onmouseout="this.style.borderColor='#e0dbd2';this.style.color='var(--muted)'">
                📋 Salin Link
            </button>
        </div>
    </div>

</div>
@endsection
@section('scripts')
<script>
function toggleLike(id) {
    fetch(`/itinerary/${id}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        const btn   = document.getElementById('likeBtn');
        const heart = document.getElementById('likeHeart');
        const count = document.getElementById('likeCount');
        if (heart) heart.textContent = data.liked ? '❤️' : '🤍';
        if (count) count.textContent = data.count;
        if (btn)   btn.classList.toggle('liked', data.liked);
    })
    .catch(e => console.error('Like error:', e));
}

function toggleSave(id) {
    fetch(`/itinerary/${id}/copy`, {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept':'application/json'}
    })
    .then(r => r.json())
    .then(data => {
        const btn = document.getElementById('saveBtn');
        btn.textContent = data.saved ? '📌 Tersimpan' : '📋 Salin Itinerary';
        btn.classList.toggle('saved', data.saved);
    });
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        alert('Link berhasil disalin!');
    });
}
</script>
@endsection