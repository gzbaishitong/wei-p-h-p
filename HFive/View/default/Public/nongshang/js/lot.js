$(document).ready(function(){	
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

		var title = document.createElement('div');
		title.style.position = "absolute";
		title.style.width = "45%";
		title.style.zIndex = "1000000";
		title.style.top = "100%";
		title.style.left = "27%";
		title.style.marginTop = 150+'px';

		document.body.appendChild(msgObj);
		document.body.appendChild(title);
		msgObj.appendChild(img);
		document.getElementById("msgDiv").appendChild(title);
		
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

		var title = document.createElement('div');
		title.style.position = "absolute";
		title.style.width = "45%";
		title.style.zIndex = "1000000";
		title.style.top = "100%";
		title.style.left = "27%";
		title.style.marginTop = 150+'px';

		document.body.appendChild(msgObj);
		document.body.appendChild(title);
		msgObj.appendChild(img);
		document.getElementById("msgDiv").appendChild(title);
		
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

				//三等奖
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
				//二等奖
				else if(((m1_rslt==prizeIndex && m2_rslt==prizeIndex)&&(m3_rslt!=prizeIndex)) || ((m1_rslt==prizeIndex && m3_rslt==prizeIndex)&&(m2_rslt!=prizeIndex)) || ((m2_rslt==prizeIndex && m3_rslt==prizeIndex)&&(m1_rslt!=prizeIndex))) {
					totalPrizeNum++;
					prizeMsg[totalPrizeNum] = '恭喜你获得7-11十元消费券，稍后发至预留手机号，请留意查收！<br>';
					sAlert('恭喜你获得7-11十元消费券，稍后发至预留手机号，请留意查收！<br>');
					totalPrizeTwo++;
				}
				//一等奖
				else if (m1_rslt==prizeIndex && m2_rslt==prizeIndex && m3_rslt==prizeIndex) {
					totalPrizeNum++;
					prizeMsg[totalPrizeNum] = '恭喜你获得钻石世家钻石腕表，稍后专人联系你领奖，手机要保持畅通哦！<br>';
					sAlert('恭喜你获得钻石世家钻石腕表，稍后专人联系你领奖，手机要保持畅通哦！<br>');
					totalPrizeOne++;
				}
				//没获奖
				else {
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
		   sAlert("请输入手机号码！");
		   return false;
		}    
		
		var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
		if(!myreg.test(mobile))
		{
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
			sAlert("你输入的姓名为空，请重新输入！");
			return false;
		}
		if(name_length>16){
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