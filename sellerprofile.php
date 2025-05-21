<?php require_once "config.php";
session_start();

$user_id = $_SESSION['id'];

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    // User not found — handle error or redirect
    echo "User not found";
    exit();
}
// Total products by this user
$product_stmt = $conn->prepare("SELECT COUNT(*) AS total FROM products WHERE user_id = ?");
$product_stmt->bind_param("i", $user_id);
$product_stmt->execute();
$product_result = $product_stmt->get_result();
$product_data = $product_result->fetch_assoc();

// Average rating for this user's store
$rating_stmt = $conn->prepare("SELECT AVG(rating) AS avg_rating FROM products WHERE user_id = ?");
$rating_stmt->bind_param("i", $user_id);
$rating_stmt->execute();
$rating_result = $rating_stmt->get_result();
$rating_data = $rating_result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Seller Profile Page</title>
  <script src = "js/script.js"></script>
  <style>
    :root {
      --lavender: #e6e6fa;
      --purple: #6a0dad;
      --light-purple: #f3e8ff;
      --error-red: #e74c3c;
    }
    body {
      font-family: Arial, sans-serif;
      background: var(--lavender);
      margin: 0;
      padding: 20px;
    }
    .container {
      max-width: 700px;
      margin: 0 auto;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      display: flex;
      flex-direction: column;
      gap: 30px;
    }
    .profile-section {
      background: var(--light-purple);
      padding: 40px 20px;
      border-radius: 10px;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }
    .avatar {
      position: relative;
      width: 80px;
      height: 80px;
      border-radius: 50%;
      overflow: hidden;
      border: 3px solid var(--purple);
      margin-bottom: 20px;
      cursor: pointer;
    }
    .avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }
    
    .avatar:hover  {
      opacity: 1;
    }
    
    .profile-info {
      color: var(--purple);
      font-weight: 600;
      margin: 6px 0;
      font-size: 1.1rem;
    }
    .stats {
      margin-top: 20px;
      display: flex;
      justify-content: center;
      gap: 40px;
      font-weight: bold;
      color: var(--purple);
      font-size: 1.1rem;
    }
    
.photo-buttons {
  display: flex;
  flex-direction: column;
  gap: 10px;
  width: 100%;
  max-width: 250px;
  margin-top: 10px;
}
#removePicBtn{
   background-color: var(--purple);
  color: white;
  border: none;
  padding: 10px 16px;
  border-radius: 6px;
  font-size: 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.2s ease;
}
.photo-buttons button   {
  background-color: var(--purple);
  color: white;
  border: none;
  padding: 10px 16px;
  border-radius: 6px;
  font-size: 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.photo-buttons button :hover  {
  background-color: #4b0082;
  transform: scale(1.03);
}

.photo-buttons button:active  {
  transform: scale(0.97);
}
.mobile-back-button {
  display: none;
  position: fixed;
  top: 15px;
  left: 15px;
  z-index: 999;
  background: var(--purple);
  color: white;
  border: none;
  border-radius: 6px;
  padding: 10px 16px;
  font-size: 1rem;
  cursor: pointer;
  box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}
.mobile-back-button:hover {
  background: #4b0082;
}

    @media (max-width: 480px) {
      .stats {
        flex-direction: column;
        gap: 10px;
      }
    }
    form {
      padding: 30px 20px;
    }
    .form-grid {
  display: grid;
  grid-template-columns: 130px 1fr;
  gap: 15px 20px;
  align-items: center;
}


    @media (max-width: 480px) {
      .form-grid {
        grid-template-columns: 1fr;
      }
    }
    label {
      font-weight: 600;
      color: #333;
    }
    input, select, datalist {
      padding: 10px;
      font-size: 1rem;
      border: 1.5px solid #ccc;
      border-radius: 6px;
      width: 100%;
      box-sizing: border-box;
      transition: border-color 0.3s ease;
    }
    input:focus, select:focus {
      border-color: var(--purple);
      outline: none;
    }
    input.invalid, select.invalid {
      border-color: var(--error-red);
      background-color: #ffe6e6;
    }
    .actions {
      margin-top: 25px;
      text-align: center;
    }
    button#saveBtn {
      background: var(--purple);
      border: none;
      padding: 14px 32px;
      border-radius: 8px;
      color: white;
      font-size: 1.1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    button#saveBtn:hover {
      background: #4b0082;
    }
    #upload {
      position: absolute;
      width: 0.1px;
      height: 0.1px;
      opacity: 0;
      overflow: hidden;
      z-index: -1;
    }
    @media (max-width: 768px) {
    .mobile-back-button {
    display: block;
  }
}
  </style>
