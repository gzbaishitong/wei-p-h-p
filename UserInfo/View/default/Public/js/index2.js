var scrollable = document.getElementById("scroll");
	new ScrollFix(scrollable);
	var scrollable2 = document.getElementById("mask2-text");
	new ScrollFix(scrollable2);
	
	//以上代码为控制scroll

    $.fn.adjust = function(){
        this.each(function(){
            var a = $(this).css("border");
            var n = parseInt(a.slice(0,1));

            var imgH = $(this).children("img").height();
            var imgW = $(this).children("img").width();

            var H = $(this).height()-n*2;
            var W = $(this).width()-n*2;
            if(imgH>=imgW){
                $(this).children("img").css("margin-left",(W-imgW)/2)
            }else{
                $(this).children("img").css("margin-top",(H-imgH)/2)
            }

        })
    }

    //$(".youhuiitem-img").adjust();
    //$(".item-img").adjust();

    $("#mall").click(function(){
        window.location = $(this).children("a").attr("href")
    })
	