<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once "js_jdk.php";
	$jssdk = new JSSDK("wx807f16d8a8046457", "58abccf980b5bc2e4302d8255c84fd16");
	$signPackage = $jssdk->GetSignPackage();
	
	$user_agent = $_SERVER['HTTP_USER_AGENT'];

	if (strpos($user_agent, 'MicroMessenger') === false) {
		echo '<div style="width:100%;font-size:30px;text-align:center;margin-top:30px;">请使用微信浏览器访问！</div>';
		die;
	}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta http-equiv="Cache-Control" content="no-transform">
<meta name="format-detection" content="telephone=no"/>
<title>见“1”答题赢大奖</title>

<link rel="stylesheet" href="css/que.css">
<script type="text/javascript" src="quiz/jquery.min.js"></script>

</head>
<body>	
	<div id="spinner">
	  <div id="bounce1"></div>
	  <div id="bounce2"></div>
	  <div id="bounce3"></div>
	</div>
	
	<div id="bg">
		<!--灯箱、光线、星星、人物-->
		<div id="lightbox">
			<img src="img/new/lightbox.png" width="100%" height="100%">
		</div>
		<div id="light">
			<img src="img/new/light.png" width="100%" height="100%">
		</div>
		<div id="star">
			<img src="img/new/star.png" width="100%" height="100%">
		</div>
		<div id="lihong">
			<img src="img/new/lihong.png" width="100%" height="100%">
		</div>
		
		<!--游戏规则-->
		<div id="rules">
			<img src="img/new/rulesBtn.png" width="100%" height="100%">
		</div>
		<div id="rulesContent">
			<img src="img/new/rules.png" width="100%" height="100%">
		</div>
		
		<!--开始答题-->
		<div id="begin">
			<img src="img/new/begin-button.png" width="100%" height="100%">
		</div>
		
		<!--我的奖品-->
		<div id="personal">
			<img src="img/new/personalBtn.png" width="100%" height="100%" alt="">
		</div>
	</div>
	
	<div id="submitBg">
		<div id="form-box">
			<form method="POST" onsubmit="return false;">
				<div class="phoneInput">
					<img src="img/new/input2.png" width="100%"/>
				</div>
				<input type="text" id="phone" />
				
				<div id="submit"></div>
			</form>
		</div>
	</div>

	<script type="text/javascript" src="js/que.js"></script>
	<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript">
	function wxshare(){
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
			  link: 'http://baozou.gzbaishitong.com/game/source/nongshangnew11/que.php',
			  imgUrl: 'http://baozou.gzbaishitong.com/game/source/nongshangnew11/img/new/shareTo.jpg',
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
			  link: 'http://baozou.gzbaishitong.com/game/source/nongshangnew11/que.php',
			  imgUrl: 'http://baozou.gzbaishitong.com/game/source/nongshangnew11/img/new/shareTo.jpg',
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
	</script>

	<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan style='display:none;' id='cnzz_stat_icon_1255852946'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/z_stat.php%3Fid%3D1255852946' type='text/javascript'%3E%3C/script%3E"));</script>
</body>
</html>
