<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta name="description" content="Parudeesa Terms and Conditions – The Lake View Resort" />
    <title>Terms & Conditions | Parudeesa – The Lake View Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600;1,700&family=EB+Garamond:ital,wght@0,400;0,500;1,400&family=Josefin+Sans:wght@300;400;600&display=swap" rel="stylesheet" />

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
            --txt: #2e1a08;
            --txt-m: #7a5a3a;
            --txt-l: #b08060;
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

        html {
            scroll-behavior: smooth;
            -webkit-text-size-adjust: 100%;
        }

        body {
            font-family: 'Josefin Sans', sans-serif;
            background: var(--brand-pale);
            color: var(--txt);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Cormorant Garamond', serif;
        }

        .eb {
            font-family: 'EB Garamond', serif;
        }

        body::after {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 9990;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='0.015'/%3E%3C/svg%3E");
        }

        /* ═══════ NAVBAR ═══════ */
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
            line-height: 1.1;
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            height: 84px;
            width: auto;
            object-fit: contain;
            margin-top: -5px;
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
            cursor: pointer;
        }

        .nav-link:hover,
        .nav-link.anav {
            color: var(--brand-d) !important;
            background: rgba(250, 135, 62, .1);
        }

        .navbar-toggler {
            border: 1px solid rgba(250, 135, 62, .35);
            border-radius: 8px;
            padding: .3rem .5rem;
            box-shadow: none !important;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23fa873e' stroke-width='2.2' stroke-linecap='round' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        /* ═══════ POLICY PAGE ═══════ */
        main {
            flex: 1;
            padding: 80px 20px 60px;
        }

        .policy-container {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
        }

        .policy-title {
            font-size: clamp(2.2rem, 5vw, 3.8rem);
            font-weight: 700;
            font-style: italic;
            color: var(--brn-dk);
            margin-bottom: 1rem;
            line-height: 1.15;
        }

        .policy-date {
            font-size: 1rem;
            color: var(--txt-m);
            margin-bottom: 4rem;
            font-family: 'EB Garamond', serif;
        }

        .policy-card {
            background: #fff;
            border: 1px solid rgba(250, 135, 62, .15);
            border-radius: 20px;
            padding: 4rem 3.5rem;
            box-shadow: 0 8px 32px rgba(250, 135, 62, .12);
            text-align: left;
        }

        .policy-section {
            margin-bottom: 3rem;
        }

        .policy-section:last-child {
            margin-bottom: 0;
        }

        .policy-section h2 {
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--brand);
            margin-bottom: 1.2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(250, 135, 62, .25);
            font-family: 'Cormorant Garamond', serif;
        }

        .policy-section p {
            font-family: 'EB Garamond', serif;
            font-size: 1.05rem;
            color: var(--txt-m);
            line-height: 1.85;
            margin-bottom: 1.2rem;
            text-align: justify;
        }

        .policy-section ul {
            list-style: none;
            padding: 0;
            margin: 1.5rem 0;
        }

        .policy-section li {
            font-family: 'EB Garamond', serif;
            font-size: 1.05rem;
            color: var(--txt);
            line-height: 1.85;
            padding-left: 2.5rem;
            margin-bottom: 1rem;
            position: relative;
            text-align: justify;
        }

        .policy-section li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: var(--brand);
            font-weight: 700;
            font-size: 1.3rem;
        }

        .policy-section strong {
            color: var(--brn-dk);
            font-weight: 700;
        }

        /* ═══════ FOOTER ═══════ */
        footer {
            background: linear-gradient(160deg, #1e0a02 0%, var(--brn-dk) 100%);
            color: rgba(255, 243, 236, .6);
            padding: 65px 0 calc(24px + var(--safe-b));
            border-top: 2px solid rgba(250, 135, 62, .2);
            margin-top: 80px;
        }

        .f-head {
            font-size: .58rem;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--brand-l);
            margin-bottom: 1.2rem;
            font-weight: 700;
        }

        .f-brand {
            margin-bottom: 1.5rem;
        }

        .f-brand img {
            height: 90px;
            width: auto;
            object-fit: contain;
            margin-bottom: 1rem;
        }

        .f-brand p {
            font-family: 'EB Garamond', serif;
            font-style: italic;
            color: rgba(255, 243, 236, .4);
            font-size: .95rem;
            line-height: 1.65;
        }

        .f-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .f-links li {
            margin-bottom: .6rem;
        }

        .f-links a {
            font-size: .82rem;
            color: rgba(255, 243, 236, .45);
            text-decoration: none;
            transition: color var(--ease);
            cursor: pointer;
            font-family: 'Josefin Sans', sans-serif;
        }

        .f-links a:hover {
            color: var(--brand-l);
        }

        .f-copy {
            font-size: .7rem;
            text-align: center;
            color: rgba(255, 243, 236, .4);
        }

        .f-div {
            border-color: rgba(255, 255, 255, .06);
            margin: 2rem 0 1.2rem;
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
            gap: 12px;
            font-size: 0.9rem;
        }

        .footer-contact-item i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .footer-contact-item a {
            color: rgba(255, 243, 236, 0.7);
            text-decoration: none;
            transition: color var(--ease);
        }

        .footer-contact-item a:hover {
            color: var(--brand-l);
        }

        @media (max-width: 768px) {
            main {
                padding: 60px 15px 40px;
            }

            .policy-card {
                padding: 2.5rem 1.5rem;
            }

            .policy-title {
                font-size: clamp(1.8rem, 4vw, 2.5rem);
            }

            .policy-section h2 {
                font-size: 1.4rem;
            }

            .policy-section p,
            .policy-section li {
                font-size: 1rem;
            }

            .policy-date {
                font-size: .9rem;
            }
        }
    </style>
