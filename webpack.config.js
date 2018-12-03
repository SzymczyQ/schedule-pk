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

    // Global JavaScripts
    .addEntry('js/notifications/notifications', './assets/js/notifications/notifications.js')

    // Login page
    .addEntry('js/login/login', './assets/js/login/login.js')

    // User page
    .addEntry('js/user/user', './assets/js/user/user.js')

    // Project CSS files
    .addStyleEntry('css/bootstrap', './assets/css/bootstrap.css')
    .addStyleEntry('css/font-awesome', './assets/css/font-awesome.css')
    .addStyleEntry('css/ionicons', './assets/css/ionicons.css')
    .addStyleEntry('css/adminlte', './assets/css/adminlte.css')
    .addStyleEntry('css/skin-green', './assets/css/skin-green.css')

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
        { from: './assets/js/plugins/html5shiv.min.js', to: 'js/plugins/' }
    ]))
;

module.exports = Encore.getWebpackConfig();
