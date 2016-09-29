<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta http-equiv="Cache-Control" content="no-transform">
<title>见“1”答题赢大奖</title>

<style>
*{margin:0;padding:0;}
html,body{height:100%; overflow:hidden;}
#bg{position:relative;top:-100%;width:100%;height:100%;}

#begin,#bg-img,#rules,#rulesContent,#personal{position:absolute;font-size:0;}
#rules{width:70px; height:70px; left:50%; margin-left:-155px} 
#rulesContent{display:none;}

#begin{
	left:50%;
	width:170px;
	height:72px;
	margin-left:-85px;
}

#personal{width:70px; height:70px; left:50%; margin-left:85px;}
<!--loading-->
#loading {
  margin: 50px auto 0;
  width: 150px;
  height: 218px;
  z-index:100001;
}

#spinner {
  margin: 100px auto 0;
  width: 150px;
  text-align: center;
  z-index:100001;
  height:100%;
}
 
#spinner > div {
  width: 30px;
  height: 30px;
  background-color: #FFAD40;
  z-index:100001;
 
  border-radius: 100%;
  display: inline-block;
  -webkit-animation: bouncedelay 1.4s infinite ease-in-out;
  animation: bouncedelay 1.4s infinite ease-in-out;
  /* Prevent first frame from flickering when animation starts */
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
}
 
#spinner #bounce1 {
  -webkit-animation-delay: -0.32s;
  animation-delay: -0.32s;
  z-index:100001;
}
 
#spinner #bounce2 {
  -webkit-animation-delay: -0.16s;
  animation-delay: -0.16s;
  z-index:100001;
}
 
@-webkit-keyframes bouncedelay {
  0%, 80%, 100% { -webkit-transform: scale(0.0) }
  40% { -webkit-transform: scale(1.0) }
}
 
@keyframes bouncedelay {
  0%, 80%, 100% {
    transform: scale(0.0);
    -webkit-transform: scale(0.0);
  } 40% {
    transform: scale(1.0);
    -webkit-transform: scale(1.0);
  }
}

<!--查询奖品-->
#form-box {
	width:100%;
	height:100%;
	display:none;
}

form {text-align:center;}

.nameInput {width:70px; height:35px; left:19%; top:46%; position:absolute;}
.phoneInput {width:70px; height:35px; left:20%; top:50%; position:absolute;}

#submit {background-color:transparent; border:none; outline:none; display:block; clear:both; width:21%;height:15%;left:39%;top:83%;position:absolute;background:url('http://7xkg1m.com2.z0.glb.qiniucdn.com/submitBtn.png') no-repeat center;background-size:93% 73%;}

#name {display:block; width:60%;height:6%; left:20%; top:53%; position:absolute; border:2px solid #7b1d51; border-radius:5px; background-color:#fff;}
#phone {display:block; width:60%;height:6%; left:20%; top:58%; position:absolute; border:2px solid #7b1d51; border-radius:5px; background-color:#fff;}


#continue {display:inline-block; height:50px; width:90px; float:left; margin:20px auto auto 40px; border:3px solid #fff; border-radius:50px; background-color:transparent; color:#A48E4E;}
#again {display:inline-block; height:50px; width:90px; float:right; margin:20px 40px auto auto; border:3px solid #fff; border-radius:50px; background-color:transparent; color:#A48E4E;}

:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
    color: #fff;
	text-align:left;
}

::-moz-placeholder { /* Mozilla Firefox 19+ */
    color: #fff;
	text-align:left;
}

input:-ms-input-placeholder,
textarea:-ms-input-placeholder {
    color: #fff;
	text-align:left;
}

input::-webkit-input-placeholder,
textarea::-webkit-input-placeholder {
    color: #fff;
	text-align:left;
}

