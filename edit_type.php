<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_type = intval($_POST['id_type']);
    $nom_type = $_POST['nom_type'];

    $stmt = $conn->prepare("UPDATE types SET nom_type = ? WHERE id_type = ?");
    $stmt->bind_param("si", $nom_type, $id_type);
    $stmt->execute();

    header("Location: type.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de type non spécifié ou invalide.");
}

$id_type = intval($_GET['id']);
$sql = "SELECT * FROM types WHERE id_type = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_type);
$stmt->execute();
$result = $stmt->get_result();
$type = $result->fetch_assoc();

if (!$type) {
    die("Type non trouvé.");
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Modifier Type - R SCHOOL</title>
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
        <li><a href="logout.php"><i class='bx bx-log-out'></i><span class="nav-item">Logout</span></a></li>
    </ul>
</nav>
<div class="main--content">
    <h1>Modifier Type</h1>
    <form method="POST" action="edit_type.php">
        <input type="hidden" name="id_type" value="<?php echo $type['id_type']; ?>">
        <label for="nom_type">Nom:</label>
        <input type="text" id="nom_type" name="nom_type" value="<?php echo htmlspecialchars($type['nom_type']); ?>">
        <button type="submit">Enregistrer</button>
    </form>
</div>
</body>
</html>
