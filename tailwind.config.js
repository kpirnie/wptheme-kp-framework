/** @type {import('tailwindcss').Config} */
module.exports = {
    important: true,
    content: [
        './*.php',
        './template-parts/**/*.php',
        './templates/**/*.php',
        './assets/js/**/*.js',
    ],
    plugins: [
        require('@tailwindcss/typography'),
    ],
}
