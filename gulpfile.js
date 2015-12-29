var elixir = require('laravel-elixir');
var gulp = require('gulp');
var util = require('gulp-util');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

gulp.task('farewell', function() {
    util.log('Have a good one.');
});

elixir(function (mix) {
    mix.sass('app.scss', 'public/assets/css/app.css');
    mix.copy('node_modules/material-design-lite/material.min.css', 'public/assets/css/material.min.css');
    mix.copy('node_modules/material-design-lite/material.min.js', 'public/assets/js/material.min.js');
    mix.copy('resources/assets/images', 'public/assets/images');
    mix.task('farewell');
});
