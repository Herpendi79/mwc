/* scroll down js */
document.getElementById("scrollDownBtn").addEventListener("click", () => {
  window.scrollBy({
    top: window.innerHeight,
    behavior: "smooth",
  });
});

/* swiper js */
var swiper = new Swiper(".venueSwiper", {
  loop: true,
  autoplay: {
    delay: 3000, // 3 seconds
    disableOnInteraction: false,
  },
  speed: 800,
});
