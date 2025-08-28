// tailwind.config.js
import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js", // Importante para o JS do seu tema
    ],

    theme: {
        extend: {
            // Adicionando as cores customizadas para o Tailwind reconhecer
            colors: {
                "primary-dark": "var(--color-primary-dark)",
                "primary-light": "var(--color-primary-light)",
                "accent-yellow": "var(--color-accent-yellow)",
            },
        },
    },

    plugins: [
        // require('@tailwindcss/forms'), // Se você precisar
    ],
};
