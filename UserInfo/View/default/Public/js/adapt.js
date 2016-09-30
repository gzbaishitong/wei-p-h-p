$.fn.adjust = function(){
		this.each(function(){
			var a = $(this).css("border");
			var n = parseInt(a.slice(0,1));
			
			var imgH = $(this).children("img").height();
			var imgW = $(this).children("img").width();
			console.log(imgH)
			var H = $(this).height()-n*2;
			var W = $(this).width()-n*2;
			if(imgH>=imgW){
				$(this).children("img").css("margin-left",(W-imgW)/2)
			}else{
				$(this).children("img").css("margin-top",(H-imgH)/2)
			}
			
		})
	}