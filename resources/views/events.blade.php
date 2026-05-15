<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $seo['title'] ?? 'Parudeesa — Lakeside Events' }}</title>
<meta name="description" content="{{ $seo['description'] ?? '' }}">
<meta property="og:image" content="{{ $seo['og_image'] ?? '' }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
{!! $seo['schema_markup'] ?? '' !!}
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<!-- Swiper JS is loaded at the bottom -->
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<!-- Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<!-- Bootstrap CSS for grid and utils -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Brand Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
<style>
:root {
  --ivory: #FAF7F2;
  --cream: #F5EFE4;
  --sand: #E8DCCB;
  --warm-beige: #D4C4A8;
  --terracotta: #C4714A;
  --terracotta-light: #D4855E;
  --bronze: #A0703A;
  --bronze-light: #C4945A;
  --brown-dark: #3D2B1F;
  --brown-mid: #6B4A35;
  --brown-warm: #8B6045;
  --text-primary: #2C1A0E;
  --text-secondary: #6B4A35;
  --text-muted: #A08060;
  --gold: #C9A96E;
  --gold-light: #E8C98A;
  --white: #FFFFFF;
  --shadow-warm: rgba(164, 112, 58, 0.15);
  --shadow-deep: rgba(45, 27, 14, 0.12);
  --ease: cubic-bezier(0.16, 1, 0.3, 1);
  
  /* Brand Tokens from Home */
  --brand: #fa873e;
  --brand-d: #e06828;
  --brand-dd: #c05520;
  --brand-l: #ffb07a;
  --brand-pale: #fff3ec;
  --brand-mist: #fff8f3;
  --brn-dk: #3e2010;
  --txt-m: #5a5a5a;
  --ease-home: .35s cubic-bezier(.4, 0, .2, 1);
}

* { margin: 0; padding: 0; box-sizing: border-box; }
html { scroll-behavior: smooth; }

body {
  font-family: 'Poppins', sans-serif;
  background: var(--ivory);
  color: var(--text-primary);
  overflow-x: hidden;
}

/* ═══════════════════════════════════════
   OFFICIAL BRAND NAVBAR
═══════════════════════════════════════ */

/* ═══════════════════════════════════════
   HERO SECTION
═══════════════════════════════════════ */
.hero {
  position: relative;
  height: 100vh;
  min-height: 700px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.hero-bg {
  position: absolute;
  inset: 0;
  background:
    linear-gradient(160deg, rgba(45,27,14,0.72) 0%, rgba(100,60,30,0.55) 40%, rgba(196,113,74,0.3) 100%),
    url('/images/event-hero-main.jpg') center/cover no-repeat;
  transform: scale(1.05);
  animation: heroZoom 20s ease-in-out infinite alternate;
}

@keyframes heroZoom {
  from { transform: scale(1.05); }
  to { transform: scale(1.12); }
}

.hero-bg::after {
  content: '';
  position: absolute;
  inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
  opacity: 0.4;
  pointer-events: none;
}

.hero::after {
  content: '';
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 200px;
  background: linear-gradient(to top, var(--ivory), transparent);
  pointer-events: none;
}

.hero-content {
  position: relative;
  z-index: 2;
  text-align: center;
  max-width: 900px;
  padding: 0 40px;
  animation: heroFadeUp 1.4s var(--ease) both;
}

@keyframes heroFadeUp {
  from { opacity: 0; transform: translateY(50px); }
  to { opacity: 1; transform: translateY(0); }
}

.hero-eyebrow {
  font-size: 11px;
  font-weight: 500;
  letter-spacing: 5px;
  text-transform: uppercase;
  color: var(--gold-light);
  margin-bottom: 28px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 16px;
}

.hero-eyebrow::before, .hero-eyebrow::after {
  content: '';
  width: 40px;
  height: 1px;
  background: var(--gold-light);
  opacity: 0.6;
}

.hero h1 {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(52px, 7vw, 96px);
  font-weight: 300;
  line-height: 1.08;
  color: var(--white);
  margin-bottom: 28px;
  letter-spacing: -1px;
}

.hero h1 em { font-style: italic; color: var(--gold-light); }

.hero-sub {
  font-size: 15px;
  font-weight: 300;
  color: rgba(255,255,255,0.75);
  line-height: 1.8;
  max-width: 560px;
  margin: 0 auto 52px;
  letter-spacing: 0.3px;
}

.hero-ctas { display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; }

.btn-primary {
  padding: 18px 44px;
  background: var(--terracotta);
  color: var(--white);
  font-family: 'Poppins', sans-serif;
  font-size: 12px;
  font-weight: 600;
  letter-spacing: 2.5px;
  text-transform: uppercase;
  text-decoration: none;
  border: none;
  border-radius: 2px;
  cursor: pointer;
  transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
  position: relative;
  overflow: hidden;
  display: inline-block;
}

.btn-primary span { position: relative; z-index: 1; }
.btn-primary:hover { background: var(--terracotta-light); transform: translateY(-3px); }

.btn-secondary {
  padding: 17px 44px;
  background: transparent;
  color: var(--white);
  font-family: 'Poppins', sans-serif;
  font-size: 12px;
  font-weight: 500;
  letter-spacing: 2.5px;
  text-transform: uppercase;
  text-decoration: none;
  border: 1px solid rgba(255,255,255,0.45);
  border-radius: 2px;
  cursor: pointer;
  transition: all 0.35s ease;
  backdrop-filter: blur(10px);
  display: inline-block;
}

.btn-secondary:hover { background: rgba(255,255,255,0.12); border-color: rgba(255,255,255,0.7); }

.scroll-hint {
  position: absolute;
  bottom: 48px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 2;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  color: rgba(255,255,255,0.5);
  font-size: 10px;
  letter-spacing: 3px;
  text-transform: uppercase;
  animation: scrollBob 2s ease-in-out infinite;
}

@keyframes scrollBob {
  0%, 100% { transform: translateX(-50%) translateY(0); }
  50% { transform: translateX(-50%) translateY(6px); }
}

.scroll-line { width: 1px; height: 50px; background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.4)); }

/* ═══════════════════════════════════════
   SECTION STYLES
═══════════════════════════════════════ */
section { padding: 120px 60px; }

.section-label {
  font-size: 10px;
  font-weight: 600;
  letter-spacing: 5px;
  text-transform: uppercase;
  color: var(--terracotta);
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  gap: 14px;
}

.section-label::before { content: ''; width: 30px; height: 1px; background: var(--terracotta); }

.section-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(40px, 5vw, 68px);
  font-weight: 400;
  line-height: 1.1;
  color: var(--brown-dark);
  margin-bottom: 20px;
}

.section-title em { font-style: italic; color: var(--terracotta); }

.section-sub { font-size: 15px; font-weight: 300; color: var(--text-muted); line-height: 1.9; max-width: 520px; }

/* ═══════════════════════════════════════
   EVENTS WE HOST
═══════════════════════════════════════ */
/* ═══════════════════════════════════════
   EVENTS WE HOST (EXACT REF MATCH)
   ═══════════════════════════════════════ */
.events-section { 
    background: #f7f3f0;
    padding: 100px 0; 
    position: relative; 
}

.events-header { 
    margin: 0 auto 60px; 
    padding: 0 20px;
}




.events-header .section-label {
    font-size: 11px;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #8c6a5a;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.events-header .section-label::before {
    content: "";
    width: 24px;
    height: 1px;
    background: #8c6a5a;
}

