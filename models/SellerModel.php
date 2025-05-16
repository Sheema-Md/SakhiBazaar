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
        $totalSales = 0;
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
        $total = 0;
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM products WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($total);
        $fetched = $stmt->fetch();
        $stmt->close();
        return $fetched ? $total : 0;
    }

    public function getTotalCustomers($userId) {
        $totalCustomers = 0;
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
        $avg = null;
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
}
?>
