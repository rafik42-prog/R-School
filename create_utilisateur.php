<?php
session_start();
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "benrabah";
// Créer la connexion
$conn = new mysqli($servername, $db_username, $db_password, $dbname);
// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Fonction pour créer un utilisateur
function create_user($conn, $username, $password) {
    // Préparer la déclaration
    $stmt = $conn->prepare("INSERT INTO utilisateur (username, password ) VALUES (?, ?)");
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param("ss", $username, $hashed_password,);
    // Exécuter la déclaration
    if ($stmt->execute()) {
        echo "New user created successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    // Fermer la déclaration
    $stmt->close();
}
// Créer un nouvel utilisateur (exemple)
create_user($conn, 'Rafik', 'Rafik');


$conn->close();
?>

