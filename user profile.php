<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Seller Profile Page</title>
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
    .camera-icon {
      position: absolute;
      right: 5px;
      bottom: 5px;
      background: rgba(0,0,0,0.6);
      color: white;
      border-radius: 50%;
      width: 22px;
      height: 22px;
      font-size: 14px;
      display: flex;
      justify-content: center;
      align-items: center;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    .avatar:hover .camera-icon {
      opacity: 1;
    }
    #removePicBtn {
      margin-top: 10px;
      padding: 6px 12px;
      font-size: 0.85rem;
      border: 2px solid var(--purple);
      border-radius: 6px;
      background: white;
      color: var(--purple);
      cursor: pointer;
      transition: background 0.3s ease, color 0.3s ease;
      display: none;
    }
    #removePicBtn:hover {
      background: var(--purple);
      color: white;
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
  </style>
</head>
<body>
  <div class="container">
    <!-- Profile Overview -->
    <section class="profile-section" aria-label="Profile Overview">
      <input type="file" id="upload" accept="image/*" />
      <label for="upload" class="avatar" title="Change Profile Picture">
        <img id="profilePic" src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Profile Picture" />
        <span class="camera-icon">&#128247;</span>
      </label>
      <button type="button" id="removePicBtn" aria-label="Remove profile picture">Remove Picture</button>
      <p class="profile-info" id="dispName">Seller Name</p>
      <p class="profile-info" id="dispStore">Store Name</p>
      <div class="stats" aria-label="Store statistics">
        <div>Total Products: 120</div>
        <div>Store Rating: ★ 4.5</div>
      </div>
    </section>

    <!-- Editable Information Form -->
    <form id="profileForm" novalidate>
      <div class="form-grid">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" placeholder="John Doe" />
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="john@example.com" />
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" placeholder="+1234567890" />
        <label for="storeName">Store Name</label>
        <input type="text" id="storeName" name="storeName" placeholder="Awesome Store" />
        <label for="occupation">Occupation</label>
        <input list="occupationList" id="occupation" name="occupation" placeholder="Type or select occupation" />
        <datalist id="occupationList">
          <option value="teacher">
          <option value="home maker">
          <option value="farmer">
          <option value="Retailer">
          <option value="Other">
        </datalist>
        <label for="pincode">Pincode</label>
        <input type="text" id="pincode" name="pincode" placeholder="123456" />
        <label for="city">City</label>
        <input list="cityList" id="city" name="city" placeholder="Type or select city" />
        <datalist id="cityList">
          <option value="atmakur">
          <option value="nellore">
          <option value="hyderabad">
          <option value="tirupathi">
          <option value="Other">
        </datalist>
        <label for="state">State</label>
        <input list="stateList" id="state" name="state" placeholder="Type or select state" />
        <datalist id="stateList">
          <option value="andhra pradesh">
          <option value="telangana">
          <option value="tamilnadu">
          <option value="karnataka">
          <option value="Other">
        </datalist>
      </div>
      <div class="actions">
        <button type="submit" id="saveBtn">Save Changes</button>
      </div>
    </form>
  </div>

  <script>
    const defaultPic = "https://cdn-icons-png.flaticon.com/512/149/149071.png";
    const profilePic = document.getElementById("profilePic");
    const uploadInput = document.getElementById("upload");
    const removeBtn = document.getElementById("removePicBtn");
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

    function loadProfile() {
      const profileData = JSON.parse(localStorage.getItem("sellerProfile")) || {};
      profilePic.src = profileData.pic || defaultPic;
      removeBtn.style.display = profileData.pic ? "inline-block" : "none";
      nameInput.value = profileData.name || "";
      emailInput.value = profileData.email || "";
      phoneInput.value = profileData.phone || "";
      storeInput.value = profileData.storeName || "";
      occupationInput.value = profileData.occupation || "";
      pincodeInput.value = profileData.pincode || "";
      cityInput.value = profileData.city || "";
      stateInput.value = profileData.state || "";
      dispName.textContent = profileData.name || "Seller Name";
      dispStore.textContent = profileData.storeName || "Store Name";
    }

    uploadInput.addEventListener("change", () => {
      const file = uploadInput.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = e => {
          profilePic.src = e.target.result;
          removeBtn.style.display = "inline-block";
        };
        reader.readAsDataURL(file);
      }
    });

    removeBtn.addEventListener("click", () => {
      profilePic.src = defaultPic;
      uploadInput.value = "";
      removeBtn.style.display = "none";
    });

    function validateEmail(email) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
    function validatePhone(phone) {
      return /^\+?[0-9\s\-]{7,15}$/.test(phone);
    }

    form.addEventListener("submit", e => {
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
      const profileData = {
        pic: profilePic.src === defaultPic ? null : profilePic.src,
        name: nameInput.value.trim() || "Seller Name",
        email: emailInput.value.trim(),
        phone: phoneInput.value.trim(),
        storeName: storeInput.value.trim() || "Store Name",
        occupation: occupationInput.value.trim(),
        pincode: pincodeInput.value.trim(),
        city: cityInput.value.trim(),
        state: stateInput.value.trim(),
      };
      localStorage.setItem("sellerProfile", JSON.stringify(profileData));
      dispName.textContent = profileData.name;
      dispStore.textContent = profileData.storeName;
      alert("Changes saved successfully!");
    });

    loadProfile();
  </script>
</body>
</html>
