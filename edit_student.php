<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM apprenants WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $apprenant = $result->fetch_assoc();

    if (!$apprenant) {
        die("Apprenant non trouvé.");
    }
} else {
    die("ID d'apprenant non fourni.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modifier Apprenant - R SCHOOL</title>
    <link rel="stylesheet" href="adm.css">
</head>
<body>
    <h2>Modifier Apprenant</h2>
    <form action="process_edit_student.php" method="post">
        <input type="hidden" name="id" value="<?php echo $apprenant['id']; ?>">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($apprenant['nom']); ?>" required><br>
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($apprenant['prenom']); ?>" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($apprenant['email']); ?>" required><br>
        <label for="date_naissance">Date de Naissance:</label>
        <input type="date" id="date_naissance" name="date_naissance" value="<?php echo $apprenant['date_naissance']; ?>" required><br>
        <label for="adresse">Adresse:</label>
        <input type="text" id="adresse" name="adresse" value="<?php echo htmlspecialchars($apprenant['adresse']); ?>" required><br>
        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
