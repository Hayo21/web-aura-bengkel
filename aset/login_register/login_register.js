document.addEventListener("DOMContentLoaded", function () {
  const formContainers = document.querySelectorAll(".form-container");
  const toggleButtons = document.querySelectorAll(".btn-toggle");

  toggleButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const targetId = this.getAttribute("data-target");
      formContainers.forEach((container) => {
        if (container.id === targetId) {
          container.classList.add("active-form");
        } else {
          container.classList.remove("active-form");
        }
      });
    });
  });

  const togglePassword = document.getElementById("togglePassword");
  const passwordInput = document.getElementById("exampleInputPassword1");

  togglePassword.addEventListener("click", function () {
    const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
    passwordInput.setAttribute("type", type);
    togglePassword.querySelector("i").classList.toggle("bi-eye");
    togglePassword.querySelector("i").classList.toggle("bi-eye-slash");
  });
});
