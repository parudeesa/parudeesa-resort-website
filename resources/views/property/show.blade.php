<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"/>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>{{ $property->name }} – Luxury Details</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600;1,700&family=EB+Garamond:ital,wght@0,400;0,500;1,400&family=Josefin+Sans:wght@300;400;600&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
    $propertyPrice = $property->price ?: 8000;
    $phone = $property->phone ?: '89210 21202';
    $location = $property->location ?: 'Kerala, India';
@endphp

<style>
:root {
  --brand: #fa873e;
  --brand-d: #e06828;
  --bg-ivory: #fff8f3;
  --bg-beige: #fff3ec;
  --text-dark: #3e2010;
  --text-muted: #7a4520;
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
  --font-serif: 'Cormorant Garamond', serif;
  --font-sans: 'Josefin Sans', sans-serif;
  --font-body: 'EB Garamond', serif;
}

*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth;-webkit-text-size-adjust:100%}
body{font-family:var(--font-sans);background:var(--bg-ivory);color:var(--text-dark);overflow-x:hidden;-webkit-font-smoothing:antialiased;line-height:1.6}
h1,h2,h3,h4,h5{font-family:var(--font-serif);color:var(--text-dark);line-height:1.2}

/* Flatpickr disabled dates styling */
.flatpickr-calendar .flatpickr-day.disabled,
.flatpickr-calendar .flatpickr-day.notAllowed {
  background: #ffe0e0 !important;
  border-color: #ff6b6b !important;
  color: #999 !important;
  cursor: not-allowed !important;
  text-decoration: line-through;
}
.flatpickr-calendar .flatpickr-day.disabled:hover,
.flatpickr-calendar .flatpickr-day.notAllowed:hover {
  background: #ffcccc !important;
  color: #666 !important;
}
.flatpickr-calendar .flatpickr-day.inRange {
  background: #fff8e1 !important;
  color: #ff9800 !important;
}
.flatpickr-calendar .flatpickr-day.selected,
.flatpickr-calendar .flatpickr-day.startRange,
.flatpickr-calendar .flatpickr-day.endRange {
  background: #fa873e !important;
  border-color: #e06828 !important;
  color: #fff !important;
}

/* Navbar */
.navbar{background:rgba(253, 251, 247, 0.95);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border-bottom:1px solid rgba(44,42,41,.05);padding:1rem 0;position:sticky;top:0;z-index:1050;transition:all var(--ease)}
.navbar-brand{font-family:var(--font-serif);font-size:1.8rem;font-weight:700;color:var(--text-dark)!important;letter-spacing:.5px;line-height:1}
.navbar-brand small{display:block;font-size:.6rem;font-weight:400;letter-spacing:.25em;text-transform:uppercase;color:var(--gold);margin-top:.1rem;font-family:var(--font-sans)}
.nav-back{display:inline-flex;align-items:center;gap:.5rem;font-size:.75rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:var(--text-muted);cursor:pointer;transition:all var(--ease);padding:.5rem 1.2rem;border-radius:50px;border:1px solid var(--gold-light);background:transparent}
.nav-back:hover{color:var(--text-dark);border-color:var(--gold);background:var(--bg-beige)}

/* Hero Section */
.hero-wrapper{position:relative;height:85vh;min-height:600px;overflow:hidden;border-radius:0 0 var(--radius-lg) var(--radius-lg);margin-bottom:3rem}
.hero-img{width:100%;height:100%;object-fit:cover;transition:transform 10s ease}
.hero-wrapper:hover .hero-img{transform:scale(1.05)}
.hero-overlay{position:absolute;inset:0;background:linear-gradient(to top, rgba(44,42,41,0.85) 0%, rgba(44,42,41,0.4) 50%, rgba(44,42,41,0.1) 100%)}

