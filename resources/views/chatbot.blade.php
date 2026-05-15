@php
    // Ensure data is available even if not passed from controller
    if (!isset($properties)) {
        $properties = \App\Models\Property::with('amenities')->get();
    }
    
    if (!isset($yachts)) {
        $yachts = \App\Models\Yacht::where('status', true)->get()->map(function($y) {
            return [
                'id' => $y->id,
                'name' => $y->name,
                'price' => (float) $y->price,
                'capacity' => $y->capacity,
                'image' => asset($y->image),
            ];
        });
    }
    $yacht = \App\Models\Yacht::first();
    $allAmenities = \App\Models\Amenity::where('status', true)->get();
    
    // Sync yacht price to amenity for chatbot
    $yachtAmenity = $allAmenities->first(fn ($a) => str_contains(strtolower($a->name), 'yacht'));
    if ($yachtAmenity && $yacht) {
        $yachtAmenity->price = $yacht->price;
    }
    
    // Food Packages (Dynamic from Database)
    $foodPackages = \App\Models\FoodPackage::where('status', true)->get()->map(function($pkg) {
        return [
            'id' => (string) $pkg->id,
            'name' => $pkg->name,
            'price' => (float) $pkg->price,
            'desc' => $pkg->description
        ];
    })->toArray();

    // Event Services (Dynamic from Database)
    $eventServices = \App\Models\EventService::where('status', true)->get()->map(function($svc) {
        return [
            'id' => (string) $svc->id,
            'name' => $svc->name,
            'icon' => $svc->icon ?: 'bi-check2-circle',
            'price' => (float) $svc->price
        ];
    })->toArray();

    $chatbotProperties = $properties->map(function ($p) {
        $nameLower = strtolower($p->name);
        $tag = str_contains($nameLower, 'paradise') ? 'paradise' : (str_contains($nameLower, 'utopi') ? 'utopia' : 'both');
        
        $defaultHighlights = [
            ['label' => 'Infinity Swimming Pool', 'icon' => 'bi-droplet-fill'],
            ['label' => 'In-House Restaurant', 'icon' => 'bi-house-heart-fill'],
            ['label' => 'Lakeside Property', 'icon' => 'bi-water'],
            ['label' => 'Breathtaking Sunset Views', 'icon' => 'bi-stars'],
        ];
        
        $rawHighlights = (is_array($p->highlights) && count($p->highlights)) ? $p->highlights : $defaultHighlights;
        
        $transformedHighlights = collect($rawHighlights)->map(function($h) {
            $label = '';
            $icon = 'bi-check-circle-fill';
            if (is_string($h)) { $label = $h; }
            elseif (is_array($h)) { $label = $h['label'] ?? $h['name'] ?? $h['title'] ?? ''; $icon = $h['icon'] ?? 'bi-check-circle-fill'; }
            return ['label' => $label ?: 'Luxury Feature', 'icon' => $icon];
        })->filter(fn($h) => $h['label'] !== 'Luxury Feature')->all();

        if (empty($transformedHighlights)) { $transformedHighlights = $defaultHighlights; }

        // Fetch Disabled Dates
        $disabledDates = [];
        
        // 1. Bookings
        $bookings = \App\Models\Booking::where('property_id', $p->id)
            ->where('status', '!=', 'cancelled')
            ->where(function($q) {
                $q->whereIn('payment_status', ['Paid', 'Pending', 'created'])
                  ->orWhereNull('payment_status');
            })
            ->get();
            
        foreach ($bookings as $b) {
            if ($b->check_in && $b->check_out) {
                $start = \Illuminate\Support\Carbon::parse($b->check_in);
                $end = \Illuminate\Support\Carbon::parse($b->check_out);
                // Generate all dates between check-in and check-out (excluding check-out day)
                while ($start->lt($end)) {
                    $disabledDates[] = $start->toDateString();
                    $start->addDay();
                }
            }
        }
        
        // 2. Blocked Dates
        $blocked = \App\Models\BlockedDate::where('property_id', $p->id)->get();
        foreach ($blocked as $bl) {
            if ($bl->start_date && $bl->end_date) {
                $start = \Illuminate\Support\Carbon::parse($bl->start_date);
                $end = \Illuminate\Support\Carbon::parse($bl->end_date);
                // Blocked dates are usually inclusive
                while ($start->lte($end)) {
                    $disabledDates[] = $start->toDateString();
                    $start->addDay();
                }
            }
        }
        
        $disabledDates = array_values(array_unique($disabledDates));

        return [
            'id' => $p->id,
            'name' => $p->name,
            'price' => (float)($p->weekday_price ?: ($p->price ?: 8000)),
            'weekday_price' => (float)($p->weekday_price ?: $p->price),
            'weekday_tier2_price' => (float)($p->weekday_tier2_price ?: ($p->weekday_price ?: $p->price)),
            'weekend_price' => (float)($p->weekend_price ?: $p->price),
            'weekend_tier2_price' => (float)($p->weekend_tier2_price ?: ($p->weekend_price ?: $p->price)),
            'base_guests' => (int)($p->base_guests ?: 5),
            'extra_guest_price' => (float)($p->extra_guest_price ?: 600),
            'capacity' => $p->capacity ?? '2-15 Guests',
            'max_capacity' => (int)($p->max_guests ?: 15),
            'tagline' => $p->tagline ?? 'Luxury lakeside property',
            'description' => $p->description,
            'location' => $p->location ?? 'Kerala, India',
            'image' => $p->image_url ? asset($p->image_url) : 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&q=80',
            'amenities' => $p->amenities->map(function($a) { return ['id' => $a->id, 'name' => $a->name, 'price' => $a->price, 'type' => $a->pricing_type]; }),
            'highlights' => $transformedHighlights,
            'disabled_dates' => $disabledDates,
            'tag' => $tag
        ];
    });

    $chatbotYachts = $yachts->map(function ($y) {
        $yArr = is_array($y) ? $y : $y->toArray();
        $disabledDates = [];
        $bookings = \App\Models\Booking::where('yacht_id', $yArr['id'])
            ->where('status', '!=', 'cancelled')
            ->where(function($q) {
                $q->whereIn('payment_status', ['Paid', 'Pending', 'created'])
                  ->orWhereNull('payment_status');
            })
            ->get();
            
        foreach ($bookings as $b) {
            if ($b->check_in && $b->check_out) {
                $start = \Illuminate\Support\Carbon::parse($b->check_in);
                $end = \Illuminate\Support\Carbon::parse($b->check_out);
                while ($start->lte($end)) {
                    $disabledDates[] = $start->toDateString();
                    $start->addDay();
                }
            }
        }

        return [
            'id' => $yArr['id'],
            'name' => $yArr['name'],
            'price' => (float)$yArr['price'],
            'capacity' => $yArr['capacity'] ?? '6 Guests',
            'duration' => $yArr['duration'] ?? '2 Hours',
            'image' => ($yArr['image'] ?? null) ? asset($yArr['image']) : ($yArr['image_url'] ?? 'https://images.unsplash.com/photo-1567899378494-47b22a2bb9ba?w=400&q=80'),
            'amenities' => ['Sun Deck', 'Sound System', 'Safety Jackets', 'Refreshments'],
            'disabled_dates' => $disabledDates,
        ];
    });

    $chatbotAmenities = $allAmenities->map(function($a) {
        return ['id' => $a->id, 'name' => $a->name, 'price' => (float)$a->price, 'type' => $a->pricing_type, 'assignment' => $a->property_assignment ?? 'both'];
    });

    $bookingSettings = [
        'check_in_time' => \App\Models\Setting::get('check_in_time', '02:00 PM'),
        'check_out_time' => \App\Models\Setting::get('check_out_time', '11:00 AM'),
        'water_activity_threshold' => (int) \App\Models\Setting::get('water_activity_threshold', 5),
        'water_activity_low_price' => (float) \App\Models\Setting::get('water_activity_low_price', 1000),
        'water_activity_high_price' => (float) \App\Models\Setting::get('water_activity_high_price', 800),
        'property_stay_threshold' => (int) \App\Models\Setting::get('property_stay_threshold', 5),
        'cancellation_policy' => \App\Models\Setting::get('cancellation_policy', 'Free cancellation up to 48 hours before check-in.'),
    ];
@endphp

