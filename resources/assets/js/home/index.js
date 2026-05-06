/* Swiper js */
var swiper1 = new Swiper(".heroswiper", {
  effect: "fade",
  fadeEffect: {
    crossFade: true,
  },
  speed: 800,
  loop: true,
  autoplay: {
    delay: 3500,
    disableOnInteraction: false,
  },
});

var swiper2 = new Swiper(".reviwe-swiper", {
  loop: true,
  slidesPerView: 1,
  spaceBetween: 30,
  navigation: {
    nextEl: ".swiper-button-next-custom",
    prevEl: ".swiper-button-prev-custom",
  },
});

var swiper3 = new Swiper(".galleryswiper", {
  breakpoints: {
    320: {
      slidesPerView: 1,
      spaceBetween: 15,
    },
    480: {
      slidesPerView: 2,
      spaceBetween: 20,
    },
    768: {
      slidesPerView: 2,
      spaceBetween: 25,
    },
    1024: {
      slidesPerView: 3,
      spaceBetween: 30,
    },
    1280: {
      slidesPerView: 4,
      spaceBetween: 30,
    },
  },
});

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

/* tab js */
const tabs = document.querySelectorAll(".tab-btn");
const panels = document.querySelectorAll("[role='tabpanel']");

if (tabs.length > 0) {
  tabs.forEach((tab, index) => {
    tab.addEventListener("click", () => {
      tabs.forEach((t) => {
        t.classList.remove("bg-[#c0f037]");
        t.classList.add("bg-white/10");
        t.setAttribute("aria-selected", "false");
        t.querySelectorAll("p, h2").forEach((el) =>
          el.classList.remove("text-black")
        );
      });

      panels.forEach((panel) => {
        panel.classList.add("opacity-0", "translate-y-4");
        panel.classList.remove("opacity-100", "translate-y-0");
        panel.setAttribute("hidden", true);
      });

      tab.classList.add("bg-[#c0f037]");
      tab.classList.remove("bg-white/10");
      tab.setAttribute("aria-selected", "true");
      tab
        .querySelectorAll("p, h2")
        .forEach((el) => el.classList.add("text-black"));

      const panel = panels[index];
      if (panel) {
        panel.removeAttribute("hidden");
        setTimeout(() => {
          panel.classList.remove("opacity-0", "translate-y-4");
          panel.classList.add("opacity-100", "translate-y-0");
        }, 50);
      }
    });
  });

  const firstTab = tabs[0];
  if (firstTab) {
    firstTab.classList.add("bg-[#c0f037]");
    firstTab.classList.remove("bg-white/10");
    firstTab
      .querySelectorAll("p, h2")
      .forEach((el) => el.classList.add("text-black"));
  }

  const firstPanel = panels[0];
  if (firstPanel) {
    firstPanel.removeAttribute("hidden");
    firstPanel.classList.add("opacity-100", "translate-y-0");
  }
}

/* Rtl mode js */
const root = document.documentElement;
if (directionToggle) {
  (function () {
    const savedDir = localStorage.getItem("direction");
    if (savedDir) {
      root.setAttribute("dir", savedDir);

      if (savedDir === "rtl") {
        const ltrText = directionToggle.querySelector(".ltrText");
        const rtlText = directionToggle.querySelector(".rtlText");
        if (ltrText) ltrText.classList.add("hidden");
        if (rtlText) rtlText.classList.remove("hidden");
      }
    }
  })();

  directionToggle.addEventListener("click", () => {
    const current = root.getAttribute("dir") === "rtl" ? "ltr" : "rtl";
    root.setAttribute("dir", current);
    localStorage.setItem("direction", current);

    const ltrText = directionToggle.querySelector(".ltrText");
    const rtlText = directionToggle.querySelector(".rtlText");
    if (ltrText) ltrText.classList.toggle("hidden");
    if (rtlText) rtlText.classList.toggle("hidden");
  });
}


