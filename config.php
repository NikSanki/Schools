<?php
$host = "localhost";
$username = "root";
$password = "admin"; //  database connection ka password
$dbname = "student_db"; // database name

$conn = new mysqli($host, $username, $password, $dbname);

// check connection 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