body{height:100%;font-size:0;}
		.container{position:relative;}
		#lihong{position:absolute;bottom:0;left:0;width:100%;height:50%}
		#lihong2{position:absolute;bottom:0;left:0;width:100%;height:50%;opacity:0}
		#lihong3{position:absolute;bottom:0;left:0;width:100%;height:50%;opacity:0}
		#lihong{-webkit-animation:lihong 0.7s ease-in-out}
		#lihong2{-webkit-animation:lihong2 9s linear forwards;-webkit-animation-delay:0.7s;z-index:1000}
		#lihong3{-webkit-animation:lihong3 9s linear forwards;-webkit-animation-delay:0.7s;z-index:1000}
		#zuijin{position:absolute;top:0;left:0;width:100%;opacity:0}
		#shenme{position:absolute;top:10%;left:0;width:100%;opacity:0}
		#zuihuo{position:absolute;top:25%;left:0;width:100%;opacity:0}
		#danranshi{position:absolute;top:0;left:0;width:100%;opacity:0}
		#jianyiyoujiang{position:absolute;top:15%;left:0;width:100%;opacity:0;z-index:1000}
		#lihong4{position:absolute;bottom:0;left:0;width:100%;opacity:0}
		#light{position:absolute;bottom:10%;left:0;width:100%;opacity:0;z-index:100}
		#star{position:absolute;bottom:10%;left:0;width:100%;opacity:0;z-index:100}
		#zuijin{-webkit-animation:zuijin 3s ease-in-out forwards;-webkit-animation-delay:0.7s}
		#shenme{-webkit-animation:shenme 3s ease-in-out forwards;-webkit-animation-delay:1.4s}
		#zuihuo{-webkit-animation:shenme 3s ease-in-out forwards;-webkit-animation-delay:2.1s}
		#danranshi{-webkit-animation:danranshi 1s ease-in-out forwards;-webkit-animation-delay:5.9s}
		#jianyiyoujiang{-webkit-animation:jianyiyoujiang 2s ease-in-out forwards;-webkit-animation-delay:6.9s}
		#light{-webkit-animation:light 2s ease-in-out forwards;-webkit-animation-delay:3.9s}
		#star{-webkit-animation:star 0.7s ease-in-out forwards;-webkit-animation-delay:6.9s}
		#bg1{-webkit-animation:bg 9s linear forwards; z-index:10000;display:none}
		#bg{display:none}
		@-webkit-keyframes bg{
		0%{opacity:1;}
		99%{opacity:1;}
		100%{opacity:0;z-index:0}
		}
		@-webkit-keyframes lihong{
		0%{-webkit-transform:translateY(100%);}
		100%{-webkit-transform:translateY(0);}
		}
		@-webkit-keyframes lihong2{
		0%{opacity:1}
		20%{opacity:1}
		20.5%{opacity:0}
		40.5%{opacity:0}
		41%{opacity:1}61%{opacity:1}61.5%{opacity:0}81.5%{opacity:0}82%{opacity:1;webkit-tranform:translateY(100%)}99%{opacity:1}100%{opacity:0;-webkit-transform:traslateY(100%)}
		}
		@-webkit-keyframes lihong3{
		0%{opacity:0}
		20%{opacity:0}
		20.5%{opacity:1}
		40.5%{opacity:1}
		41%{opacity:0}61%{opacity:0}61.5%{opacity:1}81.5%{opacity:1}82.5%{opacity:0}100%{opacity:0}
		}
		@-webkit-keyframes zuijin{
		0%{-webkit-transform:translateX(-50%);}
		20%{-webkit-transform:translateX(0);opacity:1}
		80%{-webkit-transform:translateX(0);opacity:1}
		100%{-webkit-transform:translateX(-50%)}
		}
		@-webkit-keyframes shenme{
		0%{-webkit-transform:translateX(-50%);}
		20%{-webkit-transform:translateX(0);opacity:1}
		80%{-webkit-transform:translateX(0);opacity:1}
		100%{-webkit-transform:translateX(-50%)}
		}
		@-webkit-keyframes zuihuo{
		0%{-webkit-transform:translateX(-50%);}
		20%{-webkit-transform:translateX(0);opacity:1}
		80%{-webkit-transform:translateX(0);opacity:1}
		100%{-webkit-transform:translateX(-50%)}
		}
		@-webkit-keyframes danranshi{
		0%{-webkit-transform:translateX(-50%);}
		20%{-webkit-transform:translateX(0);opacity:1}
		80%{-webkit-transform:translateX(0);opacity:1}
		100%{-webkit-transform:translateX(-50%)}
		}
		@-webkit-keyframes jianyiyoujiang{
		0%{transform:scale(0);-webkit-transform:scale(0);}
		70%{transform:scale(1);opacity:1;-webkit-transform:scale(1);opacity:1;}
		75%{transform:rotateZ(30deg);opacity:1;-webkit-transform:rotateZ(30deg);opacity:1;}
		80%{transform:ratateZ(-30deg);opacity:1;-webkit-transform:ratateZ(-30deg);opacity:1;}
		85%{transform:ratateZ(30deg);opacity:1;-webkit-transform:ratateZ(30deg);opacity:1;}
		90%{transform:ratateZ(0);opacity:1;-webkit-transform:ratateZ(0);opacity:1;}
		95%{transform:ratateZ(0);opacity:1;-webkit-transform:ratateZ(0);opacity:1;}
		100%{transform:scale(1);opacity:1;-webkit-transform:scale(1);opacity:1;}
		}
		@-webkit-keyframes light{
		0%{-webkit-transform:scale(0);}
		80%{-webkit-transform:scale(1);opacity:1}
		100%{-webkit-transform:scale(0)}
		}

		@-webkit-keyframes star{
		/*0%{opacity:1;-webkit-transform:rotateZ(30deg)}
		90%{opacity:1;-webkit-transform:rotateZ(-30deg)}
		93%{opacity:1;-webkit-transform:rotateZ(30deg)}
		96%{opacity:1;-webkit-transform:rotateZ(-30deg)}
		98%{opacity:1;-webkit-transform:rotateZ(30deg)}
		100%{opacity:1;-webkit-transform:rotateZ(0)}*/
		
		0%{opacity:1;}
		16%{opacity:0;}
		32%{opacity:1;}
		48%{opacity:0;}
		64%{opacity:1;}
		80%{opacity:0;}
		100%{opacity:1;}
		}
		

		#huanqiu{position:absolute;top:0;left:0;width:100%;opacity:0;z-index:100}
		#huanqiu{-webkit-animation:huanqiu 1.5s ease-in-out forwards;-webkit-animation-delay:6.5s}
		@-webkit-keyframes huanqiu{
		0%{-webkit-transform:translateX(50%);}
		20%{-webkit-transform:translateX(0);opacity:1}
		80%{-webkit-transform:translateX(0);opacity:1}
		100%{-webkit-transform:translateX(50%)}
		}
		#maer{position:absolute;top:10%;left:0;width:100%;opacity:0;z-index:100}
		#maer{-webkit-animation:maer 1.5s ease-in-out forwards;-webkit-animation-delay:8s}
		@-webkit-keyframes maer{
		0%{-webkit-transform:translateX(50%);}
		20%{-webkit-transform:translateX(0);opacity:1}
		80%{-webkit-transform:translateX(0);opacity:1}
		100%{-webkit-transform:translateX(50%)}
		}
		#diandongche{position:absolute;bottom:0;left:0;width:100%;opacity:0;z-index:100}
		#diandongche{-webkit-animation:diandongche 1.5s ease-in-out forwards;-webkit-animation-delay:8.5s}
		@-webkit-keyframes diandongche{
		0%{-webkit-transform:translateX(-50%);}
		20%{-webkit-transform:translateX(0);opacity:1}
		80%{-webkit-transform:translateX(0);opacity:1}
		100%{-webkit-transform:translateX(-50%)}
		}
		#lihongfigure{position:absolute;bottom:0;left:0;width:100%;opacity:0;z-index:100}
		#lihongfigure{-webkit-animation:lihongfigure 2s ease-in-out forwards;-webkit-animation-delay:10s}
		@-webkit-keyframes lihongfigure{
		0%{-webkit-transform:translateX(50%);}
		10%{-webkit-transform:translateX(0);opacity:1}
		29.5%{opacity:1}
		30%{opacity:0}
		70%{opacity:0}
		71%{opacity:1}
		90%{-webkit-transform:translateX(0);opacity:1}
		100%{-webkit-transform:translateX(50%)}
		}
		#lihongfigure2{position:absolute;bottom:0;left:0;width:100%;opacity:0;z-index:100;opacity:0}
		#lihongfigure2{-webkit-animation:lihongfigure2 2s ease-in-out forwards;-webkit-animation-delay:10s}
		@-webkit-keyframes lihongfigure2{
		0%{opacity:0}
		29%{opcity:0}
		29.5%{opacity:1}
		30%{opacity:1}
		70%{opacity:1}
		71%{opacity:0}
		100%{opacity:0}
		}
		#yongyou{position:absolute;top:0;left:0;width:100%;opacity:0;z-index:100;opacity:0}
		#yongyou{-webkit-animation:yongyou 2s ease-in-out forwards;-webkit-animation-delay:10s}
		@-webkit-keyframes yongyou{
		0%{opacity:0}
		29%{opcity:0}
		29.5%{opacity:1}
		30%{opacity:1}
		70%{opacity:1}
		71%{opacity:0}
		100%{opacity:0}
		}
		#lihongstep4{position:absolute;bottom:0;left:0;width:100%;opacity:0;z-index:100;opacity:0}
		#lihongstep4{-webkit-animation:lihongstep4 2s ease-in-out forwards;-webkit-animation-delay:12s}
		@-webkit-keyframes lihongstep4{
		0%{-webkit-transform:translateX(50%);}
		10%{-webkit-transform:translateX(20%);opacity:1}
		90%{-webkit-transform:translateX(20%);opacity:1}
		100%{-webkit-transform:translateX(50%)}
		}
		#step4an{position:absolute;bottom:50%;left:0;width:100%;opacity:0;z-index:50;opacity:0}
		#step4an{-webkit-animation:step4an 2s ease-in-out forwards;-webkit-animation-delay:12s}
		@-webkit-keyframes step4an{
		0%{-webkit-transform:scale(0);}
		60%{-webkit-transform:scale(1);opacity:1}
		90%{-webkit-transform:scale(1);opacity:1}
		100%{-webkit-transform:scale(0);translateX(50%)}
		}
		#step4an2{position:absolute;top:0;left:0;width:100%;opacity:0;z-index:50;opacity:0}
		#step4an2{-webkit-animation:step4an2 1.5s ease-in-out forwards;-webkit-animation-delay:12.5s}
		@-webkit-keyframes step4an2{
		0%{-webkit-transform:scale(0);}
		60%{-webkit-transform:scale(1);opacity:1}
		90%{-webkit-transform:scale(1);opacity:1}
		100%{-webkit-transform:scale(0);translateX(50%)}
		}
		#lihongsmall{position:absolute;bottom:0;left:0;width:100%;opacity:0;z-index:100;opacity:0}
		#lihongsmall{-webkit-animation:lihongsmall 3s ease-in-out forwards;-webkit-animation-delay:14s}
		@-webkit-keyframes lihongsmall{
		0%{-webkit-transform:translateX(50%);}
		10%{-webkit-transform:translateX(0);opacity:1}
		90%{-webkit-transform:translateX(0);opacity:1}
		100%{-webkit-transform:translateX(50%)}
		}
		#step51{position:absolute;bottom:35%;left:0;width:100%;opacity:0;z-index:50;opacity:0}
		#step51{-webkit-animation:step51 3s ease-in-out forwards;-webkit-animation-delay:14s}
		@-webkit-keyframes step51{
		0%{-webkit-transform:scale(0);}
		60%{-webkit-transform:scale(1);opacity:1}
		90%{-webkit-transform:scale(1);opacity:1}
		100%{-webkit-transform:scale(0);translateX(50%)}
		}
		#step52{position:absolute;bottom:55%;left:0;width:100%;opacity:0;z-index:40;opacity:0}
		#step52{-webkit-animation:step51 2.5s ease-in-out forwards;-webkit-animation-delay:14.5s}
		@-webkit-keyframes step51{
		0%{-webkit-transform:scale(0);}
		60%{-webkit-transform:scale(1);opacity:1}
		90%{-webkit-transform:scale(1);opacity:1}
		100%{-webkit-transform:scale(0);translateX(50%)}
		}
		#step53{position:absolute;top:0;left:0;width:100%;opacity:0;z-index:40;opacity:0}
		#step53{-webkit-animation:step53 2s ease-in-out forwards;-webkit-animation-delay:15s}
		@-webkit-keyframes step53{
		0%{-webkit-transform:scale(0);}
		60%{-webkit-transform:scale(1);opacity:1}
		90%{-webkit-transform:scale(1);opacity:1}
		100%{-webkit-transform:scale(0);translateX(50%)}
		}
		#step6{position:absolute;bottom:0;left:0;width:100%;opacity:0;z-index:40;opacity:0}
		#step6{-webkit-animation:step6 2s ease-in-out forwards;-webkit-animation-delay:17s}
		@-webkit-keyframes step6{
		0%{-webkit-transform:translateX(50%)}
		20%{-webkit-transform:translateX(0);opacity:1}
		100%{-webkit-transform:translateX(0);opacity:1}
		}
		#step62{position:absolute;top:0;left:0;width:100%;opacity:0;z-index:20;opacity:0}
		#step62{-webkit-animation:step62 2s ease-in-out forwards;-webkit-animation-delay:17s}
		@-webkit-keyframes step62{
		0%{-webkit-transform:scale(0)}
		20%{-webkit-transform:scale(1);opacity:1}
		100%{-webkit-transform:scale(1);opacity:1}
		}
		#step63{position:absolute;top:0;left:0;width:100%;opacity:0;z-index:10;opacity:0}
		#step63{-webkit-animation:step63 2s ease-in-out forwards;-webkit-animation-delay:17s}
		@-webkit-keyframes step63{
		0%{-webkit-transform:scale(0)}
		20%{-webkit-transform:scale(1);opacity:1}
		100%{-webkit-transform:scale(1);opacity:1}
		}
