<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

$sql = "SELECT * FROM tests";
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
    <title>Tests de Niveaux - R SCHOOL</title>
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
        <li><a href="niveaux.php" >
        <i class='bx bx-trending-up'></i>
        <span class="nav-item">Niveaux</span>
    </a></li>
        <li><a href="tests.php"><i class='bx bx-check-circle'></i><span class="nav-item">Tests de Niveaux</span></a></li>
        <li><a href="logout.php"><i class='bx bx-log-out'></i><span class="nav-item">Logout</span></a></li>
    </ul>
</nav>
<div class="main--content">
    <h1>Tests de Niveaux</h1>
    <div class="table admin">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Date</th>
                    <th>Résultat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id_test']; ?></td>
                    <td><?php echo htmlspecialchars($row['nom_test']); ?></td>
                    <td><?php echo htmlspecialchars($row['date_test']); ?></td>
                    <td><?php echo htmlspecialchars($row['resultat_test']); ?></td>
                    <td>
                        <span class="action_btn">
                            <a href="edit_test.php?id=<?php echo $row['id_test']; ?>">Modifier</a>
                            <form method="POST" action="delete_test.php" style="display:inline;">
                                <input type="hidden" name="id_test" value="<?php echo $row['id_test']; ?>">
                                <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce test ?');">Supprimer</button>
                            </form>
                        </span>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <a href="add_test.php" class="btn">Ajouter un Test</a>
</div>
</body>
</html>
