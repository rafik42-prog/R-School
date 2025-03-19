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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Ajouter un Test - R SCHOOL</title>
    <link rel="stylesheet" href="adm.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<nav>
    <ul>
        <li>
            <a href="#" class="logo">
                <img src="photo_6032782189076268073_y.jpg" alt="">
                <span class="nav-item">R SCHOOL</span>
            </a>
        </li>
        <li><a href="admin_dashboard.php"><i class='bx bxs-school'></i><span class="nav-item">Administration</span></a></li>
        <li><a href="enseignant.php"><i class='bx bxs-user-plus'></i><span class="nav-item">Enseignant</span></a></li>
        <li><a href="apprenant.php"><i class='bx bxs-graduation'></i><span class="nav-item">Apprenant</span></a></li>
        <li><a href="tests.php"><i class='bx bx-check-circle'></i><span class="nav-item">Tests de Niveaux</span></a></li>
        <li><a href="logout.php"><i class='bx bx-log-out'></i><span class="nav-item">Logout</span></a></li>
    </ul>
</nav>
<div class="main--content">
    <h1>Ajouter un Test</h1>
    <form method="POST" action="add_test.php">
        <label for="nom_test">Nom du Test:</label>
        <input type="text" id="nom_test" name="nom_test" required>
        <label for="date_test">Date du Test:</label>
        <input type="date" id="date_test" name="date_test" required>
        <label for="resultat_test">Résultat du Test:</label>
        <input type="number" step="0.01" id="resultat_test" name="resultat_test" required>
        <label for="user_id">ID de l'Utilisateur:</label>
        <input type="number" id="user_id" name="user_id" required>
        <button type="submit">Enregistrer</button>
    </form>
</div>
</body>
</html>
