<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "benrabah";

// Créer connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fonction pour créer un utilisateur
function create_user($username, $password) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);
    $stmt->execute();
    $stmt->close();
}

create_user('admin', 'password123');
create_user('user1', 'mypassword');
create_user('rafik', 'rafik');




$conn->close();
?>

