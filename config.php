<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "bdt_grandi";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>