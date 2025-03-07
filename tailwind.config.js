/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors:{
        'custom-gray': '#8C8C8C',
        'custom-violet': '#5B34EB',
        'custom-orange':'#FF3636',
        'custom-blue':'#F1F9FF',

      },
    },
  },
  plugins: [],
}

