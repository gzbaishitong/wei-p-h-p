function preloadimages(arr){   
    var newimages=[], loadedimages=0
    var postaction=function(){}  //此处增加了一个postaction函数
    var arr=(typeof arr!="object")? [arr] : arr
    function imageloadpost(){
        loadedimages++
        if (loadedimages==arr.length){
            postaction(newimages) //加载完成用我们调用postaction函数并将newimages数组做为参数传递进去
        }
    }
    for (var i=0; i<arr.length; i++){
        newimages[i]=new Image()
        newimages[i].src=arr[i]
        newimages[i].onload=function(){
            imageloadpost()
        }
        newimages[i].onerror=function(){
            imageloadpost()
        }
    }
    return { //此处返回一个空白对象的done方法
        done:function(f){
            postaction=f || postaction
        }
    }
}

preloadimages(["img/new/bg.jpg", "img/new/light.png", "img/new/lightbox.png", "img/new/star.png", 
"img/new/begin-button.png", "img/new/rulesBtn.png", "img/new/personalBtn.png", "img/new/rules.png", 
"img/new/checkBg.jpg", "img/new/input2.png", "img/new/shareTo.jpg"]).done(function(images){
	document.getElementById('spinner').style.display ='none';
	document.getElementById('bg').style.display = "block";
});


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
	img.setAttribute('src', 'img/new/popUp.png');
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
	img.setAttribute('src', 'img/new/popUp.png');
	img.style.position = "absolute";
	img.style.width = "100%";
	img.style.top=0;
	img.style.left=0;
	img.style.zIndex = "1000000";

	var img2 = document.createElement('img');
	img2.setAttribute('src','img/new/confirm.png');
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
	window.location.href="quiz/index2.html";
};

document.getElementById("personal").onclick = function(){
	document.getElementById('submitBg').style.display = 'block';
	document.getElementById('form-box').style.display = 'block';
};

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
				if(finalStr == ''){finalStr = "暂未获得优惠券，继续答题赢取抽奖机会吧！";}
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
//document.getElementById('bg').style.height = winH +"px";
document.getElementById('rulesContent').style.height = winH +'px';

/*var distance = 150/1010*winH;

document.getElementById('begin').style.bottom = distance + "px";
document.getElementById('rules').style.bottom = distance + "px";
document.getElementById('personal').style.bottom = distance + "px";*/