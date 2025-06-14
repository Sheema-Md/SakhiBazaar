<?php require_once __DIR__ . '/../config/config.php';
$productId = $_GET['id'];
$result = $conn->query("SELECT * FROM products WHERE id = $productId");
$product = $result->fetch_assoc();
$imagePath = !empty($product['image_url']) ? $product['image_url'] : 'images/placeholder.png';

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Product</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function previewImage(event) {
      const reader = new FileReader();
      reader.onload = function () {
        const img = document.getElementById('productImage');
        img.src = reader.result;
        img.classList.remove('hidden');
        document.getElementById('uploadLabel').classList.add('hidden');
      };
      reader.readAsDataURL(event.target.files[0]);
    }
  </script>
</head>
<body class="bg-purple-50 p-8">
  <form method="POST" enctype="multipart/form-data" action="save_product.php" class="max-w-3xl mx-auto bg-white shadow-xl p-6 rounded-xl space-y-4">
    <input type="hidden" name="id" value="<?= $product['id'] ?>">

    <div class="flex gap-6">
      <!-- Image -->
      <div class="relative">
        <?php if (empty($product['image_url'])): ?>
          <label id="uploadLabel" for="imageInput" class="absolute w-32 h-32 flex items-center justify-center text-3xl border rounded-xl text-purple-600 cursor-pointer bg-white">+</label>
        <?php endif; ?>
        <input type="file" name="prod-img" id="imageInput" class="absolute w-full h-full opacity-0 cursor-pointer" onchange="previewImage(event)">
        <img id="productImage"
             src="<?= htmlspecialchars($imagePath) ?>"
             class="w-32 h-32 object-cover rounded-xl border <?= empty($product['image_url']) ? 'hidden' : '' ?>" />
      </div>

     <div class="flex-1 space-y-4">
        <div>
          <label class="block text-purple-800 font-medium">Product Name</label>
          <input type="text" name="name" value="<?= htmlspecialchars($product['product_name']) ?>" class="w-full p-2 border rounded bg-purple-50">
        </div>
        <div>
          <label class="block text-purple-800 font-medium">Category</label>
          <select name="category" class="w-full p-2 border rounded bg-purple-50">
            <?php
              $categories = ["Clothing", "Accessories", "Handicrafts", "Home Decor", "Other"];
              foreach ($categories as $cat) {
                $selected = $product['category'] == $cat ? "selected" : "";
                echo "<option value='$cat' $selected>$cat</option>";
              }
            ?>
          </select>
        </div>
      </div>
    </div>

    <!-- Price, Stock, Quantity -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-purple-800 font-medium">Price</label>
        <input type="text" name="price" value="<?= htmlspecialchars($product['price']) ?>" class="w-full p-2 border rounded bg-purple-50">
      </div>

      <div>
        <label class="block text-purple-800 font-medium">Stock Status</label>
        <select name="stock" class="w-full p-2 border rounded bg-purple-50">
          <option value="In Stock" <?= $product['stock_status'] == "In Stock" ? "selected" : "" ?>>In Stock</option>
          <option value="Out of Stock" <?= $product['stock_status'] == "Out of Stock" ? "selected" : "" ?>>Out of Stock</option>
        </select>
      </div>

      <div>
        <label class="block text-purple-800 font-medium">Quantity</label>
        <input type="number" name="quantity" value="<?= $product['quantity'] ?>" class="w-full p-2 border rounded bg-purple-50">
      </div>

      <div>
        <label class="block text-purple-800 font-medium">Color</label>
        <input type="text" name="color" value="<?= htmlspecialchars($product['prod-color']) ?>" class="w-full p-2 border rounded bg-purple-50">
      </div>
    </div>

    <!-- Sizes and Material -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-purple-800 font-medium">Sizes (comma separated)</label>
        <input type="text" name="size" value="<?= htmlspecialchars($product['prod-size']) ?>" class="w-full p-2 border rounded bg-purple-50">
      </div>
      <div>
        <label class="block text-purple-800 font-medium">Material</label>
        <input type="text" name="material" value="<?= htmlspecialchars($product['material']) ?>" class="w-full p-2 border rounded bg-purple-50">
      </div>
    </div>

    <!-- Description -->
    <div>
      <label class="block text-purple-800 font-medium">Description</label>
      <textarea name="description" rows="4" class="w-full p-3 border rounded bg-purple-50"><?= htmlspecialchars($product['description']) ?></textarea>
    </div>


    <div class="flex justify-between border-t pt-4">
      <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded hover:bg-purple-700">Save Changes</button>
      <a href="delete_product.php?id=<?= $product['id'] ?>" onclick="return confirm('Are you sure?')" class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600">Delete Product</a>
    </div>
  </form>
   <script src = "js/script.js"></script>
</body>
</html>
<?php require_once 'partials/footer.php'; ?>