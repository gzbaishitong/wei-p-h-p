<?php
	include_once('./wx/pdo.class.php');
	$openid = $_POST['openid'];
	$score = $_POST["score"];
	$pdo = new pdomysql();
	$res = $pdo->_fetch("select * from userinfo where openid='$openid'",0);
	$rank = $pdo->_fetch("select * from userinfo where score>$score",2);
	if($res['phone']!=NULL){
		
		if($res['score']>=$score){
			
			$res1 = $pdo->_fetch("select nickname,headimgurl,score FROM userinfo  ORDER BY score desc limit 5",1);
			print_r(json_encode(array('users'=>$res1,'rank'=>$rank+1)));	
		}else{
			$pdo->update("userinfo",array('score'=>$score),$where="openid='$openid'");
			$res1 = $pdo->_fetch("select nickname,headimgurl,score FROM userinfo  ORDER BY score desc limit 5",1);
			print_r(json_encode(array('users'=>$res1,'rank'=>$rank+1)));
		}
	}else{
		$phone = $_POST['phone'];
		$pdo->update("userinfo",array("score"=>$score,"phone"=>$phone),$where="openid='$openid'");
		$res1 = $pdo->_fetch("select nickname,headimgurl,score FROM userinfo  ORDER BY score desc limit 5",1);
		print_r(json_encode(array('users'=>$res1,'rank'=>$rank+1)));
	}
	