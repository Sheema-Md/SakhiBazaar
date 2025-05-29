<aside class="sidebar" id="sidebar">
  
  <div class="logo">Sakhi Bazaar</div>
  <?php $current_page = basename($_SERVER['PHP_SELF']); ?>

<nav>
  <a href="seller_dashboard2.php" class="<?= $current_page === 'seller_dashboard2.php' ? 'active' : '' ?>">
    <i class="fas fa-home"></i> Dashboard
  </a>
  <a href="sellerprofile.php" class="<?= $current_page === 'sellerprofile.php' ? 'active' : '' ?>">
    <i class="fas fa-user"></i> Profile
  </a>
 <div class="sidebar-dropdown">
  <a href="product-listing.php" class="<?= $current_page === 'product-listing.php' ? 'active' : '' ?>" id="product-listing-toggle">
    <i class="fas fa-box"></i> Product Listing <i class="fas fa-chevron-down dropdown-icon"></i>
  </a>
  <div class="sidebar-submenu" id="product-listing-submenu" style="display: <?= $current_page === 'product-listing.php' ? 'block' : 'none' ?>;">
    <a href="product-listing.php?tab=drafts" class="sub-link">Drafts</a>
    <a href="product-listing.php?tab=listed" class="sub-link">Listed Products</a>
    <a href="product-listing.php?tab=sold" class="sub-link">Sold Products</a>
    <a href="addproduct.php" class="sub-link">Add Product</a>
  </div>
</div>

  </a>
 <a href="#" class="sidebar-link" data-url="market.php"> 
  <i class="fas fa-store"></i> Marketplace
</a>
<a href="#" class="sidebar-link" data-url="transactions.php">
  <i class="fas fa-money-check-alt"></i> Transactions
</a>
<a href="#" class="sidebar-link" data-url="finance-literacy.php">
  <i class="fas fa-chart-line"></i> Finance & Literacy
</a>
<a href="#" class="sidebar-link" data-url="help-support.php">
  <i class="fas fa-headset"></i> Help & Support
</a>
<a href="#" class="sidebar-link" data-url="success-stories.php">
  <i class="fas fa-book"></i> Success Stories
</a>
<a href="#" class="sidebar-link" data-url="settings.php">
  <i class="fas fa-cog"></i> Settings
</a>

</nav>

      <div class="logout-section">
        <form action="logout.php" method="POST">
      <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </form>
      </div>
</aside>
<script>
document.getElementById('product-listing-toggle').addEventListener('click', function(e) {
    e.preventDefault(); // Prevents page reload
    const submenu = document.getElementById('product-listing-submenu');
    submenu.style.display = (submenu.style.display === 'block') ? 'none' : 'block';
});

  document.querySelectorAll('.sidebar-link').forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      const url = this.getAttribute('data-url');
      fetch(url)
        .then(response => response.text())
        .then(html => {
          document.querySelector('.main-content').innerHTML = html;

        });
    });
  });

</script>
