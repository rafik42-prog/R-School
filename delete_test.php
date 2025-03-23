<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_test = intval($_POST['id_test']);

    $stmt = $conn->prepare("DELETE FROM tests WHERE id_test = ?");
    $stmt->bind_param("i", $id_test);
    $stmt->execute();

    header("Location: tests.php");
    exit();
}

$conn->close();
?>
