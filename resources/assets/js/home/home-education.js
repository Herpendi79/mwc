/* Video modal js */
const openBtn = document.getElementById("openVideoModal");
const closeBtn = document.getElementById("closeVideoModal");
const modal = document.getElementById("videoModal");
const videoFrame = document.getElementById("videoFrame");

// CHANGE YOUR VIDEO LINK HERE
const videoURL = "https://www.youtube.com/embed/dQw4w9WgXcQ";

openBtn.addEventListener("click", () => {
  modal.classList.remove("hidden");
  videoFrame.src = videoURL + "?autoplay=1";
});

closeBtn.addEventListener("click", () => {
  modal.classList.add("hidden");
  videoFrame.src = "";
});

// Close when clicking outside video box
modal.addEventListener("click", (e) => {
  if (e.target === modal) {
    modal.classList.add("hidden");
    videoFrame.src = "";
  }
});

/* countdown event js */
const eventDate = new Date("December 31, 2026 23:59:59").getTime();

const countdown = setInterval(() => {
  const now = new Date().getTime();
  const distance = eventDate - now;

  if (distance < 0) {
    clearInterval(countdown);
    document.getElementById("days").innerText = "0";
    document.getElementById("hours").innerText = "0";
    document.getElementById("minutes").innerText = "0";
    document.getElementById("seconds").innerText = "0";
    return;
  }

  const days = Math.floor(distance / (1000 * 60 * 60 * 24));
  const hours = Math.floor(
    (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
  );
  const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((distance % (1000 * 60)) / 1000);

  document.getElementById("days").innerText = days;
  document.getElementById("hours").innerText = hours;
  document.getElementById("minutes").innerText = minutes;
  document.getElementById("seconds").innerText = seconds;
}, 1000);

/* Acoordion js */
const headers = document.querySelectorAll(".accordion-header");

headers.forEach((header) => {
  header.addEventListener("click", () => {
    const content = header.nextElementSibling;
    const accordion = header.parentElement;

    // Close other accordions
    headers.forEach((h) => {
      const acc = h.parentElement;
      if (h !== header) {
        h.nextElementSibling.style.maxHeight = null;
        acc.classList.remove("rounded-[40px]");
        acc.classList.add("rounded-full");
      }
    });

    // Toggle current accordion
    if (content.style.maxHeight) {
      content.style.maxHeight = null;
      accordion.classList.remove("rounded-[40px]");
      accordion.classList.add("rounded-full");
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
      accordion.classList.remove("rounded-full");
      accordion.classList.add("rounded-[40px]");
    }
  });
});

/* swiper js */
// LEFT SIDE
var swiperLeft = new Swiper(".sponsorSwiperLeft", {
  direction: "vertical",
  loop: true,
  centeredSlides: true,
  slidesPerView: 2.8,
  spaceBetween: 30,
  speed: 900,
  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  },
});

// RIGHT SIDE
var swiperRight = new Swiper(".sponsorSwiperRight", {
  direction: "vertical",
  loop: true,
  centeredSlides: true,
  slidesPerView: 2.8,
  spaceBetween: 30,
  speed: 900,
  autoplay: {
    delay: 2500,
    reverseDirection: true,
    disableOnInteraction: false,
  },
});

/* testimonial swiper js */
function initMenuSwipers() {
  const sliders = document.querySelectorAll(".menu-swiper");
  if (!sliders.length) return;

  sliders.forEach((sliderEl) => {
    if (sliderEl.classList.contains("swiper-initialized")) return;

    const swiperInstance = new Swiper(sliderEl, {
      slidesPerView: 3,
      centeredSlides: true,
      spaceBetween: 24,
      loop: true,
      loopedSlides: 6,
      grabCursor: true,
      pagination: false,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      },
      navigation: {
        nextEl: sliderEl
          .closest("section, div")
          .querySelector(".swiper-button-next-custom"),
        prevEl: sliderEl
          .closest("section, div")
          .querySelector(".swiper-button-prev-custom"),
      },

      breakpoints: {
        0: {
          slidesPerView: 1,
          spaceBetween: 12,
          centeredSlides: false,
        },
        640: {
          slidesPerView: 1.5,
          spaceBetween: 16,
          centeredSlides: true,
        },
        768: {
          slidesPerView: 2,
          spaceBetween: 18,
          centeredSlides: true,
        },
        980: {
          slidesPerView: 3,
          spaceBetween: 20,
          centeredSlides: true,
        },
        1280: {
          slidesPerView: 3,
          spaceBetween: 24,
        },
      },
    });

    sliderEl.querySelectorAll(".swiper-slide").forEach((slide) => {
      slide.addEventListener("click", (e) => {
        const isActive = slide.classList.contains("swiper-slide-active");
        const link = slide.querySelector("a");

        if (!isActive) {
          e.preventDefault();
          swiperInstance.slideToLoop(
            slide.getAttribute("data-swiper-slide-index")
          );
        } else if (link) {
          window.location.href = link.href;
        }
      });
    });
  });
}
initMenuSwipers();
