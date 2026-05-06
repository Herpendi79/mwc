/* Search bar js */
const openBtn = document.getElementById("openSearch");
const closeBtn = document.getElementById("closeSearch");
const bar = document.getElementById("searchBar");
const box = document.getElementById("searchBox");

openBtn.addEventListener("click", () => {
  bar.classList.remove("hidden");

  // smooth fade + expand
  setTimeout(() => {
    bar.classList.remove("opacity-0");
    box.classList.remove("scale-50", "opacity-0");
  }, 10);
});

closeBtn.addEventListener("click", () => {
  // smooth shrink + fade
  bar.classList.add("opacity-0");
  box.classList.add("scale-50", "opacity-0");

  setTimeout(() => {
    bar.classList.add("hidden");
  }, 500); // match animation duration
});
