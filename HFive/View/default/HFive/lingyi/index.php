<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>御宅神部落</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" id="viewport"/>
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" href="weui.css">
	<link rel="stylesheet" href="jquery-weui.css">
	<link rel="stylesheet" href="main.css?v=1"/>

	<script src="jquery-2.1.4.js"></script>
	<script src="jquery-weui.js"></script>

	
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
//wx share
var title = '恐怖漫画《微信红包》看完你还敢抢红包吗......';
var url = "http://mp.weixin.qq.com/s?__biz=MzA3NTU4MDkwMg==&mid=403086539&idx=1&sn=e2947ede29cb4eae9784c2b8c4349a92&scene=1&srcid=03027teLVoyXKQMI1rycqXgI#wechat_redirect"
	
	wx.config({
		debug: false,
		appId: '',
		timestamp: '',
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
	
	function wxshare(){
		wx.ready(function () {
			wx.onMenuShareAppMessage({
			  title: '恐怖漫画《微信红包》~有些红包不要轻易拿',
			  desc: '未完待续，点击阅读原文，揭晓结局！',
			  link:url,
			  imgUrl: 'http://kf.gzbaishitong.com/games/lingyi/1.jpg',
			  trigger: function (res) {
			  },
			  success: function (res) {
				  window.location = "http://kf.gzbaishitong.com/games/lingyi/share.html"
			  },
			  cancel: function (res) {
			  },
			  fail: function (res) {
			  }
			});

			wx.onMenuShareTimeline({
			  title: title,
			  desc: title,
			  link: url,
			  imgUrl: 'http://kf.gzbaishitong.com/games/lingyi/1.jpg',
			  trigger: function (res) {
			  },
			  success: function (res) {
				  window.location = "http://kf.gzbaishitong.com/games/lingyi/share.html"
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


</head>

<body>
<div class="page ">
    <section class="entry">
        <div class="entry-page">
            <header>
                <div class="news-title js-title">
                   恐怖漫画《微信红包》看完你还敢抢红包吗......           </div>
                <div class="entry-meta">
					<!--<span class="meta original_tag js-original_tag"></span>  -->                  <em class="meta meta_text js-date">2016-02-22 初号机</em>
                                        <a class="meta meta_nickname js-nickname" href="javascript:;">御宅神部落</a>
					<!--点击公众号-->
					<script type="text/javascript">
						$('.js-nickname').on('click',function(e){
							$.modal({
								title: "长按识别二维码  关注御宅神部落",
								text:"<img width='256px' height='256px' src='erweima.jpg' />"
							});
						});

					</script>
                </div>
            </header>
            <div class="entry-content js-content">
				<p>想知道作者的脑洞有多大，立即分享到朋友圈看结局，看以后还敢不敢给乱抢红包！
</p>			</div>
<div id="share" style="color:red">点击这里分享</div>
            <div class="views">
                <div class="meta_primary tips_global">
                    阅读
                    <span id="readnum" class="js-readnum">100000+</span>
                </div>
                <div class="meta_primary tips_global meta_praise">
                    <i class="icon_praise_gray praised"></i>
                    <span class="praise_num js-praisednum" id="likeNum">649</span>
                </div>
                <a href="javascript:;" class="meta_extra tips_global">举报</a>
            </div>
        </div>
        <div class="comments">
            <!--广告-->
			

			<!--留言头部-->
						<header>
				<!--精选留言-->
                <div class="comment-title rich_tips with_line title_tips discuss_title_line">
                    <span class="tips">精选留言</span>
                </div>
                <!--<p class="tips_global tc title_bottom_tips">关注该公众号可参与留言</p>-->
                <!--写留言-->
				            </header>
            <!--留言列表-->
            <div class="comment-list">
                <ul class="discuss_list">
										<li class="discuss_item" >
						<div class="discuss_opr">
                                    <span class="media_tool_meta tips_global meta_praise js_comment_praise " >
                                        <i class="icon_praise_gray"></i>
                                        <span class="praise_num">2415</span>
                                    </span>
						</div>
						<div class="user_info">
							<strong class="nickname">美少女战士 </strong>
							<img class="avatar" src="http://www.wx.3sure.cn/attachment/images/12/2016/02/Glk2KdwhWwW22DKpW7Lyp229ZhTW9D.jpg">
						</div>
						<div class="discuss_message">
							<span class="discuss_status"></span>
							<div class="discuss_message_content">
								可怕的结局，再也不敢抢红包了呜呜~							</div>
						</div>
						<p class="discuss_extra_info"> 12分钟前 
							<!--<a class="discuss_del js_del" href="javascript:;" >删除</a>-->
						</p>
												<div class="reply_result">
							<div class="nickname">作者回复</div>
							<div class="discuss_message">
								<div class="discuss_message_content">
									作者脑洞不要太大							</div>
							</div>
							<p class="discuss_extra_info">1分钟前 
								<!--<a class="discuss_del js_del" href="javascript:;" >删除</a>-->
							</p>
						</div>
											</li>
										<li class="discuss_item" >
						<div class="discuss_opr">
                                    <span class="media_tool_meta tips_global meta_praise js_comment_praise " >
                                        <i class="icon_praise_gray"></i>
                                        <span class="praise_num">453</span>
                                    </span>
						</div>
						<div class="user_info">
							<strong class="nickname">Siently </strong>
							<img class="avatar" src="http://www.wx.3sure.cn/attachment/images/7/2016/02/CnyNsWVUW3gshhnDG5n5VdZnVRrsD6.jpg">
						</div>
						<div class="discuss_message">
							<span class="discuss_status"></span>
							<div class="discuss_message_content">
								看得我脊梁发凉							</div>
						</div>
						<p class="discuss_extra_info"> 4分钟前 
							<!--<a class="discuss_del js_del" href="javascript:;" >删除</a>-->
						</p>
												<div class="reply_result">
							<div class="nickname">作者回复</div>
							<div class="discuss_message">
								<div class="discuss_message_content">
									小编也是~							</div>
							</div>
							<p class="discuss_extra_info">1分钟前 
								<!--<a class="discuss_del js_del" href="javascript:;" >删除</a>-->
							</p>
						</div>
											</li>
					                </ul>
                <div class="rich_tips with_line tips_global">
                    <span class="tips">以上留言由公众号筛选后显示</span>
                </div>

                <p class="rich_split_tips tc" id="js_cmt_qa" style="display: block;">
                    <a href="http://kf.qq.com/touch/sappfaq/150211YfyMVj150313qmMbyi.html?scene_id=kf264">
                        了解留言功能详情
                    </a>
                </p>
            </div>
			        </div>
    </section>
</div>

<footer id="footer">
    <!--<section class="action">
        <div class="weui_btn" >分享到朋友圈看结局</div>
    </section>-->
    <!--<img src="footer.jpg?v=1" alt="">-->
</footer>

<script>
	var footer = $('#footer');
	var footer_offsetTop = footer.offset().top;
	var view_height = $(window).height();

	if(footer_offsetTop < view_height){
		var mg_top = view_height - footer_offsetTop + 25 ;
		footer.css('margin-top',mg_top+'px');
	}
    
	$("#share").click(function(){
		var newDiv = $("<div class='wrap' style='position:absolute;top:0;left:0;background:rgba(0,0,0,.7);width:100%;height:100%;z-index:100'><p style='color:white;position:absolute;top:12%;left:26%;font-weight:bold'>分享后继续看漫画~</p><div style='position:absolute;top:0;right:0;width:37%'><img src='timg.png' width='100%'/></div></div>")
		$("body").append(newDiv);
		$('.wrap').height($('body').height())
	})
</script>
	</body>
</html>