.events-header .section-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 64px;
    font-weight: 300;
    color: #2c1a0e;
    margin-bottom: 24px;
    line-height: 1.1;
}
.events-header .section-title em { font-style: italic; color: #8c6a5a; }

.events-header .section-sub {
    font-size: 16px;
    color: #7a6e65;
    max-width: 500px;
    line-height: 1.7;
    margin: 0;
    font-weight: 300;
}

.events-grid { 
    display: grid; 
    grid-template-columns: repeat(4, 1fr); 
    gap: 24px; 
    max-width: 1200px; 
    margin: 0 auto; 
    padding: 0 20px;
}

.event-card {
  background: #ffffff;
  border-radius: 32px;
  padding: 40px 20px;
  border: 1.5px solid #d4c4a8; /* Permanent visible border */
  box-shadow: 0 15px 45px rgba(45, 27, 14, 0.05);
  transition: all 0.4s var(--ease);
  text-align: center;
  aspect-ratio: 1 / 1;
  height: auto;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-decoration: none;
}

.event-card:hover { 
    transform: translateY(-8px); 
    box-shadow: 0 25px 60px rgba(164, 112, 58, 0.12);
    border-color: #8c6a5a;
}

.event-icon-wrap {
  width: 54px;
  height: 54px;
  background: #fdfaf7;
  border-radius: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 20px;
  font-size: 26px;
  border: 1px solid rgba(0,0,0,0.03);
}

.event-card h3 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 22px;
  font-weight: 500;
  color: #3d2b1f;
  margin: 0;
  line-height: 1.2;
}

@media (max-width: 1024px) {
    .events-grid { grid-template-columns: repeat(2, 1fr); gap: 20px; }
    .events-header .section-title { font-size: 48px; }
}

@media (max-width: 480px) {
    .events-section { padding: 40px 0; }
    .events-header { margin-bottom: 30px; padding: 0 15px; }
    .events-header .section-label { font-size: 9px; margin-bottom: 8px; }
    .events-header .section-title { font-size: 32px; margin-bottom: 12px; }
    .events-header .section-sub { font-size: 13px; line-height: 1.5; }

    .events-grid { 
        grid-template-columns: repeat(2, 1fr); 
        gap: 12px; 
        padding: 0 12px; 
    }
    
    /* One card per row on very small screens if space doesn't allow */
    @media (max-width: 360px) {
        .events-grid { grid-template-columns: 1fr; }
    }

    .event-card { 
        height: auto; 
        aspect-ratio: 1 / 1;
        padding: 15px 8px; 
        border-radius: 22px; 
        border: 1.2px solid #d4c4a8; /* Permanent visible border */
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.04);
    }
    .event-icon-wrap { 
        width: 42px; 
        height: 42px; 
        font-size: 22px; 
        margin-bottom: 10px; 
        border-radius: 14px;
    }
    .event-card h3 { 
        font-size: 14px; 
        padding: 0 4px; 
        line-height: 1.2;
    }
}

.event-card p, .event-arrow { display: none; }

/* ═══════════════════════════════════════
   PRICING SECTION (REDESIGN)
═══════════════════════════════════════ */
.pricing-section { 
    background: #2a1b12; 
    position: relative; 
    overflow: hidden; 
    padding: 60px 20px !important; 
}

.pricing-inner { 
    max-width: 1100px; 
    margin: 0 auto; 
    display: grid; 
    grid-template-columns: 1.1fr 0.9fr; 
    gap: 60px; 
    align-items: center; 
}

.pricing-content .section-label { 
    color: var(--gold-light); 
    margin-bottom: 8px; 
    font-size: 9px;
    letter-spacing: 4px;
    text-transform: uppercase;
}
.pricing-content .section-label::before { background: var(--gold-light); width: 25px; }

.pricing-content .section-title { 
    color: var(--white); 
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(32px, 4vw, 46px); 
    line-height: 1.1; 
    margin-bottom: 15px; 
    font-weight: 300;
}
.pricing-content .section-title em { 
    color: var(--gold-light); 
    font-style: italic; 
    font-family: 'Cormorant Garamond', serif;
}

.pricing-content .section-sub { 
    color: rgba(255,255,255,0.55); 
    font-size: 13.5px; 
    max-width: 440px; 
    margin-bottom: 28px; 
    line-height: 1.6;
}

.pricing-feature-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px 30px;
    margin-bottom: 40px;
}

.pricing-feature-item {
    background: transparent;
    border: none;
    padding: 0;
    border-radius: 0;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: all 0.3s var(--ease);
}

.pricing-feature-item:hover {
    transform: translateX(5px);
}

.pricing-feature-icon {
    width: 24px;
    height: 24px;
    background: transparent;
    border-radius: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gold-light);
    font-size: 16px;
}

.pricing-feature-text {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 300;
    letter-spacing: 0.5px;
}

.btn-pricing-cta {
    padding: 14px 36px;
    background: linear-gradient(135deg, #c9a96e, #a6703a);
    color: var(--white);
    text-transform: uppercase;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 2.5px;
    border-radius: 100px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.4s var(--ease);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

.btn-pricing-cta:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(166, 112, 58, 0.4);
    filter: brightness(1.1);
}

.pricing-visual {
    position: relative;
    padding: 0;
}

.pricing-img-wrap { 
    border-radius: 24px; 
    overflow: hidden; 
    aspect-ratio: 4 / 5; 
    box-shadow: 0 25px 60px rgba(0,0,0,0.5); 
    border: 1px solid rgba(255,255,255,0.05);
}
.pricing-img-wrap img { width: 100%; height: 100%; object-fit: cover; }

.pricing-badge {
  position: absolute;
  bottom: 20px;
  left: 20px;
  right: 20px;
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-radius: 16px;
  padding: 20px 24px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.4);
  border: 1px solid rgba(255,255,255,0.12);
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: linear-gradient(135deg, rgba(253, 250, 247, 0.12), rgba(166, 112, 58, 0.15));
}

.pricing-badge-label { 
    font-size: 9px; 
    font-weight: 600; 
    text-transform: uppercase; 
    color: var(--gold-light); 
    letter-spacing: 2px;
    margin-bottom: 0;
}
.pricing-badge-value { 
    font-family: 'Cormorant Garamond', serif; 
    font-size: 26px; 
    color: var(--white); 
    font-weight: 400;
    line-height: 1;
}


/* ═══════════════════════════════════════
   AMENITIES
═══════════════════════════════════════ */
.amenities-section { 
    background: var(--ivory); 
    text-align: center; 
    padding: 60px 20px !important; 
}
.amenities-header { margin-bottom: 40px; }
.amenities-header .section-label { justify-content: center; margin-bottom: 8px; }
.amenities-header .section-label::before { display: none; }
.amenities-header .section-title { margin-bottom: 12px; }
.amenities-header .section-sub { margin: 0 auto; }

.amenities-swiper {
  max-width: 1300px;
  margin: 0 auto;
  padding: 0 60px 40px 60px !important;
  overflow: hidden;
}

.amenity-card {
  background: var(--white);
  border-radius: 24px;
  padding: 48px 32px;
  border: 1px solid rgba(212, 196, 168, 0.2);
  box-shadow: 0 10px 40px rgba(45, 27, 14, 0.05);
  transition: all 0.4s ease;
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.amenity-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 50px rgba(164, 112, 58, 0.1);
}

.amenity-icon { font-size: 32px; margin-bottom: 24px; display: block; }
.amenity-card h4 { font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 600; color: var(--brown-dark); margin-bottom: 12px; }
.amenity-card p { font-size: 13px; color: var(--text-muted); font-weight: 300; line-height: 1.6; }

/* ═══════ CUSTOM PILL PAGINATION ═══════ */
.swiper-pagination {
    position: relative !important;
    bottom: 0 !important;
    margin-top: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
}

