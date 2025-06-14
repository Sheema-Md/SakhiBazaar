<?php
session_start();
require_once  __DIR__ . "/../config/config.php";// your DB connection

if (!isset($_SESSION['id'])) {
    die("You must be logged in to submit a review.");
}

$user_id = $_SESSION['id'];
$product_id = intval($_POST['product_id']);
$name = trim($_POST['name']);
$review = trim($_POST['review']);
$rating = intval($_POST['rating']);

// Validate inputs
if ($product_id <= 0 || $rating < 1 || $rating > 5 || empty($name) || empty($review)) {
    die("Invalid input.");
}

// Check if user bought the product
$stmt = $conn->prepare("SELECT COUNT(*) FROM orders WHERE buyer_id = ? AND product_id = ? AND status = 'completed'");
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$stmt->bind_result($purchaseCount);
$stmt->fetch();
$stmt->close();

if ($purchaseCount === 0) {
    die("You can only review products you've purchased.");
}

// Optional: check if user already submitted a review
$stmt = $conn->prepare("SELECT id FROM reviews WHERE buyer_id = ? AND product_id = ?");
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    die("You’ve already submitted a review for this product.");
}
$stmt->close();

// Insert review
$stmt = $conn->prepare("INSERT INTO reviews (buyer_id, product_id, name, review, rating, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("iissi", $user_id, $product_id, $name, $review, $rating);

if ($stmt->execute()) {
    header("Location: productdetails.php?id=$product_id#reviews");
    exit;
} else {
    echo "Error submitting review.";
}
$stmt->close();
?>
