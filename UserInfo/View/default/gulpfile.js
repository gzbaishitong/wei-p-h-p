var gulp = require('gulp');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var minifyCSS = require('gulp-minify-css');
var spriter = require('gulp-css-spriter');
var sass = require('gulp-sass'); //编译sass文件

gulp.task('compress', function () {
        gulp.src('Public/js/Components/*.js').pipe(uglify()).pipe(gulp.dest('Public/js/Components/dist'))  
});

gulp.task('css', function() {

    var timestamp = +new Date();
    //需要自动合并雪碧图的样式文件
    return gulp.src('Public/style/common/index.css')
        /*.pipe(spriter({
            // 生成的spriter的位置
            'spriteSheet': 'Public/style/img/sprite'+timestamp+'.png',
            // 生成样式文件图片引用地址的路径
            // 如下将生产：backgound:url(../images/sprite20324232.png)
            'pathToSpriteSheetFromCSS': '../img/sprite'+timestamp+'.png'
        }))*/
		.pipe(rename('index.min.css'))
        .pipe(minifyCSS())
        //产出路径
        .pipe(gulp.dest('Public/style/common'));
});

gulp.task('sass', function () {
  return gulp.src('Public/sass/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('Public/sass/css'));
});

gulp.task('sassmin',function(){
	return gulp.src('Public/sass/css/signup.css').pipe(rename('signup.min.css')).pipe(minifyCSS()).pipe(gulp.dest("Public/sass/css"))
})
 
gulp.task('sass:watch', function () {
  gulp.watch('Public/sass/*.scss', ['sass','sassmin']);
});

