<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "castrov_web";

// Vytvoření spojení
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrola spojení
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
