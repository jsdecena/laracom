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
            'resources/admin-lte/css/AdminLTE.min.css',
            'resources/admin-lte/css/skins/skin-purple.min.css',
            'node_modules/datatables/media/css/jquery.dataTables.css',
            'resources/css/admin.css'
        ],
        'public/css/admin.min.css'
    )
    .styles(
        [
            'node_modules/bootstrap/dist/css/bootstrap.css',
            'node_modules/font-awesome/css/font-awesome.css',
            'node_modules/select2/dist/css/select2.css',
            'resources/css/drift-basic.min.css',
            'resources/css/front.css'
        ],
        'public/css/style.min.css'
    )
    .scripts(
        [
            'resources/js/jquery-2.2.3.min.js',
            'node_modules/bootstrap/dist/js/bootstrap.js',
            'node_modules/select2/dist/js/select2.js',
            'node_modules/datatables/media/js/jquery.dataTables.js',
            'resources/admin-lte/js/app.js'
        ],
        'public/js/admin.min.js'
    )
    .scripts(
        [
            'node_modules/bootstrap/dist/js/bootstrap.js',
            'node_modules/select2/dist/js/select2.js',
            'resources/js/owl.carousel.min.js',
            'resources/js/Drift.min.js'
        ],
        'public/js/front.min.js'
    )
    .copyDirectory('node_modules/datatables/media/images', 'public/images')
    .copyDirectory('node_modules/font-awesome/fonts', 'public/fonts')
    .copyDirectory('resources/admin-lte/img', 'public/img')
    .copyDirectory('resources/images', 'public/images')
    .copy('resources/js/scripts.js', 'public/js/scripts.js')
    .copy('resources/js/custom.js', 'public/js/custom.js');
