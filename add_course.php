<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: login.php");
    exit();
}

include_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_course'])) {
    $courseName = $_POST['course_name'];
    $courseDescription = $_POST['course_description'];
    $filePath = '';

    // Handle file upload
    if (isset($_FILES['course_file']) && $_FILES['course_file']['error'] == UPLOAD_ERR_OK) {
        $filePath = 'uploads/' . basename($_FILES['course_file']['name']);
        move_uploaded_file($_FILES['course_file']['tmp_name'], $filePath);
    }

    $sql = "INSERT INTO courses (course_name, course_description, course_file) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $courseName, $courseDescription, $filePath);

    if ($stmt->execute()) {
        echo "Course added successfully.";
    } else {
        echo "Error adding course: " . $stmt->error;
    }

    header("Location: cour.php");
    exit();
}

$conn->close();
?>
