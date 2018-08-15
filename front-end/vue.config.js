module.exports = {
  css: {
    loaderOptions: {
      postcss: {
        plugins: [
          require("tailwindcss")("./tailwind.js")
        ]
      }
    }
  }
}