console.log("DEBUG: File app.js dimuat sepenuhnya! ✅");
// ================= IMPORT CSS =================
// Naik ke resources, lalu masuk ke assets/css
import "../assets/css/icons.css";
import "../assets/css/plugins.css";
import "../assets/css/tailwind.css";

// ================= IMPORT JS MODULES =================
// Kita naik satu tingkat ke folder 'resources', lalu masuk ke 'assets/js/'
import "../assets/js/header";
import "../assets/js/sal.init";
import "../assets/js/dark-mode";
console.log("APP RUNNING 🚀");

// ================= INITIALIZER =================
document.addEventListener("DOMContentLoaded", () => {
    // Paksa kembali ke LTR jika tidak ingin menu terbalik
    document.documentElement.setAttribute("dir", "ltr");
    
    displayCurrentYear();
    initCountdown();
    initScrollTop();
    // Inisialisasi Swiper Sponsor
    initSponsorSwiper();
    initTabs();
    initGallerySwiper();
    initReviewSwiper();
});

// ================= REVIEW / TESTIMONI SWIPER =================
function initReviewSwiper() {
    // Gunakan '.reviwe-swiper' sesuai typo di HTML Anda agar terbaca
    const sliderEl = document.querySelector('.reviwe-swiper');
    
    if (typeof Swiper !== 'undefined' && sliderEl) {
        new Swiper(".reviwe-swiper", {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 30,
            // Pastikan selector navigation SAMA PERSIS dengan class di HTML
            navigation: {
                nextEl: ".swiper-button-next-custom",
                prevEl: ".swiper-button-prev-custom",
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
        });
        console.log("Review Swiper Ready! ⭐");
    } else {
        // Coba lagi jika library belum siap
        setTimeout(initReviewSwiper, 500);
    }
}

// ================= GALLERY SWIPER =================
function initGallerySwiper() {
    if (typeof Swiper !== 'undefined' && document.querySelector('.galleryswiper')) {
        new Swiper(".galleryswiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            breakpoints: {
                640: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 3, spaceBetween: 30 },
                1280: { slidesPerView: 4, spaceBetween: 30 },
            },
        });
        console.log("Gallery Swiper Ready! 📸");
    } else {
        setTimeout(initGallerySwiper, 500);
    }
}

// ================= TABS LOGIC =================
function initTabs() {
    const tabs = document.querySelectorAll(".tab-btn");
    const panels = document.querySelectorAll("[role='tabpanel']");

    if (tabs.length === 0 || panels.length === 0) return;

    console.log("Tabs Initialized 📑");

    tabs.forEach((tab, index) => {
        tab.addEventListener("click", () => {
            // 1. Reset semua tab (Kembalikan ke warna gelap)
            tabs.forEach((t) => {
                t.classList.remove("bg-[#c0f037]");
                t.classList.add("bg-white/10");
                t.setAttribute("aria-selected", "false");
                // Cari p, h2, h3, h4 dan hapus warna hitam
                t.querySelectorAll("p, h2, h3, h4").forEach((el) => el.classList.remove("text-black"));
            });

            // 2. Sembunyikan semua panel
            panels.forEach((panel) => {
                panel.classList.add("opacity-0", "translate-y-4", "hidden");
                panel.classList.remove("opacity-100", "translate-y-0");
            });

            // 3. Aktifkan tab yang diklik (Ubah jadi hijau)
            tab.classList.add("bg-[#c0f037]");
            tab.classList.remove("bg-white/10");
            tab.setAttribute("aria-selected", "true");
            tab.querySelectorAll("p, h2, h3, h4").forEach((el) => el.classList.add("text-black"));

            // 4. Tampilkan panel yang sesuai
            const targetPanel = panels[index];
            if (targetPanel) {
                targetPanel.classList.remove("hidden");
                setTimeout(() => {
                    targetPanel.classList.remove("opacity-0", "translate-y-4");
                    targetPanel.classList.add("opacity-100", "translate-y-0");
                }, 50);
            }
        });
    });

    // Jalankan klik simulasi pada tab pertama agar aktif saat pertama load
    const activeTab = document.querySelector('.tab-btn[aria-selected="true"]');
    if (activeTab) {
        activeTab.click();
    } else {
        tabs[0].click();
    }
}

// ================= SPONSOR SWIPER (Marquee Style) =================
function initSponsorSwiper() {
    // Pastikan library Swiper sudah ada (dari CDN)
    if (typeof Swiper !== 'undefined' && document.querySelector('.sponsorSwiper')) {
        new Swiper(".sponsorSwiper", {
            loop: true,
            slidesPerView: 2,
            spaceBetween: 30,
            speed: 5000, // Kecepatan gerak (ms)
            allowTouchMove: false, // Biar lancar seperti marquee
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
            },
            breakpoints: {
                640: { slidesPerView: 3 },
                768: { slidesPerView: 4 },
                1024: { slidesPerView: 5 },
                1280: { slidesPerView: 6 },
            },
        });
        console.log("Sponsor Swiper Ready! 🎡");
    } else {
        // Jika Swiper belum siap, coba lagi dalam 500ms
        setTimeout(initSponsorSwiper, 500);
    }
}

// ================= SCROLL TO TOP =================
function initScrollTop() {
    const scrollBtn = document.getElementById("scrollTopBtn");
    if (!scrollBtn) return;

    window.addEventListener("scroll", () => {
        // Gunakan window.pageYOffset untuk kompatibilitas lebih luas
        const scrollPos = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollPos > 300) {
            scrollBtn.style.display = "block"; // Pastikan muncul dulu
            setTimeout(() => {
                scrollBtn.classList.remove("opacity-0", "invisible", "scale-75");
                scrollBtn.classList.add("opacity-100", "visible", "scale-100");
            }, 10);
        } else {
            scrollBtn.classList.add("opacity-0", "invisible", "scale-75");
            scrollBtn.classList.remove("opacity-100", "visible", "scale-100");
        }
    });

    scrollBtn.addEventListener("click", () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
}
// ================= CURRENT YEAR =================
function displayCurrentYear() {
    const el = document.getElementById("currentYearFooter");
    if (el) el.textContent = new Date().getFullYear();
}

// ================= COUNTDOWN (26 JUNI 2026) =================
function initCountdown() {
    const targetDate = new Date("2026-06-26T00:00:00").getTime();
    const el = {
        d: document.getElementById("cd-days"),
        h: document.getElementById("cd-hours"),
        m: document.getElementById("cd-minutes"),
        s: document.getElementById("cd-seconds"),
    };

    if (!el.d) return;

    const format = (n) => String(n).padStart(2, "0");

    const update = () => {
        const now = new Date().getTime();
        const diff = targetDate - now;

        if (diff <= 0) {
            Object.values(el).forEach((e) => {
                if (e) e.innerText = "00";
            });
            return;
        }

        el.d.innerText = format(Math.floor(diff / (1000 * 60 * 60 * 24)));
        el.h.innerText = format(Math.floor((diff / (1000 * 60 * 60)) % 24));
        el.m.innerText = format(Math.floor((diff / (1000 * 60)) % 60));
        el.s.innerText = format(Math.floor((diff / 1000) % 60));
    };

    setInterval(update, 1000);
    update();
}

