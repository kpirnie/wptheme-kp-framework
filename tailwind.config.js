/** @type {import('tailwindcss').Config} */
module.exports = {
    important: true,
    content: [
        './*.php',
        './template-parts/**/*.php',
        './templates/**/*.php',
        './work/**/*.php',
        './assets/js/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                primary: '#3b82f6',
                secondary: '#6b7280',
            },
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
    ],
}