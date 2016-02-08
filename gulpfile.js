var gulp = require('gulp');
var rename = require('gulp-rename');
var compass = require('gulp-compass');
var minifyCSS = require('gulp-minify-css');

gulp.task('css', function () {
    gulp.src('resources/assets/sass/app.scss')
        .pipe(compass({
            css: 'public/assets/css',
            sass: 'resources/assets/sass',
            image: 'resources/assets/images'
        }))
        .pipe(minifyCSS())
        .pipe(gulp.dest('public/assets/css'));
});

gulp.task('copy', function () {
    gulp.src('node_modules/material-design-lite/dist/material.blue-orange.min.css')
        .pipe(rename('material.min.css'))
        .pipe(gulp.dest('public/assets/css/'));

    gulp.src([
        'node_modules/material-design-lite/material.min.js',
        'node_modules/angular/angular.min.js'
    ])
        .pipe(gulp.dest('public/assets/js/'));
});

gulp.task('images', function () {
    gulp.src(['resources/assets/images/**/*'])
        .pipe(gulp.dest('public/assets/images'));
});

gulp.task('js', function () {
    gulp.src(['resources/assets/js/**/*'])
        .pipe(gulp.dest('public/assets/js'));
});

gulp.task('watch', function() {
    gulp.watch('resources/assets/sass/**/*.scss', ['css']);
    gulp.watch('resources/assets/images/**/*', ['images']);
    gulp.watch('resources/assets/js/**/*', ['js']);
});

gulp.task('default', ['css', 'copy', 'images', 'js']);