<div class="social-nav-container">
    <!-- FLOAT STACK -->
    <div class="float-stack">
        <button class="float-btn fbtt" id="bttBtn" onclick="window.scrollTo({top:0,behavior:'smooth'})" title="Back to top">
            <i class="bi bi-chevron-up"></i>
        </button>
        <a href="#" onclick="showIgModal();return false;" class="float-btn fig" title="Instagram">
            <i class="bi bi-instagram"></i>
        </a>
        <a href="#" onclick="toggleChatbot();return false;" class="cb-bubble" id="cbBubble" title="Chat with Assistant">
            <i class="bi bi-whatsapp"></i>
        </a>
    </div>



    <!-- INSTAGRAM MODAL -->
    <div class="ig-modal-bg" id="igModal" onclick="closeIgModal(event)">
        <div class="ig-modal">
            <div class="ig-modal-icon"><i class="bi bi-instagram"></i></div>
            <h4 style="font-family: 'Playfair Display', serif; font-weight: 700; color: #3e2010; margin-bottom: 0.5rem;">Choose Instagram Account</h4>
            <p style="font-size: 0.85rem; color: #5a5a5a; margin-bottom: 1.5rem;">Explore our properties on Instagram:</p>
            <div class="d-flex gap-2 flex-column">
                <a href="https://www.instagram.com/Parudeesa_the_paradise" target="_blank"
                    class="btn-brand-ig" onclick="closeIgModal()">
                    <i class="bi bi-instagram"></i> @Parudeesa_the_paradise (Paradise)
                </a>
                <a href="https://www.instagram.com/parudeesa_utopiya" target="_blank"
                    class="btn-brand-ig" onclick="closeIgModal()">
                    <i class="bi bi-instagram"></i> @parudeesa_utopiya (Utopiya)
                </a>
            </div>
            <button onclick="closeIgModal()"
                style="font-size:.72rem;color:#5a5a5a;background:none;border:none;cursor:pointer;margin-top:.8rem;padding:.4rem 1rem">Maybe
                later</button>
        </div>
    </div>
</div>

<style>
    .social-nav-container {
        overflow: visible;
        position: static;
    }

    :root {
        --safe-b: env(safe-area-inset-bottom);
        --brand: #fa873e;
        --brand-d: #e06828;
    }

    .float-stack {
        position: fixed;
        bottom: calc(1.8rem + var(--safe-b));
        right: 1.4rem;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 1rem;
        z-index: 2100;
    }

    .float-btn, .cb-bubble {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: #fff;
        text-decoration: none;
        box-shadow: 0 8px 24px rgba(0, 0, 0, .15);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        cursor: pointer;
        position: relative;
        -webkit-tap-highlight-color: transparent;
    }

    .float-btn:hover, .cb-bubble:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 12px 32px rgba(0, 0, 0, .2);
    }

    .fbtt {
        background: linear-gradient(135deg, var(--brand), var(--brand-d));
        opacity: 0;
        pointer-events: none;
        transform: scale(0.8);
    }

    .fbtt.show {
        opacity: 1;
        pointer-events: auto;
        transform: scale(1);
    }

    .fig {
        background: linear-gradient(135deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
    }

    .cb-bubble {
        background: linear-gradient(135deg, #25D366, #128C7E);
        animation: pulse-wa 2.5s ease-in-out infinite;
    }

    @keyframes pulse-wa {
        0%, 100% { box-shadow: 0 4px 20px rgba(37, 211, 102, .4) }
        50% { box-shadow: 0 4px 36px rgba(37, 211, 102, .65) }
    }

    /* Chatbot Window */
    .cb-win {
        position: fixed;
        bottom: calc(5.5rem + var(--safe-b));
        right: 1.4rem;
        width: 420px;
        height: 600px;
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(62, 32, 16, .18);
        z-index: 2100;
        display: flex;
        flex-direction: column;
        overflow: visible; /* Allow floating elements outside */
        opacity: 0;
        visibility: hidden;
        transform: translateY(30px) scale(0.98);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid rgba(217, 101, 32, 0.12);
    }

    .cb-win.open {
        opacity: 1;
        visibility: visible;
        transform: translateY(0) scale(1);
    }

    .cb-close-overlay {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 32px;
        height: 32px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(4px);
        border: 1px solid rgba(217, 101, 32, 0.2);
        color: #d96520;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        z-index: 2102;
        transition: all 0.3s ease;
    }

    .cb-close-overlay:hover {
        background: #d96520;
        color: #fff;
        transform: rotate(90deg) scale(1.1);
    }

    .cb-info span {
        color: rgba(255, 255, 255, .8);
        font-size: .65rem;
        display: flex;
        align-items: center;
        gap: .2rem;
    }

    .cb-dot {
        width: 7px;
        height: 7px;
        background: #25D366;
        border-radius: 50%;
        display: inline-block;
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
        transition: background .2s ease;
    }

    .cb-close:hover {
        background: rgba(255, 255, 255, .28);
    }

    @media (max-width: 575px) {
        .cb-win {
            right: 1rem;
            left: 1rem;
            width: auto;
            bottom: calc(5rem + var(--safe-b));
            height: calc(100vh - 10rem);
            border-radius: 20px;
        }
        .cb-close-overlay {
            top: 12px;
            right: 12px;
        }
    }

    /* Instagram Modal */
    .ig-modal-bg {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(46, 20, 8, 0.85);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10005; /* Above navbar */
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s ease;
        padding: 20px;
    }

    .ig-modal-bg.open {
        opacity: 1;
        visibility: visible;
    }

    .ig-modal {
        background: #fff;
        width: 100%;
        max-width: 400px;
        padding: 35px 25px;
        border-radius: 28px;
        text-align: center;
        transform: scale(0.9) translateY(20px);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }

    .ig-modal-bg.open .ig-modal {
        transform: scale(1) translateY(0);
    }

    .ig-modal-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
        color: #fff;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 20px;
    }

    /* Desktop/Tablet Positioning */
    @media (min-width: 576px) {
        .ig-modal-bg {
            align-items: flex-end;
            justify-content: flex-end;
            padding: 30px 90px 100px 30px;
        }
        .ig-modal {
            margin: 0;
            width: calc(100vw - 120px);
            max-width: 420px;
            text-align: left;
            padding: 30px;
            left: auto !important;
            top: auto !important;
        }
        .ig-modal-icon {
            margin: 0 0 15px 0;
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
        }
        .btn-brand-ig {
            justify-content: flex-start;
            padding: 12px 20px;
        }
    }

    .btn-brand-ig {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px;
        background: #fa873e;
        color: #fff;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .btn-brand-ig:hover {
        background: #e06828;
        color: #fff;
        transform: translateY(-2px);
    }

    @media (max-width: 480px) {
        .float-stack { right: 1rem; bottom: 1rem; }
    }
</style>

<script>
    (function() {
        window.showIgModal = function() {
            document.getElementById('igModal').classList.add('open');
        };



        window.closeIgModal = function(e) {
            if (!e || e.target === document.getElementById('igModal') || e.target.closest('.btn-brand-ig') || e.tagName === 'BUTTON') {
                document.getElementById('igModal').classList.remove('open');
            }
        };

        // Back to top scroll listener
        window.addEventListener('scroll', function() {
            const btt = document.getElementById('bttBtn');
            if (btt) {
                if (window.scrollY > 400) {
                    btt.classList.add('show');
                } else {
                    btt.classList.remove('show');
                }
            }
        });
    })();
</script>
