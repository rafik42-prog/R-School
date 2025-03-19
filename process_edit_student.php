<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

$id = $_POST['id'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$date_naissance = $_POST['date_naissance'];
$adresse = $_POST['adresse'];

$sql = "UPDATE apprenants SET nom = ?, prenom = ?, email = ?, date_naissance = ?, adresse = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $nom, $prenom, $email, $date_naissance, $adresse, $id);

if ($stmt->execute()) {
    header("Location: apprenant.php");
    exit();
} else {
    die("Erreur: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
