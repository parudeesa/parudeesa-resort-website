<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"/>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<title>{{ $property->name }} – Luxury Details</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Outfit:wght@100..900&display=swap" rel="stylesheet"/>
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
    $heroImages = collect(array_merge([$property->image], $property->gallery_images ?? []))
        ->filter()
        ->map(fn($img) => str_starts_with($img, 'http') ? $img : asset($img))
        ->values()
        ->all();
    $heroImages = array_slice(count($heroImages) ? $heroImages : $fallbackHeroImages, 0, 5);
    $heroMain = $heroImages[0];
    $propertyPrice = $property->weekday_price ?: 8000;
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

    // Dynamic Food Packages
    $foodPackages = \App\Models\FoodPackage::where('status', true)->get();
    
    // Dynamic Settings
    $bookingSettings = [
        'check_in_time' => \App\Models\Setting::get('check_in_time', '02:00 PM'),
        'check_out_time' => \App\Models\Setting::get('check_out_time', '11:00 AM'),
        'water_activity_threshold' => (int) \App\Models\Setting::get('water_activity_threshold', 5),
        'water_activity_low' => (float) \App\Models\Setting::get('water_activity_low_price', 0),
        'water_activity_high' => (float) \App\Models\Setting::get('water_activity_high_price', 0),
        'property_stay_threshold' => (int) \App\Models\Setting::get('property_stay_threshold', 5),
        'yacht_capacity' => (int) ($yacht->capacity ?? 10),
        'yacht_price' => (float) ($yacht->price ?? 0),
        'sheesha_capacity' => (int) \App\Models\Setting::get('sheesha_capacity', 6),
        'cancellation_policy' => \App\Models\Setting::get('cancellation_policy', 'Free cancellation up to 48 hours before check-in.'),
    ];

    // Sync yacht amenity price if it exists
    if ($yachtAmenity && isset($yacht)) {
        $yachtAmenity->price = $yacht->price;
    }
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
  --font-sans: 'Outfit', sans-serif;
  --font-body: 'Outfit', sans-serif;
}

*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth;-webkit-text-size-adjust:100%}
body{font-family:var(--font-sans);background:var(--bg-ivory);color:var(--text-dark);overflow-x:hidden;-webkit-font-smoothing:antialiased;line-height:1.8;font-weight: 300;letter-spacing: 0.01em;}
h1,h2,h3,h4,h5{font-family:var(--font-serif);color:var(--text-dark);line-height:1.2}


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
@media (max-width: 991px) {
    .exp-grid {
        grid-template-columns: 1fr;
    }
}
.exp-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(62, 32, 16, 0.04);
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    border: 1px solid rgba(250, 135, 62, 0.08);
    display: flex;
    flex-direction: column;
    height: 100%;
}
.exp-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(62, 32, 16, 0.08);
    border-color: rgba(250, 135, 62, 0.2);
}
.exp-img-box {
    position: relative;
    width: 100%;
    height: 180px;
    overflow: hidden;
}
.exp-img-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.8s ease;
}
.exp-card:hover .exp-img-box img {
    transform: scale(1.08);
}
.exp-body {
    padding: 1.25rem;
    display: flex;
    flex-direction: column;
    flex: 1;
}
.exp-title {
    font-family: var(--font-serif);
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.35rem;
    line-height: 1.2;
}
.exp-price {
    font-family: var(--font-sans);
    font-size: 1.05rem;
    font-weight: 800;
    color: #fa873e;
    margin-bottom: 0.6rem;
}
.exp-desc {
    font-family: var(--font-sans);
    font-size: 0.78rem;
    color: var(--text-dark);
    opacity: 0.7;
    margin-bottom: 0.75rem;
    line-height: 1.4;
    flex: 0 0 auto;
}
.btn-add-exp {
    align-self: flex-start;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.6rem;
    background: linear-gradient(135deg, #fa873e, #e06828);
    color: #fff;
    border: none;
    border-radius: 50px;
    font-family: var(--font-sans);
    font-size: 0.75rem;
    font-weight: 800;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 6px 15px rgba(250, 135, 62, 0.15);
}
.btn-add-exp:hover {
    background: linear-gradient(135deg, #e06828, #c7561d);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(250, 135, 62, 0.25);
    color: #fff;
}
.btn-add-exp.is-added {
    background: #3b2a22;
    box-shadow: none;
}
.btn-add-exp i {
    font-size: 0.9rem;
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
    color: rgba(255, 243, 236, .4);
}
.footer-social .fs-link {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.05);
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(255, 243, 236, 0.7);
    font-size: 1.1rem;
    transition: all var(--ease);
    border: 1px solid rgba(255, 255, 255, 0.1);
}
.footer-social .fs-link:hover {
    background: var(--brand);
    color: #fff;
    transform: translateY(-3px);
    border-color: var(--brand);
}
.footer-contact {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
}
.footer-contact-item {
    display: flex;
    align-items: center;
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

.section-divider {
    height: 1px;
    background: linear-gradient(to right, transparent, rgba(250,135,62,0.15), transparent);
    margin: 2.5rem 0;
}
.stay-option-card.is-selected {
  border-color: #fa873e;
  background: #fffaf7;
  box-shadow: 0 4px 15px rgba(250, 135, 62, 0.1);
}
.stay-option-card {
  transition: all var(--ease);
}
@keyframes shake {
  0%, 100% { transform: translateX(0); }
  25% { transform: translateX(-4px); }
  75% { transform: translateX(4px); }
}
/* LUXURY YACHT REDESIGN - LIGHT THEME */
.yacht-experience-wrap {
    margin: 3.5rem 0;
    position: relative;
    z-index: 1;
}

.luxury-yacht-banner {
    background: #fff;
    border-radius: 24px;
    overflow: hidden;
    position: relative;
    display: flex;
    flex-wrap: wrap;
    box-shadow: var(--shadow-soft);
    border: 1px solid rgba(250, 135, 62, 0.15);
}

.yacht-image-side {
    flex: 1;
    min-width: 350px;
    min-height: 300px;
    position: relative;
    overflow: hidden;
}

@media (max-width: 991px) {
    .yacht-image-side { min-width: 100%; min-height: 250px; }
}

.yacht-image-side img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 10s ease;
}

.luxury-yacht-banner:hover .yacht-image-side img {
    transform: scale(1.08);
}

.yacht-image-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, transparent 50%, rgba(255,255,255,0.05) 100%);
}

.yacht-content-side {
    flex: 1.2;
    min-width: 300px;
    padding: 2.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    color: var(--text-dark);
    position: relative;
    z-index: 2;
    background: var(--bg-beige);
}

@media (max-width: 768px) {
    .yacht-content-side { padding: 1.8rem; min-width: 100%; }
}

.exclusive-label {
    display: inline-flex;
    align-items: center;
    gap: 0.8rem;
    font-size: 0.65rem;
    font-weight: 700;
    color: var(--brand);
    letter-spacing: 0.2em;
    text-transform: uppercase;
    margin-bottom: 1.2rem;
}

.exclusive-label::after {
    content: '';
    width: 30px;
    height: 1px;
    background: var(--brand);
}

.yacht-main-title {
    font-family: var(--font-serif);
    font-size: clamp(1.8rem, 3vw, 2.2rem);
    line-height: 1.2;
    margin-bottom: 1rem;
    font-weight: 700;
    color: var(--text-dark);
}

.yacht-main-title em {
    color: var(--brand);
    font-style: italic;
}

.yacht-description {
    font-size: 0.9rem;
    color: var(--text-muted);
    line-height: 1.6;
    margin-bottom: 2rem;
    font-weight: 400;
}

.yacht-spec-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.2rem;
    margin-bottom: 2.5rem;
}

@media (max-width: 480px) {
    .yacht-spec-grid { grid-template-columns: 1fr; gap: 1rem; }
}

.yacht-spec-item {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    background: #fff;
    padding: 0.8rem;
    border-radius: 12px;
    border: 1px solid rgba(250, 135, 62, 0.1);
}

.yacht-spec-icon {
    width: 36px;
    height: 36px;
    background: var(--gold-light);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--brand);
    font-size: 1.1rem;
    flex-shrink: 0;
}

.yacht-spec-info .label {
    display: block;
    font-size: 0.6rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--text-muted);
    margin-bottom: 0.1rem;
}

.yacht-spec-info .value {
    display: block;
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--text-dark);
}

.yacht-cta-block {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    flex-wrap: wrap;
    border-top: 1px solid rgba(250, 135, 62, 0.1);
    padding-top: 1.5rem;
}

.yacht-price-display .price-label {
    display: block;
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--text-muted);
    margin-bottom: 0.2rem;
}

.yacht-price-display .price-amt {
    font-family: var(--font-serif);
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--brand-d);
}

