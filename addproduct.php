
<?php
// DB Connection
require "config.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    // Collect and sanitize data
    $name = $conn->real_escape_string($_POST['prod-name']);
    $category = $conn->real_escape_string($_POST['category']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);
    $order_type = $_POST['order-type'];
    $description = $conn->real_escape_string($_POST['description']);
    $status = ($_POST['action'] === 'publish') ? 'published' : 'draft';

    // Image handling
    $imagePath = null;
    if (!empty($_FILES['prod-img']['name'])) {
        $targetDir = "uploads/";
        $imagePath = $targetDir . basename($_FILES['prod-img']['name']);
        move_uploaded_file($_FILES['prod-img']['tmp_name'], $imagePath);
    }

    // Get user ID (assuming session)
    $user_id = $_SESSION['id']; // Replace with actual session logic

    // Insert query
    $sql = "INSERT INTO products (user_id, product_name, description, price, image_url, quantity, stock_status, order_type, status)
            VALUES ('$user_id', '$name', '$description', '$price', '$imagePath', '$quantity', 'in_stock', '$order_type', '$status')";

    if ($conn->query($sql)) {
    echo "<script>alert('✅ Product added successfully!'); window.location.href = 'addproduct.php';</script>";
} else {
    echo "<script>alert('❌ Error: " . addslashes($conn->error) . "');</script>";
}

}
?>


   
     <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Add Product - Sakhi Bazaar</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(#EDE4F0);
      margin: 0;
      padding: 20px;
    }
    .container {
      max-width: 700px;
      margin: auto;
      background: white;
      padding: 25px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #333;
    }
    .form-section {
      margin-bottom: 25px;
    }
    label {
      display: block;
      margin: 10px 0 5px;
      font-weight: bold;
    }
    input, select, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }
    .form-group i {
      margin-right: 8px;
      color: #555;
    }
    .image-preview {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }
    .image-preview img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border: 1px solid #ddd;
      border-radius: 4px;
    }
    .actions {
      text-align: right;
    }
    .actions button {
      padding: 10px 20px;
      margin-left: 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 14px;
    }

    /* Back Button Styles */
    .mobile-back-button {
      display: none;
      position: fixed;
      top: 15px;
      left: 15px;
      z-index: 999;
      background: #6a0dad; /* replaced var(--purple) */
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
  <button class="mobile-back-button" onclick="goBack()">←</button>
  <div class="container">
    
    <form action="addproduct.php" method="POST" enctype="multipart/form-data">
      <h2>🛍️ Add New Product</h2>

      <!-- 1. Basic Product Info -->
      <div class="form-section">
        <h3>1. Basic Product Info</h3>
        <div class="form-group">
          <label><i class="fas fa-tag"></i>Product Name</label>
          <input type="text" name="prod-name" placeholder="Enter product name" />
        </div>
        <div class="form-group">
          <label><i class="fas fa-list"></i>Category</label>
          <select name="category">
            <option value="">Select Category</option>
            <option value="Clothing">👗 Clothing</option>
            <option value="Accessories">👜 Accessories</option>
            <option value="Handicrafts">🪡 Handicrafts</option>
            <option value="Home Decor">🏠 Home Decor</option>
            <option value="Other">❔ Other</option>
          </select>
        </div>
        <div class="form-group">
          <label><i class="fas fa-rupee-sign"></i>Price</label>
          <input type="number" name="price" placeholder="Enter price in INR" />
        </div>
        <div class="form-group">
          <label><i class="fas fa-boxes"></i>Stock Quantity</label>
          <input type="number" name="quantity" placeholder="Enter available stock" />
        </div>
      </div>

      <div class="form-group">
        <label><i class="fas fa-money-bill-wave"></i>Order Type</label>
        <select name="order-type">
          <option value="">Select Order Type</option>
          <option value="cod">Cash on Delivery</option>
          <option value="request">Order Request</option>
        </select>
      </div>

      <!-- 2. Product Image Upload -->
      <div class="form-section">
        <h3>2. Product Image Upload</h3>
        <input type="file" name="prod-img" accept="image/*" multiple onchange="previewImages(event)" />
        <div class="image-preview" id="imagePreview"></div>
      </div>

      <!-- 3. Product Description -->
      <div class="form-section">
        <h3>3. Product Description</h3>
        <textarea name="description" rows="4" placeholder="Write a short description..."></textarea>
      </div>

      <!-- 4. Actions -->
      <div class="actions form-section">
        <button type="submit" name="action" value="draft" style="background-color: #7e22ce; color: white;">
          Save as Draft
        </button>
        <button type="submit" name="action" value="publish" style="background-color: #ffc107; color: black;">
          Publish Product
        </button>
      </div>
    </form>
  </div>
  <script>
         function previewImages(event) {
           const preview = document.getElementById('imagePreview');
           preview.innerHTML = '';
           const files = event.target.files;
           if (files.length > 3) {
             alert("You can upload up to 3 images.");
             return;
           }
           for (let i = 0; i < files.length; i++) {
             const img = document.createElement("img");
             img.src = URL.createObjectURL(files[i]);
             preview.appendChild(img);
           }
         }
             function goBack() {
      if (document.referrer) {
        window.history.back();
      } else {
        window.location.href = 'seller_dashboard2.php'; // fallback page if no history
      }
    }
       </script>
     </body>
     </html>
     