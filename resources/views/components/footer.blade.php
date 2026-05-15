@props(['isHome' => false])

<style>
    /* ═══════ REFINED FOOTER COMPONENT STYLES ═══════ */
    .site-footer {
        background: linear-gradient(165deg, #1e0a02 0%, #2e1408 50%, #3e2010 100%);
        position: relative;
        color: rgba(255, 243, 236, 0.55);
        padding: 50px 0 60px;
        border-top: 2px solid rgba(250, 135, 62, 0.12);
        font-family: 'Outfit', sans-serif;
        overflow: hidden;
    }

    /* Subtle Amber Glow */
    .site-footer::before {
        content: '';
        position: absolute;
        top: -150px;
        right: -100px;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(250, 135, 62, 0.05) 0%, transparent 70%);
        pointer-events: none;
    }

    .f-brand img {
        height: 70px;
        width: auto;
        object-fit: contain;
        margin-bottom: 1.5rem;
        opacity: 0.95;
    }

    .f-brand-text {
        font-size: 0.82rem;
        color: rgba(255, 243, 236, 0.45);
        line-height: 1.8;
        letter-spacing: 0.01em;
    }

    .f-quote {
        font-family: 'EB Garamond', serif;
        font-style: italic;
        color: rgba(255, 243, 236, 0.3);
        font-size: 0.92rem;
        line-height: 1.6;
        margin-top: 1.5rem;
    }

    .f-head {
        font-family: 'Playfair Display', serif;
        color: #fa873e;
        font-weight: 700;
        font-size: 0.65rem;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        margin-bottom: 1.8rem;
    }

    .f-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .f-links li {
        margin-bottom: 0.9rem;
    }

    .f-links a, .policy-link {
        font-size: 0.8rem;
        color: rgba(255, 243, 236, 0.5);
        text-decoration: none;
        transition: all 0.4s ease;
        cursor: pointer;
        font-weight: 300;
        line-height: 1.6;
    }

    .f-links a:hover, .policy-link:hover {
        color: #fa873e;
        padding-left: 6px;
        opacity: 1;
    }

    .policy-list {
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
    }

    .footer-contact {
        display: flex;
        flex-direction: column;
        gap: 1.4rem;
    }

    .footer-contact-item {
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 0.85rem;
    }

    .footer-contact-item i {
        font-size: 1rem;
        color: rgba(250, 135, 62, 0.8);
        width: 18px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .footer-contact-item a {
        color: rgba(255, 243, 236, 0.65);
        text-decoration: none;
        transition: color 0.3s ease;
        font-weight: 300;
    }

    .footer-contact-item a:hover {
        color: #fa873e;
    }

    .footer-social-block {
        margin-top: 2.8rem;
    }

    .footer-social {
        display: flex;
        gap: 14px;
    }

    .footer-social .fs-link {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.03);
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255, 243, 236, 0.45);
        font-size: 1rem;
        transition: all 0.5s cubic-bezier(0.2, 1, 0.3, 1);
        border: 1px solid rgba(255, 255, 255, 0.06);
        text-decoration: none;
    }

    .footer-social .fs-link:hover {
        background: rgba(250, 135, 62, 0.9);
        color: #fff;
        transform: translateY(-5px);
        border-color: #fa873e;
        box-shadow: 0 8px 20px rgba(250, 135, 62, 0.25);
    }

    .f-div {
        border: 0;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        margin: 50px 0 20px;
    }

    .f-copy {
        font-size: 0.68rem;
        color: rgba(255, 243, 236, 0.22);
        text-align: center;
        margin-bottom: 0;
        letter-spacing: 0.03em;
        font-weight: 300;
    }

    @media (max-width: 991px) {
        .site-footer {
            padding: 60px 0 40px;
            text-align: center;
        }
        .footer-contact-item, .footer-social {
            justify-content: center;
        }
        .f-head {
            margin-top: 2.5rem;
            margin-bottom: 1.5rem;
        }
        .footer-social-block {
            margin-top: 2.2rem;
        }
        .f-links a:hover {
            padding-left: 0;
        }
    }
</style>

<footer class="site-footer">
    <div class="container">
        <div class="row gx-5 align-items-start">
            <!-- SECTION 1: BRAND & ADDRESS -->
            <div class="col-lg-3 col-md-6">
                <div class="f-brand">
                    <img src="{{ asset('images/parudeesa-logo.png') }}" alt="Parudeesa Logo">
                </div>
                <p class="f-brand-text">
                    Kerala Backwaters, India
                </p>
                <p class="f-quote">
                    "Experience Serenity by the Lake"</p>
            </div>

            <!-- SECTION 2: NAVIGATION -->
            <div class="col-6 col-md-3 col-lg-2">
                <div class="f-head">Navigation</div>
                <ul class="f-links">
                    @if($isHome)
                        <li><a onclick="goPage('home')">Home</a></li>
                        <li><a href="{{ route('events') }}">Events</a></li>
                        <li><a onclick="goPage('gallery')">Gallery</a></li>
                        <li><a onclick="goPage('about')">About Us</a></li>
                        <li><a onclick="toggleChatbot()">Book Now</a></li>
                    @else
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('events') }}">Events</a></li>
                        <li><a href="{{ route('home') }}#gallery">Gallery</a></li>
                        <li><a href="{{ route('home') }}#about">About Us</a></li>
                        <li><a href="javascript:void(0)" onclick="toggleChatbot()">Book Now</a></li>
                    @endif
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
                    <div class="footer-contact-item">
                        <i class="bi bi-telephone"></i>
                        <a href="tel:+918921021202">+91 89210 21202</a>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-envelope"></i>
                        <a href="mailto:hello@parudeesa.in">hello@parudeesa.in</a>
                    </div>
                </div>
                
                <div class="footer-social-block">
                    <div class="f-head" style="margin-bottom: 1.2rem;">Follow Us</div>
                    <div class="footer-social">
                        <a href="https://instagram.com/parudeesa" target="_blank" class="fs-link" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="https://facebook.com/parudeesa" target="_blank" class="fs-link" title="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="https://youtube.com/parudeesa" target="_blank" class="fs-link" title="YouTube"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <hr class="f-div" />
        <p class="f-copy">&copy; 2026 Parudeesa - The Lake View Resort. All rights reserved. Made with love in Kerala.</p>
    </div>
</footer>