</style>

<script>

function removecloud() {
    //document.getElementById('spinner').style.display = 'none';
    //document.getElementById('bgDiv').style.display = 'none';
	document.getElementById('bg').style.display='block';
}

</script>
<script type="text/javascript" src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/nongshang/quiz/jquery.min.js"></script>
</head>
<body>	
	<div id="spinner">
	  <div id="bounce1"></div>
	  <div id="bounce2"></div>
	  <div id="bounce3"></div>
	</div>
	<script>
$(document).ready(function(){
	//document.getElementById("music").play();  //背景音乐
	
	var callback = function(){
	document.getElementById('spinner').style.display ='none';
	document.getElementById('bg1').style.display = "block"
	setTimeout(function(){
		document.getElementById('bg').style.display = 'block';
	},6000)
}
var imgdefereds=["http://7xkg1m.com2.z0.glb.qiniucdn.com/light.png","http://7xkg1m.com2.z0.glb.qiniucdn.com/lihong.png","http://7xkg1m.com2.z0.glb.qiniucdn.com/lihong2.png","http://7xkg1m.com2.z0.glb.qiniucdn.com/lihong.png","http://7xkg1m.com2.z0.glb.qiniucdn.com/zuijin.png","http://7xkg1m.com2.z0.glb.qiniucdn.com/dangranshi.png","http://7xkg1m.com2.z0.glb.qiniucdn.com/jianyiyoujiang.png","http://7xkg1m.com2.z0.glb.qiniucdn.com/lihong3.png","http://7xkg1m.com2.z0.glb.qiniucdn.com/star.png"];
$('img').each(function(){
 var dfd=$.Deferred();
 $(this).bind('load',function(){
  dfd.resolve();
 }).bind('error',function(){
 //图片加载错误，加入错误处理
 // dfd.resolve();
 })
 if(this.complete) setTimeout(function(){
  dfd.resolve();
 },1000);
 imgdefereds.push(dfd);
})
$.when.apply(null,imgdefereds).done(function(){
    callback();
});
})
	</script>
	<div class="container" id ="bg1" style="background:url('http://7xkg1m.com2.z0.glb.qiniucdn.com/bg.jpg')">
		<!--<img src="http://7xkg1m.com2.z0.glb.qiniucdn.com/light.png" alt="" id='light'>-->
		<img src="http://7xkg1m.com2.z0.glb.qiniucdn.com/lihong.png" alt="" id='lihong'>
		<img src="http://7xkg1m.com2.z0.glb.qiniucdn.com/lihong2.png" alt="" id='lihong2'>
		<img src="http://7xkg1m.com2.z0.glb.qiniucdn.com/lihong.png" alt="" id='lihong3'>
		<img src="http://7xkg1m.com2.z0.glb.qiniucdn.com/zuijin.png" alt="" id='zuijin'>
		<img src="http://7xkg1m.com2.z0.glb.qiniucdn.com/shenme.png" alt="" id='shenme'>
		<img src="http://7xkg1m.com2.z0.glb.qiniucdn.com/zuihuo.png" alt="" id='zuihuo'>
		<img src="http://7xkg1m.com2.z0.glb.qiniucdn.com/dangranshi.png" alt="" id='danranshi'>
		<img src="http://7xkg1m.com2.z0.glb.qiniucdn.com/jianyiyoujiang.png" alt="" id='jianyiyoujiang'>
		<img src="http://7xkg1m.com2.z0.glb.qiniucdn.com/lihong3.png" alt="" id='lihong4'>
		<img src="http://7xkg1m.com2.z0.glb.qiniucdn.com/star.png" alt="" id='star'>
		<!--<img src="./img/huanqiu.png" id ='huanqiu'>
		<img src="./img/maer.png" alt="" id='maer'>
		<img src="./img/diandongche.png" alt="" id='diandongche'>
		<img src="./img/lihongfigure.png" alt="" id='lihongfigure'>
		<img src="./img/lihongfigure2.png" alt="" id='lihongfigure2'>
		<img src="./img/yongyou.png" alt="" id='yongyou'>
		<img src="./img/lihong.png" alt="" id='lihongstep4'>
		<img src="./img/step4an.png" alt="" id='step4an'>
		<img src="./img/step4an2.png" alt="" id='step4an2'>
		<img src="./img/lihongsmall.png" alt="" id='lihongsmall'>
		<img src="./img/step51.png" alt="" id='step51'>
		<img src="./img/step52.png" alt="" id='step52'>
		<img src="./img/step53.png" alt="" id='step53'>
		<img src="./img/lihongfigure2.png" alt="" id='step6'>
		<img src="./img/step62.png" alt="" id='step62'>
		<img src="./img/light.png" alt="" id='step63'>-->
		
		<!--<audio src="begin.mp3" loop="loop" id="music"></audio>-->
	</div>
	<script>
		removecloud()
	</script>
	<div id="bg">
		<div id="bg-img">
			<img  id="bg-img-1" src="http://7xkg1m.com2.z0.glb.qiniucdn.com/index-1-bg.jpg" alt="" width="100%" height="100%">
		</div>
		
		<!--游戏规则-->
		<div id="rules">
		<img src="http://7xkg1m.com2.z0.glb.qiniucdn.com/rulesBtn.png" width="100%" height="100%" alt="">
		</div>
		<div id="rulesContent">
			<img src="http://7xkg1m.com2.z0.glb.qiniucdn.com/rules.png" width="100%" height="100%" alt"">
		</div>
		
		<!--开始答题-->
		<div id="begin">
			<img src="http://7xkg1m.com2.z0.glb.qiniucdn.com/begin-button.png" width="100%" height="100%" alt="">
		</div>
		
		<!--我的奖品-->
		<div id="personal">
			<img src="http://7xkg1m.com2.z0.glb.qiniucdn.com/personalBtn.png" width="100%" height="100%" alt="">
		</div>
	</div>
	
	<div id="submitBg" style="width: 100%; height: 100%; position: absolute; top:0; z-index:10000; overflow-x: hidden; background: url('http://7xkg1m.com2.z0.glb.qiniucdn.com/checkBg.jpg') no-repeat center; background-size: 100% 100%; display:none;">
		<div id="form-box">
			<form method="POST" onsubmit="return false;">
				<div class="phoneInput">
					<img src="http://7xkg1m.com2.z0.glb.qiniucdn.com/input2.png" width="100%"/>
				</div>
				<input type="text" id="phone" />
				
				<div id="submit" value=""></div>
			</form>
		</div>
	</div>

