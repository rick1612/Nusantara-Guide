@extends('layouts.app')
@section('title', 'Panduan Musim ' . $province->name . ' — NusantaraGuide')
@section('styles')
<style>

    /* HERO */
    body .hero{
        background:linear-gradient(160deg,rgba(13,27,19,0.82) 0%,rgba(26,58,42,0.68) 100%),
                   url('{{ asset($province->image_url ?? "") }}') center/cover no-repeat;
        padding:64px 8% 52px;color:white;min-height:300px;
        display:flex;flex-direction:column;justify-content:flex-end;
    }
    .back-link{color:rgba(255,255,255,0.65);text-decoration:none;font-size:13px;
               display:inline-flex;align-items:center;gap:6px;margin-bottom:24px;transition:color 0.2s;}
    .back-link:hover{color:white;}
    .hero h1{font-family:'Playfair Display',serif;font-size:clamp(30px,5vw,52px);font-weight:900;margin-bottom:8px;line-height:1.15;}
    .hero p{font-size:16px;opacity:0.72;max-width:520px;line-height:1.6;}

    /* PAGE LAYOUT */
    .page-wrap{max-width:1140px;margin:0 auto;padding:48px 8% 100px;}

    /* PREFERENCE PANEL */
    .pref-panel{background:white;border-radius:20px;padding:40px;box-shadow:var(--card-shadow);margin-bottom:32px;}
    .pref-header{margin-bottom:32px;}
    .pref-header h2{font-family:'Playfair Display',serif;font-size:26px;color:var(--forest);margin-bottom:8px;}
    .pref-header p{font-size:15px;color:var(--muted);line-height:1.65;max-width:600px;}
    .pref-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-bottom:36px;}
    .pref-group{background:var(--cream);border-radius:14px;padding:24px;}
    .pref-group-title{font-size:13px;font-weight:700;letter-spacing:0.8px;text-transform:uppercase;
                      color:var(--forest);display:flex;align-items:center;gap:8px;margin-bottom:20px;}
    .pref-group-title span{font-size:20px;}
    .pref-options{display:flex;flex-direction:column;gap:10px;}
    .pref-opt{position:relative;}
    .pref-opt input[type=radio]{position:absolute;opacity:0;width:0;height:0;}
    .pref-opt-inner{display:flex;flex-direction:column;gap:4px;padding:14px 16px;border-radius:10px;
                    border:2px solid #e0dbd2;background:white;cursor:pointer;transition:all 0.2s;}
    .pref-opt input:checked + .pref-opt-inner{border-color:var(--jade);background:rgba(45,106,79,0.05);}
    .pref-opt-inner:hover{border-color:#b0c8ba;}
    .pref-opt-row{display:flex;align-items:center;justify-content:space-between;}
    .pref-opt-name{font-size:14px;font-weight:600;color:var(--ink);}
    .pref-opt-badge{font-size:10px;padding:3px 9px;border-radius:10px;font-weight:700;letter-spacing:0.3px;}
    .badge-penting{background:rgba(45,106,79,0.12);color:var(--jade);}
    .badge-fleksibel{background:rgba(107,124,114,0.1);color:var(--muted);}
    .pref-opt-desc{font-size:12px;color:var(--muted);line-height:1.4;}
    .apply-btn{display:flex;align-items:center;justify-content:center;gap:10px;
               width:100%;max-width:320px;padding:16px 32px;
               background:var(--jade);color:white;border:none;border-radius:12px;
               font-family:'DM Sans',sans-serif;font-size:16px;font-weight:700;cursor:pointer;
               transition:all 0.2s;margin:0 auto;}
    .apply-btn:hover{background:var(--forest);transform:translateY(-2px);}

    /* RESULT BANNER */
    .result-banner{border-radius:16px;padding:22px 28px;margin-bottom:32px;
                   display:flex;align-items:center;gap:18px;}
    .result-banner.great{background:rgba(116,198,157,0.12);border:2px solid rgba(116,198,157,0.35);}
    .result-banner.warn{background:rgba(233,196,106,0.12);border:2px solid rgba(233,196,106,0.35);}
    .rb-icon{font-size:36px;flex-shrink:0;}
    .rb-title{font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:var(--forest);margin-bottom:4px;}
    .rb-text{font-size:14px;color:var(--muted);line-height:1.5;}

    /* MAIN CONTENT GRID */
    .content-grid{display:grid;grid-template-columns:1fr 320px;gap:32px;}

    /* CALENDAR */
    .cal-card{background:white;border-radius:20px;padding:32px;box-shadow:var(--card-shadow);margin-bottom:24px;}
    .cal-card h2{font-family:'Playfair Display',serif;font-size:20px;color:var(--forest);
                 margin-bottom:6px;}
    .cal-subtitle{font-size:13px;color:var(--muted);margin-bottom:24px;}
    .cal-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;}
    .cal-month{border-radius:14px;padding:16px;cursor:pointer;transition:all 0.25s;
               border:2px solid transparent;display:block;position:relative;overflow:hidden;}
    .cal-month:hover{transform:translateY(-3px);box-shadow:0 8px 20px rgba(0,0,0,0.1);}
    .cal-month.match-great{background:rgba(34,197,94,0.1);border-color:rgba(34,197,94,0.45);}
    .cal-month.match-good{background:rgba(116,198,157,0.1);border-color:rgba(116,198,157,0.38);}
    .cal-month.match-ok{background:rgba(245,158,11,0.08);border-color:rgba(245,158,11,0.3);}
    .cal-month.match-poor{background:rgba(231,111,81,0.06);border-color:rgba(231,111,81,0.22);}
    .cal-month.is-current{outline:3px solid var(--jade);outline-offset:2px;}
    .score-bar{position:absolute;bottom:0;left:0;right:0;height:5px;}
    .score-fill{height:100%;transition:width 0.5s cubic-bezier(.4,0,.2,1);}
    .fill-great{background:linear-gradient(90deg,#22c55e,#16a34a);}
    .fill-good{background:linear-gradient(90deg,var(--lime),var(--jade));}
    .fill-ok{background:linear-gradient(90deg,#fbbf24,#f59e0b);}
    .fill-poor{background:linear-gradient(90deg,#f87171,#ef4444);}
    .cm-name{font-size:14px;font-weight:700;color:var(--ink);margin-bottom:8px;}
    .cm-weather{font-size:12px;color:var(--muted);display:flex;align-items:center;gap:5px;margin-bottom:4px;}
    .weather-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}
    .dot-cerah{background:#22c55e;} .dot-berawan{background:#f59e0b;} .dot-hujan{background:#3b82f6;}
    .cm-price{font-size:12px;font-weight:600;margin-bottom:6px;}
    .price-rendah{color:#16a34a;} .price-sedang{color:#d97706;}
    .price-tinggi{color:#ea580c;} .price-tertinggi{color:#dc2626;}
    .cm-badges{display:flex;gap:4px;flex-wrap:wrap;}
    .cm-badge{font-size:10px;padding:2px 7px;border-radius:8px;font-weight:600;}
    .badge-festival{background:rgba(233,196,106,0.25);color:#a0760a;}
    .badge-current{background:var(--jade);color:white;}
    .cm-match{font-size:11px;font-weight:700;margin-top:6px;}

    /* DETAIL PANEL */
    .detail-panel{background:var(--cream);border-radius:14px;padding:24px;margin-top:24px;}
    .detail-panel-title{font-size:16px;font-weight:700;color:var(--forest);margin-bottom:16px;}
    .detail-placeholder{font-size:14px;color:var(--muted);line-height:1.7;}
    .detail-row{display:flex;align-items:flex-start;gap:14px;padding:12px 0;border-bottom:1px solid #ddd8d0;}
    .detail-row:last-child{border-bottom:none;}
    .detail-icon{font-size:20px;width:34px;text-align:center;flex-shrink:0;margin-top:1px;}
    .detail-label{font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.5px;font-weight:600;margin-bottom:3px;}
    .detail-value{font-size:14px;font-weight:600;color:var(--ink);}
    .detail-tip{background:white;border-radius:10px;padding:16px;margin-top:16px;
                font-size:14px;color:#555;line-height:1.75;border-left:4px solid var(--jade);}
    .match-score-display{background:white;border-radius:12px;padding:16px 18px;
                         margin-top:16px;display:flex;align-items:center;gap:14px;}
    .score-circle{width:58px;height:58px;border-radius:50%;display:flex;align-items:center;
                  justify-content:center;font-size:17px;font-weight:900;flex-shrink:0;}
    .score-great{background:rgba(34,197,94,0.15);color:#16a34a;}
    .score-good{background:rgba(116,198,157,0.2);color:var(--jade);}
    .score-ok{background:rgba(245,158,11,0.15);color:#d97706;}
    .score-poor{background:rgba(231,111,81,0.12);color:var(--coral);}
    .score-label{font-weight:700;color:var(--forest);font-size:15px;margin-bottom:3px;}
    .score-sub{font-size:12px;color:var(--muted);}

    /* LEGEND */
    .legend{display:flex;gap:20px;flex-wrap:wrap;font-size:13px;
            padding:16px 24px;background:white;border-radius:12px;box-shadow:var(--card-shadow);}
    .legend-item{display:flex;align-items:center;gap:7px;color:var(--muted);}
    .legend-dot{width:12px;height:12px;border-radius:4px;}

    /* SIDEBAR CARDS */
    .sb-card{background:white;border-radius:16px;padding:24px;box-shadow:var(--card-shadow);margin-bottom:20px;}
    .sb-card h3{font-family:'Playfair Display',serif;font-size:17px;color:var(--forest);margin-bottom:16px;}
    .top-months-list{display:flex;flex-direction:column;gap:10px;}
    .top-month-row{display:flex;align-items:center;justify-content:space-between;
                   padding:12px 14px;background:var(--cream);border-radius:10px;}
    .tm-rank{font-size:16px;width:24px;}
    .tm-name{font-size:14px;font-weight:600;color:var(--ink);flex:1;margin-left:8px;}
    .tm-score{font-size:13px;font-weight:700;}
    .tm-bar{height:3px;background:#e8e3da;border-radius:2px;margin-top:6px;overflow:hidden;}
    .tm-bar-fill{height:100%;border-radius:2px;}
    .festival-item{padding:12px 0;border-bottom:1px solid #f5f5f5;}
    .festival-item:last-child{border-bottom:none;}
    .festival-month{font-size:12px;font-weight:700;color:var(--jade);text-transform:uppercase;
                    letter-spacing:0.5px;margin-bottom:4px;}
    .festival-name{font-size:13px;color:var(--ink);}
    .province-picker{width:100%;padding:11px 14px;border:1.5px solid #e0dbd2;border-radius:10px;
                     font-family:'DM Sans',sans-serif;font-size:14px;margin-bottom:12px;
                     outline:none;color:var(--ink);background:var(--cream);}
    .province-picker:focus{border-color:var(--jade);}
    .go-btn{width:100%;padding:12px;background:var(--jade);color:white;border:none;
            border-radius:10px;font-family:'DM Sans',sans-serif;font-size:14px;
            font-weight:700;cursor:pointer;transition:background 0.2s;}
    .go-btn:hover{background:var(--forest);}
    .action-link{display:flex;align-items:center;gap:10px;padding:13px 16px;
                 background:var(--cream);border-radius:10px;text-decoration:none;
                 color:var(--ink);font-size:14px;font-weight:500;transition:all 0.2s;margin-bottom:8px;}
    .action-link:last-child{margin-bottom:0;}
    .action-link:hover{background:#e0ece6;color:var(--jade);}
    .action-link span{font-size:18px;}

    @media(max-width:960px){
        .content-grid{grid-template-columns:1fr;}
        .pref-grid{grid-template-columns:1fr;}
        .cal-grid{grid-template-columns:repeat(3,1fr);}
    }
    @media(max-width:500px){
        .cal-grid{grid-template-columns:repeat(2,1fr);}
        .pref-panel{padding:24px;}
    }
</style>
@endsection
@section('content')

<div class="hero">
    <a href="{{ route('seasonal.index') }}" class="back-link">← Panduan Musim</a>
    <h1>{{ $province->name }}</h1>
    <p>Sesuaikan preferensimu dan temukan bulan terbaik versimu sendiri.</p>
</div>

<div class="page-wrap">

    <!-- PREFERENCE PANEL -->
    <div class="pref-panel">
        <div class="pref-header">
            <h2>⚙️ Apa yang paling penting bagimu?</h2>
            <p>Waktu terbaik berbeda untuk setiap orang. Pilih prioritasmu — sistem kami akan mencocokkan setiap bulan sesuai kebutuhanmu secara otomatis.</p>
        </div>

        <div class="pref-grid">
            <!-- WEATHER -->
            <div class="pref-group">
                <div class="pref-group-title"><span>☀️</span> Cuaca</div>
                <div class="pref-options">
                    <label class="pref-opt">
                        <input type="radio" name="pref_weather" value="3" checked>
                        <div class="pref-opt-inner">
                            <div class="pref-opt-row">
                                <span class="pref-opt-name">Harus cerah</span>
                                <span class="pref-opt-badge badge-penting">Penting</span>
                            </div>
                            <span class="pref-opt-desc">Hujan adalah deal breaker buatku</span>
                        </div>
                    </label>
                    <label class="pref-opt">
                        <input type="radio" name="pref_weather" value="2">
                        <div class="pref-opt-inner">
                            <div class="pref-opt-row">
                                <span class="pref-opt-name">Cerah lebih baik</span>
                            </div>
                            <span class="pref-opt-desc">Lebih suka cerah tapi berawan masih oke</span>
                        </div>
                    </label>
                    <label class="pref-opt">
                        <input type="radio" name="pref_weather" value="1">
                        <div class="pref-opt-inner">
                            <div class="pref-opt-row">
                                <span class="pref-opt-name">Tidak masalah</span>
                                <span class="pref-opt-badge badge-fleksibel">Fleksibel</span>
                            </div>
                            <span class="pref-opt-desc">Hujan pun tidak menghalangi perjalananku</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- CROWD -->
            <div class="pref-group">
                <div class="pref-group-title"><span>👥</span> Keramaian</div>
                <div class="pref-options">
                    <label class="pref-opt">
                        <input type="radio" name="pref_crowd" value="sepi">
                        <div class="pref-opt-inner">
                            <div class="pref-opt-row">
                                <span class="pref-opt-name">Lebih sepi lebih baik</span>
                                <span class="pref-opt-badge badge-penting">Tenang</span>
                            </div>
                            <span class="pref-opt-desc">Aku suka berwisata tanpa kerumunan</span>
                        </div>
                    </label>
                    <label class="pref-opt">
                        <input type="radio" name="pref_crowd" value="sedang" checked>
                        <div class="pref-opt-inner">
                            <div class="pref-opt-row">
                                <span class="pref-opt-name">Tidak terlalu ramai</span>
                            </div>
                            <span class="pref-opt-desc">Sedang-sedang saja, asal tidak penuh sesak</span>
                        </div>
                    </label>
                    <label class="pref-opt">
                        <input type="radio" name="pref_crowd" value="ramai">
                        <div class="pref-opt-inner">
                            <div class="pref-opt-row">
                                <span class="pref-opt-name">Tidak masalah ramai</span>
                                <span class="pref-opt-badge badge-fleksibel">Fleksibel</span>
                            </div>
                            <span class="pref-opt-desc">Ramai justru lebih seru bagiku</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- PRICE -->
            <div class="pref-group">
                <div class="pref-group-title"><span>💰</span> Harga</div>
                <div class="pref-options">
                    <label class="pref-opt">
                        <input type="radio" name="pref_price" value="hemat">
                        <div class="pref-opt-inner">
                            <div class="pref-opt-row">
                                <span class="pref-opt-name">Sehemat mungkin</span>
                                <span class="pref-opt-badge badge-penting">Hemat</span>
                            </div>
                            <span class="pref-opt-desc">Budget adalah prioritas utamaku</span>
                        </div>
                    </label>
                    <label class="pref-opt">
                        <input type="radio" name="pref_price" value="sedang" checked>
                        <div class="pref-opt-inner">
                            <div class="pref-opt-row">
                                <span class="pref-opt-name">Harga wajar</span>
                            </div>
                            <span class="pref-opt-desc">Tidak ingin terlalu mahal, tapi fleksibel</span>
                        </div>
                    </label>
                    <label class="pref-opt">
                        <input type="radio" name="pref_price" value="bebas">
                        <div class="pref-opt-inner">
                            <div class="pref-opt-row">
                                <span class="pref-opt-name">Harga tidak masalah</span>
                                <span class="pref-opt-badge badge-fleksibel">Fleksibel</span>
                            </div>
                            <span class="pref-opt-desc">Kualitas lebih penting dari harga</span>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <button class="apply-btn" onclick="recalculate(); scrollToResult()">
            ✨ &nbsp;Temukan Waktu Terbaikmu
        </button>
    </div>

    <!-- RESULT BANNER -->
    <div id="resultBanner" class="result-banner great" style="display:none;" data-scroll-target="true">
        <span class="rb-icon" id="bannerIcon">🎉</span>
        <div>
            <div class="rb-title" id="bannerTitle">Bulan terbaik untukmu</div>
            <div class="rb-text" id="bannerText"></div>
        </div>
    </div>

    <!-- CONTENT GRID -->
    <div class="content-grid">

        <!-- LEFT: CALENDAR -->
        <div>
            <div class="cal-card">
                <h2>Kalender Kunjungan</h2>
                <p class="cal-subtitle">Klik bulan mana saja untuk melihat detail kondisi dan tingkat kesesuaiannya denganmu.</p>
                <div class="cal-grid" id="calGrid">
                    @foreach($months as $num => $name)
                    @php
                        $m = $data['monthly'][$num];
                        $hasFest  = isset($data['festivals'][$num]);
                        $isCurrent= $num === $currentMonth;
                    @endphp
                    <div class="cal-month {{ $isCurrent ? 'is-current' : '' }}"
                         id="month-{{ $num }}"
                         onclick="showDetail({{ $num }})"
                         data-weather="{{ $m['weather'] }}"
                         data-crowd="{{ $m['crowd'] }}"
                         data-price="{{ $m['price'] }}"
                         data-festival="{{ $hasFest ? 'true' : 'false' }}"
                         data-tip="{{ addslashes($m['tip']) }}"
                         data-name="{{ $name }}">
                        <div class="cm-name">{{ $name }}</div>
                        <div class="cm-weather">
                            <span class="weather-dot dot-{{ $m['weather'] }}"></span>
                            {{ ucfirst($m['weather']) }}
                        </div>
                        <div class="cm-price price-{{ str_replace(' ','',$m['price']) }}">
                            {{ $m['price'] === 'rendah' ? '💚' : ($m['price'] === 'sedang' ? '💛' : ($m['price'] === 'tinggi' ? '🟠' : '🔴')) }}
                            {{ ucfirst($m['price']) }}
                        </div>
                        <div class="cm-badges">
                            @if($isCurrent)<span class="cm-badge badge-current">Sekarang</span>@endif
                            @if($hasFest)<span class="cm-badge badge-festival">🎉 Festival</span>@endif
                        </div>
                        <div class="cm-match" id="match-{{ $num }}"></div>
                        <div class="score-bar">
                            <div class="score-fill" id="bar-{{ $num }}" style="width:0%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- DETAIL PANEL -->
                <div class="detail-panel" id="detailPanel">
                    <div class="detail-panel-title" id="detailTitle">Detail Bulan</div>
                    <div id="detailContent">
                        <p class="detail-placeholder">Klik salah satu bulan di atas untuk melihat detail kondisi cuaca, keramaian, harga, dan seberapa cocok bulan itu dengan preferensimu.</p>
                    </div>
                </div>
            </div>

            <!-- LEGEND -->
            <div class="legend">
                <div class="legend-item"><span class="legend-dot" style="background:#22c55e;"></span> Sangat cocok</div>
                <div class="legend-item"><span class="legend-dot" style="background:var(--lime);"></span> Cocok</div>
                <div class="legend-item"><span class="legend-dot" style="background:#f59e0b;"></span> Cukup cocok</div>
                <div class="legend-item"><span class="legend-dot" style="background:#ef4444;"></span> Kurang cocok</div>
                <div class="legend-item"><span class="legend-dot" style="background:transparent;border:2px solid var(--jade);"></span> Bulan ini</div>
            </div>
        </div>

        <!-- RIGHT: SIDEBAR -->
        <div>
            <!-- TOP MONTHS -->
            <div class="sb-card">
                <h3>🏆 Rekomendasi Untukmu</h3>
                <div class="top-months-list" id="topMonthsList">
                    <div style="color:var(--muted);font-size:14px;line-height:1.6;">
                        Atur preferensimu di atas lalu klik tombol untuk melihat rekomendasi bulan terbaik.
                    </div>
                </div>
            </div>

            <!-- FESTIVALS -->
            @if(count($data['festivals']) > 0)
            <div class="sb-card">
                <h3>🎉 Festival & Event</h3>
                @foreach($data['festivals'] as $fm => $festivals)
                <div class="festival-item">
                    <div class="festival-month">{{ $months[$fm] }}</div>
                    @foreach($festivals as $fest)
                    <div class="festival-name">• {{ $fest }}</div>
                    @endforeach
                </div>
                @endforeach
            </div>
            @endif

            <!-- PROVINCE SWITCHER -->
            <div class="sb-card">
                <h3>Cari Provinsi Lain</h3>
                <form action="{{ route('seasonal.show') }}" method="GET">
                    <select name="province" class="province-picker">
                        @foreach($provinces as $p)
                        <option value="{{ $p->slug }}" {{ $p->slug === $slug ? 'selected' : '' }}>
                            {{ $p->name }}
                        </option>
                        @endforeach
                    </select>
                    <button type="submit" class="go-btn">Lihat Panduan →</button>
                </form>
            </div>

            <!-- ACTIONS -->
            <div class="sb-card">
                <h3>Lanjutkan Perencanaanmu</h3>
                <a href="{{ route('budget.index') }}" class="action-link">
                    <span>💰</span> Hitung Estimasi Budget
                </a>
                <a href="{{ route('transportation.index', ['type'=>'flight']) }}" class="action-link">
                    <span>✈️</span> Cari Tiket Pesawat
                </a>
                <a href="{{ route('itinerary.index') }}" class="action-link">
                    <span>📋</span> Lihat Itinerary Komunitas
                </a>
                <a href="{{ route('itinerary.create') }}" class="action-link">
                    <span>✍️</span> Buat Itinerary Baru
                </a>
            </div>
        </div>

    </div>
</div>

@endsection
@section('scripts')
<script>
const festivals  = @json($data['festivals']);
const monthNames = @json($months);
const currentMonth = {{ $currentMonth }};

function weatherScore(weather, pref) {
    const scores = { cerah: 3, berawan: 2, hujan: 1 };
    const w = scores[weather] || 1;
    if (pref == 3) return w === 3 ? 3 : w === 2 ? 1 : 0;
    if (pref == 2) return w === 3 ? 3 : w === 2 ? 2 : 1;
    return 3;
}
function crowdScore(crowd, pref) {
    const scores = { sepi: 3, sedang: 2, ramai: 1, 'sangat ramai': 0 };
    const c = scores[crowd] ?? 1;
    if (pref === 'sepi')   return c;
    if (pref === 'sedang') return c >= 2 ? 3 : c === 1 ? 1 : 0;
    return 3;
}
function priceScore(price, pref) {
    const scores = { rendah: 3, sedang: 2, tinggi: 1, tertinggi: 0 };
    const p = scores[price] ?? 1;
    if (pref === 'hemat')  return p;
    if (pref === 'sedang') return p >= 2 ? 3 : 1;
    return 3;
}
function getPrefs() {
    return {
        weather: parseInt(document.querySelector('input[name=pref_weather]:checked')?.value || 3),
        crowd:   document.querySelector('input[name=pref_crowd]:checked')?.value   || 'sedang',
        price:   document.querySelector('input[name=pref_price]:checked')?.value   || 'sedang',
    };
}

function recalculate() {
    const prefs = getPrefs();
    const scores = {};

    document.querySelectorAll('.cal-month').forEach(el => {
        const num     = parseInt(el.id.replace('month-',''));
        const weather = el.dataset.weather;
        const crowd   = el.dataset.crowd;
        const price   = el.dataset.price;
        const total   = weatherScore(weather, prefs.weather) + crowdScore(crowd, prefs.crowd) + priceScore(price, prefs.price);
        const pct     = Math.round(total / 9 * 100);
        scores[num]   = { total, pct, weather, crowd, price };

        // Update visual classes
        el.className = el.className.replace(/match-\w+/g, '').replace(/\s+/g,' ').trim();
        const barEl   = document.getElementById('bar-' + num);
        barEl.className = 'score-fill';
        barEl.style.width = pct + '%';

        let matchClass, fillClass, matchLabel, matchColor;
        if (pct >= 80)      { matchClass='match-great'; fillClass='fill-great'; matchLabel='✦ Sangat cocok'; matchColor='#16a34a'; }
        else if (pct >= 60) { matchClass='match-good';  fillClass='fill-good';  matchLabel='✓ Cocok';        matchColor='var(--jade)'; }
        else if (pct >= 40) { matchClass='match-ok';    fillClass='fill-ok';    matchLabel='~ Cukup cocok';  matchColor='#d97706'; }
        else                { matchClass='match-poor';  fillClass='fill-poor';  matchLabel='✗ Kurang cocok'; matchColor='var(--coral)'; }

        el.classList.add(matchClass);
        barEl.classList.add(fillClass);
        const matchEl = document.getElementById('match-' + num);
        matchEl.textContent = matchLabel;
        matchEl.style.color = matchColor;
    });

    // Update sidebar top months
    const sorted = Object.entries(scores).sort((a,b) => b[1].pct - a[1].pct);
    const rankEmojis = ['🥇','🥈','🥉','4️⃣'];
    const topList = document.getElementById('topMonthsList');
    topList.innerHTML = sorted.slice(0,4).map(([num, s], i) => {
        const color = s.pct>=80?'#16a34a':s.pct>=60?'var(--jade)':s.pct>=40?'#d97706':'var(--coral)';
        const fillClass = s.pct>=80?'fill-great':s.pct>=60?'fill-good':s.pct>=40?'fill-ok':'fill-poor';
        return `
        <div class="top-month-row" style="cursor:pointer;" onclick="showDetail(${num})">
            <span class="tm-rank">${rankEmojis[i]}</span>
            <div style="flex:1;margin-left:8px;">
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span class="tm-name">${monthNames[num]}</span>
                    <span class="tm-score" style="color:${color}">${s.pct}%</span>
                </div>
                <div class="tm-bar"><div class="tm-bar-fill ${fillClass}" style="width:${s.pct}%"></div></div>
            </div>
        </div>`;
    }).join('');

    // Banner
    const best = sorted[0];
    const banner = document.getElementById('resultBanner');
    banner.style.display = 'flex';
    if (best[1].pct >= 70) {
        banner.className = 'result-banner great';
        document.getElementById('bannerIcon').textContent = '🎉';
        document.getElementById('bannerTitle').textContent = `Waktu terbaikmu: ${monthNames[best[0]]}`;
        document.getElementById('bannerText').textContent = `Cocok ${best[1].pct}% dengan preferensimu — cuaca ${best[1].weather}, ${best[1].crowd}, harga ${best[1].price}.`;
    } else {
        banner.className = 'result-banner warn';
        document.getElementById('bannerIcon').textContent = '💡';
        document.getElementById('bannerTitle').textContent = 'Tidak ada bulan yang sempurna';
        document.getElementById('bannerText').textContent = `${monthNames[best[0]]} adalah pilihan terbaik (${best[1].pct}%), tapi ada kompromi. Coba longgarkan salah satu preferensimu.`;
    }

    // Refresh open detail (no scroll)
    const open = document.querySelector('.cal-month[data-open="true"]');
    if (open) showDetailNoScroll(parseInt(open.id.replace('month-','')));
}

function showDetailNoScroll(num) {
    // Same as showDetail but without scrollIntoView
    const el = document.getElementById('month-' + num);
    if (!el) return;
    document.querySelectorAll('.cal-month').forEach(c => c.removeAttribute('data-open'));
    el.setAttribute('data-open','true');
    _renderDetail(num);
    // no scroll
}

function showDetail(num) {
    const el = document.getElementById('month-' + num);
    document.querySelectorAll('.cal-month').forEach(c => c.removeAttribute('data-open'));
    el.setAttribute('data-open','true');

    const weather = el.dataset.weather;
    const crowd   = el.dataset.crowd;
    const price   = el.dataset.price;
    const tip     = el.dataset.tip;
    const name    = el.dataset.name;
    const hasFest = el.dataset.festival === 'true';

    const weatherEmoji = {cerah:'☀️', berawan:'⛅', hujan:'🌧️'}[weather] || '🌤️';
    const crowdEmoji   = {sepi:'🟢', sedang:'🟡', ramai:'🟠','sangat ramai':'🔴'}[crowd] || '🟡';
    const priceEmoji   = {rendah:'💚', sedang:'💛', tinggi:'🟠', tertinggi:'🔴'}[price] || '💛';

    const pct = parseInt(document.getElementById('bar-' + num).style.width) || 0;
    let scoreClass, scoreTxt;
    if (pct >= 80)      { scoreClass='score-great'; scoreTxt='Sangat Cocok'; }
    else if (pct >= 60) { scoreClass='score-good';  scoreTxt='Cocok'; }
    else if (pct >= 40) { scoreClass='score-ok';    scoreTxt='Cukup Cocok'; }
    else                { scoreClass='score-poor';  scoreTxt='Kurang Cocok'; }

    const festHTML = hasFest && festivals[num]
        ? `<div class="detail-row"><span class="detail-icon">🎉</span><div><div class="detail-label">Festival</div><div class="detail-value">${festivals[num].join(', ')}</div></div></div>`
        : '';

    const scoreHTML = pct > 0 ? `
        <div class="match-score-display">
            <div class="score-circle ${scoreClass}">${pct}%</div>
            <div>
                <div class="score-label">${scoreTxt} dengan preferensimu</div>
                <div class="score-sub">Skor berdasarkan cuaca, keramaian & harga</div>
            </div>
        </div>` : '';

    _renderDetail(num);
    document.getElementById('detailPanel').scrollIntoView({behavior:'smooth', block:'nearest'});
}

function _renderDetail(num) {
    const el = document.getElementById('month-' + num);
    if (!el) return;
    const weather = el.dataset.weather;
    const crowd   = el.dataset.crowd;
    const price   = el.dataset.price;
    const tip     = el.dataset.tip;
    const name    = el.dataset.name;
    const hasFest = el.dataset.festival === 'true';
    const weatherEmoji = {cerah:'☀️', berawan:'⛅', hujan:'🌧️'}[weather] || '🌤️';
    const crowdEmoji   = {sepi:'🟢', sedang:'🟡', ramai:'🟠','sangat ramai':'🔴'}[crowd] || '🟡';
    const priceEmoji   = {rendah:'💚', sedang:'💛', tinggi:'🟠', tertinggi:'🔴'}[price] || '💛';
    const pct = parseInt(document.getElementById('bar-' + num).style.width) || 0;
    let scoreClass, scoreTxt;
    if (pct >= 80)      { scoreClass='score-great'; scoreTxt='Sangat Cocok'; }
    else if (pct >= 60) { scoreClass='score-good';  scoreTxt='Cocok'; }
    else if (pct >= 40) { scoreClass='score-ok';    scoreTxt='Cukup Cocok'; }
    else                { scoreClass='score-poor';  scoreTxt='Kurang Cocok'; }
    const festHTML = hasFest && festivals[num]
        ? `<div class="detail-row"><span class="detail-icon">🎉</span><div><div class="detail-label">Festival</div><div class="detail-value">${festivals[num].join(', ')}</div></div></div>`
        : '';
    const scoreHTML = pct > 0 ? `
        <div class="match-score-display">
            <div class="score-circle ${scoreClass}">${pct}%</div>
            <div>
                <div class="score-label">${scoreTxt} dengan preferensimu</div>
                <div class="score-sub">Skor berdasarkan cuaca, keramaian & harga</div>
            </div>
        </div>` : '';
    document.getElementById('detailTitle').textContent = name;
    document.getElementById('detailContent').innerHTML = `
        ${scoreHTML}
        <div class="detail-row">
            <span class="detail-icon">${weatherEmoji}</span>
            <div><div class="detail-label">Cuaca</div><div class="detail-value">${weather.charAt(0).toUpperCase()+weather.slice(1)}</div></div>
        </div>
        <div class="detail-row">
            <span class="detail-icon">${crowdEmoji}</span>
            <div><div class="detail-label">Keramaian</div><div class="detail-value">${crowd.charAt(0).toUpperCase()+crowd.slice(1)}</div></div>
        </div>
        <div class="detail-row">
            <span class="detail-icon">${priceEmoji}</span>
            <div><div class="detail-label">Kisaran Harga</div><div class="detail-value">${price.charAt(0).toUpperCase()+price.slice(1)}</div></div>
        </div>
        ${festHTML}
        <div class="detail-tip">💡 ${tip}</div>
    `;
}

function scrollToResult() {
    setTimeout(() => {
        const banner = document.getElementById('resultBanner');
        if (banner) {
            banner.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }, 100);
}

document.addEventListener('DOMContentLoaded', () => {
    recalculate();
    showDetailNoScroll(currentMonth);
});
</script>
@endsection