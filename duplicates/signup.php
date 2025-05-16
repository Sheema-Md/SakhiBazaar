<?php
session_start();
$conn = new mysqli("localhost", "root", "", "sakhibazaar");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
require 'vendor/autoload.php'; // Include PHPMailer's autoload file
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



$registration_success = "";
$registration_error = "";
if (isset($_POST["generate_otp"])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $language = $_POST['language'];
    $role = $_POST['role'];
    $aadhar = $_POST['aadhar'];

    // Password validation
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
        // Duplicate email check
        $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check_email->bind_param("s", $email);
        $check_email->execute();
        $check_email->store_result();
        if ($check_email->num_rows > 0) {
            $registration_error = "Email is already registered.";
        }
        $check_email->close();
    }

    if (empty($registration_error)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

        // Send OTP mail
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
             $mail->SMTPDebug = 2;
$mail->Debugoutput = 'html';

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom('mohammedsheemasadiya@gmail.com', 'SakhiBazaar');
            $mail->Username = 'mohammedsheemasadiya@gmail.com';
            $mail->Password = 'mngs sonk nzyg tdqj';
            $mail->addAddress($email, $name);
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $mail->Body = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';

              if ($mail->send()) {
    echo "Email sent successfully.";
} else {
    echo "Mailer Error: " . $mail->ErrorInfo;
}

            // Insert into users
            $sql = "INSERT INTO users (name, email, phone, address, password, language, role, aadhar, verification_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssss", $name, $email, $phone, $address, $hashed_password, $language, $role, $aadhar, $verification_code);

            if ($stmt->execute()) {
                $user_id = $stmt->insert_id;

                // Insert into role-specific table
                switch ($role) {
                    case 'seller':
                        $table = 'sellers';
                        $dashboard = 'seller5.php';
                        break;
                    case 'buyer':
                        $table = 'buyers';
                        $dashboard = 'buyer_dashboard.php';
                        break;
                    case 'admin':
                        $table = 'admins';
                        $dashboard = 'admin_dashboard.php';
                        break;
                    default:
                        $registration_error = "Invalid role selected.";
                        break;
                }

                if (empty($registration_error)) {
                    $role_sql = "INSERT INTO $table (id, name, email, phone, address, password, language, aadhar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    $role_stmt = $conn->prepare($role_sql);
                    $role_stmt->bind_param("isssssss", $user_id, $name, $email, $phone, $address, $hashed_password, $language, $aadhar);
                    if ($role_stmt->execute()) {
                        $_SESSION['name'] = $name;
                        $_SESSION['role'] = $role;
                        $_SESSION['user_id'] = $user_id;
                        header("Location: $dashboard");
                        exit();
                    } else {
                        $registration_error = "Role insert error: " . $role_stmt->error;
                    }
                }
            } else {
                $registration_error = "User insert error: " . $stmt->error;
            }
        } catch (Exception $e) {
            $registration_error = "Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

$conn->close();

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
    background: linear-gradient(135deg, #d680e6, #e0cf1b);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 15px;
  }

        .container {
    width: 90%;
    max-width: 600px;
    margin: auto;
    background: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.15);
    position: relative;
}

        h2 {
            text-align: center;
            color: #e0cf1b;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        select {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
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


       .speaker-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
    width: 28px;
    height: 28px;
    z-index: 10;
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
    margin-top: 20px;  /* Increased margin for better spacing */
    text-align: center; /* Centered the text */
    font-size: 1rem;    /* Adjusted font size for better visibility */
    color: #667eea;     /* Original color */
    text-decoration: none; /* No underline */
    transition: color 0.3s, font-weight 0.3s; /* Added transition for font-weight */
}

.login a {
     /* Made the link bold */
    color: #667eea;     /* Original color */
    text-decoration: none; /* No underline */
}

.login a:hover {
    color: #764ba2;     /* Change color on hover */
    font-weight: bold;  /* Keep bold on hover */
}
@media screen and (max-width: 768px) {
    .container {
        max-width: 90%;
        padding: 20px;
    }
}

/* Mobile view adjustments */
@media screen and (max-width: 480px) {
    .container {
        max-width: 100%;
        padding: 15px;
        border-radius: 6px;
    }

    

    .input-icon i {
        left: 8px;
    }

    .input-icon input,
    .input-icon select {
        padding-left: 32px;
    }
}

        @media screen and (max-width: 480px) {
            h2 {
                font-size: 1.5em;
            }

            .radio-container label {
                flex: 1 1 100%;
                text-align: left;
            }

            .speaker-icon {
    width: 22px;
    height: 22px;
    top: 8px;
    right: 8px;
}

        }
    </style>
</head>

<body> <img src="images/speaker.png" alt="Speaker Icon" class="speaker-icon" onclick="toggleVoice()">
    <div class="container">
        <h2>Signup</h2>
        <div id="google_translate_element"></div>
        <?php if (!empty($registration_error)): ?>
            <div class="success-message error"><?php echo $registration_error; ?></div>
        <?php endif; ?>

        <?php if (!empty($registration_success)): ?>
            <div class="success-message success"><?php echo $registration_success; ?></div>
        <?php endif; ?>

        <form action = ""method="POST" onsubmit="return validateForm()">
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
                <label><input type="radio" name="role" value="admin"> Admin</label>
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
    <svg class="google-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 533.5 544.3" aria-hidden="true" focusable="false">
      <path fill="#4285f4" d="M533.5 278.4c0-18.6-1.5-36.5-4.5-53.9H272v102.1h146.9c-6.3 34-25.4 62.8-54.3 82v67h87.8c51.4-47.4 81.1-117.3 81.1-197.2z"/>
      <path fill="#34a853" d="M272 544.3c73.7 0 135.6-24.4 180.8-66.3l-87.8-67c-24.2 16.3-55.2 25.9-93 25.9-71.3 0-131.8-48.1-153.5-112.7H30v70.7C75.8 489.2 167.4 544.3 272 544.3z"/>
      <path fill="#fbbc04" d="M118.5 321.2c-6.1-18.6-9.6-38.5-9.6-58.7s3.5-40.1 9.6-58.7v-70.7H30c-19.3 38.1-30.3 81-30.3 129.4s11 91.3 30.3 129.4l88.5-70.7z"/>
      <path fill="#ea4335" d="M272 107.9c41.4 0 78.5 14.2 107.8 42.3l80.8-80.8C401 24.8 339 0 272 0 167.4 0 75.8 55.1 30 138.3l88.5 70.7c21.7-64.6 82.2-112.7 153.5-112.7z"/>
    </svg>
    Sign in with Google
  </button>
   <div class="login">
            <a href="login.php" tabindex="0">Already have an Account?</a>
        </div>
    </div>
   
    <script>
        document.getElementById('generate-otp').addEventListener('click', function() {
            alert('OTP has been sent to your registered mobile number!');
        });

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
       /* document.getElementById('generate-otp').addEventListener('click', function() {
    const phone = document.getElementById('phone').value;
    if (!/^\d{10}$/.test(phone)) {
        alert('Please enter a valid 10-digit phone number.');
        return;
    }

    fetch('generate_otp.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `phone=${phone}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('OTP has been sent to your registered mobile number!\n(For testing, OTP is: ' + data.otp + ')');
        } else {
            alert('Failed to send OTP.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while generating OTP.');
    });
});*/

        document.getElementById('google-signin').addEventListener('click', () => {
            const googleAuth = 'YOUR_GOOGLE_AUTH_URL';
            window.location.href = googleAuth;
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