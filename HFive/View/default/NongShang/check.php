<?php
include "pdo.class.php";
$phone=$_POST['phone'];
//$phone = '18520829197';
$pdo = new pdomysql();
$pdo->connect();
try{
	$result = $pdo->fetOne("tyk_user","*","phone=".$phone);
	$result1 = $pdo->fetAll('type','type','',"phone=".$phone);
	
	$res = array('prizeOne'=>$result['prizeone'],'prizeTwo'=>$result['prizetwo'],'prizeThree'=>$result['prizethree'],'prizeThreeType'=>$result1);
	$res1 = json_encode($res);
	print_r($res1);
}catch(Exception $e){
	
    exit($e->getMessage());  
	
}