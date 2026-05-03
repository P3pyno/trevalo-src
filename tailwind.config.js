/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
      },
      colors: {
        navy: {
          50:  '#EEF1F8',
          100: '#D4DBEE',
          200: '#A9B7DD',
          300: '#7E93CB',
          400: '#5370BA',
          500: '#284CA8',
          600: '#1A3A8F',
          700: '#0D1B4B',
          800: '#091335',
          900: '#040A1F',
        },
        gold: {
          50:  '#FBF5E7',
          100: '#F5E8C7',
          200: '#EED5A0',
          300: '#E8C278',
          400: '#C8A45D',
          500: '#B8893A',
          600: '#9A6E20',
          700: '#7A5518',
        },
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
