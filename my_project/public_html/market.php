<?php 
require_once __DIR__ . '/../config/config.php'; 

$category = $_GET['category'] ?? '';
$minPrice = $_GET['minPrice'] ?? 0;
$maxPrice = $_GET['maxPrice'] ?? 99999;
$rating = $_GET['rating'] ?? 0;
$size = $_GET['size'] ?? '';
$material = $_GET['material'] ?? '';
$color = $_GET['color'] ?? '';

$where = "WHERE price BETWEEN " . (int)$minPrice . " AND " . (int)$maxPrice . " AND rating >= " . (float)$rating;
$categories = ['👗 Clothing', 'Accessories', 'Handicrafts', 'Home Decor']; // These should ideally come from your DB if dynamic

if (!empty($category) && $category !== 'All') {
    $category = $conn->real_escape_string($category);
    $where .= " AND category = '$category'";
}

if (!empty($size)) {
    $size = $conn->real_escape_string($size);
    $where .= " AND `prod-size` = '$size'";
}

if (!empty($material)) {
    $material = $conn->real_escape_string($material);
    $where .= " AND material = '$material'";
}
if (!empty($color)) {
    $color = $conn->real_escape_string($color);
    $where .= " AND `prod-color` = '$color'";
}

$sql = "SELECT * FROM products $where";
$result = $conn->query($sql);

$availableFilters = ['size' => [], 'material' => [], 'color' => []];

