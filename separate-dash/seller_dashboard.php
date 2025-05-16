<?php
session_start();
require_once '../config.php';

// Authentication check
if (!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== 'seller') {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION["id"];

// Fetch seller name
$stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($userName);
$stmt->fetch();
$stmt->close();

// Total Sales (sum of product price * quantity from orders of seller's products where status is completed)
$stmt = $conn->prepare("
    SELECT SUM(o.quantity * p.price) 
    FROM orders o
    JOIN products p ON o.product_id = p.id
    WHERE p.user_id = ? AND o.status = 'completed'
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($totalSales);
$stmt->fetch();
$stmt->close();

// Total Products
$stmt = $conn->prepare("SELECT COUNT(*) FROM products WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($totalProducts);
$stmt->fetch();
$stmt->close();

// Total Unique Customers
$stmt = $conn->prepare("
    SELECT COUNT(DISTINCT o.buyer_id)
    FROM orders o
    JOIN products p ON o.product_id = p.id
    WHERE p.user_id = ?
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($totalCustomers);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sakhi Bazaar - Seller Dashboard</title>
    <link rel="stylesheet" href="../css/sell_dash_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
    <aside class="sidebar" id="sidebar">
      <div class="logo">Sakhi Bazaar</div>
      <nav>
        <a class="active"><i class="fas fa-home"></i>  Dashboard</a>
        <a><i class="fas fa-user"></i>  Profile</a>
        <a><i class="fas fa-box"></i>  Product Listing</a>
        <a><i class="fas fa-store"></i>  Marketplace</a>
        <a><i class="fas fa-chart-line"></i>  Finance & Literacy</a>
        <a><i class="fas fa-headset"></i>  Help & Support</a>
        <a><i class="fas fa-book"></i>  Success Stories</a>
        <a><i class="fas fa-cog"></i>  Settings</a>
      </nav>
      <div class="logout-section">
        <button class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
      </div>
    </aside> 

    <main class="main-content">
        <div class="overlay" id="overlay"></div>

      <header class="topbar">
  <button class="hamburger" id="hamburger-btn">
    <i class="fas fa-bars"></i>
  </button>
  <select class="language-select">
    <option>English</option>
  </select>
  <i class="fas fa-bell notification-icon"><span class="badge">3</span></i>
  <div class="profile-name"><?php echo htmlspecialchars($userName); ?></div>
  
</header>
 <section class="welcome-section">
   
        <h1>Welcome, <?php echo htmlspecialchars($userName); ?>!</h1>
    
    <?php
// Fetch average rating for the seller
$stmt = $conn->prepare("
    SELECT AVG(rating) 
    FROM products 
    WHERE user_id = ?
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($averageRating);
$stmt->fetch();
$stmt->close();

$averageRating = $averageRating ? round($averageRating, 1) : 0;
?>

    <main>
          <div class = "stats">
            <div class="stat-card">
                <i class="fas fa-lock"></i>
                <h3>₹<?php echo number_format($totalSales ?? 0, 2); ?></h3>
                <p>Total Sales</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-box"></i>
                <h3><?php echo $totalProducts ?? 0; ?></h3>
                <p>Products</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <h3><?php echo $totalCustomers ?? 0; ?></h3>
                <p>Customers</p>
            </div>
            <div class="stat-card">
    <i class="fas fa-star"></i>
    <h3><?php echo ($averageRating) ? number_format($averageRating, 1) . '/5' : 'N/A'; ?></h3>
    <p>Rating</p>
</div>
</div>
        <button class="add-product-btn"><a href = "addproduct.php">+ Add New Product</button></a>
        </section>

        <!-- Recent Orders -->
        <?php
$stmt = $conn->prepare("
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
?>
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
            <?php while ($row = $result->fetch_assoc()): ?>
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
            <?php endwhile; ?>
        </tbody>
    </table>
            
</section>
<?php $stmt->close(); ?>


        <!-- Your Products -->
        <?php
$stmt = $conn->prepare("
    SELECT product_name, description, price, stock_status, quantity, image_url, rating
    FROM products
    WHERE user_id = ?
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>
<section class="your-products">
    <h2>Your Products</h2>
    <div class="product-cards">
        <?php while ($row = $result->fetch_assoc()): 
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
        <?php endwhile; ?>
    </div>
    <button class="view-all-btn"><a href = "view_all_product.php">+ Add New Product</button></a>
</section>
<?php $stmt->close(); ?>


<section class="financial-literacy">
        <h2>Financial Literacy Resources</h2>
        <div class="resources">
          <div class="resource-card">Basic Bookkeeping<br><small>Watch video tutorial →</small></div>
          <div class="resource-card">Pricing Your Products<br><small>Read article →</small></div>
          <div class="resource-card">Savings & Investment<br><small>Join webinar →</small></div>
          <div class="resource-card">Government Schemes<br><small>Explore schemes →</small></div>
        </div>
      </section>
                </div>

    </main>
</body>

<script>
  const hamburger = document.getElementById('hamburger-btn');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');

hamburger.addEventListener('click', () => {
    sidebar.classList.add('active');
    overlay.classList.add('active');
    hamburger.style.display = 'none'; // Hide hamburger
});

overlay.addEventListener('click', () => {
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
    hamburger.style.display = 'block'; // Show hamburger again
});

document.querySelectorAll('.sidebar nav a').forEach(link => {
    link.addEventListener('click', function() {
        // Remove 'active' from all links
        document.querySelectorAll('.sidebar nav a').forEach(el => el.classList.remove('active'));

        // Add 'active' to clicked link
        this.classList.add('active');
    });
});

// ✅ Fix: Handle window resize to reset states on desktop view
window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
        // Remove sidebar & overlay active classes
        sidebar.classList.remove('active');
        overlay.classList.remove('active');

        // Ensure hamburger icon is hidden in desktop mode
        hamburger.style.display = 'none';
    } else {
        // On smaller screens, hamburger should be visible
        hamburger.style.display = 'block';
    }
});


    
if (!localStorage.getItem("preferredLanguage")) {
      localStorage.setItem("preferredLanguage", "te"); // Telugu as default
    }

    function googleTranslateElementInit() {
      new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'en,hi,te,ur',
        autoDisplay: false,
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
      }, 'google_translate_element');
    }

    // Apply saved language automatically
    function applySavedLanguage() {
      const observer = new MutationObserver(() => {
        const select = document.querySelector(".goog-te-combo");
        if (select) {
          const savedLang = localStorage.getItem("preferredLanguage");
          if (savedLang && select.value !== savedLang) {
            select.value = savedLang;
            select.dispatchEvent(new Event("change"));
          }

          select.addEventListener("change", () => {
  const selectedLang = select.value;
  localStorage.setItem("preferredLanguage", selectedLang);

  // Submit to backend
  
});


          observer.disconnect();
        }
      });

      observer.observe(document.body, { childList: true, subtree: true });
    }

    // Load Google Translate script
    (function loadTranslateScript() {
      const script = document.createElement("script");
      script.src = "//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";
      document.body.appendChild(script);
    })();

    document.addEventListener("DOMContentLoaded", applySavedLanguage);
  
  
</script>

</html>
