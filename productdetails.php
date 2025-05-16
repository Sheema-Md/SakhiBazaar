<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Product – Sakhi Bazaar</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function confirmDelete() {
      if (confirm("Are you sure you want to delete this product?")) {
        alert("Product deleted."); // Replace with actual delete logic
      }
    }

    function saveChanges() {
      const data = {
        name: document.getElementById('name').value,
        category: document.getElementById('category').value,
        price: document.getElementById('price').value,
        stock: document.getElementById('stock').value,
        description: document.getElementById('description').value,
        // image: document.getElementById('imageInput').files[0] // Optional: send to server
      };
      console.log('Saving:', data); // Replace with actual save logic
      alert('Changes saved!');
    }

    function previewImage(event) {
      const file = event.target.files[0];
      const reader = new FileReader();
      reader.onload = function () {
        const output = document.getElementById('productImage');
        output.src = reader.result;
      };
      if (file) {
        reader.readAsDataURL(file);
      }
    }
  </script>
</head>
<body class="bg-purple-50 min-h-screen flex items-center justify-center p-4">
  <div class="w-full max-w-3xl bg-white shadow-xl rounded-2xl p-6 space-y-6">
    
    <!-- Product Overview -->
    <div class="flex flex-col md:flex-row items-start gap-6">
      
      <!-- Image Upload -->
      <div class="flex flex-col items-center space-y-2">
        <img id="productImage" src="https://via.placeholder.com/150" alt="Product" class="w-32 h-32 rounded-xl object-cover border" />
        <input type="file" accept="image/*" id="imageInput" onchange="previewImage(event)" class="text-sm text-purple-800"/>
      </div>
      
      <div class="flex-1 space-y-4">
        <div>
          <label for="name" class="block text-sm font-medium text-purple-800">Product Name</label>
          <input id="name" type="text" value="Handwoven Cotton Saree"
                 class="w-full mt-1 p-2 border rounded-md bg-purple-50 focus:outline-purple-500" />
        </div>
        <div>
          <label for="category" class="block text-sm font-medium text-purple-800">Category</label>
          <input id="category" type="text" value="Ethnic Wear"
                 class="w-full mt-1 p-2 border rounded-md bg-purple-50 focus:outline-purple-500" />
        </div>
        <div>
          <label for="price" class="block text-sm font-medium text-purple-800">Price</label>
          <input id="price" type="text" value="₹1200"
                 class="w-full mt-1 p-2 border rounded-md bg-purple-50 focus:outline-purple-500" />
        </div>
        <div>
          <label for="stock" class="block text-sm font-medium text-purple-800">Stock Status</label>
          <select id="stock" class="w-full mt-1 p-2 border rounded-md bg-purple-50 focus:outline-purple-500">
            <option value="In Stock" selected>In Stock</option>
            <option value="Out of Stock">Out of Stock</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Description -->
    <div>
      <label for="description" class="block text-sm font-medium text-purple-800">Description</label>
      <textarea id="description" rows="4"
                class="w-full mt-2 p-3 border rounded-md bg-purple-50 focus:outline-purple-500">
A beautifully handcrafted cotton saree made by rural artisans. Perfect for festive occasions.
      </textarea>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row justify-end gap-4 pt-4 border-t">
      <button onclick="saveChanges()"
              class="bg-purple-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-purple-700 transition">
        Save Changes
      </button>
      <button onclick="confirmDelete()"
              class="bg-red-500 text-white px-6 py-2 rounded-lg text-sm hover:bg-red-600 transition">
        Delete Product
      </button>
    </div>
    
  </div>
</body>
</html>