// Fetch available filter options dynamically based on the current category
if (!empty($category) && $category !== 'All') {
    // Get available sizes for the selected category
    $sizeQuery = $conn->query("SELECT DISTINCT `prod-size` FROM products WHERE category = '$category' AND `prod-size` IS NOT NULL");
    if ($sizeQuery && $sizeQuery->num_rows > 0) {
        while ($row = $sizeQuery->fetch_assoc()) {
            $availableFilters['size'][] = $row['prod-size'];
        }
    }

    // Get available materials for the selected category
    $materialQuery = $conn->query("SELECT DISTINCT material FROM products WHERE category = '$category' AND material IS NOT NULL");
    if ($materialQuery && $materialQuery->num_rows > 0) {
        while ($row = $materialQuery->fetch_assoc()) {
            $availableFilters['material'][] = $row['material'];
        }
    }
    // Get available colors for the selected category
    $colorQuery = $conn->query("SELECT DISTINCT `prod-color` FROM products WHERE category = '$category' AND `prod-color` IS NOT NULL");
    if ($colorQuery && $colorQuery->num_rows > 0) {
        while ($row = $colorQuery->fetch_assoc()) {
            $availableFilters['color'][] = $row['prod-color'];
        }
    }
}
// Sort filter options for consistent display
foreach ($availableFilters as $key => $value) {
    sort($availableFilters[$key]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Sakhi Bazaar - Responsive Filters</title>
<link rel="stylesheet" href="css/sell_dash_style.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
 
<style>
    body {
        margin: 0; font-family: Arial, sans-serif; background:linear-gradient(#EDE4F0);
    }
    header {
        background-color: linear-gradient(#EDE4F0);
        color: black;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        max-width: 1200px;
        margin: auto;
        width: 100%;
    }
    .header-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 16px;
    }
    .search-container {
        display: flex; align-items: center; background: white;
        padding: 5px; border-radius: 5px;
        width: 100%; max-width: 700px; flex-grow: 1; min-width: 250px;
    }
    .search-container input {
        border: none; outline: none; padding: 8px; flex: 1;
    }
    .search-container i {
        color: gray; padding: 0 10px; cursor: pointer;
    }
    .icons {
        display: flex;
        gap: 20px;
        font-size: 18px;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
    }
    .market-content {
        display: flex; padding: 20px; gap: 20px; flex-wrap: wrap;
    }
    .sidebar-container {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }
    .content-wrapper {
        display: flex;
        gap: 20px;
        flex-wrap: nowrap;
    }
    .filter-sidebar {
        width: 250px;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1); /* Changed from #EDE4F0 to a proper shadow */
        flex-shrink: 0;
        height: fit-content;
    }
    .products-section {
        flex: 1;
        min-width: 300px;
    }
    .filter-group {
        margin-bottom: 20px;
    }
    .filter-group select, .filter-group input {
        background-color: #f9f9f9;
        border: 1px solid #aaa;
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border-radius: 5px;
        box-sizing: border-box;
    }
    .filter-group label {
        font-weight: bold; display: block; margin-bottom: 5px;
        font-size: 14px;
        color: #333;
    }
    .filter-actions {
        display: flex; justify-content: flex-start; gap: 10px;
    }
    .filter-actions button {
        padding: 8px 16px; cursor: pointer; border: none;
        border-radius: 4px; color: white; font-weight: bold;
    }
    .filter-actions button:first-child {
        background-color: #ccc; color: #333;
    }
    .filter-actions button:last-child {
        background-color: #4b0082;
    }
    h2 {
        margin-top: 0; margin-bottom: 15px; color: #333;
    }
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 20px;
    }
    .product-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        text-align: center;
        background: #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        display: flex; /* Make it a flex container */
        flex-direction: column; /* Stack children vertically */
        justify-content: space-between; /* Push buttons to bottom */
        height: 100%; /* Ensure cards are same height */
    }
    .product-card img {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
        margin-bottom: 10px;
    }
    .product-card h3 {
        font-size: 1.1em;
        margin: 5px 0;
        color: #333;
    }
    .product-card p {
        font-size: 0.9em;
        color: #666;
        margin: 5px 0;
    }
    .product-card span {
        font-size: 1.2em;
        font-weight: bold;
        color: #4b0082;
        margin-bottom: 10px;
        display: block; /* Ensure price is on its own line */
    }
    .product-card .rating {
        color: gold; /* Or a suitable color for stars */
        margin-bottom: 10px;
    }
    .product-buttons {
        display: flex; justify-content: center; gap: 10px;
        margin-top: auto; /* Push buttons to the bottom of the card */
    }
    .product-card button {
        padding: 5px 10px;
        border: none; border-radius: 4px;
        background-color: #4b0082;
        color: white; cursor: pointer;
        flex-shrink: 0;
        font-size: 0.9em;
    }
    .product-card button.wishlist {
        background-color: #e91e63;
        margin-left: 5px;
    }

    #filterToggleBtn {
        display: none;
        background-color: #4b0082;
        color: white;
        border: none;
        padding: 12px 20px;
        cursor: pointer;
        font-weight: bold;
        width: 100%;
        margin: 10px 0;
        border-radius: 5px;
    }
    #mobileFilterWrapper {
        display: none;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: all 0.3s ease-in-out;
    }
    #mobileFilterWrapper.active {
        display: block;
    }
    .filter-group select,
    .filter-group input {
        font-size: 14px;
    }
    @media (max-width: 768px) {
        .market-content {
            flex-direction: column;
            padding: 10px;
        }
        .filter-sidebar {
            display: none;
        }
        #filterToggleBtn {
            display: block;
        }
        .products-section {
            min-width: 100%;
        }
        .filter-group {
            margin-bottom: 15px;
        }
        #mobileFilterWrapper {
            display: none;
            margin-bottom: 10px;
        }
        #mobileFilterWrapper.active {
            display: block;
        }
    }
</style>
</head>
<body>
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

    <div class="market-content" data-filter-data='<?php echo htmlspecialchars(json_encode($availableFilters), ENT_QUOTES, 'UTF-8'); ?>'>
        
        <div class="content-wrapper">
            <aside class="filter-sidebar" id="filterSidebar">
                <h3>Filters</h3>
                <div class="filter-group">
                    <label for="categoryFilter">
                        <i class="fas fa-tags"></i> Category:
                        <select id="categoryFilter" onchange="applyFilters()">
                            <option value="All">All</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= htmlspecialchars($cat) ?>" <?= ($category == $cat) ? 'selected' : '' ?>><?= htmlspecialchars($cat) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>

               <?php foreach (['size', 'material', 'color'] as $filter): ?>
    <?php if (!empty($availableFilters[$filter])): ?>
        <div class="filter-group">
            <label for="<?= $filter ?>Filter"><i class="fas fa-filter"></i> <?= ucfirst($filter) ?>:</label>
            <select id="<?= $filter ?>Filter" onchange="applyFilters()">
                <option value="">All</option>
                <?php foreach ($availableFilters[$filter] as $option): ?>
                    <option value="<?= htmlspecialchars($option) ?>" <?= ($$filter == $option) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($option) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endif; ?>
