

<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=320, maximum-scale=1.5, user-scalable=no">
<!--<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">-->
<meta content=”yes” name=”apple-mobile-web-app-capable” />
<meta content=”black” name=”apple-mobile-web-app-status-bar-style” />
<meta content=”telephone=no” name=”format-detection” />
<meta http-equiv="Cache-Control" content="no-transform">
<title>见“1”有奖抽奖页</title>

<link rel="stylesheet" href="css/reset.css" type="text/css" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" href="css/sweetalert.css" />

<script type="text/javascript" src="quiz/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.slotmachine.js"></script>
<script type="text/javascript" src="js/sweetalert.min.js"></script>
<script src="//cdn.bootcss.com/fastclick/1.0.6/fastclick.min.js"></script>


<style>
.view {width:100%;margin:0;}
.view .cover {width:100%;background:rgba(0,0,0,0.8);position:fixed;top:0;left:0;}
.view .cover img {width:98%;margin:1%;}
#slotMachineButton1{
	clear:both;width:21%;height:15%;left:39%;top:49%;position:absolute; background:url('http://7xkg1m.com2.z0.glb.qiniucdn.com/prizeBtn.png') no-repeat center;background-size:93% 73%;
}

<!--提交资料DIV-->
#form-box {
	width:100%;
	height:100%;
	display:none;
}

#desc {
	width:200px;
	height:140px;
	margin:20px auto 10px;
	padding:0 5%;
	border:5px dashed #fff;
	border-radius:15px;
	color:#A48E4E;
	font-size:1em;
	font-weight:bold;
	display:none;
}

form {text-align:center; display:none;}
/*.nameInput {width:20%;height:5%;left:17%;top:46%;position:absolute;background:url('http://7xkg1m.com2.z0.glb.qiniucdn.com/input1.png') no-repeat center;background-size:auto 85%;}
.phoneInput {width:20%;height:5%;left:17%;top:61%;position:absolute;background:url('http://7xkg1m.com2.z0.glb.qiniucdn.com/input2.png') no-repeat center;background-size:auto 85%;}*/

.nameInput {width:70px; height:35px; left:19%; top:47%; position:absolute;}
.phoneInput {width:70px; height:35px; left:20%; top:62%; position:absolute;}
#submit {background-color:transparent; border:none; outline:none; display:block; clear:both; width:21%;height:15%;left:39%;top:83%;position:absolute;background:url('http://7xkg1m.com2.z0.glb.qiniucdn.com/submitBtn.png') no-repeat center;background-size:93% 73%;}

#name {display:block; width:60%;height:6%; left:20%; top:53%; position:absolute; border:2px solid #7b1d51; border-radius:5px; background-color:#fff;}
#phone {display:block; width:60%;height:6%; left:20%; top:68%; position:absolute; border:2px solid #7b1d51; border-radius:5px; background-color:#fff;}


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
</style>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
$(function() {
    FastClick.attach(document.body);
}); 

var isshared = 0;
var res_times;

