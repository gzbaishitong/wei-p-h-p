<!-- 购物车 -->

//总商品数
function totalGoods(){
	//var len=$('#shopcar-list li').length;
	//len>0?$('#shopcar-top .goodsNum').text(len):window.location='index.php?s=/addon/Shop/Index/emptycart.html';
        var num=0;
        $('#shopcar-list li').each(function(index, element) {
                if(!$(this).find('em').hasClass('icon-select-unselect')){
                   num += 1;
                }
            $('#shopcar-top .goodsNum').text(num);
	});
};
totalGoods();
//总价
function totalPrice(){
	var ttp=0;
	$('#shopcar-list li').each(function(index, element) {
            if(!$(this).find('em').hasClass('icon-select-unselect')){
               ttp+=Number($(this).find('.price').text().replace(/,/g,'').split('￥')[1]);
            }
	});
	$('#shopcar-top .price').text('￥'+ttp.toFixed(2));
};

totalPrice();
//总商品数量
//仅修改数量
var productinfo={
    plus:function(id){
        var num=Number($(id).parent().find('span').text());
        if(true||num<10){
            //屏蔽原来的最大10的限制
            var nownum = num+1;
            $(id).parent().find('span').text(nownum);//数量
            $(id).parent().find('a').removeClass('undo');
        }else{
            $(id).addClass('undo');
        }
        return false;
    },
    reduce:function(id){
        var num=Number($(id).parent().find('span').text());
        if(num>1){
             var nownum = num-1;
            $(id).parent().find('span').text(nownum);//数量
            if(nownum==1){
                 $(id).addClass('undo');
            }
        }else{
            $(id).addClass('undo');
        }
        return false;
    }
}


//增删数量
var calc={
    plus:function(id){
        var num=Number($(id).parent().find('span').text());
        var product_in = $(id).attr('product_in');
        if(true||num<10){
            //屏蔽原来的最大10的限制
            $.ajax({
                url:product_in,
                type:'get',
                dataType:'json',
                success:function(renum){
                    //alert('back:'+num);
                    $(id).parent().find('a:first').removeClass('undo');
                    nownum = num+1;
                    $(id).parent().find('span').text(nownum);//数量
                    $(id).parent().parent().find('.price').text('￥'+(Number($(id).parent().parent().find('.price').attr('value')*nownum)).toFixed(2));//价格
                    totalPrice();
                },
                error:function(){
                    alert(3);
                }
            });
        }else{
            $(id).addClass('undo');
        }
        return false;
    },
    reduce:function(id){
        var num=Number($(id).parent().find('span').text());
        var product_out = $(id).attr('product_out');
        if(num>1){
            $.ajax({
               url:product_out,
               type:'get',
               dataType:'json',
               success:function(renum){
                    $(id).parent().find('a:last').removeClass('undo');
                    nownum = num-1;
                    if(nownum<=1){
                        $(id).addClass('undo');
                    }
                    $(id).parent().find('span').text(nownum);//数量
                    //alert(Number($(id).parent().parent().find('.price').text().split('￥')[1]));
                    
                    $(id).parent().parent().find('.price').text('￥'+(Number($(id).parent().parent().find('.price').attr('value')*nownum)).toFixed(2));//价格
                    totalPrice();
                }
            });
        }else{
            $(id).addClass('undo');
        }
        return false;
    }
}
$(function(){
	//全选
	$('#shopcar-top .select').click(function(){
            $('em',this).toggleClass('icon-select-unselect');
            if($('em',this).hasClass('icon-select-unselect')){//全选
                    $('#shopcar-list').each(function(index, element) {
                            $(this).find('.select em').addClass('icon-select-unselect')
                    });
            }else{//全不选
                    $('#shopcar-list').each(function(index, element) {
                            $(this).find('.select em').removeClass('icon-select-unselect')
                    });
            };
            totalPrice();
            totalGoods();
            return false;
	});
	//删除
	$('#shopcar-act a:first').click(function(){
            if($('#shopcar-list .icon-select-unselect').length>=$('#shopcar-list li').length){//全部未选
                alert('请勾选要删除的')
            }else{
                var pid = '';
                $('#shopcar-list li').each(function(index, element) {
                    if(!$(this).find('.select em').hasClass('icon-select-unselect')){
                        //alert($(this).attr('pid'));
                        pid = pid+','+$(this).attr('pid');
                        $(this).remove();
                    }
                });
                //删除
                
                 $.ajax({
                    url:'index.php?s=addon/Shop/Cart/delCart/id/'+pid,
                    type:'get',
                    dataType:'json',
                    success:function(renum){
                        cartNum(renum);
                         //totalPrice();
                         //如果是最后一个商品，则跳转到空
                         var count =  $('#shopcar-list li').length;
                         if(count <= 0){
                             window.location='index.php?s=/addon/Shop/Index/emptycart.html';
                         }
                     },
                     error:function(){
                         alert('操作失败');
                     }
                 });
            };
            totalPrice();
            totalGoods();
            return false;
	});
	//单件选择
	$('#shopcar-list .select').click(function(){
            $('em',this).toggleClass('icon-select-unselect');
            $('#shopcar-list .icon-select-unselect').length>0?$('#shopcar-top .select em').addClass('icon-select-unselect'):$('#shopcar-top .select em').removeClass('icon-select-unselect')//判断是否全选
            totalPrice();
            totalGoods();
        });
        
        //前去结算
        $('#sureorder').click(function(){
            //获取当前勾选的商品id
            var pid = '';
            $('#shopcar-list li').each(function(index, element) {
                if(!$(this).find('.select em').hasClass('icon-select-unselect')){
                    pid = pid+','+$(this).attr('pid')+'-'+$(this).find('.num').html();
                }
            });
            window.location.href='index.php?s=addon/Shop/Index/sureorder.html&from=cart'+'&id='+pid;
            return false;
        })
})
