const gulp = require('gulp');
const gulpSass = require('gulp-sass');
const nodeSass = require('node-sass');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify-es').default;
const del = require('del');
const cleanCSS = require('gulp-clean-css');
const rename = require('gulp-rename');

const sass = gulpSass(nodeSass);

gulp.task('styles', () => {
  return gulp.src('sass/**/main.scss')
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
    '../src/Resources/public/css/*',
  ], {
    force: true,
  });
});

gulp.task('script', () => {
  return gulp.src('js/**/*.js')
    .pipe(concat('main.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('../src/Resources/public/js/'));
});

gulp.task('default', gulp.series(['clean', 'styles', 'minify-css', 'script']));

gulp.task('watch', () => {
  gulp.watch('sass/**/*.scss', (done) => {
    gulp.series(['clean', 'styles', 'minify-css'])(done);
  });

  gulp.watch('js/**/*.js', (done) => {
    gulp.series(['script'])(done);
  });
});
