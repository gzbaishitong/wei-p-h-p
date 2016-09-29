// jshint devel:true
$(document).ready(function(){
	// 开始游戏
$("#begin").click(function(event) {
	/* Act on the event */
	$("#page1").css('display','none');
});

// 录入信息
$('#default,#mywords').click(function(event) {
	/* Act on the event */
	$(this).css('display','none');
	$('.popUp').css('display', 'block');
	//popup
var popUpH = window.innerWidth*0.75;
$('#words').css('height',popUpH)
	
});

var words = '';
$('.finish').click(function(event) {
	/* Act on the event */
	if($('#words').val()){
		words = $('#words').val();
		$('.popUp').css('display', 'none');
		$('#mywords').html(words).css('display', 'block');
		$('#frl').show();
		$('#tol').show();
		$('#from').show();
		$('#to').show();
	}else{
		alert("请先填写你要对ta说的话哦！")
	}
});

//确定文字
var fromW = '';
var toW = '';
var mywords = '';
var imgSelected = '';
$('#submit').click(function(event) {
	$('#page3').css('display','block')
	/* Act on the event */
	if($('#mywords').html()){
		mywords = $('#mywords').html();
		$.each($('.swiper-slide'),function(){
			if($(this).hasClass('swiper-slide-active')){
				imgSelected = $(this).children('.main').attr('src');
			}
		});
		fromW = $('#from').val()
		toW = $('#to').val()
        console.log(toW);
		$('#page2').css('display', 'none');
		$('.content img').attr('src',imgSelected);
	}else{
		alert("请先填写你要对ta说的话哦！")
	}
});

//mingxianpian

$('.swiper-button-next').click(function(){
	if($('.swiper-slide-active .main').attr('alt') == 1){
		$('#default').attr('src','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/defaultwords.png')
	}
	if($('.swiper-slide-active .main').attr('alt') == 2){
		$('#default').attr('src','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/guimiwords.png')
	}
	if($('.swiper-slide-active .main').attr('alt') == 3){
		$('#default').attr('src','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/aimeiwords.png')
	}
	if($('.swiper-slide-active .main').attr('alt') == 4){
		$('#default').attr('src','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/lianrenwords.png')
	}
	if($('.swiper-slide-active .main').attr('alt') == 5){
		$('#default').attr('src','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/lianrenwords.png')
	}
})


$('.swiper-button-prev').click(function(){
	if($('.swiper-slide-active .main').attr('alt') == 1){
		$('#default').attr('src','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/lianrenwords.png')
	}
	if($('.swiper-slide-active .main').attr('alt') == 5){
		$('#default').attr('src','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/aimeiwords.png')
	}
	if($('.swiper-slide-active .main').attr('alt') == 4){
		$('#default').attr('src','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/guimiwords.png')
	}
	if($('.swiper-slide-active .main').attr('alt') == 3){
		$('#default').attr('src','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/defaultwords.png')
	}
	if($('.swiper-slide-active .main').attr('alt') == 2){
		$('#default').attr('src','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/lianrenwords.png')
	}
})

//change
var changeIndex = 0;
var contentWord = $('<p id="contentWord"></p>')
var fromWord=$('<p id="fromWord"></p>')
var toWord=$('<p id="toWord"></p>')
$('.change').click(function(event) {
	/* Act on the event */
	if(changeIndex==0){
		contentWord.html(mywords); 
		fromWord.html('From:'+toW)
		toWord.html('To:'+fromW)
		$('.content img').attr('src','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/6.png')
		changeIndex = 1;
		$('.content').append(contentWord);
		$('.content').append(fromWord);
		$('.content').append(toWord);
	}else{
		$('.content img').attr('src',imgSelected)
		changeIndex = 0;
		$('.content').children('p').remove();
	}
});
// swiper
var mySwiper = new Swiper ('.swiper-container', {
    direction: 'horizontal',
    loop: true,
    
    // 如果需要前进后退
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
    
  }) 
//xiugai
$('#xiugai').click(function(event) {
	/* Act on the event */
	$("#page3").css('display','none');
	$("#page2").css('display','block');
});

//send
var question ='';
var answer = '';
$('#send').click(function(event) {
	/* Act on the event */
	if(!($('#question').val())){
		alert('您的问题还没输入哦！')
		return false
	}
	if(!($('#answer').val())){
		alert('给您的卡加个密码吧！')
		return false
	}
	question=$('#question').val();
	answer=$('#answer').val();
	
	//wxShare();
	
	var text = encodeURI(mywords);
	var question = encodeURI(question);
	var answer = encodeURI(answer);
	var img = encodeURI(imgSelected);
	var fromS = encodeURI(fromW);
	var toS = encodeURI(toW);
	console.log(fromS)
	console.log(toS)
	wx.ready(function () {
		wx.onMenuShareAppMessage({
		  title: '考验真爱的时候到了！据说只有懂我的人才能看到哦~',
		  desc: '嘘~我刚才发了一段悄悄话。据说打开的人都是喜欢我的。。。',
		  link: 'http://kf.gzbaishitong.com/games/sweet/answer.php?question='+question+'&answer='+answer+'&img='+img+'&text='+text+'&fromS='+fromS+'&toS='+toS,
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
		  link: 'http://kf.gzbaishitong.com/games/sweet/answer.php?question='+question+'&answer='+answer+'&img='+img+'&text='+text+'&fromS='+fromS+'&toS='+toS,
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
	//alert('你的爱的明信片已经准备好了，点击菜单右上角分享给你爱的人吧！')
	$('#sharePop').css('display','block');
	$('#sharePop').click(function(){
		$('#sharePop').css('display','none');
	});
	
});
}
)




