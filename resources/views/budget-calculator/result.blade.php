@extends('layouts.app')
@section('title', 'Estimasi Budget ' . $province->name . ' — NusantaraGuide')
@section('styles')
<style>
    .result-hero{background:linear-gradient(135deg,var(--forest),var(--jade));padding:48px 8%;color:white;}
    .result-hero h1{font-family:'Playfair Display',serif;font-size:clamp(24px,4vw,40px);font-weight:900;margin-bottom:8px;}
    .result-hero p{font-size:15px;opacity:0.75;}
    .back-link{display:inline-flex;align-items:center;gap:6px;color:rgba(255,255,255,0.7);text-decoration:none;font-size:13px;margin-bottom:20px;transition:color 0.2s;}
    .back-link:hover{color:white;}
    .page-body{max-width:1100px;margin:0 auto;padding:40px 8% 80px;display:grid;grid-template-columns:1fr 340px;gap:36px;}
    .card{background:white;border-radius:16px;padding:28px;box-shadow:var(--card-shadow);margin-bottom:24px;}
    .card h2{font-family:'Playfair Display',serif;font-size:20px;color:var(--forest);margin-bottom:20px;padding-bottom:14px;border-bottom:2px solid var(--cream);}
    .grand-total{background:linear-gradient(135deg,var(--forest),var(--jade));color:white;border-radius:16px;padding:28px;margin-bottom:24px;text-align:center;}
    .grand-total .gt-label{font-size:13px;opacity:0.75;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;}
    .grand-total .gt-value{font-family:'Playfair Display',serif;font-size:clamp(28px,5vw,42px);font-weight:900;line-height:1.1;}
    .grand-total .gt-sub{font-size:14px;opacity:0.7;margin-top:10px;}
    .grand-total .gt-pp{margin-top:16px;padding-top:16px;border-top:1px solid rgba(255,255,255,0.2);}
    .grand-total .gt-pp-label{font-size:12px;opacity:0.65;}
    .grand-total .gt-pp-value{font-size:20px;font-weight:700;margin-top:4px;}
    .breakdown-item{display:flex;align-items:center;gap:16px;padding:14px 0;border-bottom:1px solid #f5f5f5;}
    .breakdown-item:last-child{border-bottom:none;}
    .bi-icon{font-size:24px;width:44px;height:44px;background:var(--cream);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .bi-info{flex:1;}
    .bi-label{font-size:13px;font-weight:600;color:var(--ink);}
    .bi-desc{font-size:12px;color:var(--muted);margin-top:2px;}
    .bi-bar-wrap{flex:1;margin:0 16px;}
    .bi-bar{height:8px;background:#f0ede8;border-radius:4px;overflow:hidden;margin-bottom:4px;}
    .bi-bar-fill{height:100%;background:linear-gradient(90deg,var(--lime),var(--jade));border-radius:4px;}
    .bi-amount{font-size:14px;font-weight:700;color:var(--forest);text-align:right;white-space:nowrap;min-width:140px;}
    .style-badge{display:inline-flex;align-items:center;gap:6px;padding:6px 16px;border-radius:20px;font-size:13px;font-weight:700;margin-bottom:8px;}
    .badge-backpacker{background:rgba(116,198,157,0.15);color:var(--jade);}
    .badge-budget{background:rgba(233,196,106,0.15);color:#a0760a;}
    .badge-mid-range{background:rgba(45,106,79,0.12);color:var(--jade);}
    .badge-luxury{background:rgba(231,111,81,0.12);color:var(--coral);}
    .trip-summary{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:24px;}
    .ts-item{background:var(--cream);border-radius:10px;padding:14px;text-align:center;}
    .ts-value{font-family:'Playfair Display',serif;font-size:22px;font-weight:900;color:var(--forest);}
    .ts-label{font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.5px;margin-top:3px;}
    .hotel-card{display:flex;gap:14px;padding:14px 0;border-bottom:1px solid #f5f5f5;text-decoration:none;color:inherit;transition:opacity 0.2s;}
    .hotel-card:last-child{border-bottom:none;}
    .hotel-card:hover{opacity:0.75;}
    .hotel-thumb{width:64px;height:64px;border-radius:10px;object-fit:cover;flex-shrink:0;background:var(--cream);}
    .hotel-name{font-size:14px;font-weight:700;color:var(--ink);margin-bottom:3px;}
    .hotel-price{font-size:13px;color:var(--jade);font-weight:600;}
    .places-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
    .place-mini{background:var(--cream);border-radius:10px;padding:12px;text-decoration:none;color:inherit;display:block;transition:background 0.2s;}
    .place-mini:hover{background:#e8f4ee;}
    .place-mini-name{font-size:13px;font-weight:600;color:var(--ink);}
    .place-mini-price{font-size:12px;color:var(--jade);margin-top:3px;}
    .recalc-btn{display:block;width:100%;padding:13px;background:white;border:2px solid var(--jade);border-radius:10px;color:var(--jade);text-align:center;font-size:14px;font-weight:600;text-decoration:none;transition:all 0.2s;margin-top:16px;}
    .recalc-btn:hover{background:var(--jade);color:white;}
    .share-btn{display:block;width:100%;padding:13px;background:var(--coral);border:none;border-radius:10px;color:white;text-align:center;font-size:14px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all 0.2s;margin-top:10px;}
    .share-btn:hover{background:#d4604a;}
    @media(max-width:900px){.page-body{grid-template-columns:1fr;}.bi-bar-wrap{display:none;}.trip-summary{grid-template-columns:1fr 1fr;}.places-grid{grid-template-columns:1fr;}}
</style>
@endsection
@section('content')
<div class="result-hero">
    <a href="{{ route('budget.index') }}" class="back-link">← Hitung Ulang</a>
    <h1>Estimasi Budget: {{ $province->name }}</h1>
    <p>{{ $days }} hari · {{ $people }} orang · Gaya {{ $style }}</p>
</div>

<div class="page-body">
    <div>
        <!-- TOTAL -->
        <div class="grand-total">
            <div class="gt-label">Total Estimasi Biaya</div>
            <div class="gt-value">
                Rp {{ number_format($grandMin,0,',','.') }}<br>
                <span style="font-size:60%;opacity:0.7;">– Rp {{ number_format($grandMax,0,',','.') }}</span>
            </div>
            <div class="gt-sub">{{ $people }} orang · {{ $days }} hari di {{ $province->name }}</div>
            <div class="gt-pp">
                <div class="gt-pp-label">Per orang</div>
                <div class="gt-pp-value">Rp {{ number_format($totalMinPP,0,',','.') }} – Rp {{ number_format($totalMaxPP,0,',','.') }}</div>
            </div>
        </div>

        <!-- SUMMARY PILLS -->
        <div class="trip-summary">
            <div class="ts-item"><div class="ts-value">{{ $days }}</div><div class="ts-label">Hari</div></div>
            <div class="ts-item"><div class="ts-value">{{ $people }}</div><div class="ts-label">Orang</div></div>
            <div class="ts-item">
                <div class="ts-value" style="font-size:16px;">
                    @if($style==='backpacker')🎒@elseif($style==='budget')💰@elseif($style==='mid-range')🏡@else💎@endif
                </div>
                <div class="ts-label">{{ ucfirst($style) }}</div>
            </div>
        </div>

        <!-- BREAKDOWN -->
        <div class="card">
            <h2>Rincian per Kategori <small style="font-size:13px;color:var(--muted);">(per orang)</small></h2>
            @php $maxVal = max(array_map(fn($b) => $b['max'], $breakdown)); @endphp
            @foreach($breakdown as $key => $b)
            @if($b['max'] > 0)
            <div class="breakdown-item">
                <div class="bi-icon">{{ $b['icon'] }}</div>
                <div class="bi-info">
                    <div class="bi-label">{{ $b['label'] }}</div>
                    <div class="bi-desc">{{ $key === 'hotel' || $key === 'food' || $key === 'activity' || $key === 'transport' ? $days.' hari' : 'Pulang pergi' }}</div>
                </div>
                <div class="bi-bar-wrap">
                    <div class="bi-bar"><div class="bi-bar-fill" style="width:{{ $maxVal > 0 ? round($b['max']/$maxVal*100) : 0 }}%"></div></div>
                </div>
                <div class="bi-amount">
                    Rp {{ number_format($b['min'],0,',','.') }}<br>
                    <span style="font-size:11px;color:var(--muted);">– Rp {{ number_format($b['max'],0,',','.') }}</span>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        <!-- TIPS -->
        <div class="card">
            <h2>💡 Tips Hemat di {{ $province->name }}</h2>
            <div style="font-size:14px;color:#555;line-height:1.8;">
                @if($style === 'backpacker')
                <p>🎒 Cari hostel atau guesthouse lokal yang sering tidak terdaftar di aplikasi — tanya di forum backpacker Indonesia.</p>
                <p>🍜 Makan di pasar tradisional pagi hari untuk sarapan terlezat dan termurah.</p>
                <p>🚌 Gunakan angkutan umum atau nebeng ojek lokal, bukan taksi online untuk jarak dekat.</p>
                @elseif($style === 'budget')
                <p>💰 Bandingkan harga hotel di 2-3 platform sebelum booking. Harga bisa beda jauh.</p>
                <p>🍽️ Makan siang di restoran, makan malam di warung — keseimbangan kualitas dan hemat.</p>
                @elseif($style === 'mid-range')
                <p>🏡 Pesan hotel 2-3 minggu sebelum berangkat untuk early bird rate terbaik.</p>
                <p>🎯 Gabungkan wisata free (pantai, taman) dengan 1-2 atraksi berbayar per hari.</p>
                @else
                <p>💎 Hubungi hotel langsung untuk paket eksklusif yang tidak tersedia di OTA.</p>
                <p>🚁 Pertimbangkan charter private boat atau helikopter untuk pengalaman unik.</p>
                @endif
                @if($trainAvailable)
                <p>🚆 Kereta tersedia untuk {{ $province->name }}! Lebih hemat dan nyaman dari pesawat.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- SIDEBAR -->
    <div>
        <!-- HOTELS -->
        @if($hotels->count())
        <div class="card">
            <h2>🏨 Hotel di {{ $province->name }}</h2>
            @foreach($hotels as $hotel)
            <a href="{{ route('place.show', $hotel->id) }}" class="hotel-card">
                <img src="{{ asset($hotel->image_url ?? 'images/default.jpg') }}" class="hotel-thumb" alt="{{ $hotel->name }}" onerror="this.style.background='#e8f4ee';this.style.display='none';">
                <div>
                    <div class="hotel-name">{{ $hotel->name }}</div>
                    <div class="hotel-price">
                        @if($hotel->rooms->first())
                        Mulai Rp {{ number_format($hotel->rooms->first()->price_per_night,0,',','.') }}/malam
                        @else — @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @endif

        <!-- TOP PLACES -->
        @if($places->count())
        <div class="card">
            <h2>📍 Tempat Wisata</h2>
            <div class="places-grid">
                @foreach($places->take(6) as $place)
                <a href="{{ route('place.show', $place->id) }}" class="place-mini">
                    <div class="place-mini-name">{{ Str::limit($place->name, 28) }}</div>
                    <div class="place-mini-price">@if($place->price_start==0)Gratis @else Rp {{ number_format($place->price_start/1000,0).'rb' }}@endif</div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- ACTIONS -->
        <div class="card">
            <h2>Langkah Selanjutnya</h2>
            <a href="{{ route('budget.index') }}" class="recalc-btn">🔄 Hitung Ulang</a>
            <a href="{{ route('transportation.index', ['type'=>'flight']) }}" class="recalc-btn" style="margin-top:10px;">✈️ Cari Tiket Pesawat</a>
            <a href="{{ route('places.browse', ['province'=>$province->id ?? '']) }}" class="recalc-btn" style="margin-top:10px;">📍 Lihat Tempat Wisata</a>
            <button class="share-btn" onclick="copyLink()">📋 Salin Link Estimasi Ini</button>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        const btn = document.querySelector('.share-btn');
        btn.textContent = '✓ Link tersalin!';
        setTimeout(() => btn.textContent = '📋 Salin Link Estimasi Ini', 2000);
    });
}
</script>
@endsection