var gulp = require('gulp');
var browserify = require('gulp-browserify');
var concat = require('gulp-concat');
var sass = require('gulp-sass');

gulp.task('sass', function () {
    gulp.src('./frontend/scss/application.scss')
        .pipe(sass())
        .on('error', function(err){ console.log(err.message); })
        .pipe(concat('main.css'))
        .pipe(gulp.dest('./web/dist/css'));
});

gulp.task('browserify', function () {
    gulp.src('./frontend/js/main.js')
        .pipe(browserify({transform: 'reactify'}))
        .on('error', function(err){ console.log(err.message); })
        .pipe(concat('main.js'))
        .pipe(gulp.dest('web/dist/js'));
});

gulp.task('default', ['sass', 'browserify']);

gulp.task('watch', function () {
    gulp.watch('./frontend/**/*.*', ['default'])
        .on('error', function(err){ console.log(err.message); });
})
