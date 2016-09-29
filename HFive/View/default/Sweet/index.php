<!doctype html>
<html class="no-js" lang="">
  <head>
    <meta charset="utf-8">
    <title>KisKis甜言密语</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="stylesheet" href="{:ADDON_PUBLIC_PATH}/sweet/styles/swiper3.08.min.css">
    <link rel="stylesheet" href="{:ADDON_PUBLIC_PATH}/sweet/styles/main.css">
	<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="{:ADDON_PUBLIC_PATH}/sweet/scripts/fastclick.js"></script>
    <script src="{:ADDON_PUBLIC_PATH}/sweet/scripts/swiper.min.js"></script>
    <script src="{:ADDON_PUBLIC_PATH}/sweet/scripts/main.js"></script>
	<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script>
	 wx.config({
        debug: false,
        appId: '{$signPackage["appId"]}',
        timestamp: '{$signPackage["timestamp"]}',
        nonceStr: '{$signPackage["nonceStr"]}',
        signature: '{$signPackage["signature"]}',
        jsApiList: [
            'onMenuShareTimeline','onMenuShareAppMessage'
        ]
    });

	wx.ready(function () {
		wx.onMenuShareAppMessage({
		  title: '考验真爱的时候到了！据说只有懂我的人才能看到哦~',
		  desc: '你最重要的人发来一段甜言“密”语，赶紧听听吧！',
		  link: 'http://addon.gzbaishitong.com/weiphp/index.php?s=/addon/HFive/Sweet/index',
		  imgUrl: 'http://o9z6un8mv.bkt.clouddn.com/share1.jpg',
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
	
		  link: 'http://addon.gzbaishitong.com/weiphp/index.php?s=/addon/HFive/Sweet/index',
		  imgUrl: 'http://o9z6un8mv.bkt.clouddn.com/share1.jpg',
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
    <div id="loading">
      <img src="images/loading.jpg" alt="">
    </div>
    <script>
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

 preloadimages(['http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/begin.png','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/page1.jpg',
	'http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/page2.jpg','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/1.png','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/2.png','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/3.png','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/4.png','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/5.png',
	'http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/defaultwords.png','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/aimeiwords.png','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/lianrenwords.png','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/guimiwords.png','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/aimei.png','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/anlian.png','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/guimi.png','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/lianren.png','http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/textarea.png']).done(function(images){
   $('#loading').css('display','none')
})
	</script>
     <!-- page1 -->
    <div id="page1">
      <img src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/page1.jpg" alt="">
      <div id="begin">
        <img src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/begin.png" alt="">
      </div>
    </div> 
    <!-- page2 -->
    <div id="page2">
      <img src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/page2.jpg" alt="" style="width:100%;height:100%">
      <div class="swiper-container">
          <div class="swiper-wrapper">
              <div class="swiper-slide">
				<img src='http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/qinglv.png' class='top-title'>
                <img src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/1.png" alt="1" class='main'>
              </div>
              <div class="swiper-slide">
				<img src='http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/anlian.png' class='top-title'>
                <img src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/2.png" alt="2" class='main'>>
              </div>
              <div class="swiper-slide">
				<img src='http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/guimi.png' class='top-title'>
                <img src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/3.png" alt="3" class='main'>>
              </div>
              <div class="swiper-slide">
				<img src='http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/aimei.png' class='top-title'>
                <img src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/4.png" alt="4" class='main'>>
              </div>
              <div class="swiper-slide">
				<img src='http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/qinglv.png' class='top-title'>
                <img src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/5.png" alt="5" class='main'>>
              </div>
          </div>
          <!-- 如果需要分页器 -->
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
        </div>

        <div class="mingxingpian">
          <img src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/6.png" alt="" style="width:100%;height:100%">
          <img src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/lianrenwords.png" alt="" id="default">
          <p id="mywords"></p>
		  <label id="tol" style="position:absolute;top:34%;left:5%;display:none;color: #794e21;
    font-weight: bold;">To:</label>
		  <input type="text" id="from" style="position:absolute;top:33%;left:12%;border:1px solid transparent;background:transparent;color: #794e21;
    font-weight: bold;font-size:12px;display:none" placeholder='输入对方的名字'/>
		  <label id="frl" style="position:absolute;bottom:8%;left:10%;display:none;color: #794e21;
    font-weight: bold;">From:</label>
		  <input type="text" id="to" style="position:absolute;bottom:8%;left:22%;border:1px solid transparent;background:transparent;color: #794e21;
    font-weight: bold;font-size:12px;display:none" placeholder='输入自己的名字'/>
        </div>

        <div class="popUp">
          <div class="logo">
            <img src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/logo.png" alt="">
          </div>
          <textarea name="words" id="words" placeholder="输入你要对ta说的话" require="required" autofocus="autofocus" style="background:url('http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/textarea.png') top left no-repeat;background-size:cover">输入你要对ta说的话
		  </textarea>
		  
		 <!--<input type="text" id="from" style="position:absolute;top:35%;left:20%;border:1px solid transparent"/>
		  <input type="text" id="to" style="position:absolute;bottom:28%;right:20%;border:1px solid transparent"/>-->
          <div class="finish">
            <img src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/submit.png" alt="">
          </div>
        </div>

        <div id="submit">
          <img src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/submit.png" alt="">
        </div>
    </div>
    <!--page3-->
    <div id="page3">
      <img src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/page3.jpg" alt="">
      <div class="content">
            <img src="" alt="">
      </div>

      <div class="change">
        <img src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/change.png" alt="">
      </div>

      <div class="core">
        <div class="question">
          <img src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/question.png" alt="">
          <input type="text" id='question' placeholder="在这里输入保密问题">
        </div>
        <div class="answer">
          <img src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/answer.png" alt="">
          <input type="text" id='answer' placeholder="在这里输入问题答案">
        </div>
      </div>

      <div id="xiugai">
        <img src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/xiugai.png" alt="">
      </div>

      <div id="send">
        <img src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/send.png" alt="">
      </div>
    </div> 

	<!--分享提示层-->
	<div id="sharePop">
		<img src="http://addon.gzbaishitong.com/weiphp/Uploads/Download/sweet/images/lh/share_pop.png" width="100%" height="100%" />
	</div>
    

    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <script>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='https://www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
      ga('create','UA-XXXXX-X');ga('send','pageview');
    </script>

	<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan style='display:none;' id='cnzz_stat_icon_1256008039'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/z_stat.php%3Fid%3D1256008039' type='text/javascript'%3E%3C/script%3E"));</script>
  </body>
</html>