.swiper-pagination-bullet {
    width: 10px;
    height: 10px;
    background: #e8dccb !important;
    opacity: 1 !important;
    border-radius: 20px;
    transition: all 0.4s var(--ease);
    border: none;
}

.amenities-section .swiper-pagination-bullet-active {
    width: 40px;
    background: var(--terracotta) !important;
}

.gallery-section .swiper-pagination-bullet-active {
    width: 40px;
    background: #007aff !important; /* Blue as seen in gallery screenshot */
}

.gallery-section .swiper-pagination-bullet {
    background: #d0d7de !important;
}

/* Hide Navigation Arrows for these sections */
.amenities-section .swiper-button-next, 
.amenities-section .swiper-button-prev,
.gallery-section .swiper-button-next,
.gallery-section .swiper-button-prev {
    display: none !important;
}

/* ═══════════════════════════════════════
   GALLERY
═══════════════════════════════════════ */
.gallery-section { 
    background: var(--cream); 
    padding: 80px 0 !important; 
    width: 100%; 
    overflow: hidden;
}

.gallery-header { text-align: center; margin-bottom: 48px; }
.gallery-header .section-label { justify-content: center; margin-bottom: 8px; }
.gallery-header .section-label::before { display: none; }
.gallery-header .section-title { margin-bottom: 12px; }

.gallery-swiper { 
    width: 100%; 
    padding: 20px 30px 80px !important; 
    overflow: hidden !important;
}

.gallery-swiper .swiper-slide {
    width: 100%;
}

.gallery-item { 
    position: relative; 
    border-radius: 28px; 
    overflow: hidden; 
    aspect-ratio: 1.4 / 1;
    width: 100%;
    cursor: pointer; 
    box-shadow: 0 15px 35px rgba(45, 27, 14, 0.1);
    transition: all 0.5s var(--ease);
}

.gallery-item img { 
    width: 100%; 
    height: 100%; 
    object-fit: cover; 
    transition: transform 0.8s var(--ease); 
}
.gallery-item:hover img { transform: scale(1.05); }

.gallery-overlay { display: none; }

.gallery-item:hover .gallery-overlay { opacity: 1; }
.gallery-label { font-family: 'Cormorant Garamond', serif; font-size: 20px; color: var(--white); font-style: italic; }

/* ═══════════════════════════════════════
   PROCESS
═══════════════════════════════════════ */
.process-section { 
    background: var(--brown-dark); 
    text-align: center; 
    padding: 60px 20px !important; 
}
.process-section .section-label { color: var(--gold-light); justify-content: center; margin-bottom: 8px; }
.process-section .section-label::before { display: none; }
.process-section .section-title { color: var(--white); margin-bottom: 0; }
.process-section .section-title em { color: var(--gold-light); }

.process-steps { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; max-width: 1100px; margin: 40px auto 0; }
.step-number {
  width: 72px;
  height: 72px;
  border-radius: 50%;
  background: rgba(201,169,110,0.1);
  border: 1px solid rgba(201,169,110,0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 20px;
  font-family: 'Cormorant Garamond', serif;
  font-size: 24px;
  color: var(--gold-light);
}

.process-step h3 { font-family: 'Cormorant Garamond', serif; font-size: 24px; color: var(--white); margin-bottom: 8px; }
.process-step p { font-size: 13px; color: rgba(255,255,255,0.5); line-height: 1.8; }

/* ═══════════════════════════════════════
   INQUIRY FORM
═══════════════════════════════════════ */
.inquiry-section {
    background: var(--ivory);
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}
.inquiry-section::before {
    content: '';
    position: absolute;
    top: -10%;
    right: -5%;
    width: 40%;
    height: 60%;
    background: radial-gradient(circle, rgba(196, 113, 74, 0.05) 0%, transparent 70%);
    pointer-events: none;
}

.inquiry-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 30px;
    display: grid;
    grid-template-columns: 1.2fr 0.8fr;
    gap: 60px;
    align-items: start;
}

@media (max-width: 1024px) {
    .inquiry-container {
        grid-template-columns: 1fr;
        gap: 40px;
    }
}

.inquiry-content .section-label {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    color: var(--terracotta);
    font-size: 11px;
    letter-spacing: 4px;
    text-transform: uppercase;
    font-weight: 600;
    margin-bottom: 24px;
}

.inquiry-content .section-label i {
    font-size: 14px;
}

.inquiry-content h2 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(40px, 4.5vw, 64px);
    line-height: 1.1;
    color: var(--brown-dark);
    margin-bottom: 24px;
}

.inquiry-content h2 em {
    font-style: italic;
    color: var(--terracotta);
}

.inquiry-benefits {
    margin-top: 48px;
    display: flex;
    flex-direction: column;
    gap: 32px;
}

.benefit-item {
    display: flex;
    gap: 20px;
}

.benefit-icon {
    width: 54px;
    height: 54px;
    min-width: 54px;
    background: var(--white);
    border: 1px solid var(--sand);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: var(--terracotta);
    box-shadow: 0 10px 25px var(--shadow-warm);
    transition: all 0.4s var(--ease);
}

.benefit-item:hover .benefit-icon {
    transform: translateY(-5px) rotate(5deg);
    border-color: var(--terracotta);
    color: var(--white);
    background: var(--terracotta);
}

.benefit-text h5 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 20px;
    color: var(--brown-dark);
    margin-bottom: 6px;
}

.benefit-text p {
    font-size: 13px;
    color: var(--text-muted);
    line-height: 1.6;
    margin: 0;
}

/* Form Styling */
/* ═══════════════════════════════════════
   MODERN LUXURY FORM REDESIGN
═══════════════════════════════════════ */
.form-main-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(36px, 4vw, 52px);
    color: var(--brown-dark);
    margin-top: 10px;
}

.label-caps {
    font-size: 10px !important;
    font-weight: 700 !important;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #8c7662;
    margin-bottom: 12px !important;
    display: block;
}

.premium-form-card {
    background: var(--white);
    border-radius: 32px;
    padding: 60px;
    box-shadow: 0 40px 100px var(--shadow-deep);
    border: 1px solid rgba(212, 196, 168, 0.3);
    position: relative;
    max-width: 1000px;
    margin: 0 auto;
}

.input-luxury {
    width: 100%;
    padding: 16px 20px;
    background: #fdfaf7;
    border: 1px solid #f0e6da;
    border-radius: 14px;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    color: var(--brown-dark);
    transition: all 0.3s ease;
}

.input-luxury:focus {
    background: var(--white);
    border-color: var(--terracotta);
    box-shadow: 0 0 0 4px rgba(196, 113, 74, 0.05);
    outline: none;
}

.input-icon-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.input-prefix-text {
    position: absolute;
    left: 20px;
    font-weight: 500;
    color: var(--terracotta);
    opacity: 0.6;
}

/* Stay Toggle Pill */
.stay-pill-selector {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #fdfaf7;
    padding: 15px 25px;
    border-radius: 16px;
    border: 1px solid #f0e6da;
}

.stay-toggle-wrap-new {
    display: flex;
    background: #f3ede6;
    padding: 4px;
    border-radius: 50px;
    width: 160px;
}

.stay-btn {
    flex: 1;
    cursor: pointer;
    margin-bottom: 0 !important;
}

.stay-btn input { display: none; }

.stay-btn-ui {
    display: block;
    text-align: center;
    padding: 8px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 700;
    color: #a48e7a;
    transition: all 0.3s ease;
}

