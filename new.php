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
    // Vérifier d'abord si l'utilisateur existe déjà
    $check_stmt = $conn->prepare("SELECT username FROM utilisateur WHERE username = ?");
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "Erreur: Le nom d'utilisateur existe déjà.";
    } else {
        // L'utilisateur n'existe pas encore, procéder à l'insertion
        $insert_stmt = $conn->prepare("INSERT INTO utilisateur (username, password) VALUES (?, ?)");
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_stmt->bind_param("ss", $username, $hashed_password);

        if ($insert_stmt->execute()) {
            echo "Nouvel utilisateur créé avec succès.";
        } else {
            echo "Erreur: " . $insert_stmt->error;
        }

        $insert_stmt->close();
    }

    $check_stmt->close();
}

// Créer un nouvel utilisateur (exemple)
create_user($conn, 'insaf', 'insaf123');
create_user($conn,'meessani','mess2003');

$conn->close();
?>
