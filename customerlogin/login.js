   const loginForm = document.getElementById("loginForm");
const feedback = document.getElementById("feedback");

loginForm.addEventListener("submit", function (event) {
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value.trim();

  const validEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

  if (!validEmail || password.length < 6) {
    event.preventDefault(); // stop form
    feedback.textContent = "Enter a valid email and password (min 6 chars).";
    feedback.style.color = "#ff7b7b";
  }
  // If valid, let the form submit normally to PHP
});