.btn-book-yacht-luxury {
    background: var(--text-dark);
    color: #fff;
    border: none;
    padding: 1rem 2rem;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.btn-book-yacht-luxury:hover {
    background: var(--brand);
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(250, 135, 62, 0.2);
}

.yacht-subtitle {
    font-family: var(--font-sans);
    font-size: 0.95rem;
    color: var(--text-muted);
    margin-bottom: 2rem;
    font-weight: 500;
}

.floating-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(5px);
    border: 1px solid var(--gold-light);
    padding: 0.6rem 1.2rem;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

.floating-badge span {
    display: block;
    font-size: 0.55rem;
    letter-spacing: 0.15em;
    color: var(--text-muted);
    text-transform: uppercase;
}

.floating-badge strong {
    display: block;
    font-size: 0.9rem;
    color: var(--brand);
    font-family: var(--font-serif);
}
    .location-map-card {
        background: #fff;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-soft);
        border: 1px solid rgba(250, 135, 62, 0.1);
        transition: all var(--ease);
        cursor: pointer;
        text-decoration: none !important;
        display: block;
        margin-top: 2rem;
        position: relative;
    }
    .location-map-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
        border-color: var(--gold);
    }
    .map-preview-container {
        position: relative;
        width: 100%;
        height: 280px;
        overflow: hidden;
    }
    .map-preview-container::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.4));
        z-index: 1;
    }
    .map-preview-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 1.2s ease;
    }
    .location-map-card:hover .map-preview-img {
        transform: scale(1.05);
    }
    .map-overlay-badge {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(255, 255, 255, 0.95);
        padding: 0.8rem 1.8rem;
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        z-index: 5;
        transition: all 0.3s ease;
    }
    .map-overlay-badge i {
        color: var(--brand);
        font-size: 1.2rem;
    }
    .map-overlay-badge span {
        font-family: var(--font-sans);
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--brand-d);
    }
    .location-map-card:hover .map-overlay-badge {
        background: var(--brand);
        transform: translate(-50%, -50%) scale(1.05);
    }
    .location-map-card:hover .map-overlay-badge span,
    .location-map-card:hover .map-overlay-badge i {
        color: #fff;
    }
    .map-info-body {
        padding: 1.2rem 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
        text-align: left;
        background: #fff;
    }
    .map-title {
        font-family: var(--font-serif);
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }
    .map-address {
        font-size: 0.85rem;
        color: var(--text-muted);
        line-height: 1.4;
        font-weight: 400;
    }
</style>
</head>
<body>

    <!-- ██ NAVBAR ██ -->
    <x-navbar :isHome="false" />

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
          {{ $property->description }}
        </p>
        <h2 class="section-title mt-4">Highlights</h2>
        <div class="highlight-grid">
          @foreach($highlights as $item)
          <div class="highlight-card reveal">
            <div class="highlight-img-box">
              @if(isset($item['image']) && $item['image'])
                <img src="{{ str_starts_with($item['image'], 'http') ? $item['image'] : asset($item['image']) }}" alt="{{ $item['label'] }}" loading="lazy">
              @elseif(isset($item['icon']) && $item['icon'])
                <div class="w-100 h-100 d-flex align-items-center justify-center bg-orange-50 text-orange-500 fs-2">
                    <i class="bi {{ $item['icon'] }}"></i>
                </div>
              @else
                <img src="{{ asset('images/highlights/default.png') }}" alt="{{ $item['label'] }}" loading="lazy">
              @endif
            </div>
            <div class="highlight-body">
              <h3 class="highlight-title">{{ $item['label'] }}</h3>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <div class="content-section reveal mx-auto" style="max-width:1400px">
        <h2 class="section-title">Accommodation and Outdoor Spaces</h2>
        <div class="icon-card-grid">
          @if($property->accommodation)
            @foreach($property->accommodation as $item)
              <div class="icon-card">
                <div class="ic-icon"><i class="bi bi-houses-fill"></i></div>
                <div class="ic-content"><div class="ic-title">{{ $item }}</div></div>
              </div>
            @endforeach
          @endif

          @if($property->outdoor_spaces)
            @foreach($property->outdoor_spaces as $item)
              <div class="icon-card">
                <div class="ic-icon"><i class="bi bi-tree-fill"></i></div>
                <div class="ic-content"><div class="ic-title">{{ $item }}</div></div>
              </div>
            @endforeach
          @endif
        </div>
      </div>

      <div class="content-section reveal">
        <h2 class="section-title">Experiences and Add-ons</h2>

        <div class="exp-grid">
          @foreach($amenities as $amenity)
            @if(!str_contains(strtolower($amenity->name), 'yacht'))
            <div class="exp-card">
              <div class="exp-img-box">
                @php
                  $keyword = strtolower($amenity->name);
                  $fallbackImg = 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=600&q=80';
                  if(str_contains($keyword, 'campfire')) $fallbackImg = 'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?w=600&q=80';
                  if(str_contains($keyword, 'speaker')) $fallbackImg = 'https://images.unsplash.com/photo-1545127398-14699f92334b?w=600&q=80';
                  if(str_contains($keyword, 'kayak')) $fallbackImg = 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=600&q=80';
                  if(str_contains($keyword, 'sheesha') || str_contains($keyword, 'shisha')) $fallbackImg = 'https://images.unsplash.com/photo-1516715105260-7a5611666687?w=600&q=80';
                @endphp
                <img src="{{ str_starts_with($amenity->image, 'http') ? $amenity->image : asset($amenity->image) }}" alt="{{ $amenity->name }}" class="img-fluid rounded-4">
              </div>
                <div class="exp-body">
                  <div class="exp-title">{{ $amenity->name }}</div>
                  @php
                    $nameLower = strtolower($amenity->name);
                    $fallbackDesc = 'Enhance your stay with this premium experience.';
                    
                    if(str_contains($nameLower, 'kayaking') || str_contains($nameLower, 'boating')) $fallbackDesc = 'Refreshments will be provided during the activity.';
                    elseif(str_contains($nameLower, 'speaker') || str_contains($nameLower, 'jbl')) $fallbackDesc = 'High-volume sound usage is allowed only until 10 PM. After that, volume should be reduced.';
                    elseif(str_contains($nameLower, 'campfire') || str_contains($nameLower, 'camp fire')) $fallbackDesc = 'In case of unfavorable circumstances, refunds will not be provided.';
                    elseif(str_contains($nameLower, 'sheesha') || str_contains($nameLower, 'shisha')) $fallbackDesc = 'Only 6 sheesha units are available at a time.';
                    
                    $displayDesc = $amenity->description ?: $fallbackDesc;
                  @endphp
                  <p class="exp-desc">{{ $displayDesc }}</p>
                  
                  <div class="exp-price">
                    @if(str_contains(strtolower($amenity->name), 'kayaking') || str_contains(strtolower($amenity->name), 'boating'))
                      <span class="kayak-price-display">₹{{ number_format($bookingSettings['water_activity_high'], 0) }}/p</span>
                    @elseif($amenity->price > 0)
                      ₹{{ number_format($amenity->price, 0) }}
                    @else
                      Premium Add-on
                    @endif
                  </div>

                  <div style="flex: 1;"></div> <!-- Spacer to push button down -->
                  
                  <button class="btn-add-exp" onclick="openAddonModal('{{ strtolower($amenity->name) }}', '{{ $amenity->name }}')">
                    <i class="bi bi-plus"></i> ADD
                  </button>
                </div>
            </div>
            @endif
          @endforeach
        </div>
      </div>

      @if($yachtAmenity)
      <div class="yacht-experience-wrap reveal">
        <div class="luxury-yacht-banner">
            <div class="yacht-image-side">
                <img src="{{ str_starts_with($yachtAmenity->image, 'http') ? $yachtAmenity->image : asset($yachtAmenity->image) }}" alt="{{ $yachtAmenity->name }}">
                <div class="yacht-image-overlay"></div>
                
                <div class="floating-badge">
                    <span>Exclusive</span>
                    <strong>Private Hire</strong>
                </div>
            </div>
            
            <div class="yacht-content-side">
                <div class="exclusive-label">Luxury Experience</div>
                <h2 class="yacht-main-title">
                    Indulge in the <br><em>Yacht</em> Lifestyle
                </h2>
                
                <p class="yacht-subtitle">
                    Premium yacht add-on
                </p>
                
                <div class="yacht-spec-grid">
                    <div class="yacht-spec-item">
                        <div class="yacht-spec-icon">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div class="yacht-spec-info">
                            <span class="label">Duration</span>
                            <span class="value">5 Hours</span>
                        </div>
                    </div>
                    <div class="yacht-spec-item">
                        <div class="yacht-spec-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="yacht-spec-info">
                            <span class="label">Capacity</span>
                            <span class="value">Up to 10 People</span>
                        </div>
                    </div>
                </div>
                
                <div class="yacht-cta-block">
                    <div class="yacht-price-display">
                        <span class="price-label">Fixed Rate</span>
                        <div class="yacht-price-amt" style="font-family: var(--font-sans); font-weight: 600; color: #5a5a5a; font-size: 1.4rem;">₹{{ number_format($yachtAmenity->price, 0) }}</div>
                    </div>
                    
                    <button class="btn-book-yacht-luxury" onclick="openAddonModal('{{ strtolower($yachtAmenity->name) }}', '{{ $yachtAmenity->name }}')">
                        ADD TO BOOKING
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
          <a href="{{ route('events') }}#inquiry" class="btn-premium mt-3">
            Request Custom Event Package
          </a>
        </div>
      </div>

      @if(trim($property->name) === 'Parudeesa The Paradise')
      <div class="content-section reveal mx-auto" style="max-width: 900px; margin-top: 4rem;">
        <h2 class="section-title">Location & Directions</h2>
        <a href="https://www.google.com/maps/dir/Parudeesa+:+The+Lakeview+Resort,+Vettussery+lane,+Boat+Jetty+Road,+Vaduthala,+Ernakulam,+Kerala+682023/Parudeesa+:+The+Lakeview+Resort,+Vettussery+lane,+Boat+Jetty+Road,+Vaduthala,+Ernakulam,+Kerala+682023/@10.0268974,76.2646621,17z/data=!3m1!4b1!4m13!4m12!1m5!1m1!1s0x3b0813e12fe49c39:0x81371c194e5f7846!2m2!1d76.267237!2d10.0268921!1m5!1m1!1s0x3b0813e12fe49c39:0x81371c194e5f7846!2m2!1d76.267237!2d10.0268921?entry=ttu&g_ep=EgoyMDI2MDUwNi4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="location-map-card">
            <div class="map-preview-container">
                <img src="{{ asset('images/luxury_resort_banner.png') }}" alt="{{ $property->name }} Resort View" class="map-preview-img">
                <div class="map-overlay-badge">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>View on Maps</span>
                </div>
            </div>
            <div class="map-info-body">
                <h3 class="map-title">{{ $property->name }}</h3>
                <p class="map-address">Vettussery lane, Vaduthala, Ernakulam, Kerala 682023</p>
            </div>
        </a>
      </div>
      @endif

      <div class="content-section reveal mx-auto" style="max-width:1400px; margin-top: {{ trim($property->name) === 'Parudeesa The Paradise' ? '0' : '4rem' }};">
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
          {{-- 1. Pricing Options (STATIC) --}}
          <div style="background: rgba(250,135,62,0.05); border: 1px solid rgba(250,135,62,0.15); border-radius: 16px; padding: 1.5rem; margin-bottom: 2rem;">
            <div style="font-family:var(--font-sans);font-size:.75rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--brand-d);margin-bottom:1.2rem; display: flex; align-items: center; gap: 0.5rem;">
              <i class="bi bi-info-circle"></i> STAY RATES
            </div>
            <div class="pricing-options-grid" style="display: flex; flex-direction: column; gap: 0.85rem;">
              <div id="rate-weekday" style="padding: 1rem 1.25rem; border-radius: 12px; background: #fff; border: 1px solid rgba(250,135,62,0.1); display: flex; justify-content: space-between; align-items: center; transition: all 0.3s ease;">
                <div style="font-weight: 600; color: var(--text-dark); font-size: 0.9rem;">Weekday <span style="color: var(--text-muted); font-weight: 400; font-size: 0.8rem;">(Up to 5 Guests)</span></div>
                <div style="font-weight: 800; color: var(--gold); font-size: 1rem;">₹{{ number_format($property->weekday_price ?: $property->price, 0) }}</div>
              </div>
              <div id="rate-weekday-tier2" style="padding: 1rem 1.25rem; border-radius: 12px; background: #fff; border: 1px solid rgba(250,135,62,0.1); display: flex; justify-content: space-between; align-items: center; transition: all 0.3s ease;">
                <div style="font-weight: 600; color: var(--text-dark); font-size: 0.9rem;">Weekday <span style="color: var(--text-muted); font-weight: 400; font-size: 0.8rem;">(Up to 10 Guests)</span></div>
                <div style="font-weight: 800; color: var(--gold); font-size: 1rem;">₹{{ number_format($property->weekday_tier2_price ?: ($property->weekday_price ?: $property->price), 0) }}</div>
              </div>
              <div id="rate-weekend" style="padding: 1rem 1.25rem; border-radius: 12px; background: #fff; border: 1px solid rgba(250,135,62,0.1); display: flex; justify-content: space-between; align-items: center; transition: all 0.3s ease;">
                <div style="font-weight: 600; color: var(--text-dark); font-size: 0.9rem;">Weekend <span style="color: var(--text-muted); font-weight: 400; font-size: 0.8rem;">(Up to 10 Guests)</span></div>
                <div style="font-weight: 800; color: var(--gold); font-size: 1rem;">₹{{ number_format($property->weekend_price ?: $property->price, 0) }}</div>
              </div>
            </div>
          </div>

          {{-- 2. BOOK VIA CHATBOT Button --}}
          <div class="text-center mb-4">
            <a href="#" onclick="toggleChatbot(); return false;" class="btn-wa-alt d-inline-flex justify-content-center align-items-center" style="background: linear-gradient(135deg, #25D366, #1aa854); color: #fff; padding: 0.5rem 1.5rem; font-size: 0.85rem; border-radius: 30px; width: auto; gap: 0.5rem; border: none; box-shadow: 0 4px 15px rgba(37, 211, 102, 0.25);">
  <i class="bi bi-robot"></i> BOOK VIA CHATBOT