<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan style='display:none;' id='cnzz_stat_icon_1255852946'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/z_stat.php%3Fid%3D1255852946' type='text/javascript'%3E%3C/script%3E"));</script>
</body>

<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
/*window.setTimeout(function(){
	document.getElementById("music").play();
},3000);*/

function wxshare(){
	wx.config({
		debug: false,
		appId: '',
		timestamp: '',
		nonceStr: '',
		signature: '',
		jsApiList: [
			// 所有要调用的 API 都要加到这个列表中
			'checkJsApi',
			'openLocation',
			'getLocation',
			'onMenuShareTimeline',
			'onMenuShareAppMessage'
		  ]
	});

	wx.ready(function () {
		wx.checkJsApi({
			jsApiList: [
				'getLocation',
				'onMenuShareTimeline',
				'onMenuShareAppMessage'
			],
			success: function (res) {
				//alert(JSON.stringify(res));
			}
		});

		wx.onMenuShareAppMessage({
		  title: '【太阳信用卡】见一有奖,等你来挑战',
		  desc: '【游戏】广州农商银行',
		  link: 'http://baozou.gzbaishitong.com/game/source/nongshangnew/index.php',
		  imgUrl: 'http://7xkg1m.com2.z0.glb.qiniucdn.com/shareTo.jpg',
		  trigger: function (res) {
		  },
		  success: function (res) {
		  },
		  cancel: function (res) {
		  },
		  fail: function (res) {
		  }
		});

		wx.onMenuShareTimeline({
		  title: '【太阳信用卡】见一有奖,等你来挑战',
		  desc: '【游戏】广州农商银行',
		  link: 'http://baozou.gzbaishitong.com/game/source/nongshangnew/index.php',
		  imgUrl: 'http://7xkg1m.com2.z0.glb.qiniucdn.com/shareTo.jpg',
		  trigger: function (res) {
		  },
		  success: function (res) {
		  },
		  cancel: function (res) {
		  },
		  fail: function (res) {
		  }
		});

	});
}
wxshare();

