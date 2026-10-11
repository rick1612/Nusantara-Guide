<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — NusantaraGuide</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root{--forest:#1a3a2a;--jade:#2d6a4f;--lime:#74c69d;--cream:#fdf8f0;--gold:#e9c46a;--coral:#e76f51;--ink:#0d1b13;--muted:#6b7c72;}
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'DM Sans',sans-serif;background:var(--cream);color:var(--ink);min-height:100vh;display:flex;flex-direction:column;}

        /* SPLIT LAYOUT */
        .auth-wrap{display:grid;grid-template-columns:1fr 1fr;min-height:100vh;}

        /* LEFT — decorative panel */
        .auth-left{
            background:linear-gradient(160deg,rgba(13,27,19,0.75) 0%,rgba(26,58,42,0.6) 100%),
                       url('https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1200&q=80') center/cover no-repeat;
            display:flex;flex-direction:column;justify-content:space-between;
            padding:48px;position:relative;overflow:hidden;
        }
        .auth-left-logo{font-family:'Playfair Display',serif;font-size:26px;font-weight:900;color:white;text-decoration:none;}
        .auth-left-logo span{color:var(--gold);}
        .auth-left-content{position:relative;z-index:1;}
        .auth-left h2{font-family:'Playfair Display',serif;font-size:clamp(28px,4vw,42px);color:white;font-weight:900;line-height:1.2;margin-bottom:16px;}
        .auth-left h2 em{color:var(--gold);font-style:normal;}
        .auth-left p{font-size:15px;color:rgba(255,255,255,0.75);line-height:1.7;max-width:380px;}
        .auth-left-stats{display:flex;gap:32px;margin-top:32px;}
        .auth-stat .num{font-family:'Playfair Display',serif;font-size:28px;font-weight:900;color:var(--gold);}
        .auth-stat .lbl{font-size:12px;color:rgba(255,255,255,0.6);text-transform:uppercase;letter-spacing:0.5px;margin-top:2px;}

        /* RIGHT — form panel */
        .auth-right{display:flex;align-items:center;justify-content:center;padding:48px 10%;}
        .auth-form-wrap{width:100%;max-width:420px;}

        .auth-title{font-family:'Playfair Display',serif;font-size:32px;font-weight:900;color:var(--forest);margin-bottom:6px;}
        .auth-sub{font-size:15px;color:var(--muted);margin-bottom:36px;}
        .auth-sub a{color:var(--jade);font-weight:600;text-decoration:none;}
        .auth-sub a:hover{text-decoration:underline;}

        .form-group{margin-bottom:18px;}
        .form-group label{display:block;font-size:12px;font-weight:700;color:var(--muted);letter-spacing:0.5px;text-transform:uppercase;margin-bottom:7px;}
        .form-group input{
            width:100%;padding:13px 16px;
            border:1.5px solid #e0dbd2;border-radius:10px;
            font-family:'DM Sans',sans-serif;font-size:15px;color:var(--ink);
            background:white;outline:none;transition:border-color 0.2s,box-shadow 0.2s;
        }
        .form-group input:focus{border-color:var(--jade);box-shadow:0 0 0 3px rgba(45,106,79,0.08);}
        .form-group input.is-invalid{border-color:var(--coral);}

        .error-msg{font-size:12px;color:var(--coral);margin-top:5px;}

        .alert-error{
            background:rgba(231,111,81,0.08);border:1px solid rgba(231,111,81,0.3);
            border-radius:10px;padding:12px 16px;margin-bottom:20px;
            font-size:14px;color:var(--coral);
        }

        .submit-btn{
            width:100%;padding:14px;background:var(--jade);color:white;
            border:none;border-radius:10px;font-family:'DM Sans',sans-serif;
            font-size:16px;font-weight:700;cursor:pointer;transition:all 0.2s;
            margin-top:8px;
        }
        .submit-btn:hover{background:var(--forest);transform:translateY(-1px);}

        .divider{display:flex;align-items:center;gap:12px;margin:24px 0;}
        .divider::before,.divider::after{content:'';flex:1;height:1px;background:#e0dbd2;}
        .divider span{font-size:13px;color:var(--muted);}

        .register-link{
            display:block;text-align:center;padding:13px;
            border:1.5px solid var(--jade);border-radius:10px;
            color:var(--jade);text-decoration:none;font-size:15px;font-weight:600;
            transition:all 0.2s;
        }
        .register-link:hover{background:var(--jade);color:white;}

        @media(max-width:768px){
            .auth-wrap{grid-template-columns:1fr;}
            .auth-left{display:none;}
            .auth-right{padding:40px 8%;}
        }
    </style>
</head>
<body>
<div class="auth-wrap">

    <!-- LEFT PANEL -->
    <div class="auth-left">
        <a href="{{ route('home') }}" class="auth-left-logo">Nusantara<span>Guide</span></a>
        <div class="auth-left-content">
            <h2>Selamat datang kembali, <em>Penjelajah</em>!</h2>
            <p>Masuk untuk mengakses rencana perjalananmu, booking hotel & tiket, dan berbagi itinerary dengan komunitas traveler Indonesia.</p>
            <div class="auth-left-stats">
                <div class="auth-stat"><div class="num">500+</div><div class="lbl">Destinasi</div></div>
                <div class="auth-stat"><div class="num">10K+</div><div class="lbl">Traveler</div></div>
                <div class="auth-stat"><div class="num">200+</div><div class="lbl">Itinerary</div></div>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL — FORM -->
    <div class="auth-right">
        <div class="auth-form-wrap">
            <div class="auth-title">Masuk</div>
            <div class="auth-sub">Belum punya akun? <a href="{{ route('register') }}">Daftar gratis</a></div>

            @if($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif
            @if(session('error'))
                <div class="alert-error">{{ session('error') }}</div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="nama@email.com" required
                           class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                    @error('email')<div class="error-msg">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required
                           class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                    @error('password')<div class="error-msg">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="submit-btn">Masuk ke NusantaraGuide</button>
            </form>

            <div class="divider"><span>atau</span></div>

            <a href="{{ route('register') }}" class="register-link">Buat akun baru</a>
        </div>
    </div>

</div>
</body>
</html>