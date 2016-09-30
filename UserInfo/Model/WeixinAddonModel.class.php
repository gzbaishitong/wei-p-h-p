<?php
        	
namespace Addons\UserInfo\Model;
use Home\Model\WeixinModel;
        	
/**
 * UserInfo的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'UserInfo' ); // 获取后台插件的配置参数	
		//dump($config);

	} 

	// 关注公众号事件
    function subscribe($dataArr)
    {

    }
	
	// 取消关注公众号事件
	public function unsubscribe() {
		return true;
	}
	
	// 扫描带参数二维码事件
	public function scan($dataArr)
    {
        
		return true;
	}
	
	// 上报地理位置事件
	public function location() {
		return true;
	}
	
	// 自定义菜单事件
	public function click() {
		return true;
	}	
}
        	