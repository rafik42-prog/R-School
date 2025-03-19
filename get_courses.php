<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "benrabah";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch courses and teacher's name
$sql = "SELECT c.nom_cour, e.nom AS nom_enseignant 
        FROM cours_en_ligne c 
        JOIN enseignants e ON c.id_ens = e.id_ens";
$result = $conn->query($sql);

$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}

echo json_encode($courses);

$conn->close();
?>

