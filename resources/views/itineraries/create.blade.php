@extends('layouts.app')
@section('title', 'Buat Itinerary — NusantaraGuide')
@section('styles')
<style>
    .page-hero{background:linear-gradient(135deg,var(--forest) 0%,var(--jade) 100%);padding:48px 8% 40px;}
    .page-hero h1{font-family:'Playfair Display',serif;font-size:clamp(26px,4vw,40px);color:white;font-weight:900;margin-bottom:6px;}
    .page-hero p{font-size:15px;color:rgba(255,255,255,0.72);}

    .builder-wrap{max-width:1400px;margin:0 auto;padding:40px 4% 80px;display:grid;grid-template-columns:1fr 300px;gap:32px;align-items:start;}

    /* ── LEFT COL ── */
    .left-col{display:flex;flex-direction:column;gap:24px;}

    /* INFO CARD */
    .info-card{background:white;border-radius:18px;padding:28px;box-shadow:var(--card-shadow);}
    .info-card h2{font-family:'Playfair Display',serif;font-size:18px;color:var(--forest);margin-bottom:20px;padding-bottom:12px;border-bottom:2px solid var(--cream);}
    .form-group{margin-bottom:16px;}
    .form-group label{display:block;font-size:11px;font-weight:700;color:var(--muted);letter-spacing:0.8px;text-transform:uppercase;margin-bottom:6px;}
    .form-group input,.form-group select,.form-group textarea{width:100%;padding:11px 14px;border:1.5px solid #e0dbd2;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--ink);background:var(--cream);outline:none;transition:border-color 0.2s;}
    .form-group input:focus,.form-group select:focus,.form-group textarea:focus{border-color:var(--jade);background:white;}
    .form-group textarea{resize:vertical;min-height:72px;}
    .form-row-2{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
    .form-row-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;}

    /* STYLE PICKER */
    .style-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;}
    .style-opt input{display:none;}
    .style-opt-inner{padding:12px 8px;border:2px solid #e0dbd2;border-radius:10px;text-align:center;cursor:pointer;transition:all 0.2s;}
    .style-opt-inner:hover{border-color:var(--jade);}
    .style-opt input:checked + .style-opt-inner{border-color:var(--jade);background:rgba(45,106,79,0.06);}
    .style-icon{font-size:22px;margin-bottom:4px;}
    .style-name{font-size:12px;font-weight:700;color:var(--ink);}
    .style-range{font-size:10px;color:var(--muted);margin-top:2px;}

    /* TAGS */
    .tags-wrap{display:flex;flex-wrap:wrap;gap:8px;}
    .tag-opt{display:none;}
    .tag-label{padding:6px 14px;border-radius:20px;border:1.5px solid #e0dbd2;font-size:13px;font-weight:500;color:var(--muted);cursor:pointer;transition:all 0.2s;}
    .tag-opt:checked + .tag-label{background:var(--forest);color:white;border-color:var(--forest);}

    /* ── DAY BUILDER ── */
    .day-builder{background:white;border-radius:18px;padding:28px;box-shadow:var(--card-shadow);}
    .day-builder-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;padding-bottom:14px;border-bottom:2px solid var(--cream);}
    .day-builder-header h2{font-family:'Playfair Display',serif;font-size:18px;color:var(--forest);}
    .day-tabs{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:28px;}
    .day-tab{padding:8px 20px;border-radius:20px;border:1.5px solid #e0dbd2;font-size:13px;font-weight:600;color:var(--muted);cursor:pointer;background:white;font-family:'DM Sans',sans-serif;transition:all 0.2s;}
    .day-tab.active{background:var(--forest);color:white;border-color:var(--forest);}
    .day-tab:hover:not(.active){border-color:var(--jade);color:var(--jade);}
    .add-day-tab{padding:8px 16px;border-radius:20px;border:2px dashed #d0c9c0;font-size:13px;font-weight:600;color:var(--muted);cursor:pointer;background:white;font-family:'DM Sans',sans-serif;transition:all 0.2s;}
    .add-day-tab:hover{border-color:var(--jade);color:var(--jade);}

    /* DAY PANEL */
    .day-panel{display:none;}
    .day-panel.active{display:block;}
    .day-panel-header{display:flex;align-items:center;gap:14px;margin-bottom:20px;}
    .day-num-badge{width:40px;height:40px;border-radius:50%;background:var(--forest);color:white;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:15px;flex-shrink:0;}
    .day-title-input{flex:1;padding:10px 14px;border:1.5px solid #e0dbd2;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--ink);background:var(--cream);outline:none;transition:border-color 0.2s;}
    .day-title-input:focus{border-color:var(--jade);background:white;}
    .remove-day-btn{background:none;border:none;color:var(--muted);cursor:pointer;font-size:13px;padding:6px 10px;border-radius:6px;font-family:'DM Sans',sans-serif;transition:all 0.2s;}
    .remove-day-btn:hover{color:var(--coral);background:rgba(231,111,81,0.08);}
    .day-notes-input{width:100%;padding:10px 14px;border:1.5px solid #e0dbd2;border-radius:10px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--ink);background:var(--cream);outline:none;margin-bottom:20px;resize:none;}
    .day-notes-input:focus{border-color:var(--jade);background:white;}

    /* ── TIMELINE ── */
    .timeline{position:relative;padding-left:28px;}
    .timeline::before{content:'';position:absolute;left:11px;top:0;bottom:0;width:2px;background:linear-gradient(to bottom,var(--lime),rgba(116,198,157,0.1));}

    /* STOP CARD */
    .stop-card{position:relative;margin-bottom:6px;}
    .stop-dot{position:absolute;left:-28px;top:16px;width:22px;height:22px;border-radius:50%;background:white;border:2px solid var(--lime);display:flex;align-items:center;justify-content:center;font-size:11px;z-index:1;}
    .stop-inner{background:var(--cream);border-radius:14px;border:1.5px solid #e8e3da;overflow:hidden;transition:border-color 0.2s;}
    .stop-inner:focus-within{border-color:var(--jade);}
    .stop-header{display:flex;align-items:center;gap:10px;padding:12px 16px;background:white;border-bottom:1px solid #f0ede8;}
    .stop-type-badge{font-size:18px;width:32px;text-align:center;}
    .stop-type-label{font-size:13px;font-weight:700;color:var(--ink);flex:1;}
    .stop-time-wrap{display:flex;align-items:center;gap:6px;}
    .stop-time-input{padding:5px 10px;border:1px solid #e0dbd2;border-radius:7px;font-size:13px;font-family:'DM Sans',sans-serif;width:90px;outline:none;}
    .stop-time-sep{font-size:12px;color:var(--muted);}
    .stop-remove{background:none;border:none;color:var(--muted);cursor:pointer;font-size:18px;padding:4px 6px;border-radius:6px;transition:all 0.2s;margin-left:4px;}
    .stop-remove:hover{color:var(--coral);background:rgba(231,111,81,0.08);}
    .stop-body{padding:14px 16px;display:flex;flex-direction:column;gap:10px;}
    .stop-field{width:100%;padding:9px 12px;border:1.5px solid #e0dbd2;border-radius:8px;font-family:'DM Sans',sans-serif;font-size:13px;background:white;outline:none;color:var(--ink);transition:border-color 0.2s;}
    .stop-field:focus{border-color:var(--jade);}
    .stop-field-row{display:grid;grid-template-columns:1fr 1fr;gap:10px;}
    .stop-description{width:100%;padding:9px 12px;border:1.5px solid #e0dbd2;border-radius:8px;font-family:'DM Sans',sans-serif;font-size:13px;background:white;outline:none;color:var(--ink);resize:vertical;min-height:72px;line-height:1.6;transition:border-color 0.2s;}
    .stop-description:focus{border-color:var(--jade);}
    .stop-description::placeholder{color:#b0b8b4;}
    .stop-field-label{font-size:11px;font-weight:700;color:var(--muted);letter-spacing:0.5px;text-transform:uppercase;margin-bottom:4px;}

    /* TRANSPORT CONNECTOR */
    .transport-connector{margin:6px 0;padding-left:4px;display:flex;align-items:center;gap:10px;}
    .connector-line{width:2px;height:32px;background:linear-gradient(to bottom,var(--lime),rgba(116,198,157,0.3));margin-left:9px;flex-shrink:0;}
    .connector-content{flex:1;display:flex;align-items:center;gap:8px;background:rgba(116,198,157,0.08);border:1px dashed rgba(116,198,157,0.4);border-radius:10px;padding:7px 12px;}
    .connector-icon{font-size:16px;}
    .connector-input{border:none;background:transparent;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--muted);outline:none;flex:1;min-width:0;}
    .connector-input::placeholder{color:#c0c8c4;}
    .connector-cost{width:90px;border:none;background:transparent;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--muted);outline:none;text-align:right;}
    .connector-cost::placeholder{color:#c0c8c4;}

    /* ADD STOP BUTTONS */
    .add-stop-row{display:flex;gap:8px;flex-wrap:wrap;margin-top:16px;padding-top:16px;border-top:2px dashed #e8e3da;}
    .add-stop-btn{display:flex;align-items:center;gap:6px;padding:8px 14px;border-radius:8px;border:1.5px dashed #d0c9c0;background:white;color:var(--muted);font-size:13px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all 0.2s;}
    .add-stop-btn:hover{border-color:var(--jade);color:var(--jade);background:rgba(45,106,79,0.04);}

    /* ── SUBMIT ── */
    .submit-card{background:white;border-radius:18px;padding:24px;box-shadow:var(--card-shadow);}
    .submit-row{display:flex;gap:12px;}
    .btn-publish{flex:1;padding:14px;background:var(--coral);color:white;border:none;border-radius:12px;font-family:'DM Sans',sans-serif;font-size:15px;font-weight:700;cursor:pointer;transition:all 0.2s;}
    .btn-publish:hover{background:#d4604a;}
    .btn-draft{padding:14px 22px;background:white;color:var(--muted);border:1.5px solid #e0dbd2;border-radius:12px;font-family:'DM Sans',sans-serif;font-size:15px;font-weight:600;cursor:pointer;transition:all 0.2s;}
    .btn-draft:hover{border-color:var(--jade);color:var(--jade);}

    /* ── RIGHT SIDEBAR ── */
    .sidebar{display:flex;flex-direction:column;gap:20px;position:sticky;top:88px;}
    .sidebar-card{background:white;border-radius:16px;padding:22px;box-shadow:var(--card-shadow);}
    .sidebar-card h3{font-size:15px;font-weight:700;color:var(--forest);margin-bottom:14px;}

    /* BUDGET TRACKER */
    .budget-display{background:linear-gradient(135deg,var(--forest),var(--jade));border-radius:12px;padding:18px;color:white;text-align:center;}
    .budget-amount{font-family:'Playfair Display',serif;font-size:26px;font-weight:900;margin-bottom:4px;}
    .budget-note{font-size:12px;opacity:0.7;}
    .budget-breakdown{margin-top:14px;display:flex;flex-direction:column;gap:6px;}
    .budget-row{display:flex;justify-content:space-between;font-size:12px;opacity:0.85;padding:4px 0;border-bottom:1px solid rgba(255,255,255,0.1);}
    .budget-row:last-child{border-bottom:none;}

    /* DAY SUMMARY */
    .day-summary-list{display:flex;flex-direction:column;gap:8px;}
    .day-summary-item{display:flex;align-items:center;gap:10px;padding:10px;background:var(--cream);border-radius:10px;cursor:pointer;transition:background 0.2s;}
    .day-summary-item:hover{background:#e8f4ee;}
    .ds-num{width:26px;height:26px;border-radius:50%;background:var(--forest);color:white;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;}
    .ds-info{flex:1;min-width:0;}
    .ds-title{font-size:13px;font-weight:600;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
    .ds-count{font-size:11px;color:var(--muted);margin-top:1px;}

    /* TIPS */
    .tip-item{display:flex;gap:10px;padding:8px 0;border-bottom:1px solid #f5f5f5;font-size:13px;color:var(--muted);line-height:1.5;}
    .tip-item:last-child{border-bottom:none;}
    .tip-icon{font-size:16px;flex-shrink:0;margin-top:1px;}

    .autofill-badge{background:rgba(116,198,157,0.15);border:1px solid rgba(116,198,157,0.4);color:var(--jade);font-size:12px;font-weight:600;padding:6px 12px;border-radius:8px;margin-top:6px;}
    .autofilled{border-color:var(--lime) !important;background:rgba(116,198,157,0.05) !important;}
    .currency-input{font-variant-numeric:tabular-nums;}
    .currency-input::placeholder{font-size:12px;color:#b0b8b4;}
    @media(max-width:960px){.builder-wrap{grid-template-columns:1fr;}.sidebar{position:static;}.style-grid{grid-template-columns:1fr 1fr;}}
    @media(max-width:600px){.form-row-2,.form-row-3{grid-template-columns:1fr;}.stop-field-row{grid-template-columns:1fr;}.style-grid{grid-template-columns:1fr 1fr;}.submit-row{flex-direction:column;}}
</style>
@endsection
@section('content')

<div class="page-hero">
    <h1>✍️ Buat Itinerary</h1>
    <p>Bagikan perjalananmu — lengkap dengan cerita, waktu, dan biaya tiap aktivitas.</p>
</div>

<!-- DRAFT RESTORE BANNER -->
<div id="draft-restore-banner" style="display:none;background:#fff8e8;border-bottom:2px solid #e9c46a;padding:14px 8%;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;">
    <div style="display:flex;align-items:center;gap:12px;">
        <span style="font-size:22px;">💾</span>
        <div>
            <div style="font-size:14px;font-weight:700;color:var(--forest);">Ada draft yang belum selesai</div>
            <div style="font-size:13px;color:var(--muted);">Itinerary <span id="draft-title-preview"></span> tersimpan otomatis</div>
        </div>
    </div>
    <div style="display:flex;gap:10px;">
        <button type="button" onclick="restoreFromLocal();document.getElementById('draft-restore-banner').style.display='none';"
                style="background:var(--jade);color:white;border:none;padding:9px 20px;border-radius:8px;font-family:'DM Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;">
            Lanjutkan Draft
        </button>
        <button type="button" onclick="clearDraft();document.getElementById('draft-restore-banner').style.display='none';"
                style="background:white;color:var(--muted);border:1.5px solid #e0dbd2;padding:9px 20px;border-radius:8px;font-family:'DM Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;">
            Mulai Baru
        </button>
    </div>
</div>

<form action="{{ route('itinerary.store') }}" method="POST" enctype="multipart/form-data" id="itineraryForm">
@csrf
<input type="hidden" name="status" id="statusInput" value="published">

<div class="builder-wrap">

    <!-- ── LEFT COLUMN ── -->
    <div class="left-col">

        <!-- BASIC INFO -->
        <div class="info-card">
            <h2>📋 Informasi Dasar</h2>
            <div class="form-group">
                <label>Judul Itinerary *</label>
                <input type="text" name="title" required placeholder="Contoh: 5 Hari di Bali dengan Budget 3 Juta" value="{{ old('title') }}">
            </div>
            <div class="form-group">
                <label>Ringkasan *</label>
                <textarea name="summary" required placeholder="Ceritakan perjalananmu secara singkat — apa yang membuat perjalanan ini spesial?" maxlength="500">{{ old('summary') }}</textarea>
            </div>
            <div class="form-row-2">
                <div class="form-group">
                    <label>Destinasi Utama</label>
                    <select name="region_id">
                        <option value="">Pilih wilayah...</option>
                        @foreach($regions as $region)
                        <option value="{{ $region->id }}" {{ old('region_id')==$region->id?'selected':'' }}>
                            {{ $region->name }} — {{ $region->province->name ?? '' }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Durasi *</label>
                    <select name="duration_days" id="durationSelect" onchange="syncDays()">
                        @for($i=1;$i<=14;$i++)
                        <option value="{{ $i }}" {{ old('duration_days',3)==$i?'selected':'' }}>{{ $i }} hari</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="form-row-2">
                <div class="form-group">
                    <label>Estimasi Budget</label>
                    <input type="text" name="estimated_budget"
                           class="currency-input"
                           placeholder="e.g. 3jt, 1.5juta, 3000000"
                           value="{{ old('estimated_budget') }}"
                           oninput="formatCurrency(this)">
                </div>
                <div class="form-group">
                    <label>Budget Aktual</label>
                    <input type="text" name="actual_budget"
                           class="currency-input"
                           placeholder="e.g. 2.8jt, 2800000"
                           id="actualBudget"
                           value="{{ old('actual_budget') }}"
                           oninput="formatCurrency(this)">
                </div>
            </div>
            <div class="form-row-2">
                <div class="form-group">
                    <label>Rating Perjalanan</label>
                    <select name="trip_rating">
                        <option value="">Tidak diisi</option>
                        <option value="5">⭐⭐⭐⭐⭐ Luar biasa</option>
                        <option value="4">⭐⭐⭐⭐ Sangat bagus</option>
                        <option value="3">⭐⭐⭐ Bagus</option>
                        <option value="2">⭐⭐ Biasa</option>
                        <option value="1">⭐ Kurang</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Cover Image</label>
                    <input type="file" name="cover_image" accept="image/*">
                </div>
            </div>

            <!-- TRAVEL STYLE -->
            <div class="form-group">
                <label>Gaya Perjalanan *</label>
                <div class="style-grid">
                    @foreach(['backpacker'=>['🎒','Backpacker','230–550rb/hr'],'budget'=>['💰','Budget','575rb–1.3jt'],'mid-range'=>['🏡','Mid-range','1.1–2.8jt'],'luxury'=>['💎','Luxury','3.5jt+'],'family'=>['👨‍👩‍👧','Keluarga',''],'solo'=>['🧍','Solo',''],'couple'=>['👫','Couple',''],'group'=>['👥','Grup','']] as $val=>$data)
                    <label class="style-opt">
                        <input type="radio" name="travel_style" value="{{ $val }}" {{ old('travel_style','mid-range')===$val?'checked':'' }}>
                        <div class="style-opt-inner">
                            <div class="style-icon">{{ $data[0] }}</div>
                            <div class="style-name">{{ $data[1] }}</div>
                            @if($data[2])<div class="style-range">{{ $data[2] }}</div>@endif
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- DAY BUILDER -->
        <div class="day-builder">
            <div class="day-builder-header">
                <h2>🗓️ Rencana Harian</h2>
                <span style="font-size:13px;color:var(--muted);">Klik hari untuk edit</span>
            </div>

            <!-- DAY TABS -->
            <div class="day-tabs" id="dayTabs"></div>

            <!-- DAY PANELS -->
            <div id="dayPanels"></div>
        </div>

        <!-- STORY & TIPS -->
        <div class="info-card">
            <h2>📖 Cerita & Tips</h2>
            <div class="form-group">
                <label>Cerita Lengkap (Opsional)</label>
                <textarea name="body" style="min-height:140px;" placeholder="Ceritakan pengalamanmu secara detail — momen berkesan, tantangan yang dihadapi, hal-hal yang mengejutkan...">{{ old('body') }}</textarea>
            </div>
            <div class="form-group">
                <label>Tips untuk Traveler Lain</label>
                <textarea name="trip_tips" placeholder="Saran penting untuk yang ingin mengikuti itinerary ini — apa yang harus dilakukan, apa yang harus dihindari...">{{ old('trip_tips') }}</textarea>
            </div>
        </div>

        <!-- TAGS -->
        <div class="info-card">
            <h2>🏷️ Tags</h2>
            <div class="tags-wrap">
                @foreach($tags as $tag)
                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag{{ $tag->id }}" class="tag-opt">
                <label for="tag{{ $tag->id }}" class="tag-label">{{ $tag->name }}</label>
                @endforeach
            </div>
        </div>

        <!-- SUBMIT -->
        <div class="submit-card">
            <div style="font-size:12px;color:var(--muted);text-align:center;margin-bottom:12px;" id="autosave-status">
                💾 Draft tersimpan otomatis
            </div>
            <div class="submit-row">
                <button type="submit" class="btn-publish" onclick="setStatus('published')">🚀 Publikasikan</button>
                <button type="button" class="btn-draft" onclick="setStatus('draft');document.getElementById('itineraryForm').submit();">💾 Simpan Draft</button>
            </div>
            <div style="text-align:center;margin-top:12px;">
                <button type="button" onclick="if(confirm('Hapus semua data yang sudah diisi?')){clearDraft();location.reload();}"
                        style="background:none;border:none;color:var(--muted);font-size:12px;cursor:pointer;text-decoration:underline;font-family:'DM Sans',sans-serif;">
                    Mulai dari awal
                </button>
            </div>
        </div>
    </div>

    <!-- ── RIGHT SIDEBAR ── -->
    <div class="sidebar">

        <!-- BUDGET TRACKER -->
        <div class="sidebar-card">
            <h3>💰 Estimasi Biaya</h3>
            <div class="budget-display">
                <div class="budget-note">Total dari semua aktivitas</div>
                <div class="budget-amount" id="totalDisplay">Rp 0</div>
                <div class="budget-note" id="totalNote">Belum ada aktivitas berbayar</div>
                <div class="budget-breakdown" id="budgetBreakdown"></div>
            </div>
        </div>

        <!-- DAY OVERVIEW -->
        <div class="sidebar-card">
            <h3>📅 Ringkasan Hari</h3>
            <div class="day-summary-list" id="daySummary"></div>
        </div>

        <!-- QUICK TIPS -->
        <div class="sidebar-card">
            <h3>💡 Tips Menulis</h3>
            <div class="tip-item"><span class="tip-icon">🕐</span>Tambahkan waktu mulai & selesai agar terlihat realistis</div>
            <div class="tip-item"><span class="tip-icon">📝</span>Isi deskripsi dengan cerita nyata — rekomendasi menu, kondisi jalan, dll</div>
            <div class="tip-item"><span class="tip-icon">🚗</span>Isi transport antar stop untuk gambaran waktu perjalanan</div>
            <div class="tip-item"><span class="tip-icon">💰</span>Biaya aktual lebih berguna dari estimasi</div>
            <div class="tip-item"><span class="tip-icon">📸</span>Tambahkan cover image untuk menarik lebih banyak pembaca</div>
        </div>
    </div>

</div>
</form>
@endsection

@section('scripts')
<script>
// ── DATA FROM LARAVEL ─────────────────────────────────────────
const flightBookings = {{ Js::from($flightBookingsJson ?? []) }};
const trainBookings  = {{ Js::from($trainBookingsJson ?? []) }};
const hotelBookings  = {{ Js::from($hotelBookingsJson ?? []) }};
const places         = {{ Js::from($placesJson ?? []) }};

// ── STATE ─────────────────────────────────────────────────────
let dayCount    = 0;
let stopCount   = 0;
let activeDay   = 0;

const stopTypes = {
    flight: { icon: '✈️', label: 'Penerbangan' },
    train:  { icon: '🚆', label: 'Kereta Api' },
    hotel:  { icon: '🏨', label: 'Hotel / Menginap' },
    place:  { icon: '📍', label: 'Tempat Wisata' },
    food:   { icon: '🍽️', label: 'Makan & Minum' },
    custom: { icon: '📝', label: 'Aktivitas Lain' },
};

// ── INIT ──────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    try {
        // Check if a draft exists first
        const hasDraft = localStorage.getItem(SAVE_KEY);
        if (hasDraft) {
            // Show the banner - let user decide to restore or start fresh
            checkForDraft();
            // Start with default days (user can click Lanjutkan to restore)
            const dur = parseInt(document.getElementById('durationSelect').value) || 3;
            for (let i = 0; i < dur; i++) addDay();
            switchDay(0);
        } else {
            const dur = parseInt(document.getElementById('durationSelect').value) || 3;
            for (let i = 0; i < dur; i++) addDay();
            switchDay(0);
        }
    } catch(e) {
        console.error('Day builder error:', e);
        for (let i = 0; i < 3; i++) addDay();
        switchDay(0);
    }
});

function syncDays() {
    try {
        const target  = parseInt(document.getElementById('durationSelect').value) || 1;
        const current = dayCount;
        if (target > current) {
            for (let i = current; i < target; i++) addDay();
        } else {
            for (let i = current - 1; i >= target; i--) removeDay(i);
        }
        if (activeDay >= target) switchDay(target - 1);
    } catch(e) { console.error('syncDays error:', e); }
}

// ── DAY MANAGEMENT ────────────────────────────────────────────
function addDay() {
    const idx = dayCount++;
    // Tab
    const tab = document.createElement('button');
    tab.type = 'button';
    tab.className = 'day-tab';
    tab.id = `tab-${idx}`;
    tab.textContent = `Hari ${idx + 1}`;
    tab.onclick = () => switchDay(idx);
    document.getElementById('dayTabs').appendChild(tab);

    // Panel
    const panel = document.createElement('div');
    panel.className = 'day-panel';
    panel.id = `panel-${idx}`;
    panel.innerHTML = `
        <div class="day-panel-header">
            <div class="day-num-badge">${idx + 1}</div>
            <input type="hidden" name="days[${idx}][number]" value="${idx + 1}">
            <input class="day-title-input" type="text" name="days[${idx}][title]"
                   placeholder="Judul hari ini (opsional) — e.g. Hari Tiba & Check-in"
                   onchange="updateSidebar()">
            ${idx > 0 ? `<button type="button" class="remove-day-btn" onclick="removeDay(${idx})">✕ Hapus</button>` : ''}
        </div>
        <textarea class="day-notes-input" name="days[${idx}][notes]"
                  placeholder="Catatan umum untuk hari ini — cuaca, kondisi, hal yang perlu diingat..." rows="2"></textarea>
        <div class="timeline">
            <div class="stops-list" id="stops-${idx}"></div>
        </div>
        <div class="add-stop-row">
            <button type="button" class="add-stop-btn" onclick="addStop(${idx},'flight')">✈️ Penerbangan</button>
            <button type="button" class="add-stop-btn" onclick="addStop(${idx},'train')">🚆 Kereta</button>
            <button type="button" class="add-stop-btn" onclick="addStop(${idx},'hotel')">🏨 Hotel</button>
            <button type="button" class="add-stop-btn" onclick="addStop(${idx},'place')">📍 Tempat</button>
            <button type="button" class="add-stop-btn" onclick="addStop(${idx},'food')">🍽️ Makan</button>
            <button type="button" class="add-stop-btn" onclick="addStop(${idx},'custom')">📝 Lainnya</button>
        </div>`;
    document.getElementById('dayPanels').appendChild(panel);
    updateSidebar();
}

function removeDay(idx) {
    document.getElementById(`tab-${idx}`)?.remove();
    document.getElementById(`panel-${idx}`)?.remove();
    dayCount--;
    if (activeDay >= dayCount) switchDay(dayCount - 1);
    updateSidebar();
}

function switchDay(idx) {
    document.querySelectorAll('.day-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.day-panel').forEach(p => p.classList.remove('active'));
    document.getElementById(`tab-${idx}`)?.classList.add('active');
    document.getElementById(`panel-${idx}`)?.classList.add('active');
    activeDay = idx;
}

// ── ADD STOP ──────────────────────────────────────────────────
function addStop(dayIdx, type) {
    const sIdx = stopCount++;
    const info = stopTypes[type];
    const list = document.getElementById(`stops-${dayIdx}`);

    // Add transport connector BEFORE this stop (if not first stop)
    const existingStops = list.querySelectorAll('.stop-card');
    if (existingStops.length > 0) {
        const connector = document.createElement('div');
        connector.className = 'transport-connector';
        connector.id = `connector-${sIdx}`;
        connector.innerHTML = `
            <div class="connector-line"></div>
            <div class="connector-content">
                <span class="connector-icon">🚗</span>
                <input class="connector-input" type="text"
                       name="days[${dayIdx}][stops][${sIdx}][transport_mode]"
                       placeholder="Transportasi ke sini — Uber, ojek, jalan kaki...">
                <input class="connector-cost currency-input" type="text"
                       name="days[${dayIdx}][stops][${sIdx}][transport_cost]"
                       placeholder="Biaya transport"
                       oninput="formatCurrency(this)"
                       onchange="updateBudget()">
            </div>`;
        list.appendChild(connector);
    }

    // Build stop body based on type
    let bodyHTML = buildStopBody(type, dayIdx, sIdx);

    const card = document.createElement('div');
    card.className = 'stop-card';
    card.id = `stop-${sIdx}`;
    card.innerHTML = `
        <div class="stop-dot">${info.icon}</div>
        <div class="stop-inner">
            <div class="stop-header">
                <span class="stop-type-badge">${info.icon}</span>
                <span class="stop-type-label">${info.label}</span>
                <input type="hidden" name="days[${dayIdx}][stops][${sIdx}][type]" value="${type}">
                <div class="stop-time-wrap">
                    <input class="stop-time-input" type="time"
                           name="days[${dayIdx}][stops][${sIdx}][time_start]"
                           placeholder="Mulai">
                    <span class="stop-time-sep">→</span>
                    <input class="stop-time-input" type="time"
                           name="days[${dayIdx}][stops][${sIdx}][time_end]"
                           placeholder="Selesai">
                </div>
                <button type="button" class="stop-remove"
                        onclick="removeStop('stop-${sIdx}','connector-${sIdx}')">×</button>
            </div>
            <div class="stop-body">${bodyHTML}</div>
        </div>`;
    list.appendChild(card);
    // Initialize searchable selects on newly added stop
    card.querySelectorAll('.searchable-select').forEach(sel => initSearchable(sel));
    updateSidebar();
    updateBudget();
}

function buildStopBody(type, dayIdx, sIdx) {
    const trainOpts = trainBookings.length
        ? trainBookings.map(b => `<option value="${b.id}" data-price="${b.price}">${b.label}</option>`).join('')
        : '<option value="">Belum ada booking kereta</option>';
    const flightOpts = flightBookings.length
        ? flightBookings.map(b => `<option value="${b.id}" data-price="${b.price}">${b.label}</option>`).join('')
        : '<option value="">Belum ada booking penerbangan</option>';
    const hotelOpts = hotelBookings.length
        ? hotelBookings.map(b => `<option value="${b.id}" data-price="${b.price}">${b.label}</option>`).join('')
        : '<option value="">Belum ada booking hotel</option>';
    const placeOpts = places.map(p => `<option value="${p.id}">${p.label}</option>`).join('');

    const descField = `
        <div>
            <div class="stop-field-label">Cerita / Deskripsi</div>
            <textarea class="stop-description"
                      name="days[${dayIdx}][stops][${sIdx}][custom_description]"
                      placeholder="Ceritakan pengalamanmu di sini — kondisi tempat, apa yang kamu rasakan, rekomendasi khusus, hal yang perlu dipersiapkan..."></textarea>
        </div>
        <div class="stop-field-row">
            <div>
                <div class="stop-field-label">Biaya</div>
                <input class="stop-field currency-input" type="text"
                       name="days[${dayIdx}][stops][${sIdx}][cost]"
                       data-raw-name="days[${dayIdx}][stops][${sIdx}][cost_raw]"
                       placeholder="e.g. 150rb, 1.5jt, 200000"
                       oninput="formatCurrency(this)"
                       onchange="updateBudget()">
            </div>
            <div>
                <div class="stop-field-label">Tips Singkat</div>
                <input class="stop-field" type="text"
                       name="days[${dayIdx}][stops][${sIdx}][tip]"
                       placeholder="e.g. Reservasi dulu!">
            </div>
        </div>`;

    if (type === 'flight') return `
        <div>
            <div class="stop-field-label">Link ke Booking (opsional)</div>
            <select class="stop-field" name="days[${dayIdx}][stops][${sIdx}][flight_booking_id]"
                    id="flight-sel-${sIdx}"
                    onchange="autofillFlight(this, ${sIdx}, ${dayIdx})">
                <option value="">— Pilih booking atau isi manual —</option>${flightOpts}
            </select>
            <div id="flight-autofill-badge-${sIdx}" class="autofill-badge" style="display:none;">
                ✓ Data terisi otomatis dari booking
            </div>
        </div>
        <div class="stop-field-row">
            <div>
                <div class="stop-field-label">Maskapai & Nomor</div>
                <input class="stop-field" type="text"
                       name="days[${dayIdx}][stops][${sIdx}][custom_title]"
                       placeholder="Garuda GA-400">
            </div>
            <div>
                <div class="stop-field-label">Rute</div>
                <input class="stop-field" type="text"
                       name="days[${dayIdx}][stops][${sIdx}][custom_place_name]"
                       placeholder="CGK → DPS">
            </div>
        </div>
        ${descField}`;

    if (type === 'train') return `
        <div>
            <div class="stop-field-label">Link ke Booking (opsional)</div>
            <select class="stop-field" name="days[${dayIdx}][stops][${sIdx}][train_booking_id]"
                    id="train-sel-${sIdx}"
                    onchange="autofillTrain(this, ${sIdx}, ${dayIdx})">
                <option value="">— Pilih booking atau isi manual —</option>${trainOpts}
            </select>
            <div id="train-autofill-badge-${sIdx}" class="autofill-badge" style="display:none;">
                ✓ Data terisi otomatis dari booking
            </div>
        </div>
        <div class="stop-field-row">
            <div>
                <div class="stop-field-label">Nama Kereta</div>
                <input class="stop-field" type="text"
                       name="days[${dayIdx}][stops][${sIdx}][custom_title]"
                       placeholder="e.g. Argo Bromo Anggrek">
            </div>
            <div>
                <div class="stop-field-label">Rute</div>
                <input class="stop-field" type="text"
                       name="days[${dayIdx}][stops][${sIdx}][custom_place_name]"
                       placeholder="e.g. Gambir → Surabaya Pasar Turi">
            </div>
        </div>
        ${descField}`;

    if (type === 'hotel') return `
        <div>
            <div class="stop-field-label">Link ke Booking (opsional)</div>
            <select class="stop-field" name="days[${dayIdx}][stops][${sIdx}][hotel_booking_id]"
                    id="hotel-sel-${sIdx}"
                    onchange="autofillHotel(this, ${sIdx}, ${dayIdx})">
                <option value="">— Pilih booking atau isi manual —</option>${hotelOpts}
            </select>
            <div id="hotel-autofill-badge-${sIdx}" class="autofill-badge" style="display:none;">
                ✓ Data terisi otomatis dari booking
            </div>
        </div>
        <div>
            <div class="stop-field-label">Nama Hotel</div>
            <input class="stop-field" type="text"
                   name="days[${dayIdx}][stops][${sIdx}][custom_title]"
                   placeholder="Nama hotel atau penginapan">
        </div>
        ${descField}`;

    if (type === 'place') return `
        <div>
            <div class="stop-field-label">Pilih dari Database (opsional)</div>
            <select class="stop-field" name="days[${dayIdx}][stops][${sIdx}][place_id]">
                <option value="">Atau ketik nama sendiri</option>${placeOpts}
            </select>
        </div>
        <div>
            <div class="stop-field-label">Nama Tempat</div>
            <input class="stop-field" type="text"
                   name="days[${dayIdx}][stops][${sIdx}][custom_place_name]"
                   placeholder="Nama tempat wisata">
        </div>
        ${descField}`;

    if (type === 'food') return `
        <div>
            <div class="stop-field-label">Pilih dari Database (opsional)</div>
            <select class="stop-field searchable-select"
                    name="days[${dayIdx}][stops][${sIdx}][place_id]"
                    id="place-sel-${sIdx}"
                    onchange="autofillPlace(this, ${sIdx})">
                <option value="">— Cari tempat makan —</option>${placeOpts}
            </select>
        </div>
        <div>
            <div class="stop-field-label">Nama Tempat Makan</div>
            <input class="stop-field" type="text"
                   name="days[${dayIdx}][stops][${sIdx}][custom_title]"
                   placeholder="Nama restoran, warung, atau kafe">
        </div>
        <div>
            <div class="stop-field-label">Lokasi</div>
            <input class="stop-field" type="text"
                   name="days[${dayIdx}][stops][${sIdx}][custom_place_name]"
                   placeholder="Alamat atau area">
        </div>
        ${descField}`;

    // custom
    return `
        <div>
            <div class="stop-field-label">Nama Aktivitas *</div>
            <input class="stop-field" type="text"
                   name="days[${dayIdx}][stops][${sIdx}][custom_title]"
                   placeholder="Apa yang kamu lakukan?">
        </div>
        ${descField}`;
}

function removeStop(stopId, connectorId) {
    document.getElementById(stopId)?.remove();
    document.getElementById(connectorId)?.remove();
    updateSidebar();
    updateBudget();
}

// ── BUDGET TRACKER ────────────────────────────────────────────
function updateBudget() {
    let total = 0;
    const breakdown = {};

    // Flight bookings linked
    document.querySelectorAll('select[name*="flight_booking_id"]').forEach(sel => {
        const opt = sel.options[sel.selectedIndex];
        if (opt?.dataset.price) {
            const v = parseFloat(opt.dataset.price);
            total += v;
            breakdown['Penerbangan'] = (breakdown['Penerbangan'] || 0) + v;
        }
    });
    // Train bookings linked
    document.querySelectorAll('select[name*="train_booking_id"]').forEach(sel => {
        const opt = sel.options[sel.selectedIndex];
        if (opt?.dataset.price) {
            const v = parseFloat(opt.dataset.price);
            total += v;
            breakdown['Kereta'] = (breakdown['Kereta'] || 0) + v;
        }
    });
    // Hotel bookings linked
    document.querySelectorAll('select[name*="hotel_booking_id"]').forEach(sel => {
        const opt = sel.options[sel.selectedIndex];
        if (opt?.dataset.price) {
            const v = parseFloat(opt.dataset.price);
            total += v;
            breakdown['Hotel'] = (breakdown['Hotel'] || 0) + v;
        }
    });
    // Manual costs
    document.querySelectorAll('input[name*="[cost]"]').forEach(inp => {
        if (inp.value) {
            total += parseFloat(inp.value);
            breakdown['Aktivitas'] = (breakdown['Aktivitas'] || 0) + parseFloat(inp.value);
        }
    });
    // Transport costs
    document.querySelectorAll('input[name*="[transport_cost]"]').forEach(inp => {
        if (inp.value) {
            total += parseFloat(inp.value);
            breakdown['Transport'] = (breakdown['Transport'] || 0) + parseFloat(inp.value);
        }
    });

    document.getElementById('totalDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('totalNote').textContent = total > 0 ? 'dari aktivitas yang diisi' : 'Belum ada aktivitas berbayar';

    const bEl = document.getElementById('budgetBreakdown');
    bEl.innerHTML = Object.entries(breakdown).map(([k, v]) =>
        `<div class="budget-row"><span>${k}</span><span>Rp ${v.toLocaleString('id-ID')}</span></div>`
    ).join('');
}

// ── SIDEBAR SUMMARY ───────────────────────────────────────────
function updateSidebar() {
    const summary = document.getElementById('daySummary');
    summary.innerHTML = '';
    for (let i = 0; i < dayCount; i++) {
        const panel = document.getElementById(`panel-${i}`);
        if (!panel) continue;
        const titleInput = panel.querySelector(`input[name="days[${i}][title]"]`);
        const stopCount  = panel.querySelectorAll('.stop-card').length;
        const title      = titleInput?.value || `Hari ${i + 1}`;
        const item = document.createElement('div');
        item.className = 'day-summary-item';
        item.onclick = () => switchDay(i);
        item.innerHTML = `
            <div class="ds-num">${i + 1}</div>
            <div class="ds-info">
                <div class="ds-title">${title}</div>
                <div class="ds-count">${stopCount} aktivitas</div>
            </div>`;
        summary.appendChild(item);
    }
}

// ── AUTOFILL PLACE FROM DATABASE ────────────────────────────
function autofillPlace(sel, sIdx) {
    const id = parseInt(sel.value);
    if (!id) return;
    const place = places.find(p => p.id === id);
    if (!place) return;
    const body    = sel.closest('.stop-body');
    const titleEl = body.querySelector('input[name*="custom_title"]');
    const placeEl = body.querySelector('input[name*="custom_place_name"]');
    const costEl  = body.querySelector('input[name*="[cost]"]');
    if (titleEl && place.label)       { titleEl.value = place.label; setAutofilled(titleEl); }
    if (placeEl && place.address)     { placeEl.value = place.address; setAutofilled(placeEl); }
    if (costEl  && place.price_start) { costEl.value  = parseInt(place.price_start).toLocaleString('id-ID'); setAutofilled(costEl); }
    updateBudget();
}

// ── AUTOFILL FROM BOOKINGS ───────────────────────────────────
function setAutofilled(el) {
    el.classList.add('autofilled');
}

function autofillFlight(sel, sIdx, dayIdx) {
    const id = parseInt(sel.value);
    if (!id) { updateBudget(); return; }

    const booking = flightBookings.find(b => b.id === id);
    if (!booking) { updateBudget(); return; }

    // Fill title field
    const titleEl = sel.closest('.stop-body').querySelector('input[name*="custom_title"]');
    const routeEl = sel.closest('.stop-body').querySelector('input[name*="custom_place_name"]');
    const costEl  = sel.closest('.stop-body').querySelector('input[name*="[cost]"]');
    const startEl = sel.closest('.stop-inner').querySelector('input[name*="time_start"]');
    const endEl   = sel.closest('.stop-inner').querySelector('input[name*="time_end"]');

    if (titleEl && booking.airline && booking.flight_number) {
        titleEl.value = booking.airline + ' ' + booking.flight_number;
        setAutofilled(titleEl);
    }
    if (routeEl && booking.route) {
        routeEl.value = booking.route;
        setAutofilled(routeEl);
    }
    if (costEl && booking.price) {
        costEl.value = booking.price.toLocaleString('id-ID');
        setAutofilled(costEl);
    }
    if (startEl && booking.departure_time) {
        startEl.value = booking.departure_time;
        setAutofilled(startEl);
    }
    if (endEl && booking.arrival_time) {
        endEl.value = booking.arrival_time;
        setAutofilled(endEl);
    }

    // Show badge
    const badge = document.getElementById('flight-autofill-badge-' + sIdx);
    if (badge) badge.style.display = 'block';
    updateBudget();
}

function autofillTrain(sel, sIdx, dayIdx) {
    const id = parseInt(sel.value);
    if (!id) { updateBudget(); return; }

    const booking = trainBookings.find(b => b.id === id);
    if (!booking) { updateBudget(); return; }

    const titleEl = sel.closest('.stop-body').querySelector('input[name*="custom_title"]');
    const routeEl = sel.closest('.stop-body').querySelector('input[name*="custom_place_name"]');
    const costEl  = sel.closest('.stop-body').querySelector('input[name*="[cost]"]');
    const startEl = sel.closest('.stop-inner').querySelector('input[name*="time_start"]');
    const endEl   = sel.closest('.stop-inner').querySelector('input[name*="time_end"]');
    const descEl  = sel.closest('.stop-body').querySelector('textarea[name*="custom_description"]');

    if (titleEl && booking.train_name) {
        titleEl.value = booking.train_name;
        setAutofilled(titleEl);
    }
    if (routeEl && booking.route) {
        routeEl.value = booking.route;
        setAutofilled(routeEl);
    }
    if (costEl && booking.price) {
        costEl.value = booking.price.toLocaleString('id-ID');
        setAutofilled(costEl);
    }
    if (startEl && booking.departure_time) {
        startEl.value = booking.departure_time;
        setAutofilled(startEl);
    }
    if (endEl && booking.arrival_time) {
        endEl.value = booking.arrival_time;
        setAutofilled(endEl);
    }
    if (descEl && booking.seat_class) {
        descEl.value = 'Kelas ' + booking.seat_class + ' · ' + booking.passengers + ' penumpang';
        setAutofilled(descEl);
    }

    const badge = document.getElementById('train-autofill-badge-' + sIdx);
    if (badge) badge.style.display = 'block';
    updateBudget();
}

function autofillHotel(sel, sIdx, dayIdx) {
    const id = parseInt(sel.value);
    if (!id) { updateBudget(); return; }

    const booking = hotelBookings.find(b => b.id === id);
    if (!booking) { updateBudget(); return; }

    const titleEl = sel.closest('.stop-body').querySelector('input[name*="custom_title"]');
    const costEl  = sel.closest('.stop-body').querySelector('input[name*="[cost]"]');
    const descEl  = sel.closest('.stop-body').querySelector('textarea[name*="custom_description"]');
    const startEl = sel.closest('.stop-inner').querySelector('input[name*="time_start"]');

    if (titleEl && booking.hotel_name) {
        titleEl.value = booking.hotel_name;
        setAutofilled(titleEl);
    }
    if (costEl && booking.price) {
        costEl.value = booking.price.toLocaleString('id-ID');
        setAutofilled(costEl);
    }
    if (descEl) {
        const parts = [];
        if (booking.room_name) parts.push('Kamar: ' + booking.room_name);
        if (booking.check_in)  parts.push('Check-in: ' + booking.check_in);
        if (booking.check_out) parts.push('Check-out: ' + booking.check_out);
        if (booking.guests)    parts.push(booking.guests + ' tamu');
        if (parts.length) { descEl.value = parts.join(' · '); setAutofilled(descEl); }
    }
    if (startEl) { startEl.value = '14:00'; setAutofilled(startEl); } // standard check-in

    const badge = document.getElementById('hotel-autofill-badge-' + sIdx);
    if (badge) badge.style.display = 'block';
    updateBudget();
}

// ── SMART CURRENCY INPUT ─────────────────────────────────────
function parseCurrency(val) {
    if (!val) return 0;
    val = val.toString().toLowerCase().trim();
    // Handle shorthand: 3jt, 3.5jt, 1.2juta, 500rb, 500ribu
    const jutaMatch = val.match(/^([\d.,]+)\s*j(t|uta)?$/);
    const ribuMatch = val.match(/^([\d.,]+)\s*r(b|ibu)?$/);
    if (jutaMatch) {
        return Math.round(parseFloat(jutaMatch[1].replace(',', '.')) * 1000000);
    }
    if (ribuMatch) {
        return Math.round(parseFloat(ribuMatch[1].replace(',', '.')) * 1000);
    }
    // Remove dots used as thousand separators (Indonesian format)
    val = val.replace(/\./g, '').replace(/,/g, '').replace(/[^0-9]/g, '');
    return parseInt(val) || 0;
}

function formatCurrency(input) {
    const raw = parseCurrency(input.value);
    // Store raw value in hidden field for form submission
    let hidden = input.nextElementSibling;
    if (!hidden || !hidden.classList.contains('currency-raw')) {
        hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.className = 'currency-raw';
        hidden.name = input.name; // use same name for submission
        input.name = input.name + '_display'; // rename display input
        input.insertAdjacentElement('afterend', hidden);
    }
    hidden.value = raw;
    // Show formatted display (don't reformat while typing shorthand)
    const isShorthand = /[jrb]/i.test(input.value);
    if (!isShorthand && raw > 0) {
        input.value = raw.toLocaleString('id-ID');
    }
    updateBudget();
}

// Override updateBudget to use .currency-raw values
function getRawValue(input) {
    // Check if there's a hidden raw value next to this input
    const next = input.nextElementSibling;
    if (next && next.classList.contains('currency-raw')) {
        return parseFloat(next.value) || 0;
    }
    return parseCurrency(input.value);
}

// ── SEARCHABLE SELECT ────────────────────────────────────────
function initSearchable(el) {
    if (!el || el._tsInitialized) return;
    el._tsInitialized = true;

    const original = el;
    const options  = Array.from(el.options);

    // Wrapper
    const wrapper = document.createElement('div');
    wrapper.style.cssText = 'position:relative;';

    // Search input
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.className = 'stop-field';
    searchInput.placeholder = el.options[0]?.text || 'Cari...';
    searchInput.style.cssText = 'margin-bottom:0;padding-right:32px;';
    searchInput.autocomplete = 'off';

    // Clear button (×)
    const clearBtn = document.createElement('button');
    clearBtn.type = 'button';
    clearBtn.textContent = '×';
    clearBtn.style.cssText = 'display:none;position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;font-size:18px;color:var(--muted);cursor:pointer;line-height:1;padding:0 4px;z-index:2;';
    clearBtn.onclick = (e) => {
        e.stopPropagation();
        searchInput.value = '';
        original.value   = '';
        clearBtn.style.display = 'none';
        searchInput.classList.remove('autofilled');
        renderOptions('');
        searchInput.focus();
        dropdown.style.display = 'block';
        original.dispatchEvent(new Event('change'));
    };

    // Dropdown
    const dropdown = document.createElement('div');
    dropdown.style.cssText = 'display:none;position:absolute;top:100%;left:0;right:0;background:white;border:1.5px solid var(--jade);border-radius:10px;box-shadow:0 4px 20px rgba(0,0,0,0.12);z-index:1000;max-height:220px;overflow-y:auto;margin-top:4px;';

    function renderOptions(filter) {
        dropdown.innerHTML = '';
        const q = filter.toLowerCase().trim();
        const filtered = options.filter(o => o.value && (!q || o.text.toLowerCase().includes(q)));
        if (filtered.length === 0) {
            dropdown.innerHTML = '<div style="padding:10px 14px;color:var(--muted);font-size:13px;">Tidak ditemukan — coba kata lain</div>';
            return;
        }
        filtered.slice(0, 60).forEach(o => {
            const item = document.createElement('div');
            // Highlight matching text
            const idx = o.text.toLowerCase().indexOf(q);
            if (q && idx >= 0) {
                item.innerHTML = o.text.slice(0, idx) +
                    '<strong style="color:var(--jade)">' + o.text.slice(idx, idx+q.length) + '</strong>' +
                    o.text.slice(idx + q.length);
            } else {
                item.textContent = o.text;
            }
            item.style.cssText = 'padding:10px 14px;cursor:pointer;font-size:13px;color:var(--ink);transition:background 0.15s;';
            item.onmouseover = () => item.style.background = 'rgba(45,106,79,0.08)';
            item.onmouseout  = () => item.style.background = '';
            item.onmousedown = (e) => e.preventDefault(); // prevent blur before click
            item.onclick = () => {
                searchInput.value = o.text;
                original.value    = o.value;
                clearBtn.style.display = 'block';
                dropdown.style.display = 'none';
                original.dispatchEvent(new Event('change'));
            };
            dropdown.appendChild(item);
        });
    }

    // Show dropdown and filter on every keystroke
    searchInput.addEventListener('input', () => {
        renderOptions(searchInput.value);
        dropdown.style.display = 'block';
        // Show/hide clear button
        clearBtn.style.display = searchInput.value ? 'block' : 'none';
        // If user is typing, clear the hidden select value
        if (original.value && searchInput.value !== options.find(o=>o.value===original.value)?.text) {
            original.value = '';
        }
    });

    searchInput.addEventListener('focus', () => {
        renderOptions(searchInput.value);
        dropdown.style.display = 'block';
    });

    // Close on outside click
    document.addEventListener('click', e => {
        if (!wrapper.contains(e.target)) {
            dropdown.style.display = 'none';
            // If input doesn't match any option, clear it
            const match = options.find(o => o.text === searchInput.value);
            if (!match) {
                searchInput.value = '';
                original.value    = '';
                clearBtn.style.display = 'none';
            }
        }
    });

    // Keyboard navigation
    searchInput.addEventListener('keydown', e => {
        const items = dropdown.querySelectorAll('div');
        const active = dropdown.querySelector('div[data-active]');
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            const next = active ? active.nextElementSibling : items[0];
            active?.removeAttribute('data-active');
            active && (active.style.background = '');
            if (next) { next.setAttribute('data-active',''); next.style.background = 'rgba(45,106,79,0.08)'; next.scrollIntoView({block:'nearest'}); }
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            const prev = active?.previousElementSibling;
            active?.removeAttribute('data-active');
            active && (active.style.background = '');
            if (prev) { prev.setAttribute('data-active',''); prev.style.background = 'rgba(45,106,79,0.08)'; prev.scrollIntoView({block:'nearest'}); }
        } else if (e.key === 'Enter' && active) {
            e.preventDefault();
            active.click();
        } else if (e.key === 'Escape') {
            dropdown.style.display = 'none';
        }
    });

    // Build DOM
    wrapper.appendChild(searchInput);
    wrapper.appendChild(clearBtn);
    wrapper.appendChild(dropdown);
    original.style.display = 'none';
    original.parentNode.insertBefore(wrapper, original);
    wrapper.appendChild(original);

    // If original already has a value, show it
    if (original.value) {
        const match = options.find(o => o.value === original.value);
        if (match) { searchInput.value = match.text; clearBtn.style.display = 'block'; }
    }
}

function setStatus(val) { document.getElementById('statusInput').value = val; }

// ── AUTOSAVE TO LOCALSTORAGE ──────────────────────────────────
const SAVE_KEY = 'nusantara_itinerary_draft';

function saveToLocal() {
    try {
        const form = document.getElementById('itineraryForm');
        const data = {};
        // Save all input/select/textarea values
        form.querySelectorAll('input:not([type=file]):not([type=hidden]), select, textarea').forEach(el => {
            if (el.name) data[el.name] = el.value;
        });
        // Save day count and active day
        data['__dayCount__'] = dayCount;
        data['__activeDay__'] = activeDay;
        // Save the entire day panels HTML so we don't lose dynamically added stops
        data['__dayPanelsHTML__'] = document.getElementById('dayPanels').innerHTML;
        data['__dayTabsHTML__']   = document.getElementById('dayTabs').innerHTML;
        localStorage.setItem(SAVE_KEY, JSON.stringify(data));
    } catch(e) { console.warn('Autosave failed:', e); }
}

function restoreFromLocal() {
    try {
        const raw = localStorage.getItem(SAVE_KEY);
        if (!raw) return false;
        const data = JSON.parse(raw);

        // Restore day panels and tabs HTML first (brings back all stops)
        if (data['__dayPanelsHTML__']) {
            document.getElementById('dayPanels').innerHTML = data['__dayPanelsHTML__'];
            dayCount = data['__dayCount__'] || 3;
        }
        if (data['__dayTabsHTML__']) {
            document.getElementById('dayTabs').innerHTML = data['__dayTabsHTML__'];
            // Re-attach onclick to tabs
            document.querySelectorAll('.day-tab').forEach((tab, i) => {
                tab.onclick = () => switchDay(i);
            });
        }

        // Restore all field values
        const form = document.getElementById('itineraryForm');
        Object.entries(data).forEach(([name, value]) => {
            if (name.startsWith('__')) return;
            const el = form.querySelector(`[name="${CSS.escape(name)}"]`);
            if (el) el.value = value;
        });

        // Re-attach radio/checkbox visual states
        form.querySelectorAll('input[type=radio]').forEach(radio => {
            if (data[radio.name] === radio.value) {
                radio.checked = true;
                // Update style-opt selected state
                radio.closest('.style-opt-inner')?.classList.add('selected');
            }
        });

        // Restore active day
        const activeIdx = data['__activeDay__'] || 0;
        switchDay(activeIdx);
        updateSidebar();
        updateBudget();
        return true;
    } catch(e) {
        console.warn('Restore failed:', e);
        return false;
    }
}

function clearDraft() {
    localStorage.removeItem(SAVE_KEY);
}

// Auto-save every 3 seconds and on any input change
setInterval(() => {
    saveToLocal();
    const status = document.getElementById('autosave-status');
    if (status) {
        const now = new Date();
        status.textContent = `💾 Tersimpan otomatis ${now.getHours().toString().padStart(2,'0')}:${now.getMinutes().toString().padStart(2,'0')}`;
    }
}, 3000);
document.addEventListener('input',  () => saveToLocal());
document.addEventListener('change', () => saveToLocal());

// Clear draft when form is submitted
document.getElementById('itineraryForm').addEventListener('submit', () => {
    clearDraft();
});

// Show draft restore banner if draft exists
function checkForDraft() {
    const raw = localStorage.getItem(SAVE_KEY);
    if (!raw) return;
    try {
        const data = JSON.parse(raw);
        if (!data['title']) return; // empty draft
        // Show banner
        const banner = document.getElementById('draft-restore-banner');
        if (banner) {
            banner.style.display = 'flex';
            const titlePreview = data['title'] ? `"${data['title'].substring(0,40)}"` : 'draft tersimpan';
            document.getElementById('draft-title-preview').textContent = titlePreview;
        }
    } catch(e) {}
}
</script>
@endsection 