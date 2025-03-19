<?php
session_start();
include 'db_connection.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

// Récupérer les salles depuis la base de données
$sql = "SELECT * FROM salles";
$result = $conn->query($sql);

// Vérifier les erreurs de requête
if (!$result) {
    die("Erreur dans la requête: " . $conn->error);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salles - R SCHOOL</title>
    <link rel="stylesheet" href="admin.css">
     
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <nav>
        <ul>
            <li>
                <a href="#" class="logo">
                    <img src="photo_6032782189076268073_y.jpg" alt="R SCHOOL">
                    <span class="nav-item">R SCHOOL</span>
                </a>
            </li>

            <li><a href="user_dashboard.php">
                <i class='bx bx-home'></i>
                <span class="nav-item">Accueil</span>               
            </a>
        
        </li>
            <li><a href="profil.php">
                <i class='bx bxs-user'></i>
                <span class="nav-item">Profil</span>
            </a></li>
            <li><a href="cours.php">
                <i class='bx bx-book-open bx-tada'></i>
                <span class="nav-item">Cours en Ligne</span>
            </a></li>
            <li><a href="parametre.php">
                <i class='bx bx-cog'></i>
                <span class="nav-item">Parametre</span>
            </a></li>
            <li><a href="logout.php" class="logout">
                <i class='bx bx-log-out'></i>
                <span class="nav-item">Logout</span>
            </a></li>
        </ul>
    </nav>

    <div class="main--content">
        <div class="header--wrapper">
            <div class="header--title">
                <span>Salles</span>
            </div>
            <div class="user--info">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='salle'>";
                        echo "<h2>" . htmlspecialchars($row['nom']) . "</h2>";
                        echo "<p>Capacité: " . htmlspecialchars($row['capacite']) . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "Aucune salle trouvée.";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>


                   
