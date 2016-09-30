requirejs.config({
	paths:{
		jquery:"http://cdn.bootcss.com/jquery/2.1.3/jquery",
		scrollFix:"http://ob26aihye.bkt.clouddn.com/scrollFix",
		promt:"Components/promt",
		lazyload:"Components/lazyload"
	},
	map:{
		'*': {
                'css' : 'css.min'
            }
	},
	shim : {
            'promt': ['css!../style/promt.css'],
		}
})

requirejs(['jquery','promt'],function($,promt){
	$(".button").click(function(){
		var img=$("#globalimg").attr("src");
		var name=$("#globalname").html();
		var text = $("#globalguize").html(); 
		promt.promtNormal(img,name,text);
	})
	$(".level").click(function(){
		var img=$("#globalimg").attr("src");
		var name=$("#globalname").html();
		var text = $("#globaldengji").html(); 
		promt.promtNormal(img,name,text);
	})
})

requirejs(['scrollFix'],function(){
	var scrollable = document.getElementById("scroll");
	new ScrollFix(scrollable);
	var scrollable2 = document.getElementById("mask2-text");
	new ScrollFix(scrollable2);
})

requirejs(['jquery','lazyload'],function($,lazyload){
	$("img.lazy").lazyload({
      effect : "fadeIn",
	  threshold:0
	});
	$("li.lazy").lazyload({
      effect : "fadeIn",
	  threshold:0
	}); 
	$("div.lazy").lazyload({
      effect : "fadeIn",
	  threshold:0
	});
})

requirejs(['jquery'],function($){
var sendredpacks = $("#maskhongbao").data("send")
var addredpack = $("#maskhongbao").data("add");
var nickname = $("#maskhongbao").data("nickname");
var area = $("#maskhongbao").data("area");
if(area != "广东省"){
	$("#getredbag").click(function(){
		alert("本次红包活动仅限广东省内地区微信用户参加。")
	})
	$("#getgreenbag").click(function(){
		alert("本次红包活动仅限广东省内地区微信用户参加。")
	})
}else{
    $("#getredbag").click(function(){
		$(this).attr("id","error")
		$(this).remove()
		$(this).css("backgroundImage","url(http://obmxpqkpi.bkt.clouddn.com/%E7%AB%8B%E5%8D%B3%E9%A2%86%E5%8F%96.gif)")
		$("#load").fadeIn("fast");
        $.post(sendredpacks,{
            method:'新用户领取红包'
        },function(data){
            var info=decodeURIComponent(data.info);//返回红包接口信
            var result_code=stringreplace($(info).find('result_code').html());//返回状态码
            var return_msg=stringreplace($(info).find('return_msg').html());//返回信息
            var re_openid=stringreplace($(info).find('re_openid').html());//用户openid
            var total_amount=stringreplace($(info).find('total_amount').html());//红包金额
            var mch_billno=stringreplace($(info).find('mch_billno').html());//商户订单号
            var mch_id=stringreplace($(info).find('mch_id').html());//商户号
            //发送红包成功
            if(result_code=='SUCCESS') {
				$("#load").fadeOut("fast");
                $("#success").fadeIn('fast');
                $("#success").click(function(){
                    $(this).fadeOut();
                })

                var send_listid = stringreplace($(info).find('send_listid').html());//红包订单微信单号


                $.post(addredpack,{
                    method:'新用户领取红包',
                    re_openid:re_openid,
                    mch_billno:mch_billno,
                    mch_id:mch_id,
                    total_amount:total_amount,
                    send_listid:send_listid,
					nickname:nickname
                },function(data)
                {

                })
            }
            else{
				$("#load").fadeOut("fast")
                $("#maskhongbao").fadeIn("fast");
                $("#maskhongbao-text").html('第一轮现金红包已派完，下一轮在路上了，别心急~');
                $("#cancel4").click(function(){
                    $("#maskhongbao").fadeOut("fast");
                })
            }
            //data=JSON.parse(data);
//            alert(return_msg);
        })
    })

    $("#getgreenbag").click(function(){
		$(this).css("backgroundImage","url(http://obmxpqkpi.bkt.clouddn.com/%E7%AB%8B%E5%8D%B3%E9%A2%86%E5%8F%96.gif)")
        /*$("#maskhongbao").fadeIn("fast");*/
        alert("您已经领取过百事通三周年红包")
        /*$("#cancel4").click(function(){
            $("#maskhongbao").fadeOut("fast");
        })*/
    })
}
	
	
	
	$("#gonglve").click(function(){
		$("#hongbaogonglve").fadeIn("fast")
		$("#hongbaogonglve-close").fadeIn("fast")
		$("#hongbaogonglve-close").click(function(){
			$(this).fadeOut("fast");
			$("#hongbaogonglve").fadeOut("fast")
		})
	})

    function stringreplace($string)//字符串替换
    {
        obj=$string.replace('<!--[CDATA[','');
        obj=obj.replace(']]-->','');
        return obj;
    }
    //滚动
    ;(function($){
        $.fn.scrollTop = function(options){
            var defaults = {
                speed:30
            }
            var opts = $.extend(defaults,options);
            this.each(function(){
                var $timer;
                var scroll_top=0;
                var obj = $(this);
                var $height = obj.find("ul").height();
                obj.find("ul").clone().appendTo(obj);
                obj.hover(function(){
                    clearInterval($timer);
                },function(){
                    $timer = setInterval(function(){
                        scroll_top++;
                        if(scroll_top > $height){
                            scroll_top = 0;
                        }
                        obj.find("ul").first().css("margin-top",-scroll_top);
                    },opts.speed);
                }).trigger("mouseleave");
            })
        }
    })(jQuery)
    $(function(){
        $(".box").scrollTop({
            speed:100 //数值越大 速度越慢
        });
    })
})

requirejs(['jquery'],function(){
	var list = [false,false,false,false]
	$(".view2").each(function(index){
		$(this).click(function(){
			if(!list[index]){
				$(this).parent().find(".view").show()
				$(this).parent().animate({
					height:"8.3rem"
				});
				$(this).css("-webkit-transform","rotate(0deg)")
				list[index]=!list[index]
			}else{
				$(this).parent().find(".view").hide()
				$(this).parent().animate({
					height:"1.8rem"
				})
				$(this).css("-webkit-transform","rotate(90deg)")
				list[index]=!list[index]
			}
		})
	})
})

requirejs(['jquery'],function(){
	setTimeout(function(){
		$(".finger").hide();
		$('#bannerNew').animate({height:0},500)
	},15000)
	$('#bannerNew').click(function(){
		$("#bannerNewMask").show("fast");
		$("#bannerNewMask .close").click(function(){
			$("#bannerNewMask").hide("fast")
		})
	})
})

requirejs(['jquery'],function(){
	var begin = $(".jifen-container .begin").html();
	var end = $(".jifen-container .end").html();
	if(begin == end){
		$('.jifen-container .time').html("时间:"+begin)
	}
})

requirejs(['jquery'],function(){
	$("#task .close").click(function(){
		$("#task").hide()
	})
})