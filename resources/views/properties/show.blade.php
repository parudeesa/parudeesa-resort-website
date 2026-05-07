<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"/>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>{{ $property->name }} – Luxury Details</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

@php
    $fallbackHeroImages = [
        'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1400&q=85',
        'https://images.unsplash.com/photo-1610641818989-c2051b5e2cfd?w=1400&q=85',
        'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1400&q=85',
        'https://images.unsplash.com/photo-1439066615861-d1af74d74000?w=1400&q=85',
        'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=1400&q=85',
    ];
    $heroImages = collect(array_merge([$property->image_url], $property->gallery_images ?? []))
        ->filter()
        ->values()
        ->all();
    $heroImages = array_slice(count($heroImages) ? $heroImages : $fallbackHeroImages, 0, 5);
    $heroMain = $heroImages[0];
    $propertyPrice = $property->price ?: 8000;
    $phone = $property->phone ?: '89210 21202';
    $location = $property->location ?: 'Kerala, India';
    $defaultHighlights = [
        ['label' => 'Unlimited Pool Access (No Time Limit)', 'icon' => 'bi-droplet-fill'],
        ['label' => 'Private Cottage Experience', 'icon' => 'bi-house-heart-fill'],
        ['label' => 'Scenic Water Activities', 'icon' => 'bi-water'],
        ['label' => 'Event Friendly Property', 'icon' => 'bi-stars'],
    ];
    $highlights = count($property->highlights ?? []) ? $property->highlights : $defaultHighlights;
    $yachtAmenity = $amenities->first(fn ($amenity) => str_contains(strtolower($amenity->name), 'yacht'));
@endphp

<style>
:root {
  --brand: #fa873e;
  --brand-d: #e06828;
  --bg-ivory: #fff8f3;
  --bg-beige: #fff3ec;
  --text-dark: #3b2a22;
  --text-muted: #5a5a5a;
  --gold: #fa873e;
  --gold-light: #fde8d8;
  --orange: #e06828;
  --card-bg: #FFFFFF;
  --shadow-soft: 0 12px 40px rgba(62, 32, 16, 0.06);
  --shadow-hover: 0 20px 50px rgba(62, 32, 16, 0.1);
  --radius-lg: 24px;
  --radius-md: 16px;
  --radius-sm: 10px;
  --ease: 0.4s cubic-bezier(0.25, 1, 0.5, 1);
  --font-serif: 'Playfair Display', serif;
  --font-sans: 'Poppins', sans-serif;
  --font-body: 'Poppins', sans-serif;
}

*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth;-webkit-text-size-adjust:100%}
body{font-family:var(--font-sans);background:var(--bg-ivory);color:var(--text-dark);overflow-x:hidden;-webkit-font-smoothing:antialiased;line-height:1.6}
h1,h2,h3,h4,h5{font-family:var(--font-serif);color:var(--text-dark);line-height:1.2}

/* Navbar */
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
    transition: box-shadow var(--ease), background var(--ease)
}
.navbar.scrolled {
    background: rgba(255, 243, 236, .97);
    box-shadow: 0 6px 36px rgba(250, 135, 62, .18)
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
    color: var(--text-muted) !important;
    padding: .45rem .85rem !important;
    border-radius: 50px;
    transition: all var(--ease);
    cursor: pointer;
    text-decoration: none;
}
.nav-link:hover {
    color: var(--brand-d) !important;
    background: rgba(250, 135, 62, .1)
}
.navbar-toggler {
    border: 1px solid rgba(250, 135, 62, .35);
    border-radius: 8px;
    padding: .3rem .5rem;
    box-shadow: none !important
}
.navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23fa873e' stroke-width='2.2' stroke-linecap='round' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e")
}
.navbar-toggler:focus {
    box-shadow: none
}

