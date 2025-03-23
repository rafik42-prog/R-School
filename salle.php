<?php
session_start();
include 'db_connection.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

// Récupérer les salles depuis la base de données
$sql = "SELECT * FROM salles";
$result = $conn->query($sql);

// Vérifier les erreurs de requête
if (!$result) {
    die("Erreur dans la requête: " . $conn->error);
}

$conn->close();
?>



                   
