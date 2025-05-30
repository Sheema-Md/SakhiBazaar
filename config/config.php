<?php
$host = 'localhost';
$db = 'sakhibazaar';
$user = 'root';
$pass = 'Aamina@12';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
