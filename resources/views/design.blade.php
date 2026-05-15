<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta name="description"
        content="Parudeesa – The Lake View Resort. Experience serenity by the lake. Kerala's premier lakeside staycation destination." />
    <title>Parudeesa – The Lake View Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // Immediate Page Initialization to prevent flash
        (function() {
            const hash = window.location.hash.replace('#', '') || 'home';
            const validPages = ['home', 'events', 'gallery', 'about', 'booking', 'login', 'register'];
            const target = validPages.includes(hash) ? hash : 'home';
            
            // Add a style to hide all pages except the target one immediately
            const style = document.createElement('style');
            style.id = 'flash-prevent';
            style.innerHTML = `.page:not(#page-${target}) { display: none !important; opacity: 0 !important; } #page-${target} { display: block !important; opacity: 1 !important; }`;
            document.head.appendChild(style);
        })();
    </script>


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

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        html, body {
            overflow-x: hidden;
            width: 100%;
            position: relative;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--brand-pale);
            color: var(--txt-m);
            font-weight: 300;
            -webkit-font-smoothing: antialiased
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            font-family: 'Playfair Display', serif;
            color: var(--txt);
            font-weight: 600;
            line-height: 1.25;
            letter-spacing: 0.02em;
        }

        body::after {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 9990;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='0.015'/%3E%3C/svg%3E")
        }

        /* Pages */
        .page {
            display: none;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .page.active {
            display: block;
            opacity: 1;
        }




        /* ═══════ BUTTONS ═══════ */
        .btn-brand {
            background: linear-gradient(135deg, var(--brand), var(--brand-d));
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: .7rem 1.6rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .73rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            box-shadow: 0 4px 18px rgba(250, 135, 62, .35);
            transition: transform var(--ease), box-shadow var(--ease);
            -webkit-tap-highlight-color: transparent;
            cursor: pointer
        }

        .btn-brand:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(250, 135, 62, .45)
        }

        .btn-wa {
            background: linear-gradient(135deg, #25D366, #1aa854);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: .7rem 1.6rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .73rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            box-shadow: 0 4px 18px rgba(37, 211, 102, .3);
            transition: transform var(--ease);
            -webkit-tap-highlight-color: transparent
        }

        .btn-wa:hover {
            color: #fff;
            transform: translateY(-2px)
        }

        .btn-outline-brand {
            background: transparent;
            color: var(--brand-d);
            border: 1.5px solid var(--brand);
            border-radius: 10px;
            padding: .68rem 1.6rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .73rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            transition: all var(--ease);
            cursor: pointer;
            -webkit-tap-highlight-color: transparent
        }

        .btn-outline-brand:hover {
            background: var(--brand);
            color: #fff;
            transform: translateY(-2px)
        }

        .btn-ghost {
            background: rgba(255, 255, 255, .12);
            color: #fff;
            border: 1.5px solid rgba(255, 255, 255, .4);
            border-radius: 10px;
            padding: .7rem 1.6rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .73rem;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            transition: all var(--ease);
            backdrop-filter: blur(8px);
            -webkit-tap-highlight-color: transparent
        }

        .btn-ghost:hover {
            background: rgba(255, 255, 255, .22);
            border-color: var(--brand-l);
            color: var(--brand-l);
            transform: translateY(-2px)
        }

        /* ═══════ ORNAMENTS ═══════ */
        .ornament-line {
            display: flex;
            align-items: center;
            gap: .8rem;
            justify-content: center;
            margin-bottom: 1rem
        }

        .ornament-line::before,
        .ornament-line::after {
            content: '';
            flex: 1;
            max-width: 80px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--brand))
        }

        .ornament-line::after {
            background: linear-gradient(270deg, transparent, var(--brand))
        }

        .ornament-line span {
            font-size: .58rem;
            letter-spacing: .25em;
            text-transform: uppercase;
            color: var(--brand);
            font-weight: 600
        }

        .eyebrow {
            font-size: .6rem;
            font-weight: 600;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--brand);
            display: block;
            margin-bottom: .5rem
        }

        .sec-title {
            font-size: clamp(1.9rem, 3.5vw, 2.8rem);
            font-weight: 700;
            color: var(--brn-dk);
            line-height: 1.15
        }

        .sec-title em {
            font-style: italic;
            color: var(--brand)
        }

        .wa-note {
            font-size: .64rem;
            color: var(--txt-m);
            display: flex;
            align-items: center;
            gap: .3rem;
            justify-content: center;
            margin-top: .5rem
        }

        /* ═══════ PAGE HERO (inner) ═══════ */
        .page-hero {
            position: relative;
            padding: 100px 0 65px;
            text-align: center;
            overflow: hidden
        }

        .ph-bg {
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1439066615861-d1af74d74000?w=1400&q=80') center/cover no-repeat
        }

        .ph-ov {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(62, 32, 16, .82) 0%, rgba(200, 90, 40, .68) 100%)
        }

        .ph-ct {
            position: relative;
            z-index: 2;
            color: var(--brand-pale)
        }

        .ph-title {
            font-size: clamp(1.8rem, 4.2vw, 3.2rem);
            font-weight: 700;
            font-style: italic;
            line-height: 1.1
        }

        .bc {
            display: flex;
            gap: .5rem;
            align-items: center;
            justify-content: center;
            font-size: .6rem;
            letter-spacing: .15em;
            text-transform: uppercase;
            color: rgba(255, 243, 236, .5);
            margin-top: .6rem
        }

        .bc span {
            color: var(--brand-l);
            cursor: pointer;
            transition: color var(--ease)
        }

        .bc span:hover {
            color: var(--brand-pale)
        }

        /* ═══════ HERO ═══════ */
        .hero {
            position: relative;
            min-height: 96vh;
            display: flex;
            align-items: center;
            overflow: hidden
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1800&q=85') center 55%/cover no-repeat;
            transform: scale(1.04);
            transition: transform 8s ease
        }

        .hero:hover .hero-bg {
            transform: scale(1)
        }

        .hero-ov {
            position: absolute;
            inset: 0;
            background: linear-gradient(160deg, rgba(62, 32, 16, .72) 0%, rgba(200, 90, 40, .38) 45%, rgba(250, 135, 62, .12) 70%, rgba(46, 26, 8, .82) 100%)
        }

        .hero-vig {
            position: absolute;
            inset: 0;
            box-shadow: inset 0 0 130px rgba(30, 12, 0, .55);
            pointer-events: none
        }

        .hero-frame {
            position: absolute;
            inset: 18px;
            border: 1px solid rgba(255, 243, 236, .18);
            pointer-events: none;
            z-index: 2
        }

        .hero-ct {
            position: relative;
            z-index: 3;
            text-align: center;
            color: #fff;
            width: 100%
        }

        .hero-name {
            font-size: clamp(2.5rem, 6.5vw, 4.8rem);
            font-weight: 700;
            font-style: italic;
            line-height: 1.0;
            color: var(--brand-pale);
            text-shadow: 0 4px 40px rgba(0, 0, 0, .45);
            animation: fadeUp .9s ease both
        }



        .hero-sub {
            font-size: clamp(.82rem, 2vw, 1.05rem);
            font-weight: 400;
            color: rgba(255, 243, 236, .72);
            letter-spacing: .14em;
            text-transform: uppercase;
            animation: fadeUp .9s .12s ease both
        }

        .hero-div {
            display: flex;
            align-items: center;
            gap: .7rem;
            justify-content: center;
            margin: .9rem auto 1rem;
            animation: fadeUp .9s .22s ease both
        }

        .hero-div::before,
        .hero-div::after {
            content: '';
            width: 50px;
            height: 1px;
            background: rgba(255, 243, 236, .32)
        }

        .hero-div span {
            font-size: .58rem;
            color: rgba(255, 243, 236, .42);
            letter-spacing: .2em
        }

        .hero-tag {
            font-family: 'EB Garamond', serif;
            font-size: clamp(.88rem, 1.5vw, 1.08rem);
            font-style: italic;
            color: rgba(255, 243, 236, .68);
            margin-bottom: 2rem;
            animation: fadeUp .9s .32s ease both
        }

        .hero-btns {
            animation: fadeUp .9s .44s ease both;
            display: flex;
            gap: .8rem;
            justify-content: center;
            flex-wrap: wrap
        }

        /* SCROLL HINT */
        .scroll-hint {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 3;
            text-align: center;
            color: rgba(255, 243, 236, .38);
            font-size: .52rem;
            letter-spacing: .2em;
            text-transform: uppercase
        }

        @keyframes bob {

            0%,
            100% {
                transform: translateX(-50%) translateY(0)
            }

            50% {
                transform: translateX(-50%) translateY(7px)
            }
        }

        .scroll-hint {
            animation: bob 2.5s ease-in-out infinite
        }

        /* ═══════ PROPERTY CARDS ═══════ */
        .feat-sec {
            padding: 80px 0 70px;
            background: linear-gradient(180deg, var(--brand-pale) 0%, var(--cream-d) 100%);
            position: relative
        }

        .feat-sec::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--brand), var(--brand-l), var(--brand), transparent)
        }

        .ig-link {
            display: block;
            cursor: pointer;
            position: relative
        }

        .ig-link::after {
            content: '\f2d1';
            font-family: 'bootstrap-icons';
            position: absolute;
            inset: 0;
            background: rgba(250, 135, 62, 0);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #fff;
            opacity: 0;
            transition: all var(--ease)
        }

        .ig-link:hover::after {
            opacity: 1;
            background: rgba(250, 135, 62, .45)
        }

        .prop-card {
            background: var(--parch);
            border-radius: var(--r);
            border: 1px solid rgba(250, 135, 62, .15);
            box-shadow: var(--sh-m);
            overflow: hidden;
            height: 100%;
            transition: transform var(--ease), box-shadow var(--ease)
        }

        .prop-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--sh-l)
        }

        .prop-img {
            position: relative;
            height: 245px;
            overflow: hidden
        }

        .prop-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .7s ease;
            display: block
        }

        .prop-card:hover .prop-img img {
            transform: scale(1.07)
        }

        .prop-img-ov {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(62, 32, 16, .6) 0%, transparent 52%);
            pointer-events: none
        }

        .prop-price-b {
            position: absolute;
            bottom: 12px;
            right: 12px;
            background: linear-gradient(135deg, rgba(255, 248, 240, .96), rgba(255, 234, 214, .92));
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(250, 135, 62, .28);
            border-radius: 12px;
            padding: .48rem .95rem;
            box-shadow: 0 10px 24px rgba(116, 62, 22, .18)
        }

        .prop-price-b .amt {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.22rem;
            font-weight: 700;
            color: #d96520;
            display: block;
            line-height: 1
        }

        .prop-price-b .per {
            font-size: .58rem;
            color: rgba(99, 57, 27, .72);
            letter-spacing: .12em
        }

        .prop-body {
            padding: 1.4rem 1.5rem 1.5rem
        }

        .prop-name {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--brn-dk);
            margin-bottom: .35rem;
            line-height: 1.2
        }

        .prop-desc {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .88rem;
            color: var(--txt-m);
            line-height: 1.65;
            margin-bottom: 1rem
        }

        .prop-pills {
            display: flex;
            gap: .5rem;
            flex-wrap: wrap;
            margin-bottom: 1.2rem
        }

        .pill {
            background: rgba(250, 135, 62, .08);
            border: 1px solid rgba(250, 135, 62, .2);
            color: var(--brand-d);
            border-radius: 50px;
            padding: .2rem .7rem;
            font-size: .6rem;
            font-weight: 600;
            letter-spacing: .07em;
            text-transform: uppercase
        }

        .prop-footer {
            display: flex;
            gap: .6rem;
            flex-wrap: wrap;
            padding-top: 1.1rem;
            border-top: 1px solid rgba(250, 135, 62, .12)
        }

        /* ═══════ AMENITIES ═══════ */
        .amen-sec {
            padding: 80px 0;
            background: linear-gradient(160deg, var(--brn-dk) 0%, var(--brn-md) 100%);
            position: relative;
            overflow: hidden
        }

        .amen-sec::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 30% 50%, rgba(250, 135, 62, .12) 0%, transparent 65%);
            pointer-events: none
        }

        .amen-card {
            background: #7d5a44; /* Lighter shade of brown */
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .amen-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.3);
        }

        .amen-img-box {
            position: relative;
            width: 100%;
            padding-top: 60%; /* Slightly taller than 16:9 for this look */
            overflow: hidden;
        }

        .amen-img-box img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .amen-card:hover .amen-img-box img {
            transform: scale(1.08);
        }

        .amen-footer {
            padding: 1.5rem 1rem;
            text-align: center;
            background: #7d5a44; /* Lighter shade of brown */
        }

        .amen-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff8f3;
            margin: 0;
            font-family: 'Cormorant Garamond', serif;
            letter-spacing: 0.05em;
        }

        @media (max-width: 768px) {
            .amen-title {
                font-size: 1.1rem;
            }
        }

        /* ═══════ EVENTS BANNER (home) ═══════ */
        .ev-banner {
            position: relative;
            padding: 90px 0;
            overflow: hidden
        }

        .ev-banner-bg {
            position: absolute;
            inset: 0;
            background: url('/images/event-hero-main.jpg') center/cover no-repeat
        }

        .ev-banner-ov {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(62, 32, 16, .88) 0%, rgba(250, 135, 62, .55) 100%)
        }

        .ev-banner-ct {
            position: relative;
            z-index: 2;
            color: #fff;
            text-align: center
        }

        /* ═══════ GOOGLE REVIEWS ═══════ */
        .reviews-sec {
            padding: 80px 0;
            background: linear-gradient(160deg, var(--brn-dk) 0%, #2e1408 100%)
        }

        .review-card {
            display: block;
            background: var(--parch);
            border: 1px solid rgba(250, 135, 62, .15);
            border-radius: var(--r);
            padding: 1.6rem;
            height: 100%;
            box-shadow: var(--sh-s);
            color: inherit;
            text-decoration: none;
            cursor: pointer;
            transition: transform var(--ease), box-shadow var(--ease)
        }

        .review-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--sh-m)
        }

        .review-stars {
            color: #f5a623;
            font-size: .85rem;
            margin-bottom: .7rem
        }

        .review-text {
            font-family: 'EB Garamond', serif;
            font-size: 1rem;
            font-style: italic;
            color: var(--txt-m);
            line-height: 1.75;
            margin-bottom: 1.2rem
        }

        .review-av {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--brand), var(--brand-d));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #fff;
            font-size: .9rem;
            flex-shrink: 0
        }

        .review-name {
            font-weight: 700;
            color: var(--brn-dk);
            font-size: .88rem
        }

        .review-src {
            font-size: .68rem;
            color: var(--txt-l);
            display: flex;
            align-items: center;
            gap: .3rem
        }

        .google-badge {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: rgba(250, 135, 62, .08);
            border: 1px solid rgba(250, 135, 62, .2);
            border-radius: 50px;
            padding: .3rem .85rem;
            font-size: .65rem;
            font-weight: 700;
            color: var(--brand-d);
            margin-bottom: 1.5rem;
            cursor: pointer;
            text-decoration: none
        }

        /* ═══════ INSTAGRAM REELS ═══════ */
        .reels-sec {
            padding: 80px 0;
            background: linear-gradient(180deg, var(--cream-d) 0%, var(--brand-pale) 100%)
        }

        .reel-card {
            border-radius: var(--r);
            overflow: hidden;
            position: relative;
            aspect-ratio: 9/16;
            max-height: 380px;
            cursor: pointer
        }

        .reel-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .6s ease
        }

        .reel-card:hover img {
            transform: scale(1.06)
        }

        .reel-ov {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(62, 32, 16, .75) 0%, transparent 55%);
            display: flex;
            align-items: flex-end;
            padding: 1rem
        }

        .reel-play {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, .22);
            backdrop-filter: blur(6px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.3rem;
            border: 2px solid rgba(255, 255, 255, .5);
            transition: all var(--ease)
        }

        .reel-card:hover .reel-play {
            background: var(--brand);
            border-color: var(--brand);
            transform: translate(-50%, -50%) scale(1.1);
            box-shadow: 0 0 20px rgba(250, 135, 62, 0.6);
            animation: pulse-play 1.5s infinite;
        }

        @keyframes pulse-play {
            0% { box-shadow: 0 0 0 0 rgba(250, 135, 62, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(250, 135, 62, 0); }
            100% { box-shadow: 0 0 0 0 rgba(250, 135, 62, 0); }
        }

        .reel-label {
            color: rgba(255, 243, 236, .85);
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .06em
        }

        /* ═══════ EVENTS PAGE ═══════ */
        .ev-card {
            background: var(--parch);
            border: 1px solid rgba(250, 135, 62, .15);
            border-radius: var(--r);
            box-shadow: var(--sh-s);
            overflow: hidden;
            height: 100%;
            transition: transform var(--ease), box-shadow var(--ease)
        }

        .ev-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--sh-l)
        }

        .ev-hdr {
            padding: 1.5rem 1.5rem 1rem;
            text-align: center;
            border-bottom: 2px solid rgba(250, 135, 62, .25)
        }

        .ev-hdr-org {
            background: linear-gradient(135deg, var(--brand-d), var(--brn-md))
        }

        .ev-hdr-pur {
            background: linear-gradient(135deg, #7a5c6e, #5a3f52)
        }

        .ev-hdr-teal {
            background: linear-gradient(135deg, #2d7a6e, #1a5a52)
        }

        .ev-hdr-gold {
            background: linear-gradient(135deg, #8a6a20, #b89038)
        }

        .ev-label {
            font-size: .58rem;
            font-weight: 700;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: rgba(255, 243, 236, .65);
            margin-bottom: .3rem;
            display: block
        }

        .ev-name {
            font-size: 1.4rem;
            font-weight: 700;
            font-style: italic;
            color: var(--brand-pale);
            line-height: 1.15
        }

        .ev-cap {
            font-size: .62rem;
            color: rgba(255, 243, 236, .55);
            margin-top: .2rem
        }

        .ev-body {
            padding: 1.4rem 1.5rem 1.5rem
        }

        .ev-price {
            font-size: 2rem;
            font-weight: 700;
            color: var(--brand);
            line-height: 1;
            margin-bottom: .4rem
        }

        .ev-price small {
            font-size: .6rem;
            color: var(--txt-m);
            font-weight: 400;
            font-family: 'Josefin Sans', sans-serif
        }

        .ev-desc {
            font-family: 'EB Garamond', serif;
            font-size: .95rem;
            color: var(--txt-m);
            line-height: 1.65;
            margin-bottom: 1rem
        }

        .ev-inc {
            margin-bottom: 1.2rem;
            list-style: none;
            padding: 0
        }

        .ev-inc li {
            font-size: .72rem;
            color: var(--txt-m);
            padding: .25rem 0;
            border-bottom: 1px dashed rgba(250, 135, 62, .15);
            display: flex;
            align-items: center;
            gap: .5rem
        }

        .ev-inc li:last-child {
            border-bottom: none
        }

        .ev-inc li i {
            color: var(--olive)
        }

        /* ═══════ GALLERY ═══════ */
        .gallery-sec {
            padding: 80px 0;
            background: var(--brand-pale)
        }

        .gal-filter {
            display: flex;
            gap: .5rem;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 2.5rem
        }

        .gal-btn {
            background: transparent;
            border: 1.5px solid rgba(250, 135, 62, .3);
            border-radius: 50px;
            padding: .45rem 1.2rem;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--brand-d);
            cursor: pointer;
            transition: all var(--ease);
            -webkit-tap-highlight-color: transparent
        }

        .gal-btn.active,
        .gal-btn:hover {
            background: var(--brand);
            border-color: var(--brand);
            color: #fff
        }

        .gal-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            grid-auto-rows: 250px;
            grid-auto-flow: dense;
            gap: 20px;
            padding: 10px 0;
        }

        .gal-item {
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--cream-d);
            border: 1px solid rgba(250, 135, 62, 0.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .gal-item.wide {
            grid-column: span 2;
        }

        .gal-item.tall {
            grid-row: span 2;
        }

        .gal-item img, 
        .gal-item video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            display: block;
        }

        .gal-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(62, 32, 16, 0.15);
            z-index: 2;
        }

        .gal-item:hover img,
        .gal-item:hover video {
            transform: scale(1.1);
        }

        .gal-item-ov {
            position: absolute;
            inset: 0;
            background: rgba(250, 135, 62, 0);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background var(--ease)
        }

        .gal-item:hover .gal-item-ov {
            background: rgba(250, 135, 62, .35)
        }

        .gal-item-ov i {
            color: #fff;
            font-size: 1.5rem;
            opacity: 0;
            transform: scale(.8);
            transition: all var(--ease)
        }

        .gal-item:hover .gal-item-ov i {
            opacity: 1;
            transform: scale(1)
        }

        /* ═══════ ABOUT US ═══════ */
        .about-sec {
            padding: 80px 0;
            background: linear-gradient(180deg, var(--brand-pale) 0%, var(--cream-d) 100%)
        }

        .about-img-wrap {
            border-radius: var(--r);
            overflow: hidden;
            box-shadow: var(--sh-l);
            position: relative
        }

        .about-img-wrap img {
            width: 100%;
            height: 420px;
            object-fit: cover
        }

        .about-badge {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background: var(--brand);
            color: #fff;
            border-radius: 12px;
            padding: .8rem 1.2rem;
            text-align: center
        }

        .about-badge .num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 700;
            line-height: 1
        }

        .about-badge .lbl {
            font-size: .6rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            opacity: .88
        }

        .stat-box {
            background: var(--parch);
            border: 1px solid rgba(250, 135, 62, .15);
            border-radius: 12px;
            padding: 1.2rem;
            text-align: center;
            box-shadow: var(--sh-s)
        }

        .stat-box .n {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--brand);
            line-height: 1
        }

        .stat-box .l {
            font-size: .68rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--txt-m);
            margin-top: .3rem
        }

        .team-card {
            background: var(--parch);
            border: 1px solid rgba(250, 135, 62, .12);
            border-radius: var(--r);
            overflow: hidden;
            text-align: center;
            box-shadow: var(--sh-s);
            transition: transform var(--ease), box-shadow var(--ease)
        }

        .team-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--sh-m)
        }

        .team-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            object-position: top
        }

        .team-body {
            padding: 1.2rem 1rem
        }

        .team-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--brn-dk)
        }

        .team-role {
            font-size: .7rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--brand);
            margin-top: .2rem
        }

        /* ═══════ CONTACT ═══════ */
        .contact-sec {
            padding: 80px 0;
            background: linear-gradient(180deg, var(--cream-d) 0%, var(--brand-pale) 100%)
        }

        .contact-card {
            background: var(--parch);
            border: 1px solid rgba(250, 135, 62, .18);
            border-radius: var(--r);
            padding: 2rem;
            box-shadow: var(--sh-m)
        }

        .contact-info-item {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            padding: .9rem 0;
            border-bottom: 1px dashed rgba(250, 135, 62, .15)
        }

        .contact-info-item:last-child {
            border-bottom: none
        }

        .ci-icon {
            width: 44px;
            height: 44px;
            background: rgba(250, 135, 62, .1);
            border: 1px solid rgba(250, 135, 62, .2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: var(--brand);
            flex-shrink: 0
        }

        .ci-label {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--txt-l);
            margin-bottom: .2rem
        }

        .ci-value {
            font-size: .88rem;
            color: var(--brn-dk);
            font-weight: 600
        }

        .ci-sub {
            font-size: .75rem;
            color: var(--txt-m)
        }

        .contact-form label {
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--brand-d);
            display: block;
            margin-bottom: .3rem
        }

        .contact-form input,
        .contact-form select,
        .contact-form textarea {
            width: 100%;
            border: 1.5px solid rgba(250, 135, 62, .25);
            border-radius: 8px;
            padding: .65rem 1rem;
            font-family: 'Josefin Sans', sans-serif;
            font-size: .85rem;
            background: var(--brand-mist);
            color: var(--txt);
            transition: border-color var(--ease);
            -webkit-appearance: none;
            appearance: none;
            outline: none
        }

        .contact-form input:focus,
        .contact-form select:focus,
        .contact-form textarea:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(250, 135, 62, .12);
            background: #fff
        }

        .contact-form .fg {
            margin-bottom: 1rem
        }

        .map-embed {
            border-radius: var(--r);
            overflow: hidden;
            box-shadow: var(--sh-m);
            height: 280px;
            border: 1px solid rgba(250, 135, 62, .15)
        }

        .map-embed iframe {
            width: 100%;
            height: 100%;
            border: none
        }

        /* ═══════ BOOKING FORM ═══════ */
        .rp-form {
            background: var(--parch);
            border: 1px solid rgba(250, 135, 62, .18);
            border-radius: var(--r);
            padding: 2rem;
            box-shadow: var(--sh-m)
        }

        .rp-form label {
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--brand-d);
            display: block;
            margin-bottom: .3rem
        }

        .rp-form input,
        .rp-form select,
        .rp-form textarea {
            width: 100%;
            border: 1.5px solid rgba(250, 135, 62, .25);
            border-radius: 8px;
            padding: .65rem 1rem;
            font-family: 'Josefin Sans', sans-serif;
            font-size: .85rem;
            background: var(--brand-mist);
            color: var(--txt);
            transition: border-color var(--ease);
            -webkit-appearance: none;
            appearance: none;
            outline: none
        }

        .rp-form input:focus,
        .rp-form select:focus,
        .rp-form textarea:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(250, 135, 62, .12);
            background: #fff
        }

        .rp-form .form-group {
            margin-bottom: 1rem
        }

        .bk-tab-row {
            display: inline-flex;
            gap: .5rem;
            background: rgba(250, 135, 62, .08);
            border: 1px solid rgba(250, 135, 62, .2);
            border-radius: 50px;
            padding: .35rem
        }

        .bk-tab {
            background: transparent;
            border: none;
            border-radius: 50px;
            padding: .55rem 1.4rem;
            font-family: 'Josefin Sans', sans-serif;
            font-size: .73rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--txt-m);
            cursor: pointer;
            transition: all var(--ease);
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            -webkit-tap-highlight-color: transparent
        }

        .bk-tab.active {
            background: linear-gradient(135deg, var(--brand), var(--brand-d));
            color: #fff;
            box-shadow: 0 3px 14px rgba(250, 135, 62, .3)
        }

        .bk-card {
            background: var(--parch);
            border: 1px solid rgba(250, 135, 62, .18);
            border-radius: var(--r);
            padding: 2rem;
            box-shadow: var(--sh-m)
        }

        .brow {
            display: flex;
            justify-content: space-between;
            padding: .75rem 0;
            border-bottom: 1px dashed rgba(250, 135, 62, .18);
            font-size: .82rem
        }

        .brow:last-of-type {
            border-bottom: none
        }

        .bl {
            color: var(--txt-m);
            font-size: .7rem;
            letter-spacing: .08em;
            text-transform: uppercase
        }

        .bv {
            font-weight: 700;
            color: var(--brn-dk)
        }

        .btotal {
            background: linear-gradient(135deg, var(--brand-d), var(--brn-md));
            border-radius: 10px;
            padding: 1.1rem 1.3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1rem 0;
            border: 1px solid rgba(250, 135, 62, .25)
        }

        .btotal .tl {
            font-size: .63rem;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255, 243, 236, .65)
        }

        .btotal .tp {
            font-size: 1.9rem;
            font-weight: 700;
            color: var(--brand-l)
        }

        .wa-box {
            background: rgba(37, 211, 102, .08);
            border: 1px solid rgba(37, 211, 102, .22);
            border-radius: 10px;
            padding: .9rem 1.1rem;
            text-align: center;
            margin: .9rem 0
        }

        .wa-box p {
            font-size: .75rem;
            color: #1a9e50;
            margin: 0;
            line-height: 1.5
        }

        .amenity-check-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin-top: .4rem
        }

        .amen-check-item {
            display: flex;
            align-items: center;
            gap: .6rem;
            background: var(--parch);
            border: 1.5px solid rgba(250, 135, 62, .18);
            border-radius: 10px;
            padding: .65rem .9rem;
            cursor: pointer;
            font-size: .8rem;
            color: var(--txt);
            transition: border-color var(--ease), background var(--ease);
            -webkit-tap-highlight-color: transparent;
            user-select: none;
            -webkit-user-select: none
        }

        .amen-check-item:hover {
            border-color: var(--brand);
            background: rgba(250, 135, 62, .04)
        }

        .amen-check-item input[type="checkbox"] {
            display: none
        }

        .amen-check-box {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            border: 1.5px solid rgba(250, 135, 62, .35);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            color: transparent;
            flex-shrink: 0;
            transition: all var(--ease);
            background: transparent
        }

        .amen-check-item input[type="checkbox"]:checked~.amen-check-box {
            background: var(--brand);
            border-color: var(--brand);
            color: #fff
        }

        .amen-check-item:has(input:checked) {
            border-color: var(--brand);
            background: rgba(250, 135, 62, .06)
        }

        .how-step {
            background: linear-gradient(160deg, var(--parch), var(--cream-d));
            border: 1px solid rgba(250, 135, 62, .15);
            border-radius: var(--r);
            padding: 2.2rem 1.5rem;
            text-align: center;
            height: 100%;
            transition: transform var(--ease), box-shadow var(--ease)
        }

        .how-step:hover {
            transform: translateY(-5px);
            box-shadow: var(--sh-m)
        }

        .step-n {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.1rem;
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
            font-family: 'Cormorant Garamond', serif
        }

        .step-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--brn-dk);
            margin-bottom: .5rem
        }

        .step-desc {
            font-family: 'EB Garamond', serif;
            font-size: .95rem;
            color: var(--txt-m);
            line-height: 1.65
        }

        /* ═══════ FOOTER ═══════ */

        .footer-contact {
            font-size: .8rem;
            color: rgba(255, 243, 236, .45);
            line-height: 2.05
        }

        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: .5rem
        }

        .footer-contact-item i {
            margin-top: .42rem;
            flex-shrink: 0
        }

        .footer-contact-item a {
            color: inherit;
            text-decoration: none
        }

        .soc {
            width: 35px;
            height: 35px;
            border: 1px solid rgba(250, 135, 62, .22);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 243, 236, .5);
            text-decoration: none;
            font-size: .88rem;
            transition: all var(--ease);
            margin-right: .4rem
        }

        .soc:hover {
            border-color: var(--brand);
            color: var(--brand-l);
            transform: translateY(-2px)
        }


        /* ═══════ SOCIAL PROOF POPUP ═══════ */
        .sp-popup {
            position: fixed;
            bottom: calc(1.8rem + var(--safe-b));
            left: 1.2rem;
            background: var(--parch);
            border: 1px solid rgba(250, 135, 62, .25);
            border-radius: 14px;
            padding: .8rem 1rem;
            max-width: 265px;
            box-shadow: 0 8px 32px rgba(250, 135, 62, .2);
            z-index: 994;
            display: flex;
            align-items: center;
            gap: .75rem;
            transform: translateX(-110%);
            opacity: 0;
            transition: transform .5s cubic-bezier(.34, 1.56, .64, 1), opacity .5s ease
        }

        .sp-popup.show {
            transform: translateX(0);
            opacity: 1
        }

        .sp-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem
        }

        .sp-icon-v {
            background: rgba(250, 135, 62, .15)
        }

        .sp-icon-b {
            background: rgba(37, 211, 102, .15)
        }

        .sp-text strong {
            font-size: .78rem;
            color: var(--brn-dk);
            font-weight: 700;
            display: block;
            line-height: 1.2
        }

        .sp-text span {
            font-size: .66rem;
            color: var(--txt-m)
        }

        .sp-close {
            font-size: .9rem;
            color: var(--txt-m);
            cursor: pointer;
            flex-shrink: 0;
            padding: .2rem;
            -webkit-tap-highlight-color: transparent
        }

        /* ═══════ INSTAGRAM MODAL ═══════ */
        .ig-modal-bg {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .6);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 1100;
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s ease
        }

        .ig-modal-bg.open {
            opacity: 1;
            pointer-events: auto
        }

        .ig-modal {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(.92);
            background: var(--parch);
            border-radius: 20px;
            padding: 2rem;
            width: min(340px, 90vw);
            text-align: center;
            transition: transform .35s cubic-bezier(.34, 1.56, .64, 1);
            box-shadow: 0 24px 64px rgba(0, 0, 0, .3)
        }

        .ig-modal-bg.open .ig-modal {
            transform: translate(-50%, -50%) scale(1)
        }

        .ig-modal h4 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--brn-dk);
            margin: .7rem 0 .4rem
        }

        .ig-modal p {
            font-size: .85rem;
            color: var(--txt-m);
            margin-bottom: 1.2rem;
            line-height: 1.6
        }

        .ig-modal-icon {
            font-size: 2.5rem;
            background: linear-gradient(135deg, #f09433, #dc2743, #bc1888);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text
        }

        /* ═══════ REEL MODAL ═══════ */
        .reel-modal-bg {
            position: fixed;
            inset: 0;
            background: rgba(62, 32, 16, 0.95);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.5s var(--ease);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .reel-modal-bg.open {
            opacity: 1;
            visibility: visible;
        }

        .reel-modal {
            background: #fff;
            border-radius: 28px;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow: hidden;
            position: relative;
            transform: translateY(40px) scale(0.9);
            transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 40px 120px rgba(0, 0, 0, 0.6);
            display: flex;
            flex-direction: column;
        }

        .reel-modal-bg.open .reel-modal {
            transform: translateY(0) scale(1);
        }

        .reel-modal-body {
            padding: 0;
            overflow-y: auto;
            flex-grow: 1;
            display: flex;
            justify-content: center;
            background: #fafafa;
        }

        .reel-modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 44px;
            height: 44px;
            background: #fff;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            color: var(--brn-dk);
            cursor: pointer;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }

        .reel-modal-close:hover {
            background: var(--brand);
            color: #fff;
            transform: rotate(90deg);
        }


        @keyframes pulse-wa {

            0%,
            100% {
                box-shadow: 0 4px 20px rgba(37, 211, 102, .4)
            }

            50% {
                box-shadow: 0 4px 36px rgba(37, 211, 102, .65)
            }
        }


        .cb-head {
            background: linear-gradient(135deg, #d96520, #fa873e);
            padding: .7rem .9rem;
            display: flex;
            align-items: center;
            gap: .6rem;
            flex-shrink: 0
        }

        .cb-av {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .22);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0
        }

        .cb-info {
            flex: 1
        }

        .cb-info strong {
            color: #fff;
            font-size: .82rem;
            display: block;
            font-family: 'Josefin Sans', sans-serif
        }

        .cb-info span {
            color: rgba(255, 255, 255, .8);
            font-size: .65rem;
            display: flex;
            align-items: center;
            gap: .2rem
        }

        .cb-dot {
            width: 7px;
            height: 7px;
            background: #25D366;
            border-radius: 50%;
            display: inline-block
        }

        .cb-close {
            background: rgba(255, 255, 255, .18);
            border: none;
            color: #fff;
            cursor: pointer;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            font-size: .8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            -webkit-tap-highlight-color: transparent;
            flex-shrink: 0;
            transition: background .2s ease
        }

        .cb-close:hover {
            background: rgba(255, 255, 255, .28)
        }

      .cb-body {
    display: flex;
    flex-direction: column;
    /* Change 'flex-end' back to 'flex-start' to fill from the top */
    justify-content: flex-start; 
    
    flex: 1;
    padding: 15px;
    background: #fde9d8;
    
    /* Keep your comfortable height */
    height: 450px; 
    overflow-y: auto;
}

/* Add this to your message container to ensure it expands */
.messages-wrapper {
    display: flex;
    flex-direction: column;
    gap: 10px;
    /* This ensures that the messages don't have weird spacing between them */
}

        .cb-frame {
            width: 100%;
            height: 100%;
            border: 0;
            display: block;
            background: #fde9d8
        }

        .cb-bot-msg {
            background: #fff;
            color: #3e2010;
            border-radius: 4px 12px 12px 12px;
            padding: .5rem .75rem;
            font-size: .76rem;
            line-height: 1.45;
            max-width: 85%;
            align-self: flex-start;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
            white-space: pre-line;
            font-family: 'Josefin Sans', sans-serif
        }

        .cb-user-msg {
            background: linear-gradient(135deg, #fa873e, #d96520);
            color: #fff;
            border-radius: 12px 12px 4px 12px;
            padding: .5rem .75rem;
            font-size: .76rem;
            line-height: 1.45;
            max-width: 85%;
            align-self: flex-end;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .1);
            font-family: 'Josefin Sans', sans-serif
        }

        .cb-typing {
            background: #fff;
            border-radius: 4px 12px 12px 12px;
            padding: .4rem .75rem;
            align-self: flex-start;
            display: flex;
            gap: 4px;
            align-items: center
        }

        .cb-typing span {
            width: 7px;
            height: 7px;
            background: var(--brand);
            border-radius: 50%;
            animation: cbT 1.2s ease-in-out infinite
        }

        .cb-typing span:nth-child(2) {
            animation-delay: .2s
        }

        .cb-typing span:nth-child(3) {
            animation-delay: .4s
        }

        @keyframes cbT {

            0%,
            80%,
            100% {
                transform: scale(1);
                opacity: .4
            }

            40% {
                transform: scale(1.3);
                opacity: 1
            }
        }

        .cb-qr-wrap {
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-top: 3px
        }

        .cb-qbtn {
            background: rgba(250, 135, 62, .08);
            border: 1.2px solid rgba(250, 135, 62, .3);
            color: #d96520;
            border-radius: 16px;
            padding: .4rem .8rem;
            font-size: .71rem;
            font-weight: 600;
            cursor: pointer;
            text-align: left;
            transition: all var(--ease);
            -webkit-tap-highlight-color: transparent;
            font-family: 'Josefin Sans', sans-serif
        }

        .cb-qbtn:hover {
            background: rgba(250, 135, 62, .2);
            border-color: var(--brand)
        }

        .cb-wa-link {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            background: #25D366;
            color: #fff;
            border-radius: 6px;
            padding: .4rem .8rem;
            font-size: .70rem;
            font-weight: 700;
            text-decoration: none;
            margin-top: 3px;
            -webkit-tap-highlight-color: transparent
        }

        /* YACHT & EVENT SECTION STYLES */
        .yacht-sec, .ev-sec { background: var(--parch); }
        .yacht-gallery img, .ev-img-wrap img { width: 100%; height: auto; max-height: 500px; object-fit: cover; border-radius: 24px; }
        .premium-badge { position: absolute; top: 20px; left: 20px; background: linear-gradient(135deg, #d4af37, #b8860b); color: #fff; padding: 0.5rem 1.2rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .stat-item { flex: 1; padding: 1.2rem; background: var(--cream); border: 1px solid rgba(250, 135, 62, 0.15); border-radius: 16px; text-align: center; }
        .stat-item i { font-size: 1.5rem; color: var(--brand); display: block; }
        .stat-label { font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--txt-m); margin-bottom: 0.2rem; }
        .stat-value { font-weight: 700; color: var(--brn-dk); font-size: 0.95rem; }
        
        .ev-feat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 2.5rem; }
        .ev-feat-card { aspect-ratio: 1/1; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 12px; background: #fff; border: 1px solid rgba(250, 135, 62, 0.12); border-radius: 16px; text-align: center; transition: all var(--ease); }
        .ev-feat-card:hover { transform: translateY(-4px); border-color: var(--brand); box-shadow: 0 10px 25px rgba(250, 135, 62, 0.1); }
        .ev-feat-card i { font-size: 1.4rem; color: var(--brand); margin-bottom: 6px; }
        .ev-feat-card span { font-size: 0.6rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--brn-dk); line-height: 1.2; display: block; }

        .price-label { font-size: 0.8rem; color: var(--txt-m); text-transform: uppercase; letter-spacing: 0.1em; display: block; margin-bottom: 0.2rem; }
        .price-value { font-family: 'Cormorant Garamond', serif; font-size: 2.5rem; font-weight: 700; color: var(--brand-d); margin: 0; }
        .p-label { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--txt-l); display: block; margin-bottom: 0.4rem; }
        .p-input { width: 100%; padding: 0.8rem 1rem; background: #fff; border: 1.5px solid rgba(250, 135, 62, 0.15); border-radius: 12px; font-size: 0.9rem; color: var(--txt); transition: all var(--ease); outline: none; }
        .p-input:focus { border-color: var(--brand); box-shadow: 0 0 0 4px rgba(250, 135, 62, 0.1); }

        /* ═══════ ANIMATIONS & REVEALS ═══════ */
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

        .reveal {
            opacity: 1;
            transform: translateY(0);
            transition: opacity .7s ease, transform .7s ease
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0)
        }

        /* ═══════ iOS FIXES ═══════ */
        @supports (-webkit-touch-callout:none) {
            .navbar {
                padding-top: calc(.75rem + var(--safe-t))
            }

            input,
            select,
            textarea {
                font-size: 16px !important
            }
        }

        @media(max-width:575px) {
            footer {
                padding: 52px 0 calc(24px + var(--safe-b))
            }

            footer .row>[class*='col-'] {
                text-align: center
            }

            .footer-social {
                justify-content: center
            }

            .footer-contact {
                margin-top: .2rem
            }

            .footer-contact-item {
                justify-content: center
            }

            .policy-row {
                justify-content: center
            }

            .policy-text {
                flex-basis: 100%
            }

            .f-head {
                margin-bottom: .8rem
            }

            .f-copy {
                line-height: 1.7
            }

            .hero {
                min-height: 88vh
            }

            .cb-win {
                right: .7rem;
                width: calc(100vw - 1.4rem);
                bottom: calc(4.5rem + var(--safe-b))
            }

            .cb-body {
                height: 70vh;
                min-height: 0;
                max-height: none
            }


            .sp-popup {
                left: .8rem;
                max-width: calc(100vw - 5.5rem)
            }

            .prop-footer {
                flex-direction: column
            }

            .prop-footer .btn-brand,
            .prop-footer .btn-outline-brand {
                width: 100%;
                justify-content: center
            }

            .gal-grid {
                grid-template-columns: repeat(2, 1fr);
                grid-auto-rows: 180px;
                gap: 12px;
            }

            .gal-item.wide {
                grid-column: span 2;
            }

            .gal-item.tall {
                grid-row: span 2;
            }

            .amenity-check-grid {
                grid-template-columns: 1fr 1fr
            }
        }

        @media(max-width:767px) {
            .f-brand {
                font-size: 1.55rem
            }

            .f-brand small,
            .f-head {
                letter-spacing: .14em
            }

            .f-links li {
                margin-bottom: .55rem
            }

            .hero-btns .btn-brand,
            .hero-btns .btn-wa,
            .hero-btns .btn-ghost {
                padding: .65rem 1.1rem;
                font-size: .68rem
            }

            .feat-sec,
            .amen-sec,
            .ev-banner,
            .reviews-sec,
            .reels-sec,
            .gallery-sec,
            .about-sec,
            .contact-sec {
                padding: 60px 0
            }
        }

        .nav-link,
        .btn-brand,
        .btn-wa,
        .btn-outline-brand,
        .float-btn {
            min-height: 44px
        }

        /* ═══════ FORM STYLES (LOGIN/REGISTER) ═══════ */
        .auth-container {
            min-height: calc(100vh - 80px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
            overflow: hidden;
        }

        .auth-bg {
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1800&q=85') center/cover no-repeat;
            filter: blur(8px) brightness(0.6);
            transform: scale(1.05);
            z-index: 0;
        }

        .auth-card {
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

        .auth-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .auth-header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--brn-dk);
            line-height: 1.15;
        }

        .auth-header h1 em {
            font-style: italic;
            color: var(--brand);
        }

        .form-group {
            margin-bottom: 1.4rem;
        }

        .form-group label {
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--brand-d);
            display: block;
            margin-bottom: .4rem;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"] {
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

        .form-group input:focus {
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

        .auth-error {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid #dc3545;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            color: #dc3545;
            font-size: 0.85rem;
        }

        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(250, 135, 62, .12);
        }

        .auth-footer p {
            font-size: .8rem;
            color: var(--txt-m);
            margin: 0;
        }

        .auth-footer a {
            color: var(--brand);
            font-weight: 600;
            text-decoration: none;
            transition: color var(--ease);
        }

        .auth-footer a:hover {
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
        .contact-info-card {
            background: var(--parch);
            border: 1px solid rgba(250, 135, 62, 0.15);
            border-radius: var(--r);
            transition: all var(--ease);
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 200px;
        }
        .contact-info-card:hover {
            transform: translateY(-5px);
            border-color: var(--brand);
            box-shadow: var(--sh-m);
        }
        .contact-info-card .ci-icon {
            width: 60px;
            height: 60px;
            background: var(--brand-mist);
            color: var(--brand);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            border: 1px solid rgba(250, 135, 62, 0.2);
        }
        .contact-info-card .ci-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--txt-m);
            font-weight: 700;
        }
        .contact-info-card .ci-value {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--brn-dk);
        }
    </style>
