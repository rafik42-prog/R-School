<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include_once 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the administrator's photo file
    $sql = "SELECT photo FROM admins WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        if (!empty($admin['photo'])) {
            unlink($admin['photo']);
        }
    }

    $sql = "DELETE FROM admins WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "L'administrateur a été supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression de l'administrateur : " . $stmt->error;
    }
}

$conn->close();

header("Location: admin_dashboard.php");
exit();
?>
