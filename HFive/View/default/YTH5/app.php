<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once("./wx/js_jdk.php");
	include_once('./wx/pdo.class.php');
	$jssdk = new JSSDK("wxb1114bb65753893c", "6e7feece406d1b7c48baf85c071bd3f1");
	$signPackage = $jssdk->GetSignPackage();
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
?>
<!DOCTYPE html>
<html lang="en" manifest = "demo1.manifest">
<head>
	<meta charset="UTF-8">
	<title>YT公寓</title>
	<meta name="charset" content="utf-8">
	<meta name='viewport' content="width=device-width,initial-scale=1,maximum-scale=1">
	<style>
		*{margin:0;padding:0}
		html,body{width:100%;height:100%;font-size:0;overflow:hidden}
		#cas{width:100%;height:100%}
		#loading{width:100%;height:100%;background-color:black;background-size:100% 100%}
	</style>
</head>
<body>
	<canvas id="cas"></canvas>
	<script src="http://cdn.gbtags.com/EaselJS/0.7.1/easeljs.min.js"></script>
	<script src="http://cdn.gbtags.com/tweenjs/0.5.1/tweenjs.min.js"></script>
	<script src="http://cdn.gbtags.com/PreloadJS/0.4.1/preloadjs.min.js"></script>
	<script src="http://cdn.gbtags.com/SoundJS/0.5.2/soundjs.min.js"></script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript">
	window.applicationCache.addEventListener('updateReady',function(){
		window.location.reload();
	})
	
	//wx share
	
	wx.config({
		debug: false,
		appId: '<?php echo $signPackage["appId"];?>',
		timestamp: '<?php echo $signPackage["timestamp"];?>',
		nonceStr: '<?php echo $signPackage["nonceStr"];?>',
		signature: '<?php echo $signPackage["signature"];?>',
		jsApiList: [
			// 所有要调用的 API 都要加到这个列表中
			'checkJsApi',
			'openLocation',
			'getLocation',
			'onMenuShareTimeline',
			'onMenuShareAppMessage'
		  ]
	});
	
	function wxshare(score){
		wx.ready(function () {
			wx.onMenuShareAppMessage({
			  title: '广州百事通',
			  desc: '我在同创公寓的游戏demo中获得'+score+'分',
			  link: 'http://kf.gzbaishitong.com/games/YTH5/app.php',
			  imgUrl: 'http://kf.gzbaishitong.com/games/YTH5/img/clock.png',
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
			  title: 'YT H5 demo',
			  desc: '我在同创公寓的游戏demo中获得'+score+'分',
			  link: 'http://kf.gzbaishitong.com/games/YTH5/app.php',
			  imgUrl: 'http://kf.gzbaishitong.com/games/YTH5/img/clock.png',
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
	</script>
	<script src="game.js?v=1" charset="utf-8"></script>
</body>
</html>