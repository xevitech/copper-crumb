require('dotenv').config();
const mix = require('laravel-mix');


const baseUrl = process.env.APP_URL;



// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css');

mix.js('resources/js/app.js', 'public/js').webpackConfig({
    output: {
        chunkFilename: 'js/chunks/[name].js?id=[chunkhash]',
        publicPath: `${baseUrl}/`,
    }
}).version().vue();
