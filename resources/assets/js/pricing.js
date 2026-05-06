/* scroll down js */
document.getElementById("scrollDownBtn").addEventListener("click", () => {
  window.scrollBy({
    top: window.innerHeight,
    behavior: "smooth",
  });
});

/* toggle button js */
const billingSwitch = document.getElementById("billingSwitch");
const toggleMonthly = document.getElementById("toggleMonthly");
const toggleYearly = document.getElementById("toggleYearly");

const prices = {
  standard: { monthly: 99, yearly: 456 },
  premium: { monthly: 149, yearly: 827 },
  vip: { monthly: 199, yearly: 953 },
};

function updatePrices() {
  const isYearly = billingSwitch.checked;
  document.getElementById("standardPrice").textContent = `$${
    isYearly ? prices.standard.yearly : prices.standard.monthly
  }`;
  document.getElementById("premiumPrice").textContent = `$${
    isYearly ? prices.premium.yearly : prices.premium.monthly
  }`;
  document.getElementById("vipPrice").textContent = `$${
    isYearly ? prices.vip.yearly : prices.vip.monthly
  }`;

  // Update labels
  if (isYearly) {
    toggleMonthly.classList.remove("text-black", "font-semibold", "dark:text-white");
    toggleMonthly.classList.add("text-gray-600", "dark:text-gray-400");
    toggleYearly.classList.remove("text-gray-600", "dark:text-gray-400");
    toggleYearly.classList.add("text-black", "font-semibold", "dark:text-white");
  } else {
    toggleMonthly.classList.add("text-black", "font-semibold", "dark:text-white");
    toggleMonthly.classList.remove("text-gray-600", "dark:text-gray-400");
    toggleYearly.classList.add("text-gray-600", "dark:text-gray-400");
    toggleYearly.classList.remove("text-black", "font-semibold", "dark:text-white");
  }
}

// Switch toggle
billingSwitch.addEventListener("change", updatePrices);

// Click on links
toggleMonthly.addEventListener("click", (e) => {
  e.preventDefault();
  billingSwitch.checked = false;
  updatePrices();
});
toggleYearly.addEventListener("click", (e) => {
  e.preventDefault();
  billingSwitch.checked = true;
  updatePrices();
});

// Initialize
updatePrices();
