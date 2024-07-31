<?php
include 'db.php';

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

// Handle file upload
$profile_image = NULL;
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    $tmp_name = $_FILES['profile_image']['tmp_name'];
    $profile_image = basename($_FILES['profile_image']['name']);
    $upload_file = $upload_dir . $profile_image;
    
    // Move uploaded file to the uploads directory
    if (move_uploaded_file($tmp_name, $upload_file)) {
        // File uploaded successfully
    } else {
        // Handle file upload error
        echo "Erreur lors de l'upload du fichier.";
        exit();
    }
}

// Insert user data into database
$sql = "INSERT INTO students (name, email, password, profile_image) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $password, $profile_image);
$stmt->execute();

header("Location: login.php");
exit();
?>
