<?php
require_once __DIR__ . '/../config/config.php';
/*require_once 'vendor/autoload.php';  // Ensure this is included at the top
require_once 'config.php';  // Your config file if any
$client = new Google_Client();
$client->setAuthConfig(); 
$client->addScope('email');
$client->addScope('profile');

$google_auth_url = $client->createAuthUrl();*/
session_start();
$registration_error = "";
$registration_success = "";

// Handle OTP Generation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate_otp'])) {
    $email = trim($_POST['email']);
    $otp_code = rand(100000, 999999);

    $_SESSION['otp_code'] = $otp_code;
    $_SESSION['form_data'] = $_POST;
    echo "<script>alert('Your OTP is: $otp_code');</script>";
    // For real application, send OTP via email/SMS here.
    // For demo, we'll just display it.
    $registration_success = "OTP Generated: $otp_code";

    // Optional: Store in DB as pending (skip if not needed)
    $stmt = $conn->prepare("INSERT INTO users (email, verification_code, status) VALUES (?, ?, 'pending') 
                            ON DUPLICATE KEY UPDATE verification_code = VALUES(verification_code), status = 'pending'");
    $stmt->bind_param("ss", $email, $otp_code);
    $stmt->execute();
    $stmt->close();
}

// Handle OTP Verification & User Registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_button'])) {
    $otp_input = $_POST['otp'];

    if (!isset($_SESSION['otp_code']) || $otp_input != $_SESSION['otp_code']) {
        $registration_error = "Invalid OTP entered.";
    } else {
        // Get latest form data from POST again
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $password = $_POST['password'];
        $language = $_POST['language'];
        $role = $_POST['role'];
        $aadhar = $_POST['aadhar'];


        // Validations
        if (
            strlen($password) < 8 ||
            !preg_match("/[A-Z]/", $password) ||
            !preg_match("/[a-z]/", $password) ||
            !preg_match("/\d/", $password) ||
            !preg_match("/[\W_]/", $password)
        ) {
            $registration_error = "Password must be at least 8 characters long and include uppercase, lowercase, digit, and special character.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $registration_error = "Invalid email format.";
        } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
            $registration_error = "Phone number must be exactly 10 digits.";
        } elseif (!preg_match("/^\d{12}$/", $aadhar)) {
            $registration_error = "Aadhar number must be 12 digits.";
        } else {
            // Check if already registered & verified
            $check_email = $conn->prepare("SELECT id, status FROM users WHERE email = ?");
            $check_email->bind_param("s", $email);
            $check_email->execute();
            $check_email->store_result();

            if ($check_email->num_rows > 0) {
                $check_email->bind_result($user_id, $existing_status);
                $check_email->fetch();

                if ($existing_status === 'verified') {
                    $registration_error = "Email is already registered & verified.";
                } else {
                    // Update the existing user with full data after OTP verify
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                    $verification_code = $_SESSION['otp_code'];
                    $status = 'verified';

                    $update_stmt = $conn->prepare("UPDATE users 
                        SET name=?, phone=?, address=?, password=?, language=?, role=?, aadhar=?, verification_code=?, status='verified'
                        WHERE email=?");
                    $update_stmt->bind_param("sssssssss", $name, $phone, $address, $hashed_password, $language, $role, $aadhar, $verification_code, $email);

                    if ($update_stmt->execute()) {
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['role'] = $role;

                        // Redirect based on role
                        header("Location: /separate-dash/{$role}_dashboard.php");
                        exit();
                    } else {
                        $registration_error = "Failed to update user.";
                    }
                    $update_stmt->close();
                }
            } else {
                // Insert new user
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $verification_code = $_SESSION['otp_code'];
                $status = 'verified';

                $insert_stmt = $conn->prepare("INSERT INTO users 
                    (name, email, phone, address, password, language, role, aadhar, verification_code, status)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $insert_stmt->bind_param("ssssssssss", $name, $email, $phone, $address, $hashed_password, $language, $role, $aadhar, $verification_code, $status);

                if ($insert_stmt->execute()) {
                    $_SESSION['user_id'] = $insert_stmt->insert_id;
                    $_SESSION['role'] = $role;

                    // Redirect based on role
                    header("Location:{$role}_dashboard.php");
                    exit();
                } else {
                    $registration_error = "Registration failed.";
                }
                $insert_stmt->close();
            }
            $check_email->close();
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body, html {
            height: 100%;
            font-family: 'Roboto', sans-serif;
            background: #EDE4F0;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px;
        }

        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        h2 {
            text-align: center;
            color: #e0cf1b;
        }

        .input-icon {
            position: relative;
            margin: 10px 0;
        }

        .input-icon i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .input-icon input,
        .input-icon select {
            width: 100%;
            padding: 10px 10px 10px 35px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .radio-container {
            display: flex;
            justify-content: space-around;
            margin: 10px 0;
        }

        .radio-container input {
            margin-right: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #d680e6;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #c66fd9;
        }

        .success-message {
            text-align: center;
            font-weight: bold;
            margin: 10px 0;
        }

        .success-message.success {
            color: green;
        }

        .success-message.error {
            color: red;
        }

        .google-signin-button {
            margin-top: 15px;
            width: 100%;
            background: white;
            border: 2px solid #4285f4;
            color: #4285f4;
            font-weight: 700;
            padding: 11px;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            user-select: none;
            transition: background-color 0.3s, color 0.3s;
        }

        .google-signin-button:hover {
            background: #4285f4;
            color: white;
        }

        .google-icon {
            width: 20px;
            height: 20px;
        }

        .login {
            margin-top: 20px;
            text-align: center;
            font-size: 1rem;
            color: #667eea;
        }

        .login a {
            color: #667eea;
            text-decoration: none;
        }

        .login a:hover {
            color: #764ba2;
            font-weight: bold;
        }
         .speaker-icon {
position: absolute;
top: 10px;
right: 10px;
cursor: pointer;
width: 28px;
height: 28px;
z-index: 10;
} 
        @media screen and (max-width: 480px) {
            .speaker-icon {
                width: 22px;
                height: 22px;
                top: 8px;
                right: 8px;
            }
        }
    </style>
</head>
<body>
    <img src="images/speaker.png" alt="Speaker Icon" class="speaker-icon" onclick="toggleVoice()">
    <div class="container">
        <h2>Signup</h2>
        <form action="" method="POST" onsubmit="return validateForm()">

            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input type="text" name="name" placeholder="Enter your name" required>
            </div>

            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" placeholder="Enter your email">
            </div>

            <div class="input-icon">
                <i class="fa fa-id-card"></i>
                <input type="text" name="aadhar" placeholder="Enter your Aadhar number" pattern="\d{12}" title="Aadhar Number should be 12 digits">
            </div>

            <div class="input-icon">
                <i class="fa fa-language"></i>
                <select name="language" required>
                    <option value="">Select Language</option>
                    <option value="english">English</option>
                    <option value="telugu">Telugu</option>
                    <option value="hindi">Hindi</option>
                    <option value="urdu">Urdu</option>
                </select>
            </div>

            <div class="radio-container">
                <label><input type="radio" name="role" value="seller" required> Seller</label>
                <label><input type="radio" name="role" value="buyer"> Buyer</label>
                
            </div>

            <div class="input-icon">
                <i class="fa fa-map-marker-alt"></i>
                <input type="text" name="address" placeholder="Enter your address" required>
            </div>

            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>

            <div class="input-icon">
                <i class="fa fa-phone"></i>
                <input type="tel" name="phone" placeholder="Enter your contact number">
            </div>

            <button type="submit" name="generate_otp">Generate OTP</button>

            <div class="input-icon">
                <i class="fa fa-key"></i>
                <input type="text" name="otp" placeholder="Enter OTP" required>
            </div>

            <button type="submit" name="verify_button">Verify</button>
        </form>

        <button class="google-signin-button" id="google-signin" aria-label="Sign in with Google">
            <svg class="google-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 533.5 544.3">
                <path fill="#4285f4" d="M533.5 278.4c0-18.6-1.5-36.5-4.5-53.9H272v102.1h146.9c-6.3 34-25.4 62.8-54.3 82v67h87.8c51.4-47.4 81.1-117.3 81.1-197.2z"/>
                <path fill="#34a853" d="M272 544.3c73.7 0 135.6-24.4 180.8-66.3l-87.8-67c-24.2 16.3-55.2 25.9-93 25.9-71.3 0-131.8-48.1-153.5-112.7H30v70.7C75.8 489.2 167.4 544.3 272 544.3z"/>
                <path fill="#fbbc04" d="M118.5 321.2c-6.1-18.6-9.6-38.5-9.6-58.7s3.5-40.1 9.6-58.7v-70.7H30c-19.3 38.1-30.3 81-30.3 129.4s11 91.3 30.3 129.4l88.5-70.7z"/>
                <path fill="#ea4335" d="M272 107.9c41.4 0 78.5 14.2 107.8 42.3l80.8-80.8C401 24.8 339 0 272 0 167.4 0 75.8 55.1 30 138.3l88.5 70.7c21.7-64.6 82.2-112.7 153.5-112.7z"/>
            </svg>
            Sign in with Google
        </button>

        <div class="login">
            <a href="login.php">Already have an Account?</a>
        </div>
    </div>


    <script>

        /*document.getElementById('google-signin').addEventListener('click', () => {
        window.location.href = '<?php echo $google_auth_url; ?>';
    });*/
        function toggleVoice() {
            alert("Voice feature toggled!");
        }

        function validateForm() {
            const aadhar = document.getElementById('aadhar').value;
            if (!/^\d{12}$/.test(aadhar)) {
                alert("Please enter a valid 12-digit Aadhar Number.");
                return false;
            }
            return true;
        }
        
document.querySelector('button[name="generate_otp"]').addEventListener('click', function(e) {
    e.preventDefault();  // prevent form submit

    const formData = new FormData(document.querySelector('form'));
    formData.append('generate_otp', '1');

    fetch('', {
        method: 'POST',
        body: new URLSearchParams(formData)
    })
    .then(response => response.text())
    .then(data => {
        const otpMatch = data.match(/alert\('Your OTP is: (\d{6})'\);/);
        if (otpMatch) {
            alert('Your OTP is: ' + otpMatch[1]);
        } else {
            alert('Failed to generate OTP. Try again.');
        }
    })
    .catch(err => {
        console.error(err);
        alert('An error occurred.');
    });
});




       

        function googleTranslateElementInit() {
      new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'en,hi,te,ur',
        autoDisplay: false,
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
      }, 'google_translate_element');
    }

    // Apply saved language automatically
    function applySavedLanguage() {
      const observer = new MutationObserver(() => {
        const select = document.querySelector(".goog-te-combo");
        if (select) {
          const savedLang = localStorage.getItem("preferredLanguage");
          if (savedLang && select.value !== savedLang) {
            select.value = savedLang;
            select.dispatchEvent(new Event("change"));
          }

          select.addEventListener("change", () => {
  const selectedLang = select.value;
  localStorage.setItem("preferredLanguage", selectedLang);

  // Submit to backend
  document.getElementById("language-input").value = selectedLang;
  document.getElementById("language-form").submit();
});


          observer.disconnect();
        }
      });

      observer.observe(document.body, { childList: true, subtree: true });
    }

    // Load Google Translate script
    (function loadTranslateScript() {
      const script = document.createElement("script");
      script.src = "//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";
      document.body.appendChild(script);
    })();

    document.addEventListener("DOMContentLoaded", applySavedLanguage);
    </script>
    </body>
</html>