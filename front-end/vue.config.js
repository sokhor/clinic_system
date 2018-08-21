module.exports = {
  baseUrl: '/',
  productionSourceMap: false,
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