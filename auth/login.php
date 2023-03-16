<?php

session_start();

require_once '../config/dbconnect.php';

// Get username and password from form
$username = $_POST["username"];
$password = $_POST["password"];

// Query the database for the user
$sql = "SELECT * FROM users WHERE UserName='$username' AND Password='$password'";
$result = mysqli_query($conn, $sql);

// Check if the user exists
if ((mysqli_num_rows($result) == 1)) {
    // User exists
    $row = mysqli_fetch_assoc($result);
    if ($row["UserType"] == "admin") {
        // Redirect to admin panel
        $_SESSION["username"] = $username;
        $_SESSION["usertype"] = "admin";
        header("Location: ../admin/dashboard.php");
    } else {
        // Redirect to user panel
        $_SESSION["username"] = $username;
        $_SESSION["usertype"] = "user";
        header("Location: ../profile.php");
    }
} else {
    // User does not exist
    echo "Invalid username or password.";
}

// Close the database connection
mysqli_close($conn);
