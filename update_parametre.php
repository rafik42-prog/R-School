<?php
session_start();
include 'db_connection.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Sécurité pour le mot de passe

// Mettre à jour les informations de l'utilisateur
$sql = "UPDATE users SET email='$email', password='$password' WHERE id='$user_id'";

if ($conn->query($sql) === TRUE) {
    echo "Paramètres mis à jour avec succès.";
} else {
    echo "Erreur lors de la mise à jour des paramètres: " . $conn->error;
}

$conn->close();
header("Location: parametre.php");
?>
