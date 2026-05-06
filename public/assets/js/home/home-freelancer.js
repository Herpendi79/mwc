/* tab js */
const tabs = document.querySelectorAll("[role='tab']");
const panels = document.querySelectorAll("[role='tabpanel']");

function activateTab(tab) {
  tabs.forEach((t) => {
    t.setAttribute("aria-selected", "false");
    t.classList.remove("bg-[#a0ffc2]", "border-black/30", "dark:text-black");
    t.classList.add("border", "border-black/10");

    // 🔹 inactive tab p reset
    const p = t.querySelector("p");
    if (p) {
      p.classList.remove("dark:text-gray-600");
    }
  });

  panels.forEach((panel) => {
    panel.hidden = true;
    panel.classList.remove("animate-fadeIn");
  });

  tab.setAttribute("aria-selected", "true");
  tab.classList.remove("border", "border-black/10");
  tab.classList.add("bg-[#a0ffc2]", "border-black/30", "dark:text-black");

  const activeP = tab.querySelector("p");
  if (activeP) {
    activeP.classList.add("dark:text-gray-600");
  }

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

/* countdown  timer js */
const targetDate = new Date("Dec 31, 2026 23:59:59").getTime();
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

/* swiper js */
var reviewswiper = new Swiper(".reviewswiper", {
  loop: true,
  slidesPerView: 1,
  spaceBetween: 30,
  navigation: {
    nextEl: ".swiper-button-next-custom",
    prevEl: ".swiper-button-prev-custom",
  },
});

/* glightbox js */
const lightbox = GLightbox({
  selector: ".glightbox",
  touchNavigation: true,
  loop: true,
  zoomable: true,
});

/* Video modal js */
const modal = document.getElementById("videoModal");
const openBtn = document.getElementById("openVideo");
const closeBtn = document.getElementById("closeVideo");
const videoFrame = document.getElementById("videoFrame");

// Your video link
const videoURL = "https://www.youtube.com/embed/dQw4w9WgXcQ";

openBtn.addEventListener("click", () => {
  modal.classList.remove("hidden");
  videoFrame.src = videoURL + "?autoplay=1";
});

closeBtn.addEventListener("click", () => {
  modal.classList.add("hidden");
  videoFrame.src = "";
});

// close modal when clicking outside
modal.addEventListener("click", (e) => {
  if (e.target === modal) {
    modal.classList.add("hidden");
    videoFrame.src = "";
  }
});

