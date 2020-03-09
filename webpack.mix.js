const mix = require('laravel-mix');
require('@tinypixelco/laravel-mix-wp-blocks');

mix.setPublicPath('dist');

mix.block('src/editor.js', 'js');