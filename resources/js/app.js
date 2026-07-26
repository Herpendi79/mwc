// ================= IMPORT CSS =================
import "../assets/css/icons.css";
import "../assets/css/plugins.css";
import "../assets/css/tailwind.css";

// ================= IMPORT JS =================
import "../assets/js/sal.init";
import "../assets/js/dark-mode";
import "../assets/js/bootstrap";

// ================= ALPINE =================
import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";
import persist from "@alpinejs/persist";

window.Alpine = Alpine;

Alpine.plugin(collapse);
Alpine.plugin(persist);

Alpine.start();

console.log("APP RUNNING 🚀");

// ================= INITIALIZER =================
document.addEventListener("DOMContentLoaded", () => {
    // Paksa LTR
    document.documentElement.setAttribute("dir", "ltr");

    displayCurrentYear();
    initCountdown();
    initScrollTop();
    initSponsorSwiper();
    initTabs();
    initGallerySwiper();
    initReviewSwiper();
    initSidebar();
});

// ================= SIDEBAR =================
function initSidebar() {
    const sidebar = document.getElementById("main-sidebar");
    const overlay = document.getElementById("sidebar-overlay");

    const openBtn = document.getElementById("mobile-menu-btn");
    const closeBtn = document.getElementById("sidebar-close");

    if (!sidebar) return;

    function openSidebar() {
        sidebar.classList.remove("-translate-x-full");
        sidebar.classList.add("translate-x-0");

        if (overlay) {
            overlay.classList.remove("hidden");

            requestAnimationFrame(() => {
                overlay.classList.add("opacity-100");
            });

            document.body.classList.add("overflow-hidden");
        }
    }

    function closeSidebar() {
        sidebar.classList.remove("translate-x-0");
        sidebar.classList.add("-translate-x-full");

        if (overlay) {
            overlay.classList.remove("opacity-100");

            setTimeout(() => {
                overlay.classList.add("hidden");
            }, 300);

            document.body.classList.remove("overflow-hidden");
        }
    }

    openBtn?.addEventListener("click", openSidebar);

    closeBtn?.addEventListener("click", closeSidebar);

    overlay?.addEventListener("click", closeSidebar);

    window.addEventListener("resize", () => {
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove("-translate-x-full");
            sidebar.classList.add("translate-x-0");

            overlay?.classList.add("hidden");
            overlay?.classList.remove("opacity-100");

            document.body.classList.remove("overflow-hidden");
        } else {
            sidebar.classList.add("-translate-x-full");
            sidebar.classList.remove("translate-x-0");
        }
    });
}
// ================= REVIEW / TESTIMONI SWIPER =================
function initReviewSwiper() {

    const slider = document.querySelector(".reviwe-swiper");

    if (!slider || typeof Swiper === "undefined") {
        setTimeout(initReviewSwiper, 500);
        return;
    }

    new Swiper(".reviwe-swiper", {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 30,

        navigation: {
            nextEl: ".swiper-button-next-custom",
            prevEl: ".swiper-button-prev-custom",
        },

        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
    });

    console.log("⭐ Review Swiper Ready");

}

// ================= GALLERY SWIPER =================
function initGallerySwiper() {

    const gallery = document.querySelector(".galleryswiper");

    if (!gallery || typeof Swiper === "undefined") {
        setTimeout(initGallerySwiper, 500);
        return;
    }

    new Swiper(".galleryswiper", {

        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,

        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },

        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 20,
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

    console.log("📸 Gallery Swiper Ready");

}

// ================= TABS =================
function initTabs() {

    const tabs = document.querySelectorAll(".tab-btn");
    const panels = document.querySelectorAll("[role='tabpanel']");

    if (!tabs.length || !panels.length) return;

    tabs.forEach((tab, index) => {

        tab.addEventListener("click", () => {

            tabs.forEach((btn) => {

                btn.classList.remove("bg-[#c0f037]");
                btn.classList.add("bg-white/10");

                btn.setAttribute("aria-selected", "false");

                btn.querySelectorAll("p,h2,h3,h4").forEach((el) => {
                    el.classList.remove("text-black");
                });

            });

            panels.forEach((panel) => {

                panel.classList.add(
                    "hidden",
                    "opacity-0",
                    "translate-y-4"
                );

                panel.classList.remove(
                    "opacity-100",
                    "translate-y-0"
                );

            });

            tab.classList.remove("bg-white/10");
            tab.classList.add("bg-[#c0f037]");
            tab.setAttribute("aria-selected", "true");

            tab.querySelectorAll("p,h2,h3,h4").forEach((el) => {
                el.classList.add("text-black");
            });

            const target = panels[index];

            if (target) {

                target.classList.remove("hidden");

                setTimeout(() => {

                    target.classList.remove(
                        "opacity-0",
                        "translate-y-4"
                    );

                    target.classList.add(
                        "opacity-100",
                        "translate-y-0"
                    );

                }, 30);

            }

        });

    });

    const activeTab = document.querySelector(
        '.tab-btn[aria-selected="true"]'
    );

    if (activeTab) {
        activeTab.click();
    } else {
        tabs[0]?.click();
    }

}
