<?php
	include_once("pdo.class.php");
	if($_POST['type']=="getscore"){
	if(!empty($_POST['openid'])){
	$openid = $_POST['openid'];
	$pdo = new pdomysql();
	$res = $pdo->getOne("select * from userinfo  where openid='{$openid}'");
	$pdo->close();
	if(!empty($res['score'])){
	print_r(json_encode(array("score"=>$res['score'])));
	}else{
	print_r(json_encode(array("score"=>0)));
	}
	}else{
		echo "openid为空";
		die();
	}
	}
	if($_POST['type']=="save"){
		$pdo = new pdomysql();
		$score = $_POST['score'];
		$phone = $_POST['phone'];
		$openid = $_POST['openid'];
		if(empty($phone)){
		$result = $pdo->getOne("select * from userinfo  where openid='{$openid}'");
		if($score>$result['score']){
		if($result['iszhuanfa']==1){
		$res = $pdo->update("userinfo",array('score'=>$score+50),"openid='{$openid}'");
		}else{
		$res = $pdo->update("userinfo",array('score'=>$score),"openid='{$openid}'");
		}
		$pdo->close();
		print_r(json_encode(array("msg"=>"哇，你破了自己的最高分，还能能高分吗？")));
		}else{
		print_r(json_encode(array("msg"=>"哇，你还没突破自己的最高分哦，继续努力吧！")));
		}
		}else{
		$res = $pdo->update("userinfo",array('score'=>$score,'phone'=>$phone),"openid='{$openid}'");
		$pdo->close();
		print_r(json_encode(array("msg"=>"分数和电话都更新了",'score'=>$score)));
		}
	}
	if($_POST['type']=="rank"){
		$pdo = new pdomysql();
		$res = $pdo->getAll("select headurl,nickname,score from userinfo order by score desc limit 10");
		$pdo->close();
		print_r(json_encode($res));
	}
	if($_POST['type']=="zhuanfa"){
		//Global $msg="";
		$openid = $_POST['openid'];
		$pdo = new pdomysql();
		$res = $pdo->getOne("select * from userinfo  where openid='{$openid}'");
		if($res['iszhuanfa']==1){
			print_r(json_encode(array('msg'=>"只能加分一次哦！加油")));
		}
		if($res['iszhuanfa']!=1 && $res['score']!=0){
		$newscore=$res['score']+50;
		$result = $pdo->update("userinfo",array('score'=>$res['score']+50,'iszhuanfa'=>1),"openid='{$openid}'");
		$result =$pdo->execute("update userinfo set score=score+50,iszhuanfa=1 where openid='{$openid}'");
		print_r(json_encode(array('msg'=>"分享成功，最高得分加50！")));
		//$msg="分享成功，最高得分加50";
		}
		}
		
	
		
	
	