<?php

class SellerModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getSellerName($userId) {
        $name = null;
        $stmt = $this->conn->prepare("SELECT name FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($name);
        $fetched = $stmt->fetch();
        $stmt->close();
        return $fetched && $name !== null ? $name : 'Seller';
    }

    public function getTotalSales($userId) {
        $totalSales=null;
        $stmt = $this->conn->prepare("
            SELECT SUM(o.quantity * p.price)
            FROM orders o
            JOIN products p ON o.product_id = p.id
            WHERE p.user_id = ? AND o.status = 'completed'
        ");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($totalSales);
        $fetched = $stmt->fetch();
        $stmt->close();
        return $fetched && $totalSales !== null ? $totalSales : 0;
    }

    public function getTotalProducts($userId) {
        $total=null;
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM products WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($total);
        $fetched = $stmt->fetch();
        $stmt->close();
        return $fetched ? $total : 0;
    }

    public function getTotalCustomers($userId) {
        $totalCustomers=null;
        $stmt = $this->conn->prepare("
            SELECT COUNT(DISTINCT o.buyer_id)
            FROM orders o
            JOIN products p ON o.product_id = p.id
            WHERE p.user_id = ?
        ");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($totalCustomers);
        $fetched = $stmt->fetch();
        $stmt->close();
        return $fetched ? $totalCustomers : 0;
    }

    public function getAverageRating($userId) {
        $avg=null;
        $stmt = $this->conn->prepare("SELECT AVG(rating) FROM products WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($avg);
        $fetched = $stmt->fetch();
        $stmt->close();
        return ($fetched && $avg !== null) ? round($avg, 1) : 0;
    }

    public function getRecentOrders($userId) {
        $stmt = $this->conn->prepare("
            SELECT o.id AS order_id, b.name AS buyer_name, p.product_name, o.quantity, o.status, o.order_date, p.price 
            FROM orders o
            JOIN users b ON o.buyer_id = b.id
            JOIN products p ON o.product_id = p.id
            WHERE p.user_id = ?
            ORDER BY o.order_date DESC
            LIMIT 5
        ");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        $stmt->close();
        return $orders;
    }

    public function getProducts($userId) {
        $stmt = $this->conn->prepare("
            SELECT product_name, description, price, stock_status, quantity, image_url, rating
            FROM products
            WHERE user_id = ?
        ");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        $stmt->close();
        return $products;
    }

    // ✅ HTML rendering method for recent orders
    public function getRecentOrdersHTML($userId) {
        $orders = $this->getRecentOrders($userId);

        ob_start(); ?>
        <section class="recent-orders">
            <h2>Recent Orders</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $row): ?>
                    <tr>
                        <td data-label="Order ID">#SB<?php echo $row['order_id']; ?></td>
                        <td data-label="Customer"><?php echo htmlspecialchars($row['buyer_name']); ?></td>
                        <td data-label="Product"><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td data-label="Amount">₹<?php echo number_format($row['price'] * $row['quantity'], 2); ?></td>
                        <td data-label="Status">
                            <span class="status <?php echo strtolower($row['status']); ?>"><?php echo ucfirst($row['status']); ?></span>
                        </td>
                        <td data-label="Order Date"><?php echo date('d M Y', strtotime($row['order_date'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <?php return ob_get_clean();
    }

    // ✅ HTML rendering method for product cards
    public function getProductsHTML($userId) {
        $products = $this->getProducts($userId);

        ob_start(); ?>
        <section class="your-products">
            <h2>Your Products</h2>
            <div class="product-cards">
                <?php foreach ($products as $row): 
                    $stockClass = ($row['quantity'] == 0) ? 'out-of-stock' : (($row['quantity'] <= 5) ? 'low-stock' : 'in-stock');
                ?>
                <div class="product-card <?php echo $stockClass; ?>">
                    <div class="image-placeholder">
                        <?php if (!empty($row['image_url'])): ?>
                            <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>" style="width:100%;height:auto;">
                        <?php else: ?>
                            <div style="background:#eee;width:100%;height:150px;"></div>
                        <?php endif; ?>
                    </div>
                    <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
                    <p class="product-description"><?php echo htmlspecialchars($row['description']); ?></p>
                    <p>Stock: <?php echo $row['quantity']; ?> | <?php echo ucfirst($row['stock_status']); ?></p>
                    <span>₹<?php echo number_format($row['price'], 2); ?></span>
                    <div class="rating">
                        <?php 
                        $fullStars = floor($row['rating']);
                        $halfStar = ($row['rating'] - $fullStars >= 0.5) ? 1 : 0;
                        $emptyStars = 5 - $fullStars - $halfStar;

                        echo str_repeat('⭐', $fullStars);
                        if ($halfStar) echo '⭐';
                        echo str_repeat('☆', $emptyStars);
                        ?> (<?php echo number_format($row['rating'], 1); ?>)
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <a href="view-products.php" class="view-all-btn"> View All Products</a>

        </section>
        <?php return ob_get_clean();
    }
    public function getFinancialLiteracyHTML() {
    ob_start(); ?>
    <section class="financial-literacy">
        <h2>Financial Literacy Resources</h2>
        <div class="resources">
            <div class="resource-card">Basic Bookkeeping<br><small>Watch video tutorial →</small></div>
            <div class="resource-card">Pricing Your Products<br><small>Read article →</small></div>
            <div class="resource-card">Savings & Investment<br><small>Join webinar →</small></div>
            <div class="resource-card">Government Schemes<br><small>Explore schemes →</small></div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}

}
