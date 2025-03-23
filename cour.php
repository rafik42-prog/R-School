<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: login.php");
    exit();
}

include_once 'db_connection.php';

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
    <title>Page de Cours de l'Enseignant</title>
    <link rel="stylesheet" href="profil.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

<nav>
    <ul>
        <li>
            <hr>
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
        <li><a href="emt_eng.php">
            <i class='bx bxs-calendar'></i>
            <span class="nav-item">&nbsp;Emploi du temps</span>
        </a></li>
        <li><a href="logout.php" class="logout">
            <i class='bx bx-log-out'></i>
            <span class="nav-item">&nbsp;Logout</span>
        </a></li>
    </ul>
</nav>

<header>
    <h1>Page de Cours de l'Enseignant</h1>
</header>

<main>
    <h2>Ajouter un Cours</h2>
    <form id="add-course-form" action="add_course.php" method="POST" enctype="multipart/form-data">
        <label for="course-name">Nom du Cours:</label>
        <input type="text" id="course-name" name="course_name" required>
        <label for="course-description">Description:</label>
        <textarea id="course-description" name="course_description" required></textarea>
        <label for="course-file">Fichier PDF:</label>
        <input type="file" id="course-file" name="course_file" required accept=".pdf">
        <button type="submit" name="add_course">Ajouter</button>
    </form>

    
</main>

</body>
</html>
