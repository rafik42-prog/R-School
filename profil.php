<?php
session_start();

// Paramètres de connexion à la base de données
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "benrabah";

// Créer la connexion
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    die("Vous devez être connecté pour modifier votre profil.");
}

// Fonction pour mettre à jour le profil de l'utilisateur
function update_profile($conn, $current_username, $new_username, $new_password, $email) {
    // Vérifier si le nouveau nom d'utilisateur est déjà pris par un autre utilisateur
    if ($new_username !== $current_username) {
        $check_stmt = $conn->prepare("SELECT username FROM utilisateur WHERE username = ?");
        $check_stmt->bind_param("s", $new_username);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            echo "Erreur: Le nouveau nom d'utilisateur est déjà pris.";
            $check_stmt->close();
            return;
        }

        $check_stmt->close();
    }

    // Construire la requête de mise à jour
    $query = "UPDATE utilisateur SET username = ?, email = ?";
    if (!empty($new_password)) {
        $query .= ", password = ?";
    }
    $query .= " WHERE username = ?";
    
    // Préparer la déclaration
    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $new_username, $email, $hashed_password, $current_username);
    } else {
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $new_username, $email, $current_username);
    }

    // Exécuter la déclaration
    if ($stmt->execute()) {
        echo "Profil mis à jour avec succès.";
        // Mettre à jour le nom d'utilisateur dans la session
        $_SESSION['username'] = $new_username;
    } else {
        echo "Erreur: " . $stmt->error;
    }

    $stmt->close();
}

// Traitement du formulaire de mise à jour du profil
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_username = $_SESSION['username'];
    $new_username = $_POST['username'];
    $new_password = $_POST['new_password'];
    $email = $_POST['email'];

    // Appeler la fonction pour mettre à jour le profil
    update_profile($conn, $current_username, $new_username, $new_password, $email);
}

// Fermer la connexion
$conn->close();
?>

<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Espace Etudiant - R SCHOOL</title>
    <link rel="stylesheet" href="profil.css">
    <!--font awesome link-->
    
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

    <div class="container">
        <header>
            <h1>Profil Apprenant</h1>
        </header>

        <main>
            <section class="profile">
                <div class="profile-info">
                    <img src="photo.jpeg" alt="Photo de profil" class="profile-pic">
                    <div class="details">
                        <p><strong>Nom:</strong> Benrabah</p>
                        <p><strong>Prénom:</strong> rafik</p>
                        <p><strong>Date de naissance:</strong> 17/07/2004</p>
                        <p><strong>Email:</strong> benrabahrafik87@gmail.com</p>
                        <p><strong>Adresse:</strong> Sidi bel abbes</p>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <h2>Modifier Profil</h2>
    <form action="" method="POST">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" required value="<?php echo htmlspecialchars($_SESSION['username']); ?>"><br><br>

        <label for="new_password">Nouveau mot de passe:</label>
        <input type="password" id="new_password" name="new_password"><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br><br>

        <input type="submit" value="Mettre à jour">
    </form>
</body>
</html>