</a>
          </div>

          <div style="height: 1px; background: linear-gradient(to right, transparent, rgba(250,135,62,0.2), transparent); margin: 2rem 0;"></div>

          <form action="{{ route('bookings.store') }}" method="POST" id="bk-form">
            @csrf
            <input type="hidden" name="property_id"  value="{{ $property->id }}" />
            <input type="hidden" name="amount"        id="form-amount"       value="0" />
            <input type="hidden" name="extra_amount"  id="form-extra-amount" value="0" />
            <input type="hidden" name="base_amount"   id="form-base-amount"  value="0" />
            <input type="hidden" name="package_name"  id="form-package-name" value="Only Stay" />
            <input type="hidden" name="event_type"    id="form-event-type"   value="" />
            <input type="hidden" name="coupon_id"      id="form-coupon-id"    value="" />
            <input type="hidden" name="discount_amount" id="form-discount-amount" value="0" />

            <!-- Sidebar Form Content (Always Visible) -->
            <div id="booking-details-sidebar">
              <div style="font-family:var(--font-serif); font-size: 1.4rem; font-weight: 700; color: var(--text-dark); margin-bottom: 1.5rem; text-align: center;">Book Your Stay</div>
              
              <div class="form-row">
                <div class="mb-3">
                    <label class="p-label" style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.4rem; display: block;">Check-in Date</label>
                    <input type="text"   class="bk-input" id="checkin"  name="check_in"  placeholder="Select Date"  required />
                </div>
                <div class="mb-3">
                    <label class="p-label" style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.4rem; display: block;">Check-out Date</label>
                    <input type="text"   class="bk-input" id="checkout" name="check_out" placeholder="Select Date" required />
                </div>
              </div>
              
              <div class="form-row">
                <div class="mb-3" style="position: relative;">
                    <label class="p-label" style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.4rem; display: block;">Name</label>
                    <input type="text" class="bk-input" id="bk-name" name="name" placeholder="Full Name" required minlength="3" pattern="[A-Za-z\s]+" title="Name should only contain letters." />
                    <div class="error-msg" id="err-name" style="color:#C62828;font-size:0.7rem;margin-top:-0.8rem;margin-bottom:0.8rem;display:none;font-weight:700;">Name is required (min 3 letters, no numbers)</div>
                </div>
                <div class="mb-3" style="position: relative;">
                    <label class="p-label" style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.4rem; display: block;">Phone Number</label>
                    <input type="tel" class="bk-input" id="bk-phone" name="phone" placeholder="10-digit Number" required pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" />
                    <div class="error-msg" id="err-phone" style="color:#C62828;font-size:0.7rem;margin-top:-0.8rem;margin-bottom:0.8rem;display:none;font-weight:700;">Phone number must contain exactly 10 digits.</div>
                </div>
              </div>

              <div class="form-row">
                <div class="mb-3" style="position: relative;">
                    <label class="p-label" style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.4rem; display: block;">Number of Guests</label>
                    <input type="number" class="bk-input" name="guests" id="guests-input" placeholder="Total Guests" min="1" required />
                    <div id="guest-error" style="color:#C62828;font-size:0.7rem;margin-top:-0.8rem;margin-bottom:0.8rem;display:none;font-weight:700;line-height:1.2;"></div>
                </div>
                <div class="mb-3" style="position: relative;">
                    <label class="p-label" style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.4rem; display: block;">Number of Pets <span style="font-size: 0.6rem; color: var(--text-muted); font-weight: 400;">(Optional)</span></label>
                    <input type="number" class="bk-input" name="pets" placeholder="No. of Pets" min="0" />
                </div>
              </div>

              {{-- Amenities --}}
              <div style="margin-bottom:1.5rem;">
                <div style="font-family:var(--font-sans);font-size:.75rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:var(--text-muted);margin-bottom:.85rem;">
                  Select Amenities
                </div>
                <div id="amenities-list" style="display:flex;flex-direction:column;gap:0.6rem; margin-bottom:1.5rem;">
                  @forelse($amenities as $amenity)
                  <div class="amenity-card" style="transition: all 0.3s ease; display: flex; flex-direction: column; gap: 0.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; width: 100%;">
                      <label class="amenity-label" style="margin: 0; font-weight: 600; color: var(--text-dark); font-size: 0.85rem; cursor: pointer; display: flex; align-items: flex-start; gap: 0.8rem; flex: 1; padding-top: 2px;">
                        <input type="checkbox" class="amenity-selector" 
                               data-amenity-id="{{ $amenity->id }}" 
                               data-amenity-name="{{ $amenity->name }}" 
                               data-amenity-price="{{ $amenity->price }}"
                               data-amenity-type="{{ (str_contains(strtolower($amenity->name), 'sheesha') || str_contains(strtolower($amenity->name), 'kayak')) ? 'per_person' : $amenity->pricing_type }}"
                               name="amenities[{{ $amenity->id }}][selected]" value="1"
                               style="width: 1rem; height: 1rem; accent-color: var(--brand); margin-top: 2px;">
                        <div style="display: flex; flex-direction: column; gap: 2px;">
                            <span style="line-height: 1.4; font-weight: 700; font-size: 0.9rem;">{{ $amenity->name }}</span>
                            @if(str_contains(strtolower($amenity->name), 'kayaking') || str_contains(strtolower($amenity->name), 'boating'))
                                <span style="font-size: 0.68rem; color: var(--text-muted); opacity: 0.7; font-weight: 500; letter-spacing: 0.01em;">
                                    &lt;{{ $bookingSettings['water_activity_threshold'] }} Guests: ₹{{ number_format($bookingSettings['water_activity_low'], 0) }}/p | {{ $bookingSettings['water_activity_threshold'] }}+ Guests: ₹{{ number_format($bookingSettings['water_activity_high'], 0) }}/p
                                </span>
                            @endif
                        </div>
                      </label>
                      
                      <div class="dynamic-amenity-price" data-amenity-base-price="{{ $amenity->price }}" style="font-weight: 800; color: #fa873e; font-size: 0.95rem; text-align: right; white-space: nowrap;">
                          @if(str_contains(strtolower($amenity->name), 'kayaking') || str_contains(strtolower($amenity->name), 'boating'))
                              ₹{{ number_format($bookingSettings['water_activity_high'], 0) }}
                          @else
                              ₹{{ number_format($amenity->price, 0) }}
                          @endif
                      </div>
                    </div>

                    @php
                      $amenityNameLower = strtolower($amenity->name);
                      $isPerPerson = (str_contains($amenityNameLower, 'sheesha') || str_contains($amenityNameLower, 'kayak') || str_contains($amenityNameLower, 'boating') || $amenity->pricing_type === 'per_person');
                      $isAutoGuest = (str_contains($amenityNameLower, 'campfire') || str_contains($amenityNameLower, 'camp fire') || str_contains($amenityNameLower, 'speaker') || str_contains($amenityNameLower, 'yacht'));
                    @endphp

                    @if($isPerPerson && !$isAutoGuest)
                    <div class="amenity-participants" style="display:none; opacity: 0; transform: translateY(-5px); transition: all 0.3s ease; width: 100%; border-top: 1px dashed rgba(250,135,62,0.15); margin-top: 4px; padding-top: 8px;">
                       <div style="display: flex; justify-content: flex-end; align-items: center; gap: 10px;">
                         <span style="font-size: 0.7rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Guests</span>
                         <div class="counter-wrap" style="height: 28px; border-radius: 8px; background: #fff; border: 1px solid rgba(250,135,62,0.25); display: flex; align-items: center; overflow: hidden;">
                           <button type="button" class="counter-btn minus-btn" style="width: 28px; height: 28px; font-size: 1rem; background: #fff3ec; border: none; color: #e06828; font-weight: 700; cursor: pointer;" disabled>−</button>
                           <input type="number" class="counter-input amenity-participants-input" name="amenities[{{ $amenity->id }}][participants]" value="1" min="1" readonly style="width: 32px; height: 28px; font-size: 0.85rem; border: none; background: transparent; text-align: center; font-weight: 700; color: var(--text-dark); outline: none;">
                           <button type="button" class="counter-btn plus-btn" style="width: 28px; height: 28px; font-size: 1rem; background: #fff3ec; border: none; color: #e06828; font-weight: 700; cursor: pointer;">+</button>
                         </div>
                       </div>
                    </div>
                    @else
                      <input type="hidden" class="counter-input" name="amenities[{{ $amenity->id }}][participants]" value="1" />
                    @endif
                  </div>
                  @empty
                  <div style="font-size:.8rem;color:var(--text-muted); text-align: center; padding: 1rem;">No amenities available.</div>
                  @endforelse
                </div>

                <div id="selected-amenities-preview" style="padding: 1rem 0;">
                  <div id="preview-items-list" style="display:flex; flex-direction:column; gap:0.6rem;"></div>
                </div>

                <div id="sidebar-total-display" style="margin-top: 1rem; padding: 1.25rem; background: rgba(250,135,62,0.05); border-radius: 12px; border: 1px solid rgba(250,135,62,0.15);">
                  <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-dark); text-transform: uppercase; letter-spacing: 0.05em;">Total Payable</span>
                    <span id="sidebar-grand-total" style="font-size: 1.4rem; font-weight: 900; color: var(--gold);">₹0</span>
                  </div>
                </div>
              </div>

              <button type="button" class="btn-book-submit" style="margin-top:1.5rem;" onclick="openBookingWizard()">CONFIRM BOOKING</button>
            </div>

            {{-- Enquiry Section --}}
            <div id="enquiry-section" class="contact-panel" style="margin-top:2.5rem; padding-top:2rem; border-top:1px solid rgba(250,135,62,0.15); text-align:center;">
              <div style="font-weight:700; font-size: 0.9rem; color:var(--text-dark); margin-bottom:0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">For more enquiries</div>
              <a href="{{ route('home') }}#about" class="btn-outline-premium justify-content-center" style="display:inline-flex; text-decoration:none; padding: 0.7rem 2rem; font-size: 0.8rem; border-radius: 50px; border: 1.5px solid var(--brand); color: var(--brand-d); font-weight: 700; transition: all 0.3s ease; width: auto;">CONTACT US</a>
            </div>

            <div id="booking-msg" style="display:none;margin-top:1.5rem;padding:1rem;border-radius:var(--radius-sm);font-size:.9rem;text-align:center"></div>
          </form>

        </div>
      </div>
    </div>

  </div>
