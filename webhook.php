<?php
header("Content-Type: text/xml");

$msg = strtolower(trim($_POST['Body'] ?? ''));

$reply = "Welcome to Parudeesa Resort 🌅";

if (strpos($msg, "hi") !== false) {
    $reply = "Hi! Welcome to Parudeesa Resort 🌅\nChoose:\n1. Availability\n2. Pricing\n3. Booking\n4. Talk to Human";
}
elseif (strpos($msg, "1") !== false || strpos($msg, "availability") !== false) {
    $reply = "Rooms are available this weekend in both Lakeside Cottage and Sunset Villa.";
}
elseif (strpos($msg, "2") !== false || strpos($msg, "pricing") !== false) {
    $reply = "Pricing:\n🏡 Lakeside Cottage - ₹6500/night\n🌅 Sunset Villa - ₹9000/night";
}
elseif (strpos($msg, "3") !== false || strpos($msg, "booking") !== false) {
    $reply = "Please share your Name, Booking Date, and Number of Guests.";
}
elseif (strpos($msg, "4") !== false || strpos($msg, "human") !== false) {
    $reply = "Please contact our receptionist here:\nhttps://wa.me/8075741948";
}
else {
    $reply = "Sorry, please reply with:\n1. Availability\n2. Pricing\n3. Booking\n4. Talk to Human";
}

echo "<Response><Message>$reply</Message></Response>";
?>