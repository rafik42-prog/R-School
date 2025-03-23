<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: login.php");
    exit();
}

// Inclure le fichier de connexion à la base de données
include 'db_connection.php';

// Récupérer la liste des apprenants depuis la base de données
$sql = "SELECT * FROM apprenants";
$result = $conn->query($sql);

// Vérifier s'il y a des résultats
if ($result->num_rows > 0) {
    $apprenants = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $apprenants = [];
}

// Fermer la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste Apprenant</title>
    <link rel="stylesheet" href="profil.css">
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
            <li><a href="teacher_dashboard.php">
                <i class='bx bxs-user'></i>
                <span class="nav-item">&nbsp;Profil</span>
            </a></li>
            <li><a href="cour.php">
                <i class='bx bxs-book-open'></i>
                <span class="nav-item">&nbsp;Cours en ligne</span>
            </a></li>
            <li><a href="liste_apprenant.php">
                <i class='bx bxs-graduation'></i>
                <span class="nav-item">&nbsp;Liste apprenant</span>
            </a></li>
            <li><a href="emt eng.html">
                <i class='bx bxs-calendar'></i>
                <span class="nav-item">&nbsp;Emploit</span>
            </a></li>
            <li><a href="logout.php" class="logout">
                <i class='bx bx-log-out'></i>
                <span class="nav-item">Logout</span>
            </a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Liste des Apprenants</h1>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Date de Naissance</th>
                    <th>Adresse</th>
                </tr>
                <td>messani</td>
                <td>bouchra</td>
                <td>bouchra@gmail.com</td>
                <td>09/02/2003</td>
                <td>Elbayadh</td>

                
            </thead>
            <tbody>
                <?php foreach ($apprenants as $apprenant): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($apprenant['nom']); ?></td>
                        <td><?php echo htmlspecialchars($apprenant['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($apprenant['email']); ?></td>
                        <td><?php echo htmlspecialchars($apprenant['date_naissance']); ?></td>
                        <td><?php echo htmlspecialchars($apprenant['adresse']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (empty($apprenants)): ?>
         
        <?php endif; ?>
    </div>
</body>
</html>