<!-- Luxury Chatbot Container -->
<div id="parudeesa-chatbot" class="chatbot-wrapper" x-data="luxuryChatbot()" x-init="initChat()" :class="{ 'active': isOpen }">
    <div style="display:none"><button id="chatbot-trigger" @click="toggleChat()"></button></div>
    <div class="chat-window" x-show="isOpen" x-transition:enter="chat-enter" x-transition:leave="chat-leave" style="display: none;">
        <div class="chat-header">
            <div class="header-content">
                <img src="{{ asset('images/parudeesa-logo-transp.png') }}" alt="Logo" class="header-logo">
                <div class="header-text">
                    <h3>Parudeesa Assistant</h3>
                    <p><span class="status-dot"></span> Online | Ready to help</p>
                </div>
            </div>
            <button class="close-btn" @click="toggleChat()"><i class="bi bi-x-lg" style="color:var(--chat-dark)"></i></button>
            <div class="progress-bar" :style="'width: ' + progress + '%'"></div>
        </div>
        <div class="chat-body" id="chat-scroll-area">
            <div class="messages-container" style="display: flex; flex-direction: column; gap: 12px;">
                <template x-for="(msg, index) in messages" :key="index">
                    <div class="message-wrapper" :class="msg.type">
                        <div class="message-bubble" :class="msg.type" x-html="msg.content"></div>
                        <template x-if="msg.components">
                            <div class="message-components" x-html="msg.components"></div>
                        </template>
                    </div>
                </template>
                <div class="typing-indicator" x-show="isTyping"><span></span><span></span><span></span></div>
            </div>
        </div>
        <div class="chat-footer" x-show="showQuickReplies">
            <div class="quick-replies">
                <template x-for="option in currentOptions" :key="option.id">
                    <button class="reply-btn" @click="handleOption(option)"><i :class="option.icon" x-show="option.icon"></i><span x-text="option.label"></span></button>
                </template>
            </div>
        </div>
        <div class="chat-booking-footer" x-show="flow !== 'main' && flow !== 'success'">
            <button class="back-btn" @click="goBack()"><i class="bi bi-arrow-left"></i> Back</button>
            <div class="step-info" x-text="'Step ' + step + ' of ' + totalSteps"></div>
        </div>
    </div>
</div>

