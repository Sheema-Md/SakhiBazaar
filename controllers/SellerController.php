<?php
require_once '../config.php';
require_once '../models/SellerModel.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$sellerModel = new SellerModel($conn);

// Fetch all dashboard data
$data = [
    'name' => $sellerModel->getSellerName($userId),
    'totalSales' => $sellerModel->getTotalSales($userId),
    'totalProducts' => $sellerModel->getTotalProducts($userId),
    'totalCustomers' => $sellerModel->getTotalCustomers($userId),
    'averageRating' => $sellerModel->getAverageRating($userId),
    'recentOrders' => $sellerModel->getRecentOrders($userId),
    'products' => $sellerModel->getProducts($userId)
];





require_once '../views/seller_dashboard_view.php';
?>
