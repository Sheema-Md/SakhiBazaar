<?php require_once __DIR__ . '/../config/config.php';
$productId = $_POST['id'];
$name = $_POST['name'];
$category = $_POST['category'];
$price = $_POST['price'];
$stock = $_POST['stock'];
$quantity = $_POST['quantity'];
$description = $_POST['description'];

$imagePath = null;
if (!empty($_FILES['prod-img']['name'])) {
    $targetDir = "uploads/";
    $imageName = basename($_FILES['prod-img']['name']);
    $imagePath = $targetDir . time() . "_" . $imageName;
    move_uploaded_file($_FILES['prod-img']['tmp_name'], $imagePath);
}

// Update logic
if ($imagePath) {
    $stmt = $conn->prepare("UPDATE products SET product_name=?, category=?, price=?, stock_status=?, quantity=?, description=?, image_url=? WHERE id=?");
    $stmt->bind_param("ssdssssi", $name, $category, $price, $stock, $quantity, $description, $imagePath, $productId);
} else {
    $stmt = $conn->prepare("UPDATE products SET product_name=?, category=?, price=?, stock_status=?, quantity=?, description=? WHERE id=?");
    $stmt->bind_param("ssdsssi", $name, $category, $price, $stock, $quantity, $description, $productId);
}

$stmt->execute();
$stmt->close();
$conn->close();

header("Location: seller_dashboard2.php?id=" . $productId);
exit;
?>