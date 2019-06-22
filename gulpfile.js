var gulp = require('gulp');
var sass = require('gulp-ruby-sass');
var sourcemaps = require('gulp-sourcemaps');
var prefix = require('gulp-autoprefixer');

gulp.task('default', function () {
	sass('scss/main.scss', {sourcemap: true, style: 'compact'})
		.pipe(prefix("last 1 version", "> 1%", "ie 8", "ie 7"))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('css'));
});

gulp.task('watch', function() {
	gulp.watch('scss/*.scss', ['default']);
});