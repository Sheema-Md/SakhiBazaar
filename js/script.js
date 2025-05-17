 const hamburger = document.getElementById('hamburger-btn');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');

hamburger.addEventListener('click', () => {
    sidebar.classList.add('active');
    overlay.classList.add('active');
    hamburger.style.display = 'none'; // Hide hamburger
});

overlay.addEventListener('click', () => {
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
    hamburger.style.display = 'block'; // Show hamburger again
});

document.querySelectorAll('.sidebar nav a').forEach(link => {
    link.addEventListener('click', function() {
        // Remove 'active' from all links
        document.querySelectorAll('.sidebar nav a').forEach(el => el.classList.remove('active'));

        // Add 'active' to clicked link
        this.classList.add('active');
    });
});

// ✅ Fix: Handle window resize to reset states on desktop view
window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
        // Remove sidebar & overlay active classes
        sidebar.classList.remove('active');
        overlay.classList.remove('active');

        // Ensure hamburger icon is hidden in desktop mode
        hamburger.style.display = 'none';
    } else {
        // On smaller screens, hamburger should be visible
        hamburger.style.display = 'block';
    }
});

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