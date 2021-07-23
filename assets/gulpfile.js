const gulp = require('gulp');
const gulpSass = require('gulp-sass');
const nodeSass = require('node-sass');
const del = require('del');
const cleanCSS = require('gulp-clean-css');
const rename = require('gulp-rename');

const sass = gulpSass(nodeSass);

gulp.task('styles', () => {
  return gulp.src('sass/**/*.scss')
      .pipe(sass().on('error', sass.logError))
      .pipe(gulp.dest('../src/Resources/public/css/'));
});

gulp.task('minify-css', () => {
  return gulp.src('../src/Resources/public/css/*.css')
      .pipe(cleanCSS({compatibility: 'ie8'}))
      .pipe(rename({
        suffix: '.min',
      }))
      .pipe(gulp.dest('../src/Resources/public/css/'));
});

gulp.task('clean', () => {
  return del([
    '../src/Resources/public/css/main.css',
    '../src/Resources/public/css/main.min.css',
  ], {
    force: true,
  });
});

gulp.task('default', gulp.series(['clean', 'styles', 'minify-css']));

gulp.task('watch', () => {
  gulp.watch('sass/**/*.scss', (done) => {
    gulp.series(['clean', 'styles'])(done);
  });
});
