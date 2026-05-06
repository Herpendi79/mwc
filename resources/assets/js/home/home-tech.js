/* Swiper js */
var featureswiper = new Swiper(".featureswiper", {
  loop: true,
  navigation: {
    nextEl: ".swiper-button-next-features",
    prevEl: ".swiper-button-prev-features",
  },
  breakpoints: {
    320: {
      slidesPerView: 1,
      spaceBetween: 10,
    },
    640: {
      slidesPerView: 2,
      spaceBetween: 20,
    },
    1024: {
      slidesPerView: 3,
      spaceBetween: 30,
    },
    1440: {
      slidesPerView: 4,
      spaceBetween: 30,
    },
  },
});

var reviewswiper = new Swiper(".reviewswiper", {
  slidesPerView: 1,
  spaceBetween: 30,
  loop: true,
  navigation: {
    nextEl: ".swiper-button-next-custom",
    prevEl: ".swiper-button-prev-custom",
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
  },
});

/* countdown  timer js */
const targetDate = new Date("Dec 1, 2026 00:00:00").getTime();
const daysEl = document.getElementById("days");
const hoursEl = document.getElementById("hours");
const minutesEl = document.getElementById("minutes");
const secondsEl = document.getElementById("seconds");
const countdown = setInterval(() => {
  const now = new Date().getTime();
  const distance = targetDate - now;

  if (distance < 0) {
    clearInterval(countdown);
    daysEl.textContent = "00";
    hoursEl.textContent = "00";
    minutesEl.textContent = "00";
    secondsEl.textContent = "00";
    return;
  }

  const days = Math.floor(distance / (1000 * 60 * 60 * 24));
  const hours = Math.floor(
    (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
  );
  const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((distance % (1000 * 60)) / 1000);

  daysEl.textContent = days < 10 ? "0" + days : days;
  hoursEl.textContent = hours < 10 ? "0" + hours : hours;
  minutesEl.textContent = minutes < 10 ? "0" + minutes : minutes;
  secondsEl.textContent = seconds < 10 ? "0" + seconds : seconds;
}, 1000);

/* Video modal js */
const modal = document.getElementById("videoModal");
const openBtn = document.getElementById("openVideo");
const closeBtn = document.getElementById("closeVideo");
const videoFrame = document.getElementById("videoFrame");

const videoURL = "https://www.youtube.com/embed/dQw4w9WgXcQ";

openBtn.addEventListener("click", () => {
  modal.classList.remove("hidden");
  videoFrame.src = videoURL + "?autoplay=1";
});

closeBtn.addEventListener("click", () => {
  modal.classList.add("hidden");
  videoFrame.src = "";
});

modal.addEventListener("click", (e) => {
  if (e.target === modal) {
    modal.classList.add("hidden");
    videoFrame.src = "";
  }
});

/* tab js */
const tabs = document.querySelectorAll("[role='tab']");
const panels = document.querySelectorAll("[role='tabpanel']");

function activateTab(tab) {
  tabs.forEach((t) => {
    t.setAttribute("aria-selected", "false");
    t.classList.remove("bg-white/30");
  });

  panels.forEach((panel) => {
    panel.hidden = true;
    panel.classList.remove("animate-fadeIn");
  });

  tab.setAttribute("aria-selected", "true");
  tab.classList.add("bg-white/30");

  const panelId = tab.id.replace("tab", "panel");
  const panel = document.getElementById(panelId);
  panel.hidden = false;
  panel.classList.add("animate-fadeIn");
}

activateTab(tabs[0]);

tabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    activateTab(tab);
  });
});
