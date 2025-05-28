<?php 

if (!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== 'seller') {
    header("Location:login.php");
    exit();
}?>
<?php require_once 'partials/header.php'; ?>
<?php require_once 'partials/sidebar.php';

require_once 'models/SellerModel.php';
 ?>
<main class="main-content">
    <div class="overlay" id="overlay"></div>
    <header class="topbar">
        <button class="hamburger" id="hamburger-btn">
            <i class="fas fa-bars"></i>
        </button>
        <select class="language-select">
            <option>English</option>
            <option>Telugu</option>
            <option>Hindi</option>
            <option>Urdu</option>
            
        </select>
        <i class="fas fa-bell notification-icon"><span class="badge">3</span></i>
        <div class="profile-name"><?php echo htmlspecialchars($data['name']); ?></div>

    </header>
    <section class="welcome-section">
        <h1>Welcome, <?php echo htmlspecialchars($data['name']); ?>!</h1>

        <div class="stats">
            <div class="stat-card">
                <i class="fas fa-lock"></i>
                <h3>₹<?php echo number_format($data['totalSales'], 2); ?></h3>
                <p>Total Sales</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-box"></i>
                <h3><?php echo $data['totalProducts']; ?></h3>
                <p>Products</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <h3><?php echo $data['totalCustomers']; ?></h3>
                <p>Customers</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-star"></i>
                <h3><?php echo $data['averageRating']; ?>/5</h3>
                <p>Rating</p>
            </div>
        </div>
        <a href="addproduct.php" class="add-product-btn">+Add New Product</a>

    </section>
      
    <!-- Recent Orders -->
   <?php
   echo $sellerModel->getRecentOrdersHTML( $userId);?>
    
   <section class="motivational-quote">
        <h2>Motivational Quote</h2>
        <blockquote>"The secret of change is to focus all of your energy, not on fighting the old, but on building the new." - Socrates</blockquote>
      </section>
<?php echo $sellerModel->getProductsHTML( $userId);
echo $sellerModel->getFinancialLiteracyHTML();?>



    
<script src = "js/script.js"></script>



<?php require_once 'partials/footer.php'; ?>