/* Hero */
.hero-wrapper{position:relative;height:85vh;min-height:600px;overflow:hidden;border-radius:var(--radius-lg);max-width:1400px;width:calc(100% - 2rem);margin:1.5rem auto 3rem;background:#111;box-shadow:var(--shadow-hover)}
.hero-carousel,.hero-carousel .carousel-inner,.hero-carousel .carousel-item{height:100%}
.hero-img{width:100%;height:100%;object-fit:cover}
.hero-overlay,.hero-content{display:none}
.hero-content{position:absolute;bottom:0;left:0;right:0;padding:4rem 2rem;z-index:10;display:flex;flex-direction:column;align-items:center;text-align:center;color:#fff}
.hero-tagline{font-family:var(--font-sans);font-size:0.8rem;letter-spacing:0.3em;text-transform:uppercase;color:rgba(255,255,255,0.9);margin-bottom:1rem;font-weight:600}
.hero-title{font-family:var(--font-serif);font-size:clamp(1.8rem,3.8vw,2.8rem);font-weight:700;line-height:1.1;margin-bottom:1rem;color:#ffffff!important;text-shadow:0 4px 20px rgba(0,0,0,0.6)}
.hero-location{font-family:var(--font-sans);font-size:1rem;color:rgba(255,255,255,0.9);display:flex;align-items:center;gap:0.5rem;margin-bottom:2rem}
.hero-actions{display:flex;gap:1rem;flex-wrap:wrap;justify-content:center;align-items:center}
.btn-premium{display:inline-flex;align-items:center;gap:0.5rem;padding:1rem 2rem;background:var(--gold);color:#fff;border-radius:50px;font-family:var(--font-sans);font-size:0.9rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;text-decoration:none;transition:all var(--ease);border:none;box-shadow:0 8px 25px rgba(197,160,89,0.3)}
.btn-premium:hover{background:#b8962c;color:#fff;transform:translateY(-3px);box-shadow:0 12px 30px rgba(197,160,89,0.4)}
.btn-outline-premium{display:inline-flex;align-items:center;gap:0.5rem;padding:1rem 2rem;background:rgba(255,255,255,0.1);backdrop-filter:blur(10px);color:#fff;border-radius:50px;font-family:var(--font-sans);font-size:0.9rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;text-decoration:none;transition:all var(--ease);border:1px solid rgba(255,255,255,0.3)}
.btn-outline-premium:hover{background:#25D366;border-color:#25D366;color:#fff;transform:translateY(-3px)}

/* Layout */
.section-title{font-family:var(--font-serif);font-size:1.25rem;font-weight:600;color:var(--text-dark);margin-bottom:1.5rem;display:flex;align-items:center;gap:1rem}
.section-title::after{content:'';flex:1;height:1px;background:linear-gradient(to right,var(--gold-light),transparent)}
.content-section{background:var(--card-bg);border-radius:var(--radius-lg);padding:2.5rem;margin-bottom:2rem;box-shadow:var(--shadow-soft);border:1px solid rgba(197,160,89,0.1)}
.about-text{font-family:var(--font-body);font-size:1rem;color:var(--text-muted);line-height:1.8;text-align:justify}

/* Cards */
.icon-card-grid{display:grid;grid-template-columns:repeat(3, 1fr);gap:1.2rem}
@media(max-width:991px){ .icon-card-grid{grid-template-columns:repeat(2, 1fr)} }
@media(max-width:768px){ .icon-card-grid{grid-template-columns:1fr} }
.icon-card{background:var(--bg-beige);border-radius:var(--radius-md);padding:1.2rem;display:flex;align-items:center;gap:1rem;transition:all var(--ease);border:1px solid transparent}
.icon-card:hover{background:var(--card-bg);transform:translateY(-5px);box-shadow:var(--shadow-hover);border-color:var(--gold-light)}
.ic-icon{width:40px;height:40px;border-radius:10px;background:var(--card-bg);display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:var(--gold);flex-shrink:0;box-shadow:0 4px 15px rgba(0,0,0,0.05)}
.ic-content{flex:1}
.ic-title{font-family:var(--font-sans);font-size:0.95rem;font-weight:600;color:var(--text-dark);margin-bottom:0.1rem}
.ic-desc{font-family:var(--font-sans);font-size:0.8rem;color:var(--text-muted)}

/* Experiences Grid Redesign */
.exp-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}
@media (max-width: 768px) {
    .exp-grid {
        grid-template-columns: 1fr;
    }
}
.exp-card {
    background: var(--card-bg);
    border-radius: var(--radius-md);
    overflow: hidden;
    box-shadow: var(--shadow-soft);
    transition: all var(--ease);
    border: 1px solid rgba(197, 160, 89, 0.1);
    position: relative;
    display: flex;
    flex-direction: column;
    height: 100%;
}
.exp-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
    border-color: var(--gold-light);
}
.exp-img-box {
    position: relative;
    width: 100%;
    padding-top: 56.25%; /* 16:9 ratio */
    overflow: hidden;
}
.exp-img-box img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}
.exp-card:hover .exp-img-box img {
    transform: scale(1.05);
}
.premium-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: linear-gradient(135deg, #d4af37, #b8860b);
    color: #fff;
    padding: 0.35rem 0.9rem;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    z-index: 10;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.exp-body {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    flex: 1;
    text-align: left;
}
.exp-title {
    font-family: var(--font-serif);
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}
.exp-price {
    font-family: var(--font-sans);
    font-size: 1rem;
    font-weight: 700;
    color: var(--gold);
    margin-bottom: 0.25rem;
}
.exp-condition {
    font-family: var(--font-sans);
    font-size: 0.75rem;
    color: var(--text-muted);
    font-style: italic;
    margin-bottom: 1rem;
}
.exp-desc {
    font-family: var(--font-sans);
    font-size: 0.85rem;
    color: var(--text-muted);
    margin-bottom: 1.25rem;
    line-height: 1.6;
    flex: 1;
}
.btn-add-exp {
    align-self: flex-start;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.65rem 1.5rem;
    background: var(--brand);
    color: #fff;
    border: none;
    border-radius: 50px;
    font-family: var(--font-sans);
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all var(--ease);
    box-shadow: 0 4px 15px rgba(250, 135, 62, 0.15);
}
.btn-add-exp:hover {
    background: var(--brand-d);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(250, 135, 62, 0.25);
    color: #fff;
}

/* Highlights Section Redesign */
.highlight-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
    margin-top: 2rem;
}
@media (max-width: 768px) {
    .highlight-grid {
        grid-template-columns: 1fr;
    }
}
.highlight-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(62, 32, 16, 0.05);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(197, 160, 89, 0.08);
}
.highlight-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(62, 32, 16, 0.12);
}
.highlight-img-box {
    position: relative;
    width: 100%;
    padding-top: 56.25%; /* 16:9 Aspect Ratio */
    overflow: hidden;
}
.highlight-img-box img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}
.highlight-card:hover .highlight-img-box img {
    transform: scale(1.05);
}
.highlight-body {
    padding: 1.25rem 1.5rem;
    text-align: center;
}
.highlight-title {
    font-family: var(--font-serif);
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
    line-height: 1.2;
}
.experience-card .ic-icon{width:62px;height:62px;font-size:2rem;border-radius:18px;background:#fff7f1}

/* Premium Exp Card */
.premium-exp-card { border: 2px solid var(--gold); box-shadow: 0 0 20px rgba(250, 135, 62, 0.15); position: relative; }
.premium-exp-card:hover { border-color: var(--gold); box-shadow: 0 0 25px rgba(250, 135, 62, 0.3); transform: translateY(-5px); }
.premium-tag { position: absolute; top: 1rem; right: 1rem; background: linear-gradient(135deg, #fa873e, #e06828); color: #fff; padding: 0.4rem 1rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; z-index: 10; box-shadow: 0 4px 10px rgba(250, 135, 62, 0.3); }

/* Footer */
footer {
    background: linear-gradient(160deg, #1e0a02 0%, #3e2010 100%);
    color: rgba(255, 243, 236, .6);
    padding: 65px 0 30px;
    border-top: 2px solid rgba(250, 135, 62, .2);
    margin-top: 4rem;
}
.f-brand {
    font-size: 1.25rem;
    font-weight: 700;
    font-style: italic;
    color: #fff8f3
}
.f-head {
    font-size: .58rem;
    letter-spacing: .18em;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 1rem;
    font-weight: 700
}
.f-links {
    list-style: none;
    padding: 0;
    margin: 0
}
.f-links li {
    margin-bottom: .45rem
}
.f-links a {
    color: rgba(255, 243, 236, .55);
    text-decoration: none;
    font-size: .8rem;
    transition: all var(--ease);
    cursor: pointer
}
.f-links a:hover {
    color: var(--gold);
    padding-left: 5px
}
.f-div {
    border-color: rgba(250, 135, 62, .15);
    margin: 2.5rem 0 1.5rem
}
.f-copy {
    font-size: .7rem;
    text-align: center;
    color: rgba(255, 243, 236, .35)
}
.footer-contact-item {
    display: flex;
    align-items: center;
    gap: .8rem;
    margin-bottom: .8rem;
    font-size: .85rem
}
.footer-contact-item a {
    color: rgba(255, 243, 236, .7);
    text-decoration: none
}
.policy-list {
    display: flex;
    flex-direction: column;
    gap: .6rem
}
.policy-link {
    font-size: .75rem;
    color: rgba(255, 243, 236, .5);
    text-decoration: none;
    transition: color var(--ease)
}
.policy-link:hover {
    color: var(--gold)
}

/* Event */
.event-box{background:linear-gradient(145deg,var(--bg-beige),var(--card-bg));border:1px solid var(--gold-light);border-radius:var(--radius-lg);padding:3rem;text-align:center}
.event-box h3{font-family:var(--font-serif);font-size:1.75rem;margin-bottom:1rem;color:var(--text-dark)}
.event-tags{display:flex;flex-wrap:wrap;justify-content:center;gap:0.8rem;margin:2rem 0}
.e-tag{background:rgba(197,160,89,0.1);color:var(--text-dark);padding:0.5rem 1rem;border-radius:50px;font-size:0.85rem;font-weight:600;border:1px solid var(--gold-light)}

/* Special */
.special-card{position:relative;border-radius:var(--radius-lg);overflow:hidden;min-height:300px;display:flex;align-items:flex-end;padding:2.5rem;margin-bottom:2rem}
.special-bg{position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&q=80') center/cover;z-index:0;transition:transform 5s ease}
.special-card:hover .special-bg{transform:scale(1.05)}
.special-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(44,42,41,0.9),transparent);z-index:1}
.special-content{position:relative;z-index:2;color:#fff}
.special-content h4{color:#fff;font-size:1.6rem;margin-bottom:0.5rem}
.special-content p{font-family:var(--font-body);font-size:1.1rem;color:rgba(255,255,255,0.9);margin-bottom:1rem;max-width:80%}
.special-price{display:inline-block;background:var(--gold);color:#fff;padding:0.4rem 1rem;border-radius:50px;font-size:0.85rem;font-weight:600;letter-spacing:0.05em}

/* Booking */
.booking-sticky{position:sticky;top:100px;z-index:90}
.booking-card{background:var(--card-bg);border-radius:var(--radius-lg);padding:2.5rem;box-shadow:var(--shadow-hover);border:1px solid rgba(197,160,89,0.15)}
.bc-title{font-family:var(--font-serif);font-size:1.6rem;font-weight:700;color:var(--text-dark);margin-bottom:1.5rem;text-align:center}
.pricing-info{background:var(--bg-beige);border-radius:var(--radius-md);padding:1.5rem;margin-bottom:2rem}
.pi-row{display:flex;justify-content:space-between;align-items:center;padding:0.6rem 0;border-bottom:1px dashed var(--gold-light)}
.pi-row:last-child{border-bottom:none}
.pi-label{font-size:0.9rem;color:var(--text-muted);font-weight:600}
.pi-val{font-size:1.05rem;color:var(--text-dark);font-family:var(--font-serif);font-weight:700}
.pi-note{font-size:0.75rem;color:var(--text-muted);font-style:italic;text-align:center;margin-top:1rem;display:block}
.bk-input{width:100%;padding:1rem 1.2rem;border:1px solid var(--gold-light);border-radius:var(--radius-sm);font-family:var(--font-sans);font-size:0.9rem;background:var(--bg-ivory);color:var(--text-dark);outline:none;transition:all var(--ease);margin-bottom:1rem}
.bk-input:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(197,160,89,0.1);background:#fff}
.btn-book-submit{width:100%;padding:1.2rem;background:var(--text-dark);color:var(--gold-light);border:none;border-radius:var(--radius-sm);font-family:var(--font-sans);font-size:1rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;cursor:pointer;transition:all var(--ease);margin-bottom:1rem;box-shadow:0 8px 20px rgba(44,42,41,0.2)}
.btn-book-submit:hover{background:var(--gold);color:#fff;transform:translateY(-2px)}
.btn-wa-alt{width:100%;padding:1.2rem;background:var(--bg-beige);color:#25D366;border:1px solid rgba(37,211,102,0.3);border-radius:var(--radius-sm);font-family:var(--font-sans);font-size:1rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;cursor:pointer;transition:all var(--ease);display:flex;align-items:center;justify-content:center;gap:0.5rem;text-decoration:none}
.btn-wa-alt:hover{background:#25D366;color:#fff;border-color:#25D366}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem}

/* ── Amenity Cards ────────────────────────────────────────────── */
.amenity-card {
  border: 1px solid rgba(250,135,62,.18);
  border-radius: 14px;
  padding: 1rem 1.2rem;
  background: #fff;
  transition: border-color .25s;
}
.amenity-card.is-selected {
  border-color: #fa873e;
  background: #fffaf7;
}
.amenity-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  flex-wrap: wrap;
}
.amenity-label {
  display: flex;
  align-items: center;
  gap: .75rem;
  font-weight: 600;
  cursor: pointer;
  flex: 1;
  font-size: .95rem;
  color: var(--text-dark);
}
.amenity-label input[type="checkbox"] {
  width: 1.2rem;
  height: 1.2rem;
  accent-color: var(--brand);
  cursor: pointer;
  flex-shrink: 0;
}
.amenity-price-label {
  font-size: .88rem;
  color: var(--text-muted);
  font-weight: 600;
  white-space: nowrap;
}

/* Participant picker */
.amenity-participants {
  display: none;
  margin-top: .9rem;
  padding-top: .85rem;
  border-top: 1px dashed rgba(250,135,62,.25);
}
.amenity-participants .picker-label {
  font-size: .78rem;
  font-weight: 600;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: var(--text-muted);
  margin-bottom: .5rem;
}
.picker-row {
  display: flex;
  align-items: center;
  gap: .75rem;
  flex-wrap: wrap;
}
.counter-wrap {
  display: flex;
  align-items: center;
  border: 1px solid rgba(250,135,62,.3);
  border-radius: 10px;
  overflow: hidden;
  background: #fff;
}
.counter-btn {
  width: 38px;
  height: 38px;
  border: none;
  background: #fff3ec;
  font-size: 1.25rem;
  font-weight: 700;
  color: #e06828;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background .15s;
  user-select: none;
  flex-shrink: 0;
}
.counter-btn:hover { background: #fcd0b0; }
.counter-btn:disabled { color: #ccc; cursor: not-allowed; background: #fafafa; }
.counter-input {
  width: 52px;
  height: 38px;
  border: none;
  border-left: 1px solid rgba(250,135,62,.2);
  border-right: 1px solid rgba(250,135,62,.2);
  text-align: center;
  font-weight: 700;
  font-size: 1rem;
  color: var(--text-dark);
  background: transparent;
  outline: none;
}
.subtotal-pill {
  font-size: .85rem;
  font-weight: 700;
  color: #e06828;
  background: #fde8d8;
  padding: .25rem .85rem;
  border-radius: 50px;
  white-space: nowrap;
}

/* Animations */
.reveal{opacity:0;transform:translateY(30px);transition:all 0.8s cubic-bezier(0.25,1,0.5,1)}
.reveal.visible{opacity:1;transform:translateY(0)}

@media(max-width:991px){
  .hero-wrapper{height:60vh;min-height:400px}
  .booking-sticky{position:static;margin-top:3rem}
}
@media(max-width:768px){
  .form-row{grid-template-columns:1fr}
  .hero-title{font-size:2.5rem}
  .content-section{padding:1.5rem}
  .special-content p{max-width:100%}
}
.stay-option-card.is-selected {
  border-color: #fa873e;
  background: #fffaf7;
  box-shadow: 0 4px 15px rgba(250, 135, 62, 0.1);
}
.stay-option-card {
  transition: all var(--ease);
}
</style>
</head>
<body>

    <!-- ██ NAVBAR ██ -->
    <nav class="navbar navbar-expand-lg" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}" style="display: flex; align-items: center;">
                <img src="/images/parudeesa-logo.png" alt="Parudeesa Logo" style="height: 75px; width: auto; object-fit: contain;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"
                aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav mx-auto gap-1">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#events">Events</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#gallery">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#about">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#contact">Contact</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="nav-link" style="background: none; border: none; color: inherit; cursor: pointer; padding: 0 !important;">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">LOGIN</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

<div class="hero-wrapper" id="heroWrap">
  <div id="propertyHeroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">
    <div class="carousel-indicators">
      @foreach($heroImages as $image)
      <button type="button" data-bs-target="#propertyHeroCarousel" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}" aria-label="Property image {{ $loop->iteration }}"></button>
      @endforeach
    </div>
    <div class="carousel-inner">
      @foreach($heroImages as $image)
      <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
        <img src="{{ $image }}" class="hero-img" alt="{{ $property->name }} image {{ $loop->iteration }}"/>
      </div>
      @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#propertyHeroCarousel" data-bs-slide="prev" aria-label="Previous image">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#propertyHeroCarousel" data-bs-slide="next" aria-label="Next image">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
  </div>
</div>

<div class="container mb-5 pb-5">
  <div class="row g-5">

    <!-- Left Column -->
    <div class="col-lg-7">

      <div class="content-section reveal">
        <h2 class="section-title">About Stay</h2>
        <p class="about-text">
          A simple lakeside stay shaped by calm sunset views and easy private moments.
        </p>
        <h2 class="section-title mt-4">Highlights</h2>
        <div class="highlight-grid">
          <!-- Swimming Pool -->
          <div class="highlight-card reveal">
            <div class="highlight-img-box">
              <img src="{{ asset('images/highlights/pool.png') }}" alt="Swimming Pool" loading="lazy">
            </div>
            <div class="highlight-body">
              <h3 class="highlight-title">Infinity Swimming Pool</h3>
            </div>
          </div>
          <!-- In-House Restaurant -->
          <div class="highlight-card reveal">
            <div class="highlight-img-box">
              <img src="{{ asset('images/highlights/restaurant.png') }}" alt="Restaurant" loading="lazy">
            </div>
            <div class="highlight-body">
              <h3 class="highlight-title">In-House Restaurant</h3>
            </div>
          </div>
          <!-- Lakeside Property -->
          <div class="highlight-card reveal">
            <div class="highlight-img-box">
              <img src="{{ asset('images/highlights/property.png') }}" alt="Lakeside Property" loading="lazy">
            </div>
            <div class="highlight-body">
              <h3 class="highlight-title">Lakeside Property</h3>
            </div>
          </div>
          <!-- Sunset Views -->
          <div class="highlight-card reveal">
            <div class="highlight-img-box">
              <img src="{{ asset('images/highlights/sunset.png') }}" alt="Sunset Views" loading="lazy">
            </div>
            <div class="highlight-body">
              <h3 class="highlight-title">Breathtaking Sunset Views</h3>
            </div>
          </div>
        </div>
      </div>

      <div class="content-section reveal mx-auto" style="max-width:1400px">
        <h2 class="section-title">Accommodation and Outdoor Spaces</h2>
        <div class="icon-card-grid">
          <div class="icon-card"><div class="ic-icon"><i class="bi bi-houses-fill"></i></div><div class="ic-content"><div class="ic-title">3 Bedroom Cottage</div></div></div>
          <div class="icon-card"><div class="ic-icon"><i class="bi bi-snow2"></i></div><div class="ic-content"><div class="ic-title">1 Master Bedroom</div></div></div>
          <div class="icon-card"><div class="ic-icon"><i class="bi bi-door-open-fill"></i></div><div class="ic-content"><div class="ic-title">2 Standard Bedrooms</div></div></div>
          <div class="icon-card"><div class="ic-icon"><i class="bi bi-badge-wc-fill"></i></div><div class="ic-content"><div class="ic-title">1 Common Washroom</div></div></div>
          <div class="icon-card"><div class="ic-icon"><i class="bi bi-brightness-alt-high-fill"></i></div><div class="ic-content"><div class="ic-title">Veranda</div></div></div>
          <div class="icon-card"><div class="ic-icon"><i class="bi bi-water"></i></div><div class="ic-content"><div class="ic-title">Private Pool Area</div></div></div>
          <div class="icon-card"><div class="ic-icon"><i class="bi bi-tree-fill"></i></div><div class="ic-content"><div class="ic-title">Lawn Area</div></div></div>
          <div class="icon-card"><div class="ic-icon"><i class="bi bi-car-front-fill"></i></div><div class="ic-content"><div class="ic-title">Private Parking</div></div></div>
          <div class="icon-card"><div class="ic-icon"><i class="bi bi-balloon-heart-fill"></i></div><div class="ic-content"><div class="ic-title">Open Event Space</div></div></div>
        </div>
      </div>

      <div class="content-section reveal mx-auto" style="max-width:1400px">
        <h2 class="section-title">Experiences and Add-ons</h2>
        <div class="exp-grid">
          @foreach($amenities as $amenity)
            @if(!str_contains(strtolower($amenity->name), 'yacht'))
            <div class="exp-card">
              @if($amenity->is_premium)
                <div class="premium-badge">Premium</div>
              @endif
              <div class="exp-img-box">
                <img src="{{ $amenity->image_url ?: 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=600&q=80' }}" alt="{{ $amenity->name }}" loading="lazy">
              </div>
              <div class="exp-body">
                <div class="exp-title">{{ $amenity->name }}</div>
                <div class="exp-price">
                  @if($amenity->price > 0)
                    ₹{{ number_format($amenity->price, 0) }}{{ $amenity->pricing_type === 'per_person' ? ' / person' : '' }}
                  @else
                    Premium Add-on
                  @endif
                </div>
                @if($amenity->condition_note)
                  <div class="exp-condition">{{ $amenity->condition_note }}</div>
                @endif
                <div class="exp-desc">{{ $amenity->description }}</div>
                <button class="btn-add-exp" onclick="openAddonModal('{{ strtolower($amenity->name) }}', '{{ $amenity->name }}')">
                  <i class="bi bi-plus-lg"></i> Add
                </button>
              </div>
            </div>
            @endif
          @endforeach
        </div>
      </div>

      @if($yachtAmenity)
      <div class="reveal mx-auto" style="max-width:1400px">
        <div class="special-card mb-5">
          <div class="special-bg" style="background-image: url('{{ $yachtAmenity->image_url ?: 'https://images.unsplash.com/photo-1569263979104-865ab7cd8d13?w=1400&q=80' }}');"></div>
          <div class="special-overlay"></div>
          <div class="special-content">
            <h4 style="font-size: 1.2rem; margin-bottom: 0.5rem;">{{ $yachtAmenity->name }}</h4>
            <p>{{ $yachtAmenity->description }}</p>
            <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
              <span class="special-price">
                @if($yachtAmenity->price > 0)
                  ₹{{ number_format($yachtAmenity->price, 0) }}
                @else
                  Premium Add-on
                @endif
              </span>
              <button class="btn-add-exp" style="background: #fff; color: var(--text-dark); border: none;" onclick="openAddonModal('{{ strtolower($yachtAmenity->name) }}', '{{ $yachtAmenity->name }}')">
                <i class="bi bi-plus-lg"></i> Add to Booking
              </button>
            </div>
          </div>
        </div>
      </div>
      @endif



      <div class="reveal">
        <div class="event-box">
          <h3>Host Your Perfect Event</h3>
          <p class="about-text text-center">Transform our luxury lakeside spaces into your dream venue.</p>
          <div class="event-tags">
            <span class="e-tag">Birthday Parties</span>
            <span class="e-tag">Family Gatherings</span>
            <span class="e-tag">Corporate Events</span>
            <span class="e-tag">Pool Parties</span>
            <span class="e-tag">Romantic Events</span>
            <span class="e-tag">Private Celebrations</span>
          </div>
          <a href="/chatbot" target="_blank" class="btn-premium mt-3">
            Request Custom Event Package
          </a>
        </div>
      </div>

      <div class="content-section reveal mx-auto" style="max-width:1400px; margin-top: 4rem;">
        <h2 class="section-title">Cancellation & Rescheduling Policy</h2>
        <div class="policy-card" style="background: var(--bg-beige); padding: 2rem; border-radius: var(--radius-md); border-left: 4px solid var(--gold);">
          <ul style="list-style: none; padding: 0; margin: 0; font-family: var(--font-body); font-size: 1.1rem; color: var(--text-dark); line-height: 1.8;">
            <li style="margin-bottom: 1rem; display: flex; gap: 1rem;"><i class="bi bi-check-circle-fill" style="color: var(--gold); margin-top: 0.2rem;"></i> <span>Cancellations must be made at least <strong>21–22 days</strong> prior to check-in for a full refund.</span></li>
            <li style="margin-bottom: 1rem; display: flex; gap: 1rem;"><i class="bi bi-info-circle-fill" style="color: #4285F4; margin-top: 0.2rem;"></i> <span>Cancellations made within <strong>7–21 days</strong> may be eligible for partial refund.</span></li>
            <li style="margin-bottom: 1rem; display: flex; gap: 1rem;"><i class="bi bi-x-circle-fill" style="color: #EA4335; margin-top: 0.2rem;"></i> <span>Cancellations within <strong>7 days</strong> of booking date are non-refundable.</span></li>
            <li style="margin-bottom: 1rem; display: flex; gap: 1rem;"><i class="bi bi-calendar-event-fill" style="color: var(--gold); margin-top: 0.2rem;"></i> <span>Rescheduling is allowed subject to availability and prior notice.</span></li>
            <li style="display: flex; gap: 1rem;"><i class="bi bi-shield-fill-exclamation" style="color: var(--text-muted); margin-top: 0.2rem;"></i> <span>In case of unforeseen circumstances, management reserves the right to make final decisions.</span></li>
          </ul>
        </div>
      </div>

    </div>

    <!-- Right Column: Booking -->
    <div class="col-lg-5" id="booking-section">
      <div class="booking-sticky reveal">
        <div class="booking-card">
          {{-- 1. Pricing Options (LOW -> HIGH) --}}
          <div style="font-family:var(--font-sans);font-size:.75rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:var(--text-muted);margin-bottom:.85rem;">
            Select Stay Option
          </div>
          <div class="pricing-options-grid mb-4" style="display: flex; flex-direction: column; gap: 0.75rem;">
            {{-- 1. Weekday (Up to 5 Guests) --}}
            <label class="amenity-card stay-option-card" style="cursor: pointer;">
                <input type="radio" name="stay_option_radio" value="8000" data-label="Weekday (Up to 5 Guests)" style="display: none;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div style="font-weight: 700; color: var(--text-dark);">Weekday (Up to 5 Guests)</div>
                    </div>
                    <div class="stay-price-display" style="font-weight: 800; color: var(--gold);">₹8,000</div>
                </div>
            </label>
            {{-- 2. Weekday (Up to 10 Guests) --}}
            <label class="amenity-card stay-option-card" style="cursor: pointer;">
                <input type="radio" name="stay_option_radio" value="11000" data-label="Weekday (Up to 10 Guests)" style="display: none;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div style="font-weight: 700; color: var(--text-dark);">Weekday (Up to 10 Guests)</div>
                    </div>
                    <div class="stay-price-display" style="font-weight: 800; color: var(--gold);">₹11,000</div>
                </div>
            </label>
            {{-- 3. Weekend (Up to 10 Guests) --}}
            <label class="amenity-card stay-option-card is-selected" style="cursor: pointer;">
                <input type="radio" name="stay_option_radio" value="12000" data-label="Weekend (Up to 10 Guests)" checked style="display: none;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div style="font-weight: 700; color: var(--text-dark);">Weekend (Up to 10 Guests)</div>
                    </div>
                    <div class="stay-price-display" style="font-weight: 800; color: var(--gold);">₹12,000</div>
                </div>
            </label>
          </div>

          {{-- 2. BOOK VIA CHATBOT Button (Reduced size) --}}
          <div class="text-center mb-4">
            <a href="/chatbot" class="btn-wa-alt d-inline-flex justify-content-center align-items-center" style="background: linear-gradient(135deg, #25D366, #1aa854); color: #fff; padding: 0.5rem 1.5rem; font-size: 0.85rem; border-radius: 30px; width: auto; gap: 0.5rem;">
              <i class="bi bi-robot"></i> BOOK VIA CHATBOT
            </a>
          </div>

          <form action="{{ route('bookings.store') }}" method="POST" id="bk-form">
            @csrf
            <input type="hidden" name="property_id"  value="{{ $property->id }}" />
            <input type="hidden" name="amount"        id="form-amount"       value="12000" />
            <input type="hidden" name="extra_amount"  id="form-extra-amount" value="0" />
            <input type="hidden" name="base_amount"   id="form-base-amount"  value="12000" />
            <input type="hidden" name="package_name"  id="form-package-name" value="Only Stay" />
            <input type="hidden" name="event_type"    id="form-event-type"   value="Weekend (Up to 10 Guests)" />

            <!-- Sidebar Form Content (Always Visible) -->
            <div id="booking-details-sidebar">
              <div class="form-row">
                <input type="text"   class="bk-input" id="checkin"  name="check_in"  placeholder="Check-in Date"  required />
                <input type="text"   class="bk-input" id="checkout" name="check_out" placeholder="Check-out Date" required />
              </div>
              <div class="form-row">
                <div style="position: relative;">
                  <input type="number" class="bk-input" name="guests" id="guests-input" placeholder="Total Guests" min="1" required />
                  <div id="guest-error" style="color:#C62828;font-size:0.7rem;margin-top:-0.8rem;margin-bottom:0.8rem;display:none;font-weight:700;line-height:1.2;"></div>
                </div>
                <input type="text"   class="bk-input" name="name"   placeholder="Full Name"     required />
              </div>
              <div class="form-row">
                <input type="tel"   class="bk-input" name="phone" placeholder="Phone Number"    required />
                <input type="email" class="bk-input" name="email" placeholder="Email Address"   required />
              </div>

              {{-- Amenities --}}
              <div style="margin-bottom:1.5rem;">
                <div style="font-family:var(--font-sans);font-size:.75rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:var(--text-muted);margin-bottom:.85rem;">
                  Select Amenities
                </div>
                <div id="amenities-list" style="display:flex;flex-direction:column;gap:.75rem;">
                  @forelse($amenities as $amenity)
                  <div class="amenity-card" data-amenity-id="{{ $amenity->id }}" style="padding: 1rem; border-radius: 12px; background: var(--bg-beige); border: 1px solid rgba(250,135,62,.1);">
                    <div class="d-flex justify-content-between align-items-center">
                      <label class="amenity-label d-flex align-items-center gap-2 mb-0" style="cursor: pointer;">
                        <input type="checkbox" class="amenity-selector" 
                               data-amenity-id="{{ $amenity->id }}" 
                               data-amenity-name="{{ $amenity->name }}" 
                               data-amenity-price="{{ $amenity->price }}" 
                               data-amenity-type="{{ $amenity->pricing_type }}" 
                               name="amenities[{{ $amenity->id }}][selected]" value="1" />
                        <span style="font-weight: 600; font-size: 0.85rem; color: var(--text-dark);">{{ $amenity->name }}</span>
                      </label>
                      <div style="font-weight: 700; font-size: 0.85rem; color: var(--gold);">
                        @if($amenity->price > 0)
                          ₹{{ number_format($amenity->price, 0) }}{{ $amenity->pricing_type === 'per_person' ? '/p' : '' }}
                        @else
                          Premium
                        @endif
                      </div>
                    </div>
                    
                    @if($amenity->pricing_type === 'per_person')
                    <div class="amenity-participants mt-2" style="display: none;">
                      <div class="d-flex align-items-center justify-content-between">
                        <div style="font-size: 0.7rem; color: var(--text-muted);">Persons:</div>
                        <div class="d-flex align-items-center gap-2">
                          <button type="button" class="counter-btn minus-btn" style="width:24px; height:24px; font-size:0.8rem;" disabled>−</button>
                          <input type="number" class="counter-input amenity-participants-input" name="amenities[{{ $amenity->id }}][participants]" value="1" min="1" readonly style="width:30px; border:none; background:transparent; text-align:center; font-weight:700; font-size:0.85rem;" />
                          <button type="button" class="counter-btn plus-btn" style="width:24px; height:24px; font-size:0.8rem;">+</button>
                        </div>
                      </div>
                    </div>
                    @else
                    <input type="hidden" class="counter-input" name="amenities[{{ $amenity->id }}][participants]" value="1" />
                    @endif
                  </div>
                  @empty
                  <div style="font-size:.85rem;color:var(--text-muted);">No amenities available.</div>
                  @endforelse
                </div>

                <div id="selected-amenities-preview" style="display:none; padding:1rem; border-radius:12px; background:rgba(250,135,62,.05); border:1px solid rgba(250,135,62,.15); margin-top:1rem;">
                  <div style="font-size:0.7rem; font-weight:700; text-transform:uppercase; color:var(--gold); margin-bottom:0.5rem; letter-spacing:0.05em;">Selected Experiences</div>
                  <div id="preview-items-list" style="display:flex; flex-direction:column; gap:0.4rem;"></div>
                </div>
              </div>

              <button type="button" class="btn-book-submit" style="margin-top:1.5rem;" onclick="openBookingWizard()">CONFIRM BOOKING</button>
            </div>

            {{-- Enquiry Section (shown on all steps or just step 1) --}}
            <div id="enquiry-section" class="contact-panel" style="margin-top:1.2rem;padding:1.5rem;border:1px solid rgba(0,0,0,.08);border-radius:12px;background:#fafafa;font-size:.95rem;text-align:center;">
              <div style="font-weight:700;margin-bottom:.85rem;color:var(--text-dark);">For enquiries only:</div>
              <a href="{{ route('home') }}#contact" class="btn-outline-premium w-100 justify-content-center" style="display:inline-flex;text-decoration:none;">ENQUIRE NOW</a>
            </div>

            <div id="booking-msg" style="display:none;margin-top:1.5rem;padding:1rem;border-radius:var(--radius-sm);font-size:.9rem;text-align:center"></div>
          </form>

        </div>
      </div>
    </div>

  </div>
</div>


  <!-- ████████ FOOTER ████████ -->
  <footer>
    <div class="container">
      <div class="row g-5">
        <!-- SECTION 1: ADDRESS -->
        <div class="col-lg-3 col-md-6">
          <div class="f-head">Address</div>
          <div class="f-brand" style="font-family: 'Cormorant Garamond', serif; font-weight:700;">
            <img src="/images/parudeesa-logo.png" alt="Parudeesa Logo" style="height: 85px; width: auto; object-fit: contain;">
          </div>
          <p style="font-size:.8rem;color:rgba(255,243,236,.55);margin-top:1rem;line-height:1.75">
            Kerala Backwaters<br/>
            India
          </p>
          <p style="font-style:italic;color:rgba(255,243,236,.4);font-size:.95rem;line-height:1.65; font-family:'EB Garamond', serif;">
            "Experience Serenity by the Lake"</p>
        </div>

        <!-- SECTION 2: NAVIGATION -->
        <div class="col-6 col-md-3 col-lg-2">
          <div class="f-head">Navigation</div>
          <ul class="f-links">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('home') }}#events">Events</a></li>
            <li><a href="{{ route('home') }}#gallery">Gallery</a></li>
            <li><a href="{{ route('home') }}#about">About Us</a></li>
            <li><a href="{{ route('home') }}#contact">Contact</a></li>
          </ul>
        </div>

        <!-- SECTION 3: POLICIES -->
        <div class="col-6 col-md-3 col-lg-3">
          <div class="f-head">Policies</div>
          <div class="policy-list">
            <a href="/terms-and-conditions" class="policy-link">Terms & Conditions</a>
            <a href="/privacy-policy" class="policy-link">Privacy Policy</a>
            <a href="/cancellation-policy" class="policy-link">Cancellation Policy</a>
          </div>
        </div>

        <!-- SECTION 4: CONTACT US -->
        <div class="col-md-6 col-lg-4">
          <div class="f-head">Contact Us</div>
          <div class="footer-contact">
            <div class="footer-contact-item"><i class="bi bi-telephone" style="color:var(--brand)"></i><a href="tel:+918921021202">+91 89210 21202</a></div>
            <div class="footer-contact-item"><i class="bi bi-envelope" style="color:var(--brand-l)"></i><a href="mailto:hello@parudeesa.in">hello@parudeesa.in</a></div>
          </div>
        </div>
      </div>
      <hr class="f-div" />
      <p class="f-copy">&copy; 2026 Parudeesa - The Lake View Resort. All rights reserved. Made with love in Kerala.</p>
    </div>
  </footer>

  <!-- ████ Booking Wizard Modal ████ -->
  <div class="modal fade" id="bookingWizardModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius: var(--radius-lg); border: none; box-shadow: var(--shadow-hover);">
        <div class="modal-header" style="border-bottom: 1px solid var(--gold-light); padding: 1.5rem;">
          <h5 class="modal-title" id="wizardTitle" style="font-family: var(--font-serif); font-size: 1.15rem; font-weight: 700; color: var(--text-dark);">Stay Options</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="padding: 1.5rem;">
          
          <!-- Wizard Step 1: Package Selection -->
          <div id="wizard-step-1">
            <p class="text-muted mb-4" style="font-size: 0.9rem;">Please select your preferred stay package to continue.</p>
            <div class="d-flex flex-column gap-3 mb-4">
              <label class="amenity-card stay-option-card is-selected" style="cursor: pointer;">
                <input type="radio" name="wizard_package_option" value="0" data-name="Only Stay" checked style="display: none;">
                <div class="d-flex justify-content-between align-items-center">
                  <div style="font-weight: 700; color: var(--text-dark);">Only Stay</div>
                  <div style="font-weight: 800; color: var(--gold);">Base Price</div>
                </div>
              </label>
              <label class="amenity-card stay-option-card" style="cursor: pointer;">
                <input type="radio" name="wizard_package_option" value="200" data-name="Stay + Breakfast" style="display: none;">
                <div class="d-flex justify-content-between align-items-center">
                  <div style="font-weight: 700; color: var(--text-dark);">Stay + Breakfast</div>
                  <div style="font-weight: 800; color: var(--gold);">+ ₹200 / person</div>
                </div>
              </label>
              <label class="amenity-card stay-option-card" style="cursor: pointer;">
                <input type="radio" name="wizard_package_option" value="450" data-name="Stay + Breakfast + Dinner" style="display: none;">
                <div class="d-flex justify-content-between align-items-center">
                  <div style="font-weight: 700; color: var(--text-dark);">Stay + Breakfast + Dinner</div>
                  <div style="font-weight: 800; color: var(--gold);">+ ₹450 / person</div>
                </div>
              </label>
            </div>
            <button type="button" class="btn-book-submit w-100" onclick="wizardGoToStep(2)">Continue to Summary</button>
          </div>

          <!-- Wizard Step 2: Booking Summary -->
          <div id="wizard-step-2" style="display:none;">
            <div class="summary-details p-4 rounded-4" style="background:var(--bg-beige); border:1px solid rgba(250,135,62,.12);">
              <div class="d-flex justify-content-between mb-2">
                <span style="color:var(--text-muted); font-size:0.9rem;">Stay Type:</span>
                <span id="wizard-summary-stay-type" style="font-weight:700; color:var(--text-dark);"></span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span style="color:var(--text-muted); font-size:0.9rem;">Package:</span>
                <span id="wizard-summary-package" style="font-weight:700; color:var(--gold);"></span>
              </div>
              <div class="d-flex justify-content-between mb-3 pb-3 border-bottom" style="border-color:rgba(250,135,62,.1) !important;">
                <span style="color:var(--text-muted); font-size:0.9rem;">Guests:</span>
                <span id="wizard-summary-guests" style="font-weight:700; color:var(--text-dark);"></span>
              </div>
              
              <div id="wizard-summary-amenities" class="mb-3"></div>

              <div class="d-flex justify-content-between align-items-center pt-2">
                <span style="font-weight:700; font-size:1.1rem; color:var(--text-dark);">Total Amount:</span>
                <span id="wizard-summary-total" style="font-weight:800; color:var(--gold); font-size:1.5rem;"></span>
              </div>
            </div>
            <div class="d-flex gap-2 mt-4">
              <button type="button" class="btn btn-outline-secondary w-50" style="border-radius:12px; font-weight:600;" onclick="wizardGoToStep(1)">Back</button>
              <button type="button" class="btn-book-submit w-100 mb-0" onclick="handleBookingSubmit(event)">PROCEED TO PAYMENT</button>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Addon Modal -->
  <div class="modal fade" id="addonModal" tabindex="-1" aria-labelledby="addonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius: var(--radius-lg); border: none; box-shadow: var(--shadow-hover);">
        <div class="modal-header" style="border-bottom: 1px solid var(--gold-light); padding: 1.5rem;">
          <h5 class="modal-title" id="addonModalLabel" style="font-family: var(--font-serif); font-size: 1.25rem; font-weight: 700; color: var(--text-dark);">Add Experience</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="padding: 2rem 1.5rem;">
          <p style="font-family: var(--font-sans); color: var(--text-muted); margin-bottom: 1.5rem; font-size: 1.05rem;">How many guests will be participating in the <strong id="modalExperienceName" style="color: var(--gold);"></strong> experience?</p>
          <div class="form-group">
            <label class="form-label" style="font-weight: 600; font-size: 0.9rem; color: var(--text-dark);">Number of Persons</label>
            <div class="d-flex align-items-center gap-3">
              <button type="button" class="btn btn-outline-secondary rounded-circle" style="width: 40px; height: 40px; border-color: var(--gold-light); color: var(--gold);" onclick="updateModalCount(-1)">-</button>
              <input type="number" id="modalPersonCount" class="form-control text-center" value="1" min="1" readonly style="width: 80px; font-weight: 700; border-color: var(--gold-light);">
              <button type="button" class="btn btn-outline-secondary rounded-circle" style="width: 40px; height: 40px; border-color: var(--gold-light); color: var(--gold);" onclick="updateModalCount(1)">+</button>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="border-top: none; padding: 1.5rem;">
          <button type="button" class="btn-book-submit mb-0 w-100" id="btnConfirmAddon">Confirm & Add to Booking</button>
        </div>
      </div>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
/* ── Scroll reveal ─────────────────────────────────────────────────────── */
const obs = new IntersectionObserver((entries) => {
  entries.forEach((e) => {
    if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); }
  });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

/* ── Init on DOM ready ─────────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', async () => {
  let disabledDates = [];
  try {
    const res = await fetch(`/property/{{ $property->id }}/unavailable-dates`);
    if (res.ok) disabledDates = await res.json();
  } catch (err) { console.error('Could not load unavailable dates:', err); }

  const fpCfg = { minDate: 'today', dateFormat: 'Y-m-d', disable: disabledDates };
  flatpickr('#checkin',  fpCfg);
  flatpickr('#checkout', fpCfg);

  initAmenityListeners();
  initStayOptionListeners();
  initPackageListeners();
  updateBookingSummary();
});

/* ── Modal Wizard Flow ──────────────────────────────────────────────────── */
function openBookingWizard() {
  const checkin = document.getElementById('checkin').value;
  const checkout = document.getElementById('checkout').value;
  const guests = document.querySelector('input[name="guests"]').value;
  const name = document.querySelector('input[name="name"]').value;
  const phone = document.querySelector('input[name="phone"]').value;
  
  if(!checkin || !checkout || !guests || !name || !phone) {
    alert('Please fill all required fields before proceeding.');
    return;
  }
  
  // Reset wizard to Step 1
  wizardGoToStep(1);
  const wizardModal = new bootstrap.Modal(document.getElementById('bookingWizardModal'));
  wizardModal.show();
}

function wizardGoToStep(step) {
  const step1 = document.getElementById('wizard-step-1');
  const step2 = document.getElementById('wizard-step-2');
  const title = document.getElementById('wizardTitle');
  
  step1.style.display = 'none';
  step2.style.display = 'none';
  
  if (step === 1) {
    title.textContent = 'Stay Options';
    step1.style.display = 'block';
  } else if (step === 2) {
    title.textContent = 'Booking Summary';
    updateWizardSummary();
    step2.style.display = 'block';
  }
}

function updateWizardSummary() {
  const stayOptionLabel = document.getElementById('form-event-type').value;
  const guestCount = getGuestCount();
  const selectedPackage = document.querySelector('input[name="wizard_package_option"]:checked');
  const packageName = selectedPackage.dataset.name;
  const packagePricePerPerson = parseFloat(selectedPackage.value);
  
  // Base Stay Price (already calculated in form-base-amount during updateBookingSummary)
  const baseTotal = parseFloat(document.getElementById('form-base-amount').value) || 0;
  const packageTotal = packagePricePerPerson * guestCount;
  const amenitiesTotal = parseFloat(document.getElementById('form-extra-amount').value) || 0;
  const grandTotal = baseTotal + packageTotal + amenitiesTotal;
  
  document.getElementById('wizard-summary-stay-type').textContent = stayOptionLabel;
  document.getElementById('wizard-summary-guests').textContent = guestCount;
  document.getElementById('wizard-summary-package').textContent = packageName;
  document.getElementById('wizard-summary-total').textContent = `₹${grandTotal.toLocaleString()}`;
  
  // Populate amenities in summary
  const amenities = buildAmenityPayload();
  const amenitiesContainer = document.getElementById('wizard-summary-amenities');
  amenitiesContainer.innerHTML = '';
  
  if(amenities.length > 0) {
    amenities.forEach(a => {
      const item = document.createElement('div');
      item.style.cssText = 'display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 0.4rem; color:var(--text-muted);';
      const text = a.pricing_type === 'per_person' ? `${a.name} (${a.participants} guests)` : a.name;
      item.innerHTML = `<span>${text}</span><span style="font-weight: 600; color:var(--text-dark);">₹${a.total.toLocaleString()}</span>`;
      amenitiesContainer.appendChild(item);
    });
  } else {
    amenitiesContainer.innerHTML = '<div style="font-size:0.85rem; color:var(--text-muted); font-style:italic;">No extra amenities selected</div>';
  }
  
  // Sync values back to hidden form inputs for final submission
  document.getElementById('form-package-name').value = packageName;
  document.getElementById('form-amount').value = grandTotal;
}

/* ── Stay Option listeners ────────────────────────────────────────────── */
function initStayOptionListeners() {
  document.querySelectorAll('input[name="stay_option_radio"]').forEach((radio) => {
    radio.addEventListener('change', () => {
      document.querySelectorAll('.stay-option-card').forEach(c => c.classList.remove('is-selected'));
      radio.closest('.stay-option-card').classList.add('is-selected');
      
      updateBookingSummary();
    });
  });
}

function calculateDynamicBasePrice() {
    const selected = document.querySelector('input[name="stay_option_radio"]:checked');
    if (!selected) return 0;

    const baseValue = parseFloat(selected.value);
    const guests = getGuestCount();
    const label = selected.dataset.label;

    let calculatedPrice = baseValue;

    // Weekday (Up to 5 Guests) logic: 8000 base + 600 per extra guest (>5)
    if (label.includes("Weekday (Up to 5 Guests)")) {
        if (guests <= 5) {
            calculatedPrice = 8000;
        } else {
            calculatedPrice = 8000 + ((guests - 5) * 600);
        }
    } else if (label.includes("Weekend")) {
        calculatedPrice = 12000;
    } else if (label.includes("Weekday (Up to 10 Guests)")) {
        calculatedPrice = 11000;
    }

    return calculatedPrice;
}

function initPackageListeners() {
  document.querySelectorAll('input[name="wizard_package_option"]').forEach((radio) => {
    radio.addEventListener('change', () => {
      document.querySelectorAll('#wizard-step-1 .stay-option-card').forEach(c => c.classList.remove('is-selected'));
      radio.closest('.stay-option-card').classList.add('is-selected');
    });
  });
}

/* ── Amenity listeners ─────────────────────────────────────────────────── */
function initAmenityListeners() {

  /* Checkbox toggle */
  document.querySelectorAll('.amenity-selector').forEach((chk) => {
    chk.addEventListener('change', () => {
      const card = chk.closest('.amenity-card');
      const pr   = card.querySelector('.amenity-participants');

      card.classList.toggle('is-selected', chk.checked);

      if (pr) {
        pr.style.display = chk.checked ? 'block' : 'none';
        if (chk.checked) syncLimits();
      }
      updateBookingSummary();
    });
  });

  /* Plus buttons */
  document.querySelectorAll('.plus-btn').forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const card       = btn.closest('.amenity-card');
      const input      = card.querySelector('.counter-input');
      const minusBtn   = card.querySelector('.minus-btn');
      const price      = parseFloat(card.querySelector('.amenity-selector').dataset.amenityPrice) || 0;
      const guestCount = getGuestCount();
      let val = parseInt(input.value) || 1;

      if (val < guestCount) {
        val++;
        input.value       = val;
        minusBtn.disabled = val <= 1;
        btn.disabled      = val >= guestCount;
        updateSubtotal(card, price, val);
        updateBookingSummary();
      } else {
        alert(`Participants cannot exceed the total number of guests (${guestCount}).`);
      }
    });
  });

  /* Minus buttons */
  document.querySelectorAll('.minus-btn').forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const card     = btn.closest('.amenity-card');
      const input    = card.querySelector('.counter-input');
      const plusBtn  = card.querySelector('.plus-btn');
      const price    = parseFloat(card.querySelector('.amenity-selector').dataset.amenityPrice) || 0;
      let val = parseInt(input.value) || 1;

      if (val > 1) {
        val--;
        input.value      = val;
        btn.disabled     = val <= 1;
        plusBtn.disabled = val >= getGuestCount();
        updateSubtotal(card, price, val);
        updateBookingSummary();
      }
    });
  });

  /* Guest count change → clamp participant inputs */
  const guestInput = document.getElementById('guests-input');
  if (guestInput) {
    guestInput.addEventListener('input', () => {
      syncLimits();
      updateBookingSummary();
    });
  }
}

