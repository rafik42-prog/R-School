<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: login.php");
    exit();
}

include_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["course-file"]["name"]);
    $uploadOk = 1;
    $pdfFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($pdfFileType != "pdf") {
        echo "Seuls les fichiers PDF sont autorisés.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1 && move_uploaded_file($_FILES["course-file"]["tmp_name"], $target_file)) {
        $courseName = $_POST['course-name'];
        $courseType = $_POST['course-type'];
        $courseFileName = basename($_FILES["course-file"]["name"]);

        $sql = "INSERT INTO courses (course_name, course_description, course_file) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $courseName, $courseType, $courseFileName);

        if ($stmt->execute()) {
            echo "Le cours a été ajouté avec succès.";
        } else {
            echo "Erreur lors de l'ajout du cours : " . $stmt->error;
        }
    } else {
        echo "Une erreur s'est produite lors du téléchargement du fichier.";
    }
}

$conn->close();

header("Location: cour.php");
exit();
?>
