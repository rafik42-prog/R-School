<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "benrabah";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $tel_mobile = $_POST['tel_mobile'];
    $email = $_POST['email'];
    $date_naissance = $_POST['date_naissance'];
    $adresse = $_POST['adresse'];
    $langue = $_POST['langue'];

    // Préparer la requête SQL
    $stmt = $conn->prepare("INSERT INTO inscription (nom, prenom, tel_mobile, email, date_naissance, adresse, langue) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nom, $prenom, $tel_mobile, $email, $date_naissance, $adresse, $langue);

    // Exécuter la requête et vérifier le succès
    if ($stmt->execute()) {
        echo "Inscription réussie.";
    } else {
        echo "Erreur: " . $stmt->error;
    }

    // Fermer la requête et la connexion
    $stmt->close();
    $conn->close();
}
?>
