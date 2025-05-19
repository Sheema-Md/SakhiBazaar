<?php
require "config.php";
session_start();

if (!isset($_SESSION['id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['id'];

// Read POST inputs
$store_name = $_POST['storeName'] ?? '';
$occupation = $_POST['occupation'] ?? '';
$pincode = $_POST['pincode'] ?? '';
$city = $_POST['city'] ?? '';
$state = $_POST['state'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$name = $_POST['name'] ?? '';

// Handle profile picture upload
$profile_picture = null; // null means no update to profile_pic

if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $tmpName = $_FILES['profile_picture']['tmp_name'];
    $filename = basename($_FILES['profile_picture']['name']);
    $targetFile = $uploadDir . time() . '_' . $filename; // unique filename

    if (move_uploaded_file($tmpName, $targetFile)) {
        $profile_picture = $targetFile;
    }
} elseif (isset($_POST['profile_picture']) && $_POST['profile_picture'] === '') {
    // User removed picture (sent empty string)
    $profile_picture = ''; // clear profile pic in DB
}

// Build SQL with or without profile_pic update
if ($profile_picture !== null) {
    $sql = "UPDATE users SET 
        store_name = ?, 
        occupation = ?, 
        pincode = ?, 
        city = ?, 
        state = ?, 
        phone = ?, 
        email = ?, 
        name = ?, 
        profile_picture = ?
    WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssssssi",
        $store_name,
        $occupation,
        $pincode,
        $city,
        $state,
        $phone,
        $email,
        $name,
        $profile_picture,
        $user_id
    );
} else {
    // No profile picture update
    $sql = "UPDATE users SET 
        store_name = ?, 
        occupation = ?, 
        pincode = ?, 
        city = ?, 
        state = ?, 
        phone = ?, 
        email = ?, 
        name = ?
    WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssssi",
        $store_name,
        $occupation,
        $pincode,
        $city,
        $state,
        $phone,
        $email,
        $name,
        $user_id
    );
}

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

if ($stmt->execute()) {
    echo "Profile updated successfully.";
} else {
    echo "Error updating profile: " . $stmt->error;
}
?>