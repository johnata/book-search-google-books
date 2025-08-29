import "./bootstrap";
import "@tailwindplus/elements";

document.addEventListener("DOMContentLoaded", () => {
    const themeToggleBtn = document.getElementById("theme-toggle");
    const html = document.documentElement;

    // Função para aplicar o tema
    function applyTheme(theme) {
        if (theme === "dark") {
            html.classList.add("dark");
        } else {
            html.classList.remove("dark");
        }
    }

    // Lógica para carregar o tema na inicialização
    const userTheme = localStorage.getItem("theme");
    const systemThemeIsDark = window.matchMedia(
        "(prefers-color-scheme: dark)"
    ).matches;

    // Prioriza o tema salvo no localStorage
    if (userTheme) {
        applyTheme(userTheme);
    }
    // Se não há tema salvo, usa a preferência do sistema
    else if (systemThemeIsDark) {
        applyTheme("dark");
    }
    // Se não há preferência, usa o modo claro como padrão
    else {
        applyTheme("light");
    }

    // Lógica para alternar o tema com o botão
    if (themeToggleBtn) {
        themeToggleBtn.addEventListener("click", () => {
            const currentTheme = html.classList.contains("dark")
                ? "dark"
                : "light";
            const newTheme = currentTheme === "dark" ? "light" : "dark";

            // Alterna o tema
            applyTheme(newTheme);

            // Salva a nova preferência no localStorage
            localStorage.setItem("theme", newTheme);
        });
    }

    addRequiredAsterisks();
});

// Função para adicionar o asterisco a campos obrigatórios
function addRequiredAsterisks() {
    const requiredInputs = document.querySelectorAll("input[required]");
    requiredInputs.forEach((input) => {
        const label = document.querySelector(`label[for="${input.id}"]`);
        if (label) {
            // Verifica se o asterisco já foi adicionado
            if (!label.querySelector(".required-asterisk")) {
                const asterisk = document.createElement("span");
                asterisk.textContent = " *";
                asterisk.classList.add("required-asterisk", "text-red-500");
                label.appendChild(asterisk);
            }
        }
    });
}
