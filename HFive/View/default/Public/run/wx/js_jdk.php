<?php
class JSSDK {
  private $appId;
  private $appSecret;

  public function __construct($appId, $appSecret) {
    $this->appId = $appId;
    $this->appSecret = $appSecret;
  }

  public function getSignPackage() {
    $jsapiTicket = $this->getJsApiTicket();

    // 注意 URL 一定要动态获取，不能 hardcode.
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    $signature = sha1($string);

    $signPackage = array(
      "appId"     => $this->appId,
      "nonceStr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );
    return $signPackage; 
  }

  private function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }

  private function getJsApiTicket() {
    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
    //$data = json_decode(file_get_contents("./php/jsapi_ticket.json"));
	$sql="select * from test.jsapi_ticket";
	$data = $this->db_operation_select($sql);
	$data = $data[0];
    if  (time() - $data['time'] >7000) {
      $accessToken = $this->getAccessToken();
      // 如果是企业号用以下 URL 获取 ticket
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      $res = json_decode($this->httpGet($url));
      $ticket = $res->ticket;
      if ($ticket) {
       $sql="update test.jsapi_ticket set ticket='{$ticket}',time=".time();
	   $this->db_operation_insert($sql);
      }
    } else {
      $ticket = $data['ticket'];
    }

    return $ticket;
  }

  public function getAccessToken() {
    // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
    
	$sql="select * from test.access_token";
	$data = $this->db_operation_select($sql);
	$data = $data[0];
	
    if (time() - $data['time'] >7000 ) {
      // 如果是企业号用以下URL获取access_token
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
      $res = json_decode($this->httpGet($url));
      $access_token = $res->access_token;
      if ($access_token) {
       $sql="update test.access_token set token='{$access_token}',time=".time();
	   $this->db_operation_insert($sql);
      }
    } else {
      $access_token = $data['token'];
    }
    return $access_token;
  }
	/*public function getWyAccessToken($code) {
    // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
    
	$sql="select * from test.wy_access_token";
	$data = $this->db_operation_select($sql);
	$data = $data[0];
	
    if (time() - $data['time'] >7000 ) {
		$code = $code;
      // 如果是企业号用以下URL获取access_token
      // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
      //$url  "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appId&secret=$this->appSecret&code=".$code."&grant_type=authorization_code";
		$access_token_json = https_request($url);
		$access_token_array = json_decode($access_token_json, true);
		print_r($access_token_array);
		die();
		$access_token = $access_token_array['access_token'];
		$openid = $access_token_array['openid'];
      if ($access_token) {
       $sql="update test.wy_access_token set token='{$access_token}',time=".time();
	   $this->db_operation_insert($sql);
      }
    } else {
      $access_token = $data['token'];
    }
	
    return $access_token;
	}*/
	
	
  private function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
  }
  private  function https_request($url){
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
private function db_operation_select($sql){

$con = mysql_connect("127.0.0.1","root","9uL8lHVtbNFE");
if(!$con){
  die('Could not connect: ' . mysql_error());
  }


$result = mysql_query($sql);

$arr = array();

while($row = mysql_fetch_assoc($result))
  {
    $arr[] = $row;
  }

mysql_close($con);

return $arr;


}


 private function db_operation_insert($sql){
   $con = mysql_connect("127.0.0.1","root","9uL8lHVtbNFE");
if(!$con){
  die('Could not connect: ' . mysql_error());
  }


$result = mysql_query($sql);


return $result;

}
}