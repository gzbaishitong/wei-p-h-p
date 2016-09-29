<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once("./wx/js_jdk.php");
	include_once('./wx/pdo.class.php');
	$jssdk = new JSSDK("wxb1114bb65753893c", "6e7feece406d1b7c48baf85c071bd3f1");
	$signPackage = $jssdk->GetSignPackage();
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if(empty($_GET['openid'])){
	header("location:http://kf.gzbaishitong.com/app/index.php?i=10&c=entry&do=index&m=duiwai&type=userinfo&redirecturl="."http://kf.gzbaishitong.com/games/furious/wx/get_wx_userinfo.php");
	die();
	}
	$openid = $_GET['openid'];
	$pdo = new pdomysql();
	$result = $pdo->_fetch("select * from userinfo where openid='$openid'",0);
	$hasphone = ($result['phone']==NULL)?0:1;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=640,target-densitydpi=device-dpi,user-scalable=no" />
    <title>Kiskis 端午龙舟赛</title>
    
	<script src="js/jquery-1.11.1.min.js" type="text/javascript"></script>
    <script src="js/TweenMax.min.js" type="text/javascript"></script>
    <script src="js/jquery.rabidScratchCard.prod.js" type="text/javascript" ></script>
    <script src="js/easeljs-0.6.0.min.js"></script>
    <script src="js/tweenjs-0.4.0.min.js"></script>
    <script src="js/movieclip-0.6.0.min.js"></script>
    <script src="js/preloadjs-0.3.0.min.js"></script>
    <script src="js/loading.js"></script>
    <script src="js/idangerous.swiper-2.1.min.js"></script> 
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script>
	//alert(WXVAR.appId+"--"+WXVAR.timestamp+"--"+WXVAR.nonceStr+"--"+WXVAR.signature);
	var OPENID = "<?php echo $openid ?>",
		hasphone = "<?php echo $hasphone ?>";
	//alert('<?php echo $signPackage["appId"];?>'+"--"+'<?php echo $signPackage["signature"];?>');
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
	//alert('<?php echo $signPackage["appId"];?>'+"--"+'<?php echo $signPackage["signature"];?>');
	</script>
	<script>
	function wxshare(score){
		wx.ready(function () {
			wx.onMenuShareAppMessage({
			  title: (typeof score != 'undefined')?'我在极速龙舟赛中获得了'+score+'分，你也来玩吧！':'KisKis极速龙舟挑战赛，邀你来挑战！',
			  desc: '【游戏】KisKis极速龙舟挑战赛',
			  link: 'http://kf.gzbaishitong.com/games/furious/index.php',
			  imgUrl: 'http://kf.gzbaishitong.com/games/furious/share.jpg',
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
			  title: (typeof score != 'undefined')?'我在极速龙舟赛中获得了'+score+'分，你也来玩吧！':'KisKis极速龙舟挑战赛，邀你来挑战！',
			  desc: '【游戏】KisKis极速龙舟挑战赛',
			  link: 'http://kf.gzbaishitong.com/games/furious/index.php',
			  imgUrl: 'http://kf.gzbaishitong.com/games/furious/share.jpg',
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
	<script src="js/index.js"></script>
    
	<link rel="stylesheet" href="css/idangerous.swiper.css">
    <link rel="stylesheet" href="css/main.css"/>
	<link rel="stylesheet" href="css/animate.css"/>

	<script>
		var _hmt = _hmt || [];
		(function() {
		  var hm = document.createElement("script");
		  hm.src = "//hm.baidu.com/hm.js?da0278feae5c239dcb88f91412e043b8";
		  var s = document.getElementsByTagName("script")[0]; 
		  s.parentNode.insertBefore(hm, s);
		})();
	</script>
    
    <script>
	   (function (i, s, o, g, r, a, m) {
		   i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
			   (i[r].q = i[r].q || []).push(arguments)
		   }, i[r].l = 1 * new Date(); a = s.createElement(o),
m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
	   })(window, document, 'script', 'http://www.google-analytics.com/analytics.js', 'ga');

	   ga('create', 'UA-59573969-2', 'auto');
	   ga('send', 'pageview');

	   function gotoga(url) {
		   ga('send', 'pageview', url);
	   }
	</script>
	
</head>

<body >
    <div class="load_main">
    	<div class="load_cont">
            <div class="progress">0%</div>
            <div class="loading"><img src="images/loading.gif" class="loadingBar" /></div>
        </div>
    </div>
    
    <div class="wrapper">	
    	<div class="intro">
			<!---------封面图开始----------->
			<div class="wrapper-cover">
				<!--<img id="cover_img" src="images/bg.jpg" />-->
				<div class="big-title animated shake">
					<img id="cover_big_title" src="images/big-title.png" width="100%" height="100%" />
				</div>
				<div class="little-title animated zoomIn">
					<img id="cover_big_title" src="images/little.png" width="100%" height="100%" />
				</div>
				<div class="begin">
					<img id="cover_big_title" src="images/begin.png" width="100%" height="100%" />
				</div>
				<!--
				<div class="z1">
					<img src="images/z5.png" alt="">
				</div>
				<div class="z2">
					<img src="images/z1.png" alt="">
				</div>
				<div class="z3">
					<img src="images/z2.png" alt="">
				</div>
				-->
				<!-- <div class="z4">
					<img src="images/z3.png" alt="">
				</div> -->
			</div>
			<!-----------封面图结束------------->

        	<div class="start_btn"></div>
        	<!--<img src="images/t1.png" class="t1">
        	<img src="images/t2.png" class="t2">
        	<img src="images/begin.png" class="t3">-->
        </div>
    	<div class="left_btn"><img src="images/left_btn.png" /></div>
    	<div class="right_btn"><img src="images/right_btn.png" /></div>
    	<div class="gameMain"><canvas id="gameMain" width="640" height="1011" style="background-color:none"></canvas>
        
        <div class="score">
        	<div class="label1">得分</div>
        	<div class="label2">0</div>
        	<img src="images/score_bg.png" class="bg" />
        </div>
        
        <div class="yibiao">
        	<!--<img src="images/speed_bg.png" class="bg" />
            <img src="images/line.png" class="line" />-->
        </div>
    </div>
    
    <div class="countDown">
    	<div class="cont">
        	<img src="images/3.png" class="time" />
        	<img src="images/score_bg.png" class="bg" />
        </div>
    </div>
    
    <div class="result">
		<!--弹出框-->
		<div id="popDiv" class="pop_layer">
			排名前5即可获得KISKIS薄荷糖哦~请输入电话号码<br/>不能输入电话号码的同学，搜索微信公众号'kiskiscandy',发送游戏分数截图参加活动！！
			<input type="text" id="phone" />
			<a class="tijiao">提交</a>
			<a class="quxiao">去截图！</a>
		</div>
		<div id="bg" class="bg"></div>
		
		
		<!--<div id="close" style="display:block;"></div>-->
		
		<!--排行榜-->
		<div id="rankDiv" class="pop_layer">
		</div>
		

    	<!--<div class="logo"><img src="images/logo.png" /></div>-->
        <div class="txt1"><img src="images/txt1.png" /></div>
        <div class="txt2"><img src="images/txt2.png" /></div>
        <div class="sc">0</div>
        <div class="pm">NO.0</div>
        <div class="again_btn"><img src="images/again_btn.png" /></div>
        <div class="share_btn"><img src="images/share_btn.png" /></div>
        <!--<div class="icon"><img src="images/level1.png" id="icons" /></div>-->
    </div>
    
    <div class="share_cont">
    	点击右上角，炫耀给朋友！
    </div>
    

</body>
</html>