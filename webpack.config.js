var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    // Images trick
    .addEntry('prod/js/images', './assets/js/images.js')

    // Javascript files
    .addEntry('js/respond', './assets/js/respond.min.js')
    .addEntry('js/html5shiv', './assets/js/html5shiv.min.js')
    .addEntry('js/bootstrap', './assets/js/bootstrap.js')
    .addEntry('js/fastclick', './assets/js/fastclick.js')
    .addEntry('js/jquery', './assets/js/jquery.js')
    .addEntry('js/jquery.slimscroll', './assets/js/jquery.slimscroll.js')
    .addEntry('js/adminlte', './assets/js/adminlte.js')
    .addEntry('js/demo', './assets/js/demo.js')

    .addStyleEntry('css/bootstrap', './assets/css/bootstrap.css')
    .addStyleEntry('css/font-awesome', './assets/css/font-awesome.css')
    .addStyleEntry('css/ionicons', './assets/css/ionicons.css')
    .addStyleEntry('css/adminlte', './assets/css/adminlte.css')
    .addStyleEntry('css/skin-green', './assets/css/skin-green.css')
    .addStyleEntry('css/custom', './assets/css/custom.css')

    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())

    .enableSassLoader()

    // .configureFilenames({
    //     images: '/images/[name].[hash:8].[ext]',
    //     fonts: 'fonts/[name].[hash:8].[ext]',
    //     js: '[name].[hash:8].js',
    //     css: '[name].[hash:8].css',
    // })

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