<?php endforeach; ?>


                <div class="filter-group">
                    <label for="ratingFilter"><i class="fas fa-star"></i> Rating:</label>
                    <select name="rating" id="ratingFilter">
                        <option value="0">All Ratings</option>
                        <?php for ($i = 1; $i <= 4; $i++): ?>
                            <option value="<?= $i ?>" <?= ($rating == $i) ? 'selected' : '' ?>><?= $i ?>★ & up</option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="minPrice"><i class="fas fa-dollar-sign"></i> Price:</label>
                    <input type="number" name="minPrice" id="minPrice" value="<?= htmlspecialchars($minPrice) ?>" placeholder="Min">
                    <span>-</span>
                    <input type="number" name="maxPrice" id="maxPrice" value="<?= htmlspecialchars($maxPrice) ?>" placeholder="Max">
                </div>

                <div class="filter-actions">
                    <button type="button" onclick="clearFilters()">Clear</button>
                    <button type="button" onclick="applyFilters()"><i class="fas fa-filter"></i> Apply Filters</button>
                </div>
            </aside>
        </div>

        <div id="mobileFilterWrapper">
            <h3>Filters</h3>
            <div class="filter-group">
                <label for="categoryFilterMobile"><i class="fas fa-tags"></i> Category</label>
                <select id="categoryFilterMobile" onchange="updateFilterOptions('mobile')">
                    <option value="All">All</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat) ?>" <?= ($category == $cat) ? 'selected' : '' ?>><?= htmlspecialchars($cat) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group" id="dynamicFiltersMobile"></div>

            <div class="filter-group">
                <label for="minPriceMobile"><i class="fas fa-dollar-sign"></i> Price Range (₹)</label>
                <input type="number" id="minPriceMobile" placeholder="Min" min="0" value="<?= htmlspecialchars($minPrice) ?>" />
                <input type="number" id="maxPriceMobile" placeholder="Max" min="0" value="<?= htmlspecialchars($maxPrice) ?>" />
            </div>

            <div class="filter-group">
                <label for="ratingFilterMobile"><i class="fas fa-star"></i> Rating</label>
                <select id="ratingFilterMobile">
                    <option value="0">All</option>
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                        <option value="<?= $i ?>" <?= ($rating == $i) ? 'selected' : '' ?>><?= $i ?>★ & above</option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="filter-actions">
                <button onclick="clearFiltersMobile()">Clear</button>
                <button onclick="applyFiltersMobile()">Done</button>
            </div>
        </div>

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
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($product = $result->fetch_assoc()): ?>
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

                            $displayRating = round(floatval($product['rating']) * 2) / 2;
                            $fullStars = floor($displayRating);
                            $halfStar = ($displayRating - $fullStars) == 0.5;
                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

                            $stars_html = str_repeat("⭐", $fullStars);
                            if ($halfStar) $stars_html .= "½"; // Using half-star character
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
                                <p>Stock: <?= $stock ?> | <span class="<?= $stock_class ?>"><?= $stock_label ?></span></p>
                                <span>₹<?= $price ?></span>
                                <div class="rating"><?= $stars_html ?> (<?= $displayRating ?>)</div>
                            </a>
                            <div class="product-buttons">
                                <button>Add to Cart</button>
                                <button class="wishlist" title="Add to Wishlist">&#9825;</button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="text-align:center; width: 100%;">No products found matching your filters.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>

  
</body>
</html>