var gulp = require('gulp');
var sass = require('gulp-sass');


gulp.task('sass', function(done) {
    gulp.src("frontend/web/scss/style.scss")
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(gulp.dest("frontend/web/css"))
    done();
});
gulp.task('serve', function(done) {
    gulp.watch("frontend/web/scss/**/*.scss", gulp.series('sass'));
    done();
});

gulp.task('default', gulp.series('serve'));
