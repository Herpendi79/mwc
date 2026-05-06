/* scroll down js */
document.getElementById("scrollDownBtn").addEventListener("click", () => {
  window.scrollBy({
    top: window.innerHeight,
    behavior: "smooth",
  });
});

/* video modal js */
const modal = document.getElementById("videoModal");
const openBtn = document.getElementById("videoBtn");
const closeBtn = document.getElementById("closeModal");
const videoFrame = document.getElementById("videoFrame");

// Your YouTube video link
const videoURL = "https://www.youtube.com/embed/dQw4w9WgXcQ";

// Open modal
openBtn.addEventListener("click", () => {
  modal.classList.remove("hidden");
  modal.classList.add("flex"); // ensure centering
  videoFrame.src = videoURL + "?autoplay=1";
});

// Close modal
closeBtn.addEventListener("click", () => {
  modal.classList.add("hidden");
  modal.classList.remove("flex");
  videoFrame.src = "";
});

// Close modal when clicking outside video
modal.addEventListener("click", (e) => {
  if (e.target === modal) {
    modal.classList.add("hidden");
    modal.classList.remove("flex");
    videoFrame.src = "";
  }
});

/* coutdown js */
const eventDate = new Date("2026-03-15T00:00:00").getTime();

const countdown = () => {
  const now = new Date().getTime();
  const distance = eventDate - now;

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

  if (distance < 0) {
    clearInterval(timer);
    document.getElementById("days").innerText = 0;
    document.getElementById("hours").innerText = 0;
    document.getElementById("minutes").innerText = 0;
    document.getElementById("seconds").innerText = 0;
  }
};

const timer = setInterval(countdown, 1000);
countdown(); // initial call
