@extends('layouts.app')
@section('title', $place->name . ' — NusantaraGuide')
@section('styles')
<style>
    .place-hero{width:100%;height:460px;position:relative;overflow:hidden;background:var(--forest);}
    .place-hero img{width:100%;height:100%;object-fit:cover;opacity:0.85;}
    .place-hero-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(13,27,19,0.85) 0%,rgba(0,0,0,0.1) 60%);padding:40px 8%;display:flex;flex-direction:column;justify-content:flex-end;}
    .breadcrumb{font-size:13px;color:rgba(255,255,255,0.6);display:flex;align-items:center;gap:8px;margin-bottom:14px;flex-wrap:wrap;}
    .breadcrumb a{color:rgba(255,255,255,0.6);text-decoration:none;}
    .breadcrumb a:hover{color:var(--lime);}
    .place-hero-title{font-family:'Playfair Display',serif;font-size:clamp(28px,5vw,52px);color:white;font-weight:900;line-height:1.15;margin-bottom:14px;}
    .place-hero-meta{display:flex;align-items:center;gap:20px;flex-wrap:wrap;}
    .hero-badge{padding:5px 14px;border-radius:20px;font-size:13px;font-weight:600;}
    .badge-cat{background:var(--coral);color:white;}
    .badge-region{background:rgba(255,255,255,0.15);color:white;border:1px solid rgba(255,255,255,0.3);}
    .badge-verified{background:rgba(116,198,157,0.25);color:var(--lime);border:1px solid rgba(116,198,157,0.4);}
    .hero-rating{display:flex;align-items:center;gap:6px;color:var(--gold);font-weight:600;font-size:16px;}
    .hero-rating span{color:rgba(255,255,255,0.7);font-size:13px;font-weight:400;}
    .page-body{display:grid;grid-template-columns:1fr 340px;gap:40px;padding:48px 8%;max-width:1300px;margin:0 auto;}
    .section-card{background:white;border-radius:16px;padding:32px;box-shadow:var(--card-shadow);margin-bottom:24px;}
    .section-card h2{font-family:'Playfair Display',serif;font-size:22px;color:var(--forest);margin-bottom:18px;padding-bottom:14px;border-bottom:2px solid var(--cream);}
    .description-text{font-size:15px;line-height:1.85;color:#444;}
    .facilities-grid{display:flex;flex-wrap:wrap;gap:10px;}
    .facility-chip{display:flex;align-items:center;gap:6px;background:var(--cream);border:1px solid #e8e3da;padding:7px 14px;border-radius:20px;font-size:13px;color:var(--ink);font-weight:500;}
    .hours-grid{display:grid;gap:0;}
    .hours-row{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid #f5f5f5;font-size:14px;}
    .hours-row:last-child{border-bottom:none;}
    .hours-day{font-weight:500;color:var(--ink);}
    .hours-time{color:var(--muted);}
    .hours-closed{color:var(--coral);font-weight:500;}
    .hours-today{background:rgba(45,106,79,0.06);margin:0 -8px;padding:10px 8px;border-radius:8px;}
    .hours-today .hours-day{color:var(--jade);font-weight:700;}
    .rating-summary{display:flex;align-items:center;gap:32px;padding:20px 0;margin-bottom:24px;border-bottom:2px solid var(--cream);}
    .rating-big{text-align:center;}
    .rating-big .num{font-family:'Playfair Display',serif;font-size:56px;font-weight:900;color:var(--forest);line-height:1;}
    .rating-big .stars{color:var(--gold);font-size:20px;margin:6px 0;}
    .rating-big .count{font-size:13px;color:var(--muted);}
    .rating-bars{flex:1;}
    .rating-bar-row{display:flex;align-items:center;gap:10px;margin-bottom:6px;}
    .rating-bar-label{font-size:13px;color:var(--muted);width:16px;text-align:right;}
    .rating-bar-track{flex:1;height:8px;background:#f0ede8;border-radius:4px;overflow:hidden;}
    .rating-bar-fill{height:100%;background:var(--gold);border-radius:4px;}
    .rating-bar-count{font-size:12px;color:var(--muted);width:20px;}
    .review-list{display:flex;flex-direction:column;gap:20px;}
    .review-item{padding:18px 0;border-bottom:1px solid #f5f5f5;}
    .review-item:last-child{border-bottom:none;}
    .review-header{display:flex;align-items:center;gap:12px;margin-bottom:8px;}
    .review-avatar{width:38px;height:38px;border-radius:50%;background:var(--lime);display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:700;color:var(--forest);flex-shrink:0;}
    .review-name{font-weight:600;font-size:14px;color:var(--ink);}
    .review-date{font-size:12px;color:var(--muted);}
    .review-stars{color:var(--gold);font-size:14px;margin-bottom:6px;}
    .review-text{font-size:14px;color:#555;line-height:1.7;}
    .write-review{background:var(--cream);border-radius:12px;padding:24px;margin-top:24px;}
    .write-review h3{font-size:16px;font-weight:600;color:var(--forest);margin-bottom:16px;}
    .star-select{display:flex;gap:8px;margin-bottom:16px;}
    .star-btn{font-size:28px;background:none;border:none;cursor:pointer;transition:transform 0.15s;line-height:1;}
    .star-btn:hover{transform:scale(1.2);}
    .review-textarea{width:100%;padding:12px 16px;border:1px solid #ddd;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:14px;resize:vertical;min-height:90px;outline:none;transition:border-color 0.2s;}
    .review-textarea:focus{border-color:var(--jade);}
    .submit-btn{margin-top:12px;background:var(--jade);color:white;border:none;padding:11px 28px;border-radius:8px;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;cursor:pointer;transition:background 0.2s;}
    .submit-btn:hover{background:var(--forest);}
    .sidebar{display:flex;flex-direction:column;gap:20px;}
    .sidebar-card{background:white;border-radius:16px;padding:24px;box-shadow:var(--card-shadow);}
    .sidebar-card h3{font-size:15px;font-weight:700;color:var(--forest);margin-bottom:16px;}
    .info-list{display:flex;flex-direction:column;gap:14px;}
    .info-row{display:flex;gap:12px;align-items:flex-start;}
    .info-icon{font-size:18px;flex-shrink:0;margin-top:1px;}
    .info-label{font-size:12px;color:var(--muted);margin-bottom:2px;}
    .info-value{font-size:14px;font-weight:500;color:var(--ink);}
    .info-value a{color:var(--jade);text-decoration:none;}
    .price-box{background:linear-gradient(135deg,var(--jade),var(--forest));color:white;border-radius:12px;padding:20px;text-align:center;}
    .price-label{font-size:12px;opacity:0.75;margin-bottom:6px;letter-spacing:0.5px;text-transform:uppercase;}
    .price-value{font-family:'Playfair Display',serif;font-size:28px;font-weight:900;}
    .price-sub{font-size:12px;opacity:0.7;margin-top:4px;}
    .fav-btn{width:100%;padding:12px;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all 0.2s;border:2px solid var(--coral);display:flex;align-items:center;justify-content:center;gap:8px;}
    .fav-btn.not-fav{background:white;color:var(--coral);}
    .fav-btn.is-fav{background:var(--coral);color:white;}
    .fav-btn:hover{opacity:0.85;transform:translateY(-1px);}
    .map-box{background:var(--cream);border-radius:10px;height:180px;display:flex;flex-direction:column;align-items:center;justify-content:center;border:2px dashed #ddd;gap:8px;}
    .map-box span{font-size:32px;}
    .map-box p{font-size:13px;color:var(--muted);}
    .map-link{font-size:13px;font-weight:600;color:var(--jade);text-decoration:none;margin-top:4px;}
    .map-link:hover{text-decoration:underline;}
    .nearby-list{display:flex;flex-direction:column;gap:12px;}
    .nearby-item{display:flex;gap:12px;align-items:center;text-decoration:none;color:inherit;transition:opacity 0.2s;}
    .nearby-item:hover{opacity:0.75;}
    .nearby-thumb{width:54px;height:54px;border-radius:10px;object-fit:cover;flex-shrink:0;background:var(--cream);}
    .nearby-name{font-size:14px;font-weight:600;color:var(--ink);}
    .nearby-cat{font-size:12px;color:var(--muted);margin-top:2px;}
    .alert-success{background:rgba(116,198,157,0.15);border:1px solid var(--lime);color:var(--jade);padding:12px 18px;border-radius:8px;font-size:14px;margin-bottom:16px;}
    @media(max-width:900px){.page-body{grid-template-columns:1fr;}.sidebar{order:-1;}.rating-summary{flex-direction:column;align-items:flex-start;gap:16px;}}
</style>
@endsection
@section('content')
<div class="place-hero">
    <img src="{{ asset($place->image_url ?? 'images/default.jpg') }}" alt="{{ $place->name }}" onerror="this.style.display='none'">
    <div class="place-hero-overlay">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a> /
            <a href="{{ route('places.browse') }}">Tempat</a> /
            @if($place->region)<a href="{{ route('region.show', [$place->region->province->slug ?? 'indonesia', $place->region->slug ?? $place->region->id]) }}">{{ $place->region->name }}</a> /@endif
            <span style="color:rgba(255,255,255,0.9);">{{ $place->name }}</span>
        </div>
        <div class="place-hero-title">{{ $place->name }}</div>
        <div class="place-hero-meta">
            @if($place->category)<span class="hero-badge badge-cat">{{ $place->category->icon ?? '' }} {{ $place->category->name }}</span>@endif
            @if($place->region)<span class="hero-badge badge-region">📍 {{ $place->region->name }}</span>@endif
            @if($place->is_verified)<span class="hero-badge badge-verified">✓ Terverifikasi</span>@endif
            @if($avgRating)<div class="hero-rating">★ {{ number_format($avgRating,1) }}<span>({{ $place->reviews->count() }} ulasan)</span></div>@endif
        </div>
    </div>
</div>

<div class="page-body">
    <div class="left-col">
        @if(session('success'))<div class="alert-success">✓ {{ session('success') }}</div>@endif

        <div class="section-card">
            <h2>Tentang Tempat Ini</h2>
            <p class="description-text">{{ $place->description ?? 'Belum ada deskripsi untuk tempat ini.' }}</p>
        </div>

        @if($place->facilities->count())
        <div class="section-card">
            <h2>Fasilitas</h2>
            <div class="facilities-grid">
                @foreach($place->facilities as $facility)
                <div class="facility-chip"><span>{{ $facility->icon ?? '✓' }}</span>{{ $facility->name }}</div>
                @endforeach
            </div>
        </div>
        @endif

        @if($place->category_id == 3 && $place->rooms->count())
        <div class="section-card">
            <h2>Pilihan Kamar 🛏️</h2>
            @if(isset($userBooking) && $userBooking)
            <div style="background:rgba(45,106,79,0.08);border:1px solid var(--lime);border-radius:10px;padding:14px 18px;margin-bottom:20px;font-size:14px;color:var(--jade);">
                ✓ Kamu memiliki booking aktif di hotel ini.
                <a href="{{ route('bookings.show', $userBooking->id) }}" style="font-weight:700;color:var(--jade);margin-left:8px;">Lihat Booking →</a>
            </div>
            @endif
            <div style="display:flex;flex-direction:column;gap:16px;">
                @foreach($place->rooms as $room)
                <div style="border:1.5px solid #e8e3da;border-radius:14px;padding:20px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;">
                    <div style="flex:1;min-width:200px;">
                        <div style="font-size:17px;font-weight:700;color:var(--ink);margin-bottom:4px;">{{ $room->name }}</div>
                        @if($room->description)<div style="font-size:13px;color:var(--muted);line-height:1.6;margin-bottom:8px;">{{ $room->description }}</div>@endif
                        <span style="font-size:12px;color:var(--muted);">👥 Maks. {{ $room->max_guests }} tamu</span>
                        @if(!$room->is_available)<span style="font-size:12px;color:var(--coral);font-weight:600;margin-left:12px;">✗ Tidak tersedia</span>@endif
                    </div>
                    <div style="text-align:right;flex-shrink:0;">
                        <div style="font-family:'Playfair Display',serif;font-size:22px;font-weight:900;color:var(--forest);">{{ $room->price_label }}</div>
                        <div style="font-size:12px;color:var(--muted);margin-bottom:12px;">per malam</div>
                        @auth
                            @if($room->is_available)
                            <a href="{{ route('booking.create', $room->id) }}" style="display:inline-block;background:var(--coral);color:white;padding:10px 22px;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;">Pesan Kamar →</a>
                            @else
                            <span style="display:inline-block;background:#ddd;color:#999;padding:10px 22px;border-radius:8px;font-size:14px;font-weight:700;">Tidak Tersedia</span>
                            @endif
                        @else
                        <a href="{{ route('login') }}" style="display:inline-block;background:var(--jade);color:white;padding:10px 22px;border-radius:8px;font-size:14px;font-weight:700;text-decoration:none;">Login untuk Memesan</a>
                        @endauth
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($place->operatingHours->count())
        <div class="section-card">
            <h2>Jam Operasional</h2>
            <div class="hours-grid">
                @php $days=['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];$dayLabels=['Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu','Sunday'=>'Minggu'];$todayEn=now()->format('l');$hoursByDay=$place->operatingHours->keyBy('day_of_week'); @endphp
                @foreach($days as $day)
                    @if(isset($hoursByDay[$day]))
                    @php $h=$hoursByDay[$day]; @endphp
                    <div class="hours-row {{ $day===$todayEn?'hours-today':'' }}">
                        <span class="hours-day">{{ $dayLabels[$day] }}@if($day===$todayEn)<small style="color:var(--jade);font-size:11px;"> (Hari ini)</small>@endif</span>
                        @if($h->is_closed)
                            <span class="hours-closed">Tutup</span>
                        @else
                            <span class="hours-time">{{ substr($h->open_time,0,5) }} – {{ substr($h->close_time,0,5) }}</span>
                        @endif
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        @if($place->events->count())
        <div class="section-card">
            <h2>Event Mendatang</h2>
            @foreach($place->events as $event)
            <div style="padding:14px 0;border-bottom:1px solid #f5f5f5;">
                <div style="font-weight:600;font-size:15px;color:var(--ink);margin-bottom:4px;">{{ $event->name }}</div>
                <div style="font-size:13px;color:var(--muted);margin-bottom:6px;">
                    📅 {{ $event->start_date->isoFormat('D MMM YYYY') }}
                    @if($event->price > 0)
                        · Rp {{ number_format($event->price,0,',','.') }}
                    @else
                        · Gratis
                    @endif
                </div>
                <div style="font-size:14px;color:#555;">{{ $event->description }}</div>
            </div>
            @endforeach
        </div>
        @endif

        <div class="section-card">
            <h2>Ulasan</h2>
            @if($place->reviews->count())
            <div class="rating-summary">
                <div class="rating-big">
                    <div class="num">{{ number_format($avgRating,1) }}</div>
                    <div class="stars">@for($i=1;$i<=5;$i++){{ $i<=round($avgRating)?'★':'☆' }}@endfor</div>
                    <div class="count">{{ $place->reviews->count() }} ulasan</div>
                </div>
                <div class="rating-bars">
                    @for($star=5;$star>=1;$star--)
                    @php $count=$ratingBreakdown[$star]??0;$pct=$place->reviews->count()?($count/$place->reviews->count()*100):0; @endphp
                    <div class="rating-bar-row">
                        <span class="rating-bar-label">{{ $star }}</span>
                        <div class="rating-bar-track"><div class="rating-bar-fill" style="width:{{ $pct }}%"></div></div>
                        <span class="rating-bar-count">{{ $count }}</span>
                    </div>
                    @endfor
                </div>
            </div>
            <div class="review-list">
                @foreach($place->reviews->take(5) as $review)
                <div class="review-item">
                    <div class="review-header">
                        <div class="review-avatar">{{ strtoupper(substr($review->user->name??'A',0,1)) }}</div>
                        <div>
                            <div class="review-name">{{ $review->user->name??'Pengguna' }}</div>
                            <div class="review-date">{{ $review->created_at?\Carbon\Carbon::parse($review->created_at)->diffForHumans():'' }}</div>
                        </div>
                    </div>
                    <div class="review-stars">@for($i=1;$i<=5;$i++){{ $i<=$review->rating?'★':'☆' }}@endfor</div>
                    <div class="review-text">{{ $review->comment }}</div>
                </div>
                @endforeach
            </div>
            @else
            <p style="color:var(--muted);font-size:14px;padding:20px 0;">Belum ada ulasan. Jadilah yang pertama!</p>
            @endif
            @auth
                @if(!$userReview)
                <div class="write-review">
                    <h3>Tulis Ulasanmu</h3>
                    <form action="{{ route('review.store', $place->id) }}" method="POST">
                        @csrf
                        <div class="star-select">
                            @for($i=1;$i<=5;$i++)<button type="button" class="star-btn" onclick="setRating({{ $i }})" id="star-{{ $i }}">☆</button>@endfor
                            <input type="hidden" name="rating" id="rating-input" value="0">
                        </div>
                        <textarea name="comment" class="review-textarea" placeholder="Ceritakan pengalamanmu di sini..."></textarea>
                        <button type="submit" class="submit-btn">Kirim Ulasan</button>
                    </form>
                </div>
                @else
                <div style="margin-top:20px;padding:16px;background:rgba(116,198,157,0.1);border-radius:10px;font-size:14px;color:var(--jade);">✓ Kamu sudah memberikan ulasan untuk tempat ini.</div>
                @endif
            @else
            <div style="margin-top:20px;padding:16px;background:var(--cream);border-radius:10px;font-size:14px;color:var(--muted);text-align:center;"><a href="{{ route('login') }}" style="color:var(--jade);font-weight:600;">Login</a> untuk memberikan ulasan.</div>
            @endauth
        </div>
    </div>

    <div class="sidebar">
        <div class="price-box">
            <div class="price-label">Harga Masuk</div>
            @if($place->price_start==0)<div class="price-value">Gratis</div>
            @else<div class="price-value">Rp {{ number_format($place->price_start,0,',','.') }}</div>
            @if($place->price_end)<div class="price-sub">– Rp {{ number_format($place->price_end,0,',','.') }}</div>@endif
            @endif
        </div>
        @auth
        <form action="{{ route('favorite.toggle', $place->id) }}" method="POST">
            @csrf
            @php $isFav=Auth::user()->favorites->contains($place->id); @endphp
            <button type="submit" class="fav-btn {{ $isFav?'is-fav':'not-fav' }}">{{ $isFav?'❤️ Tersimpan di Favorit':'🤍 Simpan ke Favorit' }}</button>
        </form>
        @endauth
        <div class="sidebar-card">
            <h3>Informasi</h3>
            <div class="info-list">
                <div class="info-row"><span class="info-icon">📍</span><div><div class="info-label">Alamat</div><div class="info-value">{{ $place->address }}</div></div></div>
                @if($place->phone)<div class="info-row"><span class="info-icon">📞</span><div><div class="info-label">Telepon</div><div class="info-value"><a href="tel:{{ $place->phone }}">{{ $place->phone }}</a></div></div></div>@endif
                @if($place->website)<div class="info-row"><span class="info-icon">🌐</span><div><div class="info-label">Website</div><div class="info-value"><a href="{{ $place->website }}" target="_blank">Kunjungi Website</a></div></div></div>@endif
                @if($place->region)<div class="info-row"><span class="info-icon">🗺️</span><div><div class="info-label">Wilayah</div><div class="info-value">{{ $place->region->name }}@if($place->region->province), {{ $place->region->province->name }}@endif</div></div></div>@endif
            </div>
        </div>
        <div class="sidebar-card">
            <h3>Lokasi</h3>
            @if($place->latitude && $place->longitude)
            <a href="https://www.google.com/maps?q={{ $place->latitude }},{{ $place->longitude }}" target="_blank" style="display:block;text-decoration:none;">
                <div class="map-box"><span>🗺️</span><p>{{ $place->latitude }}, {{ $place->longitude }}</p><span class="map-link">Buka di Google Maps →</span></div>
            </a>
            @else<div class="map-box"><span>📍</span><p style="font-size:13px;color:var(--muted);">Koordinat belum tersedia</p></div>@endif
        </div>
        @if($nearby->count())
        <div class="sidebar-card">
            <h3>Tempat Terdekat</h3>
            <div class="nearby-list">
                @foreach($nearby as $n)
                <a href="{{ route('place.show', $n->id) }}" class="nearby-item">
                    <img src="{{ asset($n->image_url??'images/default.jpg') }}" class="nearby-thumb" alt="{{ $n->name }}" onerror="this.style.background='#e8f4ee';this.style.display='none'">
                    <div><div class="nearby-name">{{ $n->name }}</div><div class="nearby-cat">{{ $n->category->name??'' }}</div></div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
@section('scripts')
<script>
function setRating(val) {
    document.getElementById('rating-input').value=val;
    for(let i=1;i<=5;i++) document.getElementById('star-'+i).textContent=i<=val?'★':'☆';
}
</script>
@endsection