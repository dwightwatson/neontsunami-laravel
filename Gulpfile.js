var gulp = require('gulp'),
  rimraf = require('gulp-rimraf'),
  include = require('gulp-include'),

  less = require('gulp-less'),
  minifyCss = require('gulp-minify-css'),

  coffee = require('gulp-coffee'),
  uglify = require('gulp-uglify'),

  imagemin = require('gulp-imagemin');

var paths = {
  stylesheet: 'app/assets/stylesheets/application.less',
  javascript: 'app/assets/javascripts/application.js',

  stylesheets: ['app/assets/stylesheets/**/*.css', 'app/assets/stylesheets/**/*.less'],
  javascripts: ['app/assets/javascripts/**/*.js'],
  public: 'public/assets',
  images: 'app/assets/images/**/*',
  fonts: 'app/assets/fonts/**/*'
};

gulp.task('clear', function() {
  return gulp.src('public/assets/**/*', { read: false })
    .pipe(rimraf());
});

gulp.task('stylesheets', function() {
  return gulp.src(paths.stylesheet)
    .pipe(include())
    .pipe(less())
    .pipe(minifyCss())
    .pipe(gulp.dest(paths.public));
});

gulp.task('javascripts', function() {
  return gulp.src(paths.javascript)
    .pipe(include())
    // .pipe(coffee())
    // .pipe(uglify())
    .pipe(gulp.dest(paths.public));
});

gulp.task('images', function() {
  return gulp.src(paths.images)
    .pipe(imagemin({optimizationLevel: 5}))
    .pipe(gulp.dest(paths.public));
});

gulp.task('fonts', function() {
  return gulp.src(paths.fonts)
    .pipe(gulp.dest(paths.public));
});

gulp.task('watch', function() {
  gulp.watch(paths.stylesheets, ['stylesheets']);
  gulp.watch(paths.javascripts, ['javascripts']);
});

gulp.task('default', ['clear', 'stylesheets', 'javascripts', 'images', 'fonts']);