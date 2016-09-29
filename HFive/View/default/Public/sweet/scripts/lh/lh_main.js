$(document).ready(function(){
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
		  title: 'KisKis甜言密语',
		  desc: '我在KisKis甜言密语中收到了一张神秘明信片，你也来制作吧！',
		  link: 'http://kf.gzbaishitong.com/games/sweet/index.php',
		  imgUrl: 'http://kf.gzbaishitong.com/games/sweet/images/loading.jpg',
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
		  title: 'KisKis甜言密语',
		  desc: '我在KisKis甜言密语中收到了一张神秘明信片，你也来制作吧！',
		  link: 'http://kf.gzbaishitong.com/games/sweet/index.php',
		  imgUrl: 'http://kf.gzbaishitong.com/games/sweet/images/loading.jpg',
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
	var to = GetQueryString("toS");
	var from = GetQueryString("fromS");
	text = 'To:' + to + '<br>' + text + '<br>From:' + from;
	$("#postcard_content p").html(text);

	//点击选择图片
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

	//分享按钮
	$('#btn_share').click(function(){
		//alert('点击右上角分享给你的朋友吧！');
		$('#sharePop').css('display','block');
		$('#sharePop').click(function(){
			$('#sharePop').css('display','none');
		});
	});
});