function sAlert(str){
	var msgw,msgh,bordercolor;
	msgw=400;//提示窗口的宽度
	msgh=200;//提示窗口的高度
	titleheight=25 //提示窗口标题高度
	bordercolor="#c51100";//提示窗口的边框颜色
	titlecolor="#c51100";//提示窗口的标题颜色

	var sWidth,sHeight;
	sWidth=screen.width;
	sHeight=screen.height;


	var msgObj=document.createElement("div");
	msgObj.setAttribute("id","msgDiv");
	msgObj.style.position = "absolute";
	msgObj.style.width = "80%";
	msgObj.style.left = "10%";
	msgObj.style.top = "25%";


	var img = document.createElement('img');
	img.setAttribute('src', 'http://7xkg1m.com2.z0.glb.qiniucdn.com/popUp.png');
	img.style.position = "absolute";
	img.style.width = "100%";
	img.style.top=0;
	img.style.left=0;
	img.style.zIndex = "1000000";

	/*var img2 = document.createElement('img');
	img2.setAttribute('src','http://7xkg1m.com2.z0.glb.qiniucdn.com/comfirm.png');
	img2.style.width = "100%";*/

	var title = document.createElement('div');
	title.style.position = "absolute";
	title.style.width = "45%";
	title.style.zIndex = "1000000";
	title.style.top = "100%";
	title.style.left = "27%";
	title.style.marginTop = 150+'px';

	// var title=document.createElement("h4");
	// title.setAttribute("id","msgTitle");
	// title.setAttribute("align","right");
	// title.style.margin="0";
	// title.style.padding="3px";
	// title.style.background=bordercolor;
	// title.style.filter="progid:DXImageTransform.Microsoft.Alpha(startX=20, startY=20, finishX=100, finishY=100,style=1,opacity=75,finishOpacity=100);";
	// title.style.opacity="0.75";
	// title.style.border="1px solid " + bordercolor;
	// title.style.height="18px";
	// title.style.font="12px Verdana, Geneva, Arial, Helvetica, sans-serif";
	// title.style.color="white";
	// title.style.cursor="pointer";
	// title.innerHTML="关闭";
	//   
	// }
	document.body.appendChild(msgObj);
	document.body.appendChild(title);
	//title.appendChild(img2);
	msgObj.appendChild(img);

	document.getElementById("msgDiv").appendChild(title);
	/*title.onclick=function(){
		document.getElementById("msgDiv").removeChild(title);
		document.body.removeChild(msgObj);
	}*/
	var txt=document.createElement("p");
	txt.style.margin="3em 0"
	txt.setAttribute("id","msgTxt");
	txt.style.position="absolute";
	txt.style.color = 'red';
	txt.style.zIndex = "1000000";
	txt.style.fontSize = "20px";
	txt.style.fontWeight = "bold";
	txt.style.width = "80%";
	txt.style.left = "10%";
	txt.style.top = "5%";
	txt.style.textAlign = 'center';

	txt.innerHTML=str;
	document.getElementById("msgDiv").appendChild(txt);
	
	//设置关闭时间    
	setTimeout(function(){
		document.getElementById("msgDiv").removeChild(title);
		document.body.removeChild(msgObj);
	},2000);
};

