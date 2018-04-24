var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
const browserSync = require('browser-sync').create();
const watch = require('gulp-watch');
const cssmin = require('gulp-cssmin');


//var directory = 'default';
// var directory = 'counselor';
// var directory = 'corporate';
var directory = 'shared/post';
// var directory = 'token_sale';
//var directory = 'ico';
//var directory = 'crypto_blog';
//var directory = 'creative_ico';
// var directory = 'ico_directory';
// var directory = 'ico_listing';

gulp.task('styles', function(){
    "use strict";

    gulp.src(['./assets/scss/' + directory + '/**/*.scss'])
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(cssmin())
        .pipe(gulp.dest('./assets/css/' + directory))
        .pipe(browserSync.stream())
});

gulp.task('watch', function () {
    watch(['./assets/scss/' + directory + '/**/*.scss'], function (e) {
        gulp.start('styles')
    });
});

gulp.task('serve', function () {
    "use strict";
    browserSync.init({
        proxy: "http://blockchain.loc",
        host: "192.168.0.124",
        port: 3000,
        notify: true,
        ui: {
            port: 3001
        },
        open: false
    });
});

gulp.task('all', function () {
    "use strict";

    gulp.src(['./assets/scss/**/main.scss'])
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(cssmin())
        .pipe(gulp.dest('./assets/css/'))
});

gulp.task('default', ['watch', 'serve']);