</div>


  <x-footer :isHome="false" />

  <!-- ████ Booking Wizard Modal ████ -->
  <div class="modal fade" id="bookingWizardModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
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
              @foreach($foodPackages as $index => $pkg)
              <label class="amenity-card stay-option-card {{ $index === 0 ? 'is-selected' : '' }}" style="cursor: pointer; border-radius: 16px; padding: 1.25rem; transition: all 0.3s ease;">
                <input type="radio" name="wizard_package_option" value="{{ (float)$pkg->price }}" data-name="{{ $pkg->name }}" {{ $index === 0 ? 'checked' : '' }} style="display: none;">
                <div class="d-flex justify-content-between align-items-center w-100">
                  <div style="display: flex; align-items: center; gap: 1rem;">
                    <div class="package-icon" style="width: 45px; height: 45px; border-radius: 12px; background: rgba(250,135,62,0.1); display: flex; align-items: center; justify-content: center; color: var(--gold); font-size: 1.25rem;">
                      @if(str_contains(strtolower($pkg->name), 'only'))
                        <i class="bi bi-house-door-fill"></i>
                      @elseif(str_contains(strtolower($pkg->name), 'breakfast'))
                        <i class="bi bi-cup-hot-fill"></i>
                      @else
                        <i class="bi bi-moon-stars-fill"></i>
                      @endif
                    </div>
                    <div style="font-weight: 700; color: var(--text-dark); font-size: 1rem;">{{ $pkg->name }}</div>
                  </div>
                  <div class="package-price-val" style="font-weight: 800; color: var(--gold); font-size: 1.1rem; white-space: nowrap;">
                    @if($pkg->price > 0)
                      + ₹{{ number_format($pkg->price, 0) }} / person
                    @else
                      Included
                    @endif
                  </div>
                </div>
              </label>
              @endforeach
            </div>

            <div id="wizard-step-1-total-box" class="mb-4 p-3 rounded-4" style="background: rgba(250,135,62,0.05); border: 1px solid rgba(250,135,62,0.15);">
              <div class="d-flex justify-content-between align-items-center">
                <span style="font-size: 0.9rem; font-weight: 700; color: var(--text-dark); text-transform: uppercase; letter-spacing: 0.05em;">Total Amount</span>
                <span id="wizard-step-1-total-val" style="font-size: 1.4rem; font-weight: 900; color: var(--gold);">₹0</span>
              </div>
            </div>
            <button type="button" class="btn-book-submit w-100" onclick="wizardGoToStep(2)">Continue to Summary</button>
          </div>

          <!-- Wizard Step 2: Booking Summary -->
          <div id="wizard-step-2" style="display:none;">
            <div class="summary-details p-4 rounded-4" style="background:var(--bg-beige); border:1px solid rgba(250,135,62,.12);">
              
              <!-- Guest Info Section -->
              <div style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--gold); margin-bottom: 1rem; letter-spacing: 0.1em;">Guest Information</div>
              <div class="d-flex justify-content-between mb-2">
                <span style="color:var(--text-muted); font-size:0.9rem;">Name:</span>
                <span id="wizard-summary-name" style="font-weight:700; color:var(--text-dark);"></span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span style="color:var(--text-muted); font-size:0.9rem;">Phone:</span>
                <span id="wizard-summary-phone" style="font-weight:700; color:var(--text-dark);"></span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span style="color:var(--text-muted); font-size:0.9rem;">Guests:</span>
                <span id="wizard-summary-guests" style="font-weight:700; color:var(--text-dark);"></span>
              </div>
              <div id="wizard-summary-pets-row" class="d-flex justify-content-between mb-3 pb-3 border-bottom" style="border-color:rgba(250,135,62,.1) !important; display: none;">
                <span style="color:var(--text-muted); font-size:0.9rem;">Pets:</span>
                <span id="wizard-summary-pets" style="font-weight:700; color:var(--text-dark);"></span>
              </div>

              <!-- Booking Info Section -->
              <div style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--gold); margin-bottom: 1rem; margin-top: 1.5rem; letter-spacing: 0.1em;">Stay Details</div>
              <div class="d-flex justify-content-between mb-2">
                <span style="color:var(--text-muted); font-size:0.9rem;">Stay Type:</span>
                <span id="wizard-summary-stay-type" style="font-weight:700; color:var(--text-dark);"></span>
              </div>
              <div class="d-flex justify-content-between mb-3 pb-3 border-bottom" style="border-color:rgba(250,135,62,.1) !important;">
                <span style="color:var(--text-muted); font-size:0.9rem;">Package:</span>
                <span id="wizard-summary-package" style="font-weight:700; color:var(--gold);"></span>
              </div>
              
              <!-- Cost Breakdown Section -->
              <div style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--gold); margin-bottom: 1rem; margin-top: 1.5rem; letter-spacing: 0.1em;">Price Breakdown</div>
              <div id="wizard-summary-cost-items" class="mb-3"></div>

              {{-- Coupon Section in Wizard --}}
              <div class="coupon-wizard-section mb-3 p-3 rounded-3" style="background:#fff; border:1px dashed var(--gold);">
                  <div style="font-size:0.7rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:0.5rem;">Have a coupon?</div>
                  <div class="d-flex gap-2">
                      <input type="text" id="wizard_coupon_code" placeholder="Enter code" class="form-control form-control-sm" style="border-color:var(--gold-light);">
                      <button type="button" id="wizard_apply_btn" class="btn btn-sm btn-premium py-1 px-3" onclick="applyWizardCoupon()" style="box-shadow:none; font-size:0.75rem;">Apply</button>
                      <button type="button" id="wizard_remove_btn" class="btn btn-sm btn-outline-secondary py-1 px-3" onclick="resetWizardCoupon()" style="display:none; font-size:0.75rem; border-radius:50px;">Remove</button>
                  </div>
                  <div id="wizard_coupon_msg" style="font-size:0.7rem; margin-top:5px; display:none;"></div>
                  
                  <div class="mt-2" id="wizard_available_coupons">
                      <div style="font-size:0.65rem; color:var(--text-muted); margin-bottom:3px; font-weight: 600;">Available Offers:</div>
                      <div class="d-flex flex-wrap gap-2">
                          @foreach($activeCoupons as $c)
                          <span class="badge bg-white text-orange border border-orange py-2 px-3 rounded-pill" 
                                style="font-size:0.65rem; cursor:pointer; font-weight: 700; transition: all 0.2s;" 
                                onclick="if(!currentWizardCoupon){ document.getElementById('wizard_coupon_code').value='{{ $c->code }}'; applyWizardCoupon(); }"
                                onmouseover="this.style.background='var(--orange-soft)'; this.style.color='white';"
                                onmouseout="this.style.background='white'; this.style.color='var(--orange)';"
                                >
                              <i class="fas fa-tag me-1"></i> {{ $c->code }} — {{ $c->type === 'percentage' ? $c->value.'%' : '₹'.$c->value }} OFF
                          </span>
                          @endforeach
                      </div>
                  </div>
              </div>

              <div id="wizard-summary-discount-row" style="display:none; color:#2E7D32; font-weight:700; font-size:0.9rem;" class="mb-2">
                  <div class="d-flex justify-content-between">
                      <span>Discount:</span>
                      <span id="wizard-summary-discount"></span>
                  </div>
              </div>

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

  const fpCfg = { 
    minDate: 'today', 
    dateFormat: 'Y-m-d', 
    disable: disabledDates,
    onChange: function() {
        updateBookingSummary();
    }
  };
  flatpickr('#checkin',  fpCfg);
  flatpickr('#checkout', fpCfg);

  // Sidebar Form Validation
  const sidebarForm = document.getElementById('bk-form');
  const sidebarInputs = sidebarForm.querySelectorAll('.bk-input');
  
  sidebarInputs.forEach(input => {
    input.addEventListener('input', function() {
        const err = this.parentElement.querySelector('.error-msg');
        if (err) {
            if (this.checkValidity()) {
                err.style.display = 'none';
                this.style.borderColor = '';
            } else {
                err.style.display = 'block';
                this.style.borderColor = '#dc3545';
            }
        }
    });
  });

  window.propertyPricing = {
    weekday: {{ (float)($property->weekday_price ?: 8000) }},
    weekday_tier2: {{ (float)($property->weekday_tier2_price ?: 11000) }},
    weekend: {{ (float)($property->weekend_price ?: 12000) }},
    maxGuests: {{ (int)($property->capacity ?: 15) }}
  };
  window.bookingSettings = @json($bookingSettings);

  initAmenityListeners();
  initStayOptionListeners();
  initPackageListeners();
  updateBookingSummary();
});

