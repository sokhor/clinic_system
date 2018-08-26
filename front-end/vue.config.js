module.exports = {
  baseUrl: "/",
  productionSourceMap: false,
  css: {
    loaderOptions: {
      postcss: {
        plugins: [
          require("postcss-import"),
          require("tailwindcss")("./tailwind.js")
        ]
      }
    }
  }
};
