<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Seller Profile Page</title>
  <style>
    :root {
      --lavender: #e6e6fa;
      --purple: #6a0dad;
      --light-purple: #dcd0ff;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: var(--lavender);
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 900px;
      margin: auto;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      overflow: hidden;
    }

    .profile-header {
      display: flex;
      flex-direction: column;
      align-items: center;
      background: var(--light-purple);
      padding: 20px;
      text-align: center;
    }

    .profile-header img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 10px;
      cursor: pointer;
    }

    .profile-header h2,
    .profile-header h3,
    .profile-header p {
      margin: 4px 0;
      color: var(--purple);
    }

    .stats {
      display: flex;
      gap: 20px;
      justify-content: center;
      margin-top: 10px;
      font-weight: bold;
    }

    .form-section {
      padding: 20px;
    }

    .form-table {
      display: grid;
      grid-template-columns: 1fr 2fr;
      row-gap: 15px;
      column-gap: 20px;
      align-items: center;
    }

    .form-table label {
      font-weight: bold;
      color: #333;
    }

    .form-table input {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1em;
      width: 100%;
    }

    .actions {
      text-align: center;
      padding: 20px;
    }

    .actions button {
      background-color: var(--purple);
      color: white;
      border: none;
      padding: 12px 24px;
      font-size: 1em;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .actions button:hover {
      background-color: #5700a3;
    }

    @media (max-width: 768px) {
      .form-table {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Profile Overview -->
    <div class="profile-header">
      <input type="file" id="upload" style="display:none" />
      <img src="https://via.placeholder.com/100" alt="Profile Picture" onclick="document.getElementById('upload').click()" />
      <h2 id="displayName">Seller Name</h2>
      <h3 id="displayStore">Store Name</h3>
      <p id="displayEmail">Email: john@example.com</p>
      <p id="displayPhone">Phone: +123456789</p>
      <div class="stats">
        <div>Total Products: 120</div>
        <div>Store Rating: ★ 4.5</div>
      </div>
    </div>

    <!-- Editable Information in Table Layout -->
    <form class="form-section" onsubmit="return false;">
      <div class="form-table">
        <label for="name">Full Name</label>
        <input type="text" id="name" placeholder="John Doe" oninput="updateProfile()" />

        <label for="email">Email Address</label>
        <input type="email" id="email" placeholder="john@example.com" oninput="updateProfile()" />

        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" placeholder="+123456789" oninput="updateProfile()" />

        <label for="storeName">Store Name</label>
        <input type="text" id="storeName" placeholder="Awesome Store" oninput="updateProfile()" />
      </div>
    </form>

    <!-- Save Button -->
    <div class="actions">
      <button type="submit">Save Changes</button>
    </div>
  </div>

  <script>
    function updateProfile() {
      const name = document.getElementById("name").value || "Seller Name";
      const email = document.getElementById("email").value || "john@example.com";
      const phone = document.getElementById("phone").value || "+123456789";
      const store = document.getElementById("storeName").value || "Store Name";

      document.getElementById("displayName").textContent = name;
      document.getElementById("displayStore").textContent = store;
      document.getElementById("displayEmail").textContent = "Email: " + email;
      document.getElementById("displayPhone").textContent = "Phone: " + phone;
    }
  </script>
</body>
</html>
