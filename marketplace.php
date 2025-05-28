<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Sakhi Bazaar - Responsive Filters</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<style>
  body {
    margin: 0; font-family: Arial, sans-serif; background: #f8f8f8;
  }
  header {
    background-color: #4b0082; color: white;
    padding: 15px 20px;
    display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;
  }
  .logo {
    font-size: 24px; font-weight: bold; flex-shrink: 0;
  }
  .search-container {
    display: flex; align-items: center; background: white;
    padding: 5px; border-radius: 5px;
    width: 100%; max-width: 500px; flex-grow: 1; min-width: 250px;
  }
  .search-container input {
    border: none; outline: none; padding: 8px; flex: 1;
  }
  .search-container i {
    color: gray; padding: 0 10px; cursor: pointer;
  }
  .icons {
    display: flex; gap: 20px; font-size: 18px; flex-shrink: 0;
  }
  .main-content {
    display: flex; padding: 20px; gap: 20px; flex-wrap: wrap;
  }
  /* Filter Sidebar - Desktop */
  .filter-sidebar {
    width: 250px;
    background: #fff; padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
    flex-shrink: 0;
    height: fit-content;
  }
  .filter-group {
    margin-bottom: 15px;
  }
  .filter-group label {
    font-weight: bold; display: block; margin-bottom: 5px;
  }
  .filter-group input,
  .filter-group select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc; border-radius: 5px;
    box-sizing: border-box;
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
  /* Products */
  .products-section {
    flex: 1; min-width: 300px;
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
    background: #fff; padding: 10px; border-radius: 8px;
    text-align: center;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
    display: flex; flex-direction: column; justify-content: space-between;
  }
  .product-card img {
    width: 100%; max-height: 130px; object-fit: cover;
    border-radius: 6px; margin-bottom: 10px;
  }
  .product-buttons {
    display: flex; justify-content: center; gap: 10px;
  }
  .product-card button {
    margin-top: 5px;
    padding: 5px 10px;
    border: none; border-radius: 4px;
    background-color: #4b0082;
    color: white; cursor: pointer;
    flex-shrink: 0;
  }
  .product-card button.wishlist {
    background-color: #e91e63;
    margin-left: 5px;
  }
  /* MOBILE: Entire filter sidebar shown top and toggled */
  #mobileFilterWrapper {
    display: none;
    background: #fff;
    padding: 15px 20px;
    border-radius: 0 0 8px 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  }
  #filterToggleBtn {
    display: none;
    background-color: #4b0082;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 0;
    cursor: pointer;
    font-weight: bold;
    width: 100%;
    margin-bottom: 10px;
  }
  @media (max-width: 768px) {
    .main-content {
      flex-direction: column;
      padding: 10px;
    }
    .filter-sidebar {
      display: none;
    }
    #filterToggleBtn {
      display: block;
    }
    #mobileFilterWrapper {
      display: none;
      margin-bottom: 10px;
    }
    #mobileFilterWrapper.active {
      display: block;
    }
    .products-section {
      min-width: 100%;
    }
  }
</style>
</head>
<body>

<header>
  <div class="logo">Sakhi Bazaar</div>
  <div class="search-container">
    <input type="text" id="searchBox" placeholder="Search products..." />
    <i class="fas fa-camera" title="Search by camera"></i>
    <i class="fas fa-search" onclick="searchProducts()" title="Search"></i>
  </div>
  <div class="icons">
    <i class="fas fa-heart" title="Wishlist"></i>
    <i class="fas fa-shopping-cart" title="Cart"></i>
    <i class="fas fa-bell" title="Notifications"></i>
  </div>
</header>

<button id="filterToggleBtn" onclick="toggleMobileFilters()">Show Filters &#x25BC;</button>

