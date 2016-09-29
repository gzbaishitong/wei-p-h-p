<?php
include_once "pdo.class.php";
$prizeOne=$_POST['prizeOne'];
$prizeTwo=$_POST['prizeTwo'];
$prizeThree=$_POST['prizeThree'];
$prizeThreeType = $_POST['prizeThreeType'];
$name=$_POST['name'];
$phone=$_POST['phone'];
$tablename= "tyk_user";
$pdo = new pdomysql();
$pdo->connect();
try{
	$pdo->beginTransaction();
	if(count($prizeThreeType)>0){
		foreach ($prizeThreeType as $type ){
			$data = array('phone'=>$phone,"type"=>$type);
			$pdo->add("type",$data);
		}
		
	}
	$res = $pdo->fetOne("limt_prize","*",TRUE);
	$result = $pdo->fetRowCount($tablename,"*","phone=".$phone);
	if($result['num']==0){
		if($prizeOne>=1){
			$prizeOne=1;
		}
		if($prizeTwo>=3){
			$prizeTwo=3;
		}
		$data = array("username"=>$name,"phone"=>$phone,"prizeone"=>$prizeOne,"prizetwo"=>$prizeTwo,"prizethree"=>$prizeThree);
		$pdo->add($tablename,$data);
		if($res['prizeone']>0 && $res['prizetwo']>0){
		$pdo->update_limt_prize($prizeOne,$prizeTwo);
		}else if($res['prizeone']>0 ){
			$pdo->update_limt_prize($prizeOne,0);
		}else if($res['prizetwo']>0){
			$pdo->update_limt_prize(0,$prizeTwo);
		}
		$pdo->commit();
	}else{
		
		$row = $pdo->fetOne($tablename,"*","phone=$phone");
		
		if($prizeOne>=1 && $row['prizeone']==0 && $res['prizeone']>0){
			$prizeOne=1;
			$pdo->update_limt_prize("1","0");
		}else{
			$prizeOne=0;
		}
		if($prizeTwo>=3){
			$prizeTwo=3;
		}
		
		$prizeThree = $prizeThree+$row['prizethree'];
		
		if($row['prizetwo'] < 3 && $res['prizetwo']>0){
			
			$pdo->update_limt_prize("0",$prizeTwo);
			$prizeTwo = $prizeTwo+$row['prizetwo'];
			if($prizeTwo>=3){
				$prizeTwo=3;
			}
		}else{
			$prizeTwo=3;
		}
		$pdo->update($tablename,array("prizeone"=>$prizeOne,"prizetwo"=>$prizeTwo,"prizethree"=>$prizeThree),"phone=".$phone);
		$pdo->commit();
		}
}catch(Exception  $e){
	$pdo->rollback(); // 执行失败，事务回滚  
    exit($e->getMessage());  
}
