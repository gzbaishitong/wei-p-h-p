define(['jquery'],function($){
	return {
		default:function(){
			$.fn.lunbo=function(options){
				var defaults = {
					"height":"2rem",
					"width":"100%",
					"position":"absolute",
					"background":"white",
					"top":0,
					"left":0,
					"speed":2000
				}
				var settings = $.extend(defaults,options);
				var ul = this.find("ul")
				var liNum = this.find("li").length;
				var liWidth = this.width();
				var ulWidth = liWidth*liNum;
				this.children("ul").css({
					"width":ulWidth,
					"height":"100%",
					"position":"absolute",
					"left":0
				})
				this.find("li").css({
					"display":"inline-block",
					"width":liWidth,
					"height":"100%",
					"float":"left"
				})
				
				//…Ë÷√º∆ ±∆˜
				var $this = this
				$timer = setInterval(function(){
					var left = parseInt($this.find("ul").first().css("left"))
					if(left == -(ulWidth-liWidth)){
						$this.find("ul").clone().appendTo($this).css("left",0);
						$this.find("ul").first().remove();
						var left = 0
					}
					var leftPx = left-liWidth
					$this.find("ul").first().animate({left:leftPx},"slow")
				},settings.speed)
				
				return this.css({
					"height":settings.height,
					"width":settings.width,
					"position":settings.position,
					"background":settings.background
				})
			}
		}
	}
})