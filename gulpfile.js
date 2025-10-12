// jshint node: true, esversion: 6

// Strict mode
'use strict';

// Core
const fs = require('fs');
const path = require('path');

// Modules
const del = require('del');
const gulp = require('gulp');

// Plugins
const autoprefixer = require('gulp-autoprefixer');
const concat = require('gulp-concat');
const csso = require('gulp-csso');
const filter = require('gulp-filter');
const include = require('gulp-include');
const plumber = require('gulp-plumber');
const rename = require('gulp-rename');
const sass = require('gulp-sass')(require('sass'));
const sourcemaps = require('gulp-sourcemaps');
const touch = require('gulp-touch-fd');
const uglify = require('gulp-uglify');

// DotEnv
require('dotenv').config();

// BrowserSync
const browserSync = require('browser-sync').create();

// Configuration
const cssSrc = [
    './src/scss/**/*.scss'
];

const cssLibSrc = [
    './node_modules/leaflet/dist/leaflet.css',
    './node_modules/leaflet.markercluster/dist/MarkerCluster.css',
    './node_modules/leaflet.markercluster/dist/MarkerCluster.Default.css',
    './node_modules/magnific-popup/dist/magnific-popup.css',
    './node_modules/swiper/swiper-bundle.min.css'
];

const jsSrc = {
    'main': [
        './src/js/main/init.js',
        './src/js/main/**/*.js'
    ],
    'admin': [
        './src/js/admin/**/*.js'
    ],
    'zepto': [
        './node_modules/zepto/src/zepto.js',
        './node_modules/zepto/src/event.js',
        './node_modules/zepto/src/ajax.js',
    ]
};

const jsLibSrc = [
    './node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
    './node_modules/leaflet/dist/leaflet.js',
    './node_modules/leaflet.markercluster/dist/leaflet.markercluster.js',
    './node_modules/magnific-popup/dist/jquery.magnific-popup.min.js',
    './node_modules/swiper/swiper-bundle.min.js'
];

const cssDest = './dist/css';
const cssLibDest = cssDest + '/lib';
const jsDest = './dist/js';
const jsLibDest = jsDest + '/lib';

// Tasks
function cssClean() {
    return del(cssDest);
}

function jsClean() {
    return del(jsDest);
}

function cssBuild() {
    return gulp.src(cssSrc)
        .pipe(plumber())

        // Create map(s) and write uncompressed development version
        .pipe(sourcemaps.init())
        .pipe(sass.sync({
            includePaths: ['.'],
            quietDeps: true
        }).on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(cssDest))
        .pipe(touch())

        // Remove map(s) and write compressed production version
        .pipe(filter('**/*.css'))
        .pipe(rename({suffix: '.min'}))
        .pipe(csso())
        .pipe(gulp.dest(cssDest))
        .pipe(touch());
}

function cssLibBuild(done) {
    if (!fs.existsSync(cssLibDest)) {
        fs.mkdirSync(cssLibDest, {recursive: true});
    }

    for (let src of cssLibSrc) {
        if (fs.existsSync(src)) {
            fs.copyFileSync(src, cssLibDest + '/' + path.basename(src));
        }
    }

    return done();
}

function jsBuild(done) {
    let tasks = Object.keys(jsSrc).map(function (name) {
        return function () {
            return gulp.src(jsSrc[name])
                .pipe(plumber())

                // Create map(s) and write uncompressed development version
                .pipe(sourcemaps.init())
                .pipe(include({
                    includePaths: ['.']
                }))
                .pipe(concat(name + '.js'))
                .pipe(sourcemaps.write('.'))
                .pipe(gulp.dest(jsDest))
                .pipe(touch())

                // Remove map(s) and write compressed production version
                .pipe(filter('**/*.js'))
                .pipe(rename({suffix: '.min'}))
                .pipe(uglify())
                .pipe(gulp.dest(jsDest))
                .pipe(touch());
        };
    });

    return gulp.parallel(...tasks, function (tasksDone) {
        tasksDone();
        done();
    })();
}

function jsLibBuild(done) {
    if (!fs.existsSync(jsLibDest)) {
        fs.mkdirSync(jsLibDest, {recursive: true});
    }

    for (let src of jsLibSrc) {
        if (fs.existsSync(src)) {
            fs.copyFileSync(src, jsLibDest + '/' + path.basename(src));
        }
    }

    return done();
}

const cssTask = gulp.series(cssClean, cssBuild, cssLibBuild);
const jsTask = gulp.series(jsClean, jsBuild, jsLibBuild);

// Combined
function watch() {
    gulp.watch(cssSrc, cssTask);

    for (let key in jsSrc) {
        gulp.watch(jsSrc[key], jsTask);
    }
}

function serve() {
    let domain = 'localhost';

    if (typeof process.env.DEVELOPMENT_DOMAIN !== 'undefined') {
        domain = process.env.DEVELOPMENT_DOMAIN;
    }

    browserSync.init({
        proxy: domain,
        open: false,
        files: [
            './**/*.php',
            path.dirname(cssDest) + '/**/*.css',
            path.dirname(jsDest) + '/**/*.js'
        ]
    });

    watch();
}

const build = gulp.parallel(cssTask, jsTask);

// Public
exports.default = build;
exports.serve = serve;
exports.watch = watch;

exports.css = cssTask;
exports.js = jsTask;
