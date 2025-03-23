<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_admin'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $grade = $_POST['grade'];
    $photo = $_POST['current_photo'];

    // Handle file upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $photo = 'uploads/' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
    }

    $sql = "UPDATE admins SET nom = ?, prenom = ?, grade = ?, photo = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nom, $prenom, $grade, $photo, $id);

    if ($stmt->execute()) {
        echo "L'administrateur a été mis à jour avec succès.";
    } else {
        echo "Erreur lors de la mise à jour de l'administrateur : " . $stmt->error;
    }

    header("Location: admin_dashboard.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT id, nom, prenom, grade, photo FROM admins WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();
    } else {
        echo "Administrateur non trouvé.";
        exit();
    }
} else {
    echo "ID de l'administrateur non spécifié.";
    exit();
}

$conn->close();
?>

