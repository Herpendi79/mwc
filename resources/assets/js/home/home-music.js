/* swiper js */
const artistSwiper = new Swiper(".artistSwiper", {
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

/* Play pause button js */
let currentAudio = null;
let currentButton = null;

document.querySelectorAll(".playPauseBtn").forEach((btn) => {
  const icon = btn.querySelector(".playPauseIcon");
  const audio = new Audio(btn.dataset.audio);

  btn.addEventListener("click", () => {
    // 👉 Same button click → Pause
    if (currentAudio === audio && !audio.paused) {
      audio.pause();
      icon.classList.remove("ri-pause-fill");
      icon.classList.add("ri-play-fill");
      currentAudio = null;
      currentButton = null;
      return;
    }

    // 👉 Another audio playing → Stop it
    if (currentAudio && currentAudio !== audio) {
      currentAudio.pause();
      currentButton
        .querySelector(".playPauseIcon")
        .classList.remove("ri-pause-fill");
      currentButton
        .querySelector(".playPauseIcon")
        .classList.add("ri-play-fill");
    }

    // 👉 Play new audio
    audio.play();
    icon.classList.remove("ri-play-fill");
    icon.classList.add("ri-pause-fill");

    currentAudio = audio;
    currentButton = btn;
  });

  // Audio finish થાય ત્યારે
  audio.addEventListener("ended", () => {
    icon.classList.remove("ri-pause-fill");
    icon.classList.add("ri-play-fill");
    currentAudio = null;
    currentButton = null;
  });
});

/* countdown js */
const eventDate = new Date("2026-10-31T18:00:00").getTime();

const countdown = setInterval(() => {
  const now = new Date().getTime();
  const distance = eventDate - now;

  if (distance < 0) {
    clearInterval(countdown);
    document.getElementById("days").innerHTML = "00";
    document.getElementById("hours").innerHTML = "00";
    document.getElementById("minutes").innerHTML = "00";
    document.getElementById("seconds").innerHTML = "00";
    return;
  }

  document.getElementById("days").innerHTML = Math.floor(
    distance / (1000 * 60 * 60 * 24)
  );

  document.getElementById("hours").innerHTML = Math.floor(
    (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
  );

  document.getElementById("minutes").innerHTML = Math.floor(
    (distance % (1000 * 60 * 60)) / (1000 * 60)
  );

  document.getElementById("seconds").innerHTML = Math.floor(
    (distance % (1000 * 60)) / 1000
  );
}, 1000);

/* tab js */
const tabs = document.querySelectorAll('[role="tab"]');
const panels = document.querySelectorAll('[role="tabpanel"]');

tabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    tabs.forEach((t) => t.setAttribute("aria-selected", "false"));
    panels.forEach((p) => p.classList.add("hidden"));

    tab.setAttribute("aria-selected", "true");
    document
      .getElementById(tab.getAttribute("aria-controls"))
      .classList.remove("hidden");
  });
});

/* audio js */
document.querySelectorAll(".music-card").forEach((card) => {
  const audio = card.querySelector(".audio");
  const playBtn = card.querySelector(".playBtn");
  const playIcon = card.querySelector(".playIcon");
  const progress = card.querySelector(".progress");
  const currentTimeEl = card.querySelector(".currentTime");
  const durationEl = card.querySelector(".duration");
  const volume = card.querySelector(".volume");

  playBtn.addEventListener("click", () => {
    document.querySelectorAll(".audio").forEach((a) => {
      if (a !== audio) {
        a.pause();
        const icon = a.closest(".music-card").querySelector(".playIcon");
        if (icon) icon.className = "playIcon ri-play-large-fill";
      }
    });

    if (audio.paused) {
      audio.play();
      playIcon.className = "playIcon ri-pause-fill";
    } else {
      audio.pause();
      playIcon.className = "playIcon ri-play-large-fill";
    }
  });

  audio.addEventListener("timeupdate", () => {
    const percent = (audio.currentTime / audio.duration) * 100 || 0;
    progress.value = percent;
    currentTimeEl.textContent = formatTime(audio.currentTime);
    durationEl.textContent = formatTime(audio.duration || 0);
  });

  progress.addEventListener("input", () => {
    audio.currentTime = (progress.value / 100) * audio.duration;
  });

  volume.addEventListener("input", () => {
    audio.volume = volume.value;
  });
});
function formatTime(time) {
  const m = Math.floor(time / 60);
  const s = Math.floor(time % 60);
  return `${String(m).padStart(2, "0")}:${String(s).padStart(2, "0")}`;
}

/* Rtl mode js */
const root = document.documentElement;
const directionToggle = document.getElementById("directionToggle");
const ltrText = directionToggle.querySelector(".ltrText");
const rtlText = directionToggle.querySelector(".rtlText");

(function () {
  const savedDir = localStorage.getItem("direction");
  if (savedDir) {
    root.setAttribute("dir", savedDir);

    if (savedDir === "rtl") {
      ltrText.classList.add("hidden");
      rtlText.classList.remove("hidden");
    }
  }
})();

directionToggle.addEventListener("click", () => {
  const current = root.getAttribute("dir") === "rtl" ? "ltr" : "rtl";
  root.setAttribute("dir", current);
  localStorage.setItem("direction", current);

  ltrText.classList.toggle("hidden");
  rtlText.classList.toggle("hidden");
});