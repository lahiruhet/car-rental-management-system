<?php
require_once '../config/dbconnect.php';

$username = $_POST["username"];
$password = $_POST["password"];

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
    $file = $_FILES['avatar'];
    // Move the file to a directory on your server
    $targetDir = '../assets/img/avatars/';
    $targetFile = $targetDir . basename($file['name']);
    move_uploaded_file($file['tmp_name'], $targetFile);
    $avatar = $targetFile;
} else {
    // Use default avatar
    $avatar = '../assets/img/avatars/default.png';
}

// Check if username is already taken
$query = "SELECT * FROM users WHERE UserName='$username'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    // Display error message
    echo "<p>Username already taken.</p>";
} else {
    // Insert new user into database with avatar filename
    $query = "INSERT INTO users (UserName, Password, UserType, Avatar) VALUES ('$username', '$password', 'user', '$avatar')";
    if (mysqli_query($conn, $query)) {
        // Display success message with styling
        echo "<style>body{
            background-image: url('../assets/img/success.gif');
            background-size: cover;
            height: 100vh;
            padding:0;
            margin:0;
        }</style><body></body>";
        header("refresh:5;url=../index.php");
    } else {
        // Display error message
        echo "<p>Error creating account.</p>";
    }
}

// Close the database connection
mysqli_close($conn);
