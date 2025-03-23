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
            $nom_cour = $_POST['nom_cour'];
            $stmt = $conn->prepare("INSERT INTO niveau (nom_cour) VALUES (?)");
            $stmt->bind_param("s", $nom_cour);
            $stmt->execute();
        } elseif ($action == 'edit') {
            $id_niv = $_POST['id_niv'];
            $nom_cour = $_POST['nom_cour'];
            $stmt = $conn->prepare("UPDATE niveau SET nom_cour = ? WHERE id_niv = ?");
            $stmt->bind_param("si", $nom_cour, $id_niv);
            $stmt->execute();
        } elseif ($action == 'delete') {
            $id_niv = $_POST['id_niv'];
            $stmt = $conn->prepare("DELETE FROM niveau WHERE id_niv = ?");
            $stmt->bind_param("i", $id_niv);
            $stmt->execute();
        }
    }
}

// Fetch all levels
$result = $conn->query("SELECT * FROM niveau");
$niveaux = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Espace Etudiant - R SCHOOL</title>
    <link rel="stylesheet" href="adm.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script>
        function editNiveau(id, name) {
            document.getElementById('id_niv').value = id;
            document.getElementById('nom_cour').value = name;
            document.getElementById('action').value = 'edit';
        }

        function deleteNiveau(id) {
            document.getElementById('id_niv').value = id;
            document.getElementById('action').value = 'delete';
            document.forms['niveauForm'].submit();
        }

        function addNiveau() {
            document.getElementById('id_niv').value = '';
            document.getElementById('nom_cour').value = '';
            document.getElementById('action').value = 'add';
        }
    </script>
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
            <li><a href="admin_dashboard.php">
                <i class='bx bxs-school'></i>
                <span class="nav-item">Administration</span>               
            </a></li>
            <li><a href="">
                <i class='bx bxs-user-plus'></i>
                <span class="nav-item">Enseignant</span>
            </a></li>
            <li><a href="">
                <i class='bx bxs-graduation'></i>
                <span class="nav-item">Apprenant</span>
            </a></li>
            <li><a href="">
                <i class='bx bxs-group'></i>
                <span class="nav-item">Groupe</span>
            </a></li>
            <li><a href="niveaux.php">
                <i class='bx bx-trending-up'></i>
                <span class="nav-item">Niveaux</span>
            </a></li>
            <li><a href="logout.php" class="logout">
                <i class='bx bx-log-out'></i>
                <span class="nav-item">Logout</span>
            </a></li>
        </ul>
    </nav>

    <div class="education-container">
        <!-- Niveaux d'étude existants -->
        <div class="education-level">
            <?php foreach ($niveaux as $niveau): ?>
                <h2><?php echo htmlspecialchars($niveau['nom_cour']); ?></h2>
                <button class="btn" onclick="editNiveau(<?php echo $niveau['id_niv']; ?>, '<?php echo htmlspecialchars(addslashes($niveau['nom_cour'])); ?>')">Modifier</button>
                <button class="btn" onclick="deleteNiveau(<?php echo $niveau['id_niv']; ?>)">Supprimer</button>
            <?php endforeach; ?>
        </div>
        <!-- Ajout de nouveaux niveaux -->
        <div class="add-education">
            <button class="btn" onclick="addNiveau()">Ajouter Niveau</button>
        </div>
    </div>

    <!-- Form for CRUD operations -->
    <form id="niveauForm" method="POST" action="niveaux.php">
        <input type="hidden" id="id_niv" name="id_niv">
        <input type="hidden" id="action" name="action">
        <input type="text" id="nom_cour" name="nom_cour">
        <button type="submit" class="btn">Enregistrer</button>
    </form>
</body>
</html>
