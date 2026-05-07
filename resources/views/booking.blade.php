<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Parudeesa Booking Form</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    padding:0;
    font-family:'Poppins',sans-serif;
    background:linear-gradient(135deg,#fff8f2,#fde9d8);
}

.form-container{
    width:90%;
    max-width:700px;
    margin:40px auto;
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
    font-family:'Poppins',sans-serif;
    background:#fff;
    box-sizing:border-box;
    outline:none;
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
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    margin-top:10px;
    transition:opacity .3s ease,transform .3s ease;
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
</style>
</head>
<body>

<div class="form-container">
    <h1>Book Your Stay</h1>
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

function updatePrice() {
    const selected = propertySelect.options[propertySelect.selectedIndex];
    if (!selected.value) return;
    
    // Extract price from text (hacky but works for this demo) or better, use data attribute
    const text = selected.text;
    const price = parseInt(text.match(/₹(\d+)/)[1]);
    
    amountInput.value = price;
    document.getElementById('base_amount_val').value = price;
    displayBase.innerText = '₹' + price.toLocaleString();
    displayTotal.innerText = '₹' + price.toLocaleString();
    
    // Reset coupon if property changes
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

</body>
</html>