function initStayOptionListeners() {
  document.querySelectorAll('input[name="stay_option_radio"]').forEach((radio) => {
    radio.addEventListener('change', () => {
      document.querySelectorAll('.stay-option-card').forEach(c => c.classList.remove('is-selected'));
      radio.closest('.stay-option-card').classList.add('is-selected');
      updateBookingSummary();
    });
  });
}

/* ── Modal Wizard Flow ──────────────────────────────────────────────────── */
function openBookingWizard() {
  const checkin = document.getElementById('checkin').value;
  const checkout = document.getElementById('checkout').value;
  const guests = document.getElementById('guests-input').value;
  const name = document.getElementById('bk-name').value;
  const phone = document.getElementById('bk-phone').value;
  
  if(!checkin || !checkout || !guests || !name || !phone) {
    alert('Please fill all required fields before proceeding.');
    return;
  }

  const pricing = getFinalPricing();
  if (pricing.grandTotal <= 0) {
    alert('Please select valid dates and details to calculate the booking amount.');
    return;
  }
  
  // Reset wizard to Step 1
  wizardGoToStep(1);

  // Populate dynamic prices in Step 1
  const baseAmt = parseFloat(document.getElementById('form-base-amount').value) || 0;
  const onlyStayLabel = document.getElementById('wizard-only-stay-price');
  if (onlyStayLabel) {
    onlyStayLabel.textContent = `₹${baseAmt.toLocaleString()}`;
  }
  
  updateStep1Total();

  const wizardModal = new bootstrap.Modal(document.getElementById('bookingWizardModal'));
  wizardModal.show();
}

