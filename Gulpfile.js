var gulp = require('gulp');
var phpspec = require('gulp-phpspec');
var run = require('gulp-run');
var notify = require('gulp-notify');

gulp.task('test', function() {
  gulp.src('spec/**/*.php')
    .pipe(run('clear'))
    .pipe(phpspec('', { notify: true }))
    .on('error', notify.onError({
      title: 'Red!',
      message: 'Your tests failed...'
    }))
    .pipe(notify(
      {
        title: 'Green!',
        message: 'Your tests succeeded!'
      }
    ));
});

gulp.task('watch', function() {
  gulp.watch(['spec/**/*.php'], ['test']);
});

gulp.task('default', ['test', 'watch']);