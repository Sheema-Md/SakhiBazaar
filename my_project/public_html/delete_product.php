<?php require_once __DIR__ . '/../config/config.php';
if ($conn->connect_error) die("Connection failed");

$productId = $_GET['id'];

// Optional: delete image file from server if needed
$result = $conn->query("SELECT image_url FROM products WHERE id = $productId");
$row = $result->fetch_assoc();
if (!empty($row['image_url']) && file_exists($row['image_url'])) {
    unlink($row['image_url']);
}

$conn->query("DELETE FROM products WHERE id = $productId");
$conn->close();

header("Location: product-listing.php");
exit;
?>