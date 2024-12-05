// tailwind.config.js
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{html,js}", // Sesuaikan dengan struktur proyek Anda
    "./public/index.html",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Poppins', 'sans-serif'], // Menambahkan font Poppins ke default sans
      },
    },
  },
}