let currentAddonKeyword = '';

function openAddonModal(keyword, name) {
  currentAddonKeyword = keyword;
  document.getElementById('modalExperienceName').textContent = name;
  document.getElementById('modalPersonCount').value = 1;
  const modal = new bootstrap.Modal(document.getElementById('addonModal'));
  modal.show();
}

function updateModalCount(delta) {
  const input = document.getElementById('modalPersonCount');
  let val = parseInt(input.value) || 1;
  const guestCount = getGuestCount();
  val += delta;
  if (val < 1) val = 1;
  if (val > guestCount) {
    val = guestCount;
    alert(`Participants cannot exceed the total number of guests (${guestCount}).`);
  }
  input.value = val;
}

document.getElementById('btnConfirmAddon')?.addEventListener('click', function() {
  const persons = parseInt(document.getElementById('modalPersonCount').value);
  
  if (!persons || persons < 1) {
    alert('Please enter a valid number of persons (minimum 1).');
    return;
  }

  const checkbox = Array.from(document.querySelectorAll('.amenity-selector'))
    .find((chk) => (chk.dataset.amenityName || '').toLowerCase().includes(currentAddonKeyword.toLowerCase()));
    
  if (checkbox) {
    checkbox.checked = true;
    const card = checkbox.closest('.amenity-card');
    const input = card.querySelector('.counter-input');
    if (input) {
      input.value = persons;
    }
    checkbox.dispatchEvent(new Event('change', { bubbles: true }));
    
    // Close modal properly
    const modalEl = document.getElementById('addonModal');
    const modalInstance = bootstrap.Modal.getInstance(modalEl);
    if(modalInstance) modalInstance.hide();

    // Visual feedback
    updateSidebarPreview();
    
    setTimeout(() => {
      document.getElementById('selected-amenities-preview')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }, 300);
  } else {
    const modalEl = document.getElementById('addonModal');
    const modalInstance = bootstrap.Modal.getInstance(modalEl);
    if(modalInstance) modalInstance.hide();
  }
});

