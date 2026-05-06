/*  glightbox js */
const lightbox = GLightbox({
  selector: ".glightbox",
  touchNavigation: true,
  loop: true,
  zoomable: true,
});

/* scroll down js */
document.getElementById("scrollDownBtn").addEventListener("click", () => {
  window.scrollBy({
    top: window.innerHeight,
    behavior: "smooth",
  });
});
