<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"/>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>{{ $property->name }} – Property Details</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600;1,700&family=EB+Garamond:ital,wght@0,400;0,500;1,400&family=Josefin+Sans:wght@300;400;600&display=swap" rel="stylesheet"/>

@php
    $heroImages = array_filter([
        $property->image_url ?: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1400&q=85',
        'https://images.unsplash.com/photo-1610641818989-c2051b5e2cfd?w=1400&q=85',
        'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1400&q=85',
        'https://images.unsplash.com/photo-1439066615861-d1af74d74000?w=1400&q=85',
        'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=1400&q=85',
        'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=1400&q=85',
    ]);
    $heroMain = $heroImages[0];
    $propertyPrice = $property->price ?: 6500;
    $suitePrice = round($propertyPrice * 1.35);
    $phone = $property->phone ?: '89210 21202';
    $location = $property->location ?: 'Kerala, India';
    $amenities = count($property->amenities) ? $property->amenities : [
        'Private Kayaking',
        'Sunrise Views',
        'Bonfire Area',
        'Free WiFi',
        'Lake View Dining',
        'Free Parking',
    ];
@endphp

<style>
:root {
  --brand:       #fa873e;
  --brand-d:     #e06828;
  --brand-dd:    #c05520;
  --brand-l:     #ffb07a;
  --brand-pale:  #fff3ec;
  --brand-mist:  #fff8f3;
  --cream:       #fff3ec;
  --cream-d:     #fde8d8;
  --parch:       #fff8f3;
  --brn-dk:      #3e2010;
  --brn-md:      #7a4520;
  --brn:         #a0622a;
  --brn-l:       #c8895a;
  --olive:       #7a7040;
  --txt:         #2e1a08;
  --txt-m:       #7a5a3a;
  --txt-l:       #b08060;
  --r:           16px;
  --ease:        .35s cubic-bezier(.4,0,.2,1);
  --sh-s:        0 2px 16px rgba(250,135,62,.1);
  --sh-m:        0 6px 32px rgba(250,135,62,.15);
  --sh-l:        0 20px 64px rgba(250,135,62,.2);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth;-webkit-text-size-adjust:100%}