function getFinalPricing() {
  const nights = getBookingNights();
  const guests = getGuestCount();
  const checkinVal = document.getElementById('checkin').value;
  
  let stayTotal = 0;
  let stayLabel = 'Weekday Rate';
  let isWeekendStatus = false;

  if (checkinVal && nights > 0) {
    const start = new Date(checkinVal + 'T00:00');
    for (let i = 0; i < nights; i++) {
        const curr = new Date(start);
        curr.setDate(start.getDate() + i);
        const isWeekend = [5, 6, 0].includes(curr.getDay()); 
        if (isWeekend) isWeekendStatus = true;
        
        let dailyRate = 0;
        if (isWeekend) {
            dailyRate = window.propertyPricing.weekend;
        } else {
            const stayThreshold = {{ $bookingSettings['property_stay_threshold'] }};
            if (guests <= stayThreshold) {
                dailyRate = window.propertyPricing.weekday;
            } else {
                dailyRate = window.propertyPricing.weekday_tier2;
            }
        }
        stayTotal += dailyRate;
    }
    stayLabel = isWeekendStatus ? 'Weekend Rate' : 'Weekday Rate';
  }
  
  // 2. Amenities Calculation
  const amenities = buildAmenityPayload();
  let amenitiesTotal = 0;
  amenities.forEach(a => { 
      amenitiesTotal += a.total; 
  });
  
  // 3. Package Calculation (Step 1 Wizard)
  const selectedPackage = document.querySelector('input[name="wizard_package_option"]:checked');
  const packageRate = selectedPackage ? parseFloat(selectedPackage.value) : 0;
  const packageTotal = (guests > 0 && nights > 0) ? (packageRate * guests * nights) : 0;
  
  const grandTotal = (parseFloat(stayTotal) || 0) + (parseFloat(amenitiesTotal) || 0) + (parseFloat(packageTotal) || 0);
  
  return {
    stayTotal,
    amenitiesTotal,
    packageTotal,
    grandTotal,
    amenitiesList: amenities,
    stayLabel: stayLabel,
    packageName: selectedPackage ? selectedPackage.dataset.name : 'Only Stay',
    nights: nights
  };
}

function updateStep1Total() {
  const pricing = getFinalPricing();
  const currentStayAndExtra = pricing.stayTotal + pricing.amenitiesTotal;

  // Update Individual Package Labels
  const onlyStayLabel = document.getElementById('wizard-only-stay-price');
  if (onlyStayLabel) onlyStayLabel.textContent = `₹${currentStayAndExtra.toLocaleString()}`;

  // Update Grand Total Box at bottom of Step 1
  const totalVal = document.getElementById('wizard-step-1-total-val');
  if (totalVal) {
    totalVal.textContent = `₹${pricing.grandTotal.toLocaleString()}`;
  }
}

// Add listener for Step 1 package changes
document.addEventListener('change', function(e) {
  if (e.target && e.target.name === 'wizard_package_option') {
    // UI feedback for selection
    document.querySelectorAll('#wizard-step-1 .stay-option-card').forEach(c => c.classList.remove('is-selected'));
    e.target.closest('.stay-option-card').classList.add('is-selected');
    updateStep1Total();
  }
});

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
  const pricing = getFinalPricing();
  const guestName = document.getElementById('bk-name').value;
  const guestPhone = document.getElementById('bk-phone').value;
  const petCount = parseInt(document.querySelector('input[name="pets"]')?.value || '0');
  
  // Update UI Elements
  document.getElementById('wizard-summary-name').textContent = guestName;
  document.getElementById('wizard-summary-phone').textContent = guestPhone;
  document.getElementById('wizard-summary-guests').textContent = getGuestCount();
  
  const petsRow = document.getElementById('wizard-summary-pets-row');
  if (petCount > 0) {
      petsRow.style.display = 'flex';
      document.getElementById('wizard-summary-pets').textContent = petCount;
  } else {
      petsRow.style.display = 'none';
  }

  document.getElementById('wizard-summary-stay-type').textContent = pricing.stayLabel + (pricing.nights > 0 ? ` (${pricing.nights} ${pricing.nights === 1 ? 'night' : 'nights'})` : '');
  document.getElementById('wizard-summary-package').textContent = pricing.packageName;
  document.getElementById('wizard-summary-total').textContent = `₹${pricing.grandTotal.toLocaleString()}`;
  
  // Detailed Cost Breakdown
  const costItemsContainer = document.getElementById('wizard-summary-cost-items');
  costItemsContainer.innerHTML = '';
  
  // 1. Stay Cost
  const stayItem = document.createElement('div');
  stayItem.style.cssText = 'display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 0.6rem; color:var(--text-dark); border-bottom: 1px dashed rgba(250,135,62,0.1); padding-bottom: 0.4rem;';
  stayItem.innerHTML = `<span>Base Stay Cost</span><span style="font-weight: 700;">₹${pricing.stayTotal.toLocaleString()}</span>`;
  costItemsContainer.appendChild(stayItem);

  // 2. Package Cost
  if (pricing.packageTotal > 0) {
      const packItem = document.createElement('div');
      packItem.style.cssText = 'display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 0.6rem; color:var(--text-dark); border-bottom: 1px dashed rgba(250,135,62,0.1); padding-bottom: 0.4rem;';
      packItem.innerHTML = `<span>Food Package (${pricing.packageName})</span><span style="font-weight: 700;">₹${pricing.packageTotal.toLocaleString()}</span>`;
      costItemsContainer.appendChild(packItem);
  }

  // 3. Amenities
  if(pricing.amenitiesList.length > 0) {
    const heading = document.createElement('div');
    heading.style.cssText = 'font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--gold); margin-bottom: 0.8rem; margin-top: 1.5rem; letter-spacing: 0.1em;';
    heading.textContent = 'Selected Amenities';
    costItemsContainer.appendChild(heading);

    pricing.amenitiesList.forEach(a => {
      const item = document.createElement('div');
      item.style.cssText = 'display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 0.6rem; color:var(--text-muted);';
      
      const safePrice = parseFloat(a.price) || 0;
      const safeTotal = parseFloat(a.total) || 0;
      const safeParticipants = parseInt(a.participants) || 1;

      let text = (a.pricing_type === 'per_person' && !a.name.toLowerCase().includes('campfire') && !a.name.toLowerCase().includes('speaker') && !a.name.toLowerCase().includes('yacht')) 
                 ? `${a.name} (${safeParticipants} ${a.name.toLowerCase().includes('sheesha') ? 'units' : 'guests'})` 
                 : a.name;
                 
      if (a.name.toLowerCase().includes('kayaking') || a.name.toLowerCase().includes('boating')) {
          text = `${a.name} (₹${safePrice.toLocaleString()}/p × ${safeParticipants} guests)`;
      }
      item.innerHTML = `<span>${text}</span><span style="font-weight: 600; color:var(--text-dark);">₹${safeTotal.toLocaleString()}</span>`;
      costItemsContainer.appendChild(item);
    });
  }

  // Sync values back to hidden form inputs for final submission
  document.getElementById('form-package-name').value = pricing.packageName;
  document.getElementById('form-amount').value = pricing.grandTotal;
  document.getElementById('form-base-amount').value = pricing.stayTotal;
  document.getElementById('form-extra-amount').value = pricing.amenitiesTotal;
  document.getElementById('form-event-type').value = pricing.stayLabel;
  
  // Re-apply coupon if active
  if (currentWizardCoupon) {
      applyWizardCoupon(true);
  }
}

let currentWizardCoupon = null;

async function applyWizardCoupon(isSilent = false) {
    const codeInput = document.getElementById('wizard_coupon_code');
    const code = codeInput.value;
    const msg = document.getElementById('wizard_coupon_msg');
    const applyBtn = document.getElementById('wizard_apply_btn');
    const removeBtn = document.getElementById('wizard_remove_btn');
    
    // Crucial: Calculate base total from scratch to avoid double deduction
    const pricing = getFinalPricing();
    const rawTotal = pricing.grandTotal;
    
    if (!code) return;

    if (!isSilent) {
        applyBtn.disabled = true;
        applyBtn.innerText = '...';
    }

    try {
        const response = await fetch('/coupons/validate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ code: code, total: rawTotal })
        });
        const data = await response.json();
        
        if (data.success) {
            currentWizardCoupon = data;
            if (!isSilent) {
                msg.style.display = 'block';
                msg.textContent = data.message;
                msg.style.color = 'green';
            }
            
            document.getElementById('form-coupon-id').value = data.coupon_id;
            document.getElementById('form-discount-amount').value = data.discount;
            document.getElementById('form-amount').value = data.new_total;
            
            document.getElementById('wizard-summary-discount-row').style.display = 'block';
            document.getElementById('wizard-summary-discount').textContent = `-₹${data.discount.toLocaleString()}`;
            document.getElementById('wizard-summary-total').textContent = `₹${data.new_total.toLocaleString()}`;
            
            // UI state
            applyBtn.style.display = 'none';
            removeBtn.style.display = 'block';
            codeInput.readOnly = true;
        } else {
            if (!isSilent) {
                msg.style.display = 'block';
                msg.textContent = data.message;
                msg.style.color = 'red';
                applyBtn.disabled = false;
                applyBtn.innerText = 'Apply';
            }
            resetWizardCoupon();
        }
    } catch (e) {
        console.error(e);
        if (!isSilent) {
            applyBtn.disabled = false;
            applyBtn.innerText = 'Apply';
        }
    }
}

