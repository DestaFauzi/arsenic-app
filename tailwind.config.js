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
            colors: {
                'arsenic': {
                    'primary': '#05614b',    // Dark Green - Primary color
                    'dark': '#020E0E',       // Very Dark - Secondary dark
                    'accent': '#01DE82',     // Bright Green - Accent/Highlight
                    'light': '#FFFFFF',      // White - Light background
                    'primary-50': '#f0f9f6',
                    'primary-100': '#dcf2e9',
                    'primary-200': '#bce5d6',
                    'primary-300': '#8dd1ba',
                    'primary-400': '#57b599',
                    'primary-500': '#05614b',
                    'primary-600': '#044d3c',
                    'primary-700': '#033a2d',
                    'primary-800': '#022620',
                    'primary-900': '#011a16',
                    'accent-50': '#f0fdf9',
                    'accent-100': '#ccfbef',
                    'accent-200': '#99f6e0',
                    'accent-300': '#5eead4',
                    'accent-400': '#2dd4bf',
                    'accent-500': '#01DE82',
                    'accent-600': '#0d9488',
                    'accent-700': '#0f766e',
                    'accent-800': '#115e59',
                    'accent-900': '#134e4a',
                }
            }
        },
    },

    plugins: [forms],
};