body{font-family:'Josefin Sans',sans-serif;background:var(--brand-pale);color:var(--txt);overflow-x:hidden;-webkit-font-smoothing:antialiased}
h1,h2,h3,h4,h5{font-family:'Cormorant Garamond',serif}
.eb{font-family:'EB Garamond',serif}
body::after{content:'';position:fixed;inset:0;pointer-events:none;z-index:9990;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='0.015'/%3E%3C/svg%3E")}
.navbar{background:rgba(255,243,236,.92);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border-bottom:1px solid rgba(250,135,62,.15);padding:.85rem 0;position:sticky;top:0;z-index:1050;box-shadow:0 4px 24px rgba(250,135,62,.08)}
.navbar-brand{font-family:'Cormorant Garamond',serif;font-size:1.6rem;font-weight:700;color:var(--brn-dk)!important;letter-spacing:.3px;line-height:1.1}
.navbar-brand small{display:block;font-size:.5rem;font-weight:400;letter-spacing:.25em;text-transform:uppercase;color:var(--brn-l);margin-top:.05rem}
.nav-back{display:inline-flex;align-items:center;gap:.5rem;font-size:.7rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:var(--txt-m);cursor:pointer;transition:color var(--ease);padding:.4rem .9rem;border-radius:50px;border:1.5px solid rgba(250,135,62,.25);background:transparent}
.nav-back:hover{color:var(--brand-d);border-color:var(--brand);background:rgba(250,135,62,.06)}
.prop-nav-badge{display:inline-flex;align-items:center;gap:.45rem;background:var(--brand);color:#fff;border-radius:50px;padding:.32rem .85rem;font-size:.62rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;box-shadow:0 3px 12px rgba(250,135,62,.35)}
.detail-hero{position:relative;height:78vh;min-height:500px;overflow:hidden;border-radius:0 0 32px 32px}
.hero-main-img{width:100%;height:100%;object-fit:cover;transition:transform 8s ease}
.detail-hero:hover .hero-main-img{transform:scale(1.04)}
.hero-gradient{position:absolute;inset:0;background:linear-gradient(to top,rgba(46,26,8,.72) 0%,rgba(62,32,16,.25) 45%,transparent 70%)}
.hero-top-bar{position:absolute;top:1.5rem;left:1.5rem;right:1.5rem;display:flex;align-items:flex-start;justify-content:space-between;z-index:3}
.hero-prop-tag{background:var(--brand);color:#fff;border-radius:50px;padding:.35rem 1rem;font-size:.65rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;box-shadow:0 3px 14px rgba(250,135,62,.45)}
.hero-price-chip{background:rgba(46,26,8,.88);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px);border:1px solid rgba(250,135,62,.35);border-radius:12px;padding:.6rem 1.2rem;text-align:center}
.hero-price-chip .amt{font-family:'Cormorant Garamond',serif;font-size:1.6rem;font-weight:700;color:var(--brand-l);line-height:1;display:block}
.hero-price-chip .per{font-size:.6rem;color:rgba(255,243,236,.65);letter-spacing:.1em}
.hero-bottom-info{position:absolute;bottom:2rem;left:2rem;right:2rem;z-index:3;display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:1rem}
.hero-prop-name{font-family:'Cormorant Garamond',serif;font-size:clamp(2rem,4.5vw,3.5rem);font-weight:700;font-style:italic;color:#fff;text-shadow:0 3px 20px rgba(0,0,0,.4);line-height:1.1}
.hero-meta-chips{display:flex;gap:.6rem;flex-wrap:wrap}
.meta-chip{background:rgba(255,243,236,.15);backdrop-filter:blur(8px);border:1px solid rgba(255,243,236,.3);border-radius:50px;padding:.3rem .85rem;font-size:.65rem;font-weight:600;letter-spacing:.06em;color:#fff;display:flex;align-items:center;gap:.3rem}
.thumb-strip-wrap{background:var(--parch);padding:1.1rem 0;border-bottom:1px solid rgba(250,135,62,.12)}
.thumb-strip{display:flex;gap:10px;overflow-x:auto;padding:0 1.5rem;scrollbar-width:none}
.thumb-strip::-webkit-scrollbar{display:none}
.thumb-item{flex-shrink:0;width:110px;height:74px;border-radius:10px;overflow:hidden;cursor:pointer;border:2.5px solid transparent;transition:border-color var(--ease),transform var(--ease)}
.thumb-item:hover,.thumb-item.active{border-color:var(--brand);transform:scale(1.04)}
.thumb-item img{width:100%;height:100%;object-fit:cover}
.detail-layout{padding:3rem 0 5rem}
.prop-headline{font-size:clamp(1.8rem,3.5vw,2.8rem);font-weight:700;color:var(--brn-dk);line-height:1.15;margin-bottom:.8rem}
.prop-headline em{font-style:italic;color:var(--brand)}
.prop-tagline{font-family:'EB Garamond',serif;font-size:1.1rem;color:var(--txt-m);line-height:1.75;margin-bottom:1.5rem}
.location-row{display:flex;gap:.6rem;flex-wrap:wrap;margin-bottom:1.8rem}
.loc-chip{background:transparent;border:1.5px solid rgba(250,135,62,.28);border-radius:50px;padding:.35rem 1rem;font-size:.68rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--brn-md);display:inline-flex;align-items:center;gap:.35rem;transition:all var(--ease)}
.loc-chip:hover{background:rgba(250,135,62,.08);border-color:var(--brand);color:var(--brand-d)}
.loc-chip i{color:var(--brand);font-size:.75rem}
.retro-divider{display:flex;align-items:center;gap:.8rem;margin:1.8rem 0}
.retro-divider::before,.retro-divider::after{content:'';flex:1;height:1px;background:linear-gradient(90deg,transparent,rgba(250,135,62,.3))}
.retro-divider::after{background:linear-gradient(270deg,transparent,rgba(250,135,62,.3))}
.retro-divider span{font-size:.6rem;letter-spacing:.22em;text-transform:uppercase;color:var(--brand);font-weight:600;white-space:nowrap}
.about-text{font-family:'EB Garamond',serif;font-size:1.05rem;color:var(--txt-m);line-height:1.85;margin-bottom:1.8rem}
.highlights-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:.75rem;margin-bottom:2rem}
.highlight-item{background:var(--parch);border:1px solid rgba(250,135,62,.15);border-radius:12px;padding:1rem 1.1rem;display:flex;align-items:flex-start;gap:.8rem;transition:all var(--ease)}
.highlight-item:hover{border-color:rgba(250,135,62,.35);box-shadow:var(--sh-s);transform:translateY(-2px)}
.hi-icon{width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,rgba(250,135,62,.15),rgba(200,90,40,.1));display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0}
.hi-label{font-size:.72rem;font-weight:700;color:var(--brn-dk);letter-spacing:.04em;line-height:1.3}
.hi-sub{font-size:.65rem;color:var(--txt-l);margin-top:.15rem}
.room-list{display:flex;flex-direction:column;gap:.75rem;margin-bottom:2rem}
.room-item{background:var(--parch);border:1px solid rgba(250,135,62,.15);border-radius:14px;padding:1.1rem 1.3rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.8rem;transition:all var(--ease)}
.room-item:hover{border-color:rgba(250,135,62,.3);box-shadow:var(--sh-s)}
.room-item-left .rname{font-family:'Cormorant Garamond',serif;font-size:1.1rem;font-weight:700;color:var(--brn-dk)}
.room-item-left .rfeat{font-size:.68rem;color:var(--txt-l);margin-top:.15rem;display:flex;gap:.8rem}
.room-item-right .rprice{font-family:'Cormorant Garamond',serif;font-size:1.3rem;font-weight:700;color:var(--brand)}
.room-item-right .rper{font-size:.58rem;color:var(--txt-l);letter-spacing:.08em}
.amenity-badges{display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:2rem}
.amen-badge{background:rgba(250,135,62,.07);border:1px solid rgba(250,135,62,.18);border-radius:50px;padding:.28rem .85rem;font-size:.65rem;font-weight:600;color:var(--brn-md);letter-spacing:.05em;display:flex;align-items:center;gap:.35rem;transition:all var(--ease)}
.amen-badge:hover{background:rgba(250,135,62,.14);border-color:rgba(250,135,62,.35);color:var(--brand-d)}
.booking-sticky{position:sticky;top:100px}
.booking-card{background:var(--parch);border:1px solid rgba(250,135,62,.2);border-radius:22px;overflow:hidden;box-shadow:var(--sh-l)}
.bk-header{background:linear-gradient(135deg,var(--brn-dk),var(--brn-md));padding:1.6rem 1.8rem}
.bk-header-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:.35rem}
.bk-title{font-family:'Cormorant Garamond',serif;font-size:1.4rem;font-weight:700;font-style:italic;color:var(--brand-pale)}
.bk-price-display{text-align:right}
.bk-price-display .p-amt{font-family:'Cormorant Garamond',serif;font-size:1.8rem;font-weight:700;color:var(--brand-l);line-height:1}
.bk-price-display .p-per{font-size:.58rem;color:rgba(255,243,236,.55);letter-spacing:.1em;display:block}
.bk-subtitle{font-size:.65rem;color:rgba(255,243,236,.55);letter-spacing:.1em;text-transform:uppercase}
.bk-tabs{display:flex;border-bottom:1px solid rgba(250,135,62,.15)}
.bk-tab{flex:1;padding:.85rem;font-size:.65rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;background:transparent;border:none;color:var(--txt-m);cursor:pointer;transition:all var(--ease);position:relative}
.bk-tab.active{color:var(--brand)}
.bk-tab.active::after{content:'';position:absolute;bottom:-1px;left:0;right:0;height:2px;background:var(--brand);border-radius:2px 2px 0 0}
.bk-tab-content{display:none;padding:1.5rem 1.6rem 1.8rem}
.bk-tab-content.active{display:block}
.bk-label{font-size:.63rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--brn-md);display:block;margin-bottom:.35rem}
.bk-input,.bk-select,.bk-textarea{width:100%;border:1.5px solid rgba(250,135,62,.22);border-radius:10px;padding:.68rem 1rem;font-family:'Josefin Sans',sans-serif;font-size:.85rem;background:var(--brand-mist);color:var(--txt);outline:none;transition:border-color var(--ease),box-shadow var(--ease);-webkit-appearance:none;appearance:none}
.bk-input:focus,.bk-select:focus,.bk-textarea:focus{border-color:var(--brand);box-shadow:0 0 0 3px rgba(250,135,62,.12);background:#fff}
.bk-textarea{resize:none;min-height:80px}
.bk-input-group{position:relative}
.bk-input-icon{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--brand-l);font-size:.9rem;pointer-events:none}
.bk-input-group .bk-input{padding-left:2.4rem}
.bk-fg{margin-bottom:1rem}
.bk-row{display:grid;grid-template-columns:1fr 1fr;gap:.75rem}
.date-range-box{background:rgba(250,135,62,.05);border:1.5px solid rgba(250,135,62,.2);border-radius:14px;overflow:hidden;margin-bottom:1rem}
.date-range-box .dr-row{display:grid;grid-template-columns:1fr 1px 1fr}
.date-range-box .dr-divider{background:rgba(250,135,62,.2)}
.date-field{padding:.7rem 1rem}
.date-field .df-label{font-size:.58rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--brand-d);display:block;margin-bottom:.2rem}
.date-field input{width:100%;border:none;background:transparent;font-family:'Josefin Sans',sans-serif;font-size:.82rem;color:var(--txt);outline:none;-webkit-appearance:none;cursor:pointer}
.date-field input::-webkit-calendar-picker-indicator{opacity:.4;cursor:pointer}
.price-summary{background:rgba(250,135,62,.05);border:1px solid rgba(250,135,62,.15);border-radius:14px;padding:1.1rem 1.2rem;margin-bottom:1.2rem}
.ps-row{display:flex;justify-content:space-between;font-size:.78rem;color:var(--txt-m);padding:.35rem 0;border-bottom:1px dashed rgba(250,135,62,.15)}
.ps-row:last-child{border-bottom:none}
.ps-row.total{color:var(--brn-dk);font-weight:700;font-size:.88rem;padding-top:.6rem}
.ps-row.total .amt{font-family:'Cormorant Garamond',serif;font-size:1.4rem;color:var(--brand)}
.btn-book-primary{width:100%;padding:.9rem 1.2rem;background:linear-gradient(135deg,var(--brand),var(--brand-d));border:none;border-radius:12px;color:#fff;font-family:'Josefin Sans',sans-serif;font-size:.78rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;cursor:pointer;box-shadow:0 4px 20px rgba(250,135,62,.4);transition:transform var(--ease),box-shadow var(--ease);display:flex;align-items:center;justify-content:center;gap:.5rem;-webkit-tap-highlight-color:transparent;margin-bottom:.75rem}
.btn-book-primary:hover{transform:translateY(-2px);box-shadow:0 8px 30px rgba(250,135,62,.5)}
.btn-wa-book{width:100%;padding:.9rem 1.2rem;background:linear-gradient(135deg,#25D366,#1aa854);border:none;border-radius:12px;color:#fff;font-family:'Josefin Sans',sans-serif;font-size:.78rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;cursor:pointer;box-shadow:0 4px 18px rgba(37,211,102,.32);transition:transform var(--ease);display:flex;align-items:center;justify-content:center;gap:.5rem;text-decoration:none;-webkit-tap-highlight-color:transparent}
.btn-wa-book:hover{color:#fff;transform:translateY(-2px)}
.secure-note{text-align:center;font-size:.62rem;color:var(--txt-l);margin-top:.7rem;display:flex;align-items:center;justify-content:center;gap:.3rem}
.wa-option-list{display:flex;flex-direction:column;gap:.75rem;margin-bottom:1.2rem}
.wa-option-btn{display:flex;align-items:center;gap:1rem;background:var(--brand-mist);border:1.5px solid rgba(250,135,62,.2);border-radius:14px;padding:1rem 1.2rem;cursor:pointer;transition:all var(--ease);text-decoration:none;-webkit-tap-highlight-color:transparent}
.wa-option-btn:hover{border-color:var(--brand);background:rgba(250,135,62,.08);transform:translateX(4px)}
.wa-opt-icon{width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0}
.wa-opt-icon.green{background:rgba(37,211,102,.15);color:#1aa854}
.wa-opt-icon.orange{background:rgba(250,135,62,.15);color:var(--brand)}
.wa-opt-text .t1{font-size:.78rem;font-weight:700;color:var(--brn-dk);display:block}
.wa-opt-text .t2{font-size:.65rem;color:var(--txt-m);margin-top:.1rem}
.wa-opt-arrow{margin-left:auto;color:var(--brand-l);font-size:1rem}
.check-grid{display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-bottom:1rem}
.check-item{display:flex;align-items:center;gap:.6rem;background:var(--brand-mist);border:1.5px solid rgba(250,135,62,.15);border-radius:8px;padding:.5rem .7rem;cursor:pointer;font-size:.72rem;color:var(--txt);transition:all var(--ease);-webkit-tap-highlight-color:transparent;user-select:none;-webkit-user-select:none}
.check-item:hover{border-color:var(--brand);background:rgba(250,135,62,.06)}
.check-item input{display:none}
.check-box{width:18px;height:18px;border-radius:5px;border:1.5px solid rgba(250,135,62,.3);background:transparent;display:flex;align-items:center;justify-content:center;font-size:.7rem;color:transparent;flex-shrink:0;transition:all var(--ease)}
.check-item input:checked~.check-box{background:var(--brand);border-color:var(--brand);color:#fff}
.check-item:has(input:checked){border-color:var(--brand);background:rgba(250,135,62,.07)}
.success-box{display:none;background:rgba(37,211,102,.08);border:1px solid rgba(37,211,102,.25);border-radius:12px;padding:1rem 1.1rem;margin-top:.8rem;font-size:.8rem;color:#1a7a40;line-height:1.65}
.success-box strong{color:#145a30}
.mobile-book-footer{display:none;position:fixed;bottom:0;left:0;right:0;background:var(--parch);border-top:1px solid rgba(250,135,62,.2);padding:.9rem 1.2rem calc(.9rem + env(safe-area-inset-bottom));box-shadow:0 -8px 32px rgba(250,135,62,.15);z-index:900;flex-wrap:wrap;gap:.6rem;align-items:center}
.mf-price{font-family:'Cormorant Garamond',serif;font-size:1.4rem;font-weight:700;color:var(--brand)}
.mf-price small{font-size:.62rem;color:var(--txt-l);font-weight:400;font-family:'Josefin Sans',sans-serif}
@keyframes fadeUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}
.reveal{opacity:0;transform:translateY(22px);transition:opacity .65s ease,transform .65s ease}
.reveal.visible{opacity:1;transform:translateY(0)}
.fade-in{animation:fadeUp .7s ease both}
@media(max-width:991px){.detail-hero{height:55vw;min-height:320px}.booking-sticky{position:static;margin-top:2.5rem}.mobile-book-footer{display:flex}body{padding-bottom:80px}}
@media(max-width:575px){.detail-hero{height:64vw;min-height:260px;border-radius:0 0 20px 20px}.highlights-grid{grid-template-columns:1fr 1fr}.bk-row{grid-template-columns:1fr}.hero-prop-name{font-size:1.6rem}.thumb-item{width:90px;height:62px}}
@supports (-webkit-touch-callout:none){input,select,textarea{font-size:16px!important}}
</style>
</head>
<body>
<nav class="navbar">
  <div class="container d-flex align-items-center justify-content-between">
    <a class="navbar-brand" href="{{ route('home') }}">
      Parudeesa
      <small>The Lake View Resort</small>
    </a>
    <div class="d-flex align-items-center gap-3">
      <span class="prop-nav-badge d-none d-sm-flex">
        <i class="bi bi-house-heart-fill"></i> {{ $property->name }}
      </span>
      <button class="nav-back" onclick="history.back()">
        <i class="bi bi-arrow-left"></i> Back
      </button>
    </div>
  </div>
</nav>

<div class="detail-hero fade-in" id="heroWrap">
  <img src="{{ $heroMain }}" class="hero-main-img" id="heroImg" alt="{{ $property->name }}"/>
  <div class="hero-gradient"></div>
  <div class="hero-top-bar">
    <span class="hero-prop-tag"><i class="bi bi-geo-alt-fill me-1"></i>{{ $property->name }}</span>
    <div class="hero-price-chip">
      <span class="amt">₹{{ number_format($propertyPrice, 0) }}</span>
      <span class="per">/ Night</span>
    </div>
  </div>
  <div class="hero-bottom-info">
    <div>
      <div class="hero-prop-name">{{ $property->name }}</div>
      <div class="hero-meta-chips mt-2">
        <span class="meta-chip"><i class="bi bi-geo-alt"></i>{{ $location }}</span>
        <span class="meta-chip"><i class="bi bi-telephone"></i>{{ $phone }}</span>
        <span class="meta-chip"><i class="bi bi-star-fill"></i>4.9 · 200+ Reviews</span>
      </div>
    </div>
    <a href="https://wa.me/918921021202?text={{ urlencode('Hi! I am interested in ' . $property->name . '.') }}" target="_blank"
       style="display:inline-flex;align-items:center;gap:.5rem;background:#25D366;color:#fff;border-radius:50px;padding:.55rem 1.3rem;font-size:.7rem;font-weight:700;letter-spacing:.08em;text-decoration:none;box-shadow:0 4px 16px rgba(37,211,102,.4)">
      <i class="bi bi-whatsapp"></i>Quick Enquiry
    </a>
  </div>
</div>

<div class="thumb-strip-wrap">
  <div class="thumb-strip" id="thumbStrip">
    @foreach($heroImages as $index => $image)
      <div class="thumb-item {{ $index === 0 ? 'active' : '' }}" onclick="changeHero('{{ $image }}', this)"><img src="{{ $image }}" alt="{{ $property->name }} thumbnail"/></div>
    @endforeach
  </div>
</div>

<section class="detail-layout">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-7">
        <div class="reveal">
          <h1 class="prop-headline">{{ $property->name }}</h1>
          <p class="prop-tagline">{{ $property->description ?: 'Experience nature’s calm with luxury lakeside living and exclusive guest services.' }}</p>
          <div class="location-row">
            <span class="loc-chip"><i class="bi bi-geo-alt"></i>{{ $location }}</span>
            <a href="https://wa.me/918921021202" target="_blank" class="loc-chip" style="text-decoration:none"><i class="bi bi-telephone"></i>{{ $phone }}</a>
            <span class="loc-chip"><i class="bi bi-people"></i>40–50 Guests</span>
          </div>
        </div>

        <div class="retro-divider reveal"><span>About This Property</span></div>
        <p class="about-text reveal">{{ $property->description ?: 'Settle into lakeside elegance, savor private sunrise moments and enjoy every detail curated for a memorable stay.' }}</p>
        <p class="about-text reveal" style="margin-top:-.5rem">Whether you choose Parudeesa The Paradise or Parudeesa Utopiya, each retreat is designed for warmth, leisure and unforgettable evenings by the water.</p>

        <div class="retro-divider reveal"><span>Highlights</span></div>
        <div class="highlights-grid reveal">
          @foreach($amenities as $amenity)
          <div class="highlight-item"><div class="hi-icon">{{ str_contains($amenity, 'Kayak') ? '🚣' : (str_contains($amenity, 'Sunrise') ? '🌅' : (str_contains($amenity, 'Fire') ? '🔥' : (str_contains($amenity, 'WiFi') ? '📶' : (str_contains($amenity, 'Lake') ? '🍽️' : '🅿️')))) }}</div><div><div class="hi-label">{{ $amenity }}</div><div class="hi-sub">{{ 'Enjoy ' . strtolower($amenity) . ' all season long.' }}</div></div></div>
          @endforeach
        </div>

        <div class="retro-divider reveal"><span>Room Types & Rates</span></div>
        <div class="room-list reveal">
          <div class="room-item">
            <div class="room-item-left">
              <div class="rname">Deluxe Room</div>
              <div class="rfeat"><span><i class="bi bi-rulers me-1"></i>280 sq ft</span><span><i class="bi bi-water me-1"></i>Lake View</span><span><i class="bi bi-moon me-1"></i>King Bed</span></div>
            </div>
            <div class="room-item-right text-end">
              <div class="rprice">₹{{ number_format($propertyPrice, 0) }}</div>
              <div class="rper">/ Night</div>
            </div>
          </div>
          <div class="room-item">
            <div class="room-item-left">
              <div class="rname">Family Suite</div>
              <div class="rfeat"><span><i class="bi bi-rulers me-1"></i>380 sq ft</span><span><i class="bi bi-tree me-1"></i>Garden View</span><span><i class="bi bi-door-open me-1"></i>2 Beds + Balcony</span></div>
            </div>
            <div class="room-item-right text-end">
              <div class="rprice">₹{{ number_format($suitePrice, 0) }}</div>
              <div class="rper">/ Night</div>
            </div>
          </div>
        </div>

        <div class="retro-divider reveal"><span>All Amenities</span></div>
        <div class="amenity-badges reveal">
          @foreach($amenities as $amenity)
          <span class="amen-badge">{{ $amenity }}</span>
          @endforeach
        </div>

        <div class="retro-divider reveal"><span>Policies</span></div>
        <div class="reveal" style="background:var(--parch);border:1px solid rgba(250,135,62,.15);border-radius:16px;padding:1.4rem 1.5rem">
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:.8rem">
            <div><div style="font-size:.62rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--brand-d);margin-bottom:.3rem">Check-In</div><div style="font-size:.88rem;font-weight:600;color:var(--brn-dk)">2:00 PM onwards</div></div>
            <div><div style="font-size:.62rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--brand-d);margin-bottom:.3rem">Check-Out</div><div style="font-size:.88rem;font-weight:600;color:var(--brn-dk)">11:00 AM</div></div>
            <div><div style="font-size:.62rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--brand-d);margin-bottom:.3rem">Min. Stay</div><div style="font-size:.88rem;font-weight:600;color:var(--brn-dk)">1 Night</div></div>
            <div><div style="font-size:.62rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--brand-d);margin-bottom:.3rem">Cancellation</div><div style="font-size:.88rem;font-weight:600;color:var(--brn-dk)">48 hrs notice</div></div>
          </div>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="booking-sticky reveal">
          <div class="booking-card">
            <div class="bk-header">
              <div class="bk-header-top">
                <div class="bk-title">Reserve Your Stay</div>
                <div class="bk-price-display">
                  <span class="p-amt">₹{{ number_format($propertyPrice, 0) }}</span>
                  <span class="p-per">/ Night</span>
                </div>
              </div>
              <div class="bk-subtitle">{{ $property->name }} · {{ $location }}</div>
            </div>

            <div class="bk-tabs">
              <button type="button" class="bk-tab active" onclick="switchBkTab('form', this)"><i class="bi bi-card-list me-1"></i>Book Online</button>
              <button type="button" class="bk-tab" onclick="switchBkTab('wa', this)"><i class="bi bi-whatsapp me-1"></i>WhatsApp</button>
            </div>

            <form id="bk-form" action="{{ route('bookings.store') }}" method="POST" class="bk-tab-content active" onsubmit="handleBookingSubmit(event)">
              @csrf
              <input type="hidden" name="property_id" value="{{ $property->id }}" />
              <input type="hidden" name="amount" id="amountField" value="{{ $propertyPrice }}" />
              <input type="hidden" name="package_name" id="packageField" value="Deluxe Room" />

              <div class="date-range-box">
                <div class="dr-row">
                  <div class="date-field">
                    <span class="df-label"><i class="bi bi-calendar-check me-1"></i>Check-In</span>
                    <input type="date" id="f-checkin" name="check_in" onchange="calcPrice()" required />
                  </div>
                  <div class="dr-divider"></div>
                  <div class="date-field">
                    <span class="df-label"><i class="bi bi-calendar-x me-1"></i>Check-Out</span>
                    <input type="date" id="f-checkout" name="check_out" onchange="calcPrice()" required />
                  </div>
                </div>
              </div>

              <div class="bk-row bk-fg">
                <div>
                  <label class="bk-label">Guests</label>
                  <select class="bk-select" id="f-guests" name="guests" onchange="calcPrice()" required>
                    <option value="2">2 Adults</option>
                    <option value="4">4 Adults</option>
                    <option value="6">6 Adults</option>
                    <option value="8">8 Adults</option>
                    <option value="10">10+ Adults</option>
                  </select>
                </div>
                <div>
                  <label class="bk-label">Room Type</label>
                  <select class="bk-select" id="f-room" onchange="calcPrice()" required>
                    <option value="Deluxe Room|{{ $propertyPrice }}">Deluxe Room</option>
                    <option value="Family Suite|{{ $suitePrice }}">Family Suite</option>
                  </select>
                </div>
              </div>

              <div class="bk-fg">
                <label class="bk-label">Full Name</label>
                <div class="bk-input-group">
                  <i class="bi bi-person bk-input-icon"></i>
                  <input type="text" class="bk-input" id="f-name" name="name" placeholder="Your full name" required />
                </div>
              </div>
              <div class="bk-row bk-fg">
                <div>
                  <label class="bk-label">Email</label>
                  <div class="bk-input-group">
                    <i class="bi bi-envelope bk-input-icon"></i>
                    <input type="email" class="bk-input" id="f-email" name="email" placeholder="name@example.com" required />
                  </div>
                </div>
                <div>
                  <label class="bk-label">Phone / WhatsApp</label>
                  <div class="bk-input-group">
                    <i class="bi bi-telephone bk-input-icon"></i>
                    <input type="tel" class="bk-input" id="f-phone" name="phone" placeholder="+91 98765 43210" required />
                  </div>
                </div>
              </div>
              <div class="bk-fg">
                <label class="bk-label">Event Type</label>
                <select class="bk-select" id="f-event" name="event_type">
                  <option>Regular Stay</option>
                  <option>Birthday</option>
                  <option>Anniversary</option>
                  <option>Family Gathering</option>
                  <option>Friends Day Out</option>
                  <option>Other</option>
                </select>
              </div>

              <label class="bk-label" style="margin-bottom:.5rem">Add-Ons (Optional)</label>
              <div class="check-grid bk-fg">
                <label class="check-item"><input type="checkbox" name="amenities[]" value="Kayaking"/><span class="check-box"><i class="bi bi-check"></i></span>🚣 Kayaking</label>
                <label class="check-item"><input type="checkbox" name="amenities[]" value="Yacht Cruise"/><span class="check-box"><i class="bi bi-check"></i></span>⛵ Yacht Cruise</label>
                <label class="check-item"><input type="checkbox" name="amenities[]" value="Gourmet Dining"/><span class="check-box"><i class="bi bi-check"></i></span>🍽️ Gourmet Dining</label>
                <label class="check-item"><input type="checkbox" name="amenities[]" value="Decorations"/><span class="check-box"><i class="bi bi-check"></i></span>🎊 Decorations</label>
                <label class="check-item"><input type="checkbox" name="amenities[]" value="Photography"/><span class="check-box"><i class="bi bi-check"></i></span>📸 Photography</label>
                <label class="check-item"><input type="checkbox" name="amenities[]" value="DJ Setup"/><span class="check-box"><i class="bi bi-check"></i></span>🎵 DJ Setup</label>
              </div>

              <div class="bk-fg">
                <label class="bk-label">Special Requests</label>
                <textarea class="bk-textarea" id="f-notes" name="notes" placeholder="Dietary needs, décor preferences, accessibility..."></textarea>
              </div>

              <div class="price-summary" id="priceSummary">
                <div class="ps-row"><span>Room Rate</span><span id="ps-rate">₹{{ number_format($propertyPrice, 0) }} × 0 nights</span></div>
                <div class="ps-row"><span>Taxes & Fees (5%)</span><span id="ps-tax">₹0</span></div>
                <div class="ps-row total"><span>Total Estimate</span><span class="amt" id="ps-total">₹{{ number_format($propertyPrice, 0) }}</span></div>
              </div>

              <button class="btn-book-primary" type="submit">
                <i class="bi bi-calendar-check"></i> Confirm Booking
              </button>
              <a href="https://wa.me/918921021202?text={{ urlencode('Hi! I want to book ' . $property->name . '.') }}" target="_blank" class="btn-wa-book">
                <i class="bi bi-whatsapp"></i> Or Book via WhatsApp
              </a>
              <div class="secure-note"><i class="bi bi-lock-fill"></i> Secured · Advance via Razorpay · Instant Confirmation</div>
              <div class="success-box" id="successBox"></div>
            </form>

            <div class="bk-tab-content" id="bk-wa">
              <p class="eb" style="font-size:.95rem;color:var(--txt-m);line-height:1.7;margin-bottom:1.2rem">Chat directly with our team on WhatsApp. Select your preferred option below and we'll guide you through the entire booking process.</p>
              <div class="wa-option-list">
                <a href="https://wa.me/918921021202?text={{ urlencode('Hi! I want to book ' . $property->name . '. Please share availability and pricing.') }}" target="_blank" class="wa-option-btn">
                  <div class="wa-opt-icon green"><i class="bi bi-whatsapp"></i></div>
                  <div class="wa-opt-text"><span class="t1">🏡 Book {{ $property->name }}</span><span class="t2">+91 89210 21202 · Tap to open WhatsApp</span></div>
                  <i class="bi bi-arrow-right wa-opt-arrow"></i>
                </a>
                <a href="https://wa.me/918921021202?text={{ urlencode('Hi! I want to enquire about event packages at ' . $property->name . '.') }}" target="_blank" class="wa-option-btn">
                  <div class="wa-opt-icon orange"><i class="bi bi-stars"></i></div>
                  <div class="wa-opt-text"><span class="t1">🎉 Enquire About Events</span><span class="t2">Party, gathering, corporate & more</span></div>
                  <i class="bi bi-arrow-right wa-opt-arrow"></i>
                </a>
                <a href="https://wa.me/918921021202?text={{ urlencode('Hi! I need a custom package at ' . $property->name . '. Can you help?') }}" target="_blank" class="wa-option-btn">
                  <div class="wa-opt-icon orange" style="background:rgba(122,92,110,.12);color:#7a5c6e"><i class="bi bi-magic"></i></div>
                  <div class="wa-opt-text"><span class="t1">✨ Request Custom Package</span><span class="t2">Tailored experience just for you</span></div>
                  <i class="bi bi-arrow-right wa-opt-arrow"></i>
                </a>
              </div>

              <div style="background:rgba(250,135,62,.05);border:1px solid rgba(250,135,62,.15);border-radius:14px;padding:1.1rem 1.2rem">
                <div style="font-size:.62rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--brand);margin-bottom:.7rem">What to mention on WhatsApp</div>
                <div style="display:flex;flex-direction:column;gap:.4rem">
                  <div style="display:flex;gap:.5rem;font-size:.78rem;color:var(--txt-m)"><i class="bi bi-check-circle-fill" style="color:var(--brand);margin-top:2px;flex-shrink:0"></i> Your preferred check-in & check-out dates</div>
                  <div style="display:flex;gap:.5rem;font-size:.78rem;color:var(--txt-m)"><i class="bi bi-check-circle-fill" style="color:var(--brand);margin-top:2px;flex-shrink:0"></i> Number of guests & room preference</div>
                  <div style="display:flex;gap:.5rem;font-size:.78rem;color:var(--txt-m)"><i class="bi bi-check-circle-fill" style="color:var(--brand);margin-top:2px;flex-shrink:0"></i> Event type (if any celebration)</div>
                  <div style="display:flex;gap:.5rem;font-size:.78rem;color:var(--txt-m)"><i class="bi bi-check-circle-fill" style="color:var(--brand);margin-top:2px;flex-shrink:0"></i> Any special add-ons or requests</div>
                </div>
              </div>

              <a href="https://www.instagram.com/Parudeesa_the_paradise" target="_blank" style="display:flex;align-items:center;justify-content:center;gap:.5rem;margin-top:.9rem;background:linear-gradient(135deg,#f09433,#dc2743,#bc1888);color:#fff;border-radius:12px;padding:.8rem;font-size:.72rem;font-weight:700;letter-spacing:.08em;text-decoration:none">
                <i class="bi bi-instagram"></i> Also DM us @Parudeesa_the_paradise
              </a>
            </div>
          </div>
          <div style="display:flex;gap:.5rem;flex-wrap:wrap;justify-content:center;margin-top:1rem">
            <span style="font-size:.62rem;color:var(--txt-l);display:flex;align-items:center;gap:.25rem"><i class="bi bi-shield-check" style="color:var(--brand)"></i>Verified Property</span>
            <span style="font-size:.62rem;color:var(--txt-l)">·</span>
            <span style="font-size:.62rem;color:var(--txt-l);display:flex;align-items:center;gap:.25rem"><i class="bi bi-star-fill" style="color:#f5a623"></i>4.9 Rating</span>
            <span style="font-size:.62rem;color:var(--txt-l)">·</span>
            <span style="font-size:.62rem;color:var(--txt-l);display:flex;align-items:center;gap:.25rem"><i class="bi bi-headset" style="color:var(--brand)"></i>24/7 Support</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="mobile-book-footer">
  <div>
    <div class="mf-price">₹{{ number_format($propertyPrice, 0) }} <small>/ night</small></div>
    <div style="font-size:.62rem;color:var(--txt-l)">{{ $property->name }}</div>
  </div>
  <a href="https://wa.me/918921021202?text={{ urlencode('Hi! I want to book ' . $property->name . '.') }}" target="_blank"
     style="display:inline-flex;align-items:center;gap:.4rem;background:#25D366;color:#fff;border-radius:50px;padding:.6rem 1.2rem;font-size:.72rem;font-weight:700;text-decoration:none;flex-shrink:0">
    <i class="bi bi-whatsapp"></i> Book Now
  </a>
  <button onclick="document.getElementById('bk-form').scrollIntoView({behavior:'smooth'})"
     style="display:inline-flex;align-items:center;gap:.4rem;background:linear-gradient(135deg,var(--brand),var(--brand-d));color:#fff;border:none;border-radius:50px;padding:.6rem 1.2rem;font-size:.72rem;font-weight:700;flex-shrink:0;cursor:pointer">
    <i class="bi bi-calendar-check"></i> Reserve
  </button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function changeHero(url, thumb) {
  const img = document.getElementById('heroImg');
  img.style.opacity = '0';
  img.style.transition = 'opacity .35s ease';
  setTimeout(() => {
    img.src = url;
    img.style.opacity = '1';
  }, 200);
  document.querySelectorAll('.thumb-item').forEach(t => t.classList.remove('active'));
  thumb.classList.add('active');
}
function switchBkTab(tab, btn) {
  document.querySelectorAll('.bk-tab').forEach(b => b.classList.remove('active'));
  document.querySelectorAll('.bk-tab-content').forEach(c => c.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('bk-' + tab).classList.add('active');
}
function calcPrice() {
  const ci = document.getElementById('f-checkin').value;
  const co = document.getElementById('f-checkout').value;
  const room = document.getElementById('f-room').value.split('|');
  const rate = parseInt(room[1] || {{ $propertyPrice }});
  const packageLabel = room[0] || 'Deluxe Room';
  document.getElementById('packageField').value = packageLabel;
  if (!ci || !co) return;
  const nights = Math.max(0, (new Date(co) - new Date(ci)) / 86400000);
  if (nights <= 0) return;
  const base = rate * nights;
  const tax = Math.round(base * 0.05);
  const total = base + tax;
  document.getElementById('ps-rate').textContent = '₹' + rate.toLocaleString('en-IN') + ' × ' + nights + ' night' + (nights > 1 ? 's' : '');
  document.getElementById('ps-tax').textContent = '₹' + tax.toLocaleString('en-IN');
  document.getElementById('ps-total').textContent = '₹' + total.toLocaleString('en-IN');
  document.getElementById('amountField').value = total;
}
function showMessage(html, success = true) {
  const box = document.getElementById('successBox');
  box.style.display = 'block';
  box.style.background = success ? 'rgba(37,211,102,.08)' : 'rgba(250,135,62,.08)';
  box.style.borderColor = success ? 'rgba(37,211,102,.25)' : 'rgba(250,135,62,.25)';
  box.style.color = success ? '#1a7a40' : '#7a4218';
  box.innerHTML = html;
  box.scrollIntoView({behavior:'smooth', block:'nearest'});
}
async function handleBookingSubmit(event) {
  event.preventDefault();
  const form = document.getElementById('bookingForm');
  const data = new FormData(form);
  const payload = {};
  data.forEach((value, key) => {
    if (key === 'amenities[]') {
      payload['amenities'] = payload['amenities'] || [];
      payload['amenities'].push(value);
    } else {
      payload[key] = value;
    }
  });
  const required = ['name','email','phone','check_in','check_out','guests','property_id','amount'];
  for (const field of required) {
    if (!payload[field] || payload[field].toString().trim() === '') {
      alert('Please fill in all required booking details.');
      return;
    }
  }
  try {
    const response = await fetch(form.action, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json'
      },
      body: JSON.stringify(payload)
    });
    const json = await response.json();
    if (json.success) {
      const message = json.calendar_synced ? '✅ Booking confirmed and synced to calendar.' : '⚠️ Booking saved, but calendar sync failed. Our team will resolve it.';
      showMessage(`<strong>${message}</strong><br/>Booking ID: ${json.booking.id}<br/>We will contact you shortly on WhatsApp.`);
      form.reset();
      document.getElementById('ps-rate').textContent = '₹' + {{ number_format($propertyPrice, 0) }} + ' × 0 nights';
      document.getElementById('ps-tax').textContent = '₹0';
      document.getElementById('ps-total').textContent = '₹{{ number_format($propertyPrice, 0) }}';
    } else {
      showMessage('<strong>⚠️ Booking could not be completed. Please try again.</strong>', false);
    }
  } catch (error) {
    showMessage('<strong>⚠️ Booking request failed. Please refresh and try again.</strong>', false);
    console.error(error);
  }
}
const obs = new IntersectionObserver((entries) => {
  entries.forEach((e, i) => {
    if (e.isIntersecting) {
      setTimeout(() => e.target.classList.add('visible'), (i % 3) * 80);
      obs.unobserve(e.target);
    }
  });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
const today = new Date().toISOString().split('T')[0];
document.getElementById('f-checkin').min = today;
document.getElementById('f-checkout').min = today;
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('a,button,[onclick]').forEach(el => {
    el.style.webkitTapHighlightColor = 'transparent';
    el.style.touchAction = 'manipulation';
  });
});
</script>
</body>
</html>
