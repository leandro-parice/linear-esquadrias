let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
	.setPublicPath('public_html')
	.sass('resources/assets/sass/site.scss', 'public_html/css')
	.js('resources/assets/js/site.js', 'public_html/js')
	.options({ processCssUrls: false });

/*

.js('resources/assets/js/site.js', '../html/js')
   .sass('resources/assets/sass/site.scss', '../html/css');

*/
