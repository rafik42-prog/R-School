<?php
session_start();

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "benrabah";

// Créer une connexion
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérifiez que le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = isset($_POST['role']) ? $_POST['role'] : '';

    // Vérifiez que le rôle est défini
    if (empty($role)) {
        echo "Role is not set. Please go back and select the appropriate role.";
        exit();
    }
      // Déterminer la table en fonction du rôle
      switch ($role) {
        case 'admin':
            $table = 'users';
            break;
        case 'teacher':
            $table = 'ensignant';
            break;
        case 'user':
            $table = 'utilisateur';
            break;
        default:
            die("Invalid role.");
    }


    // Préparer la requête SQL en fonction du rôle
    if ($role == 'user') {
        $sql = "SELECT id, username, password FROM utilisateur WHERE username = ?";
    } elseif ($role == 'teacher') {
        $sql = "SELECT id, username, password FROM ensignant WHERE username = ?";
    } elseif ($role == 'admin') {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
    } else {
        echo "Invalid role.";
        exit();
    }

    // Préparer la déclaration
    $stmt = $conn->prepare($sql);

    // Vérifier si la préparation a réussi
    if ($stmt) {
        // Lier les paramètres
        $stmt->bind_param("s", $username);
        // Exécuter la requête
        $stmt->execute();
        // Obtenir le résultat
        $result = $stmt->get_result();

        // Vérifiez si un utilisateur a été trouvé
        if ($result->num_rows > 0) {
            // Récupérer les données de l'utilisateur
            $user = $result->fetch_assoc();
            // Vérifiez le mot de passe
            if (password_verify($password, $user['password'])) {
                // Définir les variables de session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $role;
                // Rediriger l'utilisateur en fonction de son rôle
                if ($role == 'user') {
                    header("Location: user_dashboard.php");
                } elseif ($role == 'teacher') {
                    header("Location: teacher_dashboard.php");
                } elseif ($role == 'admin') {
                    header("Location: admin_dashboard.php");
                }
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with that username.";
        }
        // Fermer la déclaration
        $stmt->close();
    } else {
        echo "Failed to prepare the SQL statement.";
    }
}
// Fermer la connexion
$conn->close();
?>


