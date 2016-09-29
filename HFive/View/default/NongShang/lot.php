<?php
	header("Content-type: text/html; charset=utf-8");
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
<head lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=320, maximum-scale=1.5, user-scalable=no">
<meta http-equiv="Cache-Control" content="no-transform">
<title>见“1”答题赢大奖</title>

<link rel="stylesheet" href="css/reset.css" type="text/css" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" href="css/sweetalert.css" />
<link rel="stylesheet" href="css/lot.css" />
</head>

<body>
	<div class="view">
		<div id="reserve">
			<span id="times">0</span>
		</div>

		<div class="line">
			<div class="content">
				<div id="slotBox">
					<div id="machine1" class="slotMachine">
						<div class="slot slot1"></div>
						<div class="slot slot2"></div>
						<div class="slot slot3"></div>
						<div class="slot slot4"></div>
						<div class="slot slot5"></div>
						<div class="slot slot6"></div>
						<div class="slot slot7"></div>
						<div class="slot slot8"></div>
						<div class="slot slot9"></div>
						<div class="slot slot10"></div>
					</div>
					
					<div id="machine2" class="slotMachine">
						<div class="slot slot1"></div>
						<div class="slot slot2"></div>
						<div class="slot slot3"></div>
						<div class="slot slot4"></div>
						<div class="slot slot5"></div>
						<div class="slot slot6"></div>
						<div class="slot slot7"></div>
						<div class="slot slot8"></div>
						<div class="slot slot9"></div>
						<div class="slot slot10"></div>
					</div>
					
					<div id="machine3" class="slotMachine">
						<div class="slot slot1"></div>
						<div class="slot slot2"></div>
						<div class="slot slot3"></div>
						<div class="slot slot4"></div>
						<div class="slot slot5"></div>
						<div class="slot slot6"></div>
						<div class="slot slot7"></div>
						<div class="slot slot8"></div>
						<div class="slot slot9"></div>
						<div class="slot slot10"></div>
					</div>
					
				</div>
			
			</div>
			
			<div id="slotMachineButton1" class="slotMachineButton"></div>
		</div>

		<div class="main-btn" id="getPrize"></div>
		<div class="main-btn" id="share"></div>
		<a id="offline" href="http://mp.weixin.qq.com/s?__biz=MjM5MzIwOTQzMw==&mid=223275886&idx=1&sn=3a5ebe87a7c3e901ede4c1acbf528bfe&scene=1&from=groupmessage&isappinstalled=0#rd" onclick="javascript:location.replace(this.href); event.returnValue=false; "></a>
	</div>

	<div id="form-box">
		<form method="POST" onsubmit="return false;">
			<div class="nameInput">
				<img src="http://7xkg1m.com2.z0.glb.qiniucdn.com/input1.png" width="100%"/>
			</div>
			<input type="text" id="name" />

			<div class="phoneInput">
				<img src="http://7xkg1m.com2.z0.glb.qiniucdn.com/input2.png" width="100%"/>
			</div>
			<input type="text" id="phone" />
			
			<div type="submit" id="submit" value=""></div>
		</form>
	</div>

	<script type="text/javascript" src="quiz/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.slotmachine.js"></script>
	<script type="text/javascript" src="js/sweetalert.min.js"></script>
	<script type="text/javascript" src="js/lot.js"></script>
	<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script>
	var isshared = 0;
	var res_times;

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
			  link: 'http://baozou.gzbaishitong.com/game/source/nongshangnew/index.php',
			  imgUrl: 'http://7xkg1m.com2.z0.glb.qiniucdn.com/shareTo.jpg',
			  trigger: function (res) {
			  },
			  success: function (res) {
					//alert("分享到朋友圈才可以多抽一次哦！");
					sAlert("分享到朋友圈才可以多抽一次哦！");
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
				if(window.isshared==0){
					res_times += 1;
					$('#times').html(res_times);
					//alert("分享成功，获得一次抽奖机会！");
					sAlert("分享成功，获得一次抽奖机会！");					
					window.isshared = 1;
				}
				else {
					//alert("你已经分享过了！");
					sAlert("你已经分享过了！");
					return true;
				}
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