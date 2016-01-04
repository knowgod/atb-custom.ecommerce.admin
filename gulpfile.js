var gulp = require('gulp');
var sass = require('gulp-sass');


gulp.task('css', function () {
    gulp.src('resources/assets/sass/app.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('public/assets/css'));
});

gulp.task('copy', function () {
    gulp.src('node_modules/material-design-lite/material.min.css')
        .pipe(gulp.dest('public/assets/css/'));

    gulp.src('node_modules/material-design-lite/material.min.js')
        .pipe(gulp.dest('public/assets/js/'));
});

gulp.task('images', function () {
    gulp.src(['resources/assets/images/**/*'])
        .pipe(gulp.dest('public/assets/images'));
});

gulp.task('watch', function() {
    gulp.watch('resources/assets/sass/*.scss', ['css']);
    gulp.watch('resources/assets/images/**/*', ['images']);
});

gulp.task('default', ['css', 'copy', 'images']);