<?php
require_once  __DIR__ . "/../config/config.php";
session_start();

$user_id = $_SESSION['id'];

$sql = "SELECT id, product_name, description, price, quantity, image_url, rating FROM products WHERE user_id = $user_id ORDER BY id DESC";
$result = $conn->query($sql);

$products = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Your Products</title>
  <style>
    /* Your existing CSS here */
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(#EDE4F0, #ffffff);
    }
    .your-products {
      padding: 20px;
    }
    .your-products h2 {
      margin: 20px 0;
      text-align: center;
      font-size: 2rem;
    }
    .product-cards {
      display: grid;
      grid-template-columns: 1fr;
      gap: 20px;
      padding: 20px;
      max-width: 1000px;
      margin: 0 auto;
    }
    @media (min-width: 600px) {
      .product-cards {
        grid-template-columns: repeat(2, 1fr);
      }
    }
    @media (min-width: 1000px) {
      .product-cards {
        grid-template-columns: repeat(3, 1fr);
      }
    }
    .product-card {
      background: #fff;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s, box-shadow 0.3s;
      text-align: center;
    }
    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }
    .image-placeholder {
      width: 100%;
      height: 150px;
      background: #e5e5e5;
      border-radius: 10px;
      margin-bottom: 10px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .product-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 10px;
    }
    .in-stock {
      border: 2px solid green;
      background-color: #e6ffed;
    }
    .low-stock {
      border: 2px solid #ffc107;
      background-color: #fff8e1;
    }
    .out-of-stock {
      border: 2px solid #dc3545;
      background-color: #f8d7da;
    }
    .product-description {
      font-size: 0.9rem;
      color: #555;
      margin-bottom: 8px;
    }
    .rating {
      margin-top: 10px;
      font-size: 14px;
    }
    h3 {
      margin: 10px 0 5px;
    }
    .mobile-back-button {
      display: none;
      position: fixed;
      top: 15px;
      left: 15px;
      z-index: 999;
      background: #6a0dad;
      color: white;
      border: none;
      border-radius: 6px;
      padding: 10px 16px;
      font-size: 1rem;
      cursor: pointer;
      box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }
    .mobile-back-button:hover {
      background: #4b0082;
    }
    @media (max-width: 768px) {
      .mobile-back-button {
        display: block;
      }
    }
  </style>
</head>
<body>
  <button class="mobile-back-button" onclick="history.back()">←</button>

  <section class="your-products"> 
    <h2>Your Products</h2>
    
    <div class="product-cards">
      <?php if (count($products) > 0): ?>
        <?php foreach ($products as $product): ?>
          <?php
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

            $rating = round(floatval($product['rating']) * 2) / 2;
            $fullStars = floor($rating);
            $halfStar = ($rating - $fullStars) == 0.5;
            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

            $stars_html = str_repeat("⭐", $fullStars);
            if ($halfStar) $stars_html .= "✰";
            $stars_html .= str_repeat("☆", $emptyStars);

            $image_url = !empty($product['image_url']) ? htmlspecialchars($product['image_url']) : "https://via.placeholder.com/150?text=No+Image";

            $name = htmlspecialchars($product['product_name']);
            $description = htmlspecialchars($product['description']);
            $price = number_format(floatval($product['price']), 2);
          ?>
          <a href="edit_prod.php?id=<?= $product['id'] ?>" style="text-decoration:none; color:inherit; display:block;">
  <div class="product-card <?= $stock_class ?>">

            <div class="image-placeholder">
              <img src="<?= $image_url ?>" alt="<?= $name ?>">
            </div>
            <h3><?= $name ?></h3>
            <p class="product-description"><?= $description ?></p>
            <p>Stock: <?= $stock ?> | <?= $stock_label ?></p>
            <span>₹<?= $price ?></span>
            <div class="rating"><?= $stars_html ?> (<?= $rating ?>)</div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p style="text-align:center;">No products found for your account.</p>
      <?php endif; ?>
    </div>
      </a>
  </section>
   <script src = "js/script.js"></script>
</body>
</html>   
<?php require_once 'partials/footer.php'; ?>