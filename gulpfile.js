var gulp = require('gulp');

var cssmin = require('gulp-cssmin');
// ファイルリネーム（.min作成用）
var rename = require('gulp-rename');
// ファイル結合
var concat = require('gulp-concat');
// js最小化
var jsmin = require('gulp-jsmin');
// エラーでも監視を続行させる
var plumber = require('gulp-plumber');
// sudo npm install gulp.spritesmith --save-dev
var spritesmith = require('gulp.spritesmith');
// http://blog.e-riverstyle.com/2014/02/gulpspritesmithcss-spritegulp.html

// // Task
// gulp.task('cssmin', function () {
//   gulp.src('css/**/*.css')
//   .pipe(plumber()) // エラーでも監視を続行
//   .pipe(cssmin())
//   .pipe(rename({suffix: '.min'}))
//   .pipe(gulp.dest('css'));
// });

// gulp.task( 'copy', function() {
//     // bootstrapのcssをscssディレクトリに複製
//     gulp.src( './bootstrap/css/bootstrap.min.css'  )
//     .pipe(rename({prefix: "_",extname: ".scss"})) // 拡張子をscssに
//     .pipe( gulp.dest( './_scss/' ) ); // _scss ディレクトリに保存
// } );

// ファイル結合
// gulp.task('scripts', function() {
//   return gulp.src(['./js/jquery.flatheights.js','./js/master.js'])
//     .pipe(concat('all.js'))
//     .pipe(gulp.dest('./js/'));
// });

// js最小化
gulp.task('jsmin', function () {
  gulp.src(['./inc/navigation/js/navigation.js'])
  .pipe(plumber()) // エラーでも監視を続行
  .pipe(jsmin())
  .pipe(rename({suffix: '.min'}))
  .pipe(gulp.dest('./inc/navigation/js'));
});

// Watch
gulp.task('watch', function() {
    // gulp.watch('css/*.css', ['cssmin'])
    // gulp.watch('js/*.js', ['scripts']);
    // gulp.watch('_scss/style.scss', ['copy']);
    gulp.watch('./inc/navigation/js/navigation.js', ['jsmin']);
});

// gulp.task('default', ['scripts','watch','sprite']);
gulp.task('default', ['watch']);