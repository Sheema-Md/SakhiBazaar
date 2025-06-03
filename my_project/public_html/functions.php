<?php 
function getAllProducts() {
    require __DIR__ .  "/../config/config.php";
   

    $sql = "SELECT * FROM products ORDER BY RAND()";
    $res = $conn->query($sql);

    $products = [];
    while ($row = $res->fetch_assoc()) {
        $products[] = $row;
    }
    return $products;
}

function getFilteredProducts($filters) {
    require __DIR__ .  "/../config/config.php";
   

    $sql = "SELECT * FROM products WHERE 1=1";
    $params = [];
    $types = "";

    if (!empty($filters['category']) && $filters['category'] !== "All") {
        $sql .= " AND category = ?";
        $params[] = $filters['category'];
        $types .= "s";
    }

    if (!empty($filters['size'])) {
        $sql .= " AND `prod-size` = ?";
        $params[] = $filters['size'];
        $types .= "s";
    }

    if (!empty($filters['color'])) {
        $sql .= " AND `prod-color` = ?";
        $params[] = $filters['color'];
        $types .= "s";
    }

    if (!empty($filters['material'])) {
        $sql .= " AND material = ?";
        $params[] = $filters['material'];
        $types .= "s";
    }

    if (!empty($filters['rating'])) {
        $sql .= " AND rating >= ?";
        $params[] = $filters['rating'];
        $types .= "d";
    }

    $sql .= " AND price >= ? AND price <= ?";
    $params[] = $filters['minPrice'];
    $params[] = $filters['maxPrice'];
    $types .= "dd";

    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    return $products;
}

?>