function updateSidebarPreview() {
  const amenities = buildAmenityPayload();
  const previewContainer = document.getElementById('selected-amenities-preview');
  const previewList = document.getElementById('preview-items-list');
  
  previewList.innerHTML = '';
  
  if (amenities.length > 0) {
    previewContainer.style.display = 'block';
    amenities.forEach(a => {
      const item = document.createElement('div');
      item.style.cssText = 'display:flex; justify-content:space-between; font-size:0.8rem; color:var(--text-dark);';
      const personText = a.participants ? ` (${a.participants} persons)` : '';
      item.innerHTML = `
        <span style="font-weight:500;">${a.name}${personText}</span>
        <span style="font-weight:700; color:var(--gold);">₹${a.total.toLocaleString()}</span>
      `;
      previewList.appendChild(item);
    });
  } else {
    previewContainer.style.display = 'none';
  }
}

function getGuestCount() {
  return Math.max(1, parseInt(document.getElementById('guests-input')?.value || '1'));
}

function updateSubtotal(card, price, qty) {
  const pill = card.querySelector('.subtotal-pill');
  const chk = card.querySelector('.amenity-selector');
  let finalPrice = price;

  // Custom logic for Kayaking & Boating
  if ((chk.dataset.amenityName || '').toLowerCase().includes('kayaking')) {
    finalPrice = (qty < 5) ? 1000 : 700;
  }

  if (pill) pill.textContent = `₹${(finalPrice * qty).toFixed(0)}`;
}

