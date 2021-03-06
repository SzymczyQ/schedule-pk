var Encore = require('@symfony/webpack-encore');
var CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    // Images trick
    .addEntry('js/images', './assets/js/images.js')

    // Core JavaScript files
    .addEntry('js/plugins/adminlte', './assets/js/plugins/adminlte.js')
    .addEntry('js/plugins/bootstrap', './assets/js/plugins/bootstrap.js')
    .addEntry('js/plugins/fastclick', './assets/js/plugins/fastclick.js')
    .addEntry('js/plugins/jquery', './assets/js/plugins/jquery.js')
    .addEntry('js/plugins/jquery.slimscroll', './assets/js/plugins/jquery.slimscroll.js')
    .addEntry('js/plugins/jquery.dataTables', './assets/js/plugins/jquery.dataTables.js')

    // Global JavaScripts
    .addEntry('js/notifications/notifications', './assets/js/notifications/notifications.js')

    // Login page
    .addEntry('js/login/login', './assets/js/login/login.js')

    // User page
    .addEntry('js/user/user', './assets/js/user/user.js')

    // Home page
    .addEntry('js/homepage/homepage', [
        './assets/js/plugins/jquery.dataTables.js',
        './assets/js/plugins/dataTables.bootstrap.js',
        './assets/js/homepage/homepage.js',
        './assets/js/plugins/dataTables.buttons.min.js',
        './assets/js/plugins/buttons.flash.min.js',
        './assets/js/plugins/jszip.min.js',
        './assets/js/plugins/pdfmake.min.js',
        './assets/js/plugins/buttons.html5.min.js',
        './assets/js/plugins/buttons.print.min.js'
    ])

    // Project CSS files
    .addStyleEntry('css/bootstrap', './assets/css/bootstrap.css')
    .addStyleEntry('css/font-awesome', './assets/css/font-awesome.css')
    .addStyleEntry('css/ionicons', './assets/css/ionicons.css')
    .addStyleEntry('css/adminlte', './assets/css/adminlte.css')
    .addStyleEntry('css/skin-green', './assets/css/skin-green.css')
    .addStyleEntry('css/dataTables.bootstrap', './assets/css/dataTables.bootstrap.css')

    // Custom styles
    .addStyleEntry('css/error', './assets/scss/error.scss')
    .addStyleEntry('css/style', './assets/scss/style.scss')

    // Webpack build configuration
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableSassLoader()

    // Jquery options
    .autoProvidejQuery()
    .autoProvideVariables({
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery',
    })

    // Copy already minified files
    .addPlugin(new CopyWebpackPlugin([
        { from: './assets/js/plugins/respond.min.js', to: 'js/plugins/' },
        { from: './assets/js/plugins/html5shiv.min.js', to: 'js/plugins/' },
        { from: './assets/js/plugins/vfs_fonts.js', to: 'js/plugins/' }
    ]))
;

module.exports = Encore.getWebpackConfig();