$(document).ready(function(){
	//document.getElementById("music").play();  //背景音乐
	
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

		/*var img2 = document.createElement('img');
		img2.setAttribute('src','http://7xkg1m.com2.z0.glb.qiniucdn.com/confirm.png');
		img2.style.width = "100%";*/

		var title = document.createElement('div');
		title.style.position = "absolute";
		title.style.width = "45%";
		title.style.zIndex = "1000000";
		title.style.top = "100%";
		title.style.left = "27%";
		title.style.marginTop = 150+'px';

		document.body.appendChild(msgObj);
		document.body.appendChild(title);
		//title.appendChild(img2);
		msgObj.appendChild(img);

		document.getElementById("msgDiv").appendChild(title);
		/*title.onclick=function(){
			document.getElementById("msgDiv").removeChild(title);
			document.body.removeChild(msgObj);
			$('#form-box').css('display','none');
			$('.view').css('display','block');
			document.getElementsByTagName("body")[0].setAttribute("style","width: 100%; height: 100%; position: absolute; overflow-x: hidden; background: url('http://7xkg1m.com2.z0.glb.qiniucdn.com/prizeBg.jpg') no-repeat center; background-size: 100% 100%;")
		}*/
		var txt=document.createElement("p");
		txt.style.display = "block";
		txt.style.margin="4em 10%";
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
		txt.style.textAlign = "center";

		txt.innerHTML=str;
		document.getElementById("msgDiv").appendChild(txt);
		
		//设置关闭时间    
		setTimeout(function(){
			document.getElementById("msgDiv").removeChild(title);
			document.body.removeChild(msgObj);
			$('#form-box').css('display','none');
			$('.view').css('display','block');
			document.getElementsByTagName("body")[0].setAttribute("style","width: 100%; height: 100%; position: absolute; overflow-x: hidden; background: url('http://7xkg1m.com2.z0.glb.qiniucdn.com/prizeBg.jpg') no-repeat center; background-size: 100% 100%;")
		},2000);
	};
	
	//微信分享接口
	function wxshare(){
		wx.config({
			debug: false,
			appId: '',
			timestamp:"",
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
	
	//获取url的trueCount参数，确定抽奖次数
	function GetQueryString(name) {

	   var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)","i");

	   var r = window.location.search.substr(1).match(reg);

	   if (r!=null) return unescape(r[2]); return null;

	}
	var temp1 = GetQueryString("trueCount");
	if(temp1>5){
		temp1 = 5;
	}
	res_times = temp1;
	$('#times').html(res_times);

	//老虎机对象
	var machine1 = $("#machine1").slotMachine({
		active	: 0,
		delay	: 500/*,
		stopIndex: 0*/ //stopIndex为5时中奖
	});
	
	var machine2 = $("#machine2").slotMachine({
		active	: 0,
		delay	: 500,
		stopIndex: 0
	});
	
	var machine3 = $("#machine3").slotMachine({
		active	: 0,
		delay	: 500,
		stopIndex: 5
	});

	var m1_rslt, m2_rslt, m3_rslt;

	var totalPrizeOne = 0, totalPrizeTwo = 0, totalPrizeThree = 0, totalPrizeNum = 0;
	var prizeThreeType = [];
	var prizeMsg = [];
	var tempMsg = '';
	var prizeIndex = 5;  //中奖页为5
	
	function onComplete($el, active){
		switch($el[0].id){
			case 'machine1':
				m1_rslt = active.index;
				break;
			case 'machine2':
				m2_rslt = active.index;
				break;
			case 'machine3':
				m3_rslt = active.index;

				//获三等奖
				if(((m1_rslt==prizeIndex)&&(m2_rslt!=prizeIndex)&&(m3_rslt!=prizeIndex)) || ((m2_rslt==prizeIndex)&&(m1_rslt!=prizeIndex)&&(m3_rslt!=prizeIndex)) || ((m3_rslt==prizeIndex)&&(m1_rslt!=prizeIndex)&&(m2_rslt!=prizeIndex))) {
					totalPrizeNum++;
					prizeThreeType[totalPrizeThree] = Math.floor(Math.random(0,1)*4);
					if(prizeThreeType[totalPrizeThree] == 0){tempMsg = '恭喜你获得佐登妮丝3折优惠券，持太阳信用卡消费即享折扣！<br>'}
					if(prizeThreeType[totalPrizeThree] == 1){tempMsg = '恭喜你获得至尊用车“日租金8.5折”优惠，持太阳信用卡消费即享折扣！<br>'}
					if(prizeThreeType[totalPrizeThree] == 2){tempMsg = '恭喜你获得南海渔村9折优惠，持太阳信用卡消费即享折扣！<br>'}
					if(prizeThreeType[totalPrizeThree] == 3){tempMsg = '恭喜你获得堂会KTV房费9折优惠，持太阳信用卡消费即享折扣！<br>'}
					prizeMsg[totalPrizeNum] = tempMsg;
					sAlert(tempMsg);
					totalPrizeThree++;
				}
				//获二等奖
				else if(((m1_rslt==prizeIndex && m2_rslt==prizeIndex)&&(m3_rslt!=prizeIndex)) || ((m1_rslt==prizeIndex && m3_rslt==prizeIndex)&&(m2_rslt!=prizeIndex)) || ((m2_rslt==prizeIndex && m3_rslt==prizeIndex)&&(m1_rslt!=prizeIndex))) {
					totalPrizeNum++;
					prizeMsg[totalPrizeNum] = '恭喜你获得7-11十元消费券，稍后发至预留手机号，请留意查收！<br>';
					sAlert('恭喜你获得7-11十元消费券，稍后发至预留手机号，请留意查收！<br>');
					totalPrizeTwo++;
				}
				//获一等奖
				else if (m1_rslt==prizeIndex && m2_rslt==prizeIndex && m3_rslt==prizeIndex) {
					totalPrizeNum++;
					prizeMsg[totalPrizeNum] = '恭喜你获得钻石世家钻石腕表，稍后专人联系你领奖，手机要保持畅通哦！<br>';
					sAlert('恭喜你获得钻石世家钻石腕表，稍后专人联系你领奖，手机要保持畅通哦！<br>');
					totalPrizeOne++;
				}
				//没获奖
				else {
					//alert("很遗憾，没中奖！");
					sAlert("再来，继续努力喔！");
				}
				break;
		}
	}

	//抽奖按钮
	$("#slotMachineButton1").click(function(){
		if(res_times>0){
			machine1.shuffle(3, onComplete);
			
			setTimeout(function(){
				machine2.shuffle(3, onComplete);
			}, 800);
			
			setTimeout(function(){
				machine3.shuffle(3, onComplete);
			}, 1600);
			
			res_times -= 1;
			$('#times').html(res_times);
			
			if(res_times<=0) {
				setTimeout(function(){
					share();
					$('.view').on('click', '.cover', function () {
						$('.cover').remove();
					})
				}, 4400);
			}
		}else if(res_times<=0) {
			sAlert("再玩一遍，赢大奖！");
			share();
			$('.view').on('click', '.cover', function () {
				$('.cover').remove();
			})
		}
	})
	wxshare();

	function share() {
		var temp = '<div class="cover"><img src="http://7xkg1m.com2.z0.glb.qiniucdn.com/share.png"/></div>';
		$('.view').append(temp);
		$('.cover').css('height', window.innerHeight);
	}
	//分享多抽一次按钮
	$('#share').on('click', function () {
		share();
	})
	$('.view').on('click', '.cover', function () {
		$('.cover').remove();
	})
	
	

	//填资料赢奖品按钮
	$('#getPrize').on('click',function(){
		var temPrize = totalPrizeOne + totalPrizeTwo + totalPrizeThree;
		if(temPrize > 0){
			document.getElementsByTagName("body")[0].setAttribute("style","width: 100%; height: 100%; position: absolute; overflow-x: hidden; background: url('http://7xkg1m.com2.z0.glb.qiniucdn.com/submitBg.jpg') no-repeat center; background-size: 100% 100%;")
			$('.view').css('display','none');
			$('#form-box').css('display','block');
			$('#desc').css('display','block');
			$('#form-box form').css('display','block');
		}else {
			sAlert("你没有中奖！");
		}
	});
	
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
		var name = document.getElementById("name").value;
		var phone = document.getElementById("phone").value;

		var name_length = name.replace(/[^\x00-\xff]/g,"**").length;
		if(name_length==0){
			//alert("你输入的姓名为空，请重新输入！");
			sAlert("你输入的姓名为空，请重新输入！");
			return false;
		}
		if(name_length>16){
			//alert("至多输入16个字符或8个中文汉字！");
			sAlert("至多输入16个字符或8个中文汉字！");
			name = name.substring(0,16);
			return false;
		}
		
		if(validatemobile(phone)==true){
			$.ajax({
				type: "post",
				url: "prize.php",
				dataType: "json",
				data: {
					prizeOne: totalPrizeOne,
					prizeTwo: totalPrizeTwo,
					prizeThree: totalPrizeThree,
					prizeThreeType: prizeThreeType,
					name: name,
					phone: phone
				},
				async: false,
				cache: false,
				success: function () {
					
					/*console.log('success');
					
					
					var arr1 = [];
					var finalStr = '';
					var threeArr = [
						'恭喜你获得佐登妮丝3折优惠券，持太阳信用卡消费即享折扣！<br>',
						'恭喜你获得至尊用车“日租金8.5折”优惠，持太阳信用卡消费即享折扣！<br>',
						'恭喜你获得南海渔村9折优惠，持太阳信用卡消费即享折扣！<br>',
						'恭喜你获得堂会KTV房费9折优惠，持太阳信用卡消费即享折扣！<br>'
					];
					for(var i=0; i<totalPrizeThree; i++){arr1[i] = threeArr[prizeThreeType[i]];}
					
					var arr2 = [];
					while(totalPrizeOne){
						arr2.push('恭喜你获得钻石世家钻石腕表，稍后专人联系你领奖，手机要保持畅通哦！<br>');
						totalPrizeOne--;
					}
					while(totalPrizeTwo){
						arr2.push('恭喜你获得7-11十元消费券，稍后发至预留手机号，请留意查收！<br>');
						totalPrizeTwo--;
					}
					
					arr2 = arr2.concat(arr1);
					for(var j=0; j<arr2.length; j++){
						var tempNum = j+1;
						finalStr += tempNum + ". " + arr2[j];
					}
					
					//输出获奖信息
					ssAlert(finalStr);
					*/
				},
				fail: function (e) {}
			});
		
			ssAlert('提交成功！');
		}		
	}

	$('#submit').on('click', function() {
		infosubmit();
	});
});
</script>

</head>

<body style="width: 100%; height: 100%; position: absolute; overflow-x: hidden; background: url('http://7xkg1m.com2.z0.glb.qiniucdn.com/prizeBg.jpg') no-repeat center; background-size: 100% 100%;">
<div class="view">
	<!--<audio src="begin.mp3" loop="loop" id="music"></audio>-->

	<div id="reserve" style="clear:both; position:absolute; width:100%; height:30px; line-height:30px; top:19%; padding:0px;">
		<span id="times" style="display:block; width:80px; height:30px; line-height:30px; margin:0 auto; background:#0090db; border-radius:5px; color:#c0ebff; font-size:1.5em; font-weight:bolder; text-align:center;">3</span>
	</div>

	<div class="line">
		<div class="content" style="clear:both; position:absolute; width:200px; height:100px; top:28%; left:50%; margin-left:-100px; border-radius:5px; background:#78daff; text-align:center;">

			<div style="clear: both; position:relative; top:5px; left:0px;">
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

<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan style='display:none;' id='cnzz_stat_icon_1255852946'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/z_stat.php%3Fid%3D1255852946' type='text/javascript'%3E%3C/script%3E"));</script>
</body>
</html>