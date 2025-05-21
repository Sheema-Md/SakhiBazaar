// Sidebar toggle and overlay logic
document.addEventListener('DOMContentLoaded', () => {
  const hamburger = document.getElementById('hamburger-btn');
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');

  if (hamburger && sidebar && overlay) {
    hamburger.addEventListener('click', () => {
      sidebar.classList.add('active');
      overlay.classList.add('active');
      hamburger.style.display = 'none';
    });

    overlay.addEventListener('click', () => {
      sidebar.classList.remove('active');
      overlay.classList.remove('active');
      hamburger.style.display = 'block';
    });

    document.querySelectorAll('.sidebar nav a').forEach(link => {
      link.addEventListener('click', function () {
        document.querySelectorAll('.sidebar nav a').forEach(el => el.classList.remove('active'));
        this.classList.add('active');
      });
    });

    // Handle screen resize
    window.addEventListener('resize', () => {
      if (window.innerWidth > 768) {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        hamburger.style.display = 'none';
      } else {
        hamburger.style.display = 'block';
      }
    });
  }

  // Set default language in localStorage
  if (!localStorage.getItem("preferredLanguage")) {
    localStorage.setItem("preferredLanguage", "te"); // Default: Telugu
  }

  // Google Translate init
  window.googleTranslateElementInit = function () {
    new google.translate.TranslateElement({
      pageLanguage: 'en',
      includedLanguages: 'en,hi,te,ur',
      autoDisplay: false,
      layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
  };

  // Apply previously selected language
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
          const langInput = document.getElementById("language-input");
          const langForm = document.getElementById("language-form");
          if (langInput && langForm) {
            langInput.value = selectedLang;
            langForm.submit();
          }
        });

        observer.disconnect();
      }
    });

    observer.observe(document.body, { childList: true, subtree: true });
  }

  // Load Google Translate Script
  const translateScript = document.createElement("script");
  translateScript.src = "//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";
  document.body.appendChild(translateScript);

  applySavedLanguage();
});
 function togglePanel() {
      const panel = document.getElementById('productPanel');
      panel.style.display = panel.style.display === 'flex' ? 'none' : 'flex';
    }

    function switchTab(tabId) {
      document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
      });
      document.getElementById(tabId).classList.add('active');
    }