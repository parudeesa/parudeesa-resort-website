<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Parudeesa Booking Form</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;600&family=Cormorant+Garamond:ital,wght@0,600;1,600&display=swap');

body{
    margin:0;
    padding:0;
    font-family:'Josefin Sans',sans-serif;
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
    font-family:'Cormorant Garamond',serif;
    font-size:36px;
    color:#8a4b1f;
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
    font-family:'Josefin Sans',sans-serif;
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
</style>
</head>
<body>

<div class="form-container">
    <h1>Book Your Stay</h1>
    <div class="subtitle">Reserve your perfect lakeside staycation at Parudeesa</div>

    <form id="bookingForm">

        <div class="form-group">
            <label>Select Property</label>
            <select id="property" required>
                <option value="">Choose Property</option>
                <option>Lakeside Cottage (40–50 guests)</option>
                <option>Sunset Villa (Up to 200 guests)</option>
            </select>
        </div>

        <div class="form-group">
            <label>Event Type (Optional)</label>
            <select id="event">
                <option value="">No Event</option>
                <option>Birthday</option>
                <option>Wedding</option>
                <option>Anniversary</option>
                <option>Corporate Gathering</option>
            </select>
        </div>

        <div class="form-group">
            <label>Number of Guests</label>
            <input type="number" id="guests" placeholder="Enter guest count" required>
        </div>

        <div class="form-group">
            <label>Preferred Booking Date</label>
            <input type="date" id="date" required>
        </div>

        <div class="form-group">
            <label>Your Name</label>
            <input type="text" id="name" placeholder="Enter your name" required>
        </div>

        <div class="form-group">
            <label>Phone Number</label>
            <input type="tel" id="phone" placeholder="Enter phone number" required>
        </div>

        <div class="form-group">
            <label>Select Amenities</label>
            <div class="checkbox-group">
                <label><input type="checkbox" name="amenities" value="Kayaking"> Kayaking</label>
                <label><input type="checkbox" name="amenities" value="Private Yacht"> Private Yacht</label>
                <label><input type="checkbox" name="amenities" value="Food Package"> Food Package</label>
                <label><input type="checkbox" name="amenities" value="Custom Decorations"> Decorations</label>
                <label><input type="checkbox" name="amenities" value="Photography"> Photography</label>
                <label><input type="checkbox" name="amenities" value="DJ Setup"> DJ Setup</label>
            </div>
        </div>

        <div class="form-group">
            <label>Special Requests</label>
            <textarea id="request" placeholder="Any additional requests..."></textarea>
        </div>

        <button type="submit">Confirm Booking</button>
    </form>

    <div class="success-message" id="successMsg"></div>
</div>

<script>
document.getElementById("bookingForm").addEventListener("submit", function(e){
    e.preventDefault();

    let property = document.getElementById("property").value;
    let event = document.getElementById("event").value || "No Event";
    let guests = document.getElementById("guests").value;
    let date = document.getElementById("date").value;
    let name = document.getElementById("name").value;
    let phone = document.getElementById("phone").value;

    let selectedAmenities = Array.from(document.querySelectorAll('input[name="amenities"]:checked'))
        .map(cb => cb.value)
        .join(", ") || "None";

    let msg = `
        <strong>✅ Booking request submitted successfully!</strong><br><br>
        <strong>Name:</strong> ${name}<br>
        <strong>Phone:</strong> ${phone}<br>
        <strong>Property:</strong> ${property}<br>
        <strong>Event:</strong> ${event}<br>
        <strong>Guests:</strong> ${guests}<br>
        <strong>Date:</strong> ${date}<br>
        <strong>Amenities:</strong> ${selectedAmenities}<br><br>
        Our team will contact you shortly. You can also chat with us on WhatsApp for faster response.
    `;

    let successBox = document.getElementById("successMsg");
    successBox.innerHTML = msg;
    successBox.style.display = "block";

    document.getElementById("bookingForm").reset();
    
    // Scroll to success message
    setTimeout(() => {
        successBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }, 200);
});
</script>

</body>
</html>
