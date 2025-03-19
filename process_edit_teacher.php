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
$date_naiss = $_POST['date_naiss'];
$email = $_POST['email'];
$adresse = $_POST['adresse'];
$grade = $_POST['grade'];

$sql = "UPDATE enseignants SET nom = ?, prenom = ?, date_nais = ?, email = ?, adresse = ?, grade = ? WHERE id_ens = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssi", $nom, $prenom, $date_naiss, $email, $adresse, $grade, $id);

if ($stmt->execute()) {
    header("Location: enseignant.php");
    exit();
} else {
    die("Erreur: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
