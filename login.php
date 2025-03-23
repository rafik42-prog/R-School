<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Connexion - R SCHOOL</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
        <form action="authenticate.php" method="POST">

      
            <h1>Bienvenue</h1>
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <?php

            // Vérification et inclusion du rôle depuis l'URL
            if (isset($_GET['role'])) {
                $role = htmlspecialchars($_GET['role']);
                echo "<input type='hidden' name='role' value='{$role}'>";
            } else {
                echo "<p>Role is not set. Please go back and select the appropriate role.</p>";
                exit();
            }
            ?>




            <div class="remember-forget">
                <label><input type="checkbox"> Enregistrer mot de passe</label>
               
                <a href="forgot_password.php">Oublier mot de passe?</a>
            </div>
            <button type="submit" class="btn">Connexion</button>
            <div class="register-link">
                
                <p>Il y a aucun compte? <a href="register.php">S'inscrire</a></p>
            </div>
        </form>
    </div>

    <?php
            // Debugging: display the role parameter
            if (isset($_GET['role'])) {
                $role = htmlspecialchars($_GET['role']);
                echo "<input type='hidden' name='role' value='{$role}'>";
            } else {
                echo "<p>Role is not set. Please go back and select the appropriate role.</p>";
                exit();
            }
            ?>



</body>
</html>
