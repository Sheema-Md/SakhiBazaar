

<?php
session_start();
 // connection to DB

// Check if user is logged in & role is seller
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header("Location: login.php");
    exit();
}
echo "Welcome to the Seller Dashboard!";

$user_id = $_SESSION['user_id'];

// Fetch seller's products
$stmt = $conn->prepare("SELECT * FROM products WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Seller Dashboard</title>
</head>
<body>
    <h2>Welcome Seller: <?php echo $_SESSION['name']; ?></h2>
    <h3>Your Products</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Stock Status</th>
            <th>Added On</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                <td><?php echo htmlspecialchars($row['price']); ?></td>
                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                <td><?php echo htmlspecialchars($row['stock_status']); ?></td>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a href="add_product.php">Add New Product</a>
</body>
</html>
