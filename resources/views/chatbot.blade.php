<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Parudeesa Resort Chatbot</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;600&family=Cormorant+Garamond:wght@600&display=swap');

html{
  height:100%;
}

:root{
  --bg:#fff8f2;
  --shell:#fff3ec;
  --surface:#ffffff;
  --surface-soft:#fde9d8;
  --brand:#d96520;
  --brand-strong:#fa873e;
  --text:#5a3010;
  --muted:#8a5a37;
  --line:rgba(250,135,62,.18);
}

*{box-sizing:border-box}
body{
  margin:0;
  min-height:100vh;
  padding:24px;
  font-family:'Josefin Sans',sans-serif;
  background:radial-gradient(circle at top,#fffdf9 0,#fff8f2 45%,#fde9d8 100%);
  color:var(--text);
}

body.cb-embed{
  height:100%;
  min-height:100%;
  padding:0;
  background:var(--surface-soft);
  overflow:hidden;
}

.cb-wrap{
  display:flex;
  justify-content:center;
}

body.cb-embed .cb-wrap{
  display:flex;
  height:100%;
}

.cb-preview{
  width:min(100%,420px);
  height:550px;
  background:var(--shell);
  border-radius:24px;
  overflow:hidden;
  border:1px solid var(--line);
  box-shadow:0 20px 40px rgba(112,56,19,.14);
  display:flex;
  flex-direction:column;
}

body.cb-embed .cb-preview{
  width:100%;
  height:100%;
  min-height:100%;
  border-radius:0;
  border:0;
  box-shadow:none;
  display:flex;
  flex-direction:column;
}

.cb-head{
  background:linear-gradient(135deg,var(--brand),var(--brand-strong));
  padding:16px 18px;
  display:flex;
  align-items:center;
  gap:12px;
  color:#fff;
}

.cb-av{
  width:42px;
  height:42px;
  border-radius:50%;
  display:flex;
  align-items:center;
  justify-content:center;
  background:rgba(255,255,255,.18);
  font-size:20px;
}

.cb-hname{
  font-size:14px;
  font-weight:600;
}

.cb-hstatus{
  font-size:11px;
  opacity:.82;
}

.cb-body{
  background: var(--surface-soft);
  flex: 1;
  overflow-y: auto;
  padding: 16px;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

body.cb-embed .cb-body{
  flex:1;
  min-height:0;
  max-height:none;
  overflow-y:auto;
}

.cb-msg{
  max-width:88%;
  padding:12px 14px;
  font-size:13px;
  line-height:1.55;
  border-radius:16px;
  white-space:pre-line;
}

.cb-bot{
  background:var(--surface);
  color:var(--text);
  align-self:flex-start;
  border-top-left-radius:6px;
}

.cb-user{
  background:linear-gradient(135deg,var(--brand-strong),var(--brand));
  color:#fff;
  align-self:flex-end;
  border-top-right-radius:6px;
}

.cb-stack{
  display:flex;
  flex-direction:column;
  gap:8px;
  max-width:92%;
}

.cb-panel{
  background:var(--surface);
  border:1px solid var(--line);
  border-radius:16px;
  padding:12px;
}

.cb-grid{
  display:grid;
  gap:8px;
}

.cb-action,
.cb-amenity-btn{
  width:100%;
  border:1px solid rgba(250,135,62,.28);
  background:#fffaf6;
  color:var(--brand);
  border-radius:14px;
  padding:10px 12px;
  text-align:left;
  font:inherit;
  cursor:pointer;
  transition:all .2s ease;
}

.cb-action:hover,
.cb-amenity-btn:hover{
  border-color:rgba(250,135,62,.5);
  background:#fff1e7;
}

.cb-amenity-btn.active{
  background:linear-gradient(135deg,var(--brand-strong),var(--brand));
  color:#fff;
  border-color:transparent;
}

.cb-amenity-name{
  font-weight:600;
  display:block;
}

.cb-amenity-meta{
  font-size:11px;
  opacity:.88;
  display:block;
  margin-top:3px;
}

.cb-qty-row{
  display:flex;
  align-items:center;
  gap:8px;
  margin-top:8px;
  flex-wrap:wrap;
}

.cb-qty-label{
  font-size:11px;
  color:var(--muted);
}

.cb-qty-input{
  width:88px;
  border:1px solid rgba(250,135,62,.28);
  border-radius:10px;
  padding:7px 10px;
  font:inherit;
  color:var(--text);
  background:#fff;
}

.cb-qty-input:focus{
  outline:none;
  border-color:rgba(250,135,62,.55);
}

.cb-summary{
  font-size:12px;
  line-height:1.65;
}

.cb-summary strong{
  color:#3f240c;
}

.cb-footer{
  padding:12px;
  background:var(--shell);
  display:flex;
  gap:8px;
  border-top:1px solid var(--line);
}

.cb-input{
  flex:1;
  border:1px solid rgba(250,135,62,.25);
  border-radius:20px;
  padding:10px 14px;
  font-family:'Josefin Sans',sans-serif;
  font-size:13px;
  background:#fff;
}

.cb-input:focus{
  outline:none;
  border-color:rgba(250,135,62,.6);
}

.cb-send{
  width:40px;
  height:40px;
  border:none;
  border-radius:50%;
  background:linear-gradient(135deg,var(--brand-strong),var(--brand));
  color:#fff;
  font-size:16px;
  cursor:pointer;
}

.cb-note{
  font-size:11px;
  color:var(--muted);
  margin-top:6px;
}

.cb-typing{
  align-self:flex-start;
  background:#fff;
  border-radius:16px;
  padding:10px 14px;
  display:flex;
  gap:5px;
}

.cb-typing span{
  width:7px;
  height:7px;
  border-radius:50%;
  background:#d8a37d;
  animation:blink 1s infinite ease-in-out;
}

.cb-typing span:nth-child(2){animation-delay:.15s}
.cb-typing span:nth-child(3){animation-delay:.3s}

@keyframes blink{
  0%,80%,100%{opacity:.3;transform:translateY(0)}
  40%{opacity:1;transform:translateY(-2px)}
}

@media (max-width:520px){
  body{padding:12px}
  .cb-preview{width:100%}
  .cb-body{min-height:calc(100vh - 170px);max-height:calc(100vh - 170px)}
  body.cb-embed{padding:0}
  body.cb-embed .cb-wrap{height:100%}
  body.cb-embed .cb-preview{height:100%;min-height:100%}
  body.cb-embed .cb-body{flex:1;min-height:0;max-height:none}
}
</style>
</head>
<body class="{{ $isEmbed ? 'cb-embed' : '' }}">

<div class="cb-wrap">
  <div class="cb-preview">
    @unless($isEmbed)
    <div class="cb-head">
      <div class="cb-av">P</div>
      <div>
        <div class="cb-hname">Parudeesa Resort</div>
        <div class="cb-hstatus">Live booking assistant</div>
      </div>
    </div>
    @endunless

    <div class="cb-body" id="cbMsgs"></div>

    <div class="cb-footer">
      <input class="cb-input" id="cbInput" placeholder="Type your reply..." onkeydown="if(event.key==='Enter') cbSend()">
      <button class="cb-send" onclick="cbSend()">></button>
    </div>
  </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
const chatbotData = {
  properties: @json($chatbotProperties),
  selectedPropertyId: @json($selectedPropertyId),
};

const state = {
  step: null,
  booking: emptyBooking(),
  pendingAmenityIds: [],
  currentAmenityId: null,
  currentAmenitySelector: null,
  quote: null,
  bookingId: null,
};

function emptyBooking() {
  return {
    property_id: null,
    property_name: '',
    event_type: 'Stay',
    check_in: '',
    check_out: '',
    guests: '',
    amenities: [],
    name: '',
    email: '',
    phone: '',
  };
}

function getProperty(propertyId) {
  return chatbotData.properties.find((property) => property.id === Number(propertyId)) || null;
}

function getAmenity(propertyId, amenityId) {
  const property = getProperty(propertyId);
  return property?.amenities.find((amenity) => amenity.id === Number(amenityId)) || null;
}

function addMsg(text, user = false) {
  const msg = document.createElement('div');
  msg.className = 'cb-msg ' + (user ? 'cb-user' : 'cb-bot');
  msg.textContent = text;
  document.getElementById('cbMsgs').appendChild(msg);
  scrollChat();
}

function addHtmlPanel(html) {
  const wrap = document.createElement('div');
  wrap.className = 'cb-stack';
  wrap.innerHTML = html;
  document.getElementById('cbMsgs').appendChild(wrap);
  scrollChat();
}

function scrollChat() {
  const body = document.getElementById('cbMsgs');
  body.scrollTop = body.scrollHeight;
}

function showTyping() {
  const el = document.createElement('div');
  el.className = 'cb-typing';
  el.id = 'cbTyping';
  el.innerHTML = '<span></span><span></span><span></span>';
  document.getElementById('cbMsgs').appendChild(el);
  scrollChat();
}

function hideTyping() {
  document.getElementById('cbTyping')?.remove();
}

function respond(callback) {
  showTyping();
  setTimeout(() => {
    hideTyping();
    callback();
  }, 450);
}

function renderActions(title, actions, note = '') {
  const panel = document.createElement('div');
  panel.className = 'cb-stack';

  const bubble = document.createElement('div');
  bubble.className = 'cb-msg cb-bot';
  bubble.textContent = title;
  panel.appendChild(bubble);

  const actionPanel = document.createElement('div');
  actionPanel.className = 'cb-panel cb-grid';

  actions.forEach((action) => {
    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'cb-action';
    button.textContent = action.label;
    button.onclick = action.onClick;
    actionPanel.appendChild(button);
  });

  if (note) {
    const noteEl = document.createElement('div');
    noteEl.className = 'cb-note';
    noteEl.textContent = note;
    actionPanel.appendChild(noteEl);
  }

  panel.appendChild(actionPanel);
  document.getElementById('cbMsgs').appendChild(panel);
  scrollChat();
}

function renderMainMenu() {
  renderActions('How can I help today?', [
    { label: 'Book a stay', onClick: startBooking },
    { label: 'View pricing', onClick: showPricing },
    { label: 'See properties', onClick: showProperties },
    { label: 'Talk to a person', onClick: showContact },
  ]);
}

function showPricing() {
  addMsg('View pricing', true);
  respond(() => {
    const text = chatbotData.properties.map((property) =>
      `${property.name}: Rs ${property.price.toFixed(2)} per night`
    ).join('\n');
    addMsg(text);
    renderMainMenu();
  });
}

function showProperties() {
  addMsg('See properties', true);
  respond(() => {
    const text = chatbotData.properties.map((property) =>
      `${property.name}\nLocation: ${property.location || 'Parudeesa Resort'}\nNightly rate: Rs ${property.price.toFixed(2)}`
    ).join('\n\n');
    addMsg(text);
    renderMainMenu();
  });
}

function showContact() {
  addMsg('Talk to a person', true);
  respond(() => {
    addMsg('Call +91 89210 21202 or +91 80757 41948 and our team will help right away.');
    renderMainMenu();
  });
}

function resetBookingConversation() {
  state.step = null;
  state.booking = emptyBooking();
  state.pendingAmenityIds = [];
  state.currentAmenityId = null;
  state.currentAmenitySelector = null;
  state.quote = null;
  state.bookingId = null;
}

function startBooking() {
  resetBookingConversation();
  addMsg('Book a stay', true);
  respond(() => {
    const actions = chatbotData.properties.map((property) => ({
      label: `${property.name} - Rs ${property.price.toFixed(2)}/night`,
      onClick: () => chooseProperty(property.id),
    }));
    renderActions('Choose your property first.', actions);
    state.step = 'property';
  });
}

function chooseProperty(propertyId) {
  const property = getProperty(propertyId);
  if (!property) return;

  state.booking.property_id = property.id;
  state.booking.property_name = property.name;
  addMsg(property.name, true);

  respond(() => {
    renderActions('What kind of booking is this?', [
      { label: 'Stay only', onClick: () => chooseEventType('Stay') },
      { label: 'Birthday', onClick: () => chooseEventType('Birthday') },
      { label: 'Wedding', onClick: () => chooseEventType('Wedding') },
      { label: 'Corporate', onClick: () => chooseEventType('Corporate') },
      { label: 'Custom event', onClick: () => chooseEventType('Custom') },
    ], 'You can also type a custom event name.');
    state.step = 'event_type';
  });
}

function chooseEventType(value) {
  state.booking.event_type = value;
  addMsg(value, true);
  respond(() => {
    addMsg('Please enter your check-in date in YYYY-MM-DD format.');
    state.step = 'check_in';
  });
}

function renderAmenitySelector() {
  const property = getProperty(state.booking.property_id);
  if (!property) return;

  const panel = document.createElement('div');
  panel.className = 'cb-stack';

  const bubble = document.createElement('div');
  bubble.className = 'cb-msg cb-bot';
  bubble.textContent = 'Choose any amenities you want to add. You can select multiple, then tap Continue.';
  panel.appendChild(bubble);

  const amenityPanel = document.createElement('div');
  amenityPanel.className = 'cb-panel cb-grid';

  property.amenities.forEach((amenity) => {
    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'cb-amenity-btn';
    button.dataset.amenityId = amenity.id;
    const guestCount = Math.max(1, Number(state.booking.guests || 1));
    const selectedAmenity = state.booking.amenities.find((item) => item.id === amenity.id);
    const quantityValue = selectedAmenity?.quantity || guestCount;
    const quantityMarkup = amenity.pricing_type === 'per_person'
      ? `<div class="cb-qty-row">
          <span class="cb-qty-label">Persons</span>
          <input class="cb-qty-input" type="number" min="1" max="${guestCount}" value="${quantityValue}" data-qty-for="${amenity.id}">
        </div>`
      : '';

    button.innerHTML = `<span class="cb-amenity-name">${amenity.name}</span><span class="cb-amenity-meta">${formatAmenityLabel(amenity)}</span>${quantityMarkup}`;
    button.onclick = () => toggleAmenitySelection(amenity.id);
    amenityPanel.appendChild(button);
  });

  const continueButton = document.createElement('button');
  continueButton.type = 'button';
  continueButton.className = 'cb-action';
  continueButton.textContent = 'Continue';
  continueButton.onclick = completeAmenitySelection;

  const skipButton = document.createElement('button');
  skipButton.type = 'button';
  skipButton.className = 'cb-action';
  skipButton.textContent = 'Skip amenities';
  skipButton.onclick = skipAmenities;

  amenityPanel.appendChild(continueButton);
  amenityPanel.appendChild(skipButton);

  panel.appendChild(amenityPanel);
  document.getElementById('cbMsgs').appendChild(panel);
  state.currentAmenitySelector = amenityPanel;
  amenityPanel.querySelectorAll('.cb-qty-input').forEach((input) => {
    input.addEventListener('click', (event) => event.stopPropagation());
    input.addEventListener('input', (event) => {
      const amenityId = Number(event.target.dataset.qtyFor);
      syncAmenityQuantity(amenityId, event.target.value);
    });
  });
  refreshAmenityButtons();
  scrollChat();
}

function formatAmenityLabel(amenity) {
  return amenity.pricing_type === 'per_person'
    ? `Rs ${amenity.price.toFixed(2)} per person`
    : `Rs ${amenity.price.toFixed(2)} fixed`;
}

function toggleAmenitySelection(amenityId) {
  const foundIndex = state.booking.amenities.findIndex((amenity) => amenity.id === amenityId);
  const amenity = getAmenity(state.booking.property_id, amenityId);
  const guestCount = Math.max(1, Number(state.booking.guests || 1));
  const qtyInput = state.currentAmenitySelector?.querySelector(`[data-qty-for="${amenityId}"]`);
  const quantity = qtyInput ? clampAmenityQuantity(qtyInput.value, guestCount) : guestCount;

  if (foundIndex >= 0) {
    state.booking.amenities.splice(foundIndex, 1);
  } else {
    state.booking.amenities.push({
      id: amenityId,
      quantity: amenity?.pricing_type === 'per_person' ? quantity : null,
    });
  }
  refreshAmenityButtons();
}

function clampAmenityQuantity(value, guestCount) {
  const parsed = Number.parseInt(value, 10);
  if (!Number.isInteger(parsed) || parsed < 1) return 1;
  return Math.min(parsed, guestCount);
}

function syncAmenityQuantity(amenityId, rawValue) {
  const guestCount = Math.max(1, Number(state.booking.guests || 1));
  const input = state.currentAmenitySelector?.querySelector(`[data-qty-for="${amenityId}"]`);
  const quantity = clampAmenityQuantity(rawValue, guestCount);

  if (input) {
    input.value = quantity;
  }

  const selection = state.booking.amenities.find((item) => item.id === amenityId);
  if (selection) {
    selection.quantity = quantity;
  }
}

function refreshAmenityButtons() {
  if (!state.currentAmenitySelector) return;
  state.currentAmenitySelector.querySelectorAll('.cb-amenity-btn').forEach((button) => {
    const amenityId = Number(button.dataset.amenityId);
    const selected = state.booking.amenities.some((amenity) => amenity.id === amenityId);
    button.classList.toggle('active', selected);
  });
}

function skipAmenities() {
  state.booking.amenities = [];
  addMsg('Skip amenities', true);
  respond(askName);
}

function completeAmenitySelection() {
  const labels = state.booking.amenities.map((selected) => {
    const amenity = getAmenity(state.booking.property_id, selected.id);
    if (!amenity) return null;
    return amenity.pricing_type === 'per_person'
      ? `${amenity.name} (${selected.quantity || 1} persons)`
      : amenity.name;
  }).filter(Boolean);
  addMsg(labels.length ? labels.join(', ') : 'No amenities selected', true);

  respond(() => {
    askName();
  });
}

function askName() {
  addMsg('What is your full name?');
  state.step = 'name';
}

function askEmail() {
  addMsg('Please enter your email address.');
  state.step = 'email';
}

function askPhone() {
  addMsg('Please enter your phone number.');
  state.step = 'phone';
}

async function showSummary() {
  try {
    const quote = await requestJson('/chatbot/quote', buildQuotePayload());
    state.quote = quote.quote;

    const summaryHtml = buildSummaryHtml(quote.quote);
    addHtmlPanel(`
      <div class="cb-msg cb-bot">Here is your booking summary before payment.</div>
      <div class="cb-panel cb-summary">${summaryHtml}</div>
    `);

    renderActions('Do you want to continue to payment?', [
      { label: 'Confirm and pay', onClick: beginCheckout },
      { label: 'Change amenities', onClick: restartAmenities },
      { label: 'Start over', onClick: restartFromMenu },
    ]);

    state.step = 'summary';
  } catch (error) {
    addMsg(error.message || 'I could not prepare the summary. Please review your details and try again.');
    state.step = 'phone';
  }
}

function buildSummaryHtml(quote) {
  const amenityHtml = quote.amenities.length
    ? quote.amenities.map((amenity) => {
        const qty = amenity.pricing_type === 'per_person' ? `${amenity.quantity} x Rs ${amenity.price.toFixed(2)}` : 'Fixed';
        return `<div><strong>${escapeHtml(amenity.name)}</strong>: ${qty} = Rs ${amenity.amount.toFixed(2)}</div>`;
      }).join('')
    : '<div>No extra amenities selected.</div>';

  return `
    <div><strong>Property:</strong> ${escapeHtml(quote.property.name)}</div>
    <div><strong>Check-in:</strong> ${escapeHtml(quote.check_in)}</div>
    <div><strong>Check-out:</strong> ${escapeHtml(quote.check_out)}</div>
    <div><strong>Nights:</strong> ${quote.nights}</div>
    <div><strong>Guests:</strong> ${quote.guests}</div>
    <div><strong>Event:</strong> ${escapeHtml(state.booking.event_type || 'Stay')}</div>
    <div style="margin-top:8px"><strong>Amenities</strong></div>
    ${amenityHtml}
    <div style="margin-top:8px"><strong>Room total:</strong> Rs ${quote.base_amount.toFixed(2)}</div>
    <div><strong>Amenity total:</strong> Rs ${quote.amenity_total.toFixed(2)}</div>
    <div><strong>Final payable amount:</strong> Rs ${quote.amount.toFixed(2)}</div>
  `;
}

function buildQuotePayload() {
  return {
    property_id: state.booking.property_id,
    check_in: state.booking.check_in,
    check_out: state.booking.check_out,
    guests: Number(state.booking.guests),
    event_type: state.booking.event_type,
    amenities: state.booking.amenities.map((amenity) => ({
      id: amenity.id,
      quantity: amenity.quantity || 1,
    })),
  };
}

function buildCheckoutPayload() {
  return {
    ...buildQuotePayload(),
    name: state.booking.name,
    email: state.booking.email,
    phone: state.booking.phone,
  };
}

async function beginCheckout() {
  addMsg('Confirm and pay', true);

  try {
    const response = await requestJson('/chatbot/checkout', buildCheckoutPayload());
    state.bookingId = response.booking_id;
    state.quote = response.quote;
    openRazorpay(response);
  } catch (error) {
    addMsg(error.message || 'Checkout could not be started right now.');
  }
}

function openRazorpay(response) {
  if (!response.razorpay_key) {
    addMsg('Razorpay is not configured yet. Please add the Razorpay key and secret in the application settings.');
    return;
  }

  console.log('Opening Razorpay with response:', response);

  const options = {
    key: response.razorpay_key,
    order_id: response.order.id,
    amount: response.order.amount,
    currency: response.order.currency,
    name: 'Parudeesa Resort',
    description: `Booking for ${response.booking.property_name}`,
    prefill: {
      name: response.booking.name,
      email: response.booking.email,
      contact: response.booking.phone,
    },
    theme: {
      color: '#d96520',
    },
    handler: async function (paymentResponse) {
      console.log('Payment success:', paymentResponse);
      try {
        await requestJson('/chatbot/payment/verify', {
          booking_id: state.bookingId,
          razorpay_order_id: paymentResponse.razorpay_order_id,
          razorpay_payment_id: paymentResponse.razorpay_payment_id,
          razorpay_signature: paymentResponse.razorpay_signature,
        });

        addMsg(`Payment successful. Your booking is now confirmed for ${state.booking.property_name}.`);
        addMsg(`Total paid: Rs ${state.quote.amount.toFixed(2)}`);
        renderActions('Anything else I can help with?', [
          { label: 'Book another stay', onClick: startBooking },
          { label: 'Main menu', onClick: restartFromMenu },
        ]);
        state.step = null;
      } catch (error) {
        console.error('Payment verification error:', error);
        addMsg(error.message || 'The payment succeeded, but I could not verify it automatically. Please contact support.');
      }
    },
    modal: {
      ondismiss: async function () {
        console.log('Payment modal dismissed');
        if (state.bookingId) {
          await requestJson('/chatbot/payment/failure', {
            booking_id: state.bookingId,
            reason: 'Customer closed Razorpay before completing payment.',
          }).catch(() => null);
        }
        addMsg('Payment was not completed. Your booking is still unconfirmed.');
        renderActions('Would you like to try again?', [
          { label: 'Retry payment', onClick: beginCheckout },
          { label: 'Start over', onClick: restartFromMenu },
        ]);
      },
    },
  };

  console.log('Razorpay options:', options);

  const checkout = new Razorpay(options);
  checkout.on('payment.failed', async function (response) {
    console.log('Payment failed:', response);
    if (state.bookingId) {
      await requestJson('/chatbot/payment/failure', {
        booking_id: state.bookingId,
        reason: 'Razorpay reported a payment failure.',
      }).catch(() => null);
    }
    addMsg('Payment failed. You can retry when you are ready.');
  });

  try {
    checkout.open();
    console.log('Razorpay modal opened successfully');
  } catch (error) {
    console.error('Error opening Razorpay modal:', error);
    addMsg('Error opening payment gateway. Please try again.');
  }
}

function restartAmenities() {
  addMsg('Change amenities', true);
  respond(() => {
    state.quote = null;
    state.pendingAmenityIds = [];
    state.currentAmenityId = null;
    renderAmenitySelector();
    state.step = 'amenities';
  });
}

function restartFromMenu() {
  addMsg('Start over', true);
  respond(() => {
    resetBookingConversation();
    renderMainMenu();
  });
}

function parseDateInput(value) {
  return /^\d{4}-\d{2}-\d{2}$/.test(value);
}

function parseGuestCount(value) {
  const guestCount = Number.parseInt(value, 10);
  return Number.isInteger(guestCount) && guestCount > 0 ? guestCount : null;
}

function parseEmail(value) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
}

function parsePhone(value) {
  return /^[0-9+\-\s]{7,20}$/.test(value);
}

function cbSend() {
  const input = document.getElementById('cbInput');
  const value = input.value.trim();
  if (!value) return;

  addMsg(value, true);
  input.value = '';

  if (state.step === 'property') {
    const property = chatbotData.properties.find((item) => item.name.toLowerCase() === value.toLowerCase());
    if (property) {
      chooseProperty(property.id);
    } else {
      addMsg('Please choose one of the listed properties so I can continue.');
    }
    return;
  }

  if (state.step === 'event_type') {
    state.booking.event_type = value;
    respond(() => {
      addMsg('Please enter your check-in date in YYYY-MM-DD format.');
      state.step = 'check_in';
    });
    return;
  }

  if (state.step === 'check_in') {
    if (!parseDateInput(value)) {
      addMsg('Please enter the check-in date in YYYY-MM-DD format.');
      return;
    }
    state.booking.check_in = value;
    respond(() => {
      addMsg('Please enter your check-out date in YYYY-MM-DD format.');
      state.step = 'check_out';
    });
    return;
  }

  if (state.step === 'check_out') {
    if (!parseDateInput(value)) {
      addMsg('Please enter the check-out date in YYYY-MM-DD format.');
      return;
    }
    state.booking.check_out = value;
    respond(() => {
      addMsg('How many guests will stay?');
      state.step = 'guests';
    });
    return;
  }

  if (state.step === 'guests') {
    const guests = parseGuestCount(value);
    if (!guests) {
      addMsg('Please enter a valid guest count.');
      return;
    }
    state.booking.guests = guests;
    respond(() => {
      renderAmenitySelector();
      state.step = 'amenities';
    });
    return;
  }

  if (state.step === 'name') {
    state.booking.name = value;
    respond(askEmail);
    return;
  }

  if (state.step === 'email') {
    if (!parseEmail(value)) {
      addMsg('Please enter a valid email address.');
      return;
    }
    state.booking.email = value;
    respond(askPhone);
    return;
  }

  if (state.step === 'phone') {
    if (!parsePhone(value)) {
      addMsg('Please enter a valid phone number.');
      return;
    }
    state.booking.phone = value;
    respond(showSummary);
    return;
  }

  addMsg('Use the options above to begin a booking or ask a direct question.');
}

async function requestJson(url, payload) {
  const response = await fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
    },
    body: JSON.stringify(payload),
  });

  const data = await response.json().catch(() => ({}));

  if (!response.ok || data.success === false) {
    const errorText = firstErrorMessage(data) || 'Something went wrong. Please try again.';
    throw new Error(errorText);
  }

  return data;
}

function firstErrorMessage(data) {
  if (typeof data.message === 'string' && data.message.length) {
    return data.message;
  }

  if (data.errors && typeof data.errors === 'object') {
    const firstKey = Object.keys(data.errors)[0];
    if (firstKey && Array.isArray(data.errors[firstKey]) && data.errors[firstKey][0]) {
      return data.errors[firstKey][0];
    }
  }

  return null;
}

function escapeHtml(value) {
  return String(value ?? '')
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#039;');
}

document.addEventListener('DOMContentLoaded', () => {
  addMsg('Welcome to Parudeesa. I can take you from dates to amenities to payment without leaving this chat.');
  renderMainMenu();

  if (chatbotData.selectedPropertyId) {
    respond(() => {
      startBooking();
      const property = getProperty(chatbotData.selectedPropertyId);
      if (property) {
        setTimeout(() => chooseProperty(property.id), 200);
      }
    });
  }
});
</script>
</body>
</html>