function syncLimits() {
  const guestCount = getGuestCount();
  document.querySelectorAll('.amenity-card').forEach((card) => {
    const chk   = card.querySelector('.amenity-selector');
    const input = card.querySelector('.counter-input');
    if (!input || !chk?.checked) return;

    const price    = parseFloat(chk.dataset.amenityPrice) || 0;
    const plusBtn  = card.querySelector('.plus-btn');
    const minusBtn = card.querySelector('.minus-btn');
    let val = parseInt(input.value) || 1;

    if (val > guestCount) {
      val = guestCount;
      input.value = val;
    }
    updateSubtotal(card, price, val);
    if (plusBtn)  plusBtn.disabled  = val >= guestCount;
    if (minusBtn) minusBtn.disabled = val <= 1;
  });
}

/* ── Build payload ─────────────────────────────────────────────────────── */
function buildAmenityPayload() {
  const amenities = [];
  document.querySelectorAll('.amenity-selector').forEach((chk) => {
    if (!chk.checked) return;
    const card        = chk.closest('.amenity-card');
    let price       = parseFloat(chk.dataset.amenityPrice) || 0;
    const pricingType = chk.dataset.amenityType;
    const input       = card.querySelector('.counter-input');
    const participants = pricingType === 'per_person' && input
      ? Math.max(1, parseInt(input?.value || '1'))
      : null;
    
    // Custom logic for Kayaking & Boating dynamic pricing
    if ((chk.dataset.amenityName || '').toLowerCase().includes('kayaking')) {
      if (participants !== null) {
        price = (participants < 5) ? 1000 : 700;
      }
    }

    const total = pricingType === 'per_person' && participants !== null ? price * participants : price;
    amenities.push({
      id: chk.dataset.amenityId,
      name: chk.dataset.amenityName,
      pricing_type: pricingType,
      price,
      participants,
      total
    });
  });
  return amenities;
}