function resetWizardCoupon() {
    currentWizardCoupon = null;
    document.getElementById('form-coupon-id').value = '';
    document.getElementById('form-discount-amount').value = '';
    document.getElementById('wizard-summary-discount-row').style.display = 'none';
    document.getElementById('wizard_coupon_msg').style.display = 'none';
    
    // UI Reset
    const applyBtn = document.getElementById('wizard_apply_btn');
    const removeBtn = document.getElementById('wizard_remove_btn');
    const codeInput = document.getElementById('wizard_coupon_code');
    
    applyBtn.style.display = 'block';
    applyBtn.disabled = false;
    applyBtn.innerText = 'Apply';
    removeBtn.style.display = 'none';
    codeInput.readOnly = false;
    codeInput.value = '';
    
    // Re-calculate total from base + package + amenities
    updateWizardSummary();
}

/* ── Stay Option listeners ────────────────────────────────────────────── */
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
  document.querySelectorAll('.amenity-selector').forEach((chk) => {
    chk.addEventListener('change', () => {
      const card = chk.closest('.amenity-card');
      const counter = card.querySelector('.amenity-participants');
      if (chk.checked) {
        card.classList.add('is-selected');
        if (counter) {
          counter.style.display = 'block';
          setTimeout(() => {
            counter.style.opacity = '1';
            counter.style.transform = 'translateY(0)';
          }, 10);
        }
      } else {
        card.classList.remove('is-selected');
        if (counter) {
          counter.style.opacity = '0';
          counter.style.transform = 'translateY(-5px)';
          setTimeout(() => { counter.style.display = 'none'; }, 300);
        }
      }
      updateBookingSummary();
      syncGridAddButtons();
    });
  });

  // Plus buttons
  document.querySelectorAll('.plus-btn').forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const card = btn.closest('.amenity-card');
      const input = card.querySelector('.counter-input');
      const minusBtn = card.querySelector('.minus-btn');
      const price = parseFloat(card.querySelector('.amenity-selector').dataset.amenityPrice) || 0;
      const guestCount = getGuestCount();
      let val = parseInt(input.value) || 1;

      const amenityName = (card.querySelector('.amenity-selector').dataset.amenityName || '').toLowerCase();
      const isSheesha = amenityName.includes('sheesha');
      const isYacht = amenityName.includes('yacht');
      const limit = isSheesha ? window.bookingSettings.sheesha_capacity : (isYacht ? Math.min(guestCount, window.bookingSettings.yacht_capacity) : guestCount);

      if (val < limit) {
        val++;
        input.value = val;
        minusBtn.disabled = (val <= 1);
        btn.disabled = (val >= limit);
        updateBookingSummary();
      } else {
        alert(isSheesha ? 'Maximum 6 Sheeshas available.' : `Participants cannot exceed total guests (${guestCount}).`);
      }
    });
  });

  // Minus buttons
  document.querySelectorAll('.minus-btn').forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const card = btn.closest('.amenity-card');
      const input = card.querySelector('.counter-input');
      const plusBtn = card.querySelector('.plus-btn');
      let val = parseInt(input.value) || 1;

      if (val > 1) {
        val--;
        input.value = val;
        btn.disabled = (val <= 1);
        plusBtn.disabled = false;
        updateBookingSummary();
      }
    });
  });
}

function syncGridAddButtons() {
    const selectors = document.querySelectorAll('.amenity-selector');
    const gridButtons = document.querySelectorAll('.btn-add-exp');
    
    gridButtons.forEach(btn => {
        const card = btn.closest('.exp-card') || btn.closest('.special-content');
        if (!card) return;
        
        const title = (card.querySelector('.exp-title')?.textContent || card.querySelector('h4')?.textContent || '').trim().toLowerCase();
        if (!title) return;
        
        // Find checkbox where the name is contained in the title or vice versa
        const checkbox = Array.from(selectors).find(chk => {
            const chkName = (chk.dataset.amenityName || '').toLowerCase().trim();
            return chkName === title || title.includes(chkName) || chkName.includes(title);
        });

        if (checkbox && checkbox.checked) {
            btn.innerHTML = '<i class="bi bi-check-lg"></i> ADDED';
            btn.classList.add('is-added');
        } else {
            btn.innerHTML = '<i class="bi bi-plus"></i> ADD' + (btn.closest('.special-content') ? ' TO BOOKING' : '');
            btn.classList.remove('is-added');
        }
    });
}

/* Guest count change → clamp participant inputs */
document.addEventListener('DOMContentLoaded', () => {
    const guestInput = document.getElementById('guests-input');
    if (guestInput) {
      guestInput.addEventListener('input', () => {
        syncLimits();
        updateKayakDisplay();
        updateBookingSummary();
      });
    }
    
    // Also trigger on date change
    document.getElementById('checkin')?.addEventListener('change', updateBookingSummary);
    document.getElementById('checkout')?.addEventListener('change', updateBookingSummary);
});

function autoSelectStayOption() {
    const checkinVal = document.getElementById('checkin').value;
    
    // Clear highlights
    ['rate-weekday', 'rate-weekend'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.style.borderColor = 'rgba(250,135,62,0.1)';
            el.style.background = '#fff';
            el.style.boxShadow = 'none';
        }
    });

    if (!checkinVal) return;

    const date = new Date(checkinVal);
    const day = date.getDay(); 
    const isWeekend = (day === 0 || day === 5 || day === 6); // Fri, Sat, Sun
    const guests = getGuestCount();

    let activeId = 'rate-weekday';
    if (isWeekend) {
        activeId = 'rate-weekend';
    } else if (guests > 5) {
        activeId = 'rate-weekday-tier2';
    }

    const activeCard = document.getElementById(activeId);
    if (activeCard) {
        activeCard.style.borderColor = 'var(--brand)';
        activeCard.style.background = '#fffaf7';
        activeCard.style.boxShadow = '0 4px 12px rgba(250, 135, 62, 0.1)';
    }
}

let currentAddonKeyword = '';

function openAddonModal(keyword, name) {
  // Bypassing participant count for Campfire, Speakers, and Yacht
  if (keyword.includes('campfire') || keyword.includes('speaker') || keyword.includes('yacht')) {
    const checkbox = Array.from(document.querySelectorAll('.amenity-selector'))
      .find((chk) => {
        const chkName = (chk.dataset.amenityName || '').toLowerCase().trim();
        const search = keyword.toLowerCase().trim();
        return chkName === search || chkName.includes(search) || search.includes(chkName);
      });
    
    if (checkbox) {
      checkbox.checked = true;
      checkbox.dispatchEvent(new Event('change', { bubbles: true }));
      
      // Visual feedback
      updateSidebarPreview();
      syncGridAddButtons(); // Sync the button state
      setTimeout(() => {
        document.getElementById('selected-amenities-preview')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }, 300);
      return; // Stop here, no modal
    }
  }

  currentAddonKeyword = keyword;
  document.getElementById('modalExperienceName').textContent = name;
  document.getElementById('modalPersonCount').value = 1;
  const modal = new bootstrap.Modal(document.getElementById('addonModal'));
  modal.show();
}

function updateModalCount(delta) {
  const input = document.getElementById('modalPersonCount');
  let val = parseInt(input.value) || 1;
  const isSheesha = currentAddonKeyword.toLowerCase().includes('sheesha');
  const isYacht = currentAddonKeyword.toLowerCase().includes('yacht');
  const guestsCount = getGuestCount();
  const limit = isSheesha ? window.bookingSettings.sheesha_capacity : (isYacht ? Math.min(guestsCount, window.bookingSettings.yacht_capacity) : guestsCount);
  
  val += delta;
  if (val < 1) val = 1;
  if (val > limit) {
    val = limit;
    alert(isSheesha ? `Maximum ${window.bookingSettings.sheesha_capacity} Sheeshas available.` : (isYacht ? `Yacht capacity is limited to ${window.bookingSettings.yacht_capacity} guests.` : `Participants cannot exceed the total number of guests (${guestsCount}).`));
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
    .find((chk) => {
      const chkName = (chk.dataset.amenityName || '').toLowerCase().trim();
      const search = currentAddonKeyword.toLowerCase().trim();
      return chkName === search || chkName.includes(search) || search.includes(chkName);
    });
    
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
    syncGridAddButtons(); // Sync the button state
    
    setTimeout(() => {
      document.getElementById('selected-amenities-preview')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }, 300);
  } else {
    const modalEl = document.getElementById('addonModal');
    const modalInstance = bootstrap.Modal.getInstance(modalEl);
    if(modalInstance) modalInstance.hide();
  }
});

function getBookingNights() {
  const cin = document.getElementById('checkin').value;
  const cout = document.getElementById('checkout').value;
  if (!cin || !cout) return 0;
  const d1 = new Date(cin);
  const d2 = new Date(cout);
  const diff = d2.getTime() - d1.getTime();
  const nights = Math.ceil(diff / (1000 * 60 * 60 * 24));
  return nights > 0 ? nights : 0;
}

