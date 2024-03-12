const gulp = require('gulp');
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');
const browserSync = require('browser-sync');
const babel = require("gulp-babel");
const uglify = require('gulp-uglify');
const plumber = require('gulp-plumber');
const postcss = require('gulp-postcss');


function sync(cb) {
  browserSync.init({
    proxy: "localhost:8888/longwave",
    notify: false,
    open: false,
  });

  gulp.watch(['sass/**/*.scss', 'tailwind.config.js'], style);
  gulp.watch(['**/*.html', '**/*.php'], gulp.series(reload, style));
  gulp.watch('src/**/*.js', gulp.series(reload, js));

  browserSync.watch(['**/language/*.php', '**/cms/**', 'views/**']).on('change', browserSync.reload);

  cb()
}


function reload(cb) {
  browserSync.reload();
  cb();
}


function js(cb) {
  return gulp.src('src/*.js')
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(babel())
    .pipe(uglify())
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('dist'))
    .pipe(browserSync.reload({stream:true}));

  cb()
}


function style(cb) {
  return gulp.src('sass/*.scss')
    // .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss())
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('stylesheets'))
    .pipe(browserSync.reload({stream:true}));

  cb()
}


exports.js = js
exports.style = style

exports.default = gulp.series(style, js, sync);