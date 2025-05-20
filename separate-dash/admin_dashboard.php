<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
echo " hi Welcome to the Admin Dashboard!hi";
?>
