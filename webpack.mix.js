const mix = require('laravel-mix');



// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css');

mix.js('resources/js/app.js', 'public/js').webpackConfig({
    output: {
        chunkFilename: 'js/chunks/[name].js?id=[chunkhash]',
        publicPath: '/',
    }
}).version().vue();
