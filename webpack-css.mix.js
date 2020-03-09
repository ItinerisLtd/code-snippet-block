const mix = require('laravel-mix');

mix.setPublicPath('dist');

mix.sass('src/block.scss', 'css');
