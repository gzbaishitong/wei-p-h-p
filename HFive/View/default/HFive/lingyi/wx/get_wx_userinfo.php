<?php  
	include_once('pdo.class.php');
	$pdo = new pdomysql();
	$openid = $_GET['openid'];
	$headimgurl = $_GET['headimgurl'];
	$nickname=$_GET['nickname'];
	
	$result = $pdo->_fetch("select * from userinfo where openid='$openid'",0);
	if($result){
		header('location:http://kf.gzbaishitong.com/games/wushi/index.php?openid='.$openid);
	}
	$res = $pdo->add("userinfo",array('openid'=>$openid,'headimgurl'=>$headimgurl,'nickname'=>$nickname));
	$pdo->close();
	header('location:http://kf.gzbaishitong.com/games/wushi/index.php?openid='.$openid);
?> 