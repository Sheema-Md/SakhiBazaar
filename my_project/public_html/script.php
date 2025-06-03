<?php 
require "functions.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $category = $_POST['category'] ?? '';
    $size = $_POST['size'] ?? '';
    $color = $_POST['color'] ?? '';
    $material = $_POST['material'] ?? '';
    $rating = $_POST['rating'] ?? '';
    $minPrice = isset($_POST['minPrice']) && is_numeric($_POST['minPrice']) ? floatval($_POST['minPrice']) : 0;
    $maxPrice = isset($_POST['maxPrice']) && is_numeric($_POST['maxPrice']) ? floatval($_POST['maxPrice']) : INF;

    if ($category === "All" || $category === "") {
        $products = getAllProducts();
    } else {
        $products = getFilteredProducts([
            'category' => $category,
            'size'     => $size,
            'color'    => $color,
            'material' => $material,
            'rating'   => $rating,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
        ]);
    }

    echo json_encode($products);
}