function ssAlert(str){
	var msgw,msgh,bordercolor;
	msgw=400;//提示窗口的宽度
	msgh=200;//提示窗口的高度
	titleheight=25 //提示窗口标题高度
	bordercolor="#c51100";//提示窗口的边框颜色
	titlecolor="#c51100";//提示窗口的标题颜色

	var sWidth,sHeight;
	sWidth=screen.width;
	sHeight=screen.height;


	var msgObj=document.createElement("div");
	msgObj.setAttribute("id","msgDiv");
	msgObj.style.position = "absolute";
	msgObj.style.width = "80%";
	msgObj.style.left = "10%";
	msgObj.style.top = "25%";


	var img = document.createElement('img');
	img.setAttribute('src', 'http://7xkg1m.com2.z0.glb.qiniucdn.com/popUp.png');
	img.style.position = "absolute";
	img.style.width = "100%";
	img.style.top=0;
	img.style.left=0;
	img.style.zIndex = "1000000";

	var img2 = document.createElement('img');
	img2.setAttribute('src','http://7xkg1m.com2.z0.glb.qiniucdn.com/confirm.png');
	img2.style.width = "100%";
	img2.style.zIndex = "1000002";

	var title = document.createElement('div');
	title.style.position = "absolute";
	title.style.width = "45%";
	title.style.zIndex = "1000000";
	title.style.top = "100%";
	title.style.left = "27%";
	title.style.marginTop = 150+'px';

	document.body.appendChild(msgObj);
	document.body.appendChild(title);
	title.appendChild(img2);
	msgObj.appendChild(img);

	document.getElementById("msgDiv").appendChild(title);
	msgObj.onclick=function(){
		document.getElementById("msgDiv").removeChild(title);
		document.body.removeChild(msgObj);
		$('#form-box').css('display','none');
		$('#submitBg').css('display','none');
	}
	var txt=document.createElement("p");
	txt.style.display = "block";
	txt.style.margin="1em 10%";
	txt.setAttribute("id","msgTxt");
	txt.style.position="absolute";
	txt.style.color = 'red';
	txt.style.zIndex = "1000000";
	txt.style.fontSize = "20px";
	txt.style.fontWeight = "bold";
	txt.style.width = "80%";
	txt.style.height = "125px";
	txt.style.lineHeight = "25px";
	txt.style.overflowY = "scroll";
	txt.style.overflowX = "hidden";
	txt.style.textAlign = "left";

	txt.innerHTML=str;
	document.getElementById("msgDiv").appendChild(txt);
	
	//设置关闭时间    
	/*setTimeout(function(){
		document.getElementById("msgDiv").removeChild(title);
		document.body.removeChild(msgObj);
		$('#form-box').css('display','none');
		$('#submitBg').css('display','none');
	},2000);*/
};

