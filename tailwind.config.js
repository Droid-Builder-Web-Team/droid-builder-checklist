import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // Enable dark mode variants

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                'roboto': ['Roboto', 'sans-serif'],
            },
            boxShadow: {
                'light-shadow': '8px 8px 10px -3px rgb(50,61,74)',
                'lighter-shadow': '8px 8px 10px -3px rgb(60,71,78)',
            }
        },
    },

    variants: {
        extend: {
            backgroundColor: ['dark'], // Add the 'dark' variant for background colors
        },
    },

    plugins: [forms],
};
