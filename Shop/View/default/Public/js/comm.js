document.body.style.fontFamily='Microsoft Yahei';
var KmPop={
	init:function(cont){
		if(!$('#KmPop').length>0){
			$('body').append('<div id="KmCover" class="t2"></div><div id="KmPop" class="t2"></div>')
		};
		$('#KmCover').click(function(){
			KmPop.hide()
		});
		this.show(cont)
	},
	show:function(cont){
		$('#KmCover,#KmPop').addClass('show');
		$('#KmPop').html(cont)
	},
	hide:function(){
		$('#KmCover,#KmPop').removeClass('show');
		return false
	}
};
$(function(){
	$('.switch').click(function(){
		$(this).toggleClass('switch-off')
	})
})
//底部导航购物车的数量
function cartNum(num){
    $('.shopcart_count').show();
    $('.shopcart_count').html(num);
}