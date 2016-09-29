<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once "js_jdk.php";
	$jssdk = new JSSDK("wxb1114bb65753893c", "6e7feece406d1b7c48baf85c071bd3f1");
	$signPackage = $jssdk->GetSignPackage();
	
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
?>

<!DOCTYPE html>
<html lang="ch">
<head>
	<meta charset="utf-8" />
	<meta name="apple-touch-fullscreen" content="YES" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<title>KisKis甜言密语</title>

	<link rel="stylesheet" type="text/css" href="styles/lh/lh_style.css">

	<script type="text/javascript">
	var phoneWidth = parseInt(window.screen.width);
	var phoneScale = phoneWidth/553;
	var ua = navigator.userAgent;
	if (/Android (\d+\.\d+)/.test(ua)){
		var version = parseFloat(RegExp.$1);
		// andriod 2.3
		if(version>2.3){
			document.write('<meta name="viewport" content="width=553, minimum-scale = '+phoneScale+', maximum-scale = '+phoneScale+', target-densitydpi=device-dpi">');
			// andriod 2.3以上
		}else{
			document.write('<meta name="viewport" content="width=553, target-densitydpi=device-dpi">');
		}
	// 其他系统
	} else {
		document.write('<meta name="viewport" content="width=553, user-scalable=no, target-densitydpi=device-dpi">');
	}
	</script>
<style>
#from:before{
	content:'From:';
}

#to:before{
	content:'To:';
}
</style>	
</head>
<body>
<div class="container">
	<div id="answerpage_bg">
		<div id="image_top">
			<img src="images/lh/type1.png" width="100%" height="100%" />
		</div>
		<div id="answerpage_top">
			<img src="" width="100%" height="100%" />
		</div>

		<div id="answerpage_mid">
			<div id="question">
				<label><img src="images/question.png" width="100" /></label>
				<input type="text" id="input_question" placeholder="在这里输入保密问题" />
			</div>
			<div id="answer">
				<label><img src="images/answer.png" width="100" /></label>
				<input type="text" id="input_answer" placeholder="在此框输入问题答案" autofocus="autofocus" />
			</div>
		</div>

		<div id="answerpage_bottom">
			<div id="btn_check">
				<img src="images/lh/btn_check.png" width="100" height="100" />
				<div class="arrow"></div>
			</div>
			<div id="bottom_tips">
				<img src="images/lh/checkPage_bottom.png" width="100%" />
			</div>
		</div>
	</div>
	
	<div id="zhizuo">
		<img src="images/lh/a7_btn1.png" width="100%" />
	</div>

	<div id="blingDiv">
		<img id="bling" src="images/lh/bling.png" width="100%" />
	</div>

	<div id="sharepage_bg">
		<div id="sharepage_top">
			<div id="postcard_content">
				<!--<p id="content_text">To:某人<br>打开微信对话框输入<br>“我想你”<br>删除一个字，删除一个字，再删除一个字<br>From想你的</p>-->
				<p></p>
			</div>
		</div>
		<div id="sharepage_mid"></div>
		<div id="sharepage_bottom">
			<div id="btn_make"></div>
			<div id="btn_share"></div>
		</div>
		
		<!--分享提示层-->
		<div id="sharePop">
			<img src="images/lh/share_pop.png" width="100%" height="100%" />
		</div>
	</div>
</div>


