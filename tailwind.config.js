/** @type {import('tailwindcss').Config} */
module.exports = {
  content:  ["./app/Views/**/*.{html,js,php}"],
  theme: {
    extend: {
      animation: {
        'slide-left-to-right': 'leftToRight 0.7s ease-in-out',
        'slide-right-to-left': 'rightToLeft 0.7s ease-in-out',
        'slide-bottom-to-top': 'bottomToTop 0.7s ease-in-out',
        'slide-top-to-bottom': 'topToBottom 0.7s ease-in-out',
      },
      keyframes: {
        leftToRight: {
          '0%': { 
            transform: 'translateX(-100%)',
            opacity: 0,
          },
          '100%': { 
            transform: 'translateX(0)',
            opacity: 1,
          },
        },
        rightToLeft: {
          '0%': { 
            transform: 'translateX(200%)',
            opacity: 0,
          },
          '100%': { 
            transform: 'translateX(0)',
            opacity: 1,
          },
        },
        bottomToTop: {
          '0%': { 
            transform: 'translateY(200%)',
            opacity: 0,
          },
          '100%': { 
            transform: 'translateY(0)',
            opacity: 100,
          },
        },
        topToBottom: {
          '0%': { 
            transform: 'translateY(-200%)',
            opacity: 0,
          },
          '100%': { 
            transform: 'translateY(0)',
            opacity: 100,
          },
        }
      },
    },
  },
  plugins: [],
}