.stay-btn input:checked + .stay-btn-ui {
    background: var(--white);
    color: var(--terracotta);
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

/* Divider */
.form-divider-dashed {
    height: 1px;
    border-top: 1px dashed #dccdb4;
    margin: 50px 0;
    width: 100%;
}

/* Requirements Section */
.requirements-section-new {
    margin-bottom: 40px;
}

.section-header-small {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 25px;
}

.section-header-small i {
    font-size: 18px;
}

.req-grid-new {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 15px;
}

.req-card {
    cursor: pointer;
    margin-bottom: 0 !important;
}

.req-card input { display: none; }

.req-card-ui {
    height: 100px;
    background: var(--white);
    border: 1px solid #f0e6da;
    border-radius: 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s ease;
}

.req-card-icon {
    font-size: 24px;
    color: var(--terracotta);
    opacity: 0.8;
    transition: all 0.3s ease;
}

.req-card:hover .req-card-icon {
    opacity: 1;
    transform: scale(1.1);
}

.req-card-label {
    font-size: 10px;
    font-weight: 700;
    color: #4a3b2e;
    text-align: center;
}

.req-card:hover .req-card-ui {
    border-color: var(--terracotta);
    transform: translateY(-3px);
}

.req-card input:checked + .req-card-ui {
    border-color: var(--terracotta);
    background: #fff9f5;
    box-shadow: 0 10px 25px rgba(196, 113, 74, 0.1);
}

/* Proposal Button */
.btn-bespoke-proposal {
    width: 100%;
    padding: 22px;
    background: #342116;
    color: var(--white);
    border: none;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    transition: all 0.4s ease;
    box-shadow: 0 15px 35px rgba(52, 33, 22, 0.2);
}

.btn-bespoke-proposal:hover {
    background: #251710;
    transform: translateY(-3px);
    box-shadow: 0 20px 45px rgba(52, 33, 22, 0.3);
}

.btn-bespoke-proposal i {
    font-size: 16px;
    transition: transform 0.3s ease;
}

.btn-bespoke-proposal:hover i {
    transform: translateX(5px);
}

/* Validation */
.form-group-p.error .input-luxury {
    border-color: #e74c3c;
    background: #fffcfc;
}

.form-error-hint {
    font-size: 10px;
    color: #e74c3c;
    margin-top: 4px;
    display: none;
    animation: fadeIn 0.3s ease;
}

.form-group-p.error .form-error-hint {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Responsive Overrides */
.form-sub-title-serif {
    font-family: 'Cormorant Garamond', serif;
    font-size: 28px;
    color: var(--brown-dark);
}

.stay-card-dynamic {
    background: #fdfaf7;
    border: 1px dashed #dccdb4;
    border-radius: 20px;
    padding: 30px;
    transition: all 0.4s ease;
}

@media (max-width: 1024px) {
    .req-grid-new { grid-template-columns: repeat(3, 1fr); }
    .premium-form-card { padding: 40px; }
}

@media (max-width: 768px) {
    .inquiry-section { padding: 60px 0; }
    .req-grid-new { grid-template-columns: repeat(2, 1fr); }
    .stay-pill-selector { flex-direction: column; gap: 15px; align-items: flex-start; }
    .stay-toggle-wrap-new { width: 100%; }
    .stay-card-dynamic { padding: 20px; }
}

/* ═══════════════════════════════════════
   OFFICIAL BRAND FOOTER
═══════════════════════════════════════ */

/* ═══════════════════════════════════════
   UTILITIES & REVEAL
═══════════════════════════════════════ */
.reveal { opacity: 0; transform: translateY(30px); transition: 1s var(--ease); }
.reveal.visible { opacity: 1; transform: translateY(0); }
.reveal-delay-1 { transition-delay: 0.1s; }
.reveal-delay-2 { transition-delay: 0.2s; }

@media (max-width: 1024px) {
  nav { padding: 20px 30px; }
  .events-grid, .amenities-grid { grid-template-columns: repeat(2, 1fr); }
  .footer-inner { grid-template-columns: 1fr 1fr; gap: 40px; }
  .inquiry-inner { grid-template-columns: 1fr; gap: 60px; }
}
@media (max-width: 640px) {
  .nav-links { display: none; }
.form-group.error input, .form-group.error select { border-color: #ff4d4d; background: rgba(255, 77, 77, 0.03); }
.error-msg { font-size: 10px; color: #ff4d4d; margin-top: 4px; display: none; }
.form-group.error .error-msg { display: block; }

.property-select-wrap {
    display: none;
    margin-top: 20px;
    padding: 24px;
    background: var(--cream);
    border-radius: 16px;
    border: 1px solid var(--sand);
    animation: slideDown 0.4s var(--ease) both;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.property-options {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-top: 12px;
}

.prop-opt {
    cursor: pointer;
    position: relative;
}

.prop-opt input { display: none; }

.prop-opt-card {
    padding: 16px;
    background: var(--white);
    border: 1.5px solid var(--sand);
    border-radius: 12px;
    text-align: center;
    transition: all 0.3s ease;
}

.prop-opt input:checked + .prop-opt-card {
    border-color: var(--terracotta);
    background: var(--white);
    box-shadow: 0 4px 15px rgba(196, 113, 74, 0.15);
}

.prop-opt-card h6 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 16px;
    margin: 0;
    color: var(--brown-dark);
}

  .amenities-swiper, .pricing-inner, .process-steps { grid-template-columns: 1fr; }
  .pricing-feature-grid { grid-template-columns: repeat(2, 1fr); }
  
  /* Mobile Pricing Tweaks */
  .pricing-section { padding: 40px 20px !important; }
  .pricing-inner { gap: 30px; }
  .pricing-content .section-title { font-size: 32px; }
  .pricing-feature-item { padding: 8px 12px; }
  .pricing-feature-text { font-size: 10px; }
  .pricing-img-wrap { aspect-ratio: 1.2 / 1; }
  .pricing-badge { padding: 12px 20px; bottom: 15px; left: 15px; right: 15px; }
  .pricing-badge-value { font-size: 20px; }
  .hero h1 { font-size: 48px; }
  .inquiry-form { padding: 30px 20px; }
  .form-row { grid-template-columns: 1fr; }
}



/* ═══════ FLOAT STACK ═══════ */
/* Success Modal */
.success-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(45, 27, 14, 0.85);
    backdrop-filter: blur(10px);
    z-index: 2000;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.5s var(--ease);
}

.success-modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.success-modal-card {
    background: var(--white);
    width: 90%;
    max-width: 500px;
    padding: 60px 40px;
    border-radius: 32px;
    text-align: center;
    transform: scale(0.9) translateY(20px);
    transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.success-modal-overlay.active .success-modal-card {
    transform: scale(1) translateY(0);
}

.success-icon-wrap {
    width: 100px;
    height: 100px;
    background: var(--ivory);
    color: var(--terracotta);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
    margin: 0 auto 30px;
    box-shadow: 0 15px 35px rgba(250, 135, 62, 0.15);
}

.success-modal-card h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 32px;
    color: var(--brown-dark);
    margin-bottom: 15px;
}

.success-modal-card p {
    font-size: 15px;
    color: var(--text-muted);
    line-height: 1.6;
    margin-bottom: 35px;
}

.btn-modal-close {
    padding: 15px 40px;
    background: var(--terracotta);
    color: var(--white);
    border: none;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-modal-close:hover {
    background: var(--brown-dark);
    transform: translateY(-2px);
}
</style>
</head>
<body>

    <x-navbar :isHome="false" />

@if($hero['status'] ?? true)
<!-- HERO -->
<section class="hero" id="home">
  <div class="hero-bg" style="background-image: 
    linear-gradient(160deg, rgba(45,27,14,0.72) 0%, rgba(100,60,30,0.55) 40%, rgba(196,113,74,0.3) 100%),
    url('{{ !empty($hero['image']) ? $hero['image'] : '/images/event-hero-main.jpg' }}');"></div>
  <div class="hero-content">
    <p class="hero-eyebrow">{{ $hero['eyebrow'] ?? 'Parudeesa Lakeside Resort' }}</p>
    <h1>{!! $hero['title'] ?? 'Host <em>unforgettable</em><br>celebrations by the lake' !!}</h1>
    <p class="hero-sub">{{ $hero['subtitle'] ?? '' }}</p>
    <div class="hero-ctas">
      @if($hero['cta_1_text'] ?? '')
      <a href="{{ $hero['cta_1_link'] ?? '#' }}" class="btn-primary"><span>{{ $hero['cta_1_text'] }}</span></a>
      @endif
      @if($hero['cta_2_text'] ?? '')
      <a href="{{ $hero['cta_2_link'] ?? '#' }}" class="btn-secondary">{{ $hero['cta_2_text'] }}</a>
      @endif
    </div>
  </div>
  <div class="scroll-hint">
    <div class="scroll-line"></div>
    Scroll
  </div>
</section>
@endif

<!-- EVENTS -->
<section class="events-section" id="events">
  @php
      $refCards = [
          ['title' => 'Birthday Parties', 'icon' => '🎂'],
          ['title' => 'Bride / Groom To Be', 'icon' => '💍'],
          ['title' => 'Pre-Wedding Celebrations', 'icon' => '🌸'],
          ['title' => 'Weddings', 'icon' => '💒'],
          ['title' => 'Day Out & Corporate', 'icon' => '🏢'],
          ['title' => 'Family Gatherings', 'icon' => '🌿'],
          ['title' => 'Gender Reveal Parties', 'icon' => '✨'],
          ['title' => 'Honeymoon Staycation', 'icon' => '🏡'],
      ];
  @endphp
  <div class="events-header reveal">
    <div>
      <p class="section-label">Celebrations We Craft</p>
      <h2 class="section-title">Events we <em>host</em></h2>
    </div>
    <p class="section-sub">Every occasion is an art form. We bring your vision to life with precision, warmth, and lakeside magic.</p>
  </div>

  <div class="events-grid">
    @forelse($cards->count() > 0 ? $cards : (collect($refCards)) as $card)
      <div class="event-card reveal">
        <div class="event-icon-wrap">
          {{ is_array($card) ? $card['icon'] : $card->icon }}
        </div>
        <h3>{{ is_array($card) ? $card['title'] : $card->title }}</h3>
      </div>
    @empty
      <!-- No cards available -->
    @endforelse
  </div>
</section>

@if($pricing['status'] ?? true)
<!-- PRICING (REDESIGN) -->
<section class="pricing-section" id="pricing">
    <div class="pricing-inner">
        <div class="pricing-content reveal">
            <p class="section-label">{{ $pricing['label'] ?? 'Tailored To You' }}</p>
            <h2 class="section-title">{!! $pricing['title'] ?? 'Custom <em>pricing</em><br>for every vision' !!}</h2>
            <p class="section-sub">{{ $pricing['subtitle'] ?? '' }}</p>
            
            <div class="pricing-feature-grid">
                @forelse($pricingFeatures as $feature)
                <div class="pricing-feature-item">
                    <div class="pricing-feature-icon">
                        <i class="bi {{ $feature->icon ?? 'bi-check2-circle' }}"></i>
                    </div>
                    <span class="pricing-feature-text">{{ $feature->text }}</span>
                </div>
                @empty
                @php
                    $defaultFeatures = [
                        'Luxury Lakeside Venues',
                        'Bespoke Decor & Lighting',
                        'Premium Catering Services',
                        'Professional Event Concierge'
                    ];
                @endphp
                @foreach($defaultFeatures as $f)
                <div class="pricing-feature-item">
                    <div class="pricing-feature-icon"><i class="bi bi-check2-circle"></i></div>
                    <span class="pricing-feature-text">{{ $f }}</span>
                </div>
                @endforeach
                @endforelse
            </div>

            <a href="#inquiry" class="btn-pricing-cta">
                {{ $pricing['cta_text'] ?? 'REQUEST CUSTOM QUOTE' }}
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="pricing-visual reveal reveal-delay-1">
            <div class="pricing-img-wrap">
                <img src="{{ !empty($pricing['image']) ? $pricing['image'] : '/images/events-custom.png' }}" alt="Luxury Event Setup">
            </div>
            
            <div class="pricing-badge">
                <div class="pricing-badge-info">
                    <p class="pricing-badge-label">{{ $pricing['badge_label'] ?? 'STARTING FROM' }}</p>
                    <h4 class="pricing-badge-value">{{ $pricing['badge_value'] ?? 'Bespoke' }}</h4>
                </div>
                <div class="pricing-badge-icon">
                    <i class="bi bi-stars text-[#c9a96e]" style="font-size: 24px;"></i>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- AMENITIES -->
<section class="amenities-section" id="amenities">
  <div class="amenities-header reveal">
    <p class="section-label">What We Offer</p>
    <h2 class="section-title">Amenities &amp; <em>Experiences</em></h2>
    <p class="section-sub">Every comfort considered, every moment elevated. We offer everything you need for a seamless celebration.</p>
  </div>

  <div class="amenities-swiper swiper">
    <div class="swiper-wrapper">
      @forelse($amenities as $amenity)
      <div class="swiper-slide">
        <div class="amenity-card reveal">
          <span class="amenity-icon">{{ $amenity->icon }}</span>
          <h4>{{ $amenity->title }}</h4>
          <p>{{ $amenity->description }}</p>
        </div>
      </div>
      @empty
      @php
        $defaultAmenities = [
            ['title' => 'Swimming Pool', 'icon' => '🏊', 'desc' => 'Enjoy our crystal clear lakeside pool for relaxation and fun.'],
            ['title' => 'DJ & Music', 'icon' => '🎧', 'desc' => 'Premium sound systems and professional DJs for your celebration.'],
            ['title' => 'Boat Rides', 'icon' => '🛥️', 'desc' => 'Exclusive access to the backwaters for you and your guests.'],
            ['title' => 'Lakeside Property', 'icon' => '🏞️', 'desc' => 'Nestled by the edge with panoramic views of the backwaters.']
        ];
      @endphp
      @foreach($defaultAmenities as $a)
      <div class="swiper-slide">
        <div class="amenity-card reveal">
          <span class="amenity-icon">{{ $a['icon'] }}</span>
          <h4>{{ $a['title'] }}</h4>
          <p>{{ $a['desc'] }}</p>
        </div>
      </div>
      @endforeach
      @endforelse
    </div>
    <div class="swiper-pagination"></div>
  </div>
</section>

<!-- GALLERY -->
<section class="gallery-section" id="gallery">
  <div class="gallery-header reveal">
    <p class="section-label">Moments Captured</p>
    <h2 class="section-title">Event <em>Gallery</em></h2>
  </div>

  <div class="gallery-swiper swiper">
    <div class="swiper-wrapper">
      @forelse($gallery as $item)
      <div class="swiper-slide">
        <div class="gallery-item reveal"><img src="{{ $item->image }}"></div>
      </div>
      @empty
      @php
        $defaultGallery = [
            '/images/event-gallery-1.jpg',
            '/images/event-gallery-2.jpg',
            '/images/event-gallery-3.jpg',
            '/images/event-gallery-4.jpg'
        ];
      @endphp
      @foreach($defaultGallery as $img)
      <div class="swiper-slide">
        <div class="gallery-item reveal"><img src="{{ $img }}"></div>
      </div>
      @endforeach
      @endforelse
    </div>
    <div class="swiper-pagination"></div>
  </div>
</section>

<!-- PROCESS -->
<section class="process-section">
  <div class="container">
    <p class="section-label reveal">Simple Planning</p>
    <h2 class="section-title reveal">Effortless <em>journey</em></h2>
    <div class="process-steps">
      @forelse($steps as $step)
      <div class="process-step reveal">
        <div class="step-number">{{ str_pad($step->step_number ?? $loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
        <h3>{{ $step->title }}</h3>
        <p>{{ $step->description }}</p>
      </div>
      @empty
      @php
        $defaultSteps = [
            ['title' => 'Consultation', 'desc' => 'Discuss your vision with our experts.'],
            ['title' => 'Curation', 'desc' => 'We handle every detail of your event.'],
            ['title' => 'Celebration', 'desc' => 'Enjoy your timeless lakeside event.']
        ];
      @endphp
      @foreach($defaultSteps as $s)
      <div class="process-step reveal">
        <div class="step-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
        <h3>{{ $s['title'] }}</h3>
        <p>{{ $s['desc'] }}</p>
      </div>
      @endforeach
      @endforelse
    </div>
  </div>
</section>


<section class="inquiry-section" id="inquiry">
    <div class="container d-flex justify-content-center">
        <!-- Form Side -->
        <div class="inquiry-form-wrap reveal w-100" style="max-width: 900px;">
            <div class="text-center mb-5">
                <p class="section-label justify-content-center">Bespoke Proposal</p>
                <h2 class="form-main-title">Plan Your <em>Celebration</em></h2>
                <p class="eb mt-3 text-muted" style="font-size: 1.1rem; max-width: 650px; margin: 0 auto; line-height: 1.6;">Plan your event at Parudeesa for a truly magical experience, where every detail is crafted with care and elegance.</p>
            </div>

            <div class="premium-form-card">
                <div class="form-decoration-leaf"></div>
                
                <form id="eventInquiryForm" action="{{ route('events.inquiry') }}" method="POST">
                    @csrf
                    
                    <div class="row g-4">
                        <!-- Row 1: Name | Phone -->
                        <div class="col-md-6">
                            <div class="form-group-p">
                                <label class="label-caps">Full Name</label>
                                <input type="text" name="name" class="input-luxury" placeholder="e.g. Rahul Sharma" required>
                                <div class="form-error-hint">Your name is required</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-p">
                                <label class="label-caps">Phone Number</label>
                                <input type="tel" name="phone" class="input-luxury" placeholder="98765 43210" maxlength="10" minlength="10" required>
                                <div class="form-error-hint">A valid 10-digit phone number is required</div>
                            </div>
                        </div>

                        <!-- Row 2: Event Type | Guest Count -->
                        <div class="col-md-6">
                            <div class="form-group-p">
                                <label class="label-caps">Event Type</label>
                                <div class="select-luxury-wrap">
                                    <select name="event_type" class="input-luxury" required>
                                        <option value="" disabled selected>Select celebration type</option>
                                        <option>Wedding & Pre-Wedding</option>
                                        <option>Birthday Celebration</option>
                                        <option>Gender Reveal Party</option>
                                        <option>Honeymoon Staycation</option>
                                        <option>Corporate Retreat</option>
                                        <option>Family Gathering</option>
                                        <option>Other Event</option>
                                    </select>
                                    <i class="bi bi-chevron-down select-icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-p">
                                <label class="label-caps">Guest Count</label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-people input-icon" style="left: 15px; font-size: 14px; opacity: 0.4;"></i>
                                    <input type="number" name="guests" class="input-luxury" style="padding-left: 45px;" placeholder="Approx. guests" required>
                                </div>
                            </div>
                        </div>

                        <!-- Row 3: Date | Property -->
                        <div class="col-md-6">
                            <div class="form-group-p">
                                <label class="label-caps">Event Date</label>
                                <input type="date" name="event_date" class="input-luxury" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-p">
                                <label class="label-caps">Preferred Property</label>
                                <div class="select-luxury-wrap">
                                    <select name="property_id" class="input-luxury" required>
                                        <option value="" disabled selected>Select location</option>
                                        <option value="1">The Paradise — Main Resort</option>
                                        <option value="2">Utopiya — Boutique Retreat</option>
                                    </select>
                                    <i class="bi bi-chevron-down select-icon"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Accommodation Section -->
                        <div class="col-12 mt-5">
                            <h4 class="form-sub-title-serif mb-4">Accommodation</h4>
                            <div class="form-group-p">
                                <div class="stay-pill-selector">
                                    <label class="label-caps mb-0">Need Stay?</label>
                                    <div class="stay-toggle-wrap-new">
                                        <label class="stay-btn">
                                            <input type="radio" name="need_stay" value="No" checked onchange="toggleStayCard(false)">
                                            <span class="stay-btn-ui">No</span>
                                        </label>
                                        <label class="stay-btn">
                                            <input type="radio" name="need_stay" value="Yes" onchange="toggleStayCard(true)">
                                            <span class="stay-btn-ui">Yes</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Dynamic Stay Card -->
                            <div id="dynamicStayCard" class="stay-card-dynamic d-none mt-4">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-group-p">
                                            <label class="label-caps">Staying Guests</label>
                                            <input type="number" name="stay_guests" id="stay_guests_input" class="input-luxury" placeholder="Number of guests">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group-p">
                                            <label class="label-caps">Check-in</label>
                                            <input type="date" name="check_in" class="input-luxury">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group-p">
                                            <label class="label-caps">Check-out</label>
                                            <input type="date" name="check_out" class="input-luxury">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-divider-dashed"></div>

                    <!-- Requirements Section -->
                    <div class="requirements-section-new">
                        <h4 class="form-sub-title-serif mb-4">Enhance Your Event</h4>
                        <div class="section-header-small">
                            <i class="bi bi-check2-circle text-terracotta"></i>
                            <span class="label-caps">Select Your Requirements</span>
                        </div>

                        <div class="req-grid-new">
                            @php 
                                $services = \App\Models\EventService::where('status', true)->get(); 
                            @endphp
                            @foreach($services as $s)
                            <label class="req-card">
                                <input type="checkbox" name="requirements[]" value="{{ $s->name }}">
                                <div class="req-card-ui">
                                    <div class="req-card-icon"><i class="bi {{ $s->icon ?: 'bi-check2-circle' }}"></i></div>
                                    <span class="req-card-label">{{ $s->name }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="row g-4 mt-2">
                        <!-- Row 5: Budget | Duration -->
                        <div class="col-md-6">
                            <div class="form-group-p">
                                <label class="label-caps">Estimated Budget (₹)</label>
                                <div class="input-icon-wrap">
                                    <span class="input-prefix-text">₹</span>
                                    <input type="text" name="budget" class="input-luxury" style="padding-left: 45px;" placeholder="e.g. 50,000 - 1,00,000">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-p">
                                <label class="label-caps">Event Duration</label>
                                <div class="input-icon-wrap">
                                    <i class="bi bi-clock input-icon" style="left: 15px; font-size: 14px; opacity: 0.4;"></i>
                                    <input type="text" name="event_duration" class="input-luxury" style="padding-left: 45px;" placeholder="e.g. 4 Hours / Full Day">
                                </div>
                            </div>
                        </div>

                        <!-- Row 6: Message -->
                        <div class="col-12">
                            <div class="form-group-p">
                                <label class="label-caps">Tell us your vision</label>
                                <textarea name="notes" class="input-luxury textarea-premium" rows="3" placeholder="Themes, dietary needs, or special requests..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="submit-wrap mt-5">
                        <button type="submit" id="submitBtn" class="btn-bespoke-proposal">
                            <span class="btn-text">Request Bespoke Proposal</span>
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                    
                    <div id="formMsg" class="mt-3 text-center d-none"></div>
                </form>
            </div>
        </div>

        </div>
    </div>
</section>

<!-- PLAN YOUR CELEBRATION SECTION -->
<section class="plan-celebration-sec py-5" style="background: var(--ivory); border-top: 1px solid rgba(160, 128, 96, 0.1);">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="label-caps mb-2 d-block" style="color: var(--terracotta); letter-spacing: 4px; font-size: 10px;">LET’S BEGIN</span>
            <h2 class="form-sub-title-serif" style="font-size: clamp(28px, 4vw, 42px); font-family: 'Cormorant Garamond', serif; font-weight: 600;">Create your <em class="text-terracotta" style="font-style: italic; color: var(--terracotta) !important;">timeless</em> celebration</h2>
            <p class="text-muted small mx-auto mt-3" style="max-width: 600px; font-family: 'Poppins', sans-serif;">From conceptualization to execution, our dedicated concierge team ensures every detail of your special day is handled with precision and care.</p>
        </div>

        <div class="row g-4 justify-content-center reveal">
            <!-- Card 1 -->
            <div class="col-md-4 col-sm-6">
                <div class="compact-feature-card">
                    <div class="cf-icon"><i class="bi bi-journal-richtext"></i></div>
                    <h5 class="cf-title">Bespoke Proposals</h5>
                    <p class="cf-desc">Tailored experience designs that reflect your unique vision and style.</p>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-md-4 col-sm-6">
                <div class="compact-feature-card">
                    <div class="cf-icon"><i class="bi bi-stars"></i></div>
                    <h5 class="cf-title">Expert Curation</h5>
                    <p class="cf-desc">Seamless management of vendors, decor, and logistics by our experts.</p>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-md-4 col-sm-6">
                <div class="compact-feature-card">
                    <div class="cf-icon"><i class="bi bi-shield-lock"></i></div>
                    <h5 class="cf-title">Exclusive Access</h5>
                    <p class="cf-desc">Premium priority booking and private access to our most secluded spots.</p>
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- Success Modal -->
    <div class="success-modal-overlay" id="successModal">
        <div class="success-modal-card">
            <div class="success-icon-wrap">
                <i class="bi bi-check2-circle"></i>
            </div>
            <h3 class="modal-success-title">Request Sent Successfully</h3>
            <p id="successModalMsg" class="modal-success-text">Your request has been sent successfully. Our team will connect with you within 4–5 hours. Thank you!</p>
            <button class="btn-modal-ok" onclick="closeSuccessModal()">OK</button>
        </div>
    </div>

<style>
/* ═══════════════════════════════════════
   INQUIRY FORM REDESIGN
═══════════════════════════════════════ */
.inquiry-section {
    background: var(--ivory);
    padding: 120px 0;
    position: relative;
}

.premium-form-card {
    background: #fff;
    padding: 60px;
    border-radius: 40px;
    box-shadow: 0 40px 100px rgba(45, 27, 14, 0.08);
    border: 1px solid rgba(212, 196, 168, 0.2);
    position: relative;
    overflow: hidden;
}

.form-decoration-leaf {
    position: absolute;
    top: -20px;
    right: -20px;
    width: 150px;
    height: 150px;
    background: radial-gradient(circle, rgba(196, 113, 74, 0.03) 0%, transparent 70%);
    pointer-events: none;
}

.form-step {
    margin-bottom: 50px;
}

.form-step:last-child {
    margin-bottom: 0;
}

.form-step-header {
    display: flex;
    gap: 20px;
    align-items: center;
    margin-bottom: 35px;
    border-bottom: 1px solid #f8f1e9;
    padding-bottom: 20px;
}

.step-icon {
    width: 54px;
    height: 54px;
    background: #fffaf5;
    border: 1px solid #f5e6d3;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: var(--terracotta);
    box-shadow: 0 8px 20px rgba(196, 113, 74, 0.08);
}

.form-step-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 26px;
    color: var(--brown-dark);
    margin: 0;
    font-weight: 600;
}

.step-subtitle {
    font-size: 13px;
    color: var(--text-muted);
    margin-top: 4px;
}

.form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-bottom: 25px;
}

.form-group-p {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.form-group-p label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: var(--text-secondary);
    padding-left: 4px;
}

.input-luxury {
    width: 100%;
    height: 62px;
    padding: 15px 25px;
    background: #fffaf8;
    border: 1.5px solid #f5e6d3;
    border-radius: 20px;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    color: var(--brown-dark);
    transition: all 0.4s var(--ease);
}

.input-luxury:focus {
    background: #fff;
    border-color: var(--terracotta);
    box-shadow: 0 10px 30px rgba(196, 113, 74, 0.08);
    outline: none;
}

.select-luxury-wrap {
    position: relative;
}

.select-icon {
    position: absolute;
    right: 25px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: var(--terracotta);
    font-size: 14px;
}

.input-icon-wrap {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 25px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--terracotta);
    font-size: 18px;
    opacity: 0.7;
}

.pl-large {
    padding-left: 60px;
}

.textarea-premium {
    height: auto;
    min-height: 150px;
    padding-top: 20px;
}

/* Stay Toggle */
.stay-toggle-card {
    background: #fffaf5;
    border: 1px solid #f5e6d3;
    border-radius: 24px;
    padding: 10px;
}

.stay-toggle-wrap {
    display: flex;
    gap: 10px;
}

.stay-opt {
    flex: 1;
    cursor: pointer;
}

.stay-opt input { display: none; }

.stay-opt-ui {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    height: 52px;
    background: transparent;
    border-radius: 18px;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-muted);
    transition: all 0.4s var(--ease);
}

.stay-opt input:checked + .stay-opt-ui {
    background: #fff;
    color: var(--terracotta);
    box-shadow: 0 8px 20px rgba(196, 113, 74, 0.12);
}

.dynamic-stay-details {
    max-height: 0;
    overflow: hidden;
    transition: all 0.6s var(--ease);
    opacity: 0;
}

.dynamic-stay-details.active {
    max-height: 500px;
    opacity: 1;
    margin-top: 30px;
}

.stay-inner-card {
    padding: 35px;
    background: #fffcf9;
    border: 1px dashed #e8dccb;
    border-radius: 30px;
}

.form-helper-text {
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 6px;
    font-style: italic;
}

/* Chips */
.chips-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 12px;
}

.chip-ui {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 18px;
    background: #fffaf8;
    border: 1.5px solid #f5e6d3;
    border-radius: 16px;
    font-size: 12px;
    font-weight: 500;
    color: var(--text-secondary);
    transition: all 0.3s var(--ease);
}

.chip:hover .chip-ui {
    border-color: var(--terracotta);
    background: #fff;
    transform: translateY(-2px);
}

.chip input:checked + .chip-ui {
    background: var(--terracotta);
    border-color: var(--terracotta);
    color: #fff;
    box-shadow: 0 10px 25px rgba(196, 113, 74, 0.25);
}

.chip-ui i {
    font-size: 16px;
}

/* Submit Button */
.btn-bespoke-quote {
    width: 100%;
    height: 75px;
    background: #3e2010;
    color: #fff;
    border: none;
    border-radius: 24px;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 3px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: all 0.5s var(--ease);
    box-shadow: 0 20px 50px rgba(62, 32, 16, 0.2);
}

.btn-bespoke-quote:hover {
    transform: translateY(-5px);
    box-shadow: 0 30px 60px rgba(62, 32, 16, 0.3);
    background: #c05520;
}

.btn-bespoke-quote i {
    transition: transform 0.4s var(--ease);
}

.btn-bespoke-quote:hover i {
    transform: translateX(8px);
}

.btn-glow {
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg, transparent, rgba(255,255,255,0.1), transparent);
    transform: translateX(-100%);
    transition: transform 0.8s ease;
}

.btn-bespoke-quote:hover .btn-glow {
    transform: translateX(100%);
}

.form-group-p.error .input-luxury {
    border-color: #ff5e5e;
    background: #fff5f5;
}

.form-error-hint {
    font-size: 10px;
    color: #ff5e5e;
    display: none;
    margin-top: 5px;
}

.form-group-p.error .form-error-hint {
    display: block;
}

@media (max-width: 768px) {
    .premium-form-card { padding: 40px 25px; }
    .form-grid-2 { grid-template-columns: 1fr; gap: 20px; }
    .chips-container { grid-template-columns: 1fr 1fr; }
    .submit-wrap {
        position: sticky;
        bottom: 20px;
        z-index: 100;
    }
}

/* Success Modal */
.success-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(62, 32, 16, 0.9);
    backdrop-filter: blur(15px);
    z-index: 3000;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.5s var(--ease);
}

.success-modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.success-modal-card {
    background: #fff;
    width: 90%;
    max-width: 520px;
    padding: 70px 50px;
    border-radius: 45px;
    text-align: center;
    transform: translateY(40px) scale(0.9);
    transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1);
}

