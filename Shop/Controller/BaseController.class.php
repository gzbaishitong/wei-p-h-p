<?php

namespace Addons\shop\Controller;
use Home\Controller\AddonsController;

class BaseController extends AddonsController{
    protected $use_token;
    /*
     * 底部导航
     */
    public $appid = 'wx807f16d8a8046457';
    public $secret = '2aeca10207571bf7918d2a974f63e6c2';
    function _initialize() {

        parent::_initialize();


        session('token','gh_4fc719089612');
        //初始化使用哪个token值  后期可通过此功能，使不同公众号公用一个库存机商品信息！
        if(true){
            $this->use_token = get_token();
        }





        $controller = strtolower ( _CONTROLLER );


        $res ['title'] = '订单管理';
        $res ['url'] = addons_url ( 'Shop://Order/lists' );
        $res ['class'] = $controller == 'order' ? 'current' : '';
        $nav [] = $res;

        $res ['title'] = '首页幻灯片';
        $res ['url'] = addons_url ( 'Shop://Banner/lists' );
        $res ['class'] = $controller == 'banner' ? 'current' : '';
        $nav [] = $res;

        $res ['title'] = '专题管理';
        $res ['url'] = addons_url ( 'Shop://Topics/lists' );
        $res ['class'] = $controller == 'topics' ? 'current' : '';
        $nav [] = $res;

        $res ['title'] = '商品分类';
        $res ['url'] = addons_url ( 'Shop://Categories/lists' );
        $res ['class'] = $controller == 'categories' ? 'current' : '';
        $nav [] = $res;

        $res ['title'] = '商品管理';
        $res ['url'] = addons_url ( 'Shop://Products/lists' );
        $res ['class'] = $controller == 'products' ? 'current' : '';
        $nav [] = $res;

        $res['title'] = '商铺配置';
        $res['url'] = addons_url('Shop://Shop/config');
        $res['class'] = $controller == 'shop' ? 'current' :'';
        $nav[] = $res;
        /*
            $res ['title'] = '商铺模版';
            $res ['url'] = addons_url ( 'WeiSite://Slideshow/lists' );
            $res ['class'] = $controller == 'slideshow' ? 'current' : '';
            $nav [] = $res;
         */
        $this->assign ( 'nav', $nav );


    }
    private function footer(){

    }
}
