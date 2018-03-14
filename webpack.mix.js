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
            'node_modules/admin-lte/dist/css/AdminLTE.min.css',
            'node_modules/admin-lte/dist/css/skins/skin-purple.min.css',
            'node_modules/datatables/media/css/jquery.dataTables.css',
            'resources/assets/css/style.css'
        ],
        'public/css/admin.min.css'
    ).scripts(
        [
            'resources/assets/js/jquery-2.2.3.min.js',
            'node_modules/bootstrap/dist/js/bootstrap.js',
            'node_modules/admin-lte/dist/js/app.js',
            'node_modules/select2/dist/js/select2.js',
            'node_modules/datatables/media/js/jquery.dataTables.js'
        ],
        'public/js/admin.min.js'
    )
    .copyDirectory('node_modules/datatables/media/images', 'public/images')
    .copyDirectory('node_modules/font-awesome/fonts', 'public/fonts')
    .copyDirectory('node_modules/admin-lte/dist/img', 'public/img')
    .copy('resources/assets/js/scripts.js', 'public/js/scripts.js');
