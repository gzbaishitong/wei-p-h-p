<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once "js_jdk.php";
	$jssdk = new JSSDK("wxb1114bb65753893c", "6e7feece406d1b7c48baf85c071bd3f1");
	$signPackage = $jssdk->GetSignPackage();

	$user_agent = $_SERVER['HTTP_USER_AGENT'];
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Expires" content="-1">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta charset="utf-8">
	<title>拍史努比，赢史努比公仔！</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0">
	<meta name="format-detection" content="telephone=no" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta name="full-screen" content="yes">
	<meta name="screen-orientation" content="portrait">
	<meta name="x5-fullscreen" content="true">
	<meta name="360-fullscreen" content="true">
	<link rel="stylesheet" href="css/one.css">

	<script src="js/jquery-2.0.0.min.js"></script>
	<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script>
	wx.config({
		debug: false,
		appId: '<?php echo $signPackage["appId"];?>',
		timestamp: <?php echo $signPackage["timestamp"];?>,
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

	function wxshare1(){

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
			  title: '我拍史努比，有整套snoopy公仔送哦!',
			  desc: '你也来挑战吧，看谁拍的准！',
			  link: 'http://kf.gzbaishitong.com/games/snpy/index.php',
			  imgUrl: 'http://kf.gzbaishitong.com/games/snpy/images/share-icon.jpg',
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
			  title: '我拍史努比，有整套snoopy公仔送哦!',
			  desc: '你也来挑战吧，看谁拍的准！',
			  link: 'http://kf.gzbaishitong.com/games/snpy/index.php',
			  imgUrl: 'http://kf.gzbaishitong.com/games/snpy/images/share-icon.jpg',
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
	wxshare1();

	function wxshare2(score){

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
			  title: '我拍史努比得到'+score+'分，整套SNOOPY公仔非我莫属了~',
			  desc: '你也来挑战吧，看谁拍的准！',
			  link: 'http://kf.gzbaishitong.com/games/snpy/index.php',
			  imgUrl: 'http://kf.gzbaishitong.com/games/snpy/images/share-icon.jpg',
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
			  title: '我拍史努比得到'+score+'分，整套SNOOPY公仔非我莫属了~',
			  desc: '你也来挑战吧，看谁拍的准！',
			  link: 'http://kf.gzbaishitong.com/games/snpy/index.php',
			  imgUrl: 'http://kf.gzbaishitong.com/games/snpy/images/share-icon.jpg',
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
	<script src="js/mk1.js"></script>
</head>
<body>
	<div id="container" class="play">


		<canvas id="canvas"><span>Browser does not support the canvas.</span></canvas>
		<div id="info"></div>
		<div id="share-tip">
			<img src="images/8175051909340738288.png" width="100%" height="100%" />
		</div>
	</div>
	<div id="preload"></div>
	<script src="js/mk2.js"></script>
	
	<!--积分券-->
	<div class="fouth-page">
		<div class="duihuanma"></div>
		<div class="card"></div>
		<!--<div class="send"></div>-->
	</div>

<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan style='display:none;' id='cnzz_stat_icon_1257033539'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/z_stat.php%3Fid%3D1257033539' type='text/javascript'%3E%3C/script%3E"));</script>

</body>
</html>