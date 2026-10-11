<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NusantaraGuide')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('styles')
    @yield('head')
</head>
<body>

<nav class="navbar">
    <a href="{{ route('home') }}" class="logo">Nusantara<span>Guide</span></a>

    <ul class="nav-links">
        <li><a href="{{ route('home') }}"              {{ request()->routeIs('home')                ? 'class=active' : '' }}>Beranda</a></li>
        <li><a href="{{ route('explore') }}"           {{ request()->routeIs('explore','province.*','region.*') ? 'class=active' : '' }}>Eksplorasi</a></li>
        <li><a href="{{ route('places.browse') }}"     {{ request()->routeIs('places.*','place.*')  ? 'class=active' : '' }}>Tempat</a></li>
        <li><a href="{{ route('itinerary.index') }}"   {{ request()->routeIs('itinerary.*')         ? 'class=active' : '' }}>Itinerary</a></li>
        <li><a href="{{ route('transportation.index') }}" {{ request()->routeIs('transportation.*') ? 'class=active' : '' }}>Transportasi</a></li>
        @auth
        <li><a href="{{ route('bookings.my') }}"       {{ request()->routeIs('bookings.*','booking.*') ? 'class=active' : '' }}>Bookings</a></li>
        <li><a href="{{ route('budget.index') }}"        {{ request()->routeIs('budget.*')           ? 'class=active' : '' }}>Budget</a></li>
        <li><a href="{{ route('seasonal.index') }}"      {{ request()->routeIs('seasonal.*')         ? 'class=active' : '' }}>Musim</a></li>
        <li><a href="{{ route('itinerary.create') }}"  class="nav-cta">+ Buat Itinerary</a></li>
        @endauth
    </ul>

    <div class="nav-right">
        @auth
            <span class="nav-user-name">Halo, {{ explode(' ', Auth::user()->name)[0] }}!</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Keluar</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="login-btn">Masuk</a>
            <a href="{{ route('register') }}" class="register-btn">Daftar</a>
        @endauth
    </div>
</nav>

@yield('content')

<footer class="site-footer">
    <p class="footer-logo">NusantaraGuide</p>
    <p>© {{ date('Y') }} NusantaraGuide — Panduan wisata seluruh <strong>Indonesia</strong></p>
    <p style="margin-top:8px;font-size:12px;">Dibuat dengan ❤️ untuk para penjelajah Nusantara</p>
</footer>

@yield('scripts')
</body>
</html>