<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
$(document).ready(function(){
	//验证答案
	function validateanswer(answer){
		var answer_length = answer.replace(/[^\x00-\xff]/g,"**").length;
		if(answer_length==0){
			alert('答案还没填哦！');
			return false;
		}
		if(answer_length>200){
			alert('超过字数限制了！');
			answer = answer.substring(0,200);
			return false;
		}
		return true;
	}

	function GetQueryString(name)
	{
		 var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
		 var r = window.location.search.substr(1).match(reg);
		 if(r!=null)return  decodeURI(r[2]); return null;
	}

	var GLB_img, GLB_question, GLB_answer, GLB_toS, GLB_fromS, GLB_text;

	//获取明信片封面
	var img = GetQueryString("img");
	$('#answerpage_top img').attr('src',img);
	var img_top = img.substring(7,8);
	if(img_top=='1'){$('#image_top img').attr('src','images/lh/type1.png');}
	else if(img_top=='2'){$('#image_top img').attr('src','images/lh/type2.png');}
	else if(img_top=='3'){$('#image_top img').attr('src','images/lh/type3.png');}
	else if(img_top=='4'){$('#image_top img').attr('src','images/lh/type4.png');}
	else if(img_top=='5'){$('#image_top img').attr('src','images/lh/type1.png');}
	else {$('#image_top').css('display','none');}

	//正确问题和答案
	var trueQuestion = GetQueryString("question");
	$('#input_question').attr('value',trueQuestion);
	var trueAnswer = GetQueryString("answer");
	 
	//获取明信片正文内容
	var text = GetQueryString("text");
	GLB_text = encodeURI(text);
	var to = GetQueryString("fromS");
	var from = GetQueryString("toS");
	text = 'To:' + to + '<br>' + text + '<br>From:' + from;
	$("#postcard_content p").html(text);

	GLB_img = encodeURI(img);
	GLB_question = encodeURI(trueQuestion);
	GLB_answer = encodeURI(trueAnswer);
	GLB_toS = encodeURI(from);
	GLB_fromS = encodeURI(to);

	//点击开锁按钮
	$('#btn_check').click(function(){
		var question = $('#input_question').val();
		var answer = $('#input_answer').val();

		if(validateanswer(answer)==true){
			if(answer==trueAnswer){
				$('#blingDiv').css('display','block');
				setTimeout("$('#answerpage_bg').css('display','none');$('#blingDiv').css('display','none');$('#sharepage_bg').css('display','block');",2500);
			}else{
				alert('密语不对哦！');
			}
		}
	});

	//我要制作
	$('#btn_make').click(function(){
		location.href = "http://kf.gzbaishitong.com/games/sweet/index.php";
	});

	$('#zhizuo').click(function(){
		location.href = "http://kf.gzbaishitong.com/games/sweet/index.php";
	});
	//分享按钮
	$('#btn_share').click(function(){
		//alert('点击右上角分享给你的朋友吧！');
		$('#sharePop').css('display','block');
		$('#sharePop').click(function(){
			$('#sharePop').css('display','none');
		});
	});
	
	wx.config({
		debug: false,
		appId: '<?php echo $signPackage["appId"];?>',
		timestamp: '<?php echo $signPackage["timestamp"];?>',
		nonceStr: '<?php echo $signPackage["nonceStr"];?>',
		signature: '<?php echo $signPackage["signature"];?>',
		jsApiList: [
			// 所有要调用的 API 都要加到这个列表中
			'checkJsApi',
			'onMenuShareTimeline',
			'onMenuShareAppMessage'
		]
	});

	wx.ready(function () {
		wx.checkJsApi({
			jsApiList: [
				'onMenuShareTimeline',
				'onMenuShareAppMessage'
			],
			success: function (res) {
				//alert(JSON.stringify(res));
			}
		});
		
		wx.onMenuShareAppMessage({
		  title: '考验真爱的时候到了！据说只有懂我的人才能看到哦~',
		  desc: '嘘~我刚才发了一段悄悄话。据说打开的人都是喜欢我的。。。',
		  link: 'http://kf.gzbaishitong.com/games/sweet/answer.php?img='+GLB_img+'&question='+GLB_question+'&answer='+GLB_answer+'&toS='+GLB_toS+'&fromS='+GLB_fromS+'&text='+GLB_text,
		  imgUrl: 'http://kf.gzbaishitong.com/games/sweet/images/share.jpg',
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
		  title: '考验真爱的时候到了！据说只有懂我的人才能看到哦~',
		  desc: '嘘~我刚才发了一段悄悄话。据说打开的人都是喜欢我的。。。',
		  link: 'http://kf.gzbaishitong.com/games/sweet/answer.php?img='+GLB_img+'&question='+GLB_question+'&answer='+GLB_answer+'&toS='+GLB_toS+'&fromS='+GLB_fromS+'&text='+GLB_text,
		  imgUrl: 'http://kf.gzbaishitong.com/games/sweet/images/share.jpg',
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
});
</script>
<!--<script src="scripts/lh/lh_main.js"></script>-->
<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan style='display:none;' id='cnzz_stat_icon_1256008039'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/z_stat.php%3Fid%3D1256008039' type='text/javascript'%3E%3C/script%3E"));</script>
</body>
</html>