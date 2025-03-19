<?php
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

// Process registration form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password, $email);

    if ($stmt->execute()) {
        echo "Inscription réussie.";
        // Rediriger vers la page de connexion ou afficher un message
    } else {
        echo "Erreur lors de l'inscription: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
