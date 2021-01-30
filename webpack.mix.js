const mix = require('laravel-mix');
require('laravel-mix-brotli');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
// mix.config.webpackConfig.output = {
//     chunkFilename: 'js/[name].bundle.js',
//     publicPath: '/',
// };

mix.js('resources/js/app.js', 'public/js').vue()
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]).brotli();
mix.disableSuccessNotifications();