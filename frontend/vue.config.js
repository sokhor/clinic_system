let glob = require('glob-all')
let PurgecssPlugin = require('purgecss-webpack-plugin')
const path = require('path')

class TailwindExtractor {
  static extract(content) {
    return content.match(/[A-Za-z0-9-_:/]+/g) || []
  }
}

module.exports = {
  configureWebpack: {
    plugins: [
      new PurgecssPlugin({
        paths: glob.sync([path.join(__dirname, './**/*.vue')]),
        extractors: [
          {
            extractor: TailwindExtractor,
            extensions: ['html', 'js', 'php', 'vue']
          }
        ]
      })
    ]
  },
  productionSourceMap: false,
  css: {
    loaderOptions: {
      postcss: {
        plugins: [
          require('postcss-import'),
          require('tailwindcss')('./tailwind.js')
        ]
      }
    }
  },
  lintOnSave: undefined,
  // // proxy API requests to Valet during development
  devServer: {
    proxy: 'http://clinic.test'
  },

  // output built static files to Laravel's public dir.
  // note the "build" script in package.json needs to be modified as well.
  outputDir: '../public',

  // modify the location of the generated HTML file.
  // make sure to do this only in production.
  indexPath:
    process.env.NODE_ENV === 'production'
      ? '../resources/views/index.blade.php'
      : 'index.html'
}
