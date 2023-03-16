<?php
// Connect to MySQL database
$conn = mysqli_connect("localhost", "root", "", "rentacar");

// Check if connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
