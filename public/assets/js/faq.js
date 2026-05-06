/* scroll down js */
document.getElementById("scrollDownBtn").addEventListener("click", () => {
  window.scrollBy({
    top: window.innerHeight,
    behavior: "smooth",
  });
});

/* accordion js */
document.querySelectorAll(".accordion-header").forEach((header) => {
  header.addEventListener("click", () => {
    const item = header.parentElement; // current accordion item
    const body = item.querySelector(".accordion-body");
    const icon = header.querySelector(".icon");
    const text = header.querySelector("span"); // header text

    // Close all other accordions
    document.querySelectorAll(".accordion-item").forEach((other) => {
      if (other !== item) {
        const otherBody = other.querySelector(".accordion-body");
        const otherIcon = other.querySelector(".icon");
        const otherText = other.querySelector("span");

        // Close body
        otherBody.style.maxHeight = null;

        // Reset background & border
        other.classList.remove("bg-[#f2c944]", "border-transparent");
        other.classList.add("border", "border-black/10");

        // Reset icon
        otherIcon.textContent = "+";
        otherIcon.classList.remove("rotate-180", "text-black");
        otherIcon.classList.add("text-gray-800", "dark:text-gray-200");

        // Reset text
        otherText.classList.remove("text-black");
        otherText.classList.add("text-gray-800", "dark:text-gray-200");
      }
    });

    // Toggle current accordion
    if (body.style.maxHeight) {
      // CLOSE
      body.style.maxHeight = null;
      icon.textContent = "+";
      icon.classList.remove("rotate-180", "text-black");
      icon.classList.add("text-gray-800", "dark:text-gray-200");

      item.classList.remove("bg-[#f2c944]", "border-transparent");
      item.classList.add("border", "border-black/10");

      text.classList.remove("text-black");
      text.classList.add("text-gray-800", "dark:text-gray-200");
    } else {
      // OPEN
      body.style.maxHeight = body.scrollHeight + "px";
      icon.textContent = "−";
      icon.classList.add("rotate-180", "text-black");
      icon.classList.remove("text-gray-800", "dark:text-gray-200");

      item.classList.add("bg-[#f2c944]", "border-transparent");
      item.classList.remove("border", "border-black/10");

      text.classList.add("text-black");
      text.classList.remove("text-gray-800", "dark:text-gray-200");
    }
  });
});

