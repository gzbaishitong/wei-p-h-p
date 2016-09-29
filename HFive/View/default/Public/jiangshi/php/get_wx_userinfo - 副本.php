<?php  
	include_once('pdo.class.php');
	include_once('js_jdk.php');
	header("Content-Type; text/html; charset=utf-8");
	if (!isset($_GET['code'])){
		echo "<h2>请重新登录！！</h2>";
	}
	$code = $_GET["code"];
	function getUserInfo($code)
	{
    $appid = "wxb1114bb65753893c";
    $appsecret = "6e7feece406d1b7c48baf85c071bd3f1";
	$jssdk = new JSSDK($appid,$appsecret);
    $access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";
    $access_token_json = https_request($access_token_url);
    $access_token_array = json_decode($access_token_json, true);
	if(empty($access_token_array)){
		echo "</h2>游戏的有点多哦，请重新登录！！</h2>";
		die();
	}
     $access_token= $access_token_array['access_token'];
	//$access_token = $jssdk->getWyAccessToken($code);
    $openid = $access_token_array['openid'];
	$pdo = new pdomysql();
	$result = $pdo->_fetch("select * from userinfo  where openid='{$openid}'",2);
	if($result){
		header("location:http://kf.gzbaishitong.com/games/JiangShi/index.php?openid={$openid}");
		echo "<h2>正在进入游戏，请稍等...</h2>";
		die();
	}
    $userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
    $userinfo_json = https_request($userinfo_url);
    $userinfo_array = json_decode($userinfo_json, true);
    return $userinfo_array;
}
function https_request($url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);
    if (curl_errno($curl)) {return 'ERROR '.curl_error($curl);}
    curl_close($curl);
    return $data;
	}
	$userinfo = getUserInfo($code);
	$pdo = new pdomysql();
	$res = $pdo->add("userinfo",array('openid'=>$userinfo['openid'],'headurl'=>$userinfo['headimgurl'],'nickname'=>$userinfo['nickname']));
	$pdo->close();
	if($res){
		header('location:http://kf.gzbaishitong.com/games/JiangShi/index.php?openid='.$userinfo["openid"]);
	}else{
		header('location:http://kf.gzbaishitong.com/games/JiangShi/index.php?openid='.$userinfo["openid"]);
	}
?>  
