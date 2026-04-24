<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | Parudeesa – The Lake View Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600;1,700&family=EB+Garamond:ital,wght@0,400;0,500;1,400&family=Josefin+Sans:wght@300;400;600&display=swap"
        rel="stylesheet" />

    <style>
        /* ═══════════════════════════════════════
       BRAND TOKENS
    ═══════════════════════════════════════ */
        :root {
            --brand: #fa873e;
            --brand-d: #e06828;
            --brand-dd: #c05520;
            --brand-l: #ffb07a;
            --brand-pale: #fff3ec;
            --brand-mist: #fff8f3;
            --cream: #fff3ec;
            --cream-d: #fde8d8;
            --parch: #fff8f3;
            --brn-dk: #3e2010;
            --brn-md: #7a4520;
            --brn: #a0622a;
            --brn-l: #c8895a;
            --olive: #7a7040;
            --olive-l: #a09858;
            --txt: #2e1a08;
            --txt-m: #7a5a3a;
            --txt-l: #b08060;
            --r: 16px;
            --ease: .35s cubic-bezier(.4, 0, .2, 1);
            --sh-s: 0 2px 16px rgba(250, 135, 62, .1);
            --sh-m: 0 6px 32px rgba(250, 135, 62, .15);
            --sh-l: 0 16px 56px rgba(250, 135, 62, .2);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        body {
            font-family: 'Josefin Sans', sans-serif;
            background: var(--brand-pale);
            color: var(--txt);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            font-family: 'Cormorant Garamond', serif
        }

        body::after {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 9990;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='0.015'/%3E%3C/svg%3E")
        }

        /* ═══════ NAVBAR ═══════ */
        .navbar {
            background: rgba(255, 243, 236, .97);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(250, 135, 62, .18);
            padding: .75rem 1rem;
            position: sticky;
            top: 0;
            z-index: 1050;
            box-shadow: 0 4px 28px rgba(250, 135, 62, .1);
            transition: box-shadow var(--ease), background var(--ease);
        }

        .navbar.scrolled {
            background: rgba(255, 243, 236, .97);
            box-shadow: 0 6px 36px rgba(250, 135, 62, .18);
        }

        .navbar-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--brn-dk) !important;
            letter-spacing: .3px;
            line-height: 1.1
        }

        .navbar-brand small {
            display: block;
            font-size: .52rem;
            font-weight: 400;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--brand);
            margin-top: .1rem
        }

        .nav-link {
            font-size: .65rem;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--txt-m) !important;
            padding: .45rem .85rem !important;
            border-radius: 50px;
            transition: all var(--ease);
            cursor: pointer
        }

        .nav-link:hover {
            color: var(--brand-d) !important;
            background: rgba(250, 135, 62, .1)
        }

        /* ═══════ BUTTONS ═══════ */
        .btn-brand {
            background: linear-gradient(135deg, var(--brand), var(--brand-d));
            color: #fff !important;
            border: none !important;
            border-radius: 10px;
            padding: .7rem 1.6rem;
            font-family: 'Josefin Sans', sans-serif;
            font-size: .73rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            box-shadow: 0 4px 18px rgba(250, 135, 62, .35);
            transition: transform var(--ease), box-shadow var(--ease);
            -webkit-tap-highlight-color: transparent;
            cursor: pointer;
            width: 100%;
        }

        .btn-brand:hover {
            color: #fff !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(250, 135, 62, .45);
        }

        /* ═══════ FORM STYLES ═══════ */
        .login-container {
            min-height: calc(100vh - 80px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
            overflow: hidden;
        }

        .login-bg {
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1800&q=85') center/cover no-repeat;
            filter: blur(8px) brightness(0.6);
            transform: scale(1.05);
            /* hide blurred edges */
            z-index: -1;
        }

        .login-card {
            background: var(--parch);
            border: 1px solid rgba(250, 135, 62, .18);
            border-radius: var(--r);
            padding: 3rem 2.5rem;
            box-shadow: var(--sh-l);
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
            animation: fadeUp .6s ease both;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .ornament-line {
            display: flex;
            align-items: center;
            gap: .8rem;
            justify-content: center;
            margin-bottom: .8rem
        }

        .ornament-line::before,
        .ornament-line::after {
            content: '';
            flex: 1;
            max-width: 40px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--brand))
        }

        .ornament-line::after {
            background: linear-gradient(270deg, transparent, var(--brand))
        }

        .ornament-line span {
            font-size: .55rem;
            letter-spacing: .25em;
            text-transform: uppercase;
            color: var(--brand);
            font-weight: 600
        }

        .login-header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--brn-dk);
            line-height: 1.15;
        }

        .login-header h1 em {
            font-style: italic;
            color: var(--brand);
        }

        .form-group {
            margin-bottom: 1.4rem;
        }

        label {
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--brand-d);
            display: block;
            margin-bottom: .4rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            border: 1.5px solid rgba(250, 135, 62, .25);
            border-radius: 8px;
            padding: .85rem 1rem;
            font-family: 'Josefin Sans', sans-serif;
            font-size: .95rem;
            background: var(--brand-mist);
            color: var(--txt);
            transition: border-color var(--ease), box-shadow var(--ease);
            outline: none;
        }

        input:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(250, 135, 62, .12);
            background: #fff;
        }

        .forgot-link {
            display: block;
            text-align: right;
            font-size: .75rem;
            color: var(--txt-m);
            text-decoration: none;
            margin-top: -0.6rem;
            margin-bottom: 1.5rem;
            transition: color var(--ease);
        }

        .forgot-link:hover {
            color: var(--brand-d);
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(26px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                Parudeesa <small>The Lake View Resort</small>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}"><i class="bi bi-arrow-left me-1"></i> Back to Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- LOGIN SECTION -->
    <div class="login-container">
        <div class="login-bg"></div>
        <div class="login-card">
            <div class="login-header">
                <div class="ornament-line"><span>Welcome Back</span></div>
                <h1>Member <em>Sign In</em></h1>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                @if ($errors->any())
                <div style="background: rgba(220, 53, 69, 0.1); border: 1px solid #dc3545; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem; color: #dc3545; font-size: 0.85rem;">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    @if ($errors->has('email'))
                        <div style="color: #dc3545; font-size: 0.75rem; margin-top: 0.3rem;">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
                    @if ($errors->has('password'))
                        <div style="color: #dc3545; font-size: 0.75rem; margin-top: 0.3rem;">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>

                <button type="submit" class="btn-brand">
                    Sign In
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>

</html>
