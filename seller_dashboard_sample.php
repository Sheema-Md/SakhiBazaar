<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== 'seller') {
    header("Location: login.php");
    exit();
}
 // connection to DB
$conn = new mysqli("localhost", "root", "", "sakhibazaar");
$userId = $_SESSION["id"];
$sql = "SELECT name FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($userName);
$stmt->fetch();
$stmt->close();
$conn->close();


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sakhi Bazaar - Seller Dashboard</title>
  <link rel="stylesheet" href="css/sell_dash_style.css">
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

      <!-- Content sections remain unchanged -->
      <!-- welcome-section, stats, recent-orders, motivational-quote, your-products, financial-literacy sections stay same -->
         <section class="welcome-section">
  
<h1>Welcome back, <?php echo htmlspecialchars($userName); ?>!</h1>

        <div class="stats">
          <div class="stat-card">
            <i class="fas fa-lock"></i>
            <h3>₹24,780</h3>
            <p>Total Sales</p>
          </div>
          <div class="stat-card">
            <i class="fas fa-box"></i>
            <h3>15</h3>
            <p>Products</p>
          </div>
          <div class="stat-card">
            <i class="fas fa-users"></i>
            <h3>48</h3>
            <p>Customers</p>
          </div>
          <div class="stat-card">
            <i class="fas fa-star"></i>
            <h3>4.8/5</h3>
            <p>Rating</p>
          </div>
        </div>
        <button class="add-product-btn">+ Add New Product</button>
      </section>

      <section class="recent-orders">
        <h2>Recent Orders</h2>
        <table>
          <tr>
  <td data-label="Order ID">#SB2345</td>
  <td data-label="Customer">Anita Desai</td>
  <td data-label="Product">Handwoven Scarf</td>
  <td data-label="Amount">₹1,200</td>
  <td data-label="Status"><span class="status delivered">Delivered</span></td>
</tr>

        </table>
      </section>

      <section class="motivational-quote">
        <h2>Motivational Quote</h2>
        <blockquote>"The secret of change is to focus all of your energy, not on fighting the old, but on building the new." - Socrates</blockquote>
      </section>

      <section class="your-products">
        <h2>Your Products</h2>
        <div class="product-cards">
          <!-- Repeatable Product Cards -->
          <div class="product-card in-stock">
            <div class="image-placeholder"></div>
            <h3>Handwoven Scarf</h3>
            <p>Traditional design with modern colors</p>
            <span>₹1,200</span>
            <div class="rating">⭐⭐⭐⭐☆ (4.5)</div>
          </div>
          <div class="product-card in-stock">
            <div class="image-placeholder"></div>
            <h3>Embroidered Cushion Cover</h3>
            <p>Hand-embroidered floral pattern</p>
            <span>₹850</span>
            <div class="rating">⭐⭐⭐⭐☆ (4.0)</div>
          </div>
          <div class="product-card low-stock">
            <div class="image-placeholder"></div>
            <h3>Handmade Soap Set</h3>
            <p>Natural ingredients, 3 varieties</p>
            <span>₹450</span>
            <div class="rating">⭐⭐⭐⭐⭐ (5.0)</div>
          </div>
          <div class="product-card in-stock">
            <div class="image-placeholder"></div>
            <h3>Jute Handbag</h3>
            <p>Eco-friendly with cotton lining</p>
            <span>₹750</span>
            <div class="rating">⭐⭐⭐⭐☆ (4.2)</div>
          </div>
        </div>
        <button class="view-all-btn">View All Products</button>
      </section>

      <section class="financial-literacy">
        <h2>Financial Literacy Resources</h2>
        <div class="resources">
          <div class="resource-card">Basic Bookkeeping<br><small>Watch video tutorial →</small></div>
          <div class="resource-card">Pricing Your Products<br><small>Read article →</small></div>
          <div class="resource-card">Savings & Investment<br><small>Join webinar →</small></div>
          <div class="resource-card">Government Schemes<br><small>Explore schemes →</small></div>
        </div>
      </section>
    </main>
  </div>

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

</body>
</html>