</head>
<body>
  <button class="mobile-back-button" onclick="history.back()">←</button>

  <div class="container">
    <!-- Profile Overview -->
    <section class="profile-section" aria-label="Profile Overview">
      

      <label for="upload" class="avatar" title="Change Profile Picture">
        <img id="profilePic" src="<?= !empty($user['profile_picture']) ? htmlspecialchars($user['profile_picture']) : 'https://cdn-icons-png.flaticon.com/512/149/149071.png' ?>" alt="Profile Picture" />


      </label>
      <div class="photo-buttons">
      
<button id="upload-image">Upload Profile Picture </button>
  </div>


<input type="file" id="profile_picture" accept="image/*" style="display:none" value="<?= htmlspecialchars($user['profile_picture']) ?>"/>
      <button type="button" id="removePicBtn" aria-label="Remove profile picture">Remove Picture</button>
      <p class="profile-info" id="dispName"></p>
      <p class="profile-info" id="dispStore"></p>
      <div class="stats" aria-label="Store statistics">
  <div>Total Products: <?= $product_data['total'] ?? 0 ?></div>
  <div>Store Rating: <?= $rating_data['avg_rating'] ? number_format($rating_data['avg_rating'], 1) : "N/A" ?></div>
</div>

    </section>

    <!-- Editable Information Form -->
    <form id="profileForm" enctype="multipart/form-data" novalidate>

      <div class="form-grid">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" placeholder="John Doe"value="<?= htmlspecialchars($user['name']) ?>" />
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="john@example.com" value="<?= htmlspecialchars($user['email']) ?>"/>
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" placeholder="+9945781236" value="<?= htmlspecialchars($user['phone']) ?>"/>
        <label for="storeName">Store Name</label>
        <input type="text" id="storeName" name="storeName" placeholder="Awesome Store" value="<?= htmlspecialchars($user['store_name']) ?>" required/>
        <label for="occupation">Occupation</label>
        <input list="occupationList" id="occupation" name="occupation" placeholder="Type or select occupation" value="<?= htmlspecialchars($user['occupation']) ?>"/>
        <datalist id="occupationList">
          <option value="Teacher">
          <option value="Home Maker">
          <option value="Farmer">
          <option value="Retailer">
          <option value="Other">
        </datalist>
        <label for="pincode">Pincode</label>
        <input type="text" id="pincode" name="pincode" placeholder="524003" value="<?= htmlspecialchars($user['pincode']) ?>"/>
        <label for="city">City</label>
        <input list="cityList" id="city" name="city" placeholder="Type or select city"  value="<?= htmlspecialchars($user['city']) ?>"/>
        <datalist id="cityList">
          <option value="Vizag">
          <option value="Nellore">
          <option value="Hyderabad">
          <option value="Tirupathi">
          <option value="Other">
        </datalist>
        <label for="state">State</label>
        <input list="stateList" id="state" name="state" placeholder="Type or select state" value="<?= htmlspecialchars($user['state']) ?>"/>
        <datalist id="stateList">
          <option value="Andhra pradesh">
          <option value="Telangana">
          <option value="Tamilnadu">
          <option value="Karnataka">
          <option value="Other">
        </datalist>
      </div>
      <div class="actions">
        <button type="submit" id="saveBtn">Save Changes</button>
      </div>
    </form>
    <!-- Financial/Loan Eligibility Section -->