document.getElementById("rules").onclick = function(){
	var rls = document.getElementById('rulesContent');
	rls.style.display="block";
	rls.style.zIndex="99999";
	rls.onclick = function(){
		this.style.display="none";
	}
};

document.getElementById("begin").onclick = function(){
	window.location.href="quiz/index.html";
};

document.getElementById("personal").onclick = function(){
	//window.location.href="personal.php";
	document.getElementById('submitBg').style.display = 'block';
	document.getElementById('form-box').style.display = 'block';
};

function validatemobile(mobile){
	if(mobile.length==0)
	{
	   //alert('请输入手机号码！');
	   sAlert("请输入手机号码！");
	   return false;
	}    
	
	var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
	if(!myreg.test(mobile))
	{
		//alert('请输入有效的手机号码');
		sAlert("请输入有效的手机号码！");
		return false;
	}
	
	return true;
}

function infosubmit(){	
	var phone = document.getElementById("phone").value;

	if(validatemobile(phone)==true){
		$.ajax({
			type: "post",
			url: "check.php",
			dataType: "json",
			data: {
				phone: phone
			},
			async: false,
			cache: false,
			success: function (result) {
				//var jasonData = jQuery.parseJSON(result);
				
				//alert(result['prizeOne'] + result['prizeTwo'] + result['prizeThree']);
				
				//document.getElementById('submitBg').style.display = 'none';
				//document.getElementById('form-box').style.display = 'none';
				
				
				var arr1 = [];
				var finalStr = '';
				var threeArr = [
					'恭喜你获得佐登妮丝3折优惠券，持太阳信用卡消费即享折扣！<br>',
					'恭喜你获得至尊用车“日租金8.5折”优惠，持太阳信用卡消费即享折扣！<br>',
					'恭喜你获得南海渔村9折优惠，持太阳信用卡消费即享折扣！<br>',
					'恭喜你获得堂会KTV房费9折优惠，持太阳信用卡消费即享折扣！<br>'
				];
				for(var i=0; i<result.prizeThreeType.length; i++){ //根据返回的三等奖种类生成奖项放入arr1[]
					arr1[i] = threeArr[result.prizeThreeType[i]['type']];
				}
				
				var arr2 = [];
				while(result.prizeOne>0){
					arr2.push('恭喜你获得钻石世家钻石腕表，稍后专人联系你领奖，手机要保持畅通哦！<br>');
					result.prizeOne=0;
				}
				while(result.prizeTwo>0){
					arr2.push('恭喜你获得7-11十元消费券，稍后发至预留手机号，请留意查收！<br>');
					result.prizeTwo=0;
				}
				
				arr2 = arr2.concat(arr1);  //将arr1[]和arr2[]合并
				for(var j=0; j<arr2.length; j++){  //循环遍历，将获奖信息追加到finalStr
					var tempNum = j+1;
					finalStr += tempNum + ". " + arr2[j];
				}
				
				//输出获奖信息
				ssAlert(finalStr);
			},
			fail: function (e) {}
		});
	}
}

document.getElementById("submit").onclick = function(){
	infosubmit();
};

winH = document.documentElement.clientHeight;
		document.getElementById('bg1').style.height = winH +"px"
		setTimeout(function(){
			document.getElementById('lihong').style.display = "none";
			document.getElementById('lihong2').style.opacity = 1;
		},700)
document.getElementById('bg-img-1').style.height = winH +'px';
document.getElementById('rulesContent').style.height = winH +'px';

// var winH = document.documentElement.clientHeight;
var distance = 860/1010*winH;

document.getElementById('begin').style.top = distance + "px";
document.getElementById('rules').style.top = distance + "px";
document.getElementById('personal').style.top = distance + "px";
</script>
</html>
