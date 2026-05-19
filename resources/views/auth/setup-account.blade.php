<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | Parudeesa â€“ The Lake View Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600;1,700&family=EB+Garamond:ital,wght@0,400;0,500;1,400&family=Josefin+Sans:wght@300;400;600&family=Outfit:wght@300;400;500;600&display=swap"
        rel="stylesheet" />

    <style>
        /* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
       BRAND TOKENS
    â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
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
            font-family: 'Outfit', sans-serif;
            background: #000;
            color: var(--txt);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
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
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='0.02'/%3E%3C/svg%3E")
        }

        /* â•â•â•â•â•â•â• NAVBAR â•â•â•â•â•â•â• */
        .navbar {
            background: rgba(255, 243, 236, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(250, 135, 62, .1);
            padding: .75rem 1rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 2000;
            box-shadow: 0 4px 28px rgba(0, 0, 0, 0.05);
            transition: all var(--ease);
        }

        .navbar.scrolled {
            background: rgba(255, 243, 236, .98);
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
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
            font-size: .82rem;
            font-weight: 600;
            letter-spacing: .08em;
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

        /* â•â•â•â•â•â•â• BUTTONS â•â•â•â•â•â•â• */
        .btn-brand {
            background: linear-gradient(135deg, #D98A4E, #C7773A);
            color: #fff !important;
            border: none !important;
            border-radius: 12px;
            padding: 1rem 1.6rem;
            font-family: 'Outfit', sans-serif;
            font-size: .85rem;
            font-weight: 600;
            letter-spacing: .05em;
            text-transform: uppercase;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            box-shadow: 0 10px 25px rgba(217, 138, 78, 0.3);
            transition: all var(--ease);
            cursor: pointer;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-brand:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(250, 135, 62, .45);
        }

        /* â•â•â•â•â•â•â• FORM STYLES â•â•â•â•â•â•â• */
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .login-bg {
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1800&q=85') center/cover no-repeat;
            filter: blur(5px);
            transform: scale(1.1);
            z-index: -1;
        }

        .login-overlay {
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at center, rgba(46, 26, 8, 0.4), rgba(0, 0, 0, 0.75));
            z-index: 0;
        }

        .login-card {
            background: rgba(255, 248, 243, 0.82);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 24px;
            padding: 2.5rem 2.2rem;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 410px;
            position: relative;
            z-index: 1;
            margin-top: 60px; /* offset for navbar if needed */
            animation: fadeUp .8s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
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
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--brn-dk);
            line-height: 1.1;
            letter-spacing: -0.5px;
        }

        .login-header h1 em {
            font-style: italic;
            color: #C7773A;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        label {
            font-size: .65rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--txt-m);
            display: block;
            margin-bottom: .5rem;
            padding-left: 4px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            border: 1px solid rgba(217, 138, 78, 0.2);
            border-radius: 12px;
            padding: .95rem 1.2rem;
            font-family: 'Outfit', sans-serif;
            font-size: .9rem;
            background: rgba(255, 255, 255, 0.6);
            color: var(--txt);
            transition: all var(--ease);
            outline: none;
        }

        input:focus {
            border-color: #D98A4E;
            box-shadow: 0 0 0 4px rgba(217, 138, 78, 0.1);
            background: #fff;
        }

        .forgot-link {
            display: block;
            text-align: right;
            font-size: .7rem;
            font-weight: 500;
            color: var(--txt-l);
            text-decoration: none;
            margin-top: 0.5rem;
            margin-bottom: 2rem;
            transition: color var(--ease);
        }

        .forgot-link:hover {
            color: #C7773A;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 2.5rem 1.5rem;
                border-radius: 0;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                background: var(--parch);
                backdrop-filter: none;
            }
            .login-container {
                padding: 0;
            }
            .login-header h1 {
                font-size: 2rem;
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px)
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
    <x-navbar :isHome="false" />

    <!-- LOGIN SECTION -->
    <div class="login-container">
        <div class="login-bg"></div>
        <div class="login-overlay"></div>
        <div class="login-card">
            <div class="login-header">
                <img src="/images/parudeesa-logo.png" alt="Parudeesa Logo" style="height: 70px; width: auto; object-fit: contain; margin-bottom: 1rem;">
                <div class="ornament-line"><span>Welcome Back</span></div>
                <h1><em>Login</em></h1>
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
                    <label for="login">Email / Username / Phone</label>
                    <input type="text" id="login" name="login" placeholder="Enter email, username or phone" value="{{ old('login') }}" required autofocus autocomplete="username">
                    @if ($errors->has('login'))
                        <div style="color: #dc3545; font-size: 0.75rem; margin-top: 0.3rem;">{{ $errors->first('login') }}</div>
                    @endif
                </div>

                <div class="form-group" id="passwordGroup">
                    <label for="password">Password (Optional for Customers)</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="current-password">
                    @if ($errors->has('password'))
                        <div style="color: #dc3545; font-size: 0.75rem; margin-top: 0.3rem;">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <div class="form-group" id="otpGroup" style="display: none;">
                    <label for="otp">Enter OTP</label>
                    <input type="text" id="otp" name="otp" placeholder="Enter the 6-digit OTP">
                </div>

                <a href="{{ route('password.request') }}" class="forgot-link" id="forgotLink">Forgot Password?</a>

                <button type="submit" class="btn-brand" id="loginBtn">
                    Login
                </button>
                <button type="button" class="btn-brand" id="sendOtpBtn" style="display: none;">
                    Send OTP
                </button>
                <button type="button" class="btn-brand" id="verifyOtpBtn" style="display: none;">
                    Verify OTP & Login
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

        const loginInput = document.getElementById('login');
        const passwordGroup = document.getElementById('passwordGroup');
        const otpGroup = document.getElementById('otpGroup');
        const loginBtn = document.getElementById('loginBtn');
        const sendOtpBtn = document.getElementById('sendOtpBtn');
        const verifyOtpBtn = document.getElementById('verifyOtpBtn');
        const forgotLink = document.getElementById('forgotLink');
        let validationTimeout = null;

        loginInput.addEventListener('input', function() {
            clearTimeout(validationTimeout);
            const value = this.value.trim();
            const errorDiv = document.getElementById('phone-validation-error');
            
            // Only validate if it looks like a phone number (numeric)
            if (value && /^\d+$/.test(value)) {
                passwordGroup.style.display = 'none';
                forgotLink.style.display = 'none';
                
                if (otpGroup.style.display !== 'block') {
                    loginBtn.style.display = 'none';
                    sendOtpBtn.style.display = 'block';
                    verifyOtpBtn.style.display = 'none';
                }

                validationTimeout = setTimeout(() => {
                    fetch(`/api/check-phone-bookings/${value}`)
                        .then(res => res.json())
                        .then(data => {
                            if (!data.exists) {
                                if (!errorDiv) {
                                    const newErrorDiv = document.createElement('div');
                                    newErrorDiv.id = 'phone-validation-error';
                                    newErrorDiv.style.color = '#dc3545';
                                    newErrorDiv.style.fontSize = '0.75rem';
                                    newErrorDiv.style.marginTop = '0.3rem';
                                    newErrorDiv.innerText = 'No bookings found with this phone number. Please make a booking first.';
                                    loginInput.parentNode.appendChild(newErrorDiv);
                                } else {
                                    errorDiv.innerText = 'No bookings found with this phone number. Please make a booking first.';
                                }
                                loginInput.style.borderColor = '#dc3545';
                                sendOtpBtn.disabled = true;
                            } else {
                                if (errorDiv) errorDiv.remove();
                                loginInput.style.borderColor = '';
                                sendOtpBtn.disabled = false;
                            }
                        });
                }, 500);
            } else {
                passwordGroup.style.display = 'block';
                forgotLink.style.display = 'block';
                loginBtn.style.display = 'flex';
                sendOtpBtn.style.display = 'none';
                verifyOtpBtn.style.display = 'none';
                otpGroup.style.display = 'none';
                if (errorDiv) errorDiv.remove();
                loginInput.style.borderColor = '';
            }
        });

        sendOtpBtn.addEventListener('click', function() {
            const phone = loginInput.value.trim();
            sendOtpBtn.innerText = 'Sending...';
            sendOtpBtn.disabled = true;

            fetch('{{ route("otp.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ phone: phone })
            })
            .then(res => res.json())
            .then(data => {
                sendOtpBtn.disabled = false;
                if (data.error) {
                    sendOtpBtn.innerText = 'Send OTP';
                    const errorDiv = document.getElementById('phone-validation-error');
                    if (errorDiv) {
                         errorDiv.innerText = data.error;
                    } else {
                         const newErrorDiv = document.createElement('div');
                         newErrorDiv.id = 'phone-validation-error';
                         newErrorDiv.style.color = '#dc3545';
                         newErrorDiv.style.fontSize = '0.75rem';
                         newErrorDiv.style.marginTop = '0.3rem';
                         newErrorDiv.innerText = data.error;
                         loginInput.parentNode.appendChild(newErrorDiv);
                    }
                } else if (data.success) {
                    sendOtpBtn.style.display = 'none';
                    otpGroup.style.display = 'block';
                    verifyOtpBtn.style.display = 'flex';
                    alert(data.message);
                }
            })
            .catch(err => {
                sendOtpBtn.innerText = 'Send OTP';
                sendOtpBtn.disabled = false;
                console.error(err);
            });
        });

        verifyOtpBtn.addEventListener('click', function() {
            const phone = loginInput.value.trim();
            const otp = document.getElementById('otp').value.trim();
            verifyOtpBtn.innerText = 'Verifying...';
            verifyOtpBtn.disabled = true;

            fetch('{{ route("otp.verify") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ phone: phone, otp: otp })
            })
            .then(async res => {
                if (res.redirected) {
                    window.location.href = res.url;
                } else if (!res.ok) {
                    const data = await res.json();
                    throw data;
                } else {
                    return res.json();
                }
            })
            .then(data => {
                if (data && data.redirect) {
                     window.location.href = data.redirect;
                } else if (data && data.message) {
                     verifyOtpBtn.disabled = false;
                     verifyOtpBtn.innerText = 'Verify OTP & Login';
                     alert(data.message);
                }
            })
            .catch(err => {
                verifyOtpBtn.disabled = false;
                verifyOtpBtn.innerText = 'Verify OTP & Login';
                if (err && err.errors && err.errors.otp) {
                    alert(err.errors.otp[0]);
                } else {
                    alert(err.message || 'Verification failed');
                }
            });
        });
    </script>
</body>

</html>
