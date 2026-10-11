@extends('layouts.app')
@section('title', 'Kalkulator Budget Perjalanan — NusantaraGuide')
@section('styles')
<style>

    body .hero{background:linear-gradient(135deg,#1a3a2a 0%,#2d6a4f 100%);padding:56px 8% 48px;text-align:center;}
    .hero h1{font-family:'Playfair Display',serif;font-size:clamp(28px,5vw,48px);color:white;font-weight:900;margin-bottom:10px;}
    .hero p{font-size:16px;color:rgba(255,255,255,0.75);max-width:540px;margin:0 auto;}
    body .calc-wrap{max-width:860px;margin:-40px auto 0;padding:0 24px 80px;position:relative;z-index:2;}
    body .calc-card{background:white;border-radius:20px;padding:36px;box-shadow:0 8px 40px rgba(26,58,42,0.15);}
    .calc-card h2{font-family:'Playfair Display',serif;font-size:24px;color:var(--forest);margin-bottom:28px;text-align:center;}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;}
    .form-group{display:flex;flex-direction:column;gap:7px;}
    .form-group label{font-size:12px;font-weight:700;color:var(--muted);letter-spacing:0.5px;text-transform:uppercase;}
    .form-group select,.form-group input{padding:12px 16px;border:1.5px solid #e0dbd2;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:15px;color:var(--ink);background:var(--cream);outline:none;transition:border-color 0.2s;}
    .form-group select:focus,.form-group input:focus{border-color:var(--jade);background:white;}
    .style-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:24px;}
    .style-card{border:2px solid #e0dbd2;border-radius:12px;padding:14px 10px;text-align:center;cursor:pointer;transition:all 0.2s;}
    .style-card:hover{border-color:var(--jade);}
    .style-card.selected{border-color:var(--jade);background:rgba(45,106,79,0.06);}
    .style-card input{display:none;}
    .style-card .style-icon{font-size:28px;margin-bottom:6px;}
    .style-card .style-name{font-size:13px;font-weight:700;color:var(--ink);}
    .style-card .style-range{font-size:11px;color:var(--muted);margin-top:2px;}
    .toggle-row{display:flex;gap:20px;margin:20px 0;}
    .toggle-item{display:flex;align-items:center;gap:10px;cursor:pointer;}
    .toggle-item input{width:18px;height:18px;accent-color:var(--jade);cursor:pointer;}
    .toggle-item span{font-size:14px;font-weight:500;color:var(--ink);}
    .calc-btn{width:100%;padding:16px;background:var(--coral);color:white;border:none;border-radius:12px;font-family:'DM Sans',sans-serif;font-size:17px;font-weight:700;cursor:pointer;transition:all 0.2s;margin-top:8px;}
    .calc-btn:hover{background:#d4604a;transform:translateY(-2px);}
    .live-preview{background:linear-gradient(135deg,var(--forest),var(--jade));color:white;border-radius:14px;padding:20px 24px;margin-top:24px;display:flex;justify-content:space-between;align-items:center;}
    .live-preview .lp-label{font-size:13px;opacity:0.75;margin-bottom:4px;}
    .live-preview .lp-value{font-family:'Playfair Display',serif;font-size:28px;font-weight:900;}
    .live-preview .lp-note{font-size:12px;opacity:0.6;margin-top:2px;}
    .section {
        padding: 80px 8% !important;
        margin-top: 60px !important;
    }
    .section-tag{font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--jade);display:flex;align-items:center;gap:8px;margin-bottom:10px;}
    .section-tag::before{content:'';width:20px;height:2px;background:var(--jade);}
    .section-title{font-family:'Playfair Display',serif;font-size:clamp(22px,3vw,32px);color:var(--forest);margin-bottom:32px;}
    .tips-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px;}
    .tip-card{background:white;border-radius:14px;padding:22px;box-shadow:var(--card-shadow);}
    .tip-icon{font-size:32px;margin-bottom:10px;}
    .tip-title{font-size:15px;font-weight:700;color:var(--forest);margin-bottom:6px;}
    .tip-text{font-size:13px;color:var(--muted);line-height:1.7;}
    @media(max-width:700px){.form-grid{grid-template-columns:1fr;}.style-grid{grid-template-columns:1fr 1fr;}body .calc-wrap{padding:0 16px 60px;}}
</style>
@endsection
@section('content')
<div class="hero">
    <h1>💰 Kalkulator Budget Perjalanan</h1>
    <p>Estimasi biaya liburanmu ke seluruh Indonesia — hotel, makan, aktivitas, dan transportasi.</p>
</div>

<div class="calc-wrap">
    <div class="calc-card">
        <h2>Rencanakan Budget Perjalananmu</h2>
        <form action="{{ route('budget.calculate') }}" method="GET" id="calcForm">
            <div class="form-grid" style="margin-bottom:24px;">
                <div class="form-group">
                    <label>Destinasi (Provinsi)</label>
                    <select name="province_slug" required id="provinceSelect" onchange="updatePreview()">
                        <option value="">Pilih provinsi...</option>
                        @foreach($provinces as $p)
                        <option value="{{ $p->slug }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Durasi Perjalanan</label>
                    <select name="days" id="daysSelect" onchange="updatePreview()">
                        @for($i=1;$i<=14;$i++)
                        <option value="{{ $i }}" {{ $i==3?'selected':'' }}>{{ $i }} hari {{ $i==1?'':($i<=3?'(weekend getaway)':($i<=7?'(liburan sedang)':'(liburan panjang)')) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label>Jumlah Orang</label>
                    <select name="people" id="peopleSelect" onchange="updatePreview()">
                        @for($i=1;$i<=10;$i++)
                        <option value="{{ $i }}" {{ $i==2?'selected':'' }}>{{ $i }} orang</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div style="font-size:12px;font-weight:700;color:var(--muted);letter-spacing:0.5px;text-transform:uppercase;margin-bottom:12px;">Gaya Perjalanan</div>
            <div class="style-grid">
                <label class="style-card" onclick="selectStyle(this,'backpacker')">
                    <input type="radio" name="style" value="backpacker">
                    <div class="style-icon">🎒</div>
                    <div class="style-name">Backpacker</div>
                    <div class="style-range">Rp 230–550rb/hari</div>
                </label>
                <label class="style-card" onclick="selectStyle(this,'budget')">
                    <input type="radio" name="style" value="budget">
                    <div class="style-icon">💰</div>
                    <div class="style-name">Budget</div>
                    <div class="style-range">Rp 575rb–1,3jt/hari</div>
                </label>
                <label class="style-card selected" onclick="selectStyle(this,'mid-range')">
                    <input type="radio" name="style" value="mid-range" checked>
                    <div class="style-icon">🏡</div>
                    <div class="style-name">Mid-range</div>
                    <div class="style-range">Rp 1,15–2,8jt/hari</div>
                </label>
                <label class="style-card" onclick="selectStyle(this,'luxury')">
                    <input type="radio" name="style" value="luxury">
                    <div class="style-icon">💎</div>
                    <div class="style-name">Luxury</div>
                    <div class="style-range">Rp 3,5jt–15,5jt/hari</div>
                </label>
            </div>

            <div style="font-size:12px;font-weight:700;color:var(--muted);letter-spacing:0.5px;text-transform:uppercase;margin-bottom:12px;">Tambahkan Transportasi</div>
            <div class="toggle-row">
                <label class="toggle-item">
                    <input type="checkbox" name="include_flight" value="1" id="flightCheck" onchange="updatePreview()">
                    <span>✈️ Tiket Pesawat (PP)</span>
                </label>
                <label class="toggle-item">
                    <input type="checkbox" name="include_train" value="1" id="trainCheck" onchange="updatePreview()">
                    <span>🚆 Tiket Kereta (PP)</span>
                </label>
            </div>

            <div class="live-preview">
                <div>
                    <div class="lp-label">Estimasi Total (semua orang)</div>
                    <div class="lp-value" id="previewTotal">Pilih destinasi dulu</div>
                    <div class="lp-note" id="previewNote">untuk melihat estimasi</div>
                </div>
                <div style="text-align:right;">
                    <div class="lp-label">Per orang</div>
                    <div style="font-size:18px;font-weight:700;" id="previewPerPerson">—</div>
                </div>
            </div>
            <button type="submit" class="calc-btn">Lihat Rincian Lengkap →</button>
        </form>
    </div>
</div>

<div class="section" style="background:white;padding-top:0;">
    <div class="section-tag">Tips</div>
    <div class="section-title">Tips Hemat Liburan di Indonesia</div>
    <div class="tips-grid">
        <div class="tip-card"><div class="tip-icon">🗓️</div><div class="tip-title">Pilih Waktu yang Tepat</div><div class="tip-text">Liburan di luar peak season (hindari Juli, Agustus, dan akhir tahun) bisa hemat 30–50% biaya hotel dan tiket.</div></div>
        <div class="tip-card"><div class="tip-icon">🚆</div><div class="tip-title">Gunakan Kereta untuk Jawa</div><div class="tip-text">Kereta eksekutif lebih murah dari pesawat untuk rute Jawa, dan lebih nyaman. Pesan 30 hari sebelumnya.</div></div>
        <div class="tip-card"><div class="tip-icon">🍜</div><div class="tip-title">Makan di Warung Lokal</div><div class="tip-text">Warung dan pasar lokal menawarkan makanan otentik dengan harga 3–5x lebih murah dari restoran turis.</div></div>
        <div class="tip-card"><div class="tip-icon">🏨</div><div class="tip-title">Pesan Hotel Langsung</div><div class="tip-text">Pesan langsung lewat website hotel atau telepon sering dapat harga lebih murah dari platform booking.</div></div>
        <div class="tip-card"><div class="tip-icon">🎫</div><div class="tip-title">Kartu Wisata Bundel</div><div class="tip-text">Banyak destinasi seperti Yogyakarta punya tiket bundel Borobudur + Prambanan yang lebih hemat dari beli terpisah.</div></div>
        <div class="tip-card"><div class="tip-icon">🛵</div><div class="tip-title">Sewa Motor, Bukan Mobil</div><div class="tip-text">Untuk destinasi seperti Bali dan Lombok, sewa motor Rp 60–80rb/hari jauh lebih efisien dari rental mobil.</div></div>
    </div>
</div>
@endsection
@section('scripts')
<script>
const COSTS = {
    backpacker: { daily_min: 230000,  daily_max: 550000  },
    budget:     { daily_min: 575000,  daily_max: 1300000 },
    'mid-range':{ daily_min: 1150000, daily_max: 2800000 },
    luxury:     { daily_min: 3500000, daily_max: 15500000},
};
const FLIGHTS = {
    'bali':400000,'yogyakarta':300000,'jawa-barat':150000,'jawa-tengah':250000,
    'jawa-timur':350000,'sulawesi-selatan':500000,'sumatera-barat':450000,
    'kalimantan-timur':600000,'nusa-tenggara-timur':750000
};
const TRAINS = {
    'yogyakarta':120000,'jawa-barat':80000,'jawa-tengah':150000,'jawa-timur':200000
};

let currentStyle = 'mid-range';

function selectStyle(el, style) {
    document.querySelectorAll('.style-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    currentStyle = style;
    updatePreview();
}

function updatePreview() {
    const province = document.getElementById('provinceSelect').value;
    const days = parseInt(document.getElementById('daysSelect').value)||3;
    const people = parseInt(document.getElementById('peopleSelect').value)||2;
    const flight = document.getElementById('flightCheck').checked;
    const train = document.getElementById('trainCheck').checked;
    const c = COSTS[currentStyle];

    let minPP = c.daily_min * days;
    let maxPP = c.daily_max * days;

    if(flight && FLIGHTS[province]) { minPP += FLIGHTS[province]*2; maxPP += FLIGHTS[province]*3; }
    if(train  && TRAINS[province])  { minPP += TRAINS[province]*2;  maxPP += TRAINS[province]*3;  }

    if(!province) {
        document.getElementById('previewTotal').textContent = 'Pilih destinasi dulu';
        document.getElementById('previewNote').textContent = 'untuk melihat estimasi';
        document.getElementById('previewPerPerson').textContent = '—';
        return;
    }

    const grandMin = minPP * people;
    const grandMax = maxPP * people;
    document.getElementById('previewTotal').textContent =
        'Rp '+fmt(grandMin)+' – Rp '+fmt(grandMax);
    document.getElementById('previewNote').textContent =
        people+' orang × '+days+' hari · '+currentStyle;
    document.getElementById('previewPerPerson').textContent =
        'Rp '+fmt(minPP)+' – '+fmt(maxPP);
}

function fmt(n) {
    if(n>=1000000) return (n/1000000).toFixed(1).replace('.0','')+'jt';
    if(n>=1000)    return Math.round(n/1000)+'rb';
    return n.toString();
}
</script>
@endsection