</head>

<body>

    <x-navbar :isHome="true" />

    <!-- ████████████████████ PAGE: HOME ████████████████████ -->
    <div id="page-home" class="page">


        <!-- REEL MODAL -->
        <div class="reel-modal-bg" id="reelModal" onclick="closeReelModal(event)">
            <button class="reel-modal-close" onclick="closeReelModal(true)">&times;</button>
            <div class="reel-modal">
                <div class="reel-modal-body" id="reelContainer">
                    <!-- Dynamic Instagram Embed Injection -->
                </div>
            </div>
        </div>

        <!-- HERO -->
        <section class="hero">
            <div class="hero-bg" style="background-image: url('{{ str_starts_with(\App\Models\Setting::get('home_hero_bg'), 'http') ? \App\Models\Setting::get('home_hero_bg') : asset(\App\Models\Setting::get('home_hero_bg')) }}')"></div>
            <div class="hero-ov"></div>
            <div class="hero-vig"></div>
            <div class="hero-frame"></div>
            <div class="container hero-ct py-5" style="display:flex;align-items:center;justify-content:center;min-height:100%">
                <h1 class="hero-name">{{ \App\Models\Setting::get('home_hero_title', 'Parudeesa') }}</h1>
            </div>
        </section>

        <!-- FEATURED PROPERTIES -->
        <section class="feat-sec">
            <div class="container">
                <div class="text-center mb-5 reveal">
                    <div class="ornament-line"><span>{{ \App\Models\Setting::get('home_prop_subtitle', 'Our Properties') }}</span></div>
                    <span class="eyebrow">{{ \App\Models\Setting::get('home_prop_subtitle', 'Handpicked Retreats') }}</span>
                    <h2 class="sec-title">{!! \App\Models\Setting::get('home_prop_title', 'Two <em>Lakeside</em> Jewels') !!}</h2>
                    <p class="eb mt-2"
                        style="color:var(--txt-m);max-width:480px;margin:0 auto;font-size:1rem;line-height:1.7">
                        {{ \App\Models\Setting::get('home_prop_desc', 'Each property offers unobstructed sunset views, private lake access, and curated experiences.') }}
                    </p>
                </div>
                <div class="row g-4 justify-content-center">
                    @foreach($properties as $property)
                    <div class="col-md-6 reveal">
                        <div class="prop-card">
                            <div class="prop-img">
                                <a class="ig-link" onclick="showIgModal();return false;" title="View on Instagram">
                                    <img src="{{ str_starts_with($property->image, 'http') ? $property->image : asset($property->image) }}"
                                        alt="{{ $property->name }}" loading="lazy" />
                                </a>
                                <div class="prop-img-ov"></div>
                            </div>
                            <div class="prop-body">
                                <h3 class="prop-name">{{ $property->name }}</h3>
                                <div class="prop-pills">
                                    @forelse($property->amenities->take(4) as $amenity)
                                    <span class="pill"><i class="bi bi-stars me-1"></i>{{ $amenity->name }}</span>
                                    @empty
                                    <span class="pill"><i class="bi bi-stars me-1"></i>Sunset lake stay</span>
                                    @endforelse
                                </div>
                                <div class="prop-footer">
                                    <a href="{{ route('property.show', $property) }}" class="btn-brand w-100 justify-content-center"><i class="bi bi-eye"></i> View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- YACHT EXPERIENCE -->
        @if(isset($yachts) && $yachts->count() > 0)
        @foreach($yachts as $yacht)
        <section class="yacht-sec py-5" id="yacht">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-7 reveal">
                        <div class="yacht-gallery position-relative">
                            <img src="{{ str_starts_with($yacht->image, 'http') ? $yacht->image : asset($yacht->image) }}" alt="{{ $yacht->name }}" class="img-fluid rounded-4 shadow-lg">
                            <div class="premium-badge">Premium Experience</div>
                        </div>
                    </div>
                    <div class="col-lg-5 reveal">
                        <div class="ornament-line justify-content-start"><span>Private Charter</span></div>
                        <h2 class="sec-title mb-3">Luxury <em>Yacht</em> Experience</h2>
                        <p class="eb mb-4" style="color:var(--txt-m); font-size:1.05rem; line-height:1.8">
                            {{ $yacht->description }}
                        </p>
                        <div class="yacht-stats d-flex gap-4 mb-4">
                            <div class="stat-item">
                                <i class="bi bi-clock-history mb-2"></i>
                                <div class="stat-label">Duration</div>
                                <div class="stat-value">{{ $yacht->duration }}</div>
                            </div>
                            <div class="stat-item">
                                <i class="bi bi-people mb-2"></i>
                                <div class="stat-label">Capacity</div>
                                <div class="stat-value">Up to {{ $yacht->capacity }} People</div>
                            </div>
                        </div>
                        <div class="yacht-pricing mb-4">
                            <span class="price-label">Starting from</span>
                            <h3 class="price-value">₹{{ number_format($yacht->price, 0) }}</h3>
                        </div>
                        <div class="yacht-actions d-flex gap-3">
                            <button onclick="openYachtBooking({{ $yacht->id }}, '{{ $yacht->name }}', {{ $yacht->price }}, {{ $yacht->capacity }})" class="btn-brand px-4 py-3">Book Yacht Now</button>
                            <a href="#" onclick="goPage('about'); return false;" class="btn-outline-brand px-4 py-3">Enquire Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endforeach
        @endif

        <!-- AMENITIES -->
        <section class="amen-sec">
            <div class="container">
                <div class="text-center mb-5 reveal">
                    <span class="eyebrow" style="color:rgba(255,179,120,.8)">{{ \App\Models\Setting::get('home_amenities_subtitle', 'Experiences') }}</span>
                    <h2 class="sec-title" style="color:var(--brand-pale)">{!! \App\Models\Setting::get('home_amenities_title', 'What <em style="color:var(--brand-l)">Awaits</em> You') !!}</h2>
                </div>
                <div class="row g-4 justify-content-center">
                    @forelse($homeAmenities as $amenity)
                    <div class="col-12 col-md-6 col-lg-4 reveal">
                        <div class="amen-card">
                            <div class="amen-img-box">
                                <img src="{{ asset($amenity->image) }}" alt="{{ $amenity->title }}" loading="lazy">
                            </div>
                            <div class="amen-footer">
                                <h3 class="amen-title">{{ $amenity->title }}</h3>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center text-white-50 py-5">
                        <p class="eb italic">No amenities featured yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- EXPLORE EVENTS BANNER -->
        <!-- EVENTS SECTION REDESIGN -->
        <section class="ev-sec py-5" id="events">
            <div class="container">
                <div class="row align-items-center g-5">
                    <!-- Content Side -->
                    <div class="col-lg-5 reveal">
                        <div class="ornament-line justify-content-start"><span>{{ \App\Models\Setting::get('home_events_subtitle', 'CELEBRATIONS AT PARUDEESA') }}</span></div>
                        <h2 class="sec-title mb-3">{!! \App\Models\Setting::get('home_events_title', 'Make Every Moment <em style="font-style:italic">Unforgettable</em>') !!}</h2>
                        <p class="eb mb-4" style="color:var(--txt-m); font-size:1.05rem; line-height:1.8">
                            {{ \App\Models\Setting::get('home_events_desc', 'Experience the magic of lakeside celebrations. From intimate gatherings to grand events, we provide the perfect backdrop for your most cherished memories.') }}
                        </p>
                        
                        <!-- Compact Feature Cards -->
                        <div class="ev-feat-grid">
                            <div class="ev-feat-card">
                                <i class="bi bi-gift"></i>
                                <span>Premium Party Package</span>
                            </div>
                            <div class="ev-feat-card">
                                <i class="bi bi-stars"></i>
                                <span>Grand Celebration</span>
                            </div>
                            <div class="ev-feat-card">
                                <i class="bi bi-people"></i>
                                <span>200+ Guest Capacity</span>
                            </div>
                            <div class="ev-feat-card">
                                <i class="bi bi-gear-wide-connected"></i>
                                <span>100% Customisable</span>
                            </div>
                        </div>

                        <div class="ev-actions">
                            <a href="{{ route('events') }}" class="btn-brand px-5 py-3" style="display:inline-flex; width:auto;">EXPLORE ALL PACKAGES</a>
                        </div>
                    </div>

                    <!-- Image Side -->
                    <div class="col-lg-7 reveal">
                        <div class="ev-img-wrap position-relative">
                            <img src="{{ str_starts_with(\App\Models\Setting::get('home_events_bg'), 'http') ? \App\Models\Setting::get('home_events_bg') : asset(\App\Models\Setting::get('home_events_bg')) }}" alt="Events at Parudeesa" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- GOOGLE REVIEWS / TESTIMONIALS -->
        @php
            $googleReviewsUrl = 'https://www.google.com/travel/search?q=parudeesa%20resort&g2lb=4965990%2C72471280%2C72560029%2C72573224%2C72647020%2C72686036%2C72803964%2C72882230%2C72958624%2C73059275%2C73064764%2C73249150%2C121529349%2C121608705&hl=en-IN&gl=in&ssta=1&ts=CAEaRwopEicyJTB4M2IwODEzZTEyZmU0OWMzOToweDgxMzcxYzE5NGU1Zjc4NDYSGhIUCgcI6g8QBRgEEgcI6g8QBRgFGAEyAhAA&qs=CAEyFENnc0l4dkQ5OHBTRHg1dUJBUkFCOAJCCQlGeF9OGRw3gUIJCUZ4X04ZHDeB&ap=ugEHcmV2aWV3cw&ictx=111&ved=0CAAQ5JsGahcKEwjI-8rUrZeUAxUAAAAAHQAAAAAQBA';
        @endphp
        <section class="reviews-sec">
            <div class="container">
                <div class="text-center mb-5 reveal">
                    <div class="ornament-line"><span style="color:var(--brand-l)">{{ \App\Models\Setting::get('home_reviews_title', 'What Guests Say') }}</span></div>
                    <span class="eyebrow" style="color:rgba(250,135,62,.8)">{{ \App\Models\Setting::get('home_reviews_subtitle', 'Guest Reviews') }}</span>
                    <h2 class="sec-title" style="color:var(--brand-pale)">{!! \App\Models\Setting::get('home_reviews_title', 'Memories <em>Made Here</em>') !!}</h2>
                    <a href="{{ $googleReviewsUrl }}" target="_blank" rel="noopener noreferrer" class="google-badge mt-3"
                        aria-label="Open Parudeesa Resort Google Travel reviews">
                        <svg width="16" height="16" viewBox="0 0 48 48">
                            <path fill="#EA4335"
                                d="M24 9.5c3.5 0 6.3 1.2 8.4 3.2l6.3-6.3C34.6 2.7 29.7.5 24 .5 14.6.5 6.7 6.1 3 14.1l7.4 5.7C12.1 13 17.6 9.5 24 9.5z" />
                            <path fill="#4285F4"
                                d="M46.5 24.5c0-1.6-.1-3.1-.4-4.5H24v8.5h12.7c-.6 3-2.3 5.5-4.8 7.2l7.4 5.7c4.3-4 6.8-9.9 7.2-16.9z" />
                            <path fill="#FBBC05"
                                d="M10.4 28.2C9.8 26.6 9.5 24.8 9.5 23s.3-3.6.9-5.2L3 12.1C1.1 15.8 0 19.8 0 23s1.1 7.2 3 10.9l7.4-5.7z" />
                            <path fill="#34A853"
                                d="M24 45.5c5.7 0 10.5-1.9 14-5.1l-7.4-5.7c-1.9 1.3-4.4 2.1-6.6 2.1-6.4 0-11.9-3.5-13.6-9.8l-7.4 5.7C6.7 40.9 14.6 45.5 24 45.5z" />
                        </svg>
                        {{ \App\Models\Setting::get('home_reviews_badge', '5.0 - Google Reviews - 200+ Happy Guests') }}
                    </a>
                </div>

                <!-- Elfsight Google Reviews Widget -->
                <div class="reveal">
                    <script src="https://elfsightcdn.com/platform.js" async></script>
                    <div class="elfsight-app-46a181e2-db8d-40e4-96c0-1c2e66b1049f" data-elfsight-app-lazy></div>
                </div>
            </div>
        </section>

        <!-- INSTAGRAM REELS -->
        <section class="reels-sec">
            <div class="container">
                <div class="text-center mb-5 reveal">
                    <span class="eyebrow">Follow Our Story</span>
                    <h2 class="sec-title">Instagram <em>Reels</em></h2>
                    <p style="color:var(--txt-m);font-size:.82rem;margin-top:.5rem">@parudeesa_utopiya &
                        @Parudeesa_the_paradise</p>
                </div>
                
                <div class="swiper reelsSwiper reveal">
                    <div class="swiper-wrapper">
                        @php
                            $reels = \App\Models\Reel::where('is_active', true)->orderBy('order')->get();
                        @endphp
                        @foreach($reels as $reel)
                            <div class="swiper-slide" style="width: auto;">
                                <a href="javascript:void(0)" onclick="openReel('{{ $reel->instagram_url }}')">
                                    <div class="reel-card">
                                        @if($reel->video)
                                            <video src="{{ asset('storage/' . $reel->video) }}" 
                                                   poster="{{ asset('storage/' . $reel->thumbnail) }}"
                                                   autoplay muted loop playsinline
                                                   style="width:100%; height:100%; object-fit: cover; position:absolute; top:0; left:0;"></video>
                                        @else
                                            <img src="{{ $reel->thumbnail ? asset('storage/' . $reel->thumbnail) : 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&q=80' }}" alt="{{ $reel->title }}" loading="lazy" />
                                        @endif
                                        
                                        <div class="reel-ov">
                                            <span class="reel-label">{{ $reel->title }}</span>
                                            @if($reel->description)
                                                <p style="font-size: 0.7rem; opacity: 0.8; margin-top: 4px;">{{ $reel->description }}</p>
                                            @endif
                                        </div>
                                        <div class="reel-play pulse-animation"><i class="bi bi-play-fill"></i></div>
                                    </div>
                                </a>
                            </div>
                    @endforeach
                </div>
            </div>

            @if($reels->count() == 0)
                <p class="text-center italic text-gray-400">No reels featured yet.</p>
            @endif
                <div class="text-center mt-4 reveal">
                    <a href="https://www.instagram.com/Parudeesa_the_paradise" target="_blank" class="btn-brand"
                        style="background:linear-gradient(135deg,#f09433,#dc2743,#bc1888)">
                        <i class="bi bi-instagram me-1"></i> Follow @parudeesa_utopiya & @Parudeesa_the_paradise
                    </a>
                </div>
            </div>
        </section>

    </div><!-- /page-home -->


    <!-- ████████████████████ PAGE: GALLERY ████████████████████ -->
    <div id="page-gallery" class="page">
        <div class="page-hero">
            <div class="ph-bg"
                style="background-image:url('https://images.unsplash.com/photo-1439066615861-d1af74d74000?w=1400&q=80')">
            </div>
            <div class="ph-ov"></div>
            <div class="ph-ct">
                <span class="eyebrow" style="color:rgba(255,243,236,.65)">Visual Escapes</span>
                <h1 class="ph-title">Our <em>Gallery</em></h1>
                <div class="bc"><span onclick="goPage('home')">Home</span> / Gallery</div>
            </div>
        </div>
        <section class="gallery-sec">
            <div class="container">
                <div class="text-center mb-5 reveal">
                    <div class="ornament-line"><span>Life at Parudeesa</span></div>
                    <h2 class="sec-title">Through the <em>Lens</em></h2>
                </div>
                <!-- Filter buttons -->
                <div class="gal-filter reveal">
                    <button class="gal-btn active" onclick="filterGal(this,'all')">All</button>
                    <button class="gal-btn" onclick="filterGal(this,'property')">Properties</button>
                    <button class="gal-btn" onclick="filterGal(this,'lake')">Lake & Nature</button>
                    <button class="gal-btn" onclick="filterGal(this,'events')">Events</button>
                    <button class="gal-btn" onclick="filterGal(this,'food')">Dining</button>
                </div>
                <div class="gal-grid reveal" id="galGrid">
                    @forelse($galleries as $item)
                        <div class="gal-item {{ $item->layout === 'wide' ? 'wide' : ($item->layout === 'tall' ? 'tall' : '') }}" data-cat="{{ strtolower($item->category ?? 'all') }}">
                            @if($item->type === 'image')
                                <img src="{{ $item->url }}" alt="{{ $item->title ?? 'Gallery Image' }}" loading="lazy" />
                            @else
                                <video src="{{ $item->url }}" controls loading="lazy" style="width:100%; height:100%; object-fit:cover; border-radius: inherit;"></video>
                            @endif
                            @if($item->title)
                                <div class="gal-info">
                                    <span>{{ $item->title }}</span>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="eb italic">Capturing memories... Check back soon!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div><!-- /page-gallery -->

    <!-- ████████████████████ PAGE: ABOUT US ████████████████████ -->
    <div id="page-about" class="page">
        <div class="page-hero">
            <div class="ph-bg"
                style="background-image:url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1400&q=80')">
            </div>
            <div class="ph-ov"></div>
            <div class="ph-ct">
                <span class="eyebrow" style="color:rgba(255,243,236,.65)">Our Story</span>
                <h1 class="ph-title">About <em>Parudeesa</em></h1>
                <div class="bc"><span onclick="goPage('home')">Home</span> / About Us</div>
            </div>
        </div>
        <section class="about-sec">
            <div class="container">
                <!-- Story -->
                <div class="row g-5 align-items-center mb-5">
                    <div class="col-lg-6 reveal">
                        <div class="about-img-wrap">
                            <img src="{{ str_starts_with(\App\Models\Setting::get('home_about_image'), 'http') ? \App\Models\Setting::get('home_about_image') : asset(\App\Models\Setting::get('home_about_image')) }}"
                                alt="Parudeesa resort view" loading="lazy" />
                            <div class="about-badge">
                                <div class="num">{{ \App\Models\Setting::get('home_about_badge_number', '5+') }}</div>
                                <div class="lbl">{{ \App\Models\Setting::get('home_about_badge_text', 'Years of Experiences') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 reveal">
                        <span class="eyebrow">Our Story</span>
                        <h2 class="sec-title mb-3">{!! \App\Models\Setting::get('home_about_title', 'Born from a Love of <em>Kerala\'s Waters</em>') !!}</h2>
                        <p class="eb"
                            style="font-size:1.05rem;color:var(--txt-m);line-height:1.85;margin-bottom:1.2rem">{{ \App\Models\Setting::get('home_about_description', 'Parudeesa — meaning "paradise" — was born from a deep love of Kerala\'s serene backwaters and a vision to share that peace with the world.') }}</p>
                        <p class="eb" style="font-size:1.05rem;color:var(--txt-m);line-height:1.85;margin-bottom:2rem">
                            {{ \App\Models\Setting::get('home_about_description_2', 'From intimate couples\' retreats to grand 200-person celebrations, every experience at Parudeesa is crafted with warmth, care, and an eye for an eye for the extraordinary. We don\'t just host events — we create lifelong memories.') }}
                        </p>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="#about-contact" onclick="document.getElementById('about-contact').scrollIntoView({behavior:'smooth'}); return false;" class="btn-brand" style="cursor:pointer"><i
                                    class="bi bi-telephone"></i>
                                Get in Touch</a>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="row g-3 mb-5 reveal">
                    <div class="col-6 col-md-3">
                        <div class="stat-box">
                            <div class="n">2</div>
                            <div class="l">Properties</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-box">
                            <div class="n">200+</div>
                            <div class="l">Events Hosted</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-box">
                            <div class="n">1000+</div>
                            <div class="l">Happy Guests</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-box">
                            <div class="n">4.9★</div>
                            <div class="l">Google Rating</div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div id="about-contact" class="mb-5 pb-5 reveal">
                    <div class="text-center mb-5">
                        <div class="ornament-line"><span>Connect With Us</span></div>
                        <h2 class="sec-title">Contact <em>Information</em></h2>
                    </div>
                    <div class="row g-4 justify-content-center">
                        <!-- Phone -->
                        <div class="col-12 col-md-4">
                            <div class="contact-info-card text-center p-4">
                                <div class="ci-icon mb-3"><i class="bi bi-telephone"></i></div>
                                <h4 class="ci-label mb-2">Phone</h4>
                                <a href="tel:{{ \App\Models\Setting::get('contact_phone', '+91 89210 21202') }}" class="ci-value text-decoration-none">{{ \App\Models\Setting::get('contact_phone', '+91 89210 21202') }}</a>
                            </div>
                        </div>
                        <!-- WhatsApp -->
                        <div class="col-12 col-md-4">
                            <div class="contact-info-card text-center p-4" style="border-color: rgba(37, 211, 102, 0.3);">
                                <div class="ci-icon mb-3" style="background: rgba(37, 211, 102, 0.1); color: #25D366;"><i class="bi bi-whatsapp"></i></div>
                                <h4 class="ci-label mb-2">WhatsApp</h4>
                                <a href="https://wa.me/{{ str_replace(['+', ' '], '', \App\Models\Setting::get('contact_phone', '918921021202')) }}" target="_blank" class="ci-value text-decoration-none" style="color:var(--brn-dk); font-weight: 600;">Message Us</a>
                            </div>
                        </div>
                        <!-- Email -->
                        <div class="col-12 col-md-4">
                            <div class="contact-info-card text-center p-4">
                                <div class="ci-icon mb-3"><i class="bi bi-envelope"></i></div>
                                <h4 class="ci-label mb-2">Email</h4>
                                <a href="mailto:{{ \App\Models\Setting::get('contact_email', 'hello@parudeesa.in') }}" class="ci-value text-decoration-none">{{ \App\Models\Setting::get('contact_email', 'hello@parudeesa.in') }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team -->
                <div class="text-center mb-4 reveal">
                    <div class="ornament-line"><span>Our People</span></div>
                    <h2 class="sec-title">Meet the <em>Team</em></h2>
                </div>
                <div class="row g-4 justify-content-center mb-5 pb-5">
                    @foreach(\App\Models\TeamMember::orderBy('order')->get() as $member)
                    <div class="col-6 col-md-4 col-lg-3 reveal">
                        <div class="team-card">
                            <img src="{{ str_starts_with($member->image, 'http') ? $member->image : asset($member->image) }}"
                                class="team-img" alt="{{ $member->name }}" loading="lazy" />
                            <div class="team-body">
                                <div class="team-name">{{ $member->name }}</div>
                                <div class="team-role">{{ $member->role }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Values -->
                <div class="text-center mb-4 reveal">
                    <div class="ornament-line"><span>Our Values</span></div>
                    <h2 class="sec-title">What We <em>Stand For</em></h2>
                </div>
                <div class="row g-4">
                    @foreach(\App\Models\AboutValue::orderBy('order')->get() as $val)
                    <div class="col-md-4 reveal">
                        <div
                            style="background:var(--parch);border:1px solid rgba(250,135,62,.15);border-radius:var(--r);padding:2rem;text-align:center;box-shadow:var(--sh-s); height: 100%;">
                            <div style="font-size:2.5rem;margin-bottom:1rem">{{ $val->icon }}</div>
                            <h4 style="font-size:1.2rem;font-weight:700;color:var(--brn-dk);margin-bottom:.5rem">{{ $val->title }}</h4>
                            <p class="eb" style="font-size:.95rem;color:var(--txt-m);line-height:1.65">{{ $val->description }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div><!-- /page-about -->


    <!-- ████████████████████ PAGE: BOOKING ████████████████████ -->
    <div id="page-booking" class="page">
        <div class="page-hero">
            <div class="ph-bg"></div>
            <div class="ph-ov"></div>
            <div class="ph-ct">
                <span class="eyebrow" style="color:rgba(255,243,236,.65)">Reserve Your Stay</span>
                <h1 class="ph-title">Book Your <em>Stay</em></h1>
                <div class="bc"><span onclick="goPage('home')">Home</span> / Booking</div>
            </div>
        </div>
        <section
            style="padding:70px 0 90px;background:linear-gradient(180deg,var(--brand-pale) 0%,var(--cream-d) 100%)">
            <div class="container">
                <div class="text-center mb-4 reveal">
                    <div class="ornament-line"><span>Choose How to Book</span></div>
                    <div class="bk-tab-row">
                        <button class="bk-tab active" onclick="switchTab('form',this)"><i
                                class="bi bi-card-checklist"></i> Booking
                            Form</button>
                        <button class="bk-tab" onclick="switchTab('wa',this)"><i class="bi bi-whatsapp"></i> Via
                            WhatsApp</button>
                        <button class="bk-tab" onclick="toggleChatbot()"><i class="bi bi-robot"></i> Book via Chatbot</button>
                    </div>
                </div>

                <!-- FORM TAB -->
                <div id="bk-form-tab">
                    <div class="row g-5 align-items-start">
                        <div class="col-lg-7">
                            <div class="rp-form reveal">
                                <div class="ornament-line mb-3"><span>Booking Application</span></div>
                                <h3 style="font-size:1.5rem;font-weight:700;color:var(--brn-dk);margin-bottom:.2rem">
                                    Reserve Your Stay
                                </h3>
                                <p class="eb mb-4" style="color:var(--txt-m);font-size:.95rem">Fill the form · Pay
                                    advance via Razorpay
                                    · Get confirmation on WhatsApp</p>
                                <form id="bookingForm" onsubmit="handleFormSubmit(event)">
                                    <div class="form-group"><label>Select Property <span
                                                style="color:var(--brand)">*</span></label>
                                        <select id="f-prop" required onchange="updateSummary()">
                                            <option value="" data-price="0">Choose property...</option>
                                            @foreach($properties as $property)
                                            <option value="{{ $property->id }}" 
                                                data-name="{{ $property->name }}" 
                                                data-weekday-price="{{ $property->weekday_price }}"
                                                data-weekday-tier2-price="{{ $property->weekday_tier2_price }}"
                                                data-weekend-price="{{ $property->weekend_price }}"
                                            >
                                                {{ $property->name }} — Starting ₹{{ number_format($property->weekday_price, 0) }}/night
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group"><label>Event Type</label>
                                        <select id="f-event" onchange="updatePackages(); updateSummary()">
                                            <option value="">No Event / Regular Stay</option>
                                            <option value="Birthday">Birthday</option>
                                            <option value="Wedding">Wedding</option>
                                            <option value="Corporate">Corporate</option>
                                        </select>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group"><label>Your Name <span
                                                        style="color:var(--brand)">*</span></label><input type="text"
                                                    id="f-name" placeholder="Full name" required /></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"><label>Phone / WhatsApp <span
                                                        style="color:var(--brand)">*</span></label><input type="tel"
                                                    id="f-phone" placeholder="9876543210" required maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" pattern="[0-9]{10}" title="Please enter a 10-digit phone number." /></div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group"><label>Email <span
                                                        style="color:var(--brand)">*</span></label><input type="email"
                                                    id="f-email" placeholder="you@email.com" required /></div>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="form-group"><label>Check-In <span
                                                        style="color:var(--brand)">*</span></label><input type="text"
                                                    id="f-checkin" placeholder="YYYY-MM-DD" required onchange="updateSummary()" /></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group"><label>Check-Out <span
                                                        style="color:var(--brand)">*</span></label><input type="text"
                                                    id="f-checkout" placeholder="YYYY-MM-DD" required onchange="updateSummary()" /></div>
                                        </div>
                                        <div class="col-md-4">
                                                                      @forelse($allAmenities as $amenity)
                                            <div class="amenity-card" style="margin-bottom: 0.6rem; transition: all 0.3s ease; display: flex; flex-direction: column; gap: 0.5rem; border:1px solid rgba(250,135,62,.18); border-radius:14px; padding:1rem;">
                                                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; width: 100%;">
                                                    <label class="amen-check-item" style="margin: 0; padding: 0; border: none; background: transparent; cursor: pointer; display: flex; align-items: flex-start; gap: 0.8rem; flex: 1;">
                                                        <input type="checkbox" class="amenity-selector" name="amenities" data-amenity-id="{{ $amenity->id }}" data-amenity-name="{{ $amenity->name }}" data-amenity-price="{{ $amenity->price }}" data-amenity-type="{{ $amenity->pricing_type }}" value="{{ $amenity->name }}" onchange="updateSummary()" style="width: 1.1rem; height: 1.1rem; accent-color: var(--brand); margin-top: 2px;" />
                                                        <div style="display: flex; flex-direction: column; gap: 2px;">
                                                            <strong style="font-size: 0.9rem; color: var(--text-dark);">{{ $amenity->name }}</strong>
                                                            @if(str_contains(strtolower($amenity->name), 'kayaking') || str_contains(strtolower($amenity->name), 'boating'))
                                                                <span style="font-size: 0.68rem; color: var(--txt-m); opacity: 0.8; font-weight: 500;">
                                                                    &lt;{{ $bookingSettings['water_activity_threshold'] }} Guests: ₹{{ number_format($bookingSettings['water_activity_low_price'], 0) }}/p | {{ $bookingSettings['water_activity_threshold'] }}+ Guests: ₹{{ number_format($bookingSettings['water_activity_high_price'], 0) }}/p
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </label>
                                                    <div style="font-weight: 800; color: var(--brand-d); font-size: 0.95rem;">₹{{ number_format($amenity->price, 0) }}</div>
                                                </div>

                                                @php
                                                    $nameL = strtolower($amenity->name);
                                                    $showPicker = ($amenity->pricing_type === 'per_person') && !str_contains($nameL, 'campfire') && !str_contains($nameL, 'camp fire') && !str_contains($nameL, 'speaker');
                                                @endphp

                                                @if($showPicker)
                                                <div class="amenity-participants" style="display:none; opacity: 0; width: 100%; border-top: 1px dashed rgba(250,135,62,0.15); margin-top: 4px; padding-top: 10px;">
                                                    <div style="display: flex; justify-content: flex-end; align-items: center; gap: 10px;">
                                                        <span style="font-size: 0.7rem; font-weight: 700; color: var(--txt-m); text-transform: uppercase; letter-spacing: 0.05em;">Participants</span>
                                                        <div style="display:flex;align-items:center;gap:.5rem;">
                                                            <button type="button" class="amenity-decrement" style="width:28px;height:28px;border:1px solid rgba(250,135,62,0.2);border-radius:6px;background:#fff3ec;cursor:pointer;font-weight:bold;color:#e06828;font-size:1rem;padding:0;display:flex;align-items:center;justify-content:center;">−</button>
                                                            <input type="number" class="amenity-participants-input" min="1" value="1" disabled style="width:40px;padding:.2rem;border:none;background:transparent;font-size:.9rem;text-align:center;font-weight:700;color:var(--text-dark);" />
                                                            <button type="button" class="amenity-increment" style="width:28px;height:28px;border:1px solid rgba(250,135,62,0.2);border-radius:6px;background:#fa873e;cursor:pointer;font-weight:bold;color:#fff;font-size:1rem;padding:0;display:flex;align-items:center;justify-content:center;">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            @empty
                                            <div style="color:#999;font-size:.95rem">No amenities available</div>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="form-group"><label>Event Package</label>
                                        <select id="f-pkg" onchange="updateSummary()">
                                            <option value="" data-price="0">No package</option>
                                        </select>
                                    </div>
                                    <div class="form-group"><label>Special Requests</label><textarea id="f-notes"
                                            rows="3" placeholder="Dietary needs, décor preferences..."></textarea></div>
                                    <div
                                        style="background:rgba(250,135,62,.06);border:1px solid rgba(250,135,62,.15);border-radius:12px;padding:.9rem 1.1rem;margin-bottom:1.2rem;display:flex;gap:1rem;flex-wrap:wrap;align-items:center">
                                        <span
                                            style="font-size:.65rem;color:var(--txt-m);font-weight:700;letter-spacing:.08em;text-transform:uppercase">Also
                                            reach us:</span>
                                        <a href="https://wa.me/918921021202" target="_blank"
                                            style="display:inline-flex;align-items:center;gap:.3rem;font-size:.72rem;color:#25D366;font-weight:700;text-decoration:none"><i
                                                class="bi bi-whatsapp"></i> Paradise: 89210 21202</a>
                                        <a href="https://wa.me/918075741948" target="_blank"
                                            style="display:inline-flex;align-items:center;gap:.3rem;font-size:.72rem;color:#25D366;font-weight:700;text-decoration:none"><i
                                                class="bi bi-whatsapp"></i> Utopiya: 80757 41948</a>
                                    </div>
                                    <div class="d-flex flex-column gap-2">
                                        <button type="submit" class="btn-brand w-100 justify-content-center"
                                            style="border-radius:10px;padding:1rem;font-size:.88rem"><i
                                                class="bi bi-credit-card me-2"></i>
                                            Book Now</button>
                                    </div>
                                    <p style="font-size:.63rem;color:var(--txt-m);text-align:center;margin-top:.6rem"><i
                                            class="bi bi-lock-fill me-1"></i> Razorpay · UPI · Card · Net Banking ·
                                        Wallets</p>
                                </form>
                                <div id="successMsg"
                                    style="display:none;margin-top:1.2rem;background:#fff;border-left:4px solid var(--brand);padding:1.1rem 1.3rem;border-radius:12px;color:var(--brn-dk);line-height:1.75;font-size:.88rem">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="bk-card reveal mb-4" id="liveSummary">
                                <div class="ornament-line mb-3"><span>Your Booking Summary</span></div>
                                <div class="brow"><span class="bl">Resort</span><span class="bv">Parudeesa</span></div>
                                <div class="brow"><span class="bl">Property</span><span class="bv"
                                        id="sum-prop">—</span></div>
                                <div class="brow"><span class="bl">Check-In</span><span class="bv" id="sum-in">—</span>
                                </div>
                                <div class="brow"><span class="bl">Check-Out</span><span class="bv"
                                        id="sum-out">—</span></div>
                                <div class="brow"><span class="bl">Guests</span><span class="bv"
                                        id="sum-guests">—</span></div>
                                <div class="brow"><span class="bl">Nights</span><span class="bv"
                                        id="sum-nights">—</span></div>
                                <div class="brow"><span class="bl">Package</span><span class="bv"
                                        id="sum-pkg">None</span></div>
                                <div id="sum-amenities-container"></div>
                                <div class="btotal">
                                    <div>
                                        <div class="tl">Est. Total</div>
                                        <div class="tp" id="sum-total">₹ —</div>
                                    </div>
                                    <div style="text-align:right;font-size:.6rem;color:rgba(255,243,236,.5)">Advance:
                                        ₹{{ number_format($bookingSettings['booking_advance_amount'], 0) }}<br />via
                                        Razorpay</div>
                                </div>
                                <div class="wa-box">
                                    <p><i class="bi bi-shield-check me-1"></i><strong>Secured by Razorpay.</strong>
                                        Confirmation on
                                        WhatsApp.</p>
                                </div>
                            </div>
                            <div class="d-flex flex-column gap-3 reveal">
                                <div class="how-step"
                                    style="display:flex;align-items:flex-start;gap:1rem;padding:1.1rem 1.3rem;text-align:left">
                                    <div class="step-n"
                                        style="background:linear-gradient(135deg,var(--brand),var(--brand-d));min-width:42px;width:42px;height:42px;font-size:1.1rem;border-radius:50%">
                                        1</div>
                                    <div>
                                        <div class="step-title" style="font-size:.95rem">Fill the Form</div>
                                        <p class="step-desc" style="font-size:.78rem">Choose property, dates, guests and
                                            amenities.</p>
                                    </div>
                                </div>
                                <div class="how-step"
                                    style="display:flex;align-items:flex-start;gap:1rem;padding:1.1rem 1.3rem;text-align:left">
                                    <div class="step-n"
                                        style="background:linear-gradient(135deg,#fa873e,#d96520);min-width:42px;width:42px;height:42px;font-size:1rem;border-radius:50%">
                                        <i class="bi bi-credit-card"></i>
                                    </div>
                                    <div>
                                        <div class="step-title" style="font-size:.95rem">Pay ₹{{ number_format($bookingSettings['booking_advance_amount'], 0) }} Advance</div>
                                        <p class="step-desc" style="font-size:.78rem">Secure via Razorpay — UPI, card,
                                            net banking.</p>
                                    </div>
                                </div>
                                <div class="how-step"
                                    style="display:flex;align-items:flex-start;gap:1rem;padding:1.1rem 1.3rem;text-align:left">
                                    <div class="step-n"
                                        style="background:linear-gradient(135deg,#25D366,#128C7E);min-width:42px;width:42px;height:42px;font-size:1rem;border-radius:50%">
                                        <i class="bi bi-whatsapp"></i>
                                    </div>
                                    <div>
                                        <div class="step-title" style="font-size:.95rem">Get Confirmation</div>
                                        <p class="step-desc" style="font-size:.78rem">Instant confirmation + check-in
                                            details on WhatsApp.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- WA TAB -->
                <div id="bk-wa-tab" style="display:none">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="rp-form reveal text-center">
                                <div class="ornament-line mb-3"><span>Book via WhatsApp</span></div>
                                <div style="font-size:3rem;margin-bottom:1rem">💬</div>
                                <h3 style="font-size:1.5rem;font-weight:700;color:var(--brn-dk);margin-bottom:.5rem">
                                    Chat Directly with
                                    Our Team</h3>
                                <p class="eb mb-4" style="color:var(--txt-m);font-size:1rem;line-height:1.75">Tap the
                                    button for your
                                    property. Our team will guide you through dates, guests, packages and payment.</p>
                                <div class="d-flex flex-column gap-3 mb-4">
                                    <a href="https://wa.me/918921021202"
                                        target="_blank" class="btn-wa w-100 justify-content-center"
                                        style="border-radius:12px;padding:1rem;font-size:.9rem"><i
                                            class="bi bi-whatsapp"></i> 🏡 Book
                                        Parudeesa The Paradise (+91 89210 21202)</a>
                                    <a href="https://wa.me/918075741948"
                                        target="_blank" class="btn-wa w-100 justify-content-center"
                                        style="border-radius:12px;padding:1rem;font-size:.9rem"><i
                                            class="bi bi-whatsapp"></i> 🌅 Book
                                        Parudeesa Utopiya (+91 80757 41948)</a>
                                    <a href="https://wa.me/918921021202"
                                        target="_blank" class="btn-brand w-100 justify-content-center"
                                        style="border-radius:12px;padding:1rem;font-size:.9rem"><i
                                            class="bi bi-calendar-event"></i> Enquire
                                        About Event Packages</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div><!-- /page-booking -->

    <!-- ████████ LOGIN PAGE ████████ -->
    <div id="page-login" class="page">
        <div class="page-hero">
            <div class="ph-bg"></div>
            <div class="ph-ov"></div>
            <div class="ph-ct">
                <span class="eyebrow" style="color:rgba(255,243,236,.65)">Welcome Back</span>
                <h1 class="ph-title"><em>Login</em></h1>
                <div class="bc"><span onclick="goPage('home')">Home</span> / Login</div>
            </div>
        </div>
        <section style="padding:70px 0 90px;background:linear-gradient(180deg,var(--brand-pale) 0%,var(--cream-d) 100%)">
            <div class="container d-flex justify-content-center">
                <div class="auth-card">
                    <div class="auth-header">
                        <div class="ornament-line"><span>Welcome Back</span></div>
                        <h1><em>Login</em></h1>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        @if ($errors->any())
                        <div class="auth-error">
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

                        <button type="submit" class="btn-brand w-100" style="margin-bottom: 1rem;">
                            Login
                        </button>

                        <div class="auth-footer">
                            <p>Don't have an account? <a href="#" onclick="goPage('register'); return false;">Register Now</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div><!-- /page-login -->

    <!-- ████████ REGISTER PAGE ████████ -->
    <div id="page-register" class="page">
        <div class="page-hero">
            <div class="ph-bg"></div>
            <div class="ph-ov"></div>
            <div class="ph-ct">
                <span class="eyebrow" style="color:rgba(255,243,236,.65)">Create Account</span>
                <h1 class="ph-title">Join <em>Parudeesa</em></h1>
                <div class="bc"><span onclick="goPage('home')">Home</span> / Register</div>
            </div>
        </div>
        <section style="padding:70px 0 90px;background:linear-gradient(180deg,var(--brand-pale) 0%,var(--cream-d) 100%)">
            <div class="container d-flex justify-content-center">
                <div class="auth-card">
                    <div class="auth-header">
                        <div class="ornament-line"><span>Get Started</span></div>
                        <h1>Create <em>Account</em></h1>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        @if ($errors->any())
                        <div class="auth-error">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" placeholder="Enter your full name" value="{{ old('name') }}" required autofocus autocomplete="name" pattern="[A-Za-z\s]+" title="Name should only contain letters.">
                            @if ($errors->has('name'))
                                <div style="color: #dc3545; font-size: 0.75rem; margin-top: 0.3rem;">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required autocomplete="username">
                            @if ($errors->has('email'))
                                <div style="color: #dc3545; font-size: 0.75rem; margin-top: 0.3rem;">{{ $errors->first('email') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Create a strong password" required autocomplete="new-password">
                            @if ($errors->has('password'))
                                <div style="color: #dc3545; font-size: 0.75rem; margin-top: 0.3rem;">{{ $errors->first('password') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required autocomplete="new-password">
                            @if ($errors->has('password_confirmation'))
                                <div style="color: #dc3545; font-size: 0.75rem; margin-top: 0.3rem;">{{ $errors->first('password_confirmation') }}</div>
                            @endif
                        </div>

                        <button type="submit" class="btn-brand w-100" style="margin-bottom: 1rem;">
                            Create Account
                        </button>

                        <div class="auth-footer">
                            <p>Already have an account? <a href="#" onclick="goPage('login'); return false;">Sign In</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div><!-- /page-register -->




    <!-- SOCIAL PROOF POPUP -->
    <div class="sp-popup" id="spPopup">
        <div class="sp-icon sp-icon-v" id="spIcon">👁️</div>
        <div class="sp-text">
            <strong id="spTitle">124 people viewed this resort</strong>
            <span id="spSub">in the last 1 hour</span>
        </div>
        <span class="sp-close" onclick="closeSpPopup()">✕</span>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        /* ── Page nav ── */
        function goPage(id, skipScroll = false) {
            const targetPage = document.getElementById('page-' + id);
            if (!targetPage) return;

            // Hide all pages, show target page
            document.querySelectorAll('.page').forEach(p => {
                p.classList.remove('active');
            });
            
            targetPage.classList.add('active');
            
            // Remove flash prevention style if it exists
            const fps = document.getElementById('flash-prevent');
            if (fps) fps.remove();
            
            // Scroll to top
            if (!skipScroll) {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
            
            // Update Navbar Active State
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            const activeLink = document.getElementById('nav-link-' + id);
            if (activeLink) activeLink.classList.add('active');
            
            // Close mobile menu if open
            const nc = document.getElementById('nav');
            if (nc && nc.classList.contains('show')) { 
                try { bootstrap.Collapse.getInstance(nc).hide(); } catch (e) { } 
            }

            // Update URL hash without jumping
            if (id !== 'home') {
                history.replaceState(null, null, '#' + id);
            } else {
                history.replaceState(null, null, window.location.pathname);
            }
            
            // Re-init reveals
            setTimeout(initReveals, 80);
        }

        // Removed redundant immediate initialization from bottom

        // Handle browser back/forward buttons
        window.addEventListener('hashchange', function() {
            const hash = window.location.hash.replace('#', '') || 'home';
            goPage(hash);
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Re-check hash on DOMContentLoaded just in case
            const hash = window.location.hash.replace('#', '');
            if (hash && document.getElementById('page-' + hash)) {
                goPage(hash, true);
            }
        });

        /* ── Tab switcher ── */
        function switchTab(tab, btn) {
            document.querySelectorAll('.bk-tab').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('bk-form-tab').style.display = tab === 'form' ? 'block' : 'none';
            document.getElementById('bk-wa-tab').style.display = tab === 'wa' ? 'block' : 'none';
        }

        /* ── Gallery filter ── */
        function filterGal(btn, cat) {
            document.querySelectorAll('.gal-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('.gal-item').forEach(item => {
                const show = cat === 'all' || item.dataset.cat === cat;
                item.style.transition = 'opacity .3s,transform .3s';
                if (show) { item.style.opacity = '1'; item.style.display = 'block'; item.style.transform = 'scale(1)' }
                else { item.style.opacity = '0'; item.style.transform = 'scale(.95)'; setTimeout(() => { item.style.display = 'none' }, 300) }
            });
        }

        /* ── Dynamic Data Injection ── */
        window.foodPackages = @json($foodPackages);
        window.bookingSettings = @json($bookingSettings);

        const eventPackages = {};

        function updatePackages() {
            const pkgSelect = document.getElementById('f-pkg');
            if (!pkgSelect) return;
            pkgSelect.innerHTML = '<option value="" data-price="0" data-name="No package">No package</option>';
            
            window.foodPackages.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.id;
                opt.setAttribute('data-price', p.price);
                opt.setAttribute('data-name', p.name);
                opt.textContent = `${p.name} — ₹${parseFloat(p.price).toLocaleString('en-IN')}/person/night`;
                pkgSelect.appendChild(opt);
            });
        }

        /* ── Amenity participant handling ── */
        function initializeAmenityListeners() {
            document.querySelectorAll('.amenity-selector').forEach((checkbox) => {
                checkbox.addEventListener('change', () => {
                    const amenityItem = checkbox.closest('.amen-check-item');
                    const participantsRow = amenityItem?.querySelector('.amenity-participants');
                    const participantsInput = amenityItem?.querySelector('.amenity-participants-input');

                    if (participantsRow) {
                        participantsRow.style.display = checkbox.checked ? 'block' : 'none';
                        participantsInput.disabled = !checkbox.checked;
                        if (checkbox.checked) {
                            syncAmenityParticipantLimits();
                        }
                    }
                    updateSummary();
                });
            });

            document.querySelectorAll('.amenity-participants-input').forEach((input) => {
                input.addEventListener('input', () => {
                    if (input.value < 1) {
                        input.value = 1;
                    }
                    syncAmenityParticipantLimits();
                    updateSummary();
                });
            });

            const guestInput = document.getElementById('f-guests');
            if (guestInput) {
                guestInput.addEventListener('input', () => {
                    syncAmenityParticipantLimits();
                    updateSummary();
                });
            }
        }

        function syncAmenityParticipantLimits() {
            const guestCount = Math.max(1, parseInt(document.getElementById('f-guests')?.value) || 1);
            document.querySelectorAll('.amenity-participants-input').forEach((input) => {
                const amenityItem = input.closest('.amen-check-item');
                const amenityName = (amenityItem?.querySelector('.amenity-selector')?.dataset.amenityName || '').toLowerCase();
                const isYacht = amenityName.includes('yacht');
                
                const limit = isYacht ? Math.min(guestCount, 10) : guestCount;
                input.max = limit;
                if (parseInt(input.value || '1') > limit) {
                    input.value = limit;
                }
            });
        }

        /* ── Live booking summary ── */
        function updateSummary() {
            const propSelect = document.getElementById('f-prop');
            const propOpt = propSelect.options[propSelect.selectedIndex];
            if (!propOpt || !propOpt.value) return;

            const propName = propOpt.getAttribute('data-name');
            const weekdayPrice = parseFloat(propOpt.getAttribute('data-weekday-price')) || 0;
            const weekdayTier2Price = parseFloat(propOpt.getAttribute('data-weekday-tier2-price')) || weekdayPrice;
            const weekendPrice = parseFloat(propOpt.getAttribute('data-weekend-price')) || 0;
            
            const ci = (document.getElementById('f-checkin') || {}).value || '';
            const co = (document.getElementById('f-checkout') || {}).value || '';
            let guests = parseInt((document.getElementById('f-guests') || {}).value) || 0;
            
            const pkgSelect = document.getElementById('f-pkg');
            const pkgOpt = pkgSelect ? pkgSelect.options[pkgSelect.selectedIndex] : null;
            const pkgName = pkgOpt ? pkgOpt.getAttribute('data-name') || 'None' : 'None';
            const pkgPrice = pkgOpt ? parseFloat(pkgOpt.getAttribute('data-price')) || 0 : 0;
            
            const el = id => document.getElementById(id);
            if (!el('sum-prop')) return;

            el('sum-prop').textContent = propName;
            el('sum-in').textContent = ci ? new Date(ci + 'T00:00').toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' }) : '—';
            el('sum-out').textContent = co ? new Date(co + 'T00:00').toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' }) : '—';
            el('sum-guests').textContent = guests ? guests + ' Guests' : '—';
            
            let n = 0; 
            let stayTotal = 0;
            if (ci && co) { 
                const start = new Date(ci + 'T00:00');
                const end = new Date(co + 'T00:00');
                n = (end - start) / 86400000;
                n = n > 0 ? n : 0;
                
                // Calculate daily stay total
                if (n > 0) {
                    for (let i = 0; i < n; i++) {
                        let curr = new Date(start);
                        curr.setDate(curr.getDate() + i);
                        let day = curr.getDay(); // 0 is Sun
                        let isWeekend = [5, 6, 0].includes(day); // Fri, Sat, Sun
                        let dailyBase = 0;
                        const stayThreshold = window.bookingSettings.property_stay_threshold || 5;
                        if (guests <= stayThreshold) {
                            dailyBase = isWeekend ? weekendPrice : weekdayPrice;
                        } else {
                            dailyBase = isWeekend ? weekendPrice : weekdayTier2Price;
                        }
                        stayTotal += dailyBase;
                    }
                }
            }

            const pkgTotal = pkgPrice * guests * n;
            el('sum-pkg').textContent = pkgName !== 'No package' ? pkgName + ' (₹' + pkgTotal.toLocaleString('en-IN') + ')' : 'None';
            el('sum-nights').textContent = n ? n + (n === 1 ? ' Night' : ' Nights') : '—';
            
            // Calculate Amenities from data attributes
            let amenitiesTotal = 0;
            const checkedAmenities = Array.from(document.querySelectorAll('input[name="amenities"]:checked'));
            let amenityHtml = '';
            
            checkedAmenities.forEach(cb => {
                const name = cb.getAttribute('data-amenity-name') || cb.value;
                let price = parseFloat(cb.getAttribute('data-amenity-price')) || 0;
                const pricingType = cb.getAttribute('data-amenity-type') || 'fixed';
                
                let cost = price;
                let participants = 1;
                
                if (pricingType === 'per_person') {
                    const amenityItem = cb.closest('.amen-check-item');
                    const participantsInput = amenityItem?.querySelector('.amenity-participants-input');
                    participants = participantsInput ? parseInt(participantsInput.value) || 1 : 1;
                    
                    // Tiered Water Activity check (Unified)
                    const aName = name.toLowerCase();
                    if (aName.includes('kayaking') || aName.includes('boating')) {
                        const threshold = window.bookingSettings.water_activity_threshold || 5;
                        const lowPrice = window.bookingSettings.water_activity_low_price || 1000;
                        const highPrice = window.bookingSettings.water_activity_high_price || 700;
                        price = (participants < threshold) ? lowPrice : highPrice;
                    }
                    
                    cost = price * participants;
                }
                
                amenitiesTotal += cost;
                if (pricingType === 'per_person') {
                    amenityHtml += `<div class="brow"><span class="bl">${name} (${participants} × ₹${price.toFixed(2)})</span><span class="bv">₹${cost.toLocaleString('en-IN')}</span></div>`;
                } else {
                    amenityHtml += `<div class="brow"><span class="bl">${name}</span><span class="bv">₹${cost.toLocaleString('en-IN')}</span></div>`;
                }
            });
            
            el('sum-amenities-container').innerHTML = amenityHtml;
            
            const tot = stayTotal + pkgTotal + amenitiesTotal;
            el('sum-total').textContent = tot > 0 ? '₹' + tot.toLocaleString('en-IN') : '₹ —';
            return tot;
        }

        /* ── Form submit ── */
        function buildAmenityPayload() {
            const amenities = [];
            document.querySelectorAll('input[name="amenities"]:checked').forEach((checkbox) => {
                const amenityId = checkbox.getAttribute('data-amenity-id');
                const name = checkbox.getAttribute('data-amenity-name') || checkbox.value;
                const price = parseFloat(checkbox.getAttribute('data-amenity-price')) || 0;
                const pricingType = checkbox.getAttribute('data-amenity-type') || 'fixed';
                const amenityItem = checkbox.closest('.amen-check-item');
                const participantsInput = amenityItem?.querySelector('.amenity-participants-input');
                const participants = pricingType === 'per_person'
                    ? Math.max(1, parseInt(participantsInput?.value || '1'))
                    : null;
                const total = pricingType === 'per_person' ? price * participants : price;

                amenities.push({
                    id: amenityId,
                    name,
                    pricing_type: pricingType,
                    price,
                    participants,
                    total
                });
            });
            return amenities;
        }

        async function handleFormSubmit(e) {
            e.preventDefault();
            const form = document.getElementById('bookingForm');
            const msgBox = document.getElementById('successMsg');
            const submitBtn = form.querySelector('button[type="submit"]');
            const name = document.getElementById('f-name').value.trim();
            const phone = document.getElementById('f-phone').value.trim();
            const email = document.getElementById('f-email').value.trim();
            const propSelect = document.getElementById('f-prop');
            const propId = propSelect.value;
            const propName = propSelect.options[propSelect.selectedIndex]?.getAttribute('data-name') || '';
            const event = document.getElementById('f-event').value || 'Stay';
            const guests = document.getElementById('f-guests').value;
            const ci = document.getElementById('f-checkin').value;
            const co = document.getElementById('f-checkout').value;
            const pkgSelect = document.getElementById('f-pkg');
            const pkgName = pkgSelect.options[pkgSelect.selectedIndex]?.getAttribute('data-name') || '';
            const notes = document.getElementById('f-notes').value;
            const amenities = buildAmenityPayload();
            const totalAmount = updateSummary();
            
            if (!name || !phone || !propId || !guests || !ci || !co) { alert('Please fill all required fields.'); return }
            if (submitBtn) { submitBtn.disabled = true; submitBtn.innerText = 'Processing...'; }
            
            try {
                const response = await fetch('/bookings', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: name,
                        email: email,
                        phone: phone,
                        property_id: propId,
                        event_type: event,
                        check_in: ci,
                        check_out: co,
                        guests: guests,
                        package_name: pkgName,
                        notes: notes,
                        amenities: amenities,
                        amount: totalAmount
                    })
                });
                
                const data = await response.json();
                if (!data.success) {
                    throw new Error(data.message || JSON.stringify(data.errors || 'Booking failed'));
                }
                
                msgBox.style.display = 'block';
                msgBox.style.backgroundColor = '#E8F5E9';
                msgBox.style.color = '#2E7D32';
                msgBox.style.border = '1px solid #A5D6A7';
                msgBox.innerHTML = '<strong style="color:var(--brand)">✅ Booking request saved!</strong><br/>Launching secure Razorpay payment...';
                initiatePayment({ name, email, phone, propertyName: propName, amount: Math.round(totalAmount * 100) });
            } catch (err) {
                msgBox.style.display = 'block';
                msgBox.style.backgroundColor = '#FFEBEE';
                msgBox.style.color = '#C62828';
                msgBox.style.border = '1px solid #FFCDD2';
                msgBox.innerHTML = '<strong>Error!</strong><br/>' + (err.message || 'Please try again later or contact us for help.');
                console.error(err);
            } finally {
                if (submitBtn) { submitBtn.disabled = false; submitBtn.innerText = 'Book Now'; }
            }
        }


        /* ── Scroll reveal ── */
        function initReveals() {
            if (!('IntersectionObserver' in window)) { document.querySelectorAll('.reveal').forEach(el => el.classList.add('visible')); return }
            const obs = new IntersectionObserver((entries) => {
                entries.forEach((e, i) => { if (e.isIntersecting) { setTimeout(() => e.target.classList.add('visible'), (i % 4) * 100); obs.unobserve(e.target) } });
            }, { threshold: 0.1 });
            document.querySelectorAll('.reveal:not(.visible)').forEach(el => obs.observe(el));
        }
        initReveals();

        /* ── Navbar scroll & BTT ── */
        window.addEventListener('scroll', () => {
            document.getElementById('mainNav').classList.toggle('scrolled', window.scrollY > 50);
        }, { passive: true });


        /* ── Reel Modal ── */
        function openReel(url) {
            const modal = document.getElementById('reelModal');
            const container = document.getElementById('reelContainer');
            
            // Clean URL and prepare embed link
            const cleanUrl = url.split('?')[0];
            
            container.innerHTML = `
                <blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="${cleanUrl}?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">
                    <div style="padding:16px;"> 
                        <a href="${cleanUrl}?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank"> 
                            <div style=" display: flex; flex-direction: row; align-items: center;"> 
                                <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div> 
                                <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;"> 
                                    <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div> 
                                    <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div>
                                </div>
                            </div>
                            <div style="padding: 19% 0;"></div> 
                            <div style="display:block; height:50px; margin:0 auto 12px; width:50px;">
                                <svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-511.000000, -20.000000)" fill="#000000"><g><path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path></g></g></g>
                                </svg>
                            </div>
                            <div style="padding-top: 8px;"> 
                                <div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">View this post on Instagram</div>
                            </div>
                        </a>
                    </div>
                </blockquote>
            `;
            
            modal.classList.add('open');
            
            // Re-process Instagram embeds to render the new blockquote
            if (window.instgrm) {
                window.instgrm.Embeds.process();
            }
        }

        function closeReelModal(e) {
            if (e === true || e.target === document.getElementById('reelModal')) {
                document.getElementById('reelModal').classList.remove('open');
                // Optional: clear container to stop video/audio if playing
                // document.getElementById('reelContainer').innerHTML = '';
            }
        }

        /* ── Social proof popup ── */

        /* ── Social Proof Popups ── */
        const spMsgs = [
            { icon: '👁️', cls: 'sp-icon-v', t: '124 people viewed this resort', s: 'in the last 1 hour' },
            { icon: '🏠', cls: 'sp-icon-b', t: 'Someone from Kochi just booked!', s: 'Parudeesa The Paradise · 2 hrs ago' },
            { icon: '👁️', cls: 'sp-icon-v', t: '89 people are viewing right now', s: "Don't miss out!" },
            { icon: '🎉', cls: 'sp-icon-b', t: 'Party Package just reserved!', s: 'Parudeesa Utopiya · 45 mins ago' },
            { icon: '👁️', cls: 'sp-icon-v', t: '3 bookings made today!', s: 'Limited dates available' },
            { icon: '🏠', cls: 'sp-icon-b', t: 'Someone from Bangalore booked!', s: 'Grand Celebration · 1 hr ago' },
        ];
        let spIdx = 0;
        function showSpPopup() {
            const p = document.getElementById('spPopup'), m = spMsgs[spIdx % spMsgs.length]; spIdx++;
            document.getElementById('spIcon').textContent = m.icon;
            document.getElementById('spIcon').className = 'sp-icon ' + m.cls;
            document.getElementById('spTitle').textContent = m.t;
            document.getElementById('spSub').textContent = m.s;
            p.classList.add('show'); setTimeout(() => p.classList.remove('show'), 5000);
        }
        function closeSpPopup() { document.getElementById('spPopup').classList.remove('show') }
        setTimeout(() => { showSpPopup(); setInterval(() => { setTimeout(showSpPopup, (Math.random() * 60 + 120) * 1000) }, 150000) }, 8000);

        /* ── Razorpay ── */
        function initiatePayment(data = {}) {
            const name = data.name || (document.getElementById('f-name') || {}).value?.trim() || '';
            const phone = data.phone || (document.getElementById('f-phone') || {}).value?.trim() || '';
            const email = data.email || (document.getElementById('f-email') || {}).value?.trim() || '';
            const property = data.propertyName || 'Parudeesa';
            const amount = data.amount || 500000;
            const msgBox = document.getElementById('successMsg');
            const opts = {
                key: '{{ config("services.razorpay.key") }}', // Use Laravel config for Razorpay key
                amount: amount, currency: 'INR',
                name: 'Parudeesa – The Lake View Resort',
                description: 'Booking Advance — ' + property,
                image: 'https://images.unsplash.com/photo-1610641818989-c2051b5e2cfd?w=100&q=80',
                handler: function (res) {
                    msgBox.style.display = 'block';
                    msgBox.style.backgroundColor = '#E8F5E9';
                    msgBox.style.color = '#2E7D32';
                    msgBox.style.border = '1px solid #A5D6A7';
                    msgBox.innerHTML = '<strong>✅ Payment successful!</strong><br/>Payment ID: ' + res.razorpay_payment_id + '<br/>Your booking is confirmed. Our team will connect with you shortly.';
                    document.getElementById('bookingForm')?.reset();
                    updateSummary();
                },
                prefill: { name, email, contact: phone }, theme: { color: '#fa873e' }, modal: { ondismiss: () => {
                    msgBox.style.display = 'block';
                    msgBox.style.backgroundColor = '#FFEBEE';
                    msgBox.style.color = '#C62828';
                    msgBox.style.border = '1px solid #FFCDD2';
                    msgBox.innerHTML = '<strong>Payment not completed.</strong><br/>Please retry or contact us for help.';
                } }
            };
            try { new Razorpay(opts).open() }
            catch (e) {
                msgBox.style.display = 'block';
                msgBox.style.backgroundColor = '#FFEBEE';
                msgBox.style.color = '#C62828';
                msgBox.style.border = '1px solid #FFCDD2';
                msgBox.innerHTML = '<strong>Error:</strong> Razorpay checkout could not be opened. Please ensure HTTPS or try again.';
            }
        }

        /* ── iOS tap fix ── */
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('a,button,[onclick]').forEach(el => {
                el.style.webkitTapHighlightColor = 'transparent';
                el.style.touchAction = 'manipulation';
            });
            
            // Initialize Flatpickr instances globally so we can update them later
            window.fpCheckin = flatpickr("#f-checkin", { minDate: "today", dateFormat: "Y-m-d", onChange: updateSummary });
            window.fpCheckout = flatpickr("#f-checkout", { minDate: "today", dateFormat: "Y-m-d", onChange: updateSummary });
            
            // Add event listener to the property dropdown
            const propSelect = document.getElementById('f-prop');
            if (propSelect) {
                propSelect.addEventListener('change', async function() {
                    const propertyId = this.value;
                    if (!propertyId) {
                        window.fpCheckin.set("disable", []);
                        window.fpCheckout.set("disable", []);
                        return;
                    }
                    
                    try {
                        const response = await fetch(`/property/${propertyId}/unavailable-dates`);
                        if (response.ok) {
                            const disabledDates = await response.json();
                            window.fpCheckin.set("disable", disabledDates);
                            window.fpCheckout.set("disable", disabledDates);
                        }
                    } catch (error) {
                        console.error("Failed to fetch unavailable dates:", error);
                    }
                });
            }
            initReveals();
        });

        let currentYachtName = '';
        let currentYachtPrice = 0;

        function openYachtBooking(id, name, price, capacity) {
            currentYachtName = name;
            currentYachtPrice = price;
            document.getElementById('yachtIdInput').value = id;
            document.getElementById('yachtTotalPrice').textContent = '₹' + price.toLocaleString();
            
            // Sync capacity to guests input
            const guestsInput = document.getElementById('yachtGuestsInput');
            if (guestsInput) {
                guestsInput.max = capacity || 10;
                if (parseInt(guestsInput.value) > guestsInput.max) {
                    guestsInput.value = guestsInput.max;
                }
            }
            
            // Reset to form step
            backToYachtForm();
            
            const modal = new bootstrap.Modal(document.getElementById('yachtBookingModal'));
            modal.show();
            
            flatpickr("#yachtBookingDate", {
                minDate: "today",
                dateFormat: "Y-m-d",
            });
        }

        function showYachtSummary() {
            const form = document.getElementById('yachtBookingForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Fill summary
            document.getElementById('summYachtName').textContent = currentYachtName;
            document.getElementById('summGuestName').textContent = document.getElementById('yachtNameInput').value;
            document.getElementById('summGuestPhone').textContent = document.getElementById('yachtPhoneInput').value;
            document.getElementById('summBookingDate').textContent = document.getElementById('yachtBookingDate').value;
            document.getElementById('summGuests').textContent = document.getElementById('yachtGuestsInput').value;
            document.getElementById('summTotalAmount').textContent = '₹' + currentYachtPrice.toLocaleString();

            // Toggle views
            document.getElementById('yachtStepForm').style.display = 'none';
            document.getElementById('yachtStepSummary').style.display = 'block';
        }

        function backToYachtForm() {
            document.getElementById('yachtStepForm').style.display = 'block';
            document.getElementById('yachtStepSummary').style.display = 'none';
            document.getElementById('yachtStepPayment').style.display = 'none';
        }

        function togglePayMethod(method) {
            if (method === 'upi') {
                document.getElementById('payDetailsUpi').style.display = 'block';
                document.getElementById('payDetailsBank').style.display = 'none';
            } else {
                document.getElementById('payDetailsUpi').style.display = 'none';
                document.getElementById('payDetailsBank').style.display = 'block';
            }
        }

        function closeYachtModal() {
            bootstrap.Modal.getInstance(document.getElementById('yachtBookingModal')).hide();
        }

        async function submitYachtBooking() {
            const form = document.getElementById('yachtBookingForm');
            const btn = document.getElementById('yachtSubmitBtn');
            const formData = new FormData(form);
            
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
            
            try {
                const response = await fetch('/book-yacht', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Update payment amount
                    document.querySelectorAll('.pay-amount-val').forEach(el => {
                        el.textContent = currentYachtPrice.toLocaleString();
                    });
                    
                    // Switch to Payment step
                    document.getElementById('yachtStepSummary').style.display = 'none';
                    document.getElementById('yachtStepPayment').style.display = 'block';
                    form.reset();
                } else {
                    alert('Error: ' + (result.message || 'Something went wrong'));
                }
            } catch (error) {
                alert('An error occurred. Please try again.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = 'PROCEED TO PAYMENT';
            }
        }
    </script>
    <!-- YACHT BOOKING MODAL -->
    <div class="modal fade" id="yachtBookingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header" style="background: linear-gradient(135deg, #1e0a02 0%, #3e2010 100%); padding: 1.5rem;">
                    <div>
                        <h5 class="modal-title text-white" style="font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-weight: 700;">Book Your Yacht Experience</h5>
                        <p class="text-white-50 mb-0" style="font-size: 0.75rem; letter-spacing: 0.05em; text-transform: uppercase;">Luxury Awaits You</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 bg-white">
                    <!-- Step 1: Booking Form -->
                    <div id="yachtStepForm" class="p-4">
                        <form id="yachtBookingForm">
                            @csrf
                            <input type="hidden" name="yacht_id" id="yachtIdInput">
                            <input type="hidden" name="type" value="yacht">
                            
                            <div class="mb-3">
                                <label class="p-label mb-2"><i class="bi bi-person me-2"></i>Full Name</label>
                                <input type="text" name="name" id="yachtNameInput" class="p-input" placeholder="Enter your name" required style="border-radius: 10px;">
                            </div>
                            
                            <div class="mb-3">
                                <label class="p-label mb-2"><i class="bi bi-telephone me-2"></i>Phone Number</label>
                                <input type="tel" name="phone" id="yachtPhoneInput" class="p-input" placeholder="10-digit mobile number" required pattern="[0-9]{10}" maxlength="10" style="border-radius: 10px;">
                            </div>
                            
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="p-label mb-2"><i class="bi bi-calendar-event me-2"></i>Booking Date</label>
                                    <input type="text" name="booking_date" id="yachtBookingDate" class="p-input" placeholder="Select Date" required style="border-radius: 10px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="p-label mb-2"><i class="bi bi-people me-2"></i>Number of Guests</label>
                                    <input type="number" name="guests" id="yachtGuestsInput" class="p-input" min="1" max="{{ $bookingSettings['yacht_capacity'] ?? 10 }}" value="1" required style="border-radius: 10px;">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="p-label mb-2"><i class="bi bi-chat-left-dots me-2"></i>Special Requests (Optional)</label>
                                <textarea name="special_requests" id="yachtRequestsInput" class="p-input" rows="3" placeholder="Any specific requirements for your cruise..." style="border-radius: 10px;"></textarea>
                            </div>
                            
                            <div class="btotal p-3 rounded-4 mb-4" style="background: rgba(250,135,62,0.05); border: 1px dashed var(--brand); flex-direction: column; align-items: stretch; gap: 0.5rem;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span style="font-size: 0.75rem; font-weight: 700; color: var(--txt-m); text-transform: uppercase; letter-spacing: 0.05em;">Estimated Total</span>
                                    <span id="yachtTotalPrice" style="font-size: 1.5rem; font-weight: 800; color: var(--brand-d);">₹0</span>
                                </div>
                            </div>
                            
                            <button type="button" onclick="showYachtSummary()" class="btn-brand w-100 py-3 rounded-3" style="font-weight: 700; letter-spacing: 0.05em; font-size: 1rem;">REVIEW BOOKING</button>
                        </form>
                    </div>

                    <!-- Step 2: Booking Summary -->
                    <div id="yachtStepSummary" class="p-4" style="display: none;">
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle mb-3" style="width: 60px; height: 60px;">
                                <i class="bi bi-check-lg fs-2"></i>
                            </div>
                            <h4 style="font-family: 'Cormorant Garamond', serif; font-weight: 700;">Booking Summary</h4>
                            <p class="text-muted small">Please review your reservation details</p>
                        </div>

                        <div class="bg-light rounded-4 p-4 mb-4">
                            <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                                <span class="text-muted small">Experience</span>
                                <span class="fw-bold" id="summYachtName">-</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                                <span class="text-muted small">Guest Name</span>
                                <span class="fw-bold" id="summGuestName">-</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                                <span class="text-muted small">Phone</span>
                                <span class="fw-bold" id="summGuestPhone">-</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                                <span class="text-muted small">Booking Date</span>
                                <span class="fw-bold" id="summBookingDate">-</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                                <span class="text-muted small">No. of Guests</span>
                                <span class="fw-bold" id="summGuests">-</span>
                            </div>
                            <div class="d-flex justify-content-between pt-2 mt-2" style="border-top: 2px solid #fff;">
                                <span class="fw-bold" style="color: var(--brand-d);">Total Payable</span>
                                <span class="fw-bold h4 mb-0" style="color: var(--brand-d);" id="summTotalAmount">₹0</span>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <button type="button" onclick="backToYachtForm()" class="btn btn-outline-secondary flex-1 py-3 rounded-3 fw-bold">BACK</button>
                            <button type="button" onclick="submitYachtBooking()" id="yachtSubmitBtn" class="btn-brand flex-fill py-3 rounded-3 fw-bold">PROCEED TO PAYMENT</button>
                        </div>
                    </div>

                    <!-- Step 3: Payment Details -->
                    <div id="yachtStepPayment" class="p-4" style="display: none;">
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 60px; height: 60px;">
                                <i class="bi bi-credit-card fs-2"></i>
                            </div>
                            <h4 style="font-family: 'Cormorant Garamond', serif; font-weight: 700;">Complete Your Payment</h4>
                            <p class="text-muted small">Choose your preferred payment method</p>
                        </div>

                        <div class="payment-options d-flex flex-column gap-3 mb-4">
                            <label class="p-3 border rounded-4 d-flex align-items-center gap-3" style="cursor: pointer; background: #fff; border-color: var(--brand-pale) !important;">
                                <input type="radio" name="pay_method" value="upi" checked onchange="togglePayMethod('upi')">
                                <div class="fs-4 text-primary"><i class="bi bi-qr-code-scan"></i></div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold" style="font-size: 0.9rem;">UPI Payment</div>
                                    <div class="text-muted small">GPay, PhonePe, Paytm</div>
                                </div>
                            </label>
                            
                            <label class="p-3 border rounded-4 d-flex align-items-center gap-3" style="cursor: pointer; background: #fff; border-color: var(--brand-pale) !important;">
                                <input type="radio" name="pay_method" value="bank" onchange="togglePayMethod('bank')">
                                <div class="fs-4 text-primary"><i class="bi bi-bank"></i></div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold" style="font-size: 0.9rem;">Bank Transfer</div>
                                    <div class="text-muted small">NEFT / IMPS</div>
                                </div>
                            </label>
                        </div>

                        <div id="payDetailsUpi" class="bg-light p-3 rounded-3 mb-4 text-center">
                            <div class="mb-2"><img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=upi://pay?pa=parudeesa@upi&pn=Parudeesa%20Resort&cu=INR" alt="QR Code" style="width: 120px; border-radius: 12px; border: 4px solid #fff;"></div>
                            <div class="fw-bold" style="font-size: 0.85rem;">parudeesa@upi</div>
                            <div class="text-muted" style="font-size: 0.7rem;">Scan to pay ₹<span class="pay-amount-val">0</span></div>
                        </div>

                        <div id="payDetailsBank" class="bg-light p-3 rounded-3 mb-4" style="display: none;">
                            <div style="font-size: 0.8rem; line-height: 1.6;">
                                <div class="d-flex justify-content-between mb-1"><strong>Bank:</strong> <span>Federal Bank</span></div>
                                <div class="d-flex justify-content-between mb-1"><strong>Acc Name:</strong> <span>Parudeesa Resorts</span></div>
                                <div class="d-flex justify-content-between mb-1"><strong>Acc No:</strong> <span>12345678901234</span></div>
                                <div class="d-flex justify-content-between"><strong>IFSC:</strong> <span>FDRL0001234</span></div>
                            </div>
                        </div>

                        <div class="alert alert-warning py-2 px-3 rounded-3 mb-4 d-flex gap-2 align-items-center" style="font-size: 0.7rem; border: none; background: rgba(250,135,62,0.1); color: var(--brand-d);">
                            <i class="bi bi-info-circle fs-6"></i> <span>Please share a screenshot of the payment on WhatsApp for instant confirmation.</span>
                        </div>

                        <button type="button" onclick="closeYachtModal()" class="btn-brand w-100 py-3 rounded-3 fw-bold">I HAVE PAID</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer :isHome="true" />
    <script async src="//www.instagram.com/embed.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper(".reelsSwiper", {
                slidesPerView: 2,
                spaceBetween: 12,
                loop: true,
                speed: 1000,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    640: { slidesPerView: 3, spaceBetween: 16 },
                    1024: { slidesPerView: 5, spaceBetween: 20 },
                },
            });
        });
    </script>
    @include('chatbot')
    <x-social-nav />
</body>

</html>
