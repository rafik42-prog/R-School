<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM enseignants WHERE id_ens = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $enseignant = $result->fetch_assoc();

    if (!$enseignant) {
        die("Enseignant non trouvé.");
    }
} else {
    die("ID de l'enseignant non fourni.");
}
?>

