<?php
include 'db.php';
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM students WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    if (password_verify($password, $student['password'])) {
        $_SESSION['student_id'] = $student['id'];
        header("Location: profile.php");
        exit();
    }
}

header("Location: login.php?error=1");
exit();
?>
