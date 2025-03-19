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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Modifier Test - R SCHOOL</title>
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
        <li><a href="type.php"><i class='bx bxl-typescript'></i><span class="nav-item">Types</span></a></li>
        <li><a href="tests.php"><i class='bx bx-check-circle'></i><span class="nav-item">Tests de Niveaux</span></a></li>
        <li><a href="logout.php"><i class='bx bx-log-out'></i><span class="nav-item">Logout</span></a></li>
    </ul>
</nav>
<div class="main--content">
    <h1>Modifier Test</h1>
    <form method="POST" action="edit_test.php">
        <input type="hidden" name="id_test" value="<?php echo $test['id_test']; ?>">
        <label for="nom_test">Nom du Test:</label>
        <input type="text" id="nom_test" name="nom_test" value="<?php echo htmlspecialchars($test['nom_test']); ?>" required>
        <label for="date_test">Date du Test:</label>
        <input type="date" id="date_test" name="date_test" value="<?php echo htmlspecialchars($test['date_test']); ?>" required>
        <label for="resultat_test">Résultat du Test:</label>
        <input type="number" step="0.01" id="resultat_test" name="resultat_test" value="<?php echo htmlspecialchars($test['resultat_test']); ?>" required>
        <label for="user_id">ID de l'Utilisateur:</label>
        <input type="number" id="user_id" name="user_id" value="<?php echo htmlspecialchars($test['user_id']); ?>" required>
        <button type="submit">Enregistrer</button>
    </form>
</div>
</body>
</html>
