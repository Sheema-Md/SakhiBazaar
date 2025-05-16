

   
     <!DOCTYPE html>
     <html lang="en">
     <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <title>Add Product - Sakhi Bazaar</title>
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
       <style>
         body {
           font-family: Arial, sans-serif;
           background: #f9f9f9;
           margin: 0;
           padding: 20px;
         }
         .container {
           max-width: 700px;
           margin: auto;
           background: #fff;
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
         .publish-btn {
           background-color: #28a745;
           color: white;
         }
         .draft-btn {
           background-color: #ffc107;
           color: black;
         }
       </style>
     </head>
     <body>
       <div class="container">
         <h2>🛍️ Add New Product</h2>
     
         <!-- 1. Basic Product Info -->
         <div class="form-section">
           <h3>1. Basic Product Info</h3>
           <div class="form-group">
             <label><i class="fas fa-tag"></i>Product Name</label>
             <input type="text" placeholder="Enter product name">
           </div>
           <div class="form-group">
             <label><i class="fas fa-list"></i>Category</label>
             <select>
               <option value="">Select Category</option>
               <option>Clothing</option>
               <option>Accessories</option>
               <option>Handicrafts</option>
               <option>Home Decor</option>
             </select>
           </div>
           <div class="form-group">
             <label><i class="fas fa-rupee-sign"></i>Price</label>
             <input type="number" placeholder="Enter price in INR">
           </div>
           <div class="form-group">
             <label><i class="fas fa-boxes"></i>Stock Quantity</label>
             <input type="number" placeholder="Enter available stock">
           </div>
         </div>
     
         <!-- 2. Product Image Upload -->
         <div class="form-section">
           <h3>2. Product Image Upload</h3>
           <input type="file" accept="image/*" multiple onchange="previewImages(event)">
           <div class="image-preview" id="imagePreview"></div>
         </div>
     
         <!-- 3. Product Description -->
         <div class="form-section">
           <h3>3. Product Description</h3>
           <textarea rows="4" placeholder="Write a short description..."></textarea>
         </div>
     
         <!-- 4. Actions -->
         <div class="actions form-section">
           <button class="draft-btn">Save as Draft</button>
           <button class="publish-btn">Publish Product</button>
         </div>
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
       </script>
     </body>
     </html>
     