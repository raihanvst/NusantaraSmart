import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                midnight: {
                    50:  '#f0f3ff',
                    100: '#e0e7ff',
                    500: '#1e3a8a',
                    600: '#1a3480',
                    700: '#152966',
                    800: '#0f1f5c',
                    900: '#0a1540',
                },
            },
        },
    },
    plugins: [
        forms,
        require('flowbite/plugin'),
    ],
};