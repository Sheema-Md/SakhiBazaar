<?php 
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== 'seller') {
    header("Location:../login.php");
    exit();
}
require_once  __DIR__ . "/../config/config.php";




require_once 'models/SellerModel.php';
$user_id = $_SESSION['id'];

// or however you get the seller id
$sellerModel = new SellerModel($conn);
$data = [
    'name' => $sellerModel->getSellerName($user_id),];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SakhiBazaar Finance & Literacy</title>
  <style>
      /* Container styling and grid layout */
      
      .financial-resources {
       
        
        border-radius: 12px;
      }
    
      .financial-resources h2 {
        margin-bottom: 30px;
        font-size: 2rem;
        color: #4b007b; /* darker purple for heading */
        text-align: center;
      }
    
      .resources {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
      }
    
      /* Resource card styling */
      .resource-card {
        background: #faf8ff; /* very light purple */
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 3px 12px rgb(0 0 0 / 0.08);
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        transition: box-shadow 0.3s ease, transform 0.3s ease;
        cursor: pointer;
      }
      .resource-card:hover {
        box-shadow: 0 6px 24px rgb(0 0 0 / 0.15);
        transform: translateY(-5px);
      }
    
      .resource-card .image-placeholder {
        margin-bottom: 16px;
        color: #7e22ce; /* purple shade */
      }
    
      .resource-card h3 {
        margin: 0 0 12px 0;
        font-size: 1.3rem;
        color: #5b1696;
      }
    
      .resource-card p {
        flex-grow: 1;
        font-size: 1rem;
        color: #3a3054;
        margin-bottom: 20px;
        line-height: 1.4;
      }
    
      .view-all-btn {
        align-self: flex-start;
        text-decoration: none;
        background-color: #7e22ce;
        color: white;
        padding: 10px 18px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 1rem;
        transition: background-color 0.3s ease;
      }
    
      .view-all-btn:hover {
        background-color: #5b1696;
      }
    
      /* Responsive adjustments */
      @media (max-width: 1024px) {
        .resources {
          grid-template-columns: repeat(2, 1fr);
        }
      }
    
      @media (max-width: 600px) {
        .resources {
          grid-template-columns: 1fr;
        }
      }
    </style>

<main class="finance-content">
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
<!-- Include Font Awesome in your <head> if not already present -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    
    
    <!-- Financial Literacy & Safety Resources Section -->
    <section class="financial-resources">
      <h2>Financial Literacy &amp; Safety Resources</h2>
      <div class="resources">
    
        <div class="resource-card">
          <div class="image-placeholder">
            <i class="fas fa-wallet fa-2x"></i>
          </div>
          <h3>Digital Payments</h3>
          <p>Learn how to use digital wallets and UPI safely for business transactions.</p>
          <a href="finance-literacy/digital-payments.php" class="view-all-btn">Watch tutorial</a>
        </div>
    
        <div class="resource-card">
          <div class="image-placeholder">
            <i class="fas fa-book-open fa-2x"></i>
          </div>
          <h3>Bookkeeping Basics</h3>
          <p>Understand the fundamentals of tracking income, expenses, and profits.</p>
          <a href="finance-literacy/bookkeeping.php" class="view-all-btn">Start learning</a>
        </div>
    
        <div class="resource-card">
          <div class="image-placeholder">
            <i class="fas fa-shield-alt fa-2x"></i>
          </div>
          <h3>Cybersecurity Tips</h3>
          <p>Protect your devices and accounts from fraud and cyber threats.</p>
          <a href="finance-literacy/cybersecurity-tips.php" class="view-all-btn">Explore safety tips</a>
        </div>
    
        <div class="resource-card">
          <div class="image-placeholder">
            <i class="fas fa-chart-pie fa-2x"></i>
          </div>
          <h3>Smart Budgeting</h3>
          <p>Discover techniques to manage your finances effectively and plan ahead.</p>
          <a href="finance-literacy/smart-budgeting.php" class="view-all-btn">Read article</a>
        </div>
    
        <div class="resource-card">
          <div class="image-placeholder">
            <i class="fas fa-hand-holding-usd fa-2x"></i>
          </div>
          <h3>Access to Loans</h3>
          <p>Explore different types of loans available for small businesses and how to apply.</p>
          <a href="finance-literacy/access-to-loans.php" class="view-all-btn">View details</a>
        </div>
    
        <div class="resource-card">
          <div class="image-placeholder">
            <i class="fas fa-landmark fa-2x"></i>
          </div>
          <h3>Government Schemes</h3>
          <p>Learn about government support schemes tailored for women entrepreneurs.</p>
          <a href="finance-literacy/government-schemes.php" class="view-all-btn">See schemes</a>
        </div>
    
      </div>
    </section>
     <script src = "js/script.js"></script>
     <?php require_once 'partials/footer.php'; ?>