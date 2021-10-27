const gulp = require('gulp');
const gulpSass = require('gulp-sass');
const nodeSass = require('node-sass');
const uglify = require('gulp-uglify-es').default;
const minify = require('gulp-minify');
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
    '../src/Resources/public/js/*',
  ], {
    force: true,
  });
});

gulp.task('script', () => {
  return gulp.src('js/**/*.js')
    .pipe(gulp.dest('../src/Resources/public/js/'));
});

gulp.task('minify-script', () => {
  return gulp.src('js/**/*.js')
    .pipe(uglify())
    .pipe(minify({
      ext:{
        min:'.min.js'
      },
      noSource: true,
    }))
    .pipe(gulp.dest('../src/Resources/public/js/'));
});

gulp.task('default', gulp.series(['clean', 'styles', 'minify-css', 'script', 'minify-script']));

gulp.task('watch', () => {
  gulp.watch('sass/**/*.scss', (done) => {
    gulp.series(['clean', 'styles', 'minify-css'])(done);
  });

  gulp.watch('js/**/*.js', (done) => {
    gulp.series(['script'])(done);
  });
});
