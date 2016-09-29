<?php
        	
namespace Addons\shop\Model;
use Home\Model\WeixinModel;
        	
/**
 * shop的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'Shop' ); // 获取后台插件的配置参数			
                
                // 其中token和openid这两个参数一定要传，否则程序不知道是哪个微信用户进入了系统
		$param ['token'] = get_token ();
		$param ['openid'] = $_SESSION['openid'];
                $url = addons_url ( 'Shop://Index/index', $param );

                // 组装微信需要的图文数据，格式是固定的
                $articles [0] = array (
                    'Title' => $config['title'],
                    'Description' =>$config['info'],
                    'PicUrl' => get_cover_url($config['cover']),
                    'Url' => $url 
                );
                $this->replyNews ( $articles );
                 //'PicUrl' =>SITE_URL."/Addons/Shop/View/default/Public/images/temp/shop.jpg",
	} 

	// 关注公众号事件
	public function subscribe() {
		return true;
	}
	
	// 取消关注公众号事件
	public function unsubscribe() {
		return true;
	}
	
	// 扫描带参数二维码事件
	public function scan() {
		return true;
	}
	
	// 上报地理位置事件X
	public function location() {
		return true;
	}
	
	// 自定义菜单事件
	public function click() {
		return true;
	}	
}
        	