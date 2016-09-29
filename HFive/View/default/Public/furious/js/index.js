
var land2 = function(){
	var _this = this;
	_this.init();
}
land2.prototype = {
	init:function(){
		var _self = this;
		_self.loadimg();
	},
	loadimg:function(){
		var _self = this;
		var imgarr = ['http://addon.gzbaishitong.com/weiphp/Uploads/Download/furious/bg.jpg','http://addon.gzbaishitong.com/weiphp/Uploads/Download/furious/bg1.jpg','http://addon.gzbaishitong.com/weiphp/Uploads/Download/furious/begin.png','http://addon.gzbaishitong.com/weiphp/Uploads/Download/furious/little.png','http://addon.gzbaishitong.com/weiphp/Uploads/Download/furious/big-title.png'];
		new wrLoading('.loading',imgarr,function(){
			_self.start();
		});
	},
	start:function(){
		$(".load_main").fadeOut();
		//console.log('start')
		/*var myAnimation = new TimelineLite();
		myAnimation.from($(".intro .wrapper-cover .t3"), 0.8, {top: '-=100px', alpha:0, ease: Back.easeOut })
		.from($(".intro .t2"), 0.8, { top: '-=100px', alpha:0, scale:0, ease: Back.easeOut }, "-=0.5")
		.from($(".intro .t1"), 0.8, { top: '-=100px', alpha:0, scale:0, ease: Back.easeOut }, "-=0.5")*/
	}
}
$(function(){
	var l = new land2();
})


function progressHandle(progress){
	var loaded = Math.floor(progress * 100);
	$(".progress").html(loaded);
}

//----------------------------------------------------------------------- end loading ------------------------------------------------------------------


var canvas2, stage2, exportRoot, images;

var stage;//canvas stage
var stageWidth, stageHeight;
var timeout, interval, timeNum = 15, gameStart = false;
var score = 0, gameOver = false;
var road1, road2, roadSpeed = 300;
var borderWidth = 55, roadWidth = 170;
var carSpace = [100, 270, 440], roadID = 1;
var timer, propArr = [], speed = 200, frame = 1;


$(document).ready(function(e) {	
	stageWidth = $(window).width();
	stageHeight = $(window).height();
	
	$('.load_main').height(stageHeight);
	$('.countDown').height(stageHeight);
	$('.wrapper').height(stageHeight);
	
	//ͼ
	$('.wrapper-cover').height(stageHeight);
	$('.wrapper-cover').width(stageWidth);
	$('#cover_img').height(stageHeight);
	$('#cover_img').width(stageWidth);
	
	
	$('.gameMain').height(stageHeight);
	$('.result').height(stageHeight);
	$('.share_cont').height(stageHeight);
	
	/*setTimeout(function(){
		$('.intro .wrapper-cover .t3').addClass('effects')
	}, 1300);*/
	
	initObj();
});

function initObj(){
	var canvas = document.getElementById('gameMain');
	canvas.width = stageWidth;
	canvas.height = stageHeight;
	
	stage = new createjs.Stage("gameMain");
	createjs.Touch.enable(stage);
	
	manifest = [
		{src:"http://addon.gzbaishitong.com/weiphp/Uploads/Download/furious/images/road.jpg", id:"road"},
		{src:"http://addon.gzbaishitong.com/weiphp/Uploads/Download/furious/images/p_car.png", id:"p_car"},
		{src:"http://addon.gzbaishitong.com/weiphp/Uploads/Download/furious/images/add_tips.png", id:"add_tips"},
		{src:"http://addon.gzbaishitong.com/weiphp/Uploads/Download/furious/images/car1.png", id:"car1"},
		{src:"http://addon.gzbaishitong.com/weiphp/Uploads/Download/furious/images/car2.png", id:"car2"},
		{src:"http://addon.gzbaishitong.com/weiphp/Uploads/Download/furious/images/watch1.png", id:"watch1"},
		{src:"http://addon.gzbaishitong.com/weiphp/Uploads/Download/furious/images/watch2.png", id:"watch2"}
	];

	loader = new createjs.LoadQueue(false);
	loader.addEventListener("complete", handleComplete);
	loader.loadManifest(manifest);
}

