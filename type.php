<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id_type = intval($_POST['id_type']);
    $stmt = $conn->prepare("DELETE FROM types WHERE id_type = ?");
    $stmt->bind_param("i", $id_type);
    $stmt->execute();
    header("Location: type.php");
    exit();
}

$sql = "SELECT * FROM types";
$result = $conn->query($sql);

if (!$result) {
    die("Erreur dans la requête: " . $conn->error);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Types - R SCHOOL</title>
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
    <h1>Types</h1>
    <div class="table admin">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id_type']; ?></td>
                    <td><?php echo htmlspecialchars($row['nom_type']); ?></td>
                    <td>
                        <span class="action_btn">
                            <a href="edit_type.php?id=<?php echo $row['id_type']; ?>">Modifier</a>
                            <form method="POST" action="type.php" style="display:inline;">
                                <input type="hidden" name="id_type" value="<?php echo $row['id_type']; ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce type ?');">Supprimer</button>
                            </form>
                        </span>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
