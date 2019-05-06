//var Encore = require('@symfony/webpack-encore');

//Encore
    // directory where compiled assets will be stored
  //  .setOutputPath('public/build/')
    // public path used by the web server to access the output path
  //  .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */
  //  .addEntry('app', './assets/js/app.js')
    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
  //  .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
  //  .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
  //  .cleanupOutputBeforeBuild()
  //  .enableBuildNotifications()
  //  .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
  //  .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
  //  .configureBabel(() => {}, {
    //    useBuiltIns: 'usage',
    //    corejs: 3
  //  })

    // enables Sass/SCSS support
    //.enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes()

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()

    // uncomment if you use API Platform Admin (composer req api-admin)
    //.enableReactPreset()
    //.addEntry('admin', './assets/js/admin.js')
//;

// module.exports = Encore.getWebpackConfig();

/*var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build')
    .setPublicPath('/build')

    .cleanupOutputBeforeBuild()
    .enableSourceMaps()

    .addEntry('js/app', './assets/js/app.js')
    .addStyleEntry('css/app', './assets/css/app.css');
module.exports = Encore.getWebpackConfig();*/

const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
let conf = {
    entry: {
        app: './assets/js/app.js'
    },
    output: {
        filename: './js/main.js',
        path: path.resolve(__dirname, './public'),
        publicPath: '/public'
    },
    module: {
        rules: [{
            test: /\.css$/,
            use: [
                MiniCssExtractPlugin.loader,
                "css-loader"
            ]
        },
            {
                test: /\.scss$/,
                use: [
                    "style-loader",
                    MiniCssExtractPlugin.loader,
                    {
                        loader: "css-loader",
                        options: {
                            sourceMap: true
                        }
                    },
                    {
                        loader: "sass-loader",
                        options: {
                            sourceMap: true
                        }
                    }
                ]
            }]
    },
    devServer: {
        overlay: true
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "/css/styles.css"
        })
    ]
}

module.exports = conf;