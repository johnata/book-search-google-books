document.addEventListener("DOMContentLoaded", function () {
    const togglePassword = document.getElementById("togglePassword");
    const password = document.getElementById("password");
    const eyeOpen = document.getElementById("eye-open");
    const eyeClosed = document.getElementById("eye-closed");

    if (togglePassword) {
        togglePassword.addEventListener("click", function () {
            const type =
                password.getAttribute("type") === "password"
                    ? "text"
                    : "password";
            password.setAttribute("type", type);
            eyeOpen.classList.toggle("hidden");
            eyeClosed.classList.toggle("hidden");
        });
    }

    const togglePasswordConfirm = document.getElementById(
        "togglePasswordConfirm"
    );
    const passwordConfirm = document.getElementById("password_confirmation");
    const eyeOpenConfirm = document.getElementById("eye-open-confirm");
    const eyeClosedConfirm = document.getElementById("eye-closed-confirm");

    if (togglePasswordConfirm) {
        togglePasswordConfirm.addEventListener("click", function () {
            const type =
                passwordConfirm.getAttribute("type") === "password"
                    ? "text"
                    : "password";
            passwordConfirm.setAttribute("type", type);
            eyeOpenConfirm.classList.toggle("hidden");
            eyeClosedConfirm.classList.toggle("hidden");
        });
    }
});