.success-modal-overlay.active .success-modal-card {
    transform: translateY(0) scale(1);
}

.success-icon-wrap {
    width: 100px;
    height: 100px;
    background: #fff8f3;
    color: var(--terracotta);
    border: 1px solid rgba(196, 113, 74, 0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 45px;
    margin: 0 auto 30px;
    box-shadow: 0 15px 35px rgba(196, 113, 74, 0.12);
    animation: successPop 0.6s var(--ease) both;
}

@keyframes successPop {
    0% { transform: scale(0.5); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

.modal-success-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 32px;
    font-weight: 600;
    color: var(--brown-dark);
    margin-bottom: 15px;
}

.modal-success-text {
    font-size: 14px;
    color: var(--text-muted);
    line-height: 1.7;
    margin-bottom: 35px;
    max-width: 320px;
    margin-left: auto;
    margin-right: auto;
}

.btn-modal-ok {
    padding: 15px 50px;
    background: var(--terracotta);
    color: #fff;
    border: none;
    border-radius: 15px;
    font-weight: 600;
    font-size: 12px;
    letter-spacing: 2px;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.3s var(--ease);
    box-shadow: 0 10px 25px rgba(196, 113, 74, 0.2);
}

.btn-modal-ok:hover {
    background: var(--terracotta-light);
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(196, 113, 74, 0.3);
}

/* ═══════════════════════════════════════
   PLAN YOUR CELEBRATION SECTION
═══════════════════════════════════════ */
.compact-feature-card {
    background: #fff;
    padding: 30px 25px;
    border-radius: 24px;
    box-shadow: 0 10px 30px rgba(45, 27, 14, 0.04);
    border: 1px solid rgba(212, 196, 168, 0.15);
    height: 100%;
    transition: all 0.4s var(--ease);
    text-align: center;
}

.compact-feature-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(196, 113, 74, 0.1);
    border-color: var(--terracotta);
}

.cf-icon {
    width: 50px;
    height: 50px;
    background: #fffaf5;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: var(--terracotta);
    margin: 0 auto 20px;
    border: 1px solid #f5e6d3;
}

.cf-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 19px;
    font-weight: 700;
    color: var(--brown-dark);
    margin-bottom: 10px;
}

