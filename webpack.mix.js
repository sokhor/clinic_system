let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');

mix.js('resources/assets/js/app.js', 'public/js')
.sass('resources/assets/sass/app.scss', 'public/css')
.options({
  processCssUrls: false,
  postCss: [ tailwindcss('./tailwind.js') ],
})
.webpackConfig({
  output: { chunkFilename: 'js/chunks/[name].[chunkhash].js', publicPath: '/' }
});
