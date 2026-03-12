const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                cream: {
                    100: "#FFFDD0", // fixed typo (last char is zero, not 'O')
                },
                navyblue: {
                    900: "#001F3F",
                },
                lightblue: {
                    300: "#ADD8E6",
                },
                snow:{
                    100: "#FFFAFA",
                }
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