/* ── Summary ───────────────────────────────────────────────────────────── */
function updateBookingSummary() {
  const guests = getGuestCount();
  const selectedRadio = document.querySelector('input[name="stay_option_radio"]:checked');
  if (!selectedRadio) return;

  const label = selectedRadio.dataset.label;
  const guestError = document.getElementById('guest-error');
  if (guestError) {
      guestError.style.display = 'none';
      guestError.textContent = '';
  }
  
  let baseStayPrice = parseFloat(selectedRadio.value);
  let extraGuestCharge = 0;
  let extraGuestCount = 0;

  // STAY OPTION 1: Weekday (Up to 5 Guests)
  if (label.includes("Weekday (Up to 5 Guests)")) {
      if (guests >= 10) {
          // Automatically switch to Option 2
          const opt2 = Array.from(document.querySelectorAll('input[name="stay_option_radio"]'))
              .find(r => r.dataset.label.includes("Weekday (Up to 10 Guests)"));
          if (opt2) {
              opt2.checked = true;
              document.querySelectorAll('.stay-option-card').forEach(c => c.classList.remove('is-selected'));
              opt2.closest('.stay-option-card').classList.add('is-selected');
              return updateBookingSummary(); // Recurse
          }
      }
      if (guests > 5) {
          extraGuestCount = guests - 5;
          extraGuestCharge = extraGuestCount * 600;
      }
  } 
  // STAY OPTION 2 & 3: Weekday (Up to 10 Guests) OR Weekend (Up to 10 Guests)
  else if (label.includes("Weekday (Up to 10 Guests)") || label.includes("Weekend")) {
      if (guests > 15) {
          if (guestError) {
              guestError.textContent = "Maximum capacity is 15 guests for this stay option";
              guestError.style.display = 'block';
          }
      }
      if (guests > 10) {
          extraGuestCount = Math.min(guests, 15) - 10;
          extraGuestCharge = extraGuestCount * 600;
      }
  }

  const dynamicBaseAmount = baseStayPrice + extraGuestCharge;

  document.getElementById('form-base-amount').value = dynamicBaseAmount;
  document.getElementById('form-event-type').value = label;
  document.getElementById('summary-base-price').textContent = `₹${baseStayPrice.toLocaleString()}`;

  const amenities       = buildAmenityPayload();
  const summaryList     = document.getElementById('summary-amenities-list');
  const summaryEmpty    = document.getElementById('summary-amenities-empty');
  const extraTotalElem  = document.getElementById('summary-extra-total');
  const grandTotalElem  = document.getElementById('summary-grand-total');
  const formExtraAmount = document.getElementById('form-extra-amount');
  const formAmount      = document.getElementById('form-amount');

  let extraTotal = 0;
  summaryList.querySelectorAll('.summary-item').forEach(el => el.remove());

  if (amenities.length === 0 && extraGuestCharge === 0) {
    summaryEmpty.style.display = 'block';
  } else {
    summaryEmpty.style.display = 'none';

    // Show Extra Guest Charge in Summary
    if (extraGuestCharge > 0) {
        const item = document.createElement('div');
        item.className = 'summary-item';
        item.style.cssText = 'margin-bottom:.65rem;font-size:.96rem;color:#e06828;font-weight:700;';
        item.textContent = `Extra Guests (${extraGuestCount} × ₹600) = ₹${extraGuestCharge.toLocaleString()}`;
        summaryList.appendChild(item);
    }

    amenities.forEach((a) => {
      extraTotal += a.total;
      const item = document.createElement('div');
      item.className = 'summary-item';
      item.style.cssText = 'margin-bottom:.65rem;font-size:.96rem;color:#334155;';
      item.textContent = a.pricing_type === 'per_person' && a.participants !== null
        ? `${a.name} (${a.participants} × ₹${a.price.toFixed(2)}) = ₹${a.total.toFixed(2)}`
        : `${a.name} = ₹${a.total.toFixed(2)}`;
      summaryList.appendChild(item);
    });
  }

  const grandTotal          = dynamicBaseAmount + extraTotal;
  formExtraAmount.value      = extraTotal.toFixed(2);
  formAmount.value           = grandTotal.toFixed(2);

  updateSidebarPreview();
}