.hero-content{position:absolute;bottom:0;left:0;right:0;padding:4rem 2rem;z-index:10;display:flex;flex-direction:column;align-items:center;text-align:center;color:#fff}
.hero-tagline{font-family:var(--font-sans);font-size:0.85rem;letter-spacing:0.3em;text-transform:uppercase;color:rgba(255,255,255,0.9);margin-bottom:1rem;font-weight:600}
.hero-title{font-family:var(--font-serif);font-size:clamp(3rem, 6vw, 5rem);font-weight:700;line-height:1.1;margin-bottom:1rem;color:#ffffff !important;text-shadow:0 4px 20px rgba(0,0,0,0.6)}
.hero-location{font-family:var(--font-sans);font-size:1rem;color:rgba(255,255,255,0.9);display:flex;align-items:center;gap:0.5rem;margin-bottom:2rem}

.hero-actions{display:flex;gap:1rem;flex-wrap:wrap;justify-content:center;align-items:center}
.btn-premium{display:inline-flex;align-items:center;gap:0.5rem;padding:1rem 2rem;background:var(--gold);color:#fff;border-radius:50px;font-family:var(--font-sans);font-size:0.9rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;text-decoration:none;transition:all var(--ease);border:none;box-shadow:0 8px 25px rgba(197, 160, 89, 0.3)}
.btn-premium:hover{background:#b8962c;color:#fff;transform:translateY(-3px);box-shadow:0 12px 30px rgba(197, 160, 89, 0.4)}
.btn-outline-premium{display:inline-flex;align-items:center;gap:0.5rem;padding:1rem 2rem;background:rgba(255,255,255,0.1);backdrop-filter:blur(10px);color:#fff;border-radius:50px;font-family:var(--font-sans);font-size:0.9rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;text-decoration:none;transition:all var(--ease);border:1px solid rgba(255,255,255,0.3)}
.btn-outline-premium:hover{background:#25D366;border-color:#25D366;color:#fff;transform:translateY(-3px)}

.hero-price-badge{position:absolute;top:2rem;right:2rem;background:rgba(255,255,255,0.95);backdrop-filter:blur(10px);padding:0.8rem 1.5rem;border-radius:var(--radius-md);box-shadow:var(--shadow-hover);text-align:center;border:1px solid var(--gold-light)}
.hero-price-badge .amt{font-family:var(--font-serif);font-size:1.8rem;font-weight:700;color:var(--text-dark);line-height:1}
.hero-price-badge .lbl{font-family:var(--font-sans);font-size:0.65rem;text-transform:uppercase;letter-spacing:0.1em;color:var(--text-muted)}

/* Layout */
.section-title{font-family:var(--font-serif);font-size:2.2rem;font-weight:600;color:var(--text-dark);margin-bottom:1.5rem;display:flex;align-items:center;gap:1rem}
.section-title::after{content:'';flex:1;height:1px;background:linear-gradient(to right, var(--gold-light), transparent)}
.content-section{background:var(--card-bg);border-radius:var(--radius-lg);padding:2.5rem;margin-bottom:2rem;box-shadow:var(--shadow-soft);border:1px solid rgba(197,160,89,0.1)}

/* About */
.about-text{font-family:var(--font-body);font-size:1.2rem;color:var(--text-muted);line-height:1.8;text-align:justify}

/* Cards Grid */
.icon-card-grid{display:grid;grid-template-columns:repeat(auto-fill, minmax(220px, 1fr));gap:1.5rem}
.icon-card{background:var(--bg-beige);border-radius:var(--radius-md);padding:1.5rem;display:flex;align-items:flex-start;gap:1rem;transition:all var(--ease);border:1px solid transparent}
.icon-card:hover{background:var(--card-bg);transform:translateY(-5px);box-shadow:var(--shadow-hover);border-color:var(--gold-light)}
.ic-icon{width:45px;height:45px;border-radius:12px;background:var(--card-bg);display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:var(--gold);flex-shrink:0;box-shadow:0 4px 15px rgba(0,0,0,0.05)}
.ic-content{flex:1}
.ic-title{font-family:var(--font-sans);font-size:0.95rem;font-weight:600;color:var(--text-dark);margin-bottom:0.2rem}
.ic-desc{font-family:var(--font-sans);font-size:0.8rem;color:var(--text-muted)}

/* Highlights */
.badge-grid{display:flex;flex-wrap:wrap;gap:1rem}
.premium-badge{background:var(--card-bg);border:1px solid var(--gold-light);color:var(--text-dark);padding:0.6rem 1.2rem;border-radius:50px;font-size:0.85rem;font-weight:600;display:inline-flex;align-items:center;gap:0.5rem;box-shadow:var(--shadow-soft);transition:all var(--ease)}
.premium-badge:hover{background:var(--gold);color:#fff;border-color:var(--gold);transform:translateY(-2px)}
.premium-badge i{color:var(--gold)}
.premium-badge:hover i{color:#fff}

/* Premium Services & Event */
.service-list{display:grid;grid-template-columns:repeat(auto-fill, minmax(250px, 1fr));gap:1rem}
.service-item{display:flex;justify-content:space-between;align-items:center;padding:1rem 1.5rem;background:var(--bg-beige);border-radius:var(--radius-sm);border-left:3px solid var(--gold)}
.service-name{font-weight:600;font-size:0.95rem;color:var(--text-dark)}
.service-tag{font-size:0.65rem;text-transform:uppercase;letter-spacing:0.1em;background:var(--gold-light);color:var(--text-dark);padding:0.3rem 0.6rem;border-radius:4px;font-weight:700}

.event-box{background:linear-gradient(145deg, var(--bg-beige), var(--card-bg));border:1px solid var(--gold-light);border-radius:var(--radius-lg);padding:3rem;text-align:center}
.event-box h3{font-family:var(--font-serif);font-size:2rem;margin-bottom:1rem;color:var(--text-dark)}
.event-tags{display:flex;flex-wrap:wrap;justify-content:center;gap:0.8rem;margin:2rem 0}
.e-tag{background:rgba(197,160,89,0.1);color:var(--text-dark);padding:0.5rem 1rem;border-radius:50px;font-size:0.85rem;font-weight:600;border:1px solid var(--gold-light)}

/* Special Experience */
.special-card{position:relative;border-radius:var(--radius-lg);overflow:hidden;min-height:300px;display:flex;align-items:flex-end;padding:2.5rem;margin-bottom:2rem}
.special-bg{position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&q=80') center/cover;z-index:0;transition:transform 5s ease}
.special-card:hover .special-bg{transform:scale(1.05)}
.special-overlay{position:absolute;inset:0;background:linear-gradient(to top, rgba(44,42,41,0.9), transparent);z-index:1}
.special-content{position:relative;z-index:2;color:#fff}
.special-content h4{color:#fff;font-size:1.8rem;margin-bottom:0.5rem}
.special-content p{font-family:var(--font-body);font-size:1.1rem;color:rgba(255,255,255,0.9);margin-bottom:1rem;max-width:80%}
.special-price{display:inline-block;background:var(--gold);color:#fff;padding:0.4rem 1rem;border-radius:50px;font-size:0.85rem;font-weight:600;letter-spacing:0.05em}

/* Booking Sidebar */
.booking-sticky{position:sticky;top:100px;z-index:90}
.booking-card{background:var(--card-bg);border-radius:var(--radius-lg);padding:2.5rem;box-shadow:var(--shadow-hover);border:1px solid rgba(197,160,89,0.15)}
.bc-title{font-family:var(--font-serif);font-size:1.8rem;font-weight:700;color:var(--text-dark);margin-bottom:1.5rem;text-align:center}

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

/* Animations */
.reveal{opacity:0;transform:translateY(30px);transition:all 0.8s cubic-bezier(0.25, 1, 0.5, 1)}
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
</style>
</head>
<body>

<nav class="navbar">
  <div class="container d-flex align-items-center justify-content-between">
    <a class="navbar-brand" href="{{ route('home') }}">
      Parudeesa
      <small>Luxury Lake Resort</small>
    </a>
    <button class="nav-back" onclick="history.back()">
      <i class="bi bi-arrow-left"></i> Back
    </button>
  </div>
</nav>

<div class="hero-wrapper" id="heroWrap">
  <img src="{{ $property->image_url ?: 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=1400&q=85' }}" class="hero-img" alt="{{ $property->name }}"/>
  <div class="hero-overlay"></div>

  <div class="hero-content">
    <div class="hero-tagline">Peaceful Private Resort Stay</div>
    <h1 class="hero-title">{{ $property->name }}</h1>
    <div class="hero-location">
      <i class="bi bi-geo-alt-fill text-warning"></i> {{ $location }}
    </div>
    <div class="hero-actions mt-4">
      <button class="btn-premium" onclick="document.getElementById('booking-section').scrollIntoView({behavior:'smooth'})">
        Book Now
      </button>
      <a href="/chatbot" target="_blank" class="btn-outline-premium">
        <i class="bi bi-whatsapp"></i> Book via WhatsApp
      </a>
    </div>
  </div>
</div>

<div class="container mb-5 pb-5">
  <div class="row g-5">
    
    <!-- Left Column: Details -->
    <div class="col-lg-7">
      
      <!-- 2. About Stay -->
      <div class="content-section reveal">
        <h2 class="section-title">About Stay</h2>
        <p class="about-text">
          Escape to a world of absolute tranquility at {{ $property->name }}. Our luxury lakeside resort offers a peaceful private stay designed for those who appreciate nature's calm combined with premium elegance. Savor private sunrise moments, unwind by the serene waters, and enjoy thoughtfully curated spaces that promise a truly unforgettable retreat.
        </p>
      </div>

      <!-- 9. Highlights (Moved up for better flow) -->
      <div class="content-section reveal">
        <h2 class="section-title">Highlights</h2>
        <div class="badge-grid">
          <span class="premium-badge"><i class="bi bi-droplet-fill"></i> Unlimited Pool Access (No Time Limit)</span>
          <span class="premium-badge"><i class="bi bi-house-heart-fill"></i> Private Cottage Experience</span>
          <span class="premium-badge"><i class="bi bi-water"></i> Scenic Water Activities</span>
          <span class="premium-badge"><i class="bi bi-emoji-smile-fill"></i> Family Friendly Stay</span>
          <span class="premium-badge"><i class="bi bi-stars"></i> Event Friendly Property</span>
        </div>
      </div>

      <!-- 3. Accommodation Details -->
      <div class="content-section reveal">
        <h2 class="section-title">Accommodation</h2>
        <div class="icon-card-grid">
          <div class="icon-card">
            <div class="ic-icon"><i class="bi bi-house"></i></div>
            <div class="ic-content">
              <div class="ic-title">3 Bedroom Cottage</div>
              <div class="ic-desc">Spacious & private</div>
            </div>
          </div>
          <div class="icon-card">
            <div class="ic-icon"><i class="bi bi-snow"></i></div>
            <div class="ic-content">
              <div class="ic-title">1 Master Bedroom</div>
              <div class="ic-desc">With AC & attached bath</div>
            </div>
          </div>
          <div class="icon-card">
            <div class="ic-icon"><i class="bi bi-wind"></i></div>
            <div class="ic-content">
              <div class="ic-title">2 Standard Bedrooms</div>
              <div class="ic-desc">Non-AC, breezy & comfortable</div>
            </div>
          </div>
          <div class="icon-card">
            <div class="ic-icon"><i class="bi bi-droplet"></i></div>
            <div class="ic-content">
              <div class="ic-title">1 Common Washroom</div>
              <div class="ic-desc">Clean & fully equipped</div>
            </div>
          </div>
          <div class="icon-card">
            <div class="ic-icon"><i class="bi bi-tv"></i></div>
            <div class="ic-content">
              <div class="ic-title">Spacious Hall Area</div>
              <div class="ic-desc">Perfect for gathering</div>
            </div>
          </div>
          <div class="icon-card">
            <div class="ic-icon"><i class="bi bi-cup-hot"></i></div>
            <div class="ic-content">
              <div class="ic-title">Dining Area</div>
              <div class="ic-desc">Enjoy meals together</div>
            </div>
          </div>
          <div class="icon-card">
            <div class="ic-icon"><i class="bi bi-cup-straw"></i></div>
            <div class="ic-content">
              <div class="ic-title">Sitout Area</div>
              <div class="ic-desc">Relax with a view</div>
            </div>
          </div>
        </div>
      </div>

      <!-- 4. Outdoor & Included Spaces -->
      <div class="content-section reveal">
        <h2 class="section-title">Outdoor Spaces</h2>
        <div class="icon-card-grid">
          <div class="icon-card">
            <div class="ic-icon"><i class="bi bi-water"></i></div>
            <div class="ic-content">
              <div class="ic-title">Private Pool Area</div>
              <div class="ic-desc">Exclusive access</div>
            </div>
          </div>
          <div class="icon-card">
            <div class="ic-icon"><i class="bi bi-tree"></i></div>
            <div class="ic-content">
              <div class="ic-title">Lawn Area</div>
              <div class="ic-desc">Lush greenery</div>
            </div>
          </div>
          <div class="icon-card">
            <div class="ic-icon"><i class="bi bi-car-front"></i></div>
            <div class="ic-content">
              <div class="ic-title">Private Parking</div>
              <div class="ic-desc">Safe & secure</div>
            </div>
          </div>
          <div class="icon-card">
            <div class="ic-icon"><i class="bi bi-stars"></i></div>
            <div class="ic-content">
              <div class="ic-title">Open Event Space</div>
              <div class="ic-desc">For celebrations</div>
            </div>
          </div>
        </div>
      </div>

      <!-- 5. Amenities & Experiences -->
      <div class="content-section reveal">
        <h2 class="section-title">Included Experiences</h2>
        <div class="icon-card-grid">
          <div class="icon-card">
            <div class="ic-icon">🚣</div>
            <div class="ic-content"><div class="ic-title">Kayaking</div></div>
          </div>
          <div class="icon-card">
            <div class="ic-icon">🎣</div>
            <div class="ic-content"><div class="ic-title">Fishing</div></div>
          </div>
          <div class="icon-card">
            <div class="ic-icon">🚤</div>
            <div class="ic-content"><div class="ic-title">Boating</div></div>
          </div>
          <div class="icon-card">
            <div class="ic-icon">🍖</div>
            <div class="ic-content"><div class="ic-title">Grilling / BBQ</div></div>
          </div>
          <div class="icon-card">
            <div class="ic-icon">🔥</div>
            <div class="ic-content"><div class="ic-title">Campfire</div></div>
          </div>
          <div class="icon-card">
            <div class="ic-icon">💨</div>
            <div class="ic-content"><div class="ic-title">Sheesha / Hookah</div><div class="ic-desc">6 available</div></div>
          </div>
        </div>
      </div>

      <!-- 7. Special Experiences -->
      <div class="reveal">
        <div class="special-card">
          <div class="special-bg"></div>
          <div class="special-overlay"></div>
          <div class="special-content">
            <h4>Canopy Boat Pickup Experience</h4>
            <p>Guests can be picked up directly from the property by boat and taken to the kayaking center. Includes a scenic boat ride and full kayaking experience.</p>
            <span class="special-price">Approx ₹650 – ₹700 per person</span>
          </div>
        </div>
      </div>

      <!-- 6. Premium Services -->
      <div class="content-section reveal">
        <h2 class="section-title">Premium Add-ons</h2>
        <div class="service-list">
          <div class="service-item"><span class="service-name">Private Yacht Experience</span><span class="service-tag">On Request</span></div>
          <div class="service-item"><span class="service-name">JBL Speaker Rental</span><span class="service-tag">On Request</span></div>
          <div class="service-item"><span class="service-name">Live Music Setup</span><span class="service-tag">On Request</span></div>
          <div class="service-item"><span class="service-name">Private Anchor / Host</span><span class="service-tag">On Request</span></div>
          <div class="service-item"><span class="service-name">DJ Setup</span><span class="service-tag">On Request</span></div>
          <div class="service-item"><span class="service-name">Decor Setup</span><span class="service-tag">On Request</span></div>
          <div class="service-item"><span class="service-name">Stage Setup</span><span class="service-tag">On Request</span></div>
        </div>
      </div>

      <!-- 8. Event Hosting -->
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

    </div>

    <!-- Right Column: Booking -->
    <div class="col-lg-5" id="booking-section">
      <div class="booking-sticky reveal">
        <div class="booking-card">
          <h3 class="bc-title">Reserve Your Stay</h3>
          
          <div class="pricing-info">
            <div class="pi-row">
              <span class="pi-label">Base Stay Price</span>
              <span class="pi-val">₹{{ number_format($property->price ?: 11000, 2) }}</span>
            </div>
            <span class="pi-note">*Amenities charges will be added based on your selections below.</span>
          </div>

          <form action="{{ route('bookings.store') }}" method="POST" id="bk-form" onsubmit="handleBookingSubmit(event)">
            @csrf
            <input type="hidden" name="property_id" value="{{ $property->id }}" />
            <input type="hidden" name="amount" id="form-amount" value="{{ number_format($property->price ?: 0, 2, '.', '') }}" />
            <input type="hidden" name="extra_amount" id="form-extra-amount" value="0" />
            <input type="hidden" name="base_amount" id="form-base-amount" value="{{ number_format($property->price ?: 0, 2, '.', '') }}" />

            <div class="form-row">
              <div>
                <label style="font-size:.85rem;color:#666;font-weight:600;display:block;margin-bottom:.5rem;">Check-in Date</label>
                <input type="text" class="bk-input" id="checkin" name="check_in" placeholder="YYYY-MM-DD" required />
                <div style="font-size:.75rem;color:#e06828;margin-top:.3rem;">⛔ Red dates are unavailable</div>
              </div>
              <div>
                <label style="font-size:.85rem;color:#666;font-weight:600;display:block;margin-bottom:.5rem;">Check-out Date</label>
                <input type="text" class="bk-input" id="checkout" name="check_out" placeholder="YYYY-MM-DD" required />
                <div style="font-size:.75rem;color:#666;margin-top:.3rem;">✓ Must be after check-in</div>
              </div>
            </div>
            
            <div class="form-row">
              <div>
                <label style="font-size:.85rem;color:#666;font-weight:600;display:block;margin-bottom:.5rem;">Total Guests</label>
                <input type="number" class="bk-input" id="total-guests" name="guests" placeholder="Total Guests" min="1" value="1" required />
              </div>
              <input type="text" class="bk-input" name="name" placeholder="Full Name" required />
            </div>

            <div class="form-row">
              <input type="tel" class="bk-input" name="phone" placeholder="Phone Number" required />
              <input type="email" class="bk-input" name="email" placeholder="Email Address" required />
            </div>

            <div class="form-group">
              <label class="p-label">Select Amenities</label>
              <div id="amenities-list" style="display:grid;gap:1rem;">
                @forelse($property->amenities as $amenity)
                <div class="amenity-card" style="border:2px solid #e06828;border-radius:14px;padding:1rem;background:#fff;margin-bottom:1rem;">
                  <div style="font-size:1.1rem;font-weight:700;color:#333;margin-bottom:.5rem;">{{ $amenity->name }}</div>
                  <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
                    <label style="display:flex;align-items:center;gap:.75rem;font-weight:700;cursor:pointer;flex:1;">
                      <input type="checkbox" class="amenity-selector" data-amenity-id="{{ $amenity->id }}" data-amenity-name="{{ $amenity->name }}" data-amenity-price="{{ $amenity->price }}" data-amenity-type="{{ $amenity->pricing_type }}" name="amenities[{{ $amenity->id }}][selected]" value="1" style="width:1.2rem;height:1.2rem;" />
                      <span>{{ $amenity->name }}</span>
                    </label>
                    <div style="text-align:right;min-width:140px;font-size:.95rem;color:#444;">
                      @if($amenity->pricing_type === 'per_person')
                        ₹{{ number_format($amenity->price,2) }} / person
                      @else
                        ₹{{ number_format($amenity->price,2) }} fixed
                      @endif
                    </div>
                  </div>
                  @if($amenity->pricing_type === 'per_person')
                  <div class="amenity-participants" style="margin-top:.85rem;display:block;border-top:2px solid #e06828;padding-top:.85rem;background:#fef7f3;border-radius:8px;padding:1rem;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                      <label style="font-size:1rem;color:#e06828;font-weight:700;">👥 Select Members</label>
                      <div style="font-size:.9rem;color:#999;">
                        <span style="color:#e06828;font-weight:700;" class="persons-label">1 Person</span>
                      </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:1rem;">
                      <button type="button" class="amenity-counter-btn amenity-decrease-btn" data-amenity-id="{{ $amenity->id }}" style="width:48px;height:48px;border-radius:10px;border:none;background:#e06828;color:#fff;font-weight:700;font-size:1.3rem;cursor:pointer;transition:all 0.3s ease;box-shadow:0 2px 8px rgba(224,104,40,0.2);">−</button>
                      
                      <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:.3rem;">
                        <input type="number" class="amenity-participants-input" name="amenities[{{ $amenity->id }}][participants]" min="1" value="1" style="width:100%;text-align:center;font-weight:700;font-size:1.8rem;border:2px solid #e06828;border-radius:8px;padding:.5rem;background:#fff;" data-amenity-price="{{ $amenity->price }}" data-amenity-name="{{ $amenity->name }}" />
                        <div style="font-size:.75rem;color:#999;">₹{{ number_format($amenity->price, 2) }} each</div>
                      </div>
                      
                      <button type="button" class="amenity-counter-btn amenity-increase-btn" data-amenity-id="{{ $amenity->id }}" style="width:48px;height:48px;border-radius:10px;border:none;background:#e06828;color:#fff;font-weight:700;font-size:1.3rem;cursor:pointer;transition:all 0.3s ease;box-shadow:0 2px 8px rgba(224,104,40,0.2);">+</button>
                    </div>
                    <div style="font-size:.85rem;color:#e06828;margin-top:1rem;text-align:center;font-weight:600;" class="amenity-total-display">Total: ₹{{ number_format($amenity->price, 2) }}</div>
                  </div>
                  @endif
                  <input type="hidden" name="amenities[{{ $amenity->id }}][price]" value="{{ $amenity->price }}" />
                  <input type="hidden" name="amenities[{{ $amenity->id }}][pricing_type]" value="{{ $amenity->pricing_type }}" />
                  <input type="hidden" name="amenities[{{ $amenity->id }}][name]" value="{{ $amenity->name }}" />
                </div>
                @empty
                <div class="text-muted" style="font-size:.95rem;color:#666;padding:2rem;border:2px dashed #e06828;border-radius:12px;background:#fef7f3;text-align:center;">
                  <div style="font-size:1.2rem;margin-bottom:1rem;">🏄‍♂️ Sample Amenities</div>
                  <div style="margin-bottom:1rem;">No amenities configured yet. Here's how member selection works:</div>
                  
                  <!-- Sample Kayaking -->
                  <div class="amenity-card" style="border:2px solid #e06828;border-radius:14px;padding:1rem;background:#fff;margin:1rem 0;max-width:400px;margin-left:auto;margin-right:auto;">
                    <div style="font-size:1.1rem;font-weight:700;color:#333;margin-bottom:.5rem;">🚣 Kayaking</div>
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;margin-bottom:.5rem;">
                      <label style="display:flex;align-items:center;gap:.75rem;font-weight:700;cursor:pointer;flex:1;">
                        <input type="checkbox" checked disabled style="width:1.2rem;height:1.2rem;" />
                        <span>Kayaking</span>
                      </label>
                      <div style="text-align:right;min-width:140px;font-size:.95rem;color:#444;">₹700 / person</div>
                    </div>
                    <div class="amenity-participants" style="margin-top:.85rem;display:block;border-top:2px solid #e06828;padding-top:.85rem;background:#fef7f3;border-radius:8px;padding:.85rem;">
                      <label style="font-size:1rem;color:#e06828;font-weight:700;display:block;margin-bottom:.5rem;">👥 Number of Members</label>
                      <div style="display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;">
                        <button type="button" disabled style="width:45px;height:45px;border-radius:12px;border:2px solid #e06828;background:#fff;color:#e06828;font-weight:700;font-size:1.4rem;">-</button>
                        <input type="number" value="2" disabled style="width:80px;max-width:100px;text-align:center;font-weight:600;font-size:1.1rem;border:2px solid #e06828;" />
                        <button type="button" disabled style="width:45px;height:45px;border-radius:12px;border:2px solid #e06828;background:#fff;color:#e06828;font-weight:700;font-size:1.4rem;">+</button>
                      </div>
                      <div style="font-size:.9rem;color:#666;margin-top:.5rem;font-style:italic;">Select how many people will participate in this activity</div>
                    </div>
                  </div>
                  
                  <div style="margin-top:1rem;font-size:.9rem;color:#888;">When amenities are configured, you'll see member controls like this for per-person activities.</div>
                </div>
                @endforelse
              </div>
            </div>

            <div id="booking-summary" style="margin-top:1.5rem;padding:1.2rem;border:1px solid rgba(250,135,62,.18);border-radius:16px;background:#fff;">
              <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.5rem;margin-bottom:1rem;">
                <div>
                  <div style="font-size:.9rem;color:#999;text-transform:uppercase;letter-spacing:.12em;font-weight:700;">Booking Summary</div>
                  <div style="font-size:1.2rem;font-weight:700;color:#1f2937;">{{ $property->name }}</div>
                </div>
                <div style="text-align:right;min-width:150px;">
                  <div style="font-size:.85rem;color:#555;">Base Stay Price</div>
                  <div id="summary-base-price" style="font-size:1.25rem;font-weight:700;color:#e06828;">₹{{ number_format($property->price ?: 11000, 2) }}</div>
                </div>
              </div>
              <div id="summary-amenities-list" style="margin-bottom:1rem;color:#444;">
                <div style="font-weight:700;margin-bottom:.6rem;color:#333;">Amenities Charges</div>
                <div id="summary-amenities-empty" style="color:#777;font-size:.95rem;">Choose amenities to see charges.</div>
              </div>
              <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.75rem;border-top:1px solid rgba(229,231,235,.8);padding-top:1rem;">
                <div style="font-size:.95rem;color:#555;">Extra Amenities Total</div>
                <div id="summary-extra-total" style="font-size:1.1rem;font-weight:700;color:#111;">₹0.00</div>
              </div>
              <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.75rem;margin-top:.8rem;">
                <div style="font-size:.95rem;color:#555;">Grand Total</div>
                <div id="summary-grand-total" style="font-size:1.35rem;font-weight:800;color:#b45309;">₹{{ number_format($property->price ?: 11000, 2) }}</div>
              </div>
            </div>

            <button type="submit" class="btn-book-submit">Book Now</button>
            <div class="text-center my-3" style="font-size:0.8rem;color:var(--text-muted);font-weight:600;letter-spacing:0.1em;text-transform:uppercase">OR</div>
            <a href="/chatbot" target="_blank" class="btn-wa-alt">
              <i class="bi bi-chat-left-text"></i> Chat with us
            </a>
            <div class="contact-panel" style="margin-top:1.2rem;padding:1rem;border:1px solid rgba(0,0,0,0.08);border-radius:12px;background:#fafafa;font-size:.95rem">
              <div style="font-weight:700;margin-bottom:.4rem">For enquiries only:</div>
              <div><a href="tel:+918921021202">+91 89210 21202</a></div>
              <div><a href="tel:+918075741948">+91 80757 41948</a></div>
            </div>

            <div id="booking-msg" style="display:none;margin-top:1.5rem;padding:1rem;border-radius:var(--radius-sm);font-size:0.9rem;text-align:center"></div>
          </form>

        </div>
      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Animations
const obs = new IntersectionObserver((entries) => {
  entries.forEach((e) => {
    if (e.isIntersecting) {
      e.target.classList.add('visible');
      obs.unobserve(e.target);
    }
  });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

// Flatpickr with proper disabled date range validation
document.addEventListener('DOMContentLoaded', async () => {
  let dateRanges = [];

  try {
    const response = await fetch(`/property/{{ $property->id }}/unavailable-dates`);
    if (response.ok) {
      dateRanges = await response.json();
    }
  } catch (error) {
    console.error("Failed to load unavailable dates:", error);
  }

  // Function to check if a date is within any blocked range
  const isDateBlocked = (date) => {
    const checkDate = new Date(date).toISOString().split('T')[0];
    return dateRanges.some(range => {
      return checkDate >= range.from && checkDate <= range.to;
    });
  };

  // Function to disable dates for Flatpickr
  const disableFunction = (date) => {
    return isDateBlocked(date);
  };

  const checkin = flatpickr("#checkin", {
    minDate: "today",
    dateFormat: "Y-m-d",
    disable: [disableFunction],
    onChange: function(selectedDates, dateStr) {
      if (!selectedDates[0]) return;
      const checkoutMinDate = new Date(selectedDates[0]);
      checkoutMinDate.setDate(checkoutMinDate.getDate() + 1);
      checkout.set('minDate', checkoutMinDate);

      // Find next available checkout date after check-in
      let maxDate = null;
      let currentDate = new Date(checkoutMinDate);
      while (currentDate <= new Date(new Date().setFullYear(new Date().getFullYear() + 1))) {
        if (isDateBlocked(currentDate)) {
          const beforeBlocked = new Date(currentDate);
          beforeBlocked.setDate(beforeBlocked.getDate() - 1);
          maxDate = beforeBlocked;
          break;
        }
        currentDate.setDate(currentDate.getDate() + 1);
      }
      if (maxDate) {
        checkout.set('maxDate', maxDate);
      }
    }
  });

  const checkout = flatpickr("#checkout", {
    minDate: "today",
    dateFormat: "Y-m-d",
    disable: [disableFunction]
  });

  initializeAmenityListeners();
  updateBookingSummary();
});
  

function initializeAmenityListeners() {
  document.querySelectorAll('.amenity-selector').forEach((checkbox) => {
    checkbox.addEventListener('change', () => {
      const amenityCard = checkbox.closest('.amenity-card');
      const participantsRow = amenityCard?.querySelector('.amenity-participants');
      const participantsInput = amenityCard?.querySelector('.amenity-participants-input');

      if (participantsRow) {
        participantsRow.style.display = checkbox.checked ? 'block' : 'block';
        participantsInput.disabled = false;
      }
      updateBookingSummary();
    });
  });

  document.querySelectorAll('.amenity-participants-input').forEach((input) => {
    input.addEventListener('input', () => {
      if (input.value < 1) {
        input.value = 1;
      }
      updateBookingSummary();
    });
  });

  document.querySelectorAll('.quantity-button').forEach((button) => {
    button.addEventListener('click', () => {
      const action = button.dataset.action;
      const amenityCard = button.closest('.amenity-card');
      const input = amenityCard?.querySelector('.amenity-participants-input');
      if (!input) return;
      let current = parseInt(input.value || '1', 10);
      current = action === 'increase' ? current + 1 : Math.max(1, current - 1);
      input.value = current;
      updateBookingSummary();
    });
  });
}

function buildAmenityPayload() {
  const amenities = [];
  document.querySelectorAll('.amenity-selector').forEach((checkbox) => {
    if (!checkbox.checked) {
      return;
    }

    const amenityId = checkbox.dataset.amenityId;
    const name = checkbox.dataset.amenityName;
    const price = parseFloat(checkbox.dataset.amenityPrice) || 0;
    const pricingType = checkbox.dataset.amenityType;
    const amenityCard = checkbox.closest('.amenity-card');
    const participantsInput = amenityCard?.querySelector('.amenity-participants-input');
    const members = pricingType === 'per_person' ? Math.max(1, parseInt(participantsInput?.value || '1')) : null;
    const total = pricingType === 'per_person' ? price * members : price;

    if (pricingType === 'per_person') {
      amenities.push({
        "name": name,
        "type": "per_person",
        "members": members,
        "unit_price": price,
        "total": total
      });
    } else {
      amenities.push({
        "name": name,
        "type": "fixed",
        "total": total
      });
    }
  });

  return amenities;
}

function updateBookingSummary() {
  const baseAmount = parseFloat(document.getElementById('form-base-amount').value) || 0;
  const amenities = buildAmenityPayload();
  const summaryList = document.getElementById('summary-amenities-list');
  const summaryEmpty = document.getElementById('summary-amenities-empty');
  const extraTotalElem = document.getElementById('summary-extra-total');
  const grandTotalElem = document.getElementById('summary-grand-total');
  const formExtraAmount = document.getElementById('form-extra-amount');
  const formAmount = document.getElementById('form-amount');

  let extraTotal = 0;
  summaryList.querySelectorAll('.summary-item').forEach(el => el.remove());

  if (amenities.length === 0) {
    summaryEmpty.style.display = 'block';
  } else {
    summaryEmpty.style.display = 'none';
    amenities.forEach((amenity) => {
      extraTotal += amenity.total;
      const item = document.createElement('div');
      item.className = 'summary-item';
      item.style.marginBottom = '.65rem';
      item.style.fontSize = '.96rem';
      item.style.color = '#334155';
      if (amenity.type === 'per_person') {
        item.textContent = `${amenity.name} (${amenity.members} × ₹${amenity.unit_price.toFixed(2)}) = ₹${amenity.total.toFixed(2)}`;
      } else {
        item.textContent = `${amenity.name} = ₹${amenity.total.toFixed(2)}`;
      }
      summaryList.appendChild(item);
    });
  }

  const grandTotal = baseAmount + extraTotal;
  extraTotalElem.textContent = `₹${extraTotal.toFixed(2)}`;
  grandTotalElem.textContent = `₹${grandTotal.toFixed(2)}`;
  formExtraAmount.value = extraTotal.toFixed(2);
  formAmount.value = grandTotal.toFixed(2);
}

async function handleBookingSubmit(event) {
  event.preventDefault();
  const form = document.getElementById('bk-form');
  const msgBox = document.getElementById('booking-msg');
  const submitBtn = form.querySelector('.btn-book-submit');
  const amenities = buildAmenityPayload();
  const formData = new FormData(form);
  
  // Validate dates
  const checkInStr = formData.get('check_in');
  const checkOutStr = formData.get('check_out');
  
  if (!checkInStr || !checkOutStr) {
    msgBox.style.display = 'block';
    msgBox.style.backgroundColor = '#FFEBEE';
    msgBox.style.color = '#C62828';
    msgBox.style.border = '1px solid #FFCDD2';
    msgBox.innerHTML = '<strong>Error!</strong><br/>Please select both check-in and check-out dates.';
    return;
  }
  
  const checkIn = new Date(checkInStr);
  const checkOut = new Date(checkOutStr);
  
  if (checkOut <= checkIn) {
    msgBox.style.display = 'block';
    msgBox.style.backgroundColor = '#FFEBEE';
    msgBox.style.color = '#C62828';
    msgBox.style.border = '1px solid #FFCDD2';
    msgBox.innerHTML = '<strong>Error!</strong><br/>Check-out date must be after check-in date.';
    return;
  }
  
  const payload = {
    name: formData.get('name'),
    email: formData.get('email'),
    phone: formData.get('phone'),
    check_in: checkInStr,
    check_out: checkOutStr,
    guests: formData.get('guests'),
    property_id: formData.get('property_id'),
    event_type: formData.get('event_type') || null,
    package_name: formData.get('package_name') || null,
    notes: formData.get('notes') || null,
    base_amount: parseFloat(formData.get('base_amount')) || 0,
    extra_amount: parseFloat(formData.get('extra_amount')) || 0,
    amount: parseFloat(formData.get('amount')) || 0,
    amenities: amenities
  };
  
  submitBtn.disabled = true;
  submitBtn.innerText = 'Processing...';
  
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
    
    msgBox.style.display = 'block';
    if (json.success) {
      msgBox.style.backgroundColor = '#E8F5E9';
      msgBox.style.color = '#2E7D32';
      msgBox.style.border = '1px solid #A5D6A7';
      msgBox.innerHTML = `<strong>Booking saved.</strong><br/>Launching secure Razorpay payment...`;
      initiatePayment({
        name: payload.name,
        email: payload.email,
        phone: payload.phone,
        propertyName: '{{ $property->name }}',
        amount: Math.round(payload.amount * 100)
      });
    } else {
      throw new Error(json.message || 'Booking failed');
    }
  } catch (error) {
    msgBox.style.display = 'block';
    msgBox.style.backgroundColor = '#FFEBEE';
    msgBox.style.color = '#C62828';
    msgBox.style.border = '1px solid #FFCDD2';
    msgBox.innerHTML = `<strong>Error!</strong><br/>${error.message || 'Please try again later or contact us through the chatbot.'}`;
  } finally {
    submitBtn.disabled = false;
    submitBtn.innerText = 'Book Now';
  }
}

function initiatePayment(data) {
  const msgBox = document.getElementById('booking-msg');
  const amount = data.amount || 500000;
  const opts = {
    key: 'rzp_test_YourRazorpayKeyHere',
    amount: amount,
    currency: 'INR',
    name: 'Parudeesa – The Lake View Resort',
    description: 'Booking Advance — ' + (data.propertyName || 'Parudeesa'),
    prefill: {
      name: data.name || '',
      email: data.email || '',
      contact: data.phone || ''
    },
    theme: { color: '#fa873e' },
    handler: function(res) {
      msgBox.style.display = 'block';
      msgBox.style.backgroundColor = '#E8F5E9';
      msgBox.style.color = '#2E7D32';
      msgBox.style.border = '1px solid #A5D6A7';
      msgBox.innerHTML = '<strong>✅ Payment successful!</strong><br/>Payment ID: ' + res.razorpay_payment_id + '<br/>Your booking is confirmed. Our team will contact you shortly.';
      document.getElementById('bk-form')?.reset();
    },
    modal: {
      ondismiss: function() {
        msgBox.style.display = 'block';
        msgBox.style.backgroundColor = '#FFEBEE';
        msgBox.style.color = '#C62828';
        msgBox.style.border = '1px solid #FFCDD2';
        msgBox.innerHTML = '<strong>Payment not completed.</strong><br/>Please retry or contact us for help.';
      }
    }
  };
  try {
    new Razorpay(opts).open();
  } catch (err) {
    msgBox.style.display = 'block';
    msgBox.style.backgroundColor = '#FFEBEE';
    msgBox.style.color = '#C62828';
    msgBox.style.border = '1px solid #FFCDD2';
    msgBox.innerHTML = '<strong>Error:</strong> Razorpay checkout could not be opened. Please ensure HTTPS or try again.';
    console.error(err);
  }
}
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</body>
</html>
