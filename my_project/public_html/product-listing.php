<?php 
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== 'seller') {
    header("Location:../login.php");
    exit();
}
require_once  __DIR__ . "/../config/config.php";
require_once 'partials/header.php';


require_once 'partials/sidebar.php';?>
<div class="overlay" id="overlay"></div>
<?php
require_once 'models/SellerModel.php';
$user_id = $_SESSION['id'];

// or however you get the seller id
$sellerModel = new SellerModel($conn);
$data = [
    'name' => $sellerModel->getSellerName($user_id),];
?>


  

<main class="main-content">
    <header class="topbar">
        

        <button class="hamburger" id="hamburger-btn"><i class="fas fa-bars"></i></button>
        
        <select class="language-select">
            <option>English</option>
            <option>Telugu</option>
            <option>Hindi</option>
            <option>Urdu</option>
        </select>
        <i class="fas fa-bell notification-icon"><span class="badge">3</span></i>
        <a href = "sellerprofile.php"  "style="text-decoration:none; color:inherit; display:block;">
        <div class="profile-name"><?php echo htmlspecialchars($data['name']); ?></div></a>

    </header>

    <section class="product-listing-panel">
        <h1>Product Listing</h1>
        
        <nav class="product-tabs">
            <button class="tab-btn active" data-tab="drafts">Drafts</button>
            <button class="tab-btn" data-tab="listed">Listed Products</button>
            <button class="tab-btn" data-tab="sold">Sold Products</button>
            <button class="tab-btn" id="add-product-tab">Add Product</button>
        </nav>

        <div class="tab-content" id="drafts">
            <?php
$active_tab = $_GET['tab'] ?? 'drafts';
?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const activeTab = "<?php echo $active_tab; ?>";
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.tab === activeTab) btn.classList.add('active');
    });

    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.style.display = 'none';
        if (tab.id === activeTab) tab.style.display = 'block';
    });
});
</script>

            <h2>Draft Products</h2>
            <?php 
            // You need to implement this function to get drafts
            echo $sellerModel->getDraftProductsHTML($user_id); 
            ?>
        
</div>
        <div class="tab-content" id="listed" style="display:none;">
            <h2>Listed Products</h2>
            <?php
            // Implement this or reuse your existing getProductsHTML but filter only listed
            echo $sellerModel->getListedProductsHTML($user_id);
            ?>
        </div>

        <div class="tab-content" id="sold" style="display:none;">
            <h2>Sold Products</h2>
            <?php 
            // Implement getSoldProductsHTML method for sold products
            echo $sellerModel->getSoldProductsHTML($user_id);
            ?>
        </div>
   
       

            
            
    </section>






<script>
document.querySelectorAll('.tab-btn').forEach(button => {
    button.addEventListener('click', () => {
        // Redirect if it's the add-product tab
        if (button.id === 'add-product-tab') {
            window.location.href = 'addproduct.php';
            return;
        }

        // Remove active class on all buttons
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(tab => tab.style.display = 'none');

        // Show selected tab content
        const tabId = button.getAttribute('data-tab');
        document.getElementById(tabId).style.display = 'block';
    });
});

</script>

<?php require_once 'partials/footer.php'; ?>