<style>
    :root {
        --chat-bg: #fdfcfb; --chat-accent: #d4af37; --chat-brand: #fa873e; --chat-dark: #3e2010; --chat-muted: #8a7b6e;
        --chat-border: rgba(212, 175, 55, 0.15); --chat-radius: 24px; --chat-shadow: 0 15px 45px rgba(62, 32, 16, 0.12);
    }
    .chatbot-wrapper { position: fixed; bottom: 30px; right: 30px; z-index: 10000; font-family: 'Outfit', sans-serif; }
    .chat-window { position: absolute; bottom: 85px; right: 0; width: 440px; height: calc(100vh - 150px); max-height: 700px; min-height: 500px; background: var(--chat-bg); border-radius: var(--chat-radius); box-shadow: var(--chat-shadow); display: flex; flex-direction: column; overflow: hidden; border: 1px solid var(--chat-border); transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    .chat-header { background: linear-gradient(135deg, #fff, #f9f6f1); padding: 12px 18px; border-bottom: 1px solid var(--chat-border); display: flex; align-items: center; justify-content: space-between; position: relative; }
    .header-logo { height: 28px; width: auto; object-fit: contain; }
    .header-text h3 { margin: 0; font-size: 15px; font-weight: 700; color: var(--chat-dark); font-family: 'Playfair Display', serif; }
    .header-text p { margin: 0; font-size: 10px; color: var(--chat-muted); text-transform: uppercase; letter-spacing: 1px; }
    .status-dot { width: 6px; height: 6px; background: #10b981; border-radius: 50%; display: inline-block; margin-right: 4px; }
    .progress-bar { position: absolute; bottom: 0; left: 0; height: 2px; background: var(--chat-brand); transition: width 0.4s ease; }
    .chat-body { flex: 1; overflow-y: auto; padding: 20px; padding-bottom: 40px; background-color: #fdfaf5; background-image: radial-gradient(rgba(212, 175, 55, 0.1) 1px, transparent 1px); background-size: 30px 30px; scroll-behavior: smooth; }
    .message-wrapper { display: flex; flex-direction: column; margin-bottom: 15px; max-width: 90%; }
    .message-wrapper.user { align-self: flex-end; align-items: flex-end; }
    .message-wrapper.bot { align-self: flex-start; }
    .message-bubble { padding: 12px 16px; border-radius: 18px; font-size: 14px; line-height: 1.5; }
    .message-bubble.bot { background: white; color: var(--chat-dark); border-bottom-left-radius: 4px; box-shadow: 0 4px 10px rgba(0,0,0,0.03); }
    .message-bubble.user { background: var(--chat-brand); color: white; border-bottom-right-radius: 4px; box-shadow: 0 4px 10px rgba(250,135,62,0.2); font-weight: 500; }
    .message-components { margin-top: 10px; width: 100%; }
    .chatbot-cards { display: flex; flex-direction: column; gap: 12px; }
    .chatbot-card.luxury { background: white; border-radius: 16px; overflow: hidden; border: 1px solid var(--chat-border); cursor: pointer; transition: 0.3s; }
    .chatbot-card.luxury:hover { border-color: var(--chat-brand); transform: translateY(-2px); }
    .card-img { width: 100%; height: 120px; object-fit: cover; }
    .card-body { padding: 12px; }
    .card-body h4 { margin: 4px 0; font-size: 15px; color: var(--chat-dark); }
    .card-price { font-weight: 700; color: var(--chat-brand); font-size: 12px; }
    .details-form, .date-picker-card, .counter-card { background: white; padding: 16px; border-radius: 16px; border: 1px solid var(--chat-border); box-shadow: 0 4px 12px rgba(0,0,0,0.02); }
    .cb-input { width: 100%; padding: 10px; border: 1px solid var(--chat-border); border-radius: 8px; font-size: 13px; margin-top: 5px; outline: none; }
    .input-group label { font-size: 10px; font-weight: 700; color: var(--chat-muted); text-transform: uppercase; }
    .counter-control { display: flex; align-items: center; justify-content: center; gap: 15px; }
    .counter-btn { width: 32px; height: 32px; border-radius: 50%; border: 1px solid var(--chat-brand); background: #fff; color: var(--chat-brand); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 18px; }
    .counter-value { font-size: 18px; font-weight: 700; min-width: 25px; text-align: center; }
    .selection-stack { display: flex; flex-direction: column; gap: 8px; }
    .selection-card { background: white; padding: 18px; border-radius: 20px; border: 1px solid var(--chat-border); display: flex; justify-content: space-between; align-items: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
    .selection-card:hover { border-color: var(--chat-brand); background: #fffcf9; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(250, 135, 62, 0.08); }
    .selection-card.active { border-color: var(--chat-brand); background: #fffaf7; border-width: 2px; }
    .amenity-list { display: flex; flex-direction: column; gap: 12px; }
    .amenity-item { background: white; padding: 16px 18px; border-radius: 20px; border: 1px solid var(--chat-border); display: flex; flex-direction: column; gap: 10px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.02); }
    .amenity-item:hover { border-color: var(--chat-brand); transform: translateY(-2px); box-shadow: 0 8px 25px rgba(250, 135, 62, 0.08); }
    .amenity-item.selected { border-color: var(--chat-brand); background: #fffaf7; border-width: 2px; }
    .amenity-header { display: flex; align-items: center; gap: 15px; }
    .amen-check { width: 22px; height: 22px; border-radius: 50%; border: 1.5px solid var(--chat-accent); display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; transition: 0.3s; color: transparent; }
    .amenity-item.selected .amen-check { background: var(--chat-brand); border-color: var(--chat-brand); color: #fff; }
    .amen-name-price { flex: 1; font-size: 13px; color: var(--chat-dark); display: flex; flex-direction: column; justify-content: center; }
    .amen-counter-row { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(250, 135, 62, 0.1); padding-top: 12px; margin-top: 4px; }
    .qty-btn { width: 24px; height: 24px; border-radius: 6px; border: 1px solid var(--chat-brand); background: #fff; color: var(--chat-brand); cursor: pointer; }
    .qty-val { font-size: 14px; font-weight: 700; min-width: 15px; text-align: center; }
    .summary-card-luxury { background: white; border-radius: 20px; border: 1.5px solid #d4af37; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); margin: 5px 0; }
    .summary-header { background: #3e2010; color: #fff; padding: 12px 18px; display: flex; justify-content: space-between; align-items: center; font-size: 13px; font-weight: 700; font-family: 'Outfit', sans-serif; letter-spacing: 0.5px; }
    .summary-body { padding: 20px; background: #fff; }
    .summary-info-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; }
    .summary-info-row .label { color: #8a7b6e; font-weight: 500; }
    .summary-info-row .val { color: #3e2010; font-weight: 700; text-align: right; }
    .price-breakdown-box { background: #fdfaf7; border: 1px solid rgba(212, 175, 55, 0.1); border-radius: 12px; padding: 15px; margin: 15px 0; }
    .breakdown-title { font-size: 11px; font-weight: 800; color: #8a7b6e; letter-spacing: 1px; margin-bottom: 12px; text-transform: uppercase; }
    .breakdown-line { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 10px; color: #8a7b6e; }
    .breakdown-line strong { color: #3e2010; font-weight: 700; }
    .addon-line-mini { font-size: 10px; color: #8a7b6e; margin-top: -6px; margin-bottom: 10px; padding-left: 2px; opacity: 0.8; font-weight: 600; }
    .subtotal-row { display: flex; justify-content: space-between; margin-top: 15px; padding-top: 15px; border-top: 1px dashed #e0d5c1; font-size: 14px; color: #8a7b6e; }
    .subtotal-row strong { color: #3e2010; font-weight: 700; }
    .total-payable-row { display: flex; justify-content: space-between; align-items: center; margin: 25px 0 20px; padding-top: 15px; border-top: 1px solid rgba(0,0,0,0.05); }
    .total-payable-row .label { font-size: 16px; font-weight: 700; color: #8a7b6e; text-transform: uppercase; letter-spacing: 0.5px; }
    .total-payable-row .amount { font-size: 20px; font-weight: 900; color: #3e2010; font-family: 'Outfit', sans-serif; }
    .confirm-pay-btn { background: #fa873e; color: #fff; border: none; padding: 14px 20px; border-radius: 12px; font-weight: 800; width: 100%; cursor: pointer; font-size: 14px; text-transform: uppercase; letter-spacing: 1.5px; transition: 0.3s; box-shadow: 0 6px 20px rgba(250, 135, 62, 0.25); }
    .confirm-pay-btn:hover { background: #e06828; transform: translateY(-2px); box-shadow: 0 10px 30px rgba(250, 135, 62, 0.4); }

    /* Success Card */
    .success-card { text-align: center; padding: 15px 5px; }
    .success-icon { font-size: 54px; color: #fa873e; margin-bottom: 15px; animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .success-title { font-family: 'Cormorant Garamond', serif; font-size: 32px; font-weight: 700; color: #3e2010; margin-bottom: 8px; line-height: 1.2; }
    .success-text { font-size: 15px; color: #8a7b6e; line-height: 1.6; margin-bottom: 20px; font-weight: 500; }
    @keyframes scaleIn { from { transform: scale(0); opacity: 0; } to { transform: scale(1); opacity: 1; } }

    .chat-footer { padding: 12px; background: #fff; border-top: 1px solid var(--chat-border); }
    .quick-replies { display: flex; flex-wrap: wrap; gap: 6px; justify-content: center; }
    .reply-btn { background: #fff; border: 1.5px solid var(--chat-accent); color: var(--chat-dark); padding: 8px 16px; border-radius: 50px; font-size: 13px; font-weight: 600; cursor: pointer; transition: 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
    .reply-btn:hover { background: var(--chat-accent); color: #fff; transform: translateY(-1px); }
    .btn-premium { background: var(--chat-brand); color: #fff; border: none; padding: 14px 24px; border-radius: 12px; font-weight: 800; width: 100%; cursor: pointer; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }
    .chat-booking-footer { padding: 10px 20px; background: #f9f6f1; border-top: 1px solid var(--chat-border); display: flex; justify-content: space-between; align-items: center; }
    .back-btn { background: none; border: none; color: var(--chat-muted); font-size: 12px; cursor: pointer; font-weight: 600; }
    .step-info { font-size: 10px; font-weight: 700; color: var(--chat-brand); }
    .typing-indicator { display: flex; gap: 4px; padding: 8px 12px; background: #fff; border-radius: 15px; width: fit-content; }
    .typing-indicator span { width: 5px; height: 5px; background: #ccc; border-radius: 50%; animation: typing 1.4s infinite ease-in-out; }
    @keyframes typing { 0%, 80%, 100% { transform: scale(0); } 40% { transform: scale(1); } }
    .chat-enter { animation: slideIn 0.4s ease forwards; }
    @keyframes slideIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .close-btn { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--chat-dark); }
    
    /* Current Total Card */
    .current-total-card {
        background: #fff;
        border: 1.5px solid #fa873e;
        border-radius: 20px;
        padding: 24px;
        margin: 10px 0;
        box-shadow: 0 8px 25px rgba(250, 135, 62, 0.08);
    }
    .current-total-card .card-label {
        font-size: 11px;
        font-weight: 800;
        color: #8a7b6e;
        letter-spacing: 1px;
        margin-bottom: 15px;
        text-transform: uppercase;
    }
    .current-total-card .card-price {
        font-size: 34px;
        font-weight: 900;
        color: #fa873e;
        margin-bottom: 18px;
        font-family: 'Outfit', sans-serif;
    }
    .current-total-card .card-divider {
        height: 1px;
        background: rgba(250, 135, 62, 0.12);
        margin-bottom: 18px;
    }
    .current-total-card .card-row {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        margin-bottom: 10px;
        color: #8a7b6e;
        font-weight: 600;
    }
    .current-total-card .card-row span:last-child {
        color: #3e2010;
        font-weight: 700;
    }

    /* Contact Card Luxury */
    .contact-card-luxury { background: #fff; border-radius: 20px; border: 1px solid var(--chat-border); overflow: hidden; padding: 24px; box-shadow: var(--chat-shadow); }
    .contact-header-mini { font-size: 10px; font-weight: 800; color: var(--chat-brand); letter-spacing: 2px; margin-bottom: 15px; text-align: center; }
    .contact-grid { display: grid; grid-template-columns: 1fr; gap: 15px; }
    .contact-item-box { display: flex; align-items: center; gap: 12px; padding: 12px; background: #fdfaf7; border-radius: 12px; border: 1px solid rgba(250, 135, 62, 0.05); }
    .contact-item-box i { font-size: 18px; color: var(--chat-brand); }
    .contact-details { display: flex; flex-direction: column; }
    .contact-details .label { font-size: 9px; font-weight: 700; color: var(--chat-muted); text-transform: uppercase; }
    .contact-details .val { font-size: 14px; font-weight: 700; color: var(--chat-dark); text-decoration: none; }
    
    .policy-info-box { background: #fff8f3; border-radius: 14px; padding: 15px; border: 1px dashed rgba(250, 135, 62, 0.2); display: flex; flex-direction: column; gap: 12px; }
    .policy-row { display: flex; gap: 10px; align-items: flex-start; }
    .policy-row i { color: var(--chat-brand); font-size: 14px; margin-top: 2px; }
    .policy-row strong { font-size: 11px; color: var(--chat-dark); display: block; margin-bottom: 2px; }
    .policy-row p { margin: 0; font-size: 11px; color: var(--chat-muted); }

    .social-links-row { display: flex; justify-content: center; gap: 15px; }
    .social-link { width: 36px; height: 36px; border-radius: 50%; background: #fff; border: 1px solid var(--chat-border); display: flex; align-items: center; justify-content: center; color: var(--chat-muted); transition: 0.3s; text-decoration: none; }
    .social-link:hover { background: var(--chat-brand); color: #fff; border-color: var(--chat-brand); transform: translateY(-2px); }

    @media (max-width: 480px) { .chat-window { width: 100vw; height: 100vh; bottom: 0; right: 0; border-radius: 0; } .chatbot-wrapper { bottom: 0; right: 0; } }
</style>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
window.toggleChatbot = function() {
    console.log("Chatbot toggle requested");
    if (window.chatbot) window.chatbot.toggleChat();
    else { const btn = document.getElementById('chatbot-trigger'); if (btn) btn.click(); else console.error("Chatbot trigger not found"); }
};
window.openChatbotWithData = function(data) {
    if (window.chatbot) window.chatbot.startStayFlowWithData(data);
    else { const btn = document.getElementById('chatbot-trigger'); if (btn) { btn.click(); setTimeout(() => { if (window.chatbot) window.chatbot.startStayFlowWithData(data); }, 500); } }
};
function luxuryChatbot() {
    return {
        isOpen: false, isTyping: false, flow: 'main', step: 0, totalSteps: 0, progress: 0, messages: [], currentOptions: [], showQuickReplies: true,
        properties: @json($chatbotProperties), yachts: @json($chatbotYachts), amenities: @json($chatbotAmenities), foodPackages: @json($foodPackages), eventServices: @json($eventServices),
        settings: @json($bookingSettings),
        booking: { type: 'stay', bookingId: '', propertyId: null, propertyName: '', checkIn: '', checkOut: '', nights: 1, guests: 2, pets: 0, foodPackageId: "{{ $foodPackages[0]['id'] ?? 'only_stay' }}", selectedAmenities: [], customer: { name: '', phone: '' }, total: 0, yachtId: null, eventType: '', eventDate: '', needStay: false, eventRequirements: [], budget: '', duration: '', notes: '' },
        summaryShown: false,
        mainMenu: [ { id: 'prop_details', label: 'Property Details', icon: 'bi-house-heart' }, { id: 'book_stay', label: 'Book Stay', icon: 'bi-calendar-check' }, { id: 'book_yacht', label: 'Book Yacht', icon: 'bi-water' }, { id: 'book_event', label: 'Book Event', icon: 'bi-stars' }, { id: 'contact', label: 'Contact Us', icon: 'bi-telephone' } ],
        initChat() { window.chatbot = this; this.addMessage("bot", "Welcome to <strong>Parudeesa</strong>. I am your personal assistant. How may I help you today?"); this.currentOptions = this.mainMenu; },
        toggleChat() { this.isOpen = !this.isOpen; if (this.isOpen) setTimeout(() => this.scrollToBottom(), 100); },
        openChat() { this.isOpen = true; setTimeout(() => this.scrollToBottom(), 100); },
        addMessage(type, content, components = null, tag = null) {
            if (tag) { const existing = this.messages.find(m => m.tag === tag); if (existing) { existing.content = content; existing.components = components; this.scrollToBottom(); return; } }
            this.messages.push({ type, content, components, tag }); this.scrollToBottom();
        },
        scrollToBottom() { 
            setTimeout(() => { 
                const area = document.getElementById('chat-scroll-area'); 
                if (area) {
                    area.scrollTo({ top: area.scrollHeight, behavior: 'smooth' });
                }
            }, 100); 
            // Double check after a bit longer for images
            setTimeout(() => {
                const area = document.getElementById('chat-scroll-area');
                if (area) area.scrollTop = area.scrollHeight;
            }, 500);
        },
        async showTyping(ms = 600) { this.isTyping = true; this.showQuickReplies = false; await new Promise(r => setTimeout(r, ms)); this.isTyping = false; },
        async handleOption(option) { if (this.isTyping) return; this.addMessage("user", option.label); await this.showTyping(); switch(option.id) { case 'prop_details': this.startPropertyFlow(); break; case 'book_stay': this.startStayFlow(); break; case 'book_yacht': this.startYachtFlow(); break; case 'book_event': this.startEventFlow(); break; case 'contact': this.startContactFlow(); break; case 'back_main': this.resetToMain(); break; } },
        resetToMain() { this.flow = 'main'; this.step = 0; this.totalSteps = 0; this.progress = 0; this.currentOptions = this.mainMenu; this.showQuickReplies = true; this.addMessage("bot", "How else can I assist you?"); },
        goBack() { if (this.step > 1) { this.step -= 2; this.nextStep(); } else { this.resetToMain(); } },
        async nextStep() { this.step++; this.progress = (this.step / this.totalSteps) * 100; await this.showTyping(600); this.renderStep(); },
        renderStep() { if (this.flow === 'stay') this.renderStayStep(); else if (this.flow === 'yacht') this.renderYachtStep(); else if (this.flow === 'event') this.renderEventStep(); },
        startPropertyFlow() { this.flow = 'property'; this.progress = 20; let cards = '<div class="chatbot-cards">'; this.properties.forEach(p => { cards += `<div class="chatbot-card luxury" onclick="chatbot.showPropInfo(${p.id})"><img src="${p.image}" class="card-img"><div class="card-body"><h4>${p.name}</h4><span class="card-price">Starting from ₹${p.price}</span></div></div>`; }); cards += '</div>'; this.addMessage("bot", "Discover our properties. Select a property to explore its luxury features:", cards); },
        showPropInfo(id) {
            const p = this.properties.find(x => x.id === id); this.addMessage("user", `View ${p.name} Details`);
            const html = `<div class="details-form"><img src="${p.image}" style="width:100%; border-radius:12px; margin-bottom:12px; border: 1px solid var(--chat-border)"><div><h4 style="margin:0; font-size:18px">${p.name}</h4><p style="font-size:12px; color:var(--chat-brand); font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-top:4px">${p.tagline}</p></div><p style="font-size:11px; color:#666; line-height:1.6; margin-bottom:15px">${p.description}</p><div class="input-group" style="margin-top:15px"><label><i class="bi bi-stars"></i> Experience Highlights</label><div style="display:grid; grid-template-columns: 1fr 1fr; gap:8px; margin-top:8px">${p.highlights.map(h => `<div style="font-size:10px; background:#fff; padding:8px; border-radius:10px; color:var(--chat-dark); border:1.5px solid var(--chat-border); display:flex; align-items:center; gap:6px"><i class="${h.icon}" style="color:var(--chat-brand); font-size:12px"></i><span style="font-weight:600; line-height:1.2">${h.label}</span></div>`).join('')}</div></div><button class="btn-premium mt-3" onclick="chatbot.startStayFlow(${p.id})">Book This Property</button></div>`;
            this.addMessage("bot", `Explore the world of <strong>${p.name}</strong>:`, html);
        },
        startStayFlowWithData(data) { this.openChat(); this.flow = 'stay'; this.booking = { ...this.booking, ...data }; this.step = 7; this.totalSteps = 8; this.progress = 80; this.renderStep(); },
        startStayFlow(propertyId = null) { this.flow = 'stay'; this.step = 1; this.totalSteps = 8; this.progress = 10; this.booking.type = 'stay'; if (propertyId) { this.booking.propertyId = propertyId; this.booking.propertyName = this.properties.find(p => p.id === propertyId).name; this.nextStep(); } else { let cards = '<div class="chatbot-cards">'; this.properties.forEach(p => { cards += `<div class="chatbot-card luxury" onclick="chatbot.setBookingProperty(${p.id})"><div class="card-body"><h4>${p.name}</h4></div></div>`; }); cards += '</div>'; this.addMessage("bot", "Which property would you like to stay at?", cards); } },
        setBookingProperty(id) { this.booking.propertyId = id; this.booking.propertyName = this.properties.find(x => x.id === id).name; this.addMessage("user", `Booking ${this.booking.propertyName}`); this.nextStep(); },
        renderStayStep() { switch(this.step) { case 2: this.askDates(); break; case 3: this.askGuests(); break; case 4: this.askPets(); break; case 5: this.askFood(); break; case 6: this.askAmenities(); break; case 7: this.askCustomerDetails(); break; case 8: this.showSummary(); break; } },
        askDates() { 
            const html = `<div class="date-picker-card"><div class="input-group"><label>Check-in</label><input type="text" id="cb-cin" class="cb-input" placeholder="Select"></div><div class="input-group"><label>Check-out</label><input type="text" id="cb-cout" class="cb-input" placeholder="Select"></div><button class="btn-premium mt-3" onclick="chatbot.confirmDates()">Confirm Dates</button></div>`; 
            this.addMessage("bot", "When are you planning to visit?", html); 
            setTimeout(() => { 
                const p = this.properties.find(x => String(x.id) === String(this.booking.propertyId));
                const disabled = (p && p.disabled_dates) ? p.disabled_dates : [];
                flatpickr('#cb-cin', { minDate: 'today', dateFormat: 'Y-m-d', disable: disabled }); 
                flatpickr('#cb-cout', { minDate: 'today', dateFormat: 'Y-m-d', disable: disabled }); 
            }, 300); 
        },
        confirmDates() { 
            const cin = document.getElementById('cb-cin').value; 
            const cout = document.getElementById('cb-cout').value; 
            if (!cin || !cout) return alert("Please select both check-in and check-out dates"); 
            
            const diffTime = new Date(cout) - new Date(cin);
            const nights = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (nights <= 0) {
                alert("Check-out date must be after check-in date");
                return;
            }
            
            this.booking.checkIn = cin; 
            this.booking.checkOut = cout; 
            this.booking.nights = nights; 
            this.addMessage("user", `${cin} to ${cout} (${this.booking.nights} nights)`); 
            this.nextStep(); 
        },
        askGuests() { const html = `<div class="counter-card"><div class="counter-control"><button class="counter-btn" onclick="chatbot.updateCounter('cb-g-val', -1, 1, 15)">-</button><span class="counter-value" id="cb-g-val">2</span><button class="counter-btn" onclick="chatbot.updateCounter('cb-g-val', 1, 1, 15)">+</button></div><button class="btn-premium mt-3" onclick="chatbot.confirmGuests()">Confirm Guests</button></div>`; this.addMessage("bot", "How many guests are we hosting?", html); },
        updateCounter(id, delta, min, max) { const el = document.getElementById(id); let val = parseInt(el.innerText) + delta; if (val < min) val = min; if (val > max) val = max; el.innerText = val; },
        confirmGuests() { this.booking.guests = parseInt(document.getElementById('cb-g-val').innerText); this.addMessage("user", `${this.booking.guests} Guests`); this.nextStep(); },
        askPets() { const html = `<div class="counter-card"><div class="counter-control"><button class="counter-btn" onclick="chatbot.updateCounter('cb-p-val', -1, 0, 5)">-</button><span class="counter-value" id="cb-p-val">0</span><button class="counter-btn" onclick="chatbot.updateCounter('cb-p-val', 1, 0, 5)">+</button></div><button class="btn-premium mt-3" onclick="chatbot.confirmPets()">Confirm Pets</button></div>`; this.addMessage("bot", "Are you bringing any pets?", html); },
        confirmPets() { this.booking.pets = parseInt(document.getElementById('cb-p-val').innerText); this.addMessage("user", this.booking.pets > 0 ? `${this.booking.pets} Pets` : "No pets"); this.nextStep(); },
        askFood() { 
            let options = ''; 
            this.foodPackages.forEach(pkg => { 
                const priceLabel = pkg.price > 0 ? `₹${pkg.price}/person` : '<span style="color:#10b981; font-weight:800; font-size:10px; text-transform:uppercase; letter-spacing:1px">Included</span>';
                options += `
                <div class="selection-card" onclick="chatbot.setFood('${pkg.id}')">
                    <div style="flex:1; padding-right:15px">
                        <span style="font-weight:700; font-size:14px; color:var(--chat-dark); display:block; margin-bottom:2px">${pkg.name}</span>
                        <span style="font-size:11px; color:#8a7b6e; line-height:1.4; display:block">${pkg.desc}</span>
                    </div>
                    <div style="text-align:right">
                        <span style="color:var(--chat-brand); font-weight:800; font-size:13px; white-space:nowrap">${priceLabel}</span>
                    </div>
                </div>`; 
            }); 
            this.addMessage("bot", "Please select your preferred <strong>Dining Plan</strong>:", `<div class="selection-stack" style="gap:15px">${options}</div>`); 
        },
        setFood(id) { this.booking.foodPackageId = id; const pkg = this.foodPackages.find(x => x.id == id); this.addMessage("user", pkg.name); this.nextStep(); },
        askAmenities() {
            const breakdown = this.getBreakdown();
            const previewHtml = `
                <div class="current-total-card">
                    <p class="card-label">CURRENT TOTAL (STAY + FOOD)</p>
                    <div class="card-price">₹${(breakdown.base + breakdown.food).toLocaleString()}</div>
                    <div class="card-divider"></div>
                    <div class="card-row"><span>Base Stay</span><span>₹${breakdown.base.toLocaleString()}</span></div>
                    <div class="card-row"><span>Dining Plan</span><span>₹${breakdown.food.toLocaleString()}</span></div>
                </div>
            `;
            this.addMessage("bot", "Preview of your selection:", previewHtml);

            const p = this.properties.find(x => x.id === this.booking.propertyId); 
            const list = this.amenities.filter(a => a.assignment === p.tag || a.assignment === 'both');
            let html = '<div class="amenity-list">'; 
            list.forEach(a => {
                const isPerPerson = a.type === 'per_person'; const isSelected = !!this.booking.selectedAmenities.find(x => x.id === a.id);
                const aName = a.name.toLowerCase();
                const isWaterActivity = aName.includes("kayaking") || aName.includes("boating");
                
                let title = `<strong>${a.name}</strong> (₹${a.price}${isPerPerson ? '/guest' : ''})`;
                let subtitle = '';
                let counterLabel = 'Guests';
                
                if (isWaterActivity) {
                    title = `<strong>${a.name}</strong>`;
                    subtitle = `<div style="font-size:10px; color:#8a7b6e; margin-top:2px">Below ${this.settings.water_activity_threshold} Guests → ₹${this.settings.water_activity_low_price}/p<br>${this.settings.water_activity_threshold}+ Guests → ₹${this.settings.water_activity_high_price}/p</div>`;
                    counterLabel = 'For how many guests?';
                }
                
                html += `<div class="amenity-item ${isSelected ? 'selected' : ''}" id="amen-${a.id}"><div class="amenity-header" onclick="chatbot.toggleAmen(${a.id})"><div class="amen-check"><i class="bi bi-check"></i></div><div class="amen-name-price">${title}${subtitle}</div></div>${isPerPerson ? `<div class="amen-counter-row" style="display:${isSelected ? 'flex' : 'none'}"><span style="font-size:11px; color:#888">${counterLabel}</span><div style="display:flex; align-items:center; gap:10px"><button class="qty-btn" onclick="chatbot.updateAmenQty(${a.id}, -1)">-</button><span class="qty-val" id="amen-qty-${a.id}">1</span><button class="qty-btn" onclick="chatbot.updateAmenQty(${a.id}, 1)">+</button></div></div>` : ''}</div>`;
            });
            html += '</div><button class="btn-premium mt-3" onclick="chatbot.nextStep()">Continue</button>'; this.addMessage("bot", "Enhance your stay with curated experiences:", html);
        },
        toggleAmen(id) {
            const amen = this.amenities.find(a => a.id === id); const idx = this.booking.selectedAmenities.findIndex(x => x.id === id); const el = document.getElementById(`amen-${id}`); const counterRow = el.querySelector('.amen-counter-row');
            if (idx > -1) { this.booking.selectedAmenities.splice(idx, 1); el.classList.remove('selected'); if (counterRow) counterRow.style.display = 'none'; }
            else { this.booking.selectedAmenities.push({...amen, qty: 1}); el.classList.add('selected'); if (counterRow) counterRow.style.display = 'flex'; }
        },
        updateAmenQty(id, delta) {
            const amen = this.booking.selectedAmenities.find(x => x.id === id); if (!amen) return;
            let val = amen.qty + delta; if (val < 1) val = 1; if (val > this.booking.guests) val = this.booking.guests;
            amen.qty = val; const el = document.getElementById(`amen-qty-${id}`); if (el) el.innerText = val;
            if (this.summaryShown) this.showSummary();
        },
        askCustomerDetails() { const html = `<div class="details-form"><div class="input-group"><label>Full Name</label><input type="text" id="cb-n" placeholder="Name" class="cb-input"></div><div class="input-group"><label>Phone Number</label><input type="tel" id="cb-p" placeholder="Phone" class="cb-input" maxlength="10"></div><button class="btn-premium mt-3" onclick="chatbot.confirmCustomer()">View Summary</button></div>`; this.addMessage("bot", "Final details:", html); },
        confirmCustomer() { const name = document.getElementById('cb-n').value; const phone = document.getElementById('cb-p').value; if (!name || phone.length < 10) return alert("Enter valid details"); this.booking.customer = { name, phone }; this.addMessage("user", `${name} (${phone})`); this.nextStep(); },
        showSummary() {
            this.calculateTotal(); const pkg = this.foodPackages.find(x => x.id == this.booking.foodPackageId); const breakdown = this.getBreakdown();
            if (!this.booking.bookingId) this.booking.bookingId = Math.floor(1000 + Math.random() * 9000);
            const amenitiesList = this.booking.selectedAmenities.map(a => `${a.name}(x${a.qty})`).join(', ');
            const html = `
                <div class="summary-card-luxury">
                    <div class="summary-header">
                        <span>RESERVATION SUMMARY</span>
                        <span>#${this.booking.bookingId}</span>
                    </div>
                    <div class="summary-body">
                        <div class="summary-info-row"><span class="label">Property</span><span class="val">${this.booking.propertyName}</span></div>
                        <div class="summary-info-row"><span class="label">Stay Dates</span><span class="val">${this.booking.checkIn} to ${this.booking.checkOut}</span></div>
                        <div class="summary-info-row"><span class="label">Occupancy</span><span class="val">${this.booking.guests} Guests</span></div>
                        
                        <div class="price-breakdown-box">
                            <div class="breakdown-title">PRICE BREAKDOWN</div>
                            <div class="breakdown-line"><span>Stay (${this.booking.nights} nights)</span><strong>₹${breakdown.base.toLocaleString()}</strong></div>
                            <div class="breakdown-line"><span>Dining (${pkg.name})</span><strong>₹${breakdown.food.toLocaleString()}</strong></div>
                            <div class="breakdown-line"><span>Curated Services</span><strong>₹${breakdown.amens.toLocaleString()}</strong></div>
                            <div class="addon-line-mini">${amenitiesList || 'No additional services'}</div>
                        </div>
                        
                        <div class="subtotal-row"><span>Subtotal Amount</span><strong>₹${this.booking.total.toLocaleString()}</strong></div>
                        <div class="total-payable-row"><span class="label">Total Payable</span><span class="amount">₹${this.booking.total.toLocaleString()}</span></div>
                        
                        <button class="confirm-pay-btn" onclick="chatbot.pay()">CONFIRM & PAY SECURELY</button>
                    </div>
                </div>`;
            this.addMessage("bot", "Please review your bespoke itinerary:", html, 'booking-summary'); this.summaryShown = true;
        },
        getBreakdown() {
            const p = this.properties.find(x => x.id === this.booking.propertyId); 
            const nights = Math.max(this.booking.nights, 0);
            const cin = new Date(this.booking.checkIn);
            let stayTotal = 0;

            for (let i = 0; i < nights; i++) {
                const day = new Date(cin);
                day.setDate(cin.getDate() + i);
                const isWeekend = [5, 6, 0].includes(day.getDay()); // Fri, Sat, Sun
                
                let dailyRate = 0;
                if (isWeekend) {
                    dailyRate = parseFloat(p.weekend_price) || 12000;
                } else {
                    if (this.booking.guests <= this.settings.property_stay_threshold) {
                        dailyRate = parseFloat(p.weekday_price) || 8000;
                    } else {
                        dailyRate = parseFloat(p.weekday_tier2_price) || 11000;
                    }
                }
                stayTotal += dailyRate;
            }
            
            const base = stayTotal;
            
            const foodPkg = this.foodPackages.find(x => x.id == this.booking.foodPackageId);
            const food = (foodPkg ? foodPkg.price : 0) * this.booking.guests * nights;
            
            const amens = this.booking.selectedAmenities.reduce((s, a) => {
                let price = a.price;
                const aName = a.name.toLowerCase();
                if (aName.includes("kayaking") || aName.includes("boating")) { 
                    price = a.qty < this.settings.water_activity_threshold ? this.settings.water_activity_low_price : this.settings.water_activity_high_price;
                }
                return s + (price * a.qty);
            }, 0);
            
            return { base, food, amens };
        },
        calculateTotal() { const b = this.getBreakdown(); this.booking.total = b.base + b.food + b.amens; },
        async pay() {
            this.isTyping = true;
            try {
                const pkg = this.foodPackages.find(x => x.id == this.booking.foodPackageId);
                const resp = await fetch('/chatbot/checkout', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                    body: JSON.stringify({
                        property_id: this.booking.propertyId,
                        check_in: this.booking.checkIn,
                        check_out: this.booking.checkOut,
                        guests: this.booking.guests,
                        package_name: pkg.name,
                        name: this.booking.customer.name,
                        phone: this.booking.customer.phone,
                        amenities: this.booking.selectedAmenities.map(a => ({ id: a.id, quantity: a.qty }))
                    })
                });
                
                if (!resp.ok) {
                    let msg = "Server error occurred.";
                    try {
                        const data = await resp.json();
                        msg = data.message || msg;
                    } catch (e) {
                        const txt = await resp.text();
                        console.error("Non-JSON error:", txt);
                    }
                    throw new Error(msg);
                }

                const data = await resp.json();
                if (!data.success) throw new Error(data.message || 'Checkout failed');

                const options = {
                    key: data.razorpay_key,
                    amount: data.order.amount,
                    currency: data.order.currency,
                    name: "Parudeesa Resort",
                    description: `Booking for ${this.booking.customer.name}`,
                    order_id: data.order.id,
                    handler: async (response) => {
                        this.addMessage("bot", "Payment successful! Finalizing your reservation...");
                        await this.verifyPayment(response, data.booking_id);
                    },
                    prefill: { name: this.booking.customer.name, contact: this.booking.customer.phone },
                    theme: { color: "#fa873e" }
                };
                const rzp = new Razorpay(options);
                rzp.open();
            } catch (e) {
                alert("Booking Error: " + e.message);
                console.error(e);
            } finally {
                this.isTyping = false;
            }
        },
        async verifyPayment(res, booking_id) { 
            this.isTyping = true; 
            try { 
                const response = await fetch('/chatbot/payment/verify', { 
                    method: 'POST', 
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }, 
                    body: JSON.stringify({ 
                        booking_id: booking_id, 
                        razorpay_order_id: res.razorpay_order_id, 
                        razorpay_payment_id: res.razorpay_payment_id, 
                        razorpay_signature: res.razorpay_signature 
                    }) 
                }); 
                const data = await response.json(); 
                if (data.success) this.showSuccess(res.razorpay_payment_id); 
                else throw new Error(data.message || "Verification failed"); 
            } catch (e) { 
                alert("Verification Error: " + e.message); 
            } finally { 
                this.isTyping = false; 
            } 
        },
        showSuccess(id) { 
            this.flow = 'success'; 
            const successHtml = `
                <div class="success-card">
                    <div class="success-icon"><i class="bi bi-check-circle-fill"></i></div>
                    <h3 class="success-title">Reserved!</h3>
                    <p class="success-text">Your bespoke stay at Parudeesa is confirmed. Our concierge will reach out to you shortly via phone.</p>
                    <button class="btn-premium w-100" onclick="chatbot.resetToMain()">DONE</button>
                </div>
            `;
            this.addMessage("bot", "Booking Confirmed!", successHtml); 
        },
        startYachtFlow() { this.flow = 'yacht'; this.step = 1; this.totalSteps = 6; this.progress = 16; let cards = '<div class="chatbot-cards">'; this.yachts.forEach(y => { cards += `<div class="chatbot-card luxury" onclick="chatbot.setYacht(${y.id})"><img src="${y.image}" class="card-img"><div class="card-body"><h4>${y.name}</h4><span>₹${y.price}</span></div></div>`; }); cards += '</div>'; this.addMessage("bot", "Set sail in style:", cards); },
        setYacht(id) { const y = this.yachts.find(x => x.id === id); this.booking.yachtId = id; this.booking.propertyName = y.name; this.booking.total = y.price; this.addMessage("user", `Booking ${y.name}`); this.nextStep(); },
        renderYachtStep() { switch(this.step) { case 2: this.askYachtDate(); break; case 3: this.askYachtGuests(); break; case 4: this.askYachtCustomerDetails(); break; case 5: this.showYachtSummary(); break; case 6: this.showYachtPayment(); break; } },
        askYachtDate() { 
            const html = `<div class="date-picker-card"><div class="input-group"><label>Booking Date</label><input type="text" id="cy-d" class="cb-input" placeholder="Select Date"></div><button class="btn-premium mt-3" onclick="chatbot.confirmYachtDate()">Next</button></div>`;
            this.addMessage("bot", "When would you like to set sail?", html); 
            setTimeout(() => { 
                const y = this.yachts.find(x => String(x.id) === String(this.booking.yachtId));
                const disabled = (y && y.disabled_dates) ? y.disabled_dates : [];
                flatpickr('#cy-d', { minDate: 'today', dateFormat: 'Y-m-d', disable: disabled }); 
            }, 300); 
        },
        confirmYachtDate() { const d = document.getElementById('cy-d').value; if (!d) return alert("Select date"); this.booking.eventDate = d; this.addMessage("user", `Date: ${d}`); this.nextStep(); },
        askYachtGuests() {
            const html = `<div class="counter-card"><div class="counter-control"><button class="counter-btn" onclick="chatbot.updateCounter('cy-g-val', -1, 1, 10)">-</button><span class="counter-value" id="cy-g-val">1</span><button class="counter-btn" onclick="chatbot.updateCounter('cy-g-val', 1, 1, 10)">+</button></div><p style="font-size:10px; color:var(--chat-muted); text-align:center; margin-top:5px;">Max 10 guests</p><button class="btn-premium mt-3" onclick="chatbot.confirmYachtGuests()">Confirm Guests</button></div>`;
            this.addMessage("bot", "How many guests will be joining?", html);
        },
        confirmYachtGuests() { const g = parseInt(document.getElementById('cy-g-val').innerText); this.booking.guests = g; this.addMessage("user", `${g} Guest${g>1?'s':''}`); this.nextStep(); },
        askYachtCustomerDetails() { 
            const html = `<div class="details-form">
                <input type="text" id="cy-n" placeholder="Full Name" class="cb-input">
                <input type="tel" id="cy-p" placeholder="Phone Number" class="cb-input" maxlength="10">
                <textarea id="cy-req" placeholder="Special Requirements (e.g., cake, decor, menu requests)" class="cb-input" style="height:80px; padding:12px;"></textarea>
                <button class="btn-premium mt-3" onclick="chatbot.confirmYachtCustomerDetails()">Proceed to Summary</button>
            </div>`; 
            this.addMessage("bot", "Please provide your contact details and any special requests:", html); 
        },
        confirmYachtCustomerDetails() { 
            const n = document.getElementById('cy-n').value; 
            const p = document.getElementById('cy-p').value; 
            const r = document.getElementById('cy-req').value; 
            if (n.length < 3) return alert("Enter valid name"); 
            if (p.length < 10) return alert("Enter valid phone"); 
            this.booking.customer = { name: n, phone: p }; 
            this.booking.notes = r; 
            this.addMessage("user", "Details provided"); 
            this.nextStep(); 
        },
        showYachtSummary() {
            if (!this.booking.bookingId) this.booking.bookingId = Math.floor(1000 + Math.random() * 9000);
            const html = `
                <div class="summary-card-luxury">
                    <div class="summary-header">
                        <span>CRUISE SUMMARY</span>
                        <span>#${this.booking.bookingId}</span>
                    </div>
                    <div class="summary-body">
                        <div class="summary-info-row"><span class="label">Experience</span><span class="val">${this.booking.propertyName}</span></div>
                        <div class="summary-info-row"><span class="label">Cruise Date</span><span class="val">${this.booking.eventDate}</span></div>
                        <div class="summary-info-row"><span class="label">Guest Count</span><span class="val">${this.booking.guests} People</span></div>
                        ${this.booking.notes ? `<div class="summary-info-row"><span class="label">Special Requests</span><span class="val">${this.booking.notes}</span></div>` : ''}
                        
                        <div class="price-breakdown-box">
                            <div class="breakdown-title">PRICE BREAKDOWN</div>
                            <div class="breakdown-line"><span>Charter Base Rate</span><strong>₹${this.booking.total.toLocaleString()}</strong></div>
                            <div class="breakdown-line"><span>Curated Refreshments</span><strong>Included</strong></div>
                        </div>
                        
                        <div class="subtotal-row"><span>Subtotal Amount</span><strong>₹${this.booking.total.toLocaleString()}</strong></div>
                        <div class="total-payable-row"><span class="label">Total Charter Fee</span><span class="amount">₹${this.booking.total.toLocaleString()}</span></div>
                        
                        <button class="confirm-pay-btn" onclick="chatbot.nextStep()">PROCEED TO PAYMENT</button>
                    </div>
                </div>`;
            this.addMessage("bot", "Please review your private charter details:", html);
        },
        showYachtPayment() { this.addMessage("bot", "Complete Payment:", `<div class="details-form text-center"><img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=upi://pay?pa=parudeesa@upi&pn=Parudeesa" style="width:120px"><p>parudeesa@upi</p><button class="btn-premium" onclick="chatbot.finishYacht()">I Have Paid</button></div>`); },
        async finishYacht() { 
            this.isTyping = true; 
            try { 
                await fetch('/book-yacht', { 
                    method: 'POST', 
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }, 
                    body: JSON.stringify({ name: this.booking.customer.name, phone: this.booking.customer.phone, booking_date: this.booking.eventDate, yacht_id: this.booking.yachtId }) 
                }); 
                this.flow = 'success'; 
                const successHtml = `
                    <div class="success-card">
                        <div class="success-icon"><i class="bi bi-water"></i></div>
                        <h3 class="success-title">Cruise Requested!</h3>
                        <p class="success-text">Your luxury yacht experience request is received. Please WhatsApp your screenshot to +91 89210 21202 to finalize.</p>
                        <button class="btn-premium w-100" onclick="chatbot.resetToMain()">FINISH</button>
                    </div>
                `;
                this.addMessage("bot", "Success!", successHtml); 
            } catch (e) { alert(e.message); } finally { this.isTyping = false; } 
        },
        startEventFlow() { 
            this.flow = 'event'; 
            this.step = 1; 
            this.totalSteps = 8; 
            this.progress = 12; 
            const html = `
                <div class="chatbot-card luxury">
                    <img src="/images/event-hero-main.jpg" class="card-img" style="height:140px">
                    <div class="card-body">
                        <p style="font-size:10px; color:var(--chat-brand); font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px">Bespoke Celebrations</p>
                        <h4 style="font-family:'Cormorant Garamond', serif; font-size:18px">Lakeside Events</h4>
                        <p style="font-size:11px; color:#666; line-height:1.5; margin-top:5px">From intimate gatherings to grand celebrations, we craft moments that last a lifetime.</p>
                    </div>
                </div>`;
            this.addMessage("bot", "Let's begin planning your extraordinary event at Parudeesa:", html);
            this.nextStep(); 
        },
        renderEventStep() { 
            switch(this.step) { 
                case 2: this.askEventBasic(); break; 
                case 3: this.askEventProperty(); break; 
                case 4: this.askEventNeedStay(); break;
                case 5: if (this.booking.eventStayNeeded) { this.askEventStayDetails(); } else { this.step++; this.renderEventStep(); } break; 
                case 6: this.askEventRequirements(); break; 
                case 7: this.askEventBudget(); break; 
                case 8: this.showEventSummary(); break; 
            } 
        },
        askEventBasic() { 
            const html = `<div class="details-form">
                <div class="input-group"><label>Your Name</label><input type="text" id="ce-n" placeholder="Full Name" class="cb-input"></div>
                <div class="input-group" style="margin-top:10px"><label>Phone Number</label><input type="tel" id="ce-p" placeholder="10-digit mobile" class="cb-input" maxlength="10"></div>
                <div class="input-group" style="margin-top:10px">
                    <label>Celebration Type</label>
                    <select id="ce-t" class="cb-input">
                        <option value="" disabled selected>Select event type</option>
                        <option>Wedding & Pre-Wedding</option>
                        <option>Birthday Celebration</option>
                        <option>Gender Reveal Party</option>
                        <option>Honeymoon Staycation</option>
                        <option>Corporate Retreat</option>
                        <option>Family Gathering</option>
                        <option>Other Event</option>
                    </select>
                </div>
                <div class="input-group" style="margin-top:10px"><label>Event Date</label><input type="text" id="ce-d" placeholder="Pick a date" class="cb-input"></div>
                <div class="input-group" style="margin-top:10px"><label>Guest Count</label><input type="number" id="ce-g" placeholder="Approx. guests" class="cb-input" min="1"></div>
                <button class="btn-premium mt-3" onclick="chatbot.confirmEventBasic()">Next Step</button>
            </div>`; 
            this.addMessage("bot", "Tell us a bit about your celebration:", html); 
            setTimeout(() => { flatpickr('#ce-d', { minDate: 'today', dateFormat: 'Y-m-d' }); }, 100); 
        },
        confirmEventBasic() { 
            const n = document.getElementById('ce-n').value; 
            const p = document.getElementById('ce-p').value; 
            const t = document.getElementById('ce-t').value;
            const d = document.getElementById('ce-d').value;
            const g = document.getElementById('ce-g').value;
            if (!n || p.length < 10 || !t || !d || !g) return alert("Please fill all details correctly"); 
            
            this.booking.customer = { name: n, phone: p }; 
            this.booking.eventType = t; 
            this.booking.eventDate = d; 
            this.booking.guests = g;
            this.addMessage("user", `${t} for ${g} guests on ${d}`); 
            this.nextStep(); 
        },
        askEventProperty() { let options = ''; this.properties.forEach(p => { options += `<div class="selection-card" onclick="chatbot.setEventProp(${p.id}, '${p.name}')"><span>${p.name}</span><i class="bi bi-geo-alt" style="color:var(--chat-brand)"></i></div>`; }); this.addMessage("bot", "Where would you like to host this event?", `<div class="selection-stack">${options}</div>`); },
        setEventProp(id, name) { this.booking.propertyId = id; this.booking.propertyName = name; this.addMessage("user", name); this.nextStep(); },
        askEventNeedStay() {
            const html = `
                <div class="details-form" style="background:#fffaf5; border:1px dashed var(--chat-brand)">
                    <div style="text-align:center; margin-bottom:15px">
                        <i class="bi bi-house-heart" style="font-size:28px; color:var(--chat-brand)"></i>
                        <h5 style="margin-top:8px; font-weight:700">Stay Required?</h5>
                        <p style="font-size:11px; color:#8a7b6e">Would you like to book accommodation for your guests?</p>
                    </div>
                    <div class="selection-stack">
                        <div class="selection-card" onclick="chatbot.setEventStay(true)" style="background:#fff"><span>Yes, Overnight Stay</span><i class="bi bi-check-circle-fill" style="color:#10b981"></i></div>
                        <div class="selection-card" onclick="chatbot.setEventStay(false)" style="background:#fff"><span>No, Just the Event</span><i class="bi bi-x-circle" style="color:#8a7b6e"></i></div>
                    </div>
                </div>`;
            this.addMessage("bot", "Accommodation Requirements:", html);
        },
        setEventStay(needed) { 
            this.booking.eventStayNeeded = needed; 
            this.addMessage("user", needed ? "Yes, Stay Required" : "No Stay Needed"); 
            this.nextStep(); 
        },
        askEventRequirements() { 
            const options = this.eventServices;
            
            let html = '<div class="amenity-list">';
            options.forEach(opt => {
                const isSelected = this.booking.eventRequirements.includes(opt.id);
                html += `
                    <div class="amenity-item ${isSelected ? 'selected' : ''}" onclick="chatbot.toggleEventReq('${opt.id}', this)">
                        <div class="amenity-header">
                            <div class="amen-check"><i class="bi bi-check"></i></div>
                            <div class="amen-name-price">
                                <span style="display:flex; align-items:center; gap:8px;">
                                    <i class="bi ${opt.icon}" style="color:var(--chat-brand); font-size:14px;"></i>
                                    <strong>${opt.name}</strong>
                                </span>
                            </div>
                        </div>
                    </div>`;
            });
            html += '</div><button class="btn-premium mt-3" onclick="chatbot.nextStep()">CONFIRM & NEXT STEP</button>';
            this.addMessage("bot", "What luxury services will your event require? (Select multiple)", html); 
        },
        toggleEventReq(req, el) { 
            const idx = this.booking.eventRequirements.indexOf(req); 
            if (idx > -1) {
                this.booking.eventRequirements.splice(idx, 1);
                el.classList.remove('selected');
            } else {
                this.booking.eventRequirements.push(req);
                el.classList.add('selected');
            }
        },
        askEventStayDetails() {
            const html = `
                <div class="date-picker-card">
                    <div class="input-group"><label>Staying Guests</label><input type="number" id="ce-s-g" class="cb-input" placeholder="No. of guests" value="2"></div>
                    <div class="input-group"><label>Check-in</label><input type="text" id="ce-s-cin" class="cb-input" placeholder="Select"></div>
                    <div class="input-group"><label>Check-out</label><input type="text" id="ce-s-cout" class="cb-input" placeholder="Select"></div>
                    <button class="btn-premium mt-3" onclick="chatbot.confirmEventStay()">Confirm Stay Details</button>
                </div>`;
            this.addMessage("bot", "Accommodation details:", html);
            setTimeout(() => {
                const p = this.properties.find(x => String(x.id) === String(this.booking.propertyId));
                const disabled = (p && p.disabled_dates) ? p.disabled_dates : [];
                flatpickr('#ce-s-cin', { minDate: 'today', dateFormat: 'Y-m-d', disable: disabled });
                flatpickr('#ce-s-cout', { minDate: 'today', dateFormat: 'Y-m-d', disable: disabled });
            }, 100);
        },
        confirmEventStay() {
            const g = document.getElementById('ce-s-g').value;
            const cin = document.getElementById('ce-s-cin').value;
            const cout = document.getElementById('ce-s-cout').value;
            if (!cin || !cout) return alert("Please select both check-in and check-out dates");
            
            const diffTime = new Date(cout) - new Date(cin);
            const nights = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (nights <= 0) {
                alert("Check-out date must be after check-in date");
                return;
            }
            
            this.booking.guests = g;
            this.booking.checkIn = cin;
            this.booking.checkOut = cout;
            this.booking.nights = nights;

            const p = this.properties.find(x => String(x.id) === String(this.booking.propertyId));
            const subtotal = p.price * nights;

            const previewHtml = `
                <div class="current-total-card">
                    <p class="card-label">EVENT STAY SUBTOTAL</p>
                    <div class="card-price">₹${subtotal.toLocaleString()}</div>
                    <div class="card-divider"></div>
                    <div class="card-row"><span>Stay (${nights} nights)</span><span>₹${subtotal.toLocaleString()}</span></div>
                </div>
            `;
            this.addMessage("bot", "Preview of your selection:", previewHtml);
            this.addMessage("user", `Stay for ${g} guests, ${cin} to ${cout} (${nights} nights)`);
            this.nextStep();
        },
        askEventBudget() { 
            const html = `
                <div class="details-form">
                    <p style="font-size:12px; color:#8a7b6e; margin-bottom:12px;">To better curate your experience, please share your estimated budget range.</p>
                    <div class="input-group">
                        <label>Budget Range (₹)</label>
                        <input type="text" id="ce-b" placeholder="e.g. 50,000 - 1,00,000" class="cb-input">
                    </div>
                    <button class="btn-premium mt-3" onclick="chatbot.confirmEventFinal()">Preview My Inquiry</button>
                </div>`; 
            this.addMessage("bot", "Your celebration vision:", html); 
        },
        confirmEventFinal() { this.booking.budget = document.getElementById('ce-b').value; this.addMessage("user", `Budget: ${this.booking.budget}`); this.nextStep(); },
        showEventSummary() {
            if (!this.booking.bookingId) this.booking.bookingId = Math.floor(1000 + Math.random() * 9000);
            
            // Map requirement IDs to names for the summary
            const requirementNames = this.booking.eventRequirements.map(id => {
                const svc = this.eventServices.find(s => s.id === id);
                return svc ? svc.name : id;
            });

            const html = `
                <div class="summary-card-luxury">
                    <div class="summary-header" style="background:var(--chat-brand)">
                        <span>EVENT INQUIRY REVIEW</span>
                        <span>#${this.booking.bookingId}</span>
                    </div>
                    <div class="summary-body">
                        <div class="summary-info-row"><span class="label">Event Type</span><span class="val" style="color:var(--chat-brand)">${this.booking.eventType}</span></div>
                        <div class="summary-info-row"><span class="label">Planned Date</span><span class="val">${this.booking.eventDate}</span></div>
                        <div class="summary-info-row"><span class="label">Location</span><span class="val">${this.booking.propertyName}</span></div>
                        <div class="summary-info-row"><span class="label">Guests</span><span class="val">${this.booking.guests} People</span></div>
                        
                        <div class="price-breakdown-box" style="background:#fffaf5">
                            <div class="breakdown-title" style="color:var(--chat-brand)">CURATION DETAILS</div>
                            <div class="breakdown-line"><span>Accommodation</span><strong>${this.booking.eventStayNeeded ? 'Overnight Stay' : 'Day Event Only'}</strong></div>
                            ${this.booking.eventStayNeeded ? `<div class="breakdown-line" style="font-size:11px; margin-top:-8px"><span>Stay Duration</span><span>${this.booking.checkIn} to ${this.booking.checkOut}</span></div>` : ''}
                            <div class="breakdown-line"><span>Estimated Budget</span><strong>₹${this.booking.budget || 'To be discussed'}</strong></div>
                            <div class="breakdown-line" style="margin-top:10px; border-top:1px solid rgba(0,0,0,0.05); padding-top:10px"><span>Services Requested</span><strong>${requirementNames.length} Items</strong></div>
                            <div class="addon-line-mini" style="margin-top:5px; color:var(--chat-brand); line-height:1.4">${requirementNames.join(' • ') || 'Standard planning only'}</div>
                        </div>
                        
                        <div class="total-payable-row" style="margin-top: 15px; border-top:none">
                            <span class="label" style="font-size: 13px; letter-spacing: 1px;">Status</span>
                            <span class="amount" style="font-size: 16px; color: #fa873e;">READY TO CURATE</span>
                        </div>
                        
                        <button class="confirm-pay-btn" onclick="chatbot.submitEvent()">SEND PROPOSAL REQUEST</button>
                    </div>
                </div>`;
            this.addMessage("bot", "Everything looks perfect. Shall we send this vision to our events team?", html, 'event-summary');
        },
        async submitEvent() { 
            this.isTyping = true; 
            try { 
                const requirementNames = this.booking.eventRequirements.map(id => {
                    const svc = this.eventServices.find(s => s.id === id);
                    return svc ? svc.name : id;
                });

                const payload = { 
                    name: this.booking.customer.name, 
                    phone: this.booking.customer.phone, 
                    event_type: this.booking.eventType, 
                    event_date: this.booking.eventDate, 
                    property_id: this.booking.propertyId, 
                    guests: this.booking.guests,
                    need_stay: this.booking.eventStayNeeded ? 'Yes' : 'No',
                    check_in: this.booking.checkIn,
                    check_out: this.booking.checkOut,
                    stay_guests: this.booking.eventStayNeeded ? this.booking.guests : null,
                    budget: this.booking.budget,
                    requirements: requirementNames,
                    notes: "Inquiry via Chatbot Assistant"
                };

                const resp = await fetch('/events/inquiry', { 
                    method: 'POST', 
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }, 
                    body: JSON.stringify(payload) 
                }); 

                if (!resp.ok) throw new Error("Failed to send inquiry");

                this.flow = 'success'; 
                const successHtml = `
                    <div class="success-card">
                        <div class="success-icon" style="color:#10b981"><i class="bi bi-stars"></i></div>
                        <h3 class="success-title">Vision Received!</h3>
                        <p class="success-text">Your celebration inquiry has been successfully shared with our premium events team. We will connect with you within 4–5 hours. Thank you!</p>
                        <button class="btn-premium w-100" onclick="chatbot.resetToMain()">FINISH</button>
                    </div>
                `;
                this.addMessage("bot", "Request Sent Successfully", successHtml); 
            } catch (e) { alert("Error: " + e.message); } finally { this.isTyping = false; } 
        },
        startContactFlow() { 
            const html = `
                <div class="contact-card-luxury">
                    <div class="contact-header-mini">PREMIUM HOSPITALITY CONCIERGE</div>
                    
                    <div style="text-align:center; margin-bottom:20px;">
                        <h4 style="font-family:'Playfair Display', serif; color:var(--chat-dark); font-size:18px">How can we assist?</h4>
                        <p style="font-size:12px; color:var(--chat-muted)">Our dedicated team is ready to curate your lakeside experience.</p>
                    </div>

                    <div class="contact-grid">
                        <div class="contact-item-box" style="background:#fffaf5; border:1px solid rgba(250,135,62,0.1)">
                            <i class="bi bi-telephone-fill" style="color:var(--chat-brand)"></i>
                            <div class="contact-details">
                                <span class="label">Main Reservations</span>
                                <a href="tel:+918921021202" class="val">+91 89210 21202</a>
                            </div>
                        </div>
                        <div class="contact-item-box" style="background:#f5f8ff; border:1px solid rgba(0,102,255,0.05)">
                            <i class="bi bi-envelope-at-fill" style="color:#0066cc"></i>
                            <div class="contact-details">
                                <span class="label">Inquiries & Feedback</span>
                                <a href="mailto:stay@parudeesa.com" class="val">stay@parudeesa.com</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="policy-info-box mt-3" style="background:#fafafa; border:1px solid #eee">
                        <div class="policy-row">
                            <i class="bi bi-clock" style="color:#666"></i>
                            <div>
                                <strong style="color:#444">Resort Timings</strong>
                                <p>Check-in: ${this.settings.check_in_time} | Check-out: ${this.settings.check_out_time}</p>
                            </div>
                        </div>
                        <div class="policy-row">
                            <i class="bi bi-geo-alt" style="color:#666"></i>
                            <div>
                                <strong style="color:#444">Location</strong>
                                <p>Lakeside Road, Kerala Backwaters</p>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top:20px; text-align:center">
                        <p style="font-size:10px; font-weight:700; color:#aaa; letter-spacing:1px; margin-bottom:12px">FOLLOW OUR STORY</p>
                        <div class="social-links-row">
                            <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="social-link"><i class="bi bi-youtube"></i></a>
                        </div>
                    </div>
                </div>
            `;
            this.addMessage("bot", "Our concierge team is at your service:", html); 
            this.resetToMain(); 
        }
    }
}
</script>
