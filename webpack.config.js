var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/assets/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableVersioning(false)
    .addEntry('js/app', './resources/assets/js/app.js')
    .addStyleEntry('css/app', ['./resources/assets/css/app.css'])
;

module.exports = Encore.getWebpackConfig();