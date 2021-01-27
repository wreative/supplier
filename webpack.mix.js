const mix = require("laravel-mix");

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

// CSS
mix.styles(
    [
        "resources/css/daterangepicker.css",
        "resources/css/dataTables.bootstrap4.min.css",
        "resources/css/searchBuilder.dataTables.min.css",
        "resources/css/buttons.bootstrap4.min.css",
        "resources/css/responsive.bootstrap4.min.css",
        "resources/css/select2.min.css",
        "resources/css/style.css",
        "resources/css/components.css"
    ],
    "public/assets.css"
);

// Javascript
mix.scripts(
    [
        "resources/js/stisla.js",
        "resources/js/daterangepicker.js",
        "resources/js/jquery.dataTables.min.js",
        "resources/js/dataTables.bootstrap4.min.js",
        "resources/js/dataTables.searchBuilder.min.js",
        "resources/js/dataTables.buttons.min.js",
        "resources/js/buttons.bootstrap4.min.js",
        "resources/js/buttons.flash.min.js",
        "resources/js/buttons.html5.min.js",
        "resources/js/buttons.print.min.js",
        "resources/js/dataTables.responsive.min.js",
        "resources/js/responsive.bootstrap4.min.js",
        "resources/js/Chart.min.js",
        "resources/js/select2.full.min.js",
        "resources/js/cleave.min.js",
        "resources/js/cleave-phone.id.js",
        "resources/js/scripts.js"
    ],
    "public/assets.js"
);
