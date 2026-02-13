
document.getElementById("feedbackForm").addEventListener("submit", function (e) {
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const message = document.getElementById("message").value.trim();

    if (name === "" || email === "" || message === "") {
        e.preventDefault();
        alert("⚠️ Please fill in all fields before submitting.");
        return;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        e.preventDefault();
        alert("Please enter a valid email address.");
        return;
    }

    if (message.length < 10) {
        e.preventDefault();
        alert("Please enter at least 10 characters in your feedback message.");
        return;
    }
});
