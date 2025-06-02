<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Sakhi Bazaar - Responsive Filters</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<style>
  body {
    margin: 0; font-family: Arial, sans-serif; background:linear-gradient(#EDE4F0);
  }
  header {
    background-color:  linear-gradient(#EDE4F0);
 
  color: black;
  padding: 15px 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 15px;

  max-width: 1200px;  /* or any width you want */
  margin: auto;     /* centers the header */
  width: 100%;        /* ensures responsive scaling */
}
.header-container {
  max-width: 1200px; /* or whatever fits your layout */
  margin: 0 auto;
  padding: 0 16px; /* optional for spacing */
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
  justify-content: center; /* Center the icons */
}

  .market-content {
    display: flex; padding: 20px; gap: 20px; flex-wrap: wrap;
  }
  /* Filter Sidebar - Desktop */
  .sidebar-container {
  display: flex;
  gap: 20px; /* space between main sidebar and filter sidebar */
  margin-bottom: 20px;
}

.content-wrapper {
  display: flex;
  gap: 20px;
  flex-wrap: nowrap;
  /* full width of main-content */
}

/* Filter sidebar next to fixed sidebar */
.filter-sidebar {
  width: 250px;
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: #EDE4F0;
  flex-shrink: 0;
  height: fit-content;
}

/* Products section fills remaining space */
.products-section {
  flex: 1;
  min-width: 300px;
}



/* products-section stays as is */

  
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
  /* Update: Filter button spacing */
#filterToggleBtn {
  display: none;
  background-color: #4b0082;
  color: white;
  border: none;
  padding: 12px 20px;
  cursor: pointer;
  font-weight: bold;
  width: 100%;
  margin: 10px 0; /* Updated spacing */
  border-radius: 5px; /* Rounded for consistency */
}

/* Update: Mobile Filter Wrapper toggling */
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

/* Update: Dynamic Filter Selects */
.filter-group select,
.filter-group input {
  font-size: 14px;
}

/* Responsive layout tweaks */

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
  /* Horizontal scroll for Daily Deals */
.daily-deals-scroll {
  display: flex;
  overflow-x: auto;
  gap: 16px;
  padding-bottom: 10px;
  scroll-snap-type: x mandatory;
}
.daily-deals-scroll .product-card {
  min-width: 160px;
  scroll-snap-align: start;
}
.daily-deals-scroll::-webkit-scrollbar {
  height: 6px;
}
.daily-deals-scroll::-webkit-scrollbar-thumb {
  background-color: #aaa;
  border-radius: 4px;
}
/* Scrollable Daily Deals Section */
.scrollable-container {
  position: relative;
  margin-bottom: 30px;
}

.scroll-wrapper {
  overflow-x: auto;
  white-space: nowrap;
  scroll-behavior: smooth;
  padding-bottom: 10px;
}

.scrollable-grid {
  display: inline-flex;
  gap: 20px;
}

.scroll-arrow {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: #4b0082;
  color: white;
  border: none;
  padding: 10px;
  cursor: pointer;
  z-index: 2;
  border-radius: 50%;
}

.scroll-arrow.right {
  right: 10px; /* changed from -10px */
}
.scroll-arrow.left {
  left: 10px;  /* changed from -10px */
}
.scroll-arrow {
  top: 40%;
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

<div class="market-content">

  <!-- Desktop Sidebar -->
   <div class="content-wrapper">

  <aside class="filter-sidebar" id="filterSidebar">
    <h3>Filters</h3>
    <div class="filter-group">
      <label for="categoryFilter"><i class="fas fa-tags"></i> Category</label>

      <select id="categoryFilter" onchange="updateFilterOptions()">
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
      <label for="minPrice"><i class="fas fa-rupee-sign"></i> Price Range (₹)</label>

      <input type="number" id="minPrice" placeholder="Min" min="0" />
      <input type="number" id="maxPrice" placeholder="Max" min="0" style="margin-top:5px;" />
    </div>

    <div class="filter-group">
      <label for="ratingFilter"><i class="fas fa-star"></i> Rating</label>
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
</div>

  <!-- Mobile Filter Wrapper: same filters as desktop but with unique IDs -->
  <div id="mobileFilterWrapper">
    <h3>Filters</h3>
    <div class="filter-group">
      <label for="categoryFilter"><i class="fas fa-tags"></i> Category</label>


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
      <label for="minPrice"><i class="fas fa-rupee-sign"></i> Price Range (₹)</label>
      <input type="number" id="minPriceMobile" placeholder="Min" min="0" />
      <input type="number" id="maxPriceMobile" placeholder="Max" min="0" style="margin-top:5px;" />
    </div>

    <div class="filter-group">
      
<label for="ratingFilter"><i class="fas fa-star"></i> Rating</label>
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
<div class="scrollable-container">
  <h2>🎉 Daily Deals</h2>
  <button class="scroll-arrow left" onclick="scrollDeals('left')">&#9664;</button>
  <div class="scroll-wrapper" id="dailyDealsWrapper">
    <div class="scrollable-grid" id="dailyDeals">
      <!-- existing daily deal cards remain unchanged -->

  <div class="product-card" data-category="Clothing" data-price="499" data-rating="4">
    <img src="https://images.unsplash.com/photo-1618354691210-2f4a22ab10c6?auto=format&fit=crop&w=150&q=80" alt="Silk Kurti" />
    <p>Silk Kurti</p>
    <p><strong>₹499</strong></p>
    <div class="product-buttons">
      <button>Add to Cart</button>
      <button class="wishlist" title="Add to Wishlist">&#9825;</button>
    </div>
  </div>
  <p><del>₹799</del> <strong>₹499</strong></p>
<span style="color: green; font-weight: bold;">38% OFF</span>

  <!-- Add more product cards horizontally -->
   <div class="product-card" data-category="Clothing" data-price="499" data-rating="4">
    <img src="https://images.unsplash.com/photo-1618354691210-2f4a22ab10c6?auto=format&fit=crop&w=150&q=80" alt="Silk Kurti" />
    <p>Silk Kurti</p>
    <p><strong>₹499</strong></p>
    <div class="product-buttons">
      <button>Add to Cart</button>
      <button class="wishlist" title="Add to Wishlist">&#9825;</button>
    </div>
  </div>
  <p><del>₹799</del> <strong>₹499</strong></p>
<span style="color: green; font-weight: bold;">38% OFF</span>

  <div class="product-card" data-category="Clothing" data-price="499" data-rating="4">
    <img src="https://images.unsplash.com/photo-1618354691210-2f4a22ab10c6?auto=format&fit=crop&w=150&q=80" alt="Silk Kurti" />
    <p>Silk Kurti</p>
    <p><strong>₹499</strong></p>
    <div class="product-buttons">
      <button>Add to Cart</button>
      <button class="wishlist" title="Add to Wishlist">&#9825;</button>
    </div>
  </div>
</div>
    </div> <!-- end scrollable-grid -->
  </div> <!-- end scroll-wrapper -->
  <button class="scroll-arrow right" onclick="scrollDeals('right')">&#9654;</button>
</div> <!-- end scrollable-container -->
<p><del>₹799</del> <strong>₹499</strong></p>
<span style="color: green; font-weight: bold;">38% OFF</span>

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
  // Initialize filters when DOM is ready
document.addEventListener("DOMContentLoaded", () => {
  updateFilterOptions("desktop");
  updateFilterOptions("mobile");
});

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

  function toggleMobileFilters() {
    const wrapper = document.getElementById("mobileFilterWrapper");
    const btn = document.getElementById("filterToggleBtn");
    wrapper.classList.toggle("active");
    btn.innerHTML = wrapper.classList.contains("active")
      ? "Hide Filters &#x25B2;"
      : "Show Filters &#x25BC;";
  }

 function updateFilterOptions(mode = "desktop") {
  const categoryId = mode === "mobile" ? "categoryFilterMobile" : "categoryFilter";
  const containerId = mode === "mobile" ? "dynamicFiltersMobile" : "dynamicFiltersDesktop";

  const selectedCategory = document.getElementById(categoryId).value;
  const dynamicFilterContainer = document.getElementById(containerId);
  dynamicFilterContainer.innerHTML = "";

  if (!selectedCategory || !dynamicFilterData[selectedCategory]) return;

  const filters = dynamicFilterData[selectedCategory];
  for (const [filterName, options] of Object.entries(filters)) {
    const label = document.createElement("label");
    label.textContent = filterName;
    const select = document.createElement("select");
    select.dataset.filterName = filterName; // Important for filtering
    select.innerHTML = `<option value="All">All</option>`;
    options.forEach(option => {
      const opt = document.createElement("option");
      opt.value = option;
      opt.textContent = option;
      select.appendChild(opt);
    });
    const group = document.createElement("div");
    group.classList.add("filter-group");
    group.appendChild(label);
    group.appendChild(select);
    dynamicFilterContainer.appendChild(group);
  }
}


  function clearFilters() {
    document.getElementById("categoryFilter").value = "All";
    document.getElementById("minPrice").value = "";
    document.getElementById("maxPrice").value = "";
    document.getElementById("ratingFilter").value = "0";
    updateFilterOptions("desktop");

    clearFiltersMobile();
    applyFilters();
  }

  function clearFiltersMobile() {
    document.getElementById("categoryFilterMobile").value = "All";
    document.getElementById("minPriceMobile").value = "";
    document.getElementById("maxPriceMobile").value = "";
    document.getElementById("ratingFilterMobile").value = "0";
    updateFilterOptions("mobile");
  }

  function applyFilters() {
    const category = document.getElementById("categoryFilter").value;
    const minPrice = parseFloat(document.getElementById("minPrice").value) || 0;
    const maxPrice = parseFloat(document.getElementById("maxPrice").value) || Infinity;
    const minRating = parseInt(document.getElementById("ratingFilter").value) || 0;

    const dynamicFilterElements = document.querySelectorAll("#dynamicFiltersDesktop select");
    const dynamicFilters = {};
    dynamicFilterElements.forEach(select => {
      if (select.value !== "All") {
        dynamicFilters[select.dataset.filterName.toLowerCase()] = select.value;
      }
    });

    document.querySelectorAll(".product-card").forEach(card => {
      const cardCategory = card.dataset.category;
      const cardPrice = parseFloat(card.dataset.price);
      const cardRating = parseInt(card.dataset.rating);

      let show = true;

      if (category !== "All" && category !== cardCategory) show = false;
      if (cardPrice < minPrice || cardPrice > maxPrice) show = false;
      if (cardRating < minRating) show = false;

      for (let key in dynamicFilters) {
        const value = card.dataset[key];
        if (value !== dynamicFilters[key]) {
          show = false;
          break;
        }
      }

      card.style.display = show ? "flex" : "none";
    });
  }

  function applyFiltersMobile() {
    syncFilters("mobileToDesktop");
    applyFilters();
    toggleMobileFilters();
  }

 function syncFilters(direction) {
  const from = direction === "mobileToDesktop" ? "Mobile" : "";
  const to = direction === "mobileToDesktop" ? "" : "Mobile";

  document.getElementById("categoryFilter" + to).value = document.getElementById("categoryFilter" + from).value;
  document.getElementById("minPrice" + to).value = document.getElementById("minPrice" + from).value;
  document.getElementById("maxPrice" + to).value = document.getElementById("maxPrice" + from).value;
  document.getElementById("ratingFilter" + to).value = document.getElementById("ratingFilter" + from).value;

  updateFilterOptions(to === "Mobile" ? "mobile" : "desktop");
}

  function searchProducts() {
    const query = document.getElementById("searchBox").value.toLowerCase();
    document.querySelectorAll(".product-card").forEach(card => {
      const text = card.textContent.toLowerCase();
      card.style.display = text.includes(query) ? "flex" : "none";
    });
  }

  // Init
function scrollDeals(direction) {
  const wrapper = document.getElementById("dailyDealsWrapper");
  const scrollAmount = 300;
  wrapper.scrollBy({
    left: direction === "left" ? -scrollAmount : scrollAmount,
    behavior: "smooth"
  });
}

</script>

</body>
</html>
