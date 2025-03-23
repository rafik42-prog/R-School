<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_admin'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $grade = $_POST['grade'];
    $photo = '';

    // Handle file upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $photo = 'uploads/' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
    }

    $sql = "INSERT INTO admins (nom, prenom, grade, photo) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nom, $prenom, $grade, $photo);

    if ($stmt->execute()) {
        echo "L'administrateur a été ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout de l'administrateur : " . $stmt->error;
    }
}

$admins = [];
$sql = "SELECT id, nom, prenom, grade, photo FROM admins ORDER BY id DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $admins[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Administration - R SCHOOL</title>
    <link rel="stylesheet" href="adm.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<nav>
        <ul>
            <li>
                <a href="#" class="logo">
                     <!-- Sidebar -->
    
                    <img src="photo_6032782189076268073_y.jpg" alt="">
                    <span class="nav-item">R SCHOOL</span>
                   
                </a>
                 
            </li>
        
            <li><a href="">
                <i class='bx bxs-school'></i>
                <span class="nav-item">Administraction</span>               
            </a>
        
        </li>
        <li><a href="enseignant.php">
                   
            <i class='bx bxs-user-plus'></i>
               <span class="nav-item">Enseigant</span>
               

           </a></li>
            <li><a href="apprenant.php">
                <i class='bx bxs-graduation'></i>
                <span class="nav-item">Apprenant</span>
                
            </a></li>
            
        <li><a href="emploi.php" >
            <i class='bx bxs-group' ></i>
        <span class="nav-item">Emploi</span>
    </a></li>
    
    <li><a href="niveaux.php" >
        <i class='bx bx-trending-up'></i>
        <span class="nav-item">Niveaux</span>
    </a></li>
    <li><a href="tests.php" >
        <i class='bx bx-book-open'></i>
        <span class="nav-item">Test de niveau</span>
    </a></li>
    <li><a href="#" class="logout">
        <i class='bx bx-log-out'></i>
        <a href="logout.php"> Logout</a>
  
</a></li>
        </ul>
    
      </nav>
<div class="main--content">
    <h1>Ajouter un Administrateur</h1>
    <form action="admin_dashboard.php" method="POST" enctype="multipart/form-data">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required>
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required>
        <label for="grade">Grade:</label>
        <input type="text" id="grade" name="grade" required>
        <label for="photo">Photo:</label>
        <input type="file" id="photo" name="photo" accept="image/*">
        <button type="submit" name="add_admin">Ajouter</button>
    </form>

    <h2>Liste des Administrateurs</h2>
    <table>
        <thead>
        <div class ="main--content">
      <div class="card--container">
        <div class="card--wrapper">
          <div class="payment--card" > 
            <div class="card--header">
            <div class="amount">
                <span class="title"><b>20</b></span>
                <h3>Etudiants</h3>
            </div>

              </div>
           </div>
           <div class="payment--card"> 
            <div class="card--header">
            <div class="amount">
                <span class="title"><b>5</b> </span>
                <h3>Enseignants</h3>
            </div>
            
              </div>
           </div>
           <div class="payment--card"> 
            <div class="card--header">
            <div class="amount">
                <span class="title"><b>2</b></span>
                <h2>Ecoles</h2>
            </div>
            
              </div>
           </div>
           <div class="payment--card"> 
            <div class="card--header">
            <div class="amount">
                <span class="title"><b>20</b></span>
                <h3>Income</h3>
            </div>
            
              </div>
           </div>
         </div>
      </div>
      <div class="table admin">
        <table>
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Photo</th>
                    <th>NOM et prénom</th>
                    <th>Grade</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>01</td>
                    <td>
                        <img src="Fake 3D man.jpeg" alt="">
                    </td>
                    <td> Benrabah </td>
                    <td>Administrateur Principal</td>
                    <td>
                        <span class="action_btn">
                            <a href="#">Modifier</a>
                            <a href="#">Supprimer</a>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>02</td>
                    <td>
                        <img src="Whitehat.jpeg" alt="">
                    </td>
                    <td> Rahou </td>
                    <td>Administrateur Système</td>
                    <td>
                        <span class="action_btn">
                            <a href="#">Modifier</a>
                            <a href="#">Supprimer</a>
                        </span>
                    </td>
                </tr>

                <td>03</td>
                <td>
                    <img src="téléchargement (1).jpeg" alt="">
                </td>
                <td> Bensaid </td>
                <td>Secrétaire</td>
                <td>
                    <span class="action_btn">
                        <a href="#">Modifier</a>
                        <a href="#">Supprimer</a>
                    </span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <button class="add-admin-button">Ajouter un administrateur</button>

  
      </div>
        </thead>
        <tbody>
            <?php foreach ($admins as $admin): ?>
                <tr>
                    <td><?php echo $admin['id']; ?></td>
                    <td><?php echo htmlspecialchars($admin['nom']); ?></td>
                    <td><?php echo htmlspecialchars($admin['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($admin['grade']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($admin['photo']); ?>" alt="Photo" width="50" height="50"></td>
                    <td>
                        <span class="action_btn">
                            <a href="edit_admin.php?id=<?php echo $admin['id']; ?>">Modifier</a>
                            <a href="delete_admin.php?id=<?php echo $admin['id']; ?>">Supprimer</a>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
