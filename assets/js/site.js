// Update these details before publishing. Leave WhatsApp number blank until verified.
const SCHOOL_CONFIG = {
  schoolName: "St. Xavier's High School, Siwan",
  phone: "",                 // Example format: 919XXXXXXXXX
  email: "",                 // Official school email
  address: "Siwan, Bihar, India",
  whatsapp: ""               // Digits only, with country code
};

const PHONE_REGEX = /^[1-9][0-9]{9}$/;
const EMAIL_REGEX = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

function showError(input, message) {
  input.classList.add("is-invalid");
  input.classList.remove("is-valid");
  let err = input.parentNode.querySelector(".invalid-feedback");
  if (!err) {
    err = document.createElement("div");
    err.className = "invalid-feedback d-block";
    input.parentNode.appendChild(err);
  }
  err.textContent = message;
}
function clearError(input) {
  input.classList.remove("is-invalid");
  input.classList.add("is-valid");
  const err = input.parentNode.querySelector(".invalid-feedback");
  if (err) err.remove();
}

function clearAllErrors(form) {
  form.querySelectorAll(".is-invalid,.is-valid").forEach(el => el.classList.remove("is-invalid","is-valid"));
  form.querySelectorAll(".invalid-feedback").forEach(el => el.remove());
}

function validateField(input) {
  const name = input.name;
  const value = input.value.trim();
  const required = input.hasAttribute("required");

  if (input.type === "checkbox") {
    if (required && !input.checked) {
      showError(input, "This field is required.");
      return false;
    }
    clearError(input);
    return true;
  }

  if (required && value === "") {
    showError(input, "This field is required.");
    return false;
  }

  if (name === "phone") {
    if (value !== "" && !PHONE_REGEX.test(value)) {
      showError(input, "Enter a valid 10-digit mobile number (must not start with 0).");
      return false;
    }
  }

  if (name === "email") {
    if (value !== "" && !EMAIL_REGEX.test(value)) {
      showError(input, "Enter a valid email address.");
      return false;
    }
  }

  clearError(input);
  return true;
}

function restrictPhoneDigits(input) {
  input.maxLength = 10;
  input.addEventListener("input", () => {
    input.value = input.value.replace(/\D/g, "").slice(0, 10);
    if (input.classList.contains("is-invalid")) validateField(input);
  });
  input.addEventListener("keydown", (e) => {
    if (!/^[0-9]$/.test(e.key) && ["Backspace","Delete","ArrowLeft","ArrowRight","Tab"].indexOf(e.key) === -1) {
      e.preventDefault();
    }
  });
}

function validateForm(form) {
  clearAllErrors(form);
  let valid = true;
  form.querySelectorAll("input, select, textarea").forEach(input => {
    if (!validateField(input)) valid = false;
  });
  return valid;
}

document.addEventListener("DOMContentLoaded", () => {
  const year = document.querySelectorAll("[data-year]");
  year.forEach(el => el.textContent = new Date().getFullYear());

  const current = location.pathname.split("/").pop() || "index.php";
  document.querySelectorAll(".navbar .nav-link, .navbar .dropdown-item").forEach(link => {
    const href = link.getAttribute("href");
    if (href === current) link.classList.add("active");
    link.addEventListener("click", () => {
      const menu = document.getElementById("mainNav");
      if (menu && menu.classList.contains("show") && window.bootstrap) {
        bootstrap.Collapse.getOrCreateInstance(menu).hide();
      }
    });
  });

  if ("IntersectionObserver" in window) {
    document.body.classList.add("reveal-enabled");
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
          observer.unobserve(entry.target);
        }
      });
    }, {threshold: .12});
    document.querySelectorAll(".reveal").forEach(el => observer.observe(el));
  }

  const backTop = document.querySelector(".back-top");
  if (backTop) {
    window.addEventListener("scroll", () => backTop.classList.toggle("show", window.scrollY > 500));
    backTop.addEventListener("click", () => window.scrollTo({top:0, behavior:"smooth"}));
  }

  // Live inline validation on blur
  document.querySelectorAll("[data-enquiry-form], [data-contact-form]").forEach(form => {
    form.querySelectorAll("input, select, textarea").forEach(input => {
      input.addEventListener("blur", () => validateField(input));
      input.addEventListener("input", () => {
        if (input.classList.contains("is-invalid")) validateField(input);
      });
      if (input.name === "phone") restrictPhoneDigits(input);
    });
  });

  document.querySelectorAll("[data-enquiry-form]").forEach(form => {
    form.addEventListener("submit", async event => {
      event.preventDefault();
      if (!validateForm(form)) return;

      const formData = new FormData(form);
      formData.append('form_type', 'admission');
      const status = form.querySelector("[data-form-status]");

      try {
        const resp = await fetch("submit-enquiry.php", {
          method: "POST",
          body: new URLSearchParams(formData)
        });
        const data = await resp.json();
        if (data.success) {
          if (status) status.textContent = data.message || "Enquiry submitted successfully!";
          form.reset();
          clearAllErrors(form);
        } else {
          if (status) status.textContent = data.error || "Submission failed. Please try again.";
        }
      } catch (e) {
        if (status) status.textContent = "Network error. Please try again.";
      }
    });
  });

  document.querySelectorAll("[data-contact-form]").forEach(form => {
    form.addEventListener("submit", async event => {
      event.preventDefault();
      if (!validateForm(form)) return;

      const formData = new FormData(form);
      formData.append('form_type', 'contact');
      const status = form.querySelector("[data-contact-status]") || form.querySelector("[data-form-status]");

      try {
        const resp = await fetch("submit-enquiry.php", {
          method: "POST",
          body: new URLSearchParams(formData)
        });
        const data = await resp.json();
        if (data.success) {
          if (status) status.textContent = data.message || "Message sent successfully!";
          form.reset();
          clearAllErrors(form);
        } else {
          if (status) status.textContent = data.error || "Submission failed. Please try again.";
        }
      } catch (e) {
        if (status) status.textContent = "Network error. Please try again.";
      }
    });
  });

  document.querySelectorAll("[data-gallery-filter]").forEach(button => button.addEventListener("click", () => {
    document.querySelectorAll("[data-gallery-filter]").forEach(b => b.classList.remove("active"));
    button.classList.add("active");
    const filter = button.dataset.galleryFilter;
    document.querySelectorAll("[data-gallery-item]").forEach(item => {
      item.hidden = !(filter === "all" || item.dataset.galleryItem === filter);
    });
  }));
});
