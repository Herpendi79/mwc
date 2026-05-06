/* scroll down js */
document.getElementById("scrollDownBtn").addEventListener("click", () => {
  window.scrollBy({
    top: window.innerHeight,
    behavior: "smooth",
  });
});

/* tab js */
const tabs = document.querySelectorAll('[role="tab"]');
const panels = document.querySelectorAll('[role="tabpanel"]');

tabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    // Reset tabs text color
    tabs.forEach((t) => {
      t.setAttribute("aria-selected", "false");
      t.classList.remove("text-black", "font-semibold", "dark:text-white");
      t.classList.add("text-gray-500", "font-normal", "dark:text-gray-400");
    });

    // Hide panels
    panels.forEach((panel) => panel.classList.add("hidden"));

    // Activate current tab text
    tab.setAttribute("aria-selected", "true");
    tab.classList.remove("text-gray-500", "font-normal", "dark:text-gray-400");
    tab.classList.add("text-black", "font-semibold", "dark:text-white");

    // Show related panel
    const panelId = tab.getAttribute("aria-controls");
    document.getElementById(panelId).classList.remove("hidden");
  });
});
