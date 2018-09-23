'use strict';

var path = {
    entry: 'src/app/index.js',
    build: { //Тут мы укажем куда складывать готовые после сборки файлы
        js: '../assets/js/',
        css: '../assets/css/',
    },
    src: { //Пути откуда брать исходники
        js: 'js/*.js',
        jsLibsInit: 'bower_components/vendor.js',
        cssLibsInit: 'bower_components/vendor.css',
        style: 'css/*.sass',
    },
    watch: {
        html: '*.html',
        js: 'js/*.js',
        jsLibsDir: 'js/libs/',
        style: 'css/*.sass',
        styleLibsDir: 'css/libs/',
    },
    clean: '../src/'
};

var gulp = require('gulp'), //сам гулп
    watch = require('gulp-watch'),
    uglify = require('gulp-uglify'), //для минификации скриптов
    sass = require('gulp-sass'), //компилятор sass
    cssmin = require('gulp-clean-css'), //минификатор css
    imagemin = require('gulp-imagemin'), //оптимизатор картнок
    rigger = require('gulp-rigger'), //всткавка включашек в любый файлы
    bower = require('gulp-bower'), //менеджер подключаемых библиотек
    concat = require('gulp-concat'), //конкатинация файлов
    filter = require('gulp-filter'),
    prefixer = require('gulp-autoprefixer'), //автоматически добавляет вендрные префиксы
    sourcemaps = require('gulp-sourcemaps'),
    spritesmith = require('gulp.spritesmith'),
    rimraf = require('gulp-rimraf'),
    pug = require('gulp-pug'), // компилятор шаблонов jade/pug
    plumber = require('gulp-plumber'),
    gulpif = require('gulp-if'),
    normalize = require('normalize-path'),
    connect = require("gulp-connect");

/* JS: берет все моудли из bower.json объединяет в один файл vendor.js скрипты, кладет их в паку дистрибутива
 CSS: берет все файлы, кладет их в _vendor.scss в папке приложения. Потом этот файл будет включаться другим таском в итоговый
 */

// Server
gulp.task('connect', function () {
    return connect.server({
        port: 1378,
        livereload: true,
        root: '../src/'
    });
});

gulp.task('bower', function () {
    gulp.src(path.src.cssLibsInit)
        .pipe(rigger())
        .pipe(concat('_vendor.css'))
        .pipe(cssmin())
        .pipe(gulp.dest(path.build.css));
    return gulp.src(path.src.jsLibsInit)
        .pipe(rigger())
        .pipe(concat('_vendor.js'))
        .pipe(uglify())
        //.pipe(gulp.dest(path.src.jsLibsDir))
        .pipe(gulp.dest(path.build.js));
});

//таска, которая собирает нам наши скрипты
gulp.task('js', function () {
    return gulp.src(path.src.js) //Найдем наш main файл
        .pipe(rigger()) //Прогоним через rigger
        .pipe(concat('_main.js'))
        //.pipe(sourcemaps.init()) //Инициализируем sourcemap
        .pipe(uglify()) //Сожмем наш js
        //.pipe(sourcemaps.write()) //Пропишем карты
        // .pipe(sourcemaps.write('.', {includeContent: false})) //Пропишем карты
        .pipe(gulp.dest(path.build.js)) //Выплюнем готовый файл в build
        .pipe(connect.reload());

});


//таска, которая собирает нам все наши стили
gulp.task('styles', function () {
    return gulp.src(path.src.style) //Выберем наш main.scss
        .pipe(plumber()) // предотвращаем вылет гальпа при ошибке
        .pipe(sass()) //Скомпилируем
        .pipe(prefixer()) //Добавим вендорные префиксы
        .pipe(cssmin()) //Сожмем
        .pipe(concat('_style.css'))
        .pipe(gulp.dest(path.build.css)) //И в build
        .pipe(connect.reload());

});

//очищает папку с билдом
gulp.task('clean', function () {
    var del = require('del');
    return del([path.clean]);
});

//собственно, вотчер
gulp.task('watch', function () {
    global.watch = true;
    gulp.watch(path.watch.style, gulp.series('styles'));
    gulp.watch(path.watch.js, gulp.series('js'));
});

//Сборщик
gulp.task('build',
    gulp.series(gulp.parallel('bower'), gulp.parallel('js', 'styles'))
);

gulp.task('default', gulp.series('build', gulp.parallel('watch')));
