var SCORE = 0;
var REQ = false;
var toGameLoop = true;

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

preloadimages(["http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/again.png","http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/bg.jpg","http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/boy.png","http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/btn-rank-close.png","http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/gamebg.jpg","http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/gameover.png",
"http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/indexBg.png","http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/input.png","http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/lv.jpg","http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/lv.png","http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/mine.png","http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/rank.png","http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/rank_ul.png","http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/rankbg.png",
"http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/rule.png","http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/rulePage.png","http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/score.png","http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/scoreNum.png","http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/scoreRank.png","http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/start.png","http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/submit.png",
"http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/tt.jpg","http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/zombieCh.png","http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/zombieEn.png"
 ]).done(function(images){
	$('#loading').css('display','none');
});

!function(){
	$("#my-score-text p span").html(myscore);
	
	// 定义用到的对象
	var b = {
		index:$("#index"),
		btnPlay:$("#btn-play"),
		btnRank:$("#btn-rank"),
		btnRule:$("#btn-rule"),
		btnRankClose:$("#btn-rank-close"),
		btnRuleClose:$("#btn-rule-close"),
		box:$("#box"),
		room:$("#room"),
		rank:$("#rank"),
		rule:$("#rule"),
		btnScore:$("#btn-score"),
		scoreTip:$("#scoreTip"),
		btnScoretipClose:$("#btn-scoreTip-close"),
		btnSubmit:$("#btn-submit"),
		btnAgain:$("#btn-again"),
		btnGetRank:$("#btn-scoreRank"),
		gameover:$("#gameover"),
		inputPhone:$("#input-phone"),
		phoneNum:$("#phone-num"),
		volume:$("#volume"),
		audio:document.getElementById("bgmp3")
	},
	ua = window.navigator.userAgent.toLowerCase(),
	isAndroid = /android/i.test(ua),
	isIOS =/iphone|ipad|ipod/i.test(ua),
	clickEvent,myApp;

	// 游戏逻辑
	app = {
		init:function(){
			this.initEvent();
			this.loading();
		},

		loading:function(){

		},

		render:function(){},

		initEvent:function(){
			clickEvent = "onTouchStart" in document.documentElement ? "touchstart" : "click",
			myApp = this;//将this赋予myApp
			b.volume.on(clickEvent,function(){
				if(b.audio.paused){
					b.audio.play();
					b.volume.css("background-image","url('http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/volume.png')");
					return;
				}
				b.audio.pause();
				b.volume.css("background-image","url('http://addon.gzbaishitong.com/weiphp/Uploads/Download/jiangshi/img/volume_click.png')");
			});
			b.btnPlay.on(clickEvent,function(){
				b.index.hide();
				b.box.show();
				Game.init(b.room,myApp);
			});
			b.btnRank.on(clickEvent,function(){
				$.ajax({
					url: '{:ADDON_PUBLIC_PATH}/jiangshi/php/get_score.php',
					type: 'POST',
					dataType: 'json',
					data: {type:"rank"},
				}).done(function(res) {
					//alert(res);
					//alert(res[1].nickname+","+res[1].headurl+","+res[1].score);
					for(var i = 0; i < 10; i++){
						if(res[i].score != ''){
							$("#rank-wrapper").append("<ul class='rank-ul'><li class='rank-num'></li><li class='rank-photo'><img src='' /></li><li class='rank-username'></li><li class='rank-bestscore'></li></ul>");
							$(".rank-num").eq(i).html(i+1);
							$(".rank-photo img").eq(i).attr("src",res[i].headurl);
							$(".rank-username").eq(i).html(res[i].nickname);
							$(".rank-bestscore").eq(i).html(res[i].score+"分");
						}
					}
				});
				b.rank.show();
				b.btnRankClose.on(clickEvent,function(){
					b.rank.hide();
					$(".rank-ul").remove();
				});
			});
			b.btnRule.on(clickEvent,function(){
				b.rule.show();
				b.btnRuleClose.on(clickEvent,function(){
					b.rule.hide();
				})
			});

			if(isplayed == 1){
				b.inputPhone.css("display","none");
			}
			b.btnScore.on(clickEvent,function(){
				b.scoreTip.show();
				b.btnScoretipClose.on(clickEvent,function(){
					b.scoreTip.hide();
				});
			});
			b.btnSubmit.on('click',function(){
				//alert(111);
				var phone = '';
				phone = b.phoneNum.val();
				console.log(phone);
				var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;
				if (reg.test(phone) || isplayed == 1) {
				/* 	$.ajax({
						url: '{:ADDON_PUBLIC_PATH}/jiangshi/php/get_score.php',
						type: 'POST',
						dataType: 'json',
						data: {openid: OPENID,phone: phone,score:SCORE,type:"save"},
					}).done(function(res) {
						//alert("提交成功~");
						alert(res.msg);
					}); */
					alert('号码提交成功');
					location.href=location.href;
				}else{
				  alert("号码有误~");
				};
			});
			b.btnAgain.on('click',function(){
				location.href=location.href;
			})
			//this.weixinEvent();
		}/*,

		weixinEvent:function(){
			wx.config({
				debug: true,
				appId: appId,
				timestamp: timestamp,
				nonceStr: noceStr,
				signature: signature,
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
				wx.onMenuShareAppMessage({
				  title: '万圣节打僵尸，领长隆欢乐世界门票~',
				  desc: '不要打错小女孩了哦！',
				  link: 'http://kf.gzbaishitong.com/games/JiangShi/index.php',
				  imgUrl: 'http://kf.gzbaishitong.com/games/JiangShi/img/tt.jpg',
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
				  title: '万圣节打僵尸，领长隆欢乐世界门票~',
				  desc: '不要打错小女孩了哦！',
				  link: 'http://kf.gzbaishitong.com/games/JiangShi/index.php',
				  imgUrl: 'http://kf.gzbaishitong.com/games/JiangShi/img/tt.jpg',
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
			
		}*/

	}
	app.init();
}()