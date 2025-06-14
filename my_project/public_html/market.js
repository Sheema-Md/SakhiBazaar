
        let categorySelect = document.querySelector("#categoryFilter");
let sizeSelect = document.querySelector("#sizeFilter");
let colorSelect = document.querySelector("#colorFilter");
let materialSelect = document.querySelector("#materialFilter");
let ratingSelect = document.querySelector("#rating");
let minPriceInput = document.querySelector("#minPrice");
let maxPriceInput = document.querySelector("#maxPrice");
let container = document.querySelector("#productList");

function fetchFilteredProducts() {
  const category = categorySelect.value;
  const size = sizeSelect.value;
  const color = colorSelect.value;
  const material = materialSelect.value;
  const rating = ratingSelect.value;
  const minPrice = minPriceInput.value;
  const maxPrice = maxPriceInput.value;

  const data = new URLSearchParams();
  data.append("category", category);
  data.append("size", size);
  data.append("color", color);
  data.append("material", material);
  data.append("rating", rating);
  data.append("minPrice", minPrice);
  data.append("maxPrice", maxPrice);

  const http = new XMLHttpRequest();

  http.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      try {
        const response = JSON.parse(this.responseText);
        let out = "";
        response.forEach(item => {
          out += `
            <div class="product-card">
              <a href="prod.php?id=${item.id}" style="text-decoration:none; color:inherit; display:block;">
                <div class="image-placeholder">
                  <img src="${item.image_url}" alt="${item.product_name}">
                </div>
                <h3>${item.product_name}</h3>
                <p><strong>₹${parseFloat(item.price).toFixed(2)}</strong></p>
                <div class="rating">⭐ ${item.rating}</div>
              </a>
              <div class="product-buttons">
                <button>Add to Cart</button>
                <button class="wishlist" title="Add to Wishlist">&#9825;</button>
              </div>
            </div>
          `;
        });
        container.innerHTML = out;
      } catch (e) {
        console.error("Invalid JSON:", this.responseText);
      }
    }
  };

  http.open("POST", "script.php", true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.send(data.toString());
}

// Attach event listeners to all filters
[
  categorySelect,
  sizeSelect,
  colorSelect,
  materialSelect,
  ratingSelect,
  minPriceInput,
  maxPriceInput
].forEach(element => {
  element.addEventListener("change", fetchFilteredProducts);
});


function toggleMobileFilters() {
            const wrapper = document.getElementById("content-wrapper");
            const btn = document.getElementById("filterToggleBtn");
            wrapper.classList.toggle("active");
            btn.innerHTML = wrapper.classList.contains("active")
                ? "Hide Filters &#x25B2;"
                : "Show Filters &#x25BC;";
            // Sync desktop filters to mobile when opening, so user sees current state
            if (wrapper.classList.contains("active")) {
                syncFilters("desktopToMobile");
                updateFilterOptions("mobile"); // Re-render mobile dynamic filters
            }
        }