function handleComplete() {
	
	//
	road1 = new createjs.Bitmap(loader.getResult("road"));
	road1.scaleX = road1.scaleY = 2;
	road1.y = 0;
	road2 = new createjs.Bitmap(loader.getResult("road"));
	road2.y = -1138;
	road2.scaleX = road2.scaleY = 2;
	stage.addChild(road1, road2);
	
	
	//ӳ
	var p_carImg = loader.getResult("p_car");
	p_car = new createjs.Shape();
	p_car.graphics.beginBitmapFill(p_carImg).drawRect(0, 0, p_carImg.width, p_carImg.height);
	p_car.x = carSpace[roadID];
	p_car.y = stageHeight;//stageHeight - p_carImg.height;
	p_car.currRoadId = 1;
	stage.addChild(p_car);
	TweenLite.to(p_car, .8, {y:stageHeight - p_carImg.height, delay:0.6})
	
	createjs.Ticker.timingMode = createjs.Ticker.RAF;
	createjs.Ticker.addEventListener("tick", tick);
	
	
	//ֹҳ滬
	$(document).bind("touchstart", function(event){
		event.preventDefault();
	});
	
	//event
$('.begin').on('touchstart', function () {
    gotoga('start')
		//$('.wrapper .logo').fadeOut();
		$('.wrapper .intro .wrapper-cover').fadeOut();
		startGame();
	});
	
	//
$('.again_btn').on('touchstart', function () {
    /*gotoga('again')
		window.location.reload();
	});*/
	startGame();
	
	//ʾ
$('.share_btn').on('touchstart', function () {
    gotoga('share')
		$('.share_cont').fadeIn();
		$('.result').fadeOut();
	});
	
	//رշʾ
	$('.share_cont').bind('touchstart', function(event){
		$(this).fadeOut();
		$('.result').fadeIn();
	})
	
}

function tick(event) 
{
	deltaS = event.delta/1000;
	
	if(gameStart == true){
		
		road1.y = (road1.y + deltaS * roadSpeed);
		road2.y = (road2.y + deltaS * roadSpeed);
		if (road1.y >= stageHeight) { road1.y = -1138; }
		if (road2.y >= stageHeight) { road2.y = -1138; }
		
		//ƶ
		for(var i=0; i<propArr.length;i++)
		{
			propArr[i].y += speed * deltaS;
			
			//ӳƳ
			if(propArr[i].y > stageHeight){
				stage.removeChild(propArr[i]);
			}
			
			//ײ
			if(propArr[i].roadIndex == p_car.currRoadId){
				//ͬһ
				if(Math.abs(p_car.y - propArr[i].y) < 130 && propArr[i].y - p_car.y < 100){
					//console.log('ײ: ' + propArr[i].type);
					if(propArr[i].type == 0){
						//ӣϷ
						gameOverFun();
					}
					else if(propArr[i].type == 1){
						//��ӷ30
						addScore(30);
						stage.removeChild(propArr[i]);
						propArr.splice(i, 1);
						break;
					}
					
				}
			}
		}//end for
		
		if(speed < 1000) speed += 2;//ٶ
		if(speed < 1200) roadSpeed += 3;//ٶ
		
		/*
		rotate = 270 / 1000 * speed - 27;
		$('.wrapper .yibiao .line').css({'-webkit-transform':'rotate(' + rotate + 'deg)'});
		*/
		
		frame ++;
		if(frame % 12 == 0){
			addpro();
		}
	}
	
	stage.update(event);
}

function startGame(){
	var index = 3;
	var interval = setInterval(function(){
		index --;
		if(index > -1) $('.countDown .cont .time').attr('src', "http://addon.gzbaishitong.com/weiphp/Uploads/Download/furious/images/" + index + ".png");
		if(index <= -1){
			$('.countDown').fadeOut();
			clearInterval(interval);
			gameStart = true;
			
			var ty = (stageHeight - 190) * 0.5;
			TweenLite.to(p_car, 4, {y:ty});
			//addpro();
			//onTimer();
		}
	}, 700);
	
	$('.countDown').fadeIn();
	$('.score').fadeIn();
	$('.result .logo').fadeIn();
	//$('.wrapper .yibiao').fadeIn();
	/*$('.intro .wrapper-cover .t3').removeClass('effects')*/
	
	//
	$('.left_btn').on('touchstart',function(){
		if(roadID > 0) roadID --;
		TweenLite.to(p_car, .5, {x:carSpace[roadID]});
		setTimeout(function(){
			p_car.currRoadId = roadID;
		}, 100);
	})
	//
	$('.right_btn').on('touchstart',function(){
		if(roadID < 2) roadID ++;
		TweenLite.to(p_car, .5, {x:carSpace[roadID]});
		setTimeout(function(){
			p_car.currRoadId = roadID;
		}, 100);
	})
}

//ֻ֤
function validatemobile(mobile){
	if(mobile.length==0)
	{
	   alert('请输入手机号码！');
	   document.form1.mobile.focus();
	   return false;
	}    
	if(mobile.length!=11)
	{
		alert('请输入有效的手机号码！');
		document.form1.mobile.focus();
		return false;
	}
	
	var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
	if(!myreg.test(mobile))
	{
		alert('请输入有效的手机号码');
		document.form1.mobile.focus();
		return false;
	}
}

//填电话弹窗显示
function showDiv(){
	document.getElementById('popDiv').style.display='block';
	document.getElementById('bg').style.display='block';
	
	$("#phone").bind('touchstart',
		function() {
			$("#phone")[0].focus(); 
	});
}

//填电话弹窗关闭
function closeDiv(){
	//if(validatemobile(document.getElementById('phone').value))

	document.getElementById('popDiv').style.display='none';
	document.getElementById('bg').style.display='none';
}

//̬加载排行榜数据
function add(data){
	document.getElementById('rankDiv').style.display='block';
	
	var tab1 = document.createElement("div");
	tab1.id="close"; 
	$('#rankDiv').append(tab1);
	
	/*
	var tab2 = document.createElement("div");
	tab2.id="rankInnerDiv"; 
	$('#rankDiv').append(tab2);
	*/
	
	//رаʾ
	var rank = data['rank'];
	$('.pm').text("NO." + rank);
	
	for(var i=1; i<=data['users'].length; i++){
		//$('<li></li>').html('<span class="fir_list">' + i + '</span><span class="sec_list"><img src="' + data['users'][i-1].headimgurl + '" /><p>'+ data['users'][i-1].nickname + '</p></span>' + '</span><span class="thd_list">' + data['users'][i-1].score + '</span>').appendTo('#rankDiv');
		$('<li></li>').html('<span class="fir_list">' + i + '</span><span class="sec_list"><img src="' + data['users'][i-1].headimgurl + '" /><p>'+ data['users'][i-1].nickname + '</p></span>' + '</span><span class="thd_list">' + data['users'][i-1].score + '</span>').appendTo('#rankDiv');
	}
	
	$('#close').on('touchstart', function(event) {
		event.preventDefault();
		document.getElementById('rankDiv').style.display='none';
		/* Act on the event */
	});

}

//获取排行榜请求
function getRank(s,m,o){
	var Rs = s,Rm = m,Ro = o;
	$.ajax({
		type: "post",
		url: "rank.php",
		dataType: "json",
		data: {
			score: Rs,
			phone: Rm,
			openid: Ro
		},
		async: false,
		cache: false,
		success: function (result) {
			var rank = (result.rank == '0' ? 1 : result.rank);

			$('#rankDiv').empty();  //ranDiv
			add(result);

		
		},
		fail: function (e) { }
	});
}
function getRank2(s,o){
	var Rs = s,Ro = o;
	$.ajax({
		type: "post",
		url: "rank.php",
		dataType: "json",
		data: {
			score: Rs,
			openid: Ro
		},
		async: false,
		cache: false,
		success: function (result) {
			var rank = (result.rank == '0' ? 1 : result.rank);

			$('#rankDiv').empty();  //ranDiv
			add(result);

		
		},
		fail: function (e) { }
	});
}

//Ϸ
function gameOverFun() {
	wxshare(score);
	if(hasphone == 1){
		getRank2(score,OPENID);
	}else{
		showDiv();

		//提交
		$('.tijiao').on('touchstart', function () {
			var mobile = document.getElementById('phone').value;
			validatemobile(mobile);
			
			closeDiv();

			getRank(score,mobile,OPENID);
		});
		
		$('.quxiao').on('touchstart', function () {
			closeDiv();
		
			$('.txt2').css('display','none');
			$('.pm').css('display','none');
		});
	}
	
	/*
    var iconurl = 'images/level1.png';
    if (score < 300)
        iconurl = 'images/level1.png';
    else if (score < 500)
        iconurl = 'images/level1.png';
    else if (score < 700)
        iconurl = 'images/level1.png';
    else
        iconurl = 'images/level1.png';

    document.getElementById("icons").src = iconurl;
	*/

    
	gameOver = true;
	clearInterval(interval);
	createjs.Ticker.removeEventListener("tick", tick);
	$('.result').fadeIn();

	
}

//timer
function onTimer(){
	timer = setInterval(function(){
		addpro();
	}, 2000);
	
	addpro();
}

//ӵ
function addpro(){
	var data = [
		{type:1, img:'http://addon.gzbaishitong.com/weiphp/Uploads/Download/furious/images/watch1.png', h:310},
		{type:1, img:'http://addon.gzbaishitong.com/weiphp/Uploads/Download/furious/images/watch2.png', h:310},
		{type:1, img:'http://addon.gzbaishitong.com/weiphp/Uploads/Download/furious/images/watch3.png', h:310},
		{type:0, img:'http://addon.gzbaishitong.com/weiphp/Uploads/Download/furious/images/car1.png', h:180},
		{type:0, img:'http://addon.gzbaishitong.com/weiphp/Uploads/Download/furious/images/car2.png', h:180}
	];
	
	var randomNum = Math.floor(Math.random() * data.length);
	var obj = data[randomNum];	
	var prop = new createjs.Bitmap(obj.img);
	prop.type = obj.type;
	prop.h = obj.h;
	prop.y = -200;
	stage.addChild(prop);
	
	var target0 = [100, 275, 450], target1 = [30, 210, 390];
	randomNum = Math.floor(Math.random() * target0.length);
	prop.roadIndex = randomNum;
	prop.x = obj.type == 0 ? target0[randomNum] : target1[randomNum];//	
	propArr.push(prop);
}


//ӻ
function addScore(value){
	score += value;
	$('.label2').html(score);
	$('.result .sc').html(score);
	
	var tempscore = score;
	
	var tips = new createjs.Bitmap('http://addon.gzbaishitong.com/weiphp/Uploads/Download/furious/images/tips.png');
	tips.x = p_car.x - 30;
	tips.y = p_car.y - 100;
	TweenLite.to(tips, .4, {alpha:0, y:tips.y - 100, delay:0.4, onComplete:function(){ stage.removeChild(tips); }});
	stage.addChild(tips)
}
