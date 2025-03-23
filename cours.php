<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

include_once 'db_connection.php';

// Fetch courses
$courses = [];
$sql = "SELECT id, course_name, course_description, course_file, created_at FROM courses ORDER BY id DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Cours</title>
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
                
                <i class='bx bx-book-open bx-tada' ></i>
                <span class="nav-item">Cours en Ligne</span>
                
            </a></li>
            <li><a href="user_tests.php"> 
                
                
                <span class="nav-item">Test de niveaux</span>
                
            </a></li>
            
        <li><a href="#" class="logout">
            <i class='bx bx-log-out'></i>
            <a href="logout.php"> Logout</a>
    </a></li>
    



        </ul>
    </nav>

<header>
    <h1>Liste des Cours</h1>
</header>

<main>
    <h2>Liste des Cours</h2>
    <ul id="course-list">
        <?php if (count($courses) > 0): ?>
            <?php foreach ($courses as $course): ?>
                <li>
                    <strong><?php echo htmlspecialchars($course['course_name']); ?></strong><br>
                    <?php echo htmlspecialchars($course['course_description']); ?><br>
                    <a href="<?php echo htmlspecialchars($course['course_file']); ?>" target="_blank">Télécharger le PDF</a><br>
                    <small><?php echo htmlspecialchars($course['created_at']); ?></small>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Aucun cours disponible pour le moment.</li>
        <?php endif; ?>
    
<?php
$files = [
    "conjugaisons.pdf" => "Télécharger la conjugaisons",
    "Conjugaison anglais.pdf" => " Télécharger  Conjugaison anglais"
];

foreach ($files as $file_path => $file_name) {
    if (file_exists($file_path)) {
        echo '<a href="' . $file_path . '" download>' . $file_name . '</a><br>';
    } else {
        echo 'Le fichier ' . $file_name . '  indisponible.<br>';
    }
}
?>



    </ul>
</main>

</body>
</html>
