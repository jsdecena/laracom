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
    .styles(
        [
            'node_modules/bootstrap/dist/css/bootstrap.css',
            'node_modules/font-awesome/css/font-awesome.css',
            'node_modules/ionicons/dist/css/ionicons.css',
            'node_modules/select2/dist/css/select2.css',
            'resources/assets/admin-lte/css/AdminLTE.min.css',
            'resources/assets/admin-lte/css/skins/skin-purple.min.css',
            'node_modules/datatables/media/css/jquery.dataTables.css',
            'resources/assets/css/admin.css'
        ],
        'public/css/admin.min.css'
    )
    .scripts(
        [
            'resources/assets/js/jquery-2.2.3.min.js',
            'node_modules/bootstrap/dist/js/bootstrap.js',
            'node_modules/select2/dist/js/select2.js',
            'node_modules/datatables/media/js/jquery.dataTables.js',
            'resources/assets/admin-lte/js/app.js'
        ],
        'public/js/admin.min.js'
    )
    .styles(
        [
            'node_modules/bootstrap/dist/css/bootstrap.css',
            'node_modules/font-awesome/css/font-awesome.css',
            'node_modules/select2/dist/css/select2.css',
            'resources/assets/css/drift-basic.min.css',
            'resources/assets/css/front.css'
        ],
        'public/css/style.min.css'
    )
    .scripts(
        [
            'node_modules/bootstrap/dist/js/bootstrap.js',
            'node_modules/select2/dist/js/select2.js',
            'resources/assets/js/owl.carousel.min.js',
            'resources/assets/js/Drift.min.js'
        ],
        'public/js/front.min.js'
    )
    .copyDirectory('node_modules/datatables/media/images', 'public/images')
    .copyDirectory('node_modules/font-awesome/fonts', 'public/fonts')
    .copyDirectory('resources/assets/admin-lte/img', 'public/img')
    .copyDirectory('resources/assets/images', 'public/images')
    .copy('resources/assets/js/scripts.js', 'public/js/scripts.js')
    .copy('resources/assets/js/custom.js', 'public/js/custom.js');

/*
|-----------------------------------------------------------------------
| BrowserSync
|-----------------------------------------------------------------------
|
| BrowserSync refreshes the Browser if file changes (js, sass, blade.php) are
| detected.
| Proxy specifies the location from where the app is served.
| For more information: https://browsersync.io/docs
*/
mix.browserSync({
  proxy: 'http://localhost:8000',
  host: 'localhost',
  open: true,
  watchOptions: {
    usePolling: false
  },
  files: [
    'app/**/*.php',
    'resources/views/**/*.php',
    'public/js/**/*.js',
    'public/css/**/*.css',
    'resources/docs/**/*.md'
  ]
});