function updateSidebarPreview() {
  const amenities = buildAmenityPayload();
  const previewList = document.getElementById('preview-items-list');
  
  previewList.innerHTML = '';

  // Remove old headings if they exist outside the list
  const oldHeading = document.getElementById('sidebar-amenities-heading');
  if (oldHeading && oldHeading.parentElement !== previewList) oldHeading.remove();

  const pricing = getFinalPricing();
  
  // 1. Stay Details
  if (pricing.stayTotal > 0) {
    const stayHeading = document.createElement('div');
    stayHeading.style.cssText = 'font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--gold); margin-bottom: 0.8rem; margin-top: 0.5rem; letter-spacing: 0.1em;';
    stayHeading.textContent = 'Stay Details';
    previewList.appendChild(stayHeading);

    const stayItem = document.createElement('div');
    stayItem.style.cssText = 'display:flex; justify-content:space-between; font-size:0.85rem; color:var(--text-dark); padding: 0.4rem 0; border-bottom: 1px dashed rgba(250,135,62,0.1); margin-bottom: 1rem;';
    stayItem.innerHTML = `
      <span style="font-weight:600;">Stay (${pricing.nights} ${pricing.nights === 1 ? 'night' : 'nights'})</span>
      <span style="font-weight:700; color:var(--gold);">₹${pricing.stayTotal.toLocaleString()}</span>
    `;
    previewList.appendChild(stayItem);
  }

  // 2. Amenities Section
  if (amenities.length > 0) {
    const heading = document.createElement('div');
    heading.id = 'sidebar-amenities-heading';
    heading.style.cssText = 'font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--gold); margin-bottom: 0.8rem; margin-top: 0.5rem; letter-spacing: 0.1em;';
    heading.textContent = 'Selected Amenities';
    previewList.appendChild(heading);

    amenities.forEach(a => {
      const item = document.createElement('div');
      item.style.cssText = 'display:flex; justify-content:space-between; font-size:0.85rem; color:var(--text-dark); padding: 0.2rem 0;';
      
      let label = a.name;
      if (a.participants && !a.name.toLowerCase().includes('campfire') && !a.name.toLowerCase().includes('speaker') && !a.name.toLowerCase().includes('yacht')) {
          label = `${a.name} (${a.participants} ${a.name.toLowerCase().includes('sheesha') ? 'units' : (a.name.toLowerCase().includes('kayak') ? 'persons' : 'qty')})`;
      }

      item.innerHTML = `
        <span style="font-weight:500;">${label}</span>
        <span style="font-weight:700; color:var(--gold);">₹${a.total.toLocaleString()}</span>
      `;
      previewList.appendChild(item);
    });
  }
}

function getGuestCount() {
  const val = document.getElementById('guests-input')?.value || '0';
  const count = parseInt(val);
  return isNaN(count) ? 0 : count;
}

function updateKayakDisplay() {
  const guests = getGuestCount();
  const lowPrice = parseFloat(window.bookingSettings.water_activity_low) || 0;
  const highPrice = parseFloat(window.bookingSettings.water_activity_high) || 0;
  const threshold = parseInt(window.bookingSettings.water_activity_threshold) || 5;
  const price = (guests < threshold) ? lowPrice : highPrice;
  
  document.querySelectorAll('.kayak-price-display, .boating-price-display').forEach(el => {
    el.textContent = `₹${price}/p`;
  });
}

function updateSubtotal(card, price, qty) {
  const pill = card.querySelector('.subtotal-pill');
  const chk = card.querySelector('.amenity-selector');
  const dynamicPriceEl = card.querySelector('.dynamic-amenity-price');
  let finalPrice = price;

  // Custom logic for Kayaking & Boating based on TOTAL GUESTS
  const aName = (chk.dataset.amenityName || '').toLowerCase();
  if (aName.includes('kayaking') || aName.includes('boating')) {
    const guestCount = getGuestCount();
    const lowPrice = parseFloat(window.bookingSettings.water_activity_low) || 0;
    const highPrice = parseFloat(window.bookingSettings.water_activity_high) || 0;
    const threshold = parseInt(window.bookingSettings.water_activity_threshold) || 5;
    
    finalPrice = (guestCount < threshold) ? lowPrice : highPrice;
    
    // Update the unit price display in the card
    if (dynamicPriceEl) {
        dynamicPriceEl.textContent = `₹${finalPrice.toLocaleString()}`;
    }
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
    const amenityName = (chk.dataset.amenityName || '').toLowerCase();
    const isSheesha = amenityName.includes('sheesha');
    const isYacht = amenityName.includes('yacht');
    const limit    = isSheesha ? window.bookingSettings.sheesha_capacity : (isYacht ? Math.min(guestCount, window.bookingSettings.yacht_capacity) : guestCount);
    const plusBtn  = card.querySelector('.plus-btn');
    const minusBtn = card.querySelector('.minus-btn');
    let val = parseInt(input.value) || 1;

    if (val > limit) {
      val = limit;
      input.value = val;
    }
    updateSubtotal(card, price, val);
    if (plusBtn)  plusBtn.disabled  = val >= limit;
    if (minusBtn) minusBtn.disabled = val <= 1;

    // Sync limit message
    if (isSheesha) {
        const msg = card.querySelector('.limit-msg');
        if (msg) msg.style.display = (val >= window.bookingSettings.sheesha_capacity) ? 'block' : 'none';
    }
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
    
    // Custom logic for Kayaking & Boating dynamic pricing based on TOTAL GUESTS
    const aName = (chk.dataset.amenityName || '').toLowerCase();
    if (aName.includes('kayaking') || aName.includes('boating')) {
      const guestCount = getGuestCount();
      const lowPrice = parseFloat(window.bookingSettings.water_activity_low) || 0;
      const highPrice = parseFloat(window.bookingSettings.water_activity_high) || 0;
      const threshold = parseInt(window.bookingSettings.water_activity_threshold) || 5;
      
      price = (guestCount < threshold) ? lowPrice : highPrice;
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
  autoSelectStayOption();
  const pricing = getFinalPricing();

  const guestError = document.getElementById('guest-error');
  if (guestError) {
      guestError.style.display = 'none';
      guestError.textContent = '';
      const guestCount = getGuestCount();
      const maxGuests = window.propertyPricing.maxGuests || 15;
      
      if (guestCount > maxGuests) {
          guestError.textContent = `Maximum capacity is ${maxGuests} guests for this property`;
          guestError.style.display = 'block';
      }
  }
  
  // Update Water Activity Rate Labels in Sidebar based on its own participant count
  const kayakRateMain = document.getElementById('kayak-sidebar-rate-main');
  const kayakRateSub = document.getElementById('kayak-sidebar-rate-sub');
  if (kayakRateMain && kayakRateSub) {
      const activityCard = document.querySelector('.amenity-card[data-amenity-name*="Kayaking"], .amenity-card[data-amenity-name*="Boating"]');
      const activityInput = activityCard?.querySelector('.counter-input');
      const activityParts = parseInt(activityInput?.value || '0');
      
      if (activityParts < window.bookingSettings.water_activity_threshold) {
          kayakRateMain.textContent = `₹${window.bookingSettings.water_activity_low.toLocaleString()}/p`;
          kayakRateSub.textContent = `₹${window.bookingSettings.water_activity_high.toLocaleString()}/p (${window.bookingSettings.water_activity_threshold}+ people)`;
      } else {
          kayakRateMain.textContent = `₹${window.bookingSettings.water_activity_high.toLocaleString()}/p`;
          kayakRateSub.textContent = `₹${window.bookingSettings.water_activity_low.toLocaleString()}/p (below ${window.bookingSettings.water_activity_threshold})`;
      }
  }

  document.getElementById('form-base-amount').value = pricing.stayTotal;
  document.getElementById('form-extra-amount').value = pricing.amenitiesTotal;
  document.getElementById('form-amount').value = pricing.grandTotal;
  document.getElementById('form-event-type').value = pricing.stayLabel;

  const sidebarTotal = document.getElementById('sidebar-grand-total');
  if (sidebarTotal) {
      sidebarTotal.textContent = `₹${pricing.grandTotal.toLocaleString()}`;
  }

  updateSidebarPreview();
  syncGridAddButtons();
}

/* ── Form submit ───────────────────────────────────────────────────────── */
async function handleBookingSubmit(event) {
  if(event) event.preventDefault();
  
  const form      = document.getElementById('bk-form');
  const msgBox    = document.getElementById('booking-msg');
  const formData  = new FormData(form);
  
  // Get the grand total including package
  const totalAmount = parseFloat(document.getElementById('form-amount').value);
  if (!totalAmount || totalAmount <= 0) {
    alert('Invalid booking amount. Please try again.');
    return;
  }

  const payload = {
    name:         formData.get('name'),
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
    coupon_id:    formData.get('coupon_id'),
    discount_amount: parseFloat(formData.get('discount_amount')) || 0,
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
@include('chatbot')
<x-social-nav />
</body>
</html>
