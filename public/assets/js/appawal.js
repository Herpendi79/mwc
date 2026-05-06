// ================= IMPORT =================
import "./bootstrap";
import "../css/app.css";

// ================= CURRENT YEAR =================
function displayCurrentYear() {
    try {
        const currentYear = new Date().getFullYear();
        const footerElement = document.getElementById("currentYearFooter");

        if (footerElement) {
            footerElement.textContent = currentYear;
        }
    } catch (error) {
        console.error("Error in displayCurrentYear:", error);
    }
}

document.addEventListener("DOMContentLoaded", displayCurrentYear);
