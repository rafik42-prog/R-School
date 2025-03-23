<?php
session_start();
include 'db_connection.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupérer les informations de l'utilisateur depuis la base de données
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);

// Vérifier les erreurs de requête
if (!$result) {
    die("Erreur dans la requête: " . $conn->error);
}

$user = $result->fetch_assoc();

if (!$user) {
    die("Utilisateur non trouvé.");
}

$conn->close();
?>


