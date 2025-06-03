<?php include "functions.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Sakhi Bazaar - MarketPlace</title>
<link rel="stylesheet" href="css/sell_dash_style.css"/>
<link rel="stylesheet" href="css/market.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body>
 
   <!-- Link to the javascript file -->
   
  
    <div class="header-container">
    <header>
        <div class="search-container">
            <input type="text" id="searchBox" placeholder="Search products..." />
            <i class="fas fa-camera" title="Search by camera"></i>
            <i class="fas fa-search" onclick="searchProducts()" title="Search"></i>
        </div>
        <div class="icons">
            <i class="fas fa-heart" title="Wishlist"></i>
            <i class="fas fa-shopping-cart" title="Cart"></i>
        </div>
    </header>
</div>

<button id="filterToggleBtn" onclick="toggleMobileFilters()">Show Filters &#x25BC;</button>

<div class="market-content">
    <div class="content-wrapper">
        
        <aside class="filter-sidebar" id="filterSidebar">
            <h3>Filters</h3>

            <div class="filter-group">
                <label for="categoryFilter">
                    <i class="fas fa-tags"></i> Category:
                    <select id="categoryFilter" name="category">
                        <option value="All">All</option>
                        <option value="Clothing">Clothing</option>
                        <option value="Home Decor">Home Decor</option>
                        <option value="Accessories">Accessories</option>
                        <option value="Handicrafts">Handicrafts</option>
                    </select>
                </label>
            </div>

            <div class="filter-group">
                <label for="sizeFilter"><i class="fas fa-filter"></i> Size:</label>
                <select id="sizeFilter" name="size">
                    <option value="">All</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="Free Size">Free Size</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="materialFilter"><i class="fas fa-filter"></i> Material:</label>
                <select id="materialFilter" name="material">
                    <option value="">All</option>
                    <option value="Silk">Silk</option>
                    <option value="Jute">Jute</option>
                    <option value="Clay">Clay</option>
                    <option value="Silver">Silver</option>
                    <option value="Gold">Gold</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="colorFilter"><i class="fas fa-filter"></i> Color:</label>
                <select id="colorFilter" name="color">
                    <option value="">All</option>
                    <option value="Red">Red</option>
                    <option value="Blue">Blue</option>
                    <option value="Black">Black</option>
                    <option value="White">White</option>
                    <option value="Multi">Multi</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="ratingFilter"><i class="fas fa-star"></i> Rating:</label>
                <select name="rating" id="rating">
                    <option value="0">All Ratings</option>
                    <option value="1">1★ & up</option>
                    <option value="2">2★ & up</option>
                    <option value="3">3★ & up</option>
                    <option value="4">4★ & up</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="minPrice"><i class="fas fa-dollar-sign"></i> Price:</label>
                <input type="number" name="minPrice" id="minPrice" placeholder="Min">
                <span>-</span>
                <input type="number" name="maxPrice" id="maxPrice" placeholder="Max">
            </div>
        </aside>
    </div>  
   <!-- end of #mobileFilterWrapper -->
 <section class="products-section">
  <h2>🎉 Daily Deals</h2>
  <div class="product-grid" id="dailyDeals">
    <div class="product-card" data-category="Clothing" data-price="499" data-rating="4">
      <a href="prod.php?id=daily-deal-1" style="text-decoration:none; color:inherit; display:block;">
        <img src="https://images.unsplash.com/photo-1618354691210-2f4a22ab10c6?auto=format&fit=crop&w=150&q=80" alt="Silk Kurti" />
        <h3>Silk Kurti</h3>
        <p><strong>₹499</strong></p>
        <div class="rating">⭐⭐⭐⭐ (4.0)</div>
      </a>
      <div class="product-buttons">
        <button>Add to Cart</button>
        <button class="wishlist" title="Add to Wishlist">&#9825;</button>
      </div>
    </div>
  </div>
<h2>💼 Products For You</h2>
<div class="product-grid" id="productList">
  <?php 
  $products = getAllProducts();
  foreach ($products as $product): 
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

    $displayRating = round(floatval($product['rating']) * 2) / 2;
    $fullStars = floor($displayRating);
    $halfStar = ($displayRating - $fullStars) == 0.5;
    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

    $stars_html = str_repeat("⭐", $fullStars);
    if ($halfStar) $stars_html .= "½";
    $stars_html .= str_repeat("☆", $emptyStars);

    $image_url = !empty($product['image_url']) ? htmlspecialchars($product['image_url']) : "images/placeholder.png";
    $name = htmlspecialchars($product['product_name']);
    $price = number_format(floatval($product['price']), 2);
  ?>
    <div class="product-card">
      <a href="prod.php?id=<?= htmlspecialchars($product['id']) ?>" style="text-decoration:none; color:inherit; display:block;">
        <div class="image-placeholder">
          <img src="<?= $image_url ?>" alt="<?= $name ?>">
        </div>
        <h3><?= $name ?></h3>
        
        
        <div class="stock-label <?= $stock_class ?>"><?= $stock_label ?></div>
        <p><strong>₹<?= $price ?></strong></p>
        <div class="rating"><?= $stars_html ?> (<?= $displayRating ?>)</div>
      </a>
      <div class="product-buttons">
        <button>Add to Cart</button>
        <button class="wishlist" title="Add to Wishlist">&#9825;</button>
      </div>
    </div>
  <?php endforeach; ?>
</div>

  </section>

<script src="market.js"></script> 
</body>
</html>