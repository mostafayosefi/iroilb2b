/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./resources/js/components/site/**/*.vue"],
    theme: {
        extend: {
            colors: {
                'dark-primary': '#495464',
                'dark-secondary': '#BBBFCA',
                'white-primary': '#E8E8E8',
                'white-secondary': '#F4F4F2',
            },
        },
    },
    plugins: [
        require('tailwindcss-animated')
    ],
}
