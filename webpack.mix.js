const mix = require('laravel-mix');
require('@tinypixelco/laravel-mix-wp-blocks');

mix.setPublicPath('dist');

// TODO: dist/undefined.js & dist/undefined.asset.php??
mix.sass('src/block.scss', 'css')
    .block('src/editor.js', 'js');