module.exports = {
  theme: {
    extend: {
      width: {
        '96': '24rem',
      },

      container: {
        center: true,
      },

    },

    fontFamily : {
      body: ['Lato', 'sans-serif'],
      display: ['Lato', 'sans-serif'],
    }
  },
  variants: {
    backgroundColor: ['responsive', 'hover', 'focus', 'active'],
  },
  plugins: []
}
