<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta name="description" content="Parudeesa – The Lake View Resort. Experience serenity by the lake. Kerala's premier lakeside staycation destination." />
    <title>@yield('title') | Parudeesa – The Lake View Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <style>
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
            --txt: #3b2a22;
            --txt-m: #5a5a5a;
            --txt-l: #7a5a3a;
            --r: 16px;
            --ease: .35s cubic-bezier(.4, 0, .2, 1);
            --sh-s: 0 2px 16px rgba(250, 135, 62, .1);
            --sh-m: 0 6px 32px rgba(250, 135, 62, .15);
            --sh-l: 0 16px 56px rgba(250, 135, 62, .2);
            --safe-t: env(safe-area-inset-top);
            --safe-b: env(safe-area-inset-bottom);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--brand-pale);
            color: var(--txt);
            overflow-x: hidden;
            font-weight: 300;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
        }

        /* NAVBAR */
        .navbar {
            background: rgba(255, 243, 236, .88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(250, 135, 62, .18);
            padding: .75rem 0;
            position: sticky;
            top: 0;
            z-index: 1050;
            box-shadow: 0 4px 28px rgba(250, 135, 62, .1);
        }

        .navbar-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--brn-dk) !important;
            letter-spacing: .3px;
            line-height: 1.1;
        }

        .navbar-brand small {
            display: block;
            font-size: .52rem;
            font-weight: 400;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--brand);
            margin-top: .1rem;
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
            cursor: pointer;
        }

        .nav-link:hover {
            color: var(--brand-d) !important;
            background: rgba(250, 135, 62, .1);
        }

        /* POLICY STYLES */
        .policy-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 60px 30px;
        }

        .policy-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 700;
            color: var(--brn-dk);
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .policy-date {
            text-align: center;
            color: var(--txt-m);
            font-size: .95rem;
            margin-bottom: 3rem;
        }

        .policy-content {
            background: white;
            border: 1px solid rgba(250, 135, 62, .15);
            border-radius: var(--r);
            padding: 3rem;
            box-shadow: var(--sh-m);
        }

        .policy-section {
            margin-bottom: 2.5rem;
        }

        .policy-section:last-child {
            margin-bottom: 0;
        }

        .policy-section h2 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--brand);
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid rgba(250, 135, 62, .2);
        }

        .policy-section p {
            font-family: 'Outfit', sans-serif;
            font-size: 0.95rem;
            color: var(--txt-m);
            line-height: 1.8;
            margin-bottom: 1rem;
        }

        .policy-section ul {
            list-style: none;
            padding: 0;
            margin: 1rem 0;
        }

        .policy-section li {
            font-family: 'Outfit', sans-serif;
            font-size: 0.95rem;
            color: var(--txt);
            line-height: 1.8;
            padding-left: 2rem;
            margin-bottom: 0.75rem;
            position: relative;
        }

        .policy-section li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: var(--brand);
            font-weight: 700;
            font-size: 1.2rem;
        }

        .policy-footer {
            text-align: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 2px solid rgba(250, 135, 62, .2);
            color: var(--txt-m);
            font-family: 'EB Garamond', serif;
            font-size: 1rem;
            line-height: 1.75;
        }

        /* FOOTER */
        footer {
            background: linear-gradient(160deg, #1e0a02 0%, var(--brn-dk) 100%);
            color: rgba(255, 243, 236, .6);
            padding: 65px 0 calc(24px + var(--safe-b));
            border-top: 2px solid rgba(250, 135, 62, .2);
            margin-top: 80px;
        }

        .f-brand {
            font-size: 1.8rem;
            font-weight: 700;
            font-style: italic;
            color: var(--brand-pale);
        }

        .f-brand small {
            display: block;
            font-size: .53rem;
            font-style: normal;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--brand-l);
            margin-top: .2rem;
            font-family: 'Josefin Sans', sans-serif;
        }

        .f-head {
            font-size: .58rem;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--brand-l);
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .f-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .f-links li {
            margin-bottom: .45rem;
        }

        .f-links a {
            font-size: .8rem;
            color: rgba(255, 243, 236, .45);
            text-decoration: none;
            transition: color var(--ease);
            cursor: pointer;
        }

        .f-links a:hover {
            color: var(--brand-l);
        }

        .f-copy {
            font-size: .68rem;
            opacity: .3;
            text-align: center;
        }

        .f-div {
            border-color: rgba(255, 255, 255, .06);
            margin: 2rem 0 1.2rem;
        }

        @media (max-width: 768px) {
            .policy-container {
                padding: 40px 20px;
            }

            .policy-content {
                padding: 2rem 1.5rem;
            }

            .policy-section h2 {
                font-size: 1.3rem;
            }

            .policy-section p,
            .policy-section li {
                font-size: 0.95rem;
            }
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <x-navbar :isHome="false" />

    <!-- MAIN CONTENT -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <x-footer :isHome="false" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<x-social-nav />
</body>
</html>
