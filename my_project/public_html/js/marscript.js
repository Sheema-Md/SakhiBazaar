let serverFilterData = {}; // Initialize as empty object

// This function will be called AFTER the HTML is loaded via AJAX
function initMarketPageFilters() {
    console.log("Initializing market page filters...");
    const marketPageContainer = document.getElementById('market-page-container');
    if (marketPageContainer && marketPageContainer.dataset.filterData) {
        try {
            serverFilterData = JSON.parse(marketPageContainer.dataset.filterData);
            console.log("Parsed serverFilterData:", serverFilterData);
        } catch (e) {
            console.error("Error parsing filter data from data-attribute:", e);
        }
    } else {
        console.warn("Market page container or filter data not found.");
    }

    // Manually call your update functions
    updateFilterOptions("desktop");
    updateFilterOptions("mobile");

    // Also re-select current URL parameters in the UI
    const urlParams = new URLSearchParams(window.location.search);

    // Category
    const categorySelect = document.getElementById("categoryFilter");
    if (categorySelect) categorySelect.value = urlParams.get('category') || 'All';
    const categorySelectMobile = document.getElementById("categoryFilterMobile");
    if (categorySelectMobile) categorySelectMobile.value = urlParams.get('category') || 'All';

    // Rating
    const ratingSelect = document.getElementById("ratingFilter");
    if (ratingSelect) ratingSelect.value = urlParams.get('rating') || '0';
    const ratingSelectMobile = document.getElementById("ratingFilterMobile");
    if (ratingSelectMobile) ratingSelectMobile.value = urlParams.get('rating') || '0';

    // Price
    const minPriceInput = document.getElementById("minPrice");
    if (minPriceInput) minPriceInput.value = urlParams.get('minPrice') || '0';
    const maxPriceInput = document.getElementById("maxPrice");
    if (maxPriceInput) maxPriceInput.value = urlParams.get('maxPrice') || '99999';
    const minPriceInputMobile = document.getElementById("minPriceMobile");
    if (minPriceInputMobile) minPriceInputMobile.value = urlParams.get('minPrice') || '0';
    const maxPriceInputMobile = document.getElementById("maxPriceMobile");
    if (maxPriceInputMobile) maxPriceInputMobile.value = urlParams.get('maxPrice') || '99999';

    // Dynamic Filters (size, material, color)
    ['size', 'material', 'color'].forEach(filterKey => {
        const desktopSelect = document.querySelector(`#dynamicFiltersDesktop select[name='${filterKey}']`);
        if (desktopSelect) desktopSelect.value = urlParams.get(filterKey) || '';
        const mobileSelect = document.querySelector(`#dynamicFiltersMobile select[name='${filterKey}']`);
        if (mobileSelect) mobileSelect.value = urlParams.get(filterKey) || '';
    });

    // Re-attach event listeners for specific elements if they are created dynamically
    // (e.g., categoryFilter onchange will already work because the select element is static in market.php)
    // If dynamic selects are added later, you might need to re-attach their onchange listeners
    // but your updateFilterOptions function already handles this when it creates them.
}

// Your existing functions (applyFilters, updateFilterOptions, toggleMobileFilters, etc.)
// Ensure they are global or accessible within this file.
// For example:
// function updateFilterOptions(mode = "desktop") { ... }
// function applyFilters() { ... }
// ... all other functions ...

