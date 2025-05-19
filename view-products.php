<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Your Products</title>
  <style>
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
      display: flex;
      flex-direction: column;
      gap: 20px;
      padding: 20px;
      max-width: 600px;
      margin: 0 auto;
      transition: all 0.3s ease;
    }

    body.responsive .product-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      max-width: 100%;
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

    /* Toggle Button Style */
    .toggle-button {
      display: block;
      width: 200px;
      margin: 20px auto 0;
      padding: 10px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }

    .toggle-button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<section class="your-products"> 
  <h2>Your Products</h2>
  <div class="product-cards">

    <!-- Product 1 -->
    <div class="product-card in-stock">
      <div class="image-placeholder">
        <img src="https://via.placeholder.com/150" alt="Sample Product">
      </div>
      <h3>Sample Product 1</h3>
      <p class="product-description">This is a great product with high quality.</p>
      <p>Stock: 25 | In stock</p>
      <span>₹499.00</span>
      <div class="rating">⭐⭐⭐⭐☆ (4.2)</div>
    </div>

    <!-- Product 2 -->
    <div class="product-card low-stock">
      <div class="image-placeholder">
        <img src="https://via.placeholder.com/150" alt="Another Product">
      </div>
      <h3>Sample Product 2</h3>
      <p class="product-description">Limited stock available. Hurry up!</p>
      <p>Stock: 3 | Low stock</p>
      <span>₹299.00</span>
      <div class="rating">⭐⭐⭐☆ (3.5)</div>
    </div>

    <!-- Product 3 -->
    <div class="product-card out-of-stock">
      <div class="image-placeholder">
        <div style="background:#eee;width:100%;height:100%;"></div>
      </div>
      <h3>Sample Product 3</h3>
      <p class="product-description">Currently unavailable. Restocking soon.</p>
      <p>Stock: 0 | Out of stock</p>
      <span>₹199.00</span>
      <div class="rating">⭐⭐☆☆☆ (2.0)</div>
    </div>

    <!-- Product 4 -->
    <div class="product-card in-stock">
      <div class="image-placeholder">
        <img src="https://via.placeholder.com/150/00FF00/FFFFFF?text=Product+4" alt="Product 4">
      </div>
      <h3>Wireless Earbuds</h3>
      <p class="product-description">Compact and stylish wireless earbuds with great sound.</p>
      <p>Stock: 40 | In stock</p>
      <span>₹1,299.00</span>
      <div class="rating">⭐⭐⭐⭐⭐ (4.8)</div>
    </div>

    <!-- Product 5 -->
    <div class="product-card low-stock">
      <div class="image-placeholder">
        <img src="https://via.placeholder.com/150/FFA500/FFFFFF?text=Product+5" alt="Product 5">
      </div>
      <h3>Bluetooth Speaker</h3>
      <p class="product-description">High bass portable speaker. Limited stock left!</p>
      <p>Stock: 5 | Low stock</p>
      <span>₹799.00</span>
      <div class="rating">⭐⭐⭐⭐ (4.0)</div>
    </div>

    <!-- Product 6 -->
    <div class="product-card out-of-stock">
      <div class="image-placeholder">
        <img src="https://via.placeholder.com/150/FF0000/FFFFFF?text=Product+6" alt="Product 6">
      </div>
      <h3>Gaming Mouse</h3>
      <p class="product-description">Ergonomic gaming mouse with RGB lighting.</p>
      <p>Stock: 0 | Out of stock</p>
      <span>₹599.00</span>
      <div class="rating">⭐⭐⭐☆☆ (3.0)</div>
    </div>

  </div>

  <!-- Responsive Toggle Button -->
  <button class="toggle-button" onclick="toggleResponsive()">Toggle Responsive Mode</button>
</section>

<script>
  function toggleResponsive() {
    document.body.classList.toggle("responsive");
  }
</script>

</body>
</html>
