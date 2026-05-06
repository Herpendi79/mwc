/* Mobile Menu js */
const mobileMenuBtn = document.getElementById("mobile-menu-btn");
const mobileCloseBtn = document.getElementById("mobile-close-btn");
const mobileSidebar = document.querySelector(".fixed.inset-y-0.left-0");
mobileMenuBtn.addEventListener("click", () => {
  mobileSidebar.classList.remove("-translate-x-full");
  mobileSidebar.classList.add("translate-x-0");
});
mobileCloseBtn.addEventListener("click", () => {
  mobileSidebar.classList.remove("translate-x-0");
  mobileSidebar.classList.add("-translate-x-full");
});
document.addEventListener("click", (e) => {
  if (!mobileSidebar.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
    mobileSidebar.classList.add("-translate-x-full");
    mobileSidebar.classList.remove("translate-x-0");
  }
});
document.querySelectorAll(".mobile-dropdown-btn").forEach((btn) => {
  btn.addEventListener("click", function () {
    const dropdown = this.nextElementSibling; 
    const plus = this.querySelector(".ri-add-line");
    const minus = this.querySelector(".ri-subtract-line"); 
    dropdown.classList.toggle("max-h-0");
    dropdown.classList.toggle("max-h-96"); 
    plus.classList.toggle("hidden");
    minus.classList.toggle("hidden");
  });
});
