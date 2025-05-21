<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SakhiBazaar</title>
  <link rel="stylesheet" href="css/styles.css" />
  <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet" />
  
</head>
<body>
    
  <div class="main-container">
    <header class="app-header">
      <h1 class="app-title" style="color:#e0cf1b;text-align:center;">SakhiBazaar</h1>
      <p class="tagline">From Every Home to the Market!</p>
      <div class="header-actions">
        <!-- Google Translate -->
        <div id="google_translate_element"></div>
        <!-- Speaker Icon -->
        <div class="speaker-icon" title="Audio Navigation">
          <img src="images/speaker.png" alt="" class="speaker-icon" onclick="toggleVoice()" aria-label="Toggle Voice Assistance">
        </div>
      </div>
    </header>

    <section class="hero-image"></section>

    <section class="call-to-action">
      <p class="cta-text">Start your career on SakhiBazaar by Signing in today!</p>
    </section>

    <section class="auth-buttons">
  <form action="login.php" method="get" style="display:inline;">
    <button class="btn login-btn" type="submit">Login</button>
  </form>
  <form action="registration.php" method="get" style="display:inline;">
    <button class="btn signup-btn" type="submit">Sign Up</button>
  </form>
</section>

  </div>

  <script>
    function toggleVoice() {
            alert("Voice feature toggled!");
        }

if (!localStorage.getItem("preferredLanguage")) {
      localStorage.setItem("preferredLanguage", "te"); // Telugu as default
    }

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
