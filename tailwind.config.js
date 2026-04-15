import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
    safelist: [
        'bg-green-100',
        'text-green-800',
        'border-green-300',
        'bg-red-100',
        'text-red-800',
        'border-red-300',
        'bg-yellow-100',
        'text-yellow-800',
        'border-yellow-300',
        'bg-blue-100',
        'text-blue-800',
        'border-blue-300',
    ],
};
