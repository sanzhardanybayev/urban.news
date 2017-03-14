/**
 * Created by Sanzhar on 22.11.2016.
 */

'use strict';

var gulp = require('gulp');
var jade = require('gulp-jade');
var sass = require('gulp-sass');
var browserSync = require('browser-sync').create();

var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var cleanCSS = require('gulp-clean-css');


// Static server
gulp.task('browser-sync', function () {
    browserSync.init({
        server: {
            baseDir: "./"
        }
    });
});

gulp.task('sass', function () {
    return gulp.src('sass/styles.sass')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./css'));
});

gulp.task('cssprod', ['sass'], function () {
    return gulp.src([
        './vendor/bower/materialize/dist/css/materialize.min.css',
        './css/material-icons.css',
        './css/select2-materialize.css',
        './vendor/bower/sweetalert/dist/sweetalert.css',
        './vendor/bower/components-font-awesome/css/font-awesome.min.css',
        './css/styles.css'])
        .pipe(concat({path: 'all.css'}))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(gulp.dest('dist'));
});

gulp.task('step', ['sass', 'cssprod']);

gulp.task('cs', function () {
    gulp.watch(['./sass/*.sass', './sass/*.scss'], ['step']);
    gulp.watch(['./js/*.js'], ['jsprod']);
});


gulp.task('jsprod', function () {
    return gulp.src([
        './vendor/bower/jquery/dist/jquery.min.js',
        './vendor/bower/materialize/dist/js/materialize.min.js',
        './vendor/bower/sweetalert/dist/sweetalert.min.js',
        './js/app.js',
        './js/pusher.min.js'
    ])
        .pipe(concat('all.js'))
        .pipe(uglify())
        .pipe(gulp.dest('dist/'));
});

gulp.task('froalacss', function () {
    return gulp.src([
        './vendor/font-awesome/css/font-awesone.min.css',
        './vendor/froala/css/froala_editor.min.css',
        './vendor/froala/css/froala_style.min.css',
        './vendor/froala/css/plugins/char_counter.css',
        './vendor/froala/css/plugins/code_view.css',
        './vendor/froala/css/plugins/colors.css',
        './vendor/froala/css/plugins/emoticons.css',
        './vendor/froala/css/plugins/file.css',
        './vendor/froala/css/plugins/fullscreen.css',
        './vendor/froala/css/plugins/image.css',
        './vendor/froala/css/plugins/image_manager.css',
        './vendor/froala/css/plugins/line_breaker.css',
        './vendor/froala/css/plugins/quick_insert.css',
        './vendor/froala/css/plugins/table.css'
    ]).pipe(concat({path: 'froala.css'}))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(gulp.dest('dist/css'));
});
gulp.task('froalajs', function () {
    return gulp.src([
        './vendor/froala/js/froala_editor.min.js',
        './vendor/froala/js/plugins/align.min.js',
        './vendor/froala/js/plugins/char_counter.min.js',
        './vendor/froala/js/plugins/code_beautifier.min.js',
        './vendor/froala/js/plugins/code_view.min.js',
        './vendor/froala/js/plugins/colors.min.js',
        './vendor/froala/js/plugins/emoticons.min.js',
        './vendor/froala/js/plugins/entities.min.js',
        './vendor/froala/js/plugins/file.min.js',
        './vendor/froala/js/plugins/font_family.min.js',
        './vendor/froala/js/plugins/font_size.min.js',
        './vendor/froala/js/plugins/fullscreen.min.js',
        './vendor/froala/js/plugins/image.min.js',
        './vendor/froala/js/plugins/image_manager.min.js',
        './vendor/froala/js/plugins/inline_style.min.js',
        './vendor/froala/js/plugins/line_breaker.min.js',
        './vendor/froala/js/plugins/link.min.js',
        './vendor/froala/js/plugins/lists.min.js',
        './vendor/froala/js/plugins/paragraph_format.min.js',
        './vendor/froala/js/plugins/paragraph_style.min.js',
        './vendor/froala/js/plugins/quick_insert.min.js',
        './vendor/froala/js/plugins/quote.min.js',
        './vendor/froala/js/plugins/table.min.js',
        './vendor/froala/js/plugins/save.min.js',
        './vendor/froala/js/plugins/url.min.js',
        './vendor/froala/js/plugins/video.min.js',
        './js/froalaInit.js',
        './js/crud.js'
    ]).pipe(concat('vendor.js'))
        .pipe(uglify())
        .pipe(gulp.dest('dist/js'));
});