</head>

<body>

    <!-- ██ NAVBAR ██ -->
    <nav class="navbar navbar-expand-lg" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="/design">
                <img src="/images/parudeesa-logo.png" alt="Parudeesa Logo" style="height: 55px; width: auto; object-fit: contain;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"
                aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="nav">
                <ul class="navbar-nav mx-auto gap-1">
                    <li class="nav-item"><a class="nav-link" href="/design">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/design#events">Events</a></li>
                    <li class="nav-item"><a class="nav-link" href="/design#gallery">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="/design#about">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main>
        <div class="policy-container">
            <h1 class="policy-title">Terms & Conditions</h1>
            <p class="policy-date">Last updated: May 1, 2026</p>

            <div class="policy-card">
                <section class="policy-section">
                    <h2>1. Booking and Reservation</h2>
                    <p>By making a reservation at Parudeesa - The Lake View Resort, you agree to these terms and conditions. A booking is confirmed only upon payment of the advance amount as per the payment terms displayed at the time of booking.</p>
                    <ul>
                        <li>Bookings must be made through our official website, WhatsApp, or authorized booking channels</li>
                        <li>Advance payment is required to secure your reservation</li>
                        <li>The remaining balance must be paid before check-in</li>
                        <li>All bookings are subject to availability and confirmation</li>
                    </ul>
                </section>

                <section class="policy-section">
                    <h2>2. Guest Responsibilities</h2>
                    <p>As a guest at Parudeesa, you are responsible for:</p>
                    <ul>
                        <li>Providing accurate and complete information during the booking process</li>
                        <li>Complying with all resort rules and regulations</li>
                        <li>Respecting the property and other guests</li>
                        <li>Maintaining cleanliness and care of the accommodations</li>
                        <li>Following noise restrictions and quiet hours (10 PM - 8 AM)</li>
                        <li>Not smoking in designated non-smoking areas</li>
                        <li>Paying for any damage caused during your stay</li>
                    </ul>
                </section>

                <section class="policy-section">
                    <h2>3. Check-In and Check-Out</h2>
                    <ul>
                        <li><strong>Check-in:</strong> 2:00 PM onwards</li>
                        <li><strong>Check-out:</strong> 11:00 AM</li>
                        <li>Early check-in or late check-out is subject to availability and may incur additional charges</li>
                        <li>Late check-out without prior arrangement may result in an additional night's charge</li>
                        <li>Valid identification is required at check-in</li>
                    </ul>
                </section>

                <section class="policy-section">
                    <h2>4. Payment Terms</h2>
                    <p>Payment for your stay should be made as follows:</p>
                    <ul>
                        <li>Advance payment: 50% at the time of booking</li>
                        <li>Balance payment: 50% before check-in</li>
                        <li>We accept credit cards, debit cards, bank transfers, and digital payments through Razorpay</li>
                        <li>All prices are inclusive of applicable taxes unless stated otherwise</li>
                    </ul>
                </section>

                <section class="policy-section">
                    <h2>5. House Rules</h2>
                    <p>To ensure a pleasant experience for all guests, please adhere to the following rules:</p>
                    <ul>
                        <li>Respect quiet hours from 10:00 PM to 8:00 AM</li>
                        <li>No loud music or parties without prior permission</li>
                        <li>No smoking in rooms or restricted areas</li>
                        <li>No pets allowed without prior written approval</li>
                        <li>Maximum occupancy limits must be respected</li>
                        <li>Do not rearrange furniture or fixtures without permission</li>
                        <li>Report any damage or maintenance issues immediately</li>
                    </ul>
                </section>

                <section class="policy-section">
                    <h2>6. Liability and Damages</h2>
                    <p>Parudeesa is not responsible for:</p>
                    <ul>
                        <li>Loss, theft, or damage to personal belongings</li>
                        <li>Injuries or accidents (except those caused by resort negligence)</li>
                        <li>Natural disasters or unforeseen circumstances</li>
                    </ul>
                    <p><strong>Guest Liability:</strong> Guests are responsible for any damage caused to the property during their stay. Repair or replacement costs will be charged to the guest's account.</p>
                </section>

                <section class="policy-section">
                    <h2>7. Event and Group Bookings</h2>
                    <p>Special terms apply for events and group bookings:</p>
                    <ul>
                        <li>A separate event agreement must be signed</li>
                        <li>Event organizers are responsible for guest conduct</li>
                        <li>Additional charges may apply for setup, decoration, and catering</li>
                        <li>Noise restrictions apply even during events after 11:00 PM</li>
                        <li>Damage deposits may be required for large events</li>
                    </ul>
                </section>

                <section class="policy-section">
                    <h2>8. Modification and Termination</h2>
                    <p>Parudeesa reserves the right to:</p>
                    <ul>
                        <li>Modify or cancel reservations in case of unforeseen circumstances</li>
                        <li>Request guests to vacate if they violate house rules</li>
                        <li>Modify these terms and conditions with 30 days' notice</li>
                    </ul>
                </section>

                <section class="policy-section">
                    <h2>9. Dispute Resolution</h2>
                    <p>In case of any disputes or issues:</p>
                    <ul>
                        <li>Complaints must be filed within 7 days of checkout</li>
                        <li>Disputes will be resolved through mutual agreement</li>
                        <li>Final disputes shall be subject to jurisdiction in Kerala, India</li>
                    </ul>
                </section>

                <section class="policy-section">
                    <h2>10. Contact Information</h2>
                    <p>For questions regarding these terms and conditions, please contact:</p>
                    <ul>
                        <li><strong>Email:</strong> hello@parudeesa.in</li>
                        <li><strong>Phone:</strong> +91 89210 21202</li>
                        <li><strong>Address:</strong> Kerala Backwaters, India</li>
                    </ul>
                </section>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="row g-5">
                <!-- SECTION 1: BRAND & ADDRESS -->
                <div class="col-lg-3 col-md-6">
                    <div class="f-brand mb-3" style="font-family: 'Cormorant Garamond', serif; font-weight:700;">
                        <img src="/images/parudeesa-logo.png" alt="Parudeesa Logo" style="height: 90px; width: auto; object-fit: contain;">
                    </div>
                    <p style="font-size:.85rem;color:rgba(255,243,236,.6);line-height:1.8">
                        Kerala Backwaters, India
                    </p>
                    <p style="font-style:italic;color:rgba(255,243,236,.4);font-size:1rem;line-height:1.6; font-family:'EB Garamond', serif; margin-top: 1rem;">
                        "Experience Serenity by the Lake"</p>
                </div>

                <!-- SECTION 2: NAVIGATION -->
                <div class="col-6 col-md-3 col-lg-2">
                    <div class="f-head">Navigation</div>
                    <ul class="f-links">
                        <li><a href="/design">Home</a></li>
                        <li><a href="/design#events">Events</a></li>
                        <li><a href="/design#gallery">Gallery</a></li>
                        <li><a href="/design#about">About Us</a></li>
                        <li><a href="/booking">Book Now</a></li>
                    </ul>
                </div>

                <!-- SECTION 3: POLICIES -->
                <div class="col-6 col-md-3 col-lg-3">
                    <div class="f-head">Policies</div>
                    <div class="policy-list" style="display:flex; flex-direction:column; gap:.5rem;">
                        <a href="/terms-and-conditions" class="policy-link" style="font-size:.8rem; text-decoration:none; color:rgba(255,243,236,.45); transition:all var(--ease);">Terms & Conditions</a>
                        <a href="/privacy-policy" class="policy-link" style="font-size:.8rem; text-decoration:none; color:rgba(255,243,236,.45); transition:all var(--ease);">Privacy Policy</a>
                        <a href="/cancellation-policy" class="policy-link" style="font-size:.8rem; text-decoration:none; color:rgba(255,243,236,.45); transition:all var(--ease);">Cancellation Policy</a>
                    </div>
                </div>

                <!-- SECTION 4: CONTACT US -->
                <div class="col-md-6 col-lg-4">
                    <div class="f-head">Contact Us</div>
                    <div class="footer-contact mb-4">
                        <div class="footer-contact-item">
                            <i class="bi bi-telephone" style="color:var(--brand)"></i>
                            <a href="tel:+918921021202">+91 89210 21202</a>
                        </div>
                        <div class="footer-contact-item">
                            <i class="bi bi-envelope" style="color:var(--brand-l)"></i>
                            <a href="mailto:hello@parudeesa.in">hello@parudeesa.in</a>
                        </div>
                    </div>
                    
                    <div class="f-head" style="margin-top: 2rem;">Follow Us</div>
                    <div class="footer-social d-flex gap-3">
                        <a href="https://instagram.com/parudeesa" target="_blank" class="fs-link" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="https://facebook.com/parudeesa" target="_blank" class="fs-link" title="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="https://youtube.com/parudeesa" target="_blank" class="fs-link" title="YouTube"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr class="f-div" />
            <p class="f-copy">&copy; 2026 Parudeesa - The Lake View Resort. All rights reserved. Made with love in Kerala.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('#mainNav');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>

</body>

</html>
