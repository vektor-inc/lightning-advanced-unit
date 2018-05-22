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
// 同期的に処理してくれる（ distで使用している ）
var runSequence = require('run-sequence');

// ファイル結合
gulp.task('concat', function() {
	// return gulp.src(['./js/lightning-adv-common.js','./inc/navigation/js/navigation.js','./inc/sidebar-fix/js/sidebar-fix.js'])
	return gulp.src(['./js/lightning-adv-common.js', './inc/sidebar-fix/js/sidebar-fix.js'])
		.pipe(concat('lightning-adv.js'))
		.pipe(gulp.dest('./js/'));
});

gulp.task('copy_full-wide-title', function() {
  gulp.src('inc/widgets/widget-full-wide-title.php')
    .pipe(gulp.dest('../../vektor-wp-libraries/vk-widget-full-wide-title/package/'));
});
gulp.task('copy_new-posts', function() {
  gulp.src('inc/widgets/widget-new-posts.php')
    .pipe(gulp.dest('../../vektor-wp-libraries/vk-widget-new-posts/package/'));
});

// js最小化
gulp.task('jsmin', function() {
	gulp.src(['./js/lightning-adv.js'])
		.pipe(plumber()) // エラーでも監視を続行
		.pipe(jsmin())
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(gulp.dest('./js'));
	gulp.src(['./inc/navigation/js/navigation.js'])
		.pipe(plumber()) // エラーでも監視を続行
		.pipe(jsmin())
		.pipe(rename({
			suffix: '.min'
		}))
		.pipe(gulp.dest('./inc/navigation/js/'));
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
	gulp.watch('./inc/sidebar-fix/js/sidebar-fix.js', ['concat']);
	gulp.watch('./js/lightning-adv.js', ['jsmin']);
	gulp.watch('./inc/navigation/js/navigation.js', ['jsmin']);
	gulp.watch('./inc/widgets/widget-full-wide-title.php', ['copy_full-wide-title'])
	gulp.watch('./inc/widgets/widget-new-posts.php', ['copy_new-posts']);
});


// Watch
gulp.task('watch_full-title', function() {
	gulp.watch('./inc/widgets/widget-full-wide-title.php', ['copy_full-wide-title']);
});
gulp.task('watch_new-post', function() {
	gulp.watch('./inc/widgets/widget-new-posts.php', ['copy_new-posts']);
});

// gulp.task('default', ['scripts','watch','sprite']);
gulp.task('default', ['watch']);

// copy dist ////////////////////////////////////////////////

gulp.task('copy_dist', function() {
    return gulp.src(
            [
							'./**/*.php',
							'./**/*.txt',
							'./**/*.css',
							'./**/*.scss',
							'./**/*.bat',
							'./**/*.rb',
							'./**/*.eot',
							'./**/*.svg',
							'./**/*.ttf',
							'./**/*.woff',
							'./**/*.woff2',
							'./**/*.otf',
							'./**/*.less',
							'./**/*.png',
							'./inc/**',
							'./js/**',
							'./languages/**',
							"!./compile.bat",
							"!./config.rb",
							"!./tests/**",
							"!./dist/**",
							"!./.sftp-config.json",
							"!./.ftpconfig.json",
							"!./node_modules/**"
            ],
            { base: './' }
        )
        .pipe( gulp.dest( 'dist' ) ); // distディレクトリに出力
} );
// gulp.task('build:dist',function(){
//     /* ここで、CSS とか JS をコンパイルする */
// });

gulp.task('dist', function(cb){
    // return runSequence( 'build:dist', 'copy_dist', cb );
    return runSequence( 'copy_dist', cb );
});
