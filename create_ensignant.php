<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "benrabah";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
function create_user($conn, $username, $password) {
    $stmt = $conn->prepare("INSERT INTO ensignant (username, password) VALUES (?, ?)");
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param("ss", $username, $hashed_password);

}
// Create a new user (example)
create_user($conn, 'maroua', 'maroua');

// Close connection
$conn->close();

?>
