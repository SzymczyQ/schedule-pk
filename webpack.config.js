var Encore = require('@symfony/webpack-encore');
var CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    // Images trick
    .addEntry('js/images', './assets/js/images.js')

    // Login page
    .addEntry('js/login/login', './assets/js/login/login.js')

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

    .autoProvidejQuery()
    .autoProvideVariables({
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery',
    })

    .addPlugin(new CopyWebpackPlugin([
        { from: './assets/js/respond.min.js', to: 'js/' },
        { from: './assets/js/html5shiv.min.js', to: 'js/' },
        { from: './assets/js/bootstrap.js', to: 'js/' },
        { from: './assets/js/fastclick.js', to: 'js/' },
        { from: './assets/js/jquery.slimscroll.js', to: 'js/' },
        { from: './assets/js/jquery.js', to: 'js/' },
        { from: './assets/js/adminlte.js', to: 'js/' },
    ]))
;

module.exports = Encore.getWebpackConfig();
