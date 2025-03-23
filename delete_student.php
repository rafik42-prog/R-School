<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM apprenants WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: apprenant.php");
        exit();
    } else {
        die("Erreur: " . $stmt->error);
    }

    $stmt->close();
} else {
    die("ID d'apprenant non fourni.");
}

$conn->close();
?>
