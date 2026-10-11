<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Kelola Booking</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --forest: #1a3a2a; --jade: #2d6a4f; --lime: #74c69d; --cream: #fdf8f0; --gold: #e9c46a; --coral: #e76f51; --ink: #0d1b13; --muted: #6b7c72; --card-shadow: 0 4px 24px rgba(26,58,42,0.10); }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: #f0f0f0; color: var(--ink); }
        .navbar { background: var(--forest); padding: 0 6%; display: flex; align-items: center; justify-content: space-between; height: 60px; }
        .logo { font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 900; color: white; text-decoration: none; }
        .logo span { color: var(--gold); }
        .admin-badge { background: var(--coral); color: white; padding: 4px 12px; border-radius: 4px; font-size: 12px; font-weight: 700; letter-spacing: 1px; }
        .nav-user { display: flex; align-items: center; gap: 12px; }
        .nav-user span { color: rgba(255,255,255,0.7); font-size: 13px; }
        .logout-btn { background: transparent; border: 1px solid rgba(255,255,255,0.3); color: rgba(255,255,255,0.7); padding: 6px 14px; border-radius: 6px; cursor: pointer; font-family: 'DM Sans', sans-serif; font-size: 12px; }

        .page-wrap { padding: 32px 6%; }
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; }
        .page-title { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 900; color: var(--forest); }

        /* STATS */
        .stats-row { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px,1fr)); gap: 14px; margin-bottom: 28px; }
        .stat-card { background: white; border-radius: 12px; padding: 18px; box-shadow: var(--card-shadow); text-align: center; }
        .stat-num { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 900; }
        .stat-lbl { font-size: 12px; color: var(--muted); margin-top: 4px; text-transform: uppercase; letter-spacing: 0.5px; }

        /* FILTERS */
        .filter-bar { background: white; border-radius: 12px; padding: 16px 20px; box-shadow: var(--card-shadow); margin-bottom: 20px; display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
        .filter-bar input, .filter-bar select { padding: 9px 14px; border: 1.5px solid #e0dbd2; border-radius: 8px; font-family: 'DM Sans', sans-serif; font-size: 13px; color: var(--ink); background: var(--cream); outline: none; }
        .filter-bar button { background: var(--jade); color: white; border: none; padding: 9px 20px; border-radius: 8px; font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; }
        .reset-link { font-size: 13px; color: var(--muted); text-decoration: none; }

        /* TABLE */
        .table-card { background: white; border-radius: 16px; box-shadow: var(--card-shadow); overflow: hidden; }
        .alert-success { background: rgba(116,198,157,0.15); border-bottom: 1px solid var(--lime); color: var(--jade); padding: 14px 24px; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: var(--forest); color: white; padding: 13px 16px; text-align: left; font-size: 12px; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; }
        td { padding: 14px 16px; font-size: 13px; border-bottom: 1px solid #f5f5f5; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafaf8; }

        .code-cell { font-weight: 700; font-size: 13px; letter-spacing: 0.5px; color: var(--forest); }
        .hotel-cell .hotel-name { font-weight: 600; color: var(--ink); }
        .hotel-cell .room-name  { font-size: 12px; color: var(--muted); margin-top: 2px; }
        .guest-cell { font-size: 12px; color: var(--muted); }
        .guest-cell strong { display: block; font-size: 13px; color: var(--ink); font-weight: 600; }
        .price-cell { font-weight: 700; color: var(--forest); }

        .status-pill { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; white-space: nowrap; }

        .status-form { display: flex; gap: 6px; align-items: center; }
        .status-select { padding: 6px 10px; border: 1px solid #e0dbd2; border-radius: 6px; font-family: 'DM Sans', sans-serif; font-size: 12px; background: white; cursor: pointer; }
        .update-btn { background: var(--jade); color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; font-family: 'DM Sans', sans-serif; transition: background 0.2s; }
        .update-btn:hover { background: var(--forest); }

        .pagination-wrap { padding: 20px; display: flex; justify-content: center; }
        .empty-row td { text-align: center; padding: 48px; color: var(--muted); font-size: 15px; }

        footer { background: var(--ink); color: rgba(255,255,255,0.5); padding: 24px 6%; text-align: center; font-size: 13px; margin-top: 40px; }
        footer strong { color: var(--lime); }

        @media (max-width: 900px) {
            .page-wrap { padding: 24px 4%; }
            table { font-size: 12px; }
            th, td { padding: 10px 12px; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="{{ route('home') }}" class="logo">Nusantara<span>Guide</span> <span class="admin-badge">ADMIN</span></a>
    <div class="nav-user">
        <span>{{ Auth::user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST">
            @csrf <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</nav>

<div class="page-wrap">
    <div class="page-header">
        <div class="page-title">Kelola Booking 🏨</div>
        <a href="{{ route('home') }}" style="font-size:13px;color:var(--jade);text-decoration:none;">← Kembali ke Website</a>
    </div>

    <!-- STATS -->
    @php
        $allBookings = \App\Models\Booking::all();
        $pending   = $allBookings->where('status','pending')->count();
        $confirmed = $allBookings->where('status','confirmed')->count();
        $cancelled = $allBookings->where('status','cancelled')->count();
        $revenue   = $allBookings->where('status','confirmed')->sum('total_price');
    @endphp
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-num" style="color:var(--gold);">{{ $pending }}</div>
            <div class="stat-lbl">Menunggu</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:var(--jade);">{{ $confirmed }}</div>
            <div class="stat-lbl">Dikonfirmasi</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:var(--coral);">{{ $cancelled }}</div>
            <div class="stat-lbl">Dibatalkan</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:var(--forest);font-size:22px;">
                Rp {{ number_format($revenue/1000000, 1) }}Jt
            </div>
            <div class="stat-lbl">Revenue</div>
        </div>
    </div>

    <!-- FILTERS -->
    <div class="filter-bar">
        <form action="{{ route('admin.bookings') }}" method="GET" style="display:contents;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode booking...">
            <select name="status" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="pending"   {{ request('status')=='pending'   ?'selected':'' }}>Menunggu</option>
                <option value="confirmed" {{ request('status')=='confirmed' ?'selected':'' }}>Dikonfirmasi</option>
                <option value="cancelled" {{ request('status')=='cancelled' ?'selected':'' }}>Dibatalkan</option>
            </select>
            <button type="submit">Cari</button>
            @if(request()->anyFilled(['search','status']))
                <a href="{{ route('admin.bookings') }}" class="reset-link">Reset ×</a>
            @endif
        </form>
    </div>

    <!-- TABLE -->
    <div class="table-card">
        @if(session('success'))
            <div class="alert-success">✓ {{ session('success') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Hotel & Kamar</th>
                    <th>Tamu</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Ubah Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td class="code-cell">{{ $booking->booking_code }}</td>
                    <td class="hotel-cell">
                        <div class="hotel-name">{{ $booking->place->name ?? '-' }}</div>
                        <div class="room-name">{{ $booking->room->name ?? '-' }}</div>
                    </td>
                    <td class="guest-cell">
                        <strong>{{ $booking->user->name ?? '-' }}</strong>
                        {{ $booking->guests }} tamu
                    </td>
                    <td style="font-size:12px;">
                        {{ $booking->check_in->format('d M Y') }}<br>
                        <span style="color:var(--muted);">→ {{ $booking->check_out->format('d M Y') }}</span><br>
                        <span style="color:var(--jade);font-weight:600;">{{ $booking->nights }} malam</span>
                    </td>
                    <td class="price-cell">{{ $booking->total_label }}</td>
                    <td>
                        <span class="status-pill"
                              style="background:{{ $booking->status_color }}22;color:{{ $booking->status_color }};border:1px solid {{ $booking->status_color }}44;">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.bookings.status', $booking->id) }}" method="POST" class="status-form">
                            @csrf
                            <select name="status" class="status-select">
                                <option value="pending"   {{ $booking->status=='pending'   ?'selected':'' }}>Menunggu</option>
                                <option value="confirmed" {{ $booking->status=='confirmed' ?'selected':'' }}>Konfirmasi</option>
                                <option value="cancelled" {{ $booking->status=='cancelled' ?'selected':'' }}>Batalkan</option>
                            </select>
                            <button type="submit" class="update-btn">Simpan</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="7">Belum ada booking yang masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-wrap">
            {{ $bookings->withQueryString()->links() }}
        </div>
    </div>
</div>

<footer>
    <p>© {{ date('Y') }} NusantaraGuide Admin Panel</p>
</footer>
</body>
</html>