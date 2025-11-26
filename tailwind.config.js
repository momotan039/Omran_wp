/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.php',
    './template-parts/**/*.php',
    './inc/**/*.php',
    './assets/js/**/*.js',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Cairo', 'sans-serif'],
      },
      colors: {
        primary: '#047857',
        secondary: '#10b981',
        accent: '#f3f4f6',
        brand: {
          dark: '#064e3b',
          light: '#ecfdf5',
          gray: '#9ca3af'
        }
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}