.cf-desc {
    font-size: 13px;
    line-height: 1.6;
    color: var(--text-muted);
    margin: 0;
}

@media (max-width: 768px) {
    .plan-celebration-sec { padding: 60px 0; }
    .compact-feature-card { padding: 25px 20px; }
}
</style>

    <x-footer :isHome="false" />

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
// Reveal animation - Moved to top to ensure it runs even if other scripts fail
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) entry.target.classList.add('visible');
    });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

// Initialize Swiper
const gallerySwiper = new Swiper('.gallery-swiper', {
    slidesPerView: 1.2,
    spaceBetween: 20,
    centeredSlides: false,
    loop: true,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.gallery-section .swiper-pagination',
        clickable: true,
    },
    breakpoints: {
        640: { slidesPerView: 2.2, spaceBetween: 20 },
        1024: { slidesPerView: 3.2, spaceBetween: 25 }
    }
});


const amenitiesSwiper = new Swiper('.amenities-swiper', {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    navigation: {
        nextEl: '.amenities-section .swiper-button-next',
        prevEl: '.amenities-section .swiper-button-prev',
    },
    pagination: {
        el: '.amenities-section .swiper-pagination',
        clickable: true,
    },
    breakpoints: {
        576: { slidesPerView: 2, spaceBetween: 15 },
        768: { slidesPerView: 3, spaceBetween: 20 },
        1024: { slidesPerView: 4, spaceBetween: 24 }
    }
});