/* ── Form submit ───────────────────────────────────────────────────────── */
async function handleBookingSubmit(event) {
  if(event) event.preventDefault();
  
  const form      = document.getElementById('bk-form');
  const msgBox    = document.getElementById('booking-msg');
  const formData  = new FormData(form);
  
  // Get the grand total including package
  const totalAmount = parseFloat(document.getElementById('form-amount').dataset.totalWithPackage) || parseFloat(formData.get('amount'));

  const payload = {
    name:         formData.get('name'),
    email:        formData.get('email'),
    phone:        formData.get('phone'),
    check_in:     formData.get('check_in'),
    check_out:    formData.get('check_out'),
    guests:       formData.get('guests'),
    property_id:  formData.get('property_id'),
    event_type:   formData.get('event_type'),
    package_name: formData.get('package_name'),
    base_amount:  parseFloat(formData.get('base_amount'))  || 0,
    extra_amount: parseFloat(formData.get('extra_amount')) || 0,
    amount:       totalAmount,
    amenities:    buildAmenityPayload()
  };

  // Close wizard modal
  const wizardModalEl = document.getElementById('bookingWizardModal');
  const wizardModal = bootstrap.Modal.getInstance(wizardModalEl);
  if(wizardModal) wizardModal.hide();

  // Show processing state on the main button
  const submitBtn = form.querySelector('.btn-book-submit');
  submitBtn.disabled  = true;
  submitBtn.innerText = 'Processing...';

  try {
    const response = await fetch(form.action, {
      method: 'POST',
      headers: {
        'Content-Type':  'application/json',
        'X-CSRF-TOKEN':  document.querySelector('meta[name="csrf-token"]').content,
        'Accept':        'application/json'
      },
      body: JSON.stringify(payload)
    });
    const json = await response.json();
    msgBox.style.display = 'block';

    if (json.success) {
      msgBox.style.cssText = 'display:block;background:#E8F5E9;color:#2E7D32;border:1px solid #A5D6A7;padding:1rem;border-radius:8px;margin-top:1rem;';
      msgBox.innerHTML = `<strong>Booking saved.</strong><br/>Launching secure Razorpay payment...`;
      initiatePayment({
        name: payload.name, email: payload.email, phone: payload.phone,
        propertyName: '{{ $property->name }}',
        amount: Math.round(payload.amount * 100)
      });
    } else {
      throw new Error(json.message || 'Booking failed');
    }
  } catch (error) {
    msgBox.style.cssText = 'display:block;background:#FFEBEE;color:#C62828;border:1px solid #FFCDD2;padding:1rem;border-radius:8px;margin-top:1rem;';
    msgBox.innerHTML = `<strong>Error!</strong><br/>${error.message || 'Please try again later or contact us through the chatbot.'}`;
  } finally {
    submitBtn.disabled  = false;
    submitBtn.innerText = 'PROCEED TO PAYMENT';
  }
}

