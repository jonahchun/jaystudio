const mix = require('laravel-mix');

let SVGSpritemapPlugin = require('svg-spritemap-webpack-plugin');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/main.scss', 'public/css')
    .webpackConfig({
        plugins: [
            new SVGSpritemapPlugin('resources/images/svg-icons/*.svg', {
                output: {
                    filename: '../resources/views/page/icons.blade.php'
                },
                sprite: {
                    generate: {
                        title: false
                    },
                    prefix: 'icon-',
                },
            }),
        ]
     })
    .copyDirectory('resources/images', 'public/images')
    .copyDirectory('resources/favicon', 'public/favicon')
    .version();
