                        <?php
session_start();
// Prevent Session Hijacking

$conn = new mysqli("localhost", "root", "", "sakhibazaar");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$email = $password = '';
$emailErr = $passwordErr = $loginErr = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email)) {
        $emailErr = "Email is required";
    }

    if (empty($password)) {
        $passwordErr = "Password is required";
    }

    if (empty($emailErr) && empty($passwordErr)) {
        $sql = "SELECT id, password, role FROM users WHERE email = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
    $stmt->store_result();
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashedPassword, $role);
        $stmt->fetch();
        if (password_verify($password, $hashedPassword)) {
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $id;
            $_SESSION["email"] = $email;
            $_SESSION["role"] = $role;

            switch ($role) {
                case 'admin':
                    header("Location: admin_dashboard.php");
                    break;
                case 'seller':
                    header("Location: seller_dashboard.php");
                    break;
                case 'buyer':
                    header("Location: buyer_dashboard.php");
                    break;
                default:
                    $loginErr = "Unknown user role.";
            }
            exit();
        } else {
           $loginErr = "Invalid email or password.";
 // << Specific message
        }
    } else {
        $loginErr = "Invalid email or password.";
 // << Specific message
    }
    $stmt->close();
} else {
    $loginErr = "Execution failed";
}

        } else {
            $loginErr = "Database error";
        }
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<title>Login Page</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}
body, html {
    height: 100%;
    font-family: 'Roboto', sans-serif;
 
    background:#EDE4F0;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 15px;
}
.container {
    background: #fff;
    border-radius: 15px;
    width: 100%;
    max-width: 350px;
    padding: 30px 25px 40px 25px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    position: relative;
    min-height: 400px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.container h2 {
    text-align: center;
    margin-bottom: 25px;
    font-weight: 700;
    color: #333;
}
.form-group {
    margin-bottom: 20px;
}
label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: #555;
}
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s;
}
input[type="email"]:focus,
input[type="password"]:focus {
    border-color: #667eea;
    outline: none;
}
.error-msg {
    color: #e74c3c;
    font-size: 0.875rem;
    margin-top: 5px;
}
button {
    margin-top: 15px;
    width: 100%;
    background: #d680e6;
    color: white;
    padding: 13px;
    border-radius: 8px;
    border: none;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}
button:hover {
    background: #5a67d8;
}
.forget-password {
    margin-top: 15px;
    text-align: right;
}
.forget-password a {
    font-size: 0.9rem;
    color: #667eea;
    text-decoration: none;
    transition: color 0.3s;
}
.forget-password a:hover {
    color: #764ba2;
}
.sign-up {
    margin-top: 15px;
    text-align: right;
}
.sign-up a {
    font-size: 0.9rem;
    color: #667eea;
    text-decoration: none;
    transition: color 0.3s;
}
.sign-up a:hover {
    color: #764ba2;
}
.speaker-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            cursor: pointer;
            width: 30px;
            height: 30px;
        }
.speaker-icon:hover {
    fill: #764ba2;
}
@media (max-width: 400px) {
    .container {
        padding: 25px 20px 35px 20px;
        min-height: 360px;
    }
    .speaker-icon {
                width: 22px;
                height: 22px;
            }
}
</style>
</head>
<body>

<div class="container" role="main" aria-labelledby="loginTitle">
    

    <h2 id="loginTitle">Login</h2>
<img src="images/speaker.png" alt="" class="speaker-icon" onclick="toggleVoice()" aria-label="Toggle Voice Assistance">

<div id="google_translate_element"></div>
    <?php if ($loginErr): ?>
    <div class="error-msg" role="alert" aria-live="polite"><?php echo htmlspecialchars($loginErr); ?></div>
    <?php endif; ?>

   <form id="loginForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>


        <div class="form-group">
            <label for="email">Email address</label>
            <input 
              type="email" 
              id="email" 
              name="email" 
              placeholder="you@example.com" 
              value="<?php echo htmlspecialchars($email); ?>" 
              aria-describedby="emailError"
              required
            />
            <div id="emailError" class="error-msg" aria-live="polite"><?php echo htmlspecialchars($emailErr); ?></div>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input 
              type="password" 
              id="password" 
              name="password" 
              placeholder="Your password" 
              aria-describedby="passwordError" 
              required
            />
            <div id="passwordError" class="error-msg" aria-live="polite"><?php echo htmlspecialchars($passwordErr); ?></div>
        </div>
<div class="sign-up">
            <a href="registration.php" tabindex="0">Don't have an Account?</a>
        </div>
        <div class="forget-password">
            <a href="#" tabindex="0">Forgot password?</a>
        </div>

        <button type="submit">Login</button>
    </form>
</div>
<div id="loadingSpinner" style="display:none;">Loading...</div>


<script>
    function toggleVoice() {
            alert("Voice feature toggled!");
        }

    document.getElementById('loginForm').addEventListener('submit', function() {
    document.getElementById('loadingSpinner').style.display = 'block';
});
document.getElementById('loginForm').addEventListener('submit', function(e) {
    let formValid = true;
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');

    // Clear previous errors
    emailError.textContent = '';
    passwordError.textContent = '';

    // Validate email
    const emailValue = emailInput.value.trim();
    if (!emailValue) {
        emailError.textContent = 'Email is required';
        formValid = false;
    } else {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailValue)) {
            emailError.textContent = 'Invalid email format';
            formValid = false;
        }
    }

    // Validate password
    const passwordValue = passwordInput.value.trim();
    if (!passwordValue) {
        passwordError.textContent = 'Password is required';
        formValid = false;
    }

    if (!formValid) {
        e.preventDefault();
    }
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

