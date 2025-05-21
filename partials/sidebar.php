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
  <a href="product-listing.php" class="<?= $current_page === 'product-listing.php' ? 'active' : '' ?>">
    <i class="fas fa-box"></i> Product Listing
  </a>
  <a href="marketplace.php" class="<?= $current_page === 'marketplace.php' ? 'active' : '' ?>">
    <i class="fas fa-store"></i> Marketplace
  </a>
  <a href="transactions.php" class="<?= $current_page === 'transactions.php' ? 'active' : '' ?>">
    <i class="fas fa-money-check-alt"></i> Transactions
  </a>
  <a href="finance-literacy.php" class="<?= $current_page === 'finance-literacy.php' ? 'active' : '' ?>">
    <i class="fas fa-chart-line"></i> Finance & Literacy
  </a>
  <a href="help-support.php" class="<?= $current_page === 'help-support.php' ? 'active' : '' ?>">
    <i class="fas fa-headset"></i> Help & Support
  </a>
  <a href="success-stories.php" class="<?= $current_page === 'success-stories.php' ? 'active' : '' ?>">
    <i class="fas fa-book"></i> Success Stories
  </a>
  <a href="settings.php" class="<?= $current_page === 'settings.php' ? 'active' : '' ?>">
    <i class="fas fa-cog"></i> Settings
  </a>
</nav>

      <div class="logout-section">
        <form action="logout.php" method="POST">
      <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </form>
      </div>
</aside>