// Dynamic Stay Card Toggle
function toggleStayCard(show) {
    const card = document.getElementById('dynamicStayCard');
    const input = document.getElementById('stay_guests_input');
    if (show) {
        card.classList.remove('d-none');
        input.required = true;
    } else {
        card.classList.add('d-none');
        input.required = false;
        input.value = '';
    }
}

// Modal Logic
function closeSuccessModal() {
    document.getElementById('successModal').classList.remove('active');
}

// Form Submission & Validation
document.getElementById('eventInquiryForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const form = this;
    const btn = document.getElementById('submitBtn');
    const msg = document.getElementById('formMsg');
    const modal = document.getElementById('successModal');
    const modalMsg = document.getElementById('successModalMsg');
    
    // Validation
    let isValid = true;
    
    // Reset errors
    form.querySelectorAll('.form-group-p').forEach(g => g.classList.remove('error'));

    // Required fields
    form.querySelectorAll('[required]').forEach(input => {
        if (!input.value.trim()) {
            input.closest('.form-group-p').classList.add('error');
            isValid = false;
        }
    });

    // Phone validation
    const phoneInput = form.querySelector('input[name="phone"]');
    const phoneRegex = /^[0-9]{10}$/;
    if (phoneInput.value.trim() && !phoneRegex.test(phoneInput.value.trim())) {
        phoneInput.closest('.form-group-p').classList.add('error');
        isValid = false;
    }


    if (!isValid) {
        const firstError = form.querySelector('.form-group-p.error');
        if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }

    const formData = new FormData(form);
    btn.disabled = true;
    const originalBtnText = btn.innerHTML;
    btn.innerHTML = '<span class="btn-text">Crafting your vision...</span>';
    msg.classList.add('d-none');

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            btn.innerHTML = '<span class="btn-text">Vision Received ✨</span>';
            btn.style.background = '#27ae60';
            
            // Set message explicitly in case result.message is different
            modalMsg.textContent = "Your request has been sent successfully. Our team will connect with you within 4–5 hours. Thank you!";
            modal.classList.add('active');
            
            form.reset();
            
            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = originalBtnText;
                btn.style.background = '';
            }, 5000);
            
        } else {
            throw new Error(result.message || 'Submission failed. Please check your network.');
        }
    } catch (error) {
        msg.className = 'mt-4 text-center text-danger small';
        msg.innerHTML = `<i class="bi bi-exclamation-triangle-fill me-2"></i> ${error.message}`;
        msg.classList.remove('d-none');
        btn.disabled = false;
        btn.innerHTML = originalBtnText;
    }
});
</script>
<x-social-nav />
@include('chatbot')
</body>
</html>