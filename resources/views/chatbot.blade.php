<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Parudeesa Resort Chatbot</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;600&family=Cormorant+Garamond:ital,wght@0,600;1,600&display=swap');

body{
  margin:0;
  padding:20px;
  font-family:'Josefin Sans',sans-serif;
  background:#fff8f2;
}

.cb-wrap{
  display:flex;
  justify-content:center;
}

.cb-preview{
  width:360px;
  background:#fff3ec;
  border-radius:20px;
  overflow:hidden;
  border:1px solid rgba(250,135,62,.18);
}

.cb-head{
  background:linear-gradient(135deg,#d96520,#fa873e);
  padding:14px 16px;
  display:flex;
  align-items:center;
  gap:10px;
}

.cb-av{
  width:40px;
  height:40px;
  background:rgba(255,255,255,.2);
  border-radius:50%;
  display:flex;
  align-items:center;
  justify-content:center;
}

.cb-hname{
  font-size:13px;
  font-weight:600;
  color:#fff;
}

.cb-hstatus{
  font-size:10px;
  color:rgba(255,255,255,.75);
}

.cb-body{
  background:#fde9d8;
  min-height:420px;
  max-height:420px;
  overflow-y:auto;
  padding:14px;
  display:flex;
  flex-direction:column;
  gap:8px;
}

.cb-msg{
  max-width:82%;
  padding:10px 13px;
  font-size:12px;
  line-height:1.5;
  border-radius:14px;
  white-space:pre-line;
}

.cb-bot{
  background:#fff;
  color:#5a3010;
  align-self:flex-start;
}

.cb-user{
  background:linear-gradient(135deg,#fa873e,#d96520);
  color:#fff;
  align-self:flex-end;
}

.cb-qr{
  display:flex;
  flex-direction:column;
  gap:5px;
}

.cb-qr-btn{
  background:rgba(250,135,62,.1);
  border:1px solid rgba(250,135,62,.35);
  color:#d96520;
  border-radius:20px;
  padding:7px 12px;
  font-size:11px;
  cursor:pointer;
  transition:all .3s ease;
}

.cb-qr-btn:hover{
  background:rgba(250,135,62,.2);
  border-color:rgba(250,135,62,.55);
}

.cb-footer{
  padding:10px 12px;
  background:#fff3ec;
  display:flex;
  gap:8px;
}

.cb-input{
  flex:1;
  border:1px solid rgba(250,135,62,.25);
  border-radius:20px;
  padding:8px 14px;
  font-family:'Josefin Sans',sans-serif;
  font-size:12px;
}

.cb-input:focus{
  outline:none;
  border-color:rgba(250,135,62,.55);
}

.cb-send{
  width:34px;
  height:34px;
  background:linear-gradient(135deg,#fa873e,#d96520);
  border:none;
  border-radius:50%;
  color:#fff;
  cursor:pointer;
  transition:transform .3s ease;
}

.cb-send:hover{
  transform:scale(1.05);
}

a.cb-wa-link{
  color:#d96520;
  display:block;
  margin-top:5px;
  font-size:12px;
  text-decoration:none;
  font-weight:600;
}
</style>
</head>

<body>

<div class="cb-wrap">
<div class="cb-preview">

<div class="cb-head">
  <div class="cb-av">🏡</div>
  <div>
    <div class="cb-hname">Parudeesa Resort</div>
    <div class="cb-hstatus">Online · Replies instantly</div>
  </div>
</div>

<div class="cb-body" id="cbMsgs">
  <div class="cb-msg cb-bot">
    👋 Welcome to <strong>Parudeesa – The Lake View Resort</strong>! I'm your virtual host.
  </div>
  <div class="cb-msg cb-bot">
    How can I help you today?
  </div>

  <div class="cb-qr">
    <button class="cb-qr-btn" onclick="cbReply('availability')">📅 Check Availability</button>
    <button class="cb-qr-btn" onclick="cbReply('price')">💰 View Pricing</button>
    <button class="cb-qr-btn" onclick="cbReply('properties')">🏠 Our Properties</button>
    <button class="cb-qr-btn" onclick="cbReply('events')">🎉 Event Packages</button>
    <button class="cb-qr-btn" onclick="cbReply('amenities')">⛵ Amenities</button>
    <button class="cb-qr-btn" onclick="cbReply('book')">✅ Book Now</button>
    <button class="cb-qr-btn" onclick="cbReply('human')">🙋 Talk to Receptionist</button>
  </div>
</div>

<div class="cb-footer">
  <input class="cb-input" id="cbInput" placeholder="Type a message..." onkeydown="if(event.key==='Enter') cbSend()">
  <button class="cb-send" onclick="cbSend()">➤</button>
</div>

</div>
</div>

<script>
var bookingStep = null;
var bookingDetails = {};

var cbData = {
  availability: "We currently have availability in both Lakeside Cottage and Sunset Villa for the upcoming weekends.",
  price: "🏡 Lakeside Cottage starts from ₹6,500 per night.\n🌅 Sunset Villa starts from ₹9,000 per night.",
  properties: "🏡 Lakeside Cottage: perfect for 40–50 guests.\n🌅 Sunset Villa: accommodates up to 200 guests.",
  events: "🎉 We host birthdays, anniversaries, weddings, kayaking events, yacht parties, and custom celebrations.",
  amenities: "⛵ Amenities include kayaking, private yacht, gourmet dining, custom decorations, bonfire, and lake view rooms.",
  book: "Great! Let's complete your booking.\nWhich property would you like to book?",
  human: "Connecting you to our receptionist...\nClick below to chat instantly on WhatsApp."
};

function addMsg(text, user=false){
  const msg = document.createElement("div");
  msg.className = "cb-msg " + (user ? "cb-user" : "cb-bot");
  msg.innerText = text;
  document.getElementById("cbMsgs").appendChild(msg);
  document.getElementById("cbMsgs").scrollTop = document.getElementById("cbMsgs").scrollHeight;
}

function cbReply(type){
  const buttons = document.querySelectorAll('.cb-qr-btn');
  let buttonText = '';
  
  buttons.forEach(btn => {
    if(btn.onclick.toString().includes(`cbReply('${type}')`)) {
      buttonText = btn.innerText;
    }
  });
  
  addMsg(buttonText || type, true);
  addMsg(cbData[type], false);

  if(type === "book"){
    bookingStep = "property";
  }

  if(type === "human"){
    setTimeout(() => {
      const msgContainer = document.getElementById("cbMsgs");
      const linkDiv = document.createElement("div");
      linkDiv.style.alignSelf = "flex-start";
      const link = document.createElement("a");
      link.href = "https://wa.me/918075741948?text=Hi!%20I%20want%20to%20talk%20to%20the%20receptionist";
      link.target = "_blank";
      link.innerText = "👉 Chat with Receptionist on WhatsApp";
      link.className = "cb-wa-link";
      linkDiv.appendChild(link);
      msgContainer.appendChild(linkDiv);
      msgContainer.scrollTop = msgContainer.scrollHeight;
    }, 300);
  }
}

function cbSend(){
  const input = document.getElementById("cbInput");
  const value = input.value.trim();
  if(!value) return;

  addMsg(value, true);
  input.value = "";

  if(bookingStep === "property"){
    bookingDetails.property = value;
    addMsg("What type of event would you like to host?", false);
    bookingStep = "event";
    return;
  }

  if(bookingStep === "event"){
    bookingDetails.event = value;
    addMsg("How many guests are expected?", false);
    bookingStep = "guests";
    return;
  }

  if(bookingStep === "guests"){
    bookingDetails.guests = value;
    addMsg("Please provide your preferred booking date.", false);
    bookingStep = "date";
    return;
  }

  if(bookingStep === "date"){
    bookingDetails.date = value;
    addMsg("May I have your name?", false);
    bookingStep = "name";
    return;
  }

  if(bookingStep === "name"){
    bookingDetails.name = value;
    addMsg("Please enter your phone number.", false);
    bookingStep = "phone";
    return;
  }

  if(bookingStep === "phone"){
    bookingDetails.phone = value;

    addMsg(
      "✅ Booking Request Submitted!\n\n" +
      "Property: " + bookingDetails.property + "\n" +
      "Event: " + bookingDetails.event + "\n" +
      "Guests: " + bookingDetails.guests + "\n" +
      "Date: " + bookingDetails.date + "\n" +
      "Name: " + bookingDetails.name + "\n" +
      "Phone: " + bookingDetails.phone + "\n\n" +
      "Our team will contact you shortly.",
      false
    );

    bookingStep = null;
    bookingDetails = {};
    return;
  }

  addMsg("Please choose one of the available options above.", false);
}
</script>

</body>
</html>
