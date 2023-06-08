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
        },
    },

    variants: {
        extend: {
            backgroundColor: ['dark'], // Add the 'dark' variant for background colors
        },
    },

    plugins: [forms],
};