<div class="main-content">

  <!-- Desktop Sidebar -->
  <aside class="filter-sidebar" id="filterSidebar">
    <h3>Filters</h3>
    <div class="filter-group">
      <label for="categoryFilter">Category</label>
      <select id="categoryFilter" onchange="updateFilterOptions('desktop')">
        <option value="All">All</option>
        <option value="Clothing">Clothing</option>
        <option value="Accessories">Accessories</option>
        <option value="Handicrafts">Handicrafts</option>
        <option value="Home Decor">Home Decor</option>
      </select>
    </div>

    <div class="filter-group" id="dynamicFiltersDesktop">
      <!-- Dynamic filters for desktop here -->
    </div>

    <div class="filter-group">
      <label>Price Range (₹)</label>
      <input type="number" id="minPrice" placeholder="Min" min="0" />
      <input type="number" id="maxPrice" placeholder="Max" min="0" style="margin-top:5px;" />
    </div>

    <div class="filter-group">
      <label for="ratingFilter">Rating</label>
      <select id="ratingFilter">
        <option value="0">All</option>
        <option value="4">4★ & above</option>
        <option value="3">3★ & above</option>
      </select>
    </div>

    <div class="filter-actions">
      <button onclick="clearFilters()">Clear</button>
      <button onclick="applyFilters()">Done</button>
    </div>
  </aside>

  <!-- Mobile Filter Wrapper: same filters as desktop but with unique IDs -->
  <div id="mobileFilterWrapper">
    <h3>Filters</h3>
    <div class="filter-group">
      <label for="categoryFilterMobile">Category</label>
      <select id="categoryFilterMobile" onchange="updateFilterOptions('mobile')">
        <option value="All">All</option>
        <option value="Clothing">Clothing</option>
        <option value="Accessories">Accessories</option>
        <option value="Handicrafts">Handicrafts</option>
        <option value="Home Decor">Home Decor</option>
      </select>
    </div>

    <div class="filter-group" id="dynamicFiltersMobile">
      <!-- Dynamic filters for mobile here -->
    </div>

    <div class="filter-group">
      <label>Price Range (₹)</label>
      <input type="number" id="minPriceMobile" placeholder="Min" min="0" />
      <input type="number" id="maxPriceMobile" placeholder="Max" min="0" style="margin-top:5px;" />
    </div>

    <div class="filter-group">
      <label for="ratingFilterMobile">Rating</label>
      <select id="ratingFilterMobile">
        <option value="0">All</option>
        <option value="4">4★ & above</option>
        <option value="3">3★ & above</option>
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
        <img src="https://images.unsplash.com/photo-1618354691210-2f4a22ab10c6?auto=format&fit=crop&w=150&q=80" alt="Silk Kurti" />
        <p>Silk Kurti</p>
        <p><strong>₹499</strong></p>
        <div class="product-buttons">
          <button>Add to Cart</button>
          <button class="wishlist" title="Add to Wishlist">&#9825;</button>
        </div>
      </div>
      <!-- Add more daily deal products as needed -->
    </div>

    <h2>💼 Products For You</h2>
    <div class="product-grid" id="productList">
      <div class="product-card" data-category="Accessories" data-price="199" data-rating="5" data-size="Small" data-fabric="Cotton" data-material="Gold" data-shape="Round" data-color="Red" data-craft="Embroidery" data-technique="Handmade">
        <img src="https://images.unsplash.com/photo-1579799849915-fd1f634d90c4?auto=format&fit=crop&w=150&q=80" alt="Handmade Earrings" />
        <p>Handmade Earrings</p>
        <p><strong>₹199</strong></p>
        <div class="product-buttons">
          <button>Add to Cart</button>
          <button class="wishlist" title="Add to Wishlist">&#9825;</button>
        </div>
      </div>
      <div class="product-card" data-category="Clothing" data-price="999" data-rating="3" data-size="Large" data-fabric="Silk" data-material="Silver" data-shape="Oval" data-color="Blue" data-craft="Weaving" data-technique="Machine">
        <img src="https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=150&q=80" alt="Designer Saree" />
        <p>Designer Saree</p>
        <p><strong>₹999</strong></p>
        <div class="product-buttons">
          <button>Add to Cart</button>
          <button class="wishlist" title="Add to Wishlist">&#9825;</button>
        </div>
      </div>
      <div class="product-card" data-category="Handicrafts" data-price="349" data-rating="4" data-size="Medium" data-fabric="Linen" data-material="Wood" data-shape="Square" data-color="Green" data-craft="Painting" data-technique="Handmade">
        <img src="https://images.unsplash.com/photo-1539874754764-5a965591f0e1?auto=format&fit=crop&w=150&q=80" alt="Decorative Vase" />
        <p>Decorative Vase</p>
        <p><strong>₹349</strong></p>
        <div class="product-buttons">
          <button>Add to Cart</button>
          <button class="wishlist" title="Add to Wishlist">&#9825;</button>
        </div>
      </div>
      <!-- Add more products as needed -->
    </div>
  </section>

