<?php
require_once  __DIR__ . "/../config/config.php";


session_start();

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Fetch product with seller name
    $stmt = $conn->prepare("
        SELECT p.*, u.name AS seller_name 
        FROM products p
        JOIN users u ON p.user_id = u.id 
        WHERE p.id = ?
    ");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found.";
        exit;
    }
    $stmt->close();

    // Fetch reviews for product
    $reviews = [];
    $stmt = $conn->prepare("SELECT name, review, rating FROM reviews WHERE product_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
    $stmt->close();
    $stmt = $conn->prepare("SELECT COUNT(*) AS review_count FROM reviews WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$stmt->bind_result($review_count);
$stmt->fetch();
$stmt->close();

// Store in product array if needed
$product['reviews_count'] = $review_count;

    // Stock logic
    $stock = (int)$product['quantity'];
    if ($stock > 10) {
        $stock_class = "in-stock";
        $stock_label = "In stock";
    } elseif ($stock > 0) {
        $stock_class = "low-stock";
        $stock_label = "Low stock";
    } else {
        $stock_class = "out-of-stock";
        $stock_label = "Out of stock";
    }

    // Rating logic
    $displayRating = round(floatval($product['rating']) * 2) / 2;
    $fullStars = floor($displayRating);
    $halfStar = ($displayRating - $fullStars) == 0.5;
    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
    $stars_html = str_repeat("★", $fullStars);
    if ($halfStar) $stars_html .= "½";
    $stars_html .= str_repeat("☆", $emptyStars);

    // Check if user is logged in and bought the product (for review permission)
    $can_review = false;
    $reviewer_name = "";
    if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    $stmt = $conn->prepare("
        SELECT COUNT(*) 
        FROM orders
        WHERE buyer_id = ? AND product_id = ? AND status = 'completed'
    ");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $stmt->bind_result($purchaseCount);
    $stmt->fetch();
    $stmt->close();

    if ($purchaseCount > 0) {
        $can_review = true;
        // Fetch user name for review form if needed
        $stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($reviewer_name);
        $stmt->fetch();
        $stmt->close();
    }
}
} else {
    echo "No product ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Product Details - Sakhi Bazaar</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      background: #f5f5f5;
      color: #333;
    }
    .container {
      max-width: 1200px;
      margin: 30px auto;
      background: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .product-display {
      display: flex;
      gap: 30px;
      flex-wrap: wrap;
    }
    .image-gallery {
      flex: 1;
      min-width: 300px;
      max-width: 500px;
      height: auto;
    }
    .image-gallery img {
      width: 100%;
      height: 400px;
      object-fit: cover;
      border-radius: 10px;
    }
    .product-info {
      flex: 2;
      min-width: 300px;
    }
    .product-info h1 {
      margin: 0;
      font-size: 28px;
    }
    .price {
      font-size: 24px;
      color: #8e24aa;
      margin-top: 10px;
    }
    .shipping {
      font-size: 14px;
      color: #555;
      margin-top: 4px;
    }
    .ratings {
      margin: 10px 0;
    }
    .star {
      color: gold;
    }
    .badge, .dropdown {
      display: inline-block;
      background: #f3e5f5;
      color: #6a1b9a;
      border-radius: 8px;
      padding: 5px 10px;
      margin: 5px 5px 0 0;
      font-size: 14px;
    }
    .section {
      margin-top: 20px;
    }
    .actions button, .view-shop, .wishlist-btn {
      margin-right: 10px;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      background-color: #8e24aa;
      color: white;
      cursor: pointer;
      font-size: 16px;
    }
    .actions button:hover, .view-shop:hover {
      background-color: #6a1b9a;
    }
    .view-shop {
      background: #fff;
      color: #8e24aa;
      border: 2px solid #8e24aa;
      font-size: 14px;
      padding: 6px 14px;
    }
    .view-shop:hover {
      background: #f3e5f5;
      color: #6a1b9a;
    }
    .wishlist-btn {
      background: transparent;
      color: #fff;
      border: 2px solid #8e24aa;
      width: 48px;
      text-align: center;
      font-size: 22px;
      padding: 6px 0;
      transition: background 0.3s, color 0.3s;
    }
    .wishlist-btn.active {
      background: #f3e5f5;
      color: #8e24aa;
    }
    .wishlist-btn:hover {
      background: #8e24aa;
      color: white;
    }
    .seller-info {
      margin-top: 20px;
      font-style: italic;
    }
    .reviews {
      margin-top: 40px;
    }
    .review-card {
      background: #fafafa;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 10px;
      border-left: 4px solid #8e24aa;
    }
    .review-form textarea, .review-form input {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    .review-form button {
      margin-top: 10px;
      padding: 8px 16px;
      background-color: #8e24aa;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    .review-form button:hover {
      background-color: #6a1b9a;
    }
    .stock.in-stock {
      color: green;
      font-weight: bold;
    }
    .stock.low-stock {
      color: orange;
      font-weight: bold;
    }
    .stock.out-of-stock {
      color: red;
      font-weight: bold;
    }
    ul.highlights {
      list-style: disc;
      margin-left: 20px;
    }
    @media (max-width: 768px) {
      .product-display {
        flex-direction: column;
      }
      .actions button, .view-shop {
        width: 100%;
        margin-bottom: 10px;
      }
      .wishlist-btn {
        width: 100%;
        font-size: 24px;
      }
    }
  </style>
</head>



<body>
<div class="container">
    <div class="product-display">
      <div class="image-gallery">
        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="Product Image">
      </div>
      <div class="product-info">
        <h1><?= htmlspecialchars($product['product_name']) ?></h1>
        <div class="price">₹<?= htmlspecialchars($product['price']) ?></div>
       <div class="ratings">
  <span class="star"><?= $stars_html ?></span>
  (<?= htmlspecialchars($product['reviews_count'] ?? '0') ?> reviews)
</div>

        <div class="stock <?= $stock_class ?>">
          <?= $stock_label ?>
        </div>

        <div class="section">
          <strong>Description:</strong>
          <p><?= htmlspecialchars($product['description']) ?></p>
        </div>
        <div class="section">
          <strong>Sizes Available:</strong><br>
          <span class="badge">S</span>
          <span class="badge">M</span>
          <span class="badge">L</span>
          <span class="badge">Free Size</span>
        </div>
        <div class="section">
          <strong>Color:</strong> <?= htmlspecialchars($product['prod-color']) ?><br>
          <strong>Material:</strong> <?= htmlspecialchars($product['material']) ?><br>
        </div>
        <div class="section actions">
          <button>Add to Cart</button>
          <button data-bs-toggle="modal" data-bs-target="#buyNowModal">Buy Now</button>
          <button class="wishlist-btn" aria-label="Add to Wishlist">♡</button>
          <button>🔗 Share</button>
        </div>
        <div class="seller-info">
          Sold by: <strong class="seller-name"><?= htmlspecialchars($product['seller_name']) ?></strong>
        </div>
      </div>
    </div>

    <div class="reviews">
      <h2>Customer Reviews</h2>
      <?php if (count($reviews) > 0): ?>
        <?php foreach ($reviews as $rev): ?>
          <div class="review-card">
            <strong><?= htmlspecialchars($rev['name']) ?> 
              <?php
                $fullStars = floor($rev['rating']);
                $emptyStars = 5 - $fullStars;
                echo str_repeat("★", $fullStars);
                echo str_repeat("☆", $emptyStars);
              ?>
            </strong>
            <p><?= nl2br(htmlspecialchars($rev['review'])) ?></p>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No reviews yet. Be the first to review!</p>
      <?php endif; ?>

      <div class="review-form">
        <h3>Add Your Review</h3>
        <?php if (isset($_SESSION['id'])): ?>
            <?php if ($can_review): ?>
              <form method="POST" action="submit_review.php">
                <input type="hidden" name="product_id" value="<?= $product_id ?>">
                <input type="text" name="name" placeholder="Your Name" required value="<?= htmlspecialchars($reviewer_name) ?>">
                <textarea name="review" placeholder="Write your review here..." required></textarea>
                <input type="number" name="rating" min="1" max="5" placeholder="Rating (1-5)" required>
                <button type="submit">Submit Review</button>
              </form>
            <?php else: ?>
              <p><em>Only verified buyers can submit a review.</em></p>
            <?php endif; ?>
        <?php else: ?>
          <p><a href="login.php">Log in</a> to submit a review.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
    <div class="modal fade" id="buyNowModal" tabindex="-1" aria-labelledby="buyNowModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="review_order.php" method="GET">
          <div class="modal-header">
            <h5 class="modal-title" id="buyNowModalLabel">Select Size & Quantity</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Size:</label>
              <select name="size" class="form-select" required>
                <option value="">-- Select Size --</option>
                <option>S</option>
                <option>M</option>
                <option>L</option>
                <option>Free Size</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Quantity:</label>
              <input type="number" name="quantity" min="1" value="1" class="form-control" required>
            </div>
            <div>
              <p><strong>Price:</strong> ₹1299</p>
              <p><strong>Shipping:</strong> ₹100</p>
              <p><strong>Total:</strong> <strong class="total-price total-text">₹1399</strong></p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Proceed to Buy</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
<script>
    // Wishlist button toggle effect
    const wishlistBtn = document.querySelector('.wishlist-btn');
    wishlistBtn.addEventListener('click', () => {
      wishlistBtn.classList.toggle('active');
      wishlistBtn.textContent = wishlistBtn.classList.contains('active') ? '♥' : '♡';
    });

    // Dynamic total price update in modal
    const pricePerUnit = 1299;
    const shippingFee = 100;

    const quantityInput = document.querySelector('input[name="quantity"]');
    const totalText = document.querySelector('.total-text');
    const form = document.querySelector('#buyNowModal form');
    
    const priceHiddenInput = document.createElement('input');
    priceHiddenInput.type = 'hidden';
    priceHiddenInput.name = 'total';
    form.appendChild(priceHiddenInput);

    function updateTotalPrice() {
      const quantity = parseInt(quantityInput.value) || 1;
      const total = (pricePerUnit * quantity) + shippingFee;
      totalText.textContent = `₹${total}`;
      priceHiddenInput.value = total;
    }

    quantityInput.addEventListener('input', updateTotalPrice);
    updateTotalPrice(); // initial call
  </script>
</body>
</html>


