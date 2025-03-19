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
    if (isset($_POST['action_seance'])) {
        $action = $_POST['action_seance'];
        if ($action == 'delete') {
            $id_seance = $_POST['id_seance'];
            $stmt = $conn->prepare("DELETE FROM seance WHERE id_seance = ?");
            $stmt->bind_param("i", $id_seance);
            $stmt->execute();
        }
    }

    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action == 'add') {
            if (isset($_POST['nom_groupe'])) {
                $nom_groupe = $_POST['nom_groupe'];
                $stmt = $conn->prepare("INSERT INTO groupe (nom_groupe) VALUES (?)");
                $stmt->bind_param("s", $nom_groupe);
                $stmt->execute();
            } elseif (isset($_POST['matiere'])) {
                $matiere = $_POST['matiere'];
                $niveau = $_POST['niveau'];
                $salle = $_POST['salle'];
                $enseignant = $_POST['enseignant'];
                $jour = $_POST['jour'];
                $heure_debut = $_POST['heure_debut'];
                $heure_fin = $_POST['heure_fin'];
                $stmt = $conn->prepare("INSERT INTO seance (matiere, niveau, salle, enseignant, jour, heure_debut, heure_fin) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssss", $matiere, $niveau, $salle, $enseignant, $jour, $heure_debut, $heure_fin);
                $stmt->execute();
            }
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

// Fetch all groups and seances
$result = $conn->query("SELECT * FROM groupe");
$groupes = $result->fetch_all(MYSQLI_ASSOC);

$result_seance = $conn->query("SELECT * FROM seance");
$seances = $result_seance->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emploi du Temps</title>
    <link rel="stylesheet" href="emploi.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script>
        function editGroupe(id, name) {
            document.getElementById('id_groupe').value = id;
            document.getElementById('nom_groupe').value = name;
            document.getElementById('action').value = 'edit';
        }

        function deleteGroupe(id) {
            document.getElementById('id_groupe').value = id;
            document.getElementById('action').value = 'delete';
            document.forms['groupeForm'].submit();
        }

        function addGroupe() {
            document.getElementById('id_groupe').value = '';
            document.getElementById('nom_groupe').value = '';
            document.getElementById('action').value = 'add';
        }

        function deleteSeance(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette séance ?')) {
                document.getElementById('id_seance').value = id;
                document.getElementById('action_seance').value = 'delete';
                document.forms['seanceForm'].submit();
            }
        }
    </script>
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
            <li><a href=""><i class='bx bxs-school'></i><span class="nav-item">&nbsp;Administration</span></a></li>
            <li><a href=""><i class='bx bxs-user-plus'></i><span class="nav-item">&nbsp;Enseignant</span></a></li>
            <li><a href=""><i class='bx bxs-graduation'></i><span class="nav-item">&nbsp;Apprenant</span></a></li>
            <li><a href=""><i class='bx bx-trending-up'></i><span class="nav-item"> &nbsp;Niveaux</span></a></li>
            <li><a href=""><i class='bx bx-book-open'></i><span class="nav-item">&nbsp;Cour en ligne</span></a></li>
            <li><a href=" #" class="logout"><i class='bx bx-log-out'></i><span class="nav-item">Déconnexion</span></a></li>
        </ul>
    </nav>

    <h1>Emploi du Temps</h1>

    <div class="group-container">
        <div class="group-list">
            <?php foreach ($groupes as $groupe): ?>
                <h2><?php echo htmlspecialchars($groupe['nom_groupe']); ?></h2>
                <button class="btn" onclick="editGroupe(<?php echo $groupe['id_groupe']; ?>, '<?php echo htmlspecialchars(addslashes($groupe['nom_groupe'])); ?>')">Modifier</button>
                <button class="btn" onclick="deleteGroupe(<?php echo $groupe['id_groupe']; ?>)">Supprimer</button>
            <?php endforeach; ?>
        </div>
        <div class="add-group">
            <button class="btn" onclick="addGroupe()">Ajouter Groupe</button>
        </div>
    </div>

    <!-- Form for CRUD operations on groups -->
    <form id="groupeForm" method="POST" action="emploi_du_temps.php">
        <input type="hidden" id="id_groupe" name="id_groupe">
        <input type="hidden" id="action" name="action">
        <input type="text" id="nom_groupe" name="nom_groupe" placeholder="Nom du groupe">
        <button type="submit" class="btn">Enregistrer</button>
    </form>

    <!-- Form for adding a new seance -->
    <form id="seanceForm" method="POST" action="emploi_du_temps.php">
        <input type="hidden" id="id_seance" name="id_seance">
        <input type="hidden" id="action_seance" name="action_seance">
        <input type="text" id="matiere" name="matiere" placeholder="Matière">
        <input type="text" id="niveau" name="niveau" placeholder="Niveau">
        <input type="text" id="salle" name="salle" placeholder="Salle">
        <input type="text" id="enseignant" name="enseignant" placeholder="Enseignant">
        <input type="text" id="jour" name="jour" placeholder="Jour">
        <input type="time" id="heure_debut" name="heure_debut" placeholder="Heure de début">
        <input type="time" id="heure_fin" name="heure_fin" placeholder="Heure de fin">
        <button type="submit" class="btn">Ajouter Séance</button>
    </form>

    <table>
      <tr>
        <th>Séance</th>
        <th>Matière</th>
        <th>Niveau</th>
        <th>Salle</th>
        <th>Enseignant</th>
        <th>Jours</th>
        <th>Actions</th> <!-- New column for actions -->
      </tr>
      <?php foreach ($seances as $seance): ?>
      <tr>
        <td><?php echo htmlspecialchars($seance['heure_debut']) . '-' . htmlspecialchars($seance['heure_fin']); ?></td>
        <td><?php echo htmlspecialchars($seance['matiere']); ?></td>
        <td><?php echo htmlspecialchars($seance['niveau']); ?></td>
        <td><?php echo htmlspecialchars($seance['salle']); ?></td>
        <td><?php echo htmlspecialchars($seance['enseignant']); ?></td>
        <td><?php echo htmlspecialchars($seance['jour']); ?></td>
        <td><button onclick="deleteSeance(<?php echo $seance['id_seance']; ?>)">Supprimer</button></td>
      </tr>
      <?php endforeach; ?>
    </table>

    <button id="ajouter-seance-btn" onclick="addSeance()">Ajouter une Séance</button>
</body>
</html>