</div>

<script>
  // All possible dynamic filter fields with their possible options per category:
  const dynamicFilterData = {
    Clothing: {
      Size: ["Small", "Medium", "Large"],
      Fabric: ["Cotton", "Silk", "Linen"],
      Material: ["Gold", "Silver"]
    },
    Accessories: {
      Shape: ["Round", "Square", "Oval"],
      Color: ["Red", "Blue", "Green"]
    },
    Handicrafts: {
      Craft: ["Embroidery", "Painting", "Weaving"],
      Technique: ["Handmade", "Machine"]
    },
    "Home Decor": {
      Material: ["Wood", "Metal", "Glass"],
      Color: ["Brown", "Black", "White"]
    }
  };

  function clearFilters() {
    // Clear desktop filters
    document.getElementById("categoryFilter").value = "All";
    document.getElementById("minPrice").value = "";
    document.getElementById("maxPrice").value = "";
    document.getElementById("ratingFilter").value = "0";

    // Clear dynamic desktop filters
    const dynamicContainer = document.getElementById("dynamicFiltersDesktop");
    dynamicContainer.querySelectorAll("select").forEach(sel => sel.value = "All");

    // Clear mobile filters too
    clearFiltersMobile();

    applyFilters();
  }

  function clearFiltersMobile() {
    document.getElementById("categoryFilterMobile").value = "All";
    document.getElementById("minPriceMobile").value = "";
    document.getElementById("maxPriceMobile").value = "";
    document.getElementById("ratingFilterMobile").value = "0";

    const dynamicContainer = document.getElementById("dynamicFiltersMobile");
    dynamicContainer.querySelectorAll("select").forEach(sel => sel.value = "All");
  }

  // Toggle mobile filter display
  function toggleMobileFilters() {
    const wrapper = document.getElementById("mobileFilterWrapper");
    const btn = document.getElementById("filterToggleBtn");
    if(wrapper.classList.contains("active")) {
      wrapper.classList.remove("active");
      btn.innerHTML = "Show Filters &#x25BC;";
    } else {
      wrapper.classList.add("active");
      btn.innerHTML = "Hide Filters &#x25B2;";
    }
  }

  // Update dynamic filters based on category, source indicates desktop/mobile for syncing
  function updateFilterOptions(source) {
    let category, container;
    if (source === "mobile") {
      category = document.getElementById("categoryFilterMobile").value;
      container = document.getElementById("dynamicFiltersMobile");
    } else {
      category = document.getElementById("categoryFilter").value;
      container = document.getElementById("dynamicFiltersDesktop");
    }

    // Clear current dynamic filters container
    container.innerHTML = "";

    if(category === "All" || !dynamicFilterData[category]) {
      // No dynamic filters for "All" or unknown
      return;
    }

    // Create selects for each dynamic filter
    const filters = dynamicFilterData[category];
    for(let filterName in filters) {
      const options = filters[filterName];
      const groupDiv = document.createElement("div");
      groupDiv.className = "filter-group";

      const label = document.createElement("label");
      label.textContent = filterName;
      label.setAttribute("for", filterName + (source === "mobile" ? "Mobile" : ""));

      const select = document.createElement("select");
      select.id = filterName + (source === "mobile" ? "Mobile" : "");
      select.dataset.filterName = filterName;
      // Add "All" option
      const allOpt = document.createElement("option");
      allOpt.value = "All";
      allOpt.textContent = "All";
      select.appendChild(allOpt);

      options.forEach(opt => {
        const optionEl = document.createElement("option");
        optionEl.value = opt;
        optionEl.textContent = opt;
        select.appendChild(optionEl);
      });

      groupDiv.appendChild(label);
      groupDiv.appendChild(select);
      container.appendChild(groupDiv);
    }
  }

  // Synchronize filters desktop -> mobile and vice versa (for all filters)
  function syncFilters(sourceToTarget) {
    if(sourceToTarget === "desktopToMobile") {
      document.getElementById("categoryFilterMobile").value = document.getElementById("categoryFilter").value;
      document.getElementById("minPriceMobile").value = document.getElementById("minPrice").value;
      document.getElementById("maxPriceMobile").value = document.getElementById("maxPrice").value;
      document.getElementById("ratingFilterMobile").value = document.getElementById("ratingFilter").value;

      // Sync dynamic filters
      const desktopDynFilters = document.querySelectorAll("#dynamicFiltersDesktop select");
      const mobileDynFilters = document.querySelectorAll("#dynamicFiltersMobile select");
      desktopDynFilters.forEach((sel, i) => {
        if(mobileDynFilters[i]) mobileDynFilters[i].value = sel.value;
      });

    } else {
      // mobileToDesktop
      document.getElementById("categoryFilter").value = document.getElementById("categoryFilterMobile").value;
      document.getElementById("minPrice").value = document.getElementById("minPriceMobile").value;
      document.getElementById("maxPrice").value = document.getElementById("maxPriceMobile").value;
      document.getElementById("ratingFilter").value = document.getElementById("ratingFilterMobile").value;

      const desktopDynFilters = document.querySelectorAll("#dynamicFiltersDesktop select");
      const mobileDynFilters = document.querySelectorAll("#dynamicFiltersMobile select");
      mobileDynFilters.forEach((sel, i) => {
        if(desktopDynFilters[i]) desktopDynFilters[i].value = sel.value;
      });
    }
  }

  // Main filter function for desktop filters
  function applyFilters() {
    // Sync desktop filters to mobile before filtering
    syncFilters("desktopToMobile");

    const category = document.getElementById("categoryFilter").value;
    const minPrice = parseFloat(document.getElementById("minPrice").value) || 0;
    const maxPrice = parseFloat(document.getElementById("maxPrice").value) || Infinity;
    const ratingFilter = parseInt(document.getElementById("ratingFilter").value) || 0;

    // Get dynamic filter values from desktop
    const dynamicFilters = {};
    document.querySelectorAll("#dynamicFiltersDesktop select").forEach(sel => {
      const key = sel.dataset.filterName;
      dynamicFilters[key] = sel.value;
    });

    const products = document.querySelectorAll("#productList .product-card");

    products.forEach(product => {
      const productCategory = product.getAttribute("data-category");
      const productPrice = parseFloat(product.getAttribute("data-price"));
      const productRating = parseInt(product.getAttribute("data-rating"));

      // Category match
      let categoryMatch = (category === "All" || productCategory === category);

      // Price match
      let priceMatch = (productPrice >= minPrice && productPrice <= maxPrice);

      // Rating match
      let ratingMatch = (productRating >= ratingFilter);

      // Dynamic filters match
      let dynamicMatch = true;
      for(const key in dynamicFilters) {
        const filterValue = dynamicFilters[key];
        if(filterValue !== "All") {
          const productVal = product.getAttribute("data-" + key.toLowerCase());
          if(!productVal || productVal !== filterValue) {
            dynamicMatch = false;
            break;
          }
        }
      }

      // Show or hide product
      product.style.display = (categoryMatch && priceMatch && ratingMatch && dynamicMatch) ? "block" : "none";
    });
  }

  // Apply filters from mobile inputs
  function applyFiltersMobile() {
    // Sync mobile filters to desktop
    syncFilters("mobileToDesktop");

    // Update dynamic filters on desktop (so filters are visible and synced)
    updateFilterOptions("desktop");

    // Apply filters
    applyFilters();

    // Hide mobile filters after applying
    toggleMobileFilters();
  }

  // Initialize on page load
  window.addEventListener("DOMContentLoaded", () => {
    // Initialize dynamic filters on desktop and mobile
    updateFilterOptions("desktop");
    updateFilterOptions("mobile");

    // Sync initial values
    syncFilters("desktopToMobile");

    // Apply filters initially
    applyFilters();

    // Add event listeners to all filters to auto-apply on change (optional)
    const desktopFilters = document.querySelectorAll("#filterSidebar select, #filterSidebar input");
    desktopFilters.forEach(el => {
      el.addEventListener("change", applyFilters);
      el.addEventListener("input", applyFilters);
    });

    const mobileFilters = document.querySelectorAll("#mobileFilterWrapper select, #mobileFilterWrapper input");
    mobileFilters.forEach(el => {
      el.addEventListener("change", () => {
        // Could add auto apply for mobile or leave for Done button
        //applyFiltersMobile();
      });
    });
  });
</script>

</body>
</html>
