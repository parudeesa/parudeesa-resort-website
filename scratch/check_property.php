<?php
$conn = new mysqli("127.0.0.1", "root", "", "parudeesa");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$result = $conn->query("SELECT name FROM properties WHERE name = 'Parudeesa The Paradise'");
if ($result->num_rows > 0) {
    echo "Property exists";
} else {
    echo "Property NOT found";
}
$conn->close();
?>
