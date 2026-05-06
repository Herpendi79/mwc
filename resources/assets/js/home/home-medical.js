/* swiper js */
const sponsorSwiper = new Swiper(".sponsorSwiper", {
  loop: true,
  slidesPerView: 2,
  spaceBetween: 30,
  speed: 3000,
  freeMode: true,
  freeModeMomentum: false,
  autoplay: {
    delay: 0,
    disableOnInteraction: false,
  },
  allowTouchMove: false,
  loopedSlides: 20,
  breakpoints: {
    640: {
      slidesPerView: 3,
    },
    768: {
      slidesPerView: 3,
    },
    1024: {
      slidesPerView: 4,
    },
    1280: {
      slidesPerView: 6.5,
    },
  },
});

const speakerSwiper = new Swiper(".speakerSwiper", {
  slidesPerView: 3,
  spaceBetween: 30,
  loop: true,
  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next-custom",
    prevEl: ".swiper-button-prev-custom",
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
    640: {
      slidesPerView: 1.5,
    },
    768: {
      slidesPerView: 2,
    },
    1024: {
      slidesPerView: 2.5,
    },
    1280: {
      slidesPerView: 4,
    },
  },
});

const reviewSwiper = new Swiper(".reviewSwiper", {
  slidesPerView: 3,
  spaceBetween: 30,
  loop: true,
  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 1.5,
    },
    1024: {
      slidesPerView: 2,
    },
    1280: {
      slidesPerView: 3,
    },
  },
});

var venueSwiper = new Swiper(".venueSwiper", {
  loop: true,
  autoplay: {
    delay: 3000, // 3 seconds
    disableOnInteraction: false,
  },
  speed: 800,
});

/* faq js */
document.querySelectorAll(".accordion-header").forEach((header) => {
  header.addEventListener("click", () => {
    const body = header.nextElementSibling;
    const icon = header.querySelector("span:last-child");

    if (body.style.maxHeight) {
      body.style.maxHeight = null;
      icon.textContent = "+";
    } else {
      body.style.maxHeight = body.scrollHeight + "px";
      icon.textContent = "−";
    }
  });
});

/* Target element js */
const counter = document.getElementById("sponsorCounter");
const target = 30000; // Final number
const duration = 2000; // duration in milliseconds
let start = 0;
const increment = 100; // Increment step (adjust for smoothness)
const stepTime = Math.abs(Math.floor(duration / (target / increment)));

const counterInterval = setInterval(() => {
  start += increment;
  if (start >= target) {
    counter.innerText = `Join ${target.toLocaleString()}+`;
    clearInterval(counterInterval);
  } else {
    counter.innerText = `Join ${start.toLocaleString()}+`;
  }
}, stepTime);

/* Tab js */
const tabs = document.querySelectorAll('[role="tab"]');
const panels = document.querySelectorAll('[role="tabpanel"]');

tabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    // Reset tabs text color
    tabs.forEach((t) => {
      t.setAttribute("aria-selected", "false");
      t.classList.remove("text-[#1C2359]", "font-semibold", "dark:text-white");
      t.classList.add("text-gray-500", "font-normal", "dark:text-gray-200");
    });

    // Hide panels
    panels.forEach((panel) => panel.classList.add("hidden"));

    // Activate current tab text
    tab.setAttribute("aria-selected", "true");
    tab.classList.remove("text-gray-500", "font-normal", "dark:text-gray-200");
    tab.classList.add("text-[#1C2359]", "font-semibold", "dark:text-white");

    // Show related panel
    const panelId = tab.getAttribute("aria-controls");
    document.getElementById(panelId).classList.remove("hidden");
  });
});

/* coutdown js */
const conferenceDate = new Date("November 7, 2026 09:00:00").getTime();

function updateCountdown() {
  const now = new Date().getTime();
  const distance = conferenceDate - now;

  if (distance < 0) {
    document.getElementById("days").innerText = 0;
    document.getElementById("hours").innerText = 0;
    document.getElementById("minutes").innerText = 0;
    document.getElementById("seconds").innerText = 0;
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
}

setInterval(updateCountdown, 1000);
updateCountdown();
