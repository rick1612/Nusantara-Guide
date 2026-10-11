<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Explore Malang</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <nav class="navbar">
        <div class="logo">Explore <span>Malang</span></div>
        <ul>
            <li><a href="{{ route('register') }}">Register</a></li>
        </ul>
    </nav>

    <section class="auth-container">
        <div class="auth-card">
            <h2>Login</h2>
            <p class="auth-subtitle">Welcome back! Please log in to continue.</p>

            @if(session('error'))
                <p style="color: red; margin-bottom: 10px;">{{ session('error') }}</p>
            @endif

            @if(session('success'))
                <p style="color: green; margin-bottom: 10px;">{{ session('success') }}</p>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>

                <button type="submit" class="auth-btn">Login</button>
            </form>

            <p class="auth-footer">
                Don't have an account? <a href="{{ route('register') }}">Register here</a>
            </p>
        </div>
    </section>

</body>
</html>