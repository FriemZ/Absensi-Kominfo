window.addEventListener("load", () => {
    const splash = document.getElementById("splash-screen");
    const logo = document.getElementById("splash-logo");
    const main = document.getElementById("main-login");

    // Jalankan animasi perpindahan logo
    setTimeout(() => {
        logo.classList.add("move-logo");
    }, 1200);

    // Sembunyikan splash screen dan munculkan login
    setTimeout(() => {
        splash.style.opacity = "0";
        splash.style.pointerEvents = "none";
        main.classList.add("show");
        document.body.style.overflow = "auto";
    }, 2200);
});

document.addEventListener("DOMContentLoaded", () => {
    const inputs = document.querySelectorAll(".otp-input");
    const hiddenPassword = document.getElementById("password");

    inputs.forEach((input, index) => {
        input.addEventListener("input", () => {
            // Hanya angka, pindah otomatis
            if (input.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
            updatePassword();
        });

        input.addEventListener("keydown", (e) => {
            if (e.key === "Backspace" && input.value === "" && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });

    function updatePassword() {
        const password = Array.from(inputs)
            .map((i) => i.value)
            .join("");
        hiddenPassword.value = password;
    }
});
