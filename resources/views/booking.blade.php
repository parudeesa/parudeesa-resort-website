<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Parudeesa Booking Form</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Outfit:wght@100..900&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>
:root {
  --brand: #fa873e;
  --brand-d: #e06828;
  --brand-l: #ffb07a;
  --brand-pale: #fff3ec;
  --text-dark: #3b2a22;
  --text-muted: #5a5a5a;
  --gold: #fa873e;
  --ease: 0.4s cubic-bezier(0.25, 1, 0.5, 1);
}

body{
    margin:0;
    padding:0;
    font-family:'Outfit',sans-serif;
    background:linear-gradient(135deg,#fff8f2,#fde9d8);
    font-weight: 300;
    letter-spacing: 0.01em;
    color: #5a5a5a;
}

/* Footer Styles */
footer {
    background: linear-gradient(160deg, #1e0a02 0%, #3e2010 100%);
    color: rgba(255, 243, 236, .6);
    padding: 70px 0 calc(24px + var(--safe-b));
    border-top: 2px solid rgba(250, 135, 62, .2);
}

.form-container{
    width:90%;
    max-width:700px;
    margin:120px auto 40px;
    background:#fff3ec;
    padding:35px;
    border-radius:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    border:1px solid rgba(250,135,62,.15);
}

h1{
    text-align:center;
    font-family:'Playfair Display',serif;
    font-weight: 600;
    color:#3b2a22;
    margin-bottom:10px;
}

.subtitle{
    text-align:center;
    color:#8b6040;
    margin-bottom:30px;
    font-size:14px;
}

.form-group{
    margin-bottom:18px;
}

label{
    display:block;
    margin-bottom:6px;
    font-size:14px;
    color:#6a3b1c;
    font-weight:600;
}

input,select,textarea{
    width:100%;
    padding:12px 14px;
    border:1px solid rgba(250,135,62,.25);
    border-radius:12px;
    font-size:14px;
    font-family:'Outfit',sans-serif;
    background:#fff;
    box-sizing:border-box;
    outline:none;
    letter-spacing: 0.02em;
}

input:focus,select:focus,textarea:focus{
    border-color:#fa873e;
    box-shadow:0 0 0 3px rgba(250,135,62,.12);
}

textarea{
    resize:none;
    min-height:90px;
}

.checkbox-group{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:10px;
    margin-top:8px;
}

.checkbox-group label{
    display:flex;
    align-items:center;
    gap:8px;
    background:#fff;
    padding:10px 12px;
    border-radius:10px;
    border:1px solid rgba(250,135,62,.15);
    cursor:pointer;
    font-weight:400;
    transition:all .3s ease;
}

.checkbox-group label:hover{
    background:rgba(250,135,62,.05);
    border-color:rgba(250,135,62,.3);
}

.checkbox-group input{
    width:auto;
}

button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:14px;
    background:linear-gradient(135deg,#fa873e,#d96520);
    color:white;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
    margin-top:10px;
    transition:all .3s ease;
    text-transform: uppercase;
    letter-spacing: 0.1em;
}

button:hover{
    opacity:0.95;
    transform:translateY(-2px);
}

.success-message{
    margin-top:20px;
    background:#fff;
    border-left:4px solid #fa873e;
    padding:15px;
    color:#6a3b1c;
    display:none;
    border-radius:10px;
    line-height:1.6;
    animation:slideIn .4s ease;
}

@keyframes slideIn{
    from{
        opacity:0;
        transform:translateY(-10px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

.coupon-section {
    background: rgba(250,135,62,0.08);
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 18px;
    border: 1px dashed rgba(250,135,62,0.3);
}
.coupon-badge {
    display: inline-block;
    background: #fff;
    border: 1px solid #fa873e;
    color: #fa873e;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 800;
    margin: 5px;
    cursor: pointer;
}
.price-summary {
    background: #fff;
    padding: 15px;
    border-radius: 12px;
    margin-top: 15px;
    font-size: 14px;
}
.price-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
}
.final-total {
    border-top: 1px solid #eee;
    padding-top: 10px;
    margin-top: 10px;
    font-weight: 800;
    color: #fa873e;
    font-size: 18px;
}
.error-msg {
    color: #dc3545;
    font-size: 11px;
    margin-top: 4px;
    display: none;
}
input:invalid:not(:placeholder-shown) {
    border-color: #dc3545;
}
button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
}
.amenity-visual-card.is-selected {
    border-color: #fa873e !important;
    background: #fff8f3 !important;
    box-shadow: 0 4px 12px rgba(250,135,62,0.15) !important;
}
</style>
</head>
<body>

    <x-navbar :isHome="false" />

<div class="form-container" style="background: #fff; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.05);">
    
    <!-- STAY OPTIONS CARD (PREMIUM) -->
    <div style="background: #fff8f3; border: 1px solid rgba(250,135,62,0.1); border-radius: 24px; padding: 30px; margin-bottom: 40px; position: relative;">
        <div style="display: flex; align-items: center; gap: 10px; color: #d96520; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 25px;">
            <i class="bi bi-info-circle"></i> STAY OPTIONS
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px;">
            <div style="background: #fff; border-radius: 16px; padding: 20px; display: flex; justify-content: space-between; align-items: center; border: 1px solid rgba(0,0,0,0.03);">
                <div style="color: #3b2a22; font-weight: 600;">Weekday <span style="color: #8a7b6e; font-weight: 400; font-size: 0.85rem;">(Up to 5 Guests)</span></div>
                <div style="font-weight: 800; color: #fa873e; font-size: 1.1rem;">₹8,000 <span style="font-size: 0.7rem; color: #8a7b6e; font-weight: 400;">/ night</span></div>
            </div>
            <div style="background: #fff; border-radius: 16px; padding: 20px; display: flex; justify-content: space-between; align-items: center; border: 1px solid rgba(0,0,0,0.03);">
                <div style="color: #3b2a22; font-weight: 600;">Weekday <span style="color: #8a7b6e; font-weight: 400; font-size: 0.85rem;">(Up to 10 Guests)</span></div>
                <div style="font-weight: 800; color: #fa873e; font-size: 1.1rem;">₹11,000 <span style="font-size: 0.7rem; color: #8a7b6e; font-weight: 400;">/ night</span></div>
            </div>
            <div style="background: #fff; border-radius: 16px; padding: 20px; display: flex; justify-content: space-between; align-items: center; border: 1px solid rgba(0,0,0,0.03);">
                <div style="color: #3b2a22; font-weight: 600;">Weekend <span style="color: #8a7b6e; font-weight: 400; font-size: 0.85rem;">(Up to 10 Guests)</span></div>
                <div style="font-weight: 800; color: #fa873e; font-size: 1.1rem;">₹12,000 <span style="font-size: 0.7rem; color: #8a7b6e; font-weight: 400;">/ night</span></div>
            </div>
        </div>

        <!-- Float Green Button -->
        <div style="position: absolute; left: 50%; bottom: -25px; transform: translateX(-50%); z-index: 5;">
            <button type="button" onclick="toggleChatbot()" style="background: #58b368; color: #fff; border: none; padding: 14px 28px; border-radius: 50px; font-weight: 700; font-size: 0.85rem; display: flex; align-items: center; gap: 10px; box-shadow: 0 8px 20px rgba(88,179,104,0.3); text-transform: uppercase; letter-spacing: 1px; width: auto; margin: 0;">
                <i class="bi bi-robot"></i> BOOK VIA CHATBOT
            </button>
        </div>
    </div>

    <h1 style="margin-top: 50px;">Book Your Stay</h1>
    <div class="subtitle">Reserve your perfect lakeside staycation at Parudeesa</div>



    <form id="bookingForm">

        <div class="form-group">
            <label>Select Property</label>
            <select id="property_id" name="property_id" required>
                <option value="">Choose Property</option>
                @foreach($properties ?? [] as $property)
                <option value="{{ $property->id }}">{{ $property->name }} - ₹{{ number_format($property->price, 0) }}/night</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Check-in Date</label>
            <input type="date" id="check_in" name="check_in" required min="{{ date('Y-m-d') }}">
            <div class="error-msg" id="err-check_in">Check-in date is required</div>
        </div>

        <div class="form-group">
            <label>Check-out Date</label>
            <input type="date" id="check_out" name="check_out" required>
            <div class="error-msg" id="err-check_out">Check-out date must be after check-in</div>
        </div>

        <div class="form-group">
            <label>Number of Guests</label>
            <input type="number" id="guests" name="guests" placeholder="Enter guest count" required min="1" max="20">
            <div class="error-msg" id="err-guests">Please enter a valid guest count (1-20)</div>
        </div>

        <div class="form-group">
            <label>Your Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required minlength="3">
            <div class="error-msg" id="err-name">Name is required (min 3 characters)</div>
        </div>

        <div class="form-group">
            <label>Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="e.g. 9876543210" required pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
            <div class="error-msg" id="err-phone">Phone number must contain exactly 10 digits. Only numbers allowed.</div>
        </div>

        <div class="form-group" style="margin-top: 30px; margin-bottom: 30px;">
            <label style="font-size: 1.1rem; margin-bottom: 20px;">Enhance Your Experience</label>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                @foreach($amenities as $amenity)
                @if(!str_contains(strtolower($amenity->name), 'yacht'))
                <div class="amenity-visual-card" data-price="{{ $amenity->price }}" style="background: #fff; border: 1px solid rgba(250,135,62,0.15); border-radius: 16px; overflow: hidden; transition: all 0.3s ease; position: relative; cursor: pointer;" onclick="toggleAmenity(this)">
                    @php
                        $keyword = strtolower($amenity->name);
                        $fallbackImg = 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=300&q=80';
                        if(str_contains($keyword, 'campfire')) $fallbackImg = 'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?w=300&q=80';
                        if(str_contains($keyword, 'speaker')) $fallbackImg = 'https://images.unsplash.com/photo-1545127398-14699f92334b?w=300&q=80';
                        if(str_contains($keyword, 'kayak')) $fallbackImg = 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=300&q=80';
                        if(str_contains($keyword, 'sheesha') || str_contains($keyword, 'shisha')) $fallbackImg = 'https://images.unsplash.com/photo-1516715105260-7a5611666687?w=300&q=80';
                    @endphp
                    <div style="height: 120px; width: 100%; position: relative;">
                        <img src="{{ str_starts_with($amenity->image, 'http') ? $amenity->image : asset($amenity->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" class="amenity-checkbox" style="position: absolute; top: 10px; right: 10px; width: 20px; height: 20px; accent-color: var(--brand); z-index: 2;">
                    </div>
                    <div style="padding: 12px;">
                        <div style="font-weight: 700; font-size: 0.95rem; color: #3b2a22; margin-bottom: 4px;">{{ $amenity->name }}</div>
                        <div style="font-weight: 800; color: #fa873e; font-size: 0.9rem;">₹{{ number_format($amenity->price, 0) }}</div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>

        <div class="coupon-section">
            <label>Available Coupons</label>
            <div style="margin-bottom: 15px;">
                @foreach($activeCoupons as $c)
                <span class="coupon-badge" onclick="document.getElementById('coupon_code').value = '{{ $c->code }}'">
                    {{ $c->code }} - {{ $c->type === 'percentage' ? $c->value.'%' : '₹'.$c->value }} OFF
                </span>
                @endforeach
            </div>
            
            <label>Have a Coupon?</label>
            <div style="display:flex; gap:10px;">
                <input type="text" id="coupon_code" placeholder="Enter code" style="flex:1;">
                <button type="button" id="applyBtn" style="width:auto; padding:10px 20px; margin:0;">Apply</button>
                <button type="button" id="removeCouponBtn" style="width:auto; padding:10px 20px; margin:0; background: #6a3b1c; display:none;">Remove</button>
            </div>
            <div id="couponMsg" style="font-size:12px; margin-top:5px; display:none;"></div>
        </div>

        <div class="price-summary">
            <div class="price-row">
                <span>Base Amount</span>
                <span id="display_base">₹0</span>
            </div>
            <div class="price-row" id="discount_row" style="display:none; color: green;">
                <span>Discount</span>
                <span id="display_discount">-₹0</span>
            </div>
            <div class="price-row final-total">
                <span>Final Payable</span>
                <span id="display_total">₹0</span>
            </div>
        </div>

        <input type="hidden" name="amount" id="amount_val">
        <input type="hidden" name="base_amount" id="base_amount_val">
        <input type="hidden" name="coupon_id" id="coupon_id_val">
        <input type="hidden" name="discount_amount" id="discount_val">

        <button type="submit">Confirm Booking</button>
    </form>

    <div class="success-message" id="successMsg"></div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById("bookingForm").addEventListener("submit", function(e){
    e.preventDefault();

    const formData = new FormData(this);

    fetch('/bookings', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            let msg = `
                <strong>✅ Booking request submitted successfully!</strong><br><br>
                <strong>Name:</strong> ${formData.get('name')}<br>
                <strong>Phone:</strong> ${formData.get('phone')}<br>
                <strong>Property ID:</strong> ${formData.get('property_id')}<br>
                <strong>Check-in:</strong> ${formData.get('check_in')}<br>
                <strong>Check-out:</strong> ${formData.get('check_out')}<br>
                <strong>Guests:</strong> ${formData.get('guests')}<br><br>
                Our team will contact you shortly.
            `;

            let successBox = document.getElementById("successMsg");
            successBox.innerHTML = msg;
            successBox.style.display = "block";

            document.getElementById("bookingForm").reset();
            
            // Scroll to success message
            setTimeout(() => {
                successBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 200);
        } else {
            alert('Error submitting booking. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error submitting booking. Please try again.');
    });
});

const propertySelect = document.getElementById('property_id');
const amountInput = document.getElementById('amount_val');
const displayBase = document.getElementById('display_base');
const displayTotal = document.getElementById('display_total');

function toggleAmenity(card) {
    const checkbox = card.querySelector('.amenity-checkbox');
    checkbox.checked = !checkbox.checked;
    if (checkbox.checked) {
        card.classList.add('is-selected');
    } else {
        card.classList.remove('is-selected');
    }
    updatePrice();
}

// Ensure checkbox clicks also trigger update
document.querySelectorAll('.amenity-checkbox').forEach(chk => {
    chk.onclick = (e) => {
        e.stopPropagation();
        const card = chk.closest('.amenity-visual-card');
        if (chk.checked) card.classList.add('is-selected');
        else card.classList.remove('is-selected');
        updatePrice();
    };
});

function updatePrice() {
    const selected = propertySelect.options[propertySelect.selectedIndex];
    if (!selected.value) return;
    
    const text = selected.text;
    const basePrice = parseInt(text.match(/₹(\d+)/)[1]);
    
    let extraPrice = 0;
    document.querySelectorAll('.amenity-checkbox:checked').forEach(chk => {
        const card = chk.closest('.amenity-visual-card');
        const price = parseFloat(card.dataset.price) || 0;
        extraPrice += price;
    });

    const total = basePrice + extraPrice;
    
    amountInput.value = total;
    document.getElementById('base_amount_val').value = total; // Note: In this simple form, base_amount includes amenities for coupon calculation
    displayBase.innerText = '₹' + total.toLocaleString();
    displayTotal.innerText = '₹' + total.toLocaleString();
    
    resetCoupon();
}

propertySelect.addEventListener('change', updatePrice);

// Date Validation Logic
const checkInInput = document.getElementById('check_in');
const checkOutInput = document.getElementById('check_out');

checkInInput.addEventListener('change', function() {
    checkOutInput.min = this.value;
    if (checkOutInput.value && checkOutInput.value <= this.value) {
        checkOutInput.value = '';
        document.getElementById('err-check_out').style.display = 'block';
    } else {
        document.getElementById('err-check_out').style.display = 'none';
    }
});

checkOutInput.addEventListener('change', function() {
    if (this.value <= checkInInput.value) {
        document.getElementById('err-check_out').style.display = 'block';
    } else {
        document.getElementById('err-check_out').style.display = 'none';
    }
});

// Simple Real-time Validation
document.querySelectorAll('#bookingForm input, #bookingForm select').forEach(input => {
    input.addEventListener('input', function() {
        const err = document.getElementById('err-' + this.id);
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

document.getElementById('applyBtn').addEventListener('click', function() {
    const code = document.getElementById('coupon_code').value;
    const baseTotal = document.getElementById('base_amount_val').value;
    const applyBtn = this;
    
    if (!code || !baseTotal || baseTotal == 0) {
        alert('Please select a property and enter a code.');
        return;
    }
    
    // Disable button and show loading
    applyBtn.disabled = true;
    applyBtn.innerText = 'Applying...';
    
    fetch('/coupons/validate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ code: code, total: baseTotal })
    })
    .then(r => r.json())
    .then(data => {
        const msg = document.getElementById('couponMsg');
        msg.style.display = 'block';
        
        if (data.success) {
            msg.innerText = data.message;
            msg.style.color = 'green';
            
            document.getElementById('coupon_id_val').value = data.coupon_id;
            document.getElementById('discount_val').value = data.discount;
            document.getElementById('amount_val').value = data.new_total;
            
            document.getElementById('discount_row').style.display = 'flex';
            document.getElementById('display_discount').innerText = '-₹' + data.discount.toLocaleString();
            document.getElementById('display_total').innerText = '₹' + data.new_total.toLocaleString();
            
            document.getElementById('removeCouponBtn').style.display = 'block';
            applyBtn.style.display = 'none';
            document.getElementById('coupon_code').readOnly = true;
        } else {
            msg.innerText = data.message;
            msg.style.color = 'red';
            applyBtn.disabled = false;
            applyBtn.innerText = 'Apply';
        }
    })
    .catch(() => {
        applyBtn.disabled = false;
        applyBtn.innerText = 'Apply';
    });
});

document.getElementById('removeCouponBtn').addEventListener('click', function() {
    resetCoupon();
    document.getElementById('coupon_code').value = '';
    document.getElementById('couponMsg').style.display = 'none';
});

function resetCoupon() {
    document.getElementById('coupon_id_val').value = '';
    document.getElementById('discount_val').value = 0;
    document.getElementById('discount_row').style.display = 'none';
    
    const basePrice = parseFloat(document.getElementById('base_amount_val').value);
    if (!isNaN(basePrice)) {
        amountInput.value = basePrice;
        displayTotal.innerText = '₹' + basePrice.toLocaleString();
    }
    
    document.getElementById('applyBtn').style.display = 'block';
    document.getElementById('applyBtn').disabled = false;
    document.getElementById('applyBtn').innerText = 'Apply';
    document.getElementById('removeCouponBtn').style.display = 'none';
    document.getElementById('coupon_code').readOnly = false;
}
</script>

    <x-footer :isHome="false" />
<x-social-nav />
@include('chatbot')
</body>
</html>
