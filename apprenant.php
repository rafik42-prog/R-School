<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

$sql = "SELECT * FROM apprenants";
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
    <title>Apprenants - R SCHOOL</title>
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
        <li><a href="logout.php" class="logout"><i class='bx bx-log-out'></i><span class="nav-item">Logout</span></a></li>
    </ul>
</nav>
<div class="main--content">
    <h1>Liste des Apprenants</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>prenom</th>
                <th>Email</th>
                <th>Date_naissance</th>
                <th>Adresse</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nom']; ?></td>
                    <td><?php echo $row['prenom']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['date_naissance']; ?></td>
                    <td><?php echo $row['adresse']; ?></td>
                    
                    <td>
                        <a href="edit_student.php?id=<?php echo $row['id']; ?>">Modifier</a>
                        <a href="delete_student.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this student?');">Supprimer</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <button class="add-student-button" onclick="window.location.href='add_student.php'">Ajouter un apprenant</button>
</div>
</body>
</html>
