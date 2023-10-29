/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./resources/views/**/*.blade.php",
      "./resources/js/**/*.js",
    ],
    theme: {
        extend: {
            fontFamily: {
                // 
            },
        },
    },
    plugins: [
      require('@tailwindcss/forms'),
    ],
  }
  