const mix = require('laravel-mix');

mix.webpackConfig({
    output: {
        chunkFilename: 'dist/js/[name].js',
        publicPath: '/',
    },
}).version();

mix.js('resources/assets/js/app.js', 'public/dist/js')
    .sass('resources/assets/sass/app.scss', 'public/dist/css');
