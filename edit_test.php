<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_test = intval($_POST['id_test']);
    $nom_test = $_POST['nom_test'];
    $date_test = $_POST['date_test'];
    $resultat_test = floatval($_POST['resultat_test']);
    $user_id = intval($_POST['user_id']); // ID de l'utilisateur lié à ce test

    $stmt = $conn->prepare("UPDATE tests SET nom_test = ?, date_test = ?, resultat_test = ?, user_id = ? WHERE id_test = ?");
    $stmt->bind_param("ssdii", $nom_test, $date_test, $resultat_test, $user_id, $id_test);
    $stmt->execute();

    header("Location: tests.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de test non spécifié ou invalide.");
}

$id_test = intval($_GET['id']);
$sql = "SELECT * FROM tests WHERE id_test = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_test);
$stmt->execute();
$result = $stmt->get_result();
$test = $result->fetch_assoc();

if (!$test) {
    die("Test non trouvé.");
}

$conn->close();
?>
