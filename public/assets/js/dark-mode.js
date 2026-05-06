/* Dark mode js */
const html = document.documentElement;
const toggleBtn = document.getElementById("darkModeToggle");
const moonIcon = document.querySelector(".moonIcon");
const sunIcon = document.querySelector(".sunIcon");

if (toggleBtn) {
  toggleBtn.addEventListener("click", function () {
    const currentMode = html.getAttribute("data-mode");

    if (currentMode === "dark") {
      html.setAttribute("data-mode", "light");
      localStorage.setItem("theme", "light");
      if (moonIcon) moonIcon.classList.remove("hidden");
      if (sunIcon) sunIcon.classList.add("hidden");
    } else {
      html.setAttribute("data-mode", "dark");
      localStorage.setItem("theme", "dark");
      if (moonIcon) moonIcon.classList.add("hidden");
      if (sunIcon) sunIcon.classList.remove("hidden");
    }
  });
}

/* Rtl mode js */
const root = document.documentElement;
const directionToggle = document.getElementById("directionToggle");
const ltrText = directionToggle.querySelector(".ltrText");
const rtlText = directionToggle.querySelector(".rtlText");

if (directionToggle) {
  (function () {
    const savedDir = localStorage.getItem("direction");
    if (savedDir) {
      root.setAttribute("dir", savedDir);

      if (savedDir === "rtl") {
        if (ltrText) ltrText.classList.add("hidden");
        if (rtlText) rtlText.classList.remove("hidden");
      }
    }
  })();

  directionToggle.addEventListener("click", () => {
    const current = root.getAttribute("dir") === "rtl" ? "ltr" : "rtl";
    root.setAttribute("dir", current);
    localStorage.setItem("direction", current);

    if (ltrText) ltrText.classList.toggle("hidden");
    if (rtlText) rtlText.classList.toggle("hidden");
  });
}