// Make sure your existing functions are correctly defined below initMarketPageFilters
// or above if you want to use them directly.
// Example:
// function applyFilters() { ... }
// function applyFiltersMobile() { ... }
// etc.
function updateFilterOptions(mode = "desktop") {
            const categoryId = mode === "mobile" ? "categoryFilterMobile" : "categoryFilter";
            const containerId = mode === "mobile" ? "dynamicFiltersMobile" : "dynamicFiltersDesktop";

            const selectedCategory = document.getElementById(categoryId).value;
            const dynamicFilterContainer = document.getElementById(containerId);
            dynamicFilterContainer.innerHTML = "";

            // Use serverFilterData to populate dynamic filters
            const filtersToDisplay = {
                'size': 'Size',
                'material': 'Material',
                'color': 'Color'
            };

            for (const filterKey in filtersToDisplay) {
                if (serverFilterData[filterKey] && serverFilterData[filterKey].length > 0) {
                    const label = document.createElement("label");
                    label.textContent = filtersToDisplay[filterKey];
                    label.style.display = "block";

                    const select = document.createElement("select");
                    select.name = filterKey; // Use the actual filter key for URL params
                    select.id = `${filterKey}Filter${mode === 'mobile' ? 'Mobile' : ''}`; // Give it an ID
                    select.innerHTML = `<option value="">All ${filtersToDisplay[filterKey]}</option>`;

                    serverFilterData[filterKey].forEach(option => {
                        const opt = document.createElement("option");
                        opt.value = option;
                        opt.textContent = option;
                        // Pre-select based on current URL parameters
                        if (filterKey === 'size' && '<?php echo $size; ?>' === option) opt.selected = true;
                        if (filterKey === 'material' && '<?php echo $material; ?>' === option) opt.selected = true;
                        if (filterKey === 'color' && '<?php echo $color; ?>' === option) opt.selected = true;
                        select.appendChild(opt);
                    });

                    // Add onchange event listener for dynamic filters
                    select.onchange = () => {
                        if (mode === "desktop") applyFilters();
                        else applyFiltersMobile();
                    };

                    const wrapper = document.createElement("div");
                    wrapper.className = "filter-group";
                    wrapper.appendChild(label);
                    wrapper.appendChild(select);

                    dynamicFilterContainer.appendChild(wrapper);
                }
            }
        }
        function toggleMobileFilters() {
            const wrapper = document.getElementById("mobileFilterWrapper");
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

        document.addEventListener("DOMContentLoaded", () => {
    // Your existing calls
    updateFilterOptions("desktop");
    updateFilterOptions("mobile");

    // New: Attach event listeners programmatically
    const applyBtnDesktop = document.getElementById("applyFiltersBtnDesktop");
    if (applyBtnDesktop) {
        applyBtnDesktop.addEventListener("click", applyFilters);
    }

    const applyBtnMobile = document.getElementById("applyFiltersBtnMobile");
    if (applyBtnMobile) {
        applyBtnMobile.addEventListener("click", applyFiltersMobile);
    }

    // Add event listeners for price inputs for live filtering or 'apply' button
    document.getElementById("minPrice").addEventListener("change", applyFilters);
    document.getElementById("maxPrice").addEventListener("change", applyFilters);
    document.getElementById("ratingFilter").addEventListener("change", applyFilters);

    document.getElementById("minPriceMobile").addEventListener("change", applyFiltersMobile);
    document.getElementById("maxPriceMobile").addEventListener("change", applyFiltersMobile);
    document.getElementById("ratingFilterMobile").addEventListener("change", applyFiltersMobile);
});

// Your function definitions (they must be outside the DOMContentLoaded callback)
function applyFilters() {
    console.log("Apply Filters (Desktop) button/filter changed!"); // Added for debugging
    const category = document.getElementById("categoryFilter").value;
    const rating = document.getElementById("ratingFilter").value;
    const minPrice = document.getElementById("minPrice").value || 0;
    const maxPrice = document.getElementById("maxPrice").value || 99999;

    const params = new URLSearchParams();
    params.append("category", category);
    params.append("rating", rating);
    params.append("minPrice", minPrice);
    params.append("maxPrice", maxPrice);

    const sizeSelect = document.querySelector("#dynamicFiltersDesktop select[name='size']");
    if (sizeSelect && sizeSelect.value) params.append("size", sizeSelect.value);

    const materialSelect = document.querySelector("#dynamicFiltersDesktop select[name='material']");
    if (materialSelect && materialSelect.value) params.append("material", materialSelect.value);

    const colorSelect = document.querySelector("#dynamicFiltersDesktop select[name='color']");
    if (colorSelect && colorSelect.value) params.append("color", colorSelect.value);

    window.location.href = `?${params.toString()}`;
}

function applyFiltersMobile() {
    console.log("Apply Filters (Mobile) button/filter changed!"); // Added for debugging
    const category = document.getElementById("categoryFilterMobile").value;
    const rating = document.getElementById("ratingFilterMobile").value;
    const minPrice = document.getElementById("minPriceMobile").value || 0;
    const maxPrice = document.getElementById("maxPriceMobile").value || 99999;

    const params = new URLSearchParams();
    params.append("category", category);
    params.append("rating", rating);
    params.append("minPrice", minPrice);
    params.append("maxPrice", maxPrice);

    const sizeSelect = document.querySelector("#dynamicFiltersMobile select[name='size']");
    if (sizeSelect && sizeSelect.value) params.append("size", sizeSelect.value);

    const materialSelect = document.querySelector("#dynamicFiltersMobile select[name='material']");
    if (materialSelect && materialSelect.value) params.append("material", materialSelect.value);

    const colorSelect = document.querySelector("#dynamicFiltersMobile select[name='color']");
    if (colorSelect && colorSelect.value) params.append("color", colorSelect.value);

    window.location.href = `?${params.toString()}`;
}
        function clearFilters() {
            document.getElementById("categoryFilter").value = "All";
            document.getElementById("minPrice").value = 0;
            document.getElementById("maxPrice").value = 99999;
            document.getElementById("ratingFilter").value = "0";

            // Clear dynamic filter selects for desktop
            const dynamicDesktopFilters = document.querySelectorAll("#dynamicFiltersDesktop select");
            dynamicDesktopFilters.forEach(select => select.value = "");

            applyFilters();
        }

        function clearFiltersMobile() {
            document.getElementById("categoryFilterMobile").value = "All";
            document.getElementById("minPriceMobile").value = 0;
            document.getElementById("maxPriceMobile").value = 99999;
            document.getElementById("ratingFilterMobile").value = "0";

            // Clear dynamic filter selects for mobile
            const dynamicMobileFilters = document.querySelectorAll("#dynamicFiltersMobile select");
            dynamicMobileFilters.forEach(select => select.value = "");

            applyFiltersMobile();
        }

        function syncFilters(direction) {
            if (direction === "mobileToDesktop") {
                document.getElementById("categoryFilter").value = document.getElementById("categoryFilterMobile").value;
                document.getElementById("minPrice").value = document.getElementById("minPriceMobile").value;
                document.getElementById("maxPrice").value = document.getElementById("maxPriceMobile").value;
                document.getElementById("ratingFilter").value = document.getElementById("ratingFilterMobile").value;

                // Sync dynamic filters from mobile to desktop
                const mobileDynamicFilters = document.querySelectorAll("#dynamicFiltersMobile select");
                mobileDynamicFilters.forEach(mobileSelect => {
                    const desktopSelect = document.querySelector(`#dynamicFiltersDesktop select[name='${mobileSelect.name}']`);
                    if (desktopSelect) {
                        desktopSelect.value = mobileSelect.value;
                    }
                });

            } else if (direction === "desktopToMobile") {
                document.getElementById("categoryFilterMobile").value = document.getElementById("categoryFilter").value;
                document.getElementById("minPriceMobile").value = document.getElementById("minPrice").value;
                document.getElementById("maxPriceMobile").value = document.getElementById("maxPrice").value;
                document.getElementById("ratingFilterMobile").value = document.getElementById("ratingFilter").value;

                // Sync dynamic filters from desktop to mobile
                const desktopDynamicFilters = document.querySelectorAll("#dynamicFiltersDesktop select");
                desktopDynamicFilters.forEach(desktopSelect => {
                    const mobileSelect = document.querySelector(`#dynamicFiltersMobile select[name='${desktopSelect.name}']`);
                    if (mobileSelect) {
                        mobileSelect.value = desktopSelect.value;
                    }
                });
            }
            // Update dynamic filter options after syncing category
            updateFilterOptions(direction === "mobileToDesktop" ? "desktop" : "mobile");
        }