<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom_test = $_POST['nom_test'];
    $date_test = $_POST['date_test'];
    $resultat_test = floatval($_POST['resultat_test']);
    $user_id = intval($_POST['user_id']); // ID de l'utilisateur lié à ce test

    $stmt = $conn->prepare("INSERT INTO tests (nom_test, date_test, resultat_test, user_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $nom_test, $date_test, $resultat_test, $user_id);
    $stmt->execute();

    header("Location: tests.php");
    exit();
}

$conn->close();
?>

