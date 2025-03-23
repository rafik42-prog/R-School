<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Enseignant</title>
    <link rel="stylesheet" href="profil.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
        <nav>
            <div class="logo">
                <img src="photo_6032782189076268073_y.jpg" alt="">
                <span class="nav-item">R SCHOOL</span>
            </div>
            <ul>
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
                <li><a href="emt eng.php">
                    <i class='bx bxs-calendar'></i>
                    <span class="nav-item">&nbsp;Emploi du temps</span>
                </a></li>
                <li><a href="logout.php" class="logout">
                    <i class='bx bx-log-out'></i>
                    <span class="nav-item">&nbsp;Logout</span>
                </a></li>
            </ul>
        </nav>
    </div>

    <div class="container">
        <header>
            <h1>Profil Enseignant</h1>
        </header>

        <main>
            <section class="profile">
                <div class="profile-info">
                    <img src="avatar2.png" alt="Photo de profil" class="profile-pic">
                    <div class="details">
                        <p><strong>Nom:</strong> Rahou</p>
                        <p><strong>Prénom:</strong> Maroua</p>
                        <p><strong>Date de naissance:</strong> 09/12/1993</p>
                        <p><strong>Email:</strong> maroua@gmail.com</p>
                        <p><strong>Adresse:</strong>Elbayadh</p>
                        <p><strong>Grade:</strong>Prof de Anglais </p>
                        
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="profil.js"></script>
</body>
</html>