/* ── Razorpay ──────────────────────────────────────────────────────────── */
function initiatePayment(data) {
  const msgBox = document.getElementById('booking-msg');
  try {
    new Razorpay({
      key:         '{{ config("services.razorpay.key") }}',
      amount:      data.amount || 500000,
      currency:    'INR',
      name:        'Parudeesa – The Lake View Resort',
      description: 'Booking Advance — ' + (data.propertyName || 'Parudeesa'),
      prefill:     { name: data.name || '', email: data.email || '', contact: data.phone || '' },
      theme:       { color: '#fa873e' },
      handler: function(res) {
        msgBox.style.cssText = 'display:block;background:#E8F5E9;color:#2E7D32;border:1px solid #A5D6A7;padding:1rem;border-radius:8px;margin-top:1rem;';
        msgBox.innerHTML = '✅ <strong>Payment successful!</strong><br/>Payment ID: ' + res.razorpay_payment_id + '<br/>Your booking is confirmed. Our team will contact you shortly.';
        document.getElementById('bk-form')?.reset();
      },
      modal: {
        ondismiss: function() {
          msgBox.style.cssText = 'display:block;background:#FFEBEE;color:#C62828;border:1px solid #FFCDD2;padding:1rem;border-radius:8px;margin-top:1rem;';
          msgBox.innerHTML = '<strong>Payment not completed.</strong><br/>Please retry or contact us for help.';
        }
      }
    }).open();
  } catch (err) {
    msgBox.style.cssText = 'display:block;background:#FFEBEE;color:#C62828;border:1px solid #FFCDD2;padding:1rem;border-radius:8px;margin-top:1rem;';
    msgBox.innerHTML = '<strong>Error:</strong> Razorpay checkout could not be opened. Please ensure HTTPS or try again.';
    console.error(err);
  }
}

/* ── Navbar scroll ── */
window.addEventListener('scroll', () => {
    document.getElementById('mainNav')?.classList.toggle('scrolled', window.scrollY > 50);
}, { passive: true });
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</body>
</html>