<div id="statusMsg"></div>

  </div>

  <script>
  const defaultPic = "https://cdn-icons-png.flaticon.com/512/149/149071.png";
  const profilePic = document.getElementById("profilePic");
  const removeBtn = document.getElementById("removePicBtn");
  const uploadBtn = document.getElementById("upload-image");
  const galleryInput = document.getElementById("profile_picture");

  // Inputs and display elements
  const dispName = document.getElementById("dispName");
  const dispStore = document.getElementById("dispStore");
  const form = document.getElementById("profileForm");
  const nameInput = document.getElementById("name");
  const emailInput = document.getElementById("email");
  const phoneInput = document.getElementById("phone");
  const storeInput = document.getElementById("storeName");
  const occupationInput = document.getElementById("occupation");
  const pincodeInput = document.getElementById("pincode");
  const cityInput = document.getElementById("city");
  const stateInput = document.getElementById("state");

  // Function to update buttons visibility based on current profile pic src
  function updatePicButtonsVisibility() {
    if (profilePic.src && !profilePic.src.includes(defaultPic)) {
      removeBtn.style.display = "inline-block";
      uploadBtn.style.display = "none";
    } else {
      removeBtn.style.display = "none";
      uploadBtn.style.display = "inline-block";
    }
  }

  // Initial update on page load
  updatePicButtonsVisibility();
dispName.textContent = "<?= htmlspecialchars($user['name']) ?: 'Seller Name' ?>";
dispStore.textContent = "<?= htmlspecialchars($user['store_name']) ?: 'Store Name' ?>";

  // Clicking the upload button triggers file input click
  uploadBtn.addEventListener("click", () => galleryInput.click());

  // When a new picture is selected, preview it and update buttons
  galleryInput.addEventListener("change", () => {
    const file = galleryInput.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = e => {
        profilePic.src = e.target.result;
        updatePicButtonsVisibility();
      };
      reader.readAsDataURL(file);
    }
  });

  // Remove picture button resets picture to default and updates buttons
  removeBtn.addEventListener("click", () => {
    profilePic.src = defaultPic;
    galleryInput.value = ""; // Clear the input
    updatePicButtonsVisibility();
  });

  // Form validation helpers
  function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  function validatePhone(phone) {
    return /^\+?[0-9\s\-]{7,15}$/.test(phone);
  }

  // Form submit handler
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    emailInput.classList.remove("invalid");
    phoneInput.classList.remove("invalid");
    let valid = true;

    if (!validateEmail(emailInput.value)) {
      emailInput.classList.add("invalid");
      valid = false;
    }
    if (!validatePhone(phoneInput.value)) {
      phoneInput.classList.add("invalid");
      valid = false;
    }
    if (!valid) {
      alert("Please fix the errors in the form.");
      return;
    }

    // Prepare form data to send to PHP
    const formData = new FormData(this);

    // Append the profile picture file if any selected
    if (galleryInput.files[0]) {
      formData.set("profile_picture", galleryInput.files[0]);
    } else if (profilePic.src.includes(defaultPic)) {
      // If picture is default, send empty string or null to remove picture on server side
      formData.set("profile_picture", "");
    }

    fetch("update_profile.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.text())
      .then((data) => {
        document.getElementById("statusMsg").innerText = data;

        // Update displayed name and store after successful save
        dispName.textContent = nameInput.value.trim() || "Seller Name";
        dispStore.textContent = storeInput.value.trim() || "Store Name";

        alert("Changes saved successfully!");

        setTimeout(() => {
          window.location.href = "seller_dashboard2.php";
        }, 500);
      })
      .catch((err) => {
        alert("Failed to save changes: " + err.message);
      });
  });

</script>

</body>
</html>


