const registerForm = document.getElementById("registerForm");
const feedback = document.getElementById("feedback");

registerForm.addEventListener("submit", function (event) {
  const name = document.getElementById("name").value.trim();
  const email = document.getElementById("email").value.trim();
  let password = document.getElementById("password").value;
  const confirmPassword = document.getElementById("confirmPassword").value;

  const validEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  
  if (name.length < 2 || !validEmail || password.length < 6) {
    event.preventDefault(); // stop form
    feedback.textContent = "Fill all fields correctly. Password must be at least 6 characters.";
    feedback.style.color = "#ff7b7b";
    return;
  }

  if (password !== confirmPassword) {
    event.preventDefault(); // stop form
    feedback.textContent = "Passwords do not match.";
    feedback.style.color = "#ff7b7b";
    return;
  }
  // If everything is valid, let the form submit to PHP normally
});