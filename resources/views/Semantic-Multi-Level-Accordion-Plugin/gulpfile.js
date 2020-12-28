// gulp
const gulp = require('gulp');

// css
const sass = require('gulp-sass');
const plumber = require('gulp-plumber');
const cleanCSS = require('gulp-clean-css');
const sourcemaps = require('gulp-sourcemaps');

// js
const uglify = require('gulp-uglify');

// webserver
var webserver = require('gulp-webserver');

// path settings
const src = {
    _base: './src',
    css: './src/sass',
    js: './src/js',
};
const dest = {
    _base: './dist',
    css: './dist/css',
    js: './dist/js'
};


/**
 * gulp tasks
 */

// build:css
gulp.task('build:css', function(){
    return gulp.src(src.css + '/*.scss')
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(cleanCSS())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(dest.css));
});

// build:js
gulp.task('build:js', function() {
    return gulp.src(src.js + '/*.js')
        .pipe(plumber())
        .pipe(uglify())
        .pipe(gulp.dest(dest.js));
});

// build:all
gulp.task('build', ['build:css', 'build:js']);

// watch
gulp.task('watch', function(){
    gulp.watch(src.css + '/**/*', ['build:css']);
    gulp.watch(src.js + '/**/*', ['build:js']);
});

// webserver
gulp.task('webserver', function() {
  gulp.src('./dist')
    .pipe(webserver({
      livereload: true,
      directoryListing: false,
      open: false
    }));
});

// default
gulp.task('default', ['build', 'watch', 'webserver']);
