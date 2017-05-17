var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var inject = require("gulp-inject");
var ngHtml2Js = require("gulp-ng-html2js");

var buildDesc = 'public';
var jsDest  = buildDesc + '/js/';
var cssDest = buildDesc + '/css/';

gulp.task('create-templates', function() {
    return gulp
        .src('frontend/**/*.html')
        .pipe(ngHtml2Js({
            moduleName: "app.templates",
            rename: function(url) {
                return url.replace('frontend/', '');
            }
        }))
        .pipe(concat("app.templates.js"))
        .pipe(gulp.dest("frontend/"));
});

//gulp.task('inject-templates', ['create-templates'], function() {
//    return gulp
//        .src('./frontend/index.html')
//        .pipe(inject(
//            gulp.src('./frontend/app.templates.js',
//            {read: false}),
//            {
//                ignorePath: 'frontend',
//                addRootSlash: false
//            }
//        ))
//        .pipe(gulp.dest('frontend/'));
//});

//gulp.task('html', function() {
//    gulp
//        .src([
//            'src/index.html'
//        ])
//        .pipe(gulp.dest(buildDesc));
//});

gulp.task('js', function() {
    gulp
        .src([
            'bower_components/angular/angular.min.js',
            'bower_components/angular-route/angular-route.min.js',
            'frontend/app.js',
            'frontend/app.routes.js',
            'frontend/app.constants.js',
            'frontend/app.templates.js',
            'frontend/app/home/home.controller.js',
            'frontend/app/feed/feed_list.controller.js',
            'frontend/app/feed/feed_source_list.controller.js',
            'frontend/app/feed/feed_source_edit.controller.js',
            'frontend/app/feed/services/feed.service.js',
            'frontend/app/feed/services/feed-source.service.js',
            'frontend/app/login/login.controller.js',
            'frontend/app/signup/signup.controller.js',
            'frontend/app/feed/feed_source_view.controller.js',
            'frontend/app/feed/base.controller.js',
        ])
        .pipe(concat('all.js'))
        .pipe(uglify())
        .pipe(gulp.dest(jsDest));
});

gulp.task('css', function() {
    gulp
        .src([
            'bower_components/slick-carousel/slick/slick.css',
            'bower_components/font-awesome/css/font-awesome.min.css',
            'bower_components/bootstrap/dist/css/bootstrap.min.css',
            'node_modules/viewerjs/dist/viewer.min.css',
            cssDest + 'app.css'
        ])
        .pipe(concat('all.css'))
        .pipe(gulp.dest(cssDest));
});

gulp.task('build', ['create-templates', 'js', 'css']);
