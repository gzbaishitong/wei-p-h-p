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

requirejs(['scrollFix'],function(){
	var scrollable = document.getElementById("goods-detail");
	new ScrollFix(scrollable);
})

requirejs(['jquery'],function(){
	self=$("#information")
	var url = self.data("url");
	var time = self.data("time");
	var num = self.data("num");
	
		var alertMask = function(e){
		e.preventDefault();
		$("#mask").css("display","block");
		$('#gopay').click(function(){
			var num = $('#pronum').html();
			//var paurl="{:U('verification',array('orderid'=>$orderid))}";
			var paurl = url+1;
			window.location.href=paurl;
		});
		$("#notgopay").click(function(){
			$("#mask").css("display","none")
		})
	}
    /*var img=new Swiper('.image');
    var hot=new Swiper('.hot-bd .m10',{
        slidesPerView:3
    });
	$('#addCart').click(function(){
        var num = $('#pronum').html();

        $.ajax({
            url:"{:addons_url('Shop://Cart/inCart')}&id={$info.id}-"+1,
            type:"get",
            dataType:"json",
            success:function(re){
                if(re){
                    cartNum(re);
                    alert('ÒÑÌí¼Ó½ø¹ºÎï³µ');
                }else{
                    alert('Ìí¼ÓÊ§°Ü');
                }
            },
            error:function(){
                alert('Ìí¼ÓÊ§°Ü');
            }
        });
    });

    $('.tab-title ul li').click(function(){
        var tb= $(this).attr('tb');
        $('.tab-title ul li a').removeClass('current');
        $(this).find('a').addClass('current');

        $('.tab-bd').hide();
        $('#'+tb).show();
        return false;
    })
	*/
	$('#gopay2').click(alertMask)
    
    

//ÃëÉ±»î¶¯
var endTimeCount=time;
var NumPro =num;
if(NumPro>0){
	if(endTimeCount!=0){
		$("#symbol").attr("src","http://ob26aihye.bkt.clouddn.com/yikaishi.png")
		var nowTime = new Date();
		var endTime = new Date(endTimeCount * 1000);
		var t = endTime.getTime() - nowTime.getTime();
		if(t>=0){
			$("#symbol").attr("src","http://ob26aihye.bkt.clouddn.com/weikaishi.png")
			$("#noCount").css("display","none");
			$("#count").css("display","block")
			//µ÷ÓÃº¯Êý£º
			getCountDown(endTimeCount);
		}
		function getCountDown(a){
			var timeCount = setInterval(function(){
						var nowTime = new Date();
						var endTime = new Date(a * 1000);
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
							var countDownTime = d+"å¤©"+hour + "æ—¶" + min + "åˆ†" + sec+"ç§’";
							$("#count").html("å°†äºŽ"+countDownTime+"å¼€å§‹");
						}else{
							$("#noCount").css("display","block");
							$("#count").css("display","none");
							$("#symbol").attr("src","http://ob26aihye.bkt.clouddn.com/yikaishi.png")
							$('#gopay2').html("ç«‹å³ç§’æ€")
							clearInterval(timeCount)
						}          
					},1000);
				}    
	}
}else{
	if(endTimeCount!=0){
		$('#gopay2').html("ç§’æ€ç»“æŸ");
		$("#noCount").css("background","#d7d8d8");
		$('#gopay2').unbind("click",alertMask)
		$('#symbol').remove()
	}
}

})