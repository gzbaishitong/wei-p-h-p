requirejs.config({
	paths:{
		jquery:"http://cdn.bootcss.com/jquery/2.1.3/jquery",
		scrollFix:"http://ob26aihye.bkt.clouddn.com/scrollFix",
		lunbo:"Components/lunbo",
		swiper:"Components/swiper",
		lazyload:"Components/lazyload"
	},
	map:{
		'*': {
                'css' : 'css.min'
            }
	},
	shim : {
            
		}
})

requirejs(['jquery','lunbo'],function($,lunbo){
	lunbo.default();
	$("#lunbo").lunbo({
		"position":"relative",
		"background":"#d7d8d8"
	})
})

requirejs(['jquery','lazyload'],function($,lazyload){
	$(".mt10").scrollTop(1)
	$("div.lazy").lazyload({
      effect : "fadeIn",
	  threshold:0,
	  container:".mt10"
	});    
})

requirejs(['scrollFix'],function(){
	var scrollable = document.getElementById("hot");
	new ScrollFix(scrollable);
})

requirejs(['jquery'],function(){
	$("#cM").click(
		function(){
			$(".active").removeClass("active")
			$(this).addClass("active")
			$("#decorate").css("left","50%")
			$(".view").removeClass("view")
			$(".moneylist").addClass("view")
	})
	$("#cS").click(
		function(){
			$(".active").removeClass("active")
			$(this).addClass("active")
			$("#decorate").css("left","16%")
			$(".view").removeClass("view")
			$(".scorelist").addClass("view")
	})
	$("#cX").click(
		function(){
			$(".active").removeClass("active")
			$(this).addClass("active")
			$("#decorate").css("left","83%")
			$(".view").removeClass("view")
			$(".secklist").addClass("view")
	})
})

requirejs(['jquery','swiper'],function($,lunbo){
	var banner=new Swiper('#banner .m10',{
        autoplay:3000,
		speed:600,
        loop:true,
        pagination:'.banner-pager'
    });
    var hot=new Swiper('.hot-bd .m10',{
        slidesPerView:3
    })
})

requirejs(['jquery'],function(){
	var panelWidth = $(".fang_div").width();

    $("#hot ul.w50 li").css("height",$("#hot ul.w50 li").css("width"));
	
	$(function(){
        var num = 2;
        var totlenum = $("#pageNum").html();
    var lock_load = false;
    $(window).scroll(function(){
        totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
        if($(document).height() <= totalheight){
            if(totlenum>1 && totlenum>=num){
                if(lock_load==false){
                    loadPage(num);
                }
            }else if(totlenum !=1){
                $('#loading').html('数据加载完毕');
            }

        }
    });
    //关闭顶部提示信息
    $('.btn_notice_close').click(function(){
        $(this).parent().remove();
    })

    function loadPage(){
        lock_load = true;
        $('#loading').show();
        var jsondata='{"p":"'+num+'"}';
        jsondata=$.parseJSON(jsondata);
        $.ajax({
            url:"{:addons_url('Shop://Index/index')}",
            type:'POST',
            dataType:'json',
            data:jsondata,
            success: function(data){
                var html = '';
                $(data).each(function(){
                    html = html+'<a href="'+$(this)[0]['url']+'">'+
                    '<li><div class="fang_div" style="background-image:url('+$(this)[0]['head_img']+')"></div><span class="hot_title">'+
                    '<p class="tit_h"><nobr>'+$(this)[0]['name']+'</nobr></p>'+
                    '<p class="price">￥'+$(this)[0]['true_price']+'</p>'+
                    '<p class="oldprice"><del>￥'+$(this)[0]['old_price']+'</del></p>'+
                    '<div class="detail_btn" style="background-color:#{$shop_config.color}">详情</div>'+
                    '</span></li>'+
                    '</a>';

//<img src="'+$(this)[0]['head_img']+'">

                    // html = html+'<li class="clear pr"><a href="'+$(this)[0]['url']+'" class="w80p db"><span class="image l mr10"><img src="'+$(this)[0]['head_img']+'" alt=""></span><p class="f1-2 pb10">'+$(this)[0]['name']+'</p><del class="c9">￥'+$(this)[0]['old_price']+'</del><p class="price f1-6 fb">￥'+$(this)[0]['true_price']+'</p><p class="c9">已售：'+$(this)[0]['sellnum']+'</p></a> <div class="btn pa"><a href="#" class="add2fav"><img src="{:ADDON_PUBLIC_PATH}/images/icon-fav.png" alt="收藏"></a><a href="#" class="add2car"><img src="{:ADDON_PUBLIC_PATH}/images/icon-car.png" alt="添加到购物车"></a></div></li>'
                })
                num = num + 1;
                //$('#loading').hide();
                $('#plist').append(html);

                $(".fang_div").height(panelWidth);
                lock_load = false;
            },
            error:function(){
                //$('#loading').hide();
                //alert('数据加载失败');
                lock_load=false;
            }
        })
    };
    })
})

requirejs(['jquery'],function(){
	$(".daojishi").each(
		function(i){
			$(this).addClass("daojishi"+i);
			setDaojishi(i)
		}
	)
	function setDaojishi(a){
		var self = $(".daojishi"+a);
		var endTimeCount=self.data("time");
		var NumPro = self.data("inventory");
		if(NumPro>0){
			var nowTime = new Date();
			var endTime = new Date(endTimeCount * 1000);
			var t = endTime.getTime() - nowTime.getTime();
			if(t>0){
				self.css({
					"background":"#c4c5c5",
					"color":"white"
				});
				var timeCount = setInterval(function(){
							var nowTime = new Date();
							var t = endTime.getTime() - nowTime.getTime();
							if(t>=0){
								var d=Math.floor(t/1000/60/60/24);
								var hour=Math.floor(t/1000/60/60%24);
								   var min=Math.floor(t/1000/60%60);
								   var sec=Math.floor(t/1000%60);
								if (hour < 10) {
									 hour = "0" + hour;
								}
								if (min < 10) {
									 min = "0" + min;
								}
								if (sec < 10) {
									 sec = "0" + sec;
								}
								var countDownTime = d+"天"+hour + "时" + min + "分" + sec+"秒后";
								self.html("将于"+countDownTime+"开始");
							}else{
								self.css("background","#fedd30");
								self.html("立即秒杀")	
								clearInterval(timeCount)
							}          
						},1000);
			}else{
				self.css({
					"background":"#fedd30",
					"color":"black"
				});
				self.html("立即秒杀")	
			}
		}else{
			self.css({
					"background":"#c4c5c5",
					"color":"white"
				});
			self.html("秒杀结束")
		}
	}
	
})
	