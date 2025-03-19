<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $conn->real_escape_string($_POST['nom']);
    $email = $conn->real_escape_string($_POST['email']);
    $classe = $conn->real_escape_string($_POST['classe']);
    $date_naissance = $conn->real_escape_string($_POST['date_naissance']);
    $adresse = $conn->real_escape_string($_POST['adresse']);

    $sql = "INSERT INTO apprenants (nom, email,date_naissance,adresse) VALUES ('$nom', '$email','$date_naissance','$adresse')";

    if ($conn->query($sql) === TRUE) {
        header("Location: apprenant.php");
        exit();
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
