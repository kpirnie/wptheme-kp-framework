module.exports = {
    content: [
        './*.php',
        './template-parts/**/*.php',
        './templates/**/*.php',
        './work/**/*.php',
    ],
    plugins: [
        require('@tailwindcss/typography'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/container-queries'),
    ],
}