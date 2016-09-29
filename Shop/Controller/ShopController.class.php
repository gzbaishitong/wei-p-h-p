<?php

namespace Addons\Shop\Controller;
use Addons\Shop\Controller\BaseController;
/*
 * 后台管理控制器
 */
class ShopController extends BaseController{
    public function lists(){
        redirect(addons_url('Shop://Order/lists'));
//$this->redirect(addons_url('Shop://Order/lists'));
    }
     public function config(){
         // 使用提示
        $normal_tips = '如需使用微信支付，请到<a target="_blank" href="' . addons_url( 'Upay://Upay/config') . '"> [U支付] </a>完成基本配置';
        $this->assign ( 'normal_tips', $normal_tips );
         parent::config();
    }
}
