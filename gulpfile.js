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
// npm install gulp.spritesmith --save-dev
var spritesmith = require('gulp.spritesmith');


// ファイル結合
gulp.task('concat', function() {
  return gulp.src(['./js/lightning-adv-common.js','./inc/navigation/js/navigation.js','./inc/sidebar-fix/js/sidebar-fix.js'])
    .pipe(concat('lightning-adv.js'))
    .pipe(gulp.dest('./js/'));
});

// js最小化
gulp.task('jsmin', function () {
  gulp.src(['./js/lightning-adv.js'])
  .pipe(plumber()) // エラーでも監視を続行
  .pipe(jsmin())
  .pipe(rename({suffix: '.min'}))
  .pipe(gulp.dest('./js'));
});


// copy
// gulp.task( 'copy', function() {
//     gulp.src( './inc/navigation/js/navigation.js'  )
//     .pipe(rename({prefix: "_",extname: ".scss"})) // 拡張子をscssに
//     .pipe( gulp.dest( './design_skin/origin/_scss/' ) ); // _scss ディレクトリに保存
//     gulp.src( './library/bootstrap/fonts/**'  )
//     .pipe( gulp.dest( './design_skin/origin/fonts/' ) ); // _scss ディレクトリに保存
// } );


// Watch
gulp.task('watch', function() {
		gulp.watch('./js/lightning-adv-common.js', ['concat']);
    gulp.watch('./inc/navigation/js/navigation.js', ['concat']);
		gulp.watch('./inc/sidebar-fix/js/sidebar-fix.js', ['concat']);
		gulp.watch('./js/lightning-adv.js', ['jsmin']);
});

// gulp.task('default', ['scripts','watch','sprite']);
gulp.task('default', ['watch']);
