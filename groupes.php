<?php
$servername = "localhost"; // Update with your database server
$username = "root"; // Update with your database username
$password = ""; // Update with your database password
$dbname = "benrabah";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST requests for adding, editing, and deleting
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action == 'add') {
            $nom_groupe = $_POST['nom_groupe'];
            $stmt = $conn->prepare("INSERT INTO groupe (nom_groupe) VALUES (?)");
            $stmt->bind_param("s", $nom_groupe);
            $stmt->execute();
        } elseif ($action == 'edit') {
            $id_groupe = $_POST['id_groupe'];
            $nom_groupe = $_POST['nom_groupe'];
            $stmt = $conn->prepare("UPDATE groupe SET nom_groupe = ? WHERE id_groupe = ?");
            $stmt->bind_param("si", $nom_groupe, $id_groupe);
            $stmt->execute();
        } elseif ($action == 'delete') {
            $id_groupe = $_POST['id_groupe'];
            $stmt = $conn->prepare("DELETE FROM groupe WHERE id_groupe = ?");
            $stmt->bind_param("i", $id_groupe);
            $stmt->execute();
        }
    }
}

// Fetch all groups
$result = $conn->query("SELECT * FROM groupe");
$groupes = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

