<?php
	include("pdo.class.php");
	$pdo = new pdomysql();
	if('success' == $_GET['getTicket']){
	$res = $pdo->fetOne("bst_mc_duihuanma","*","statu=0 and type='snoopy' limit 1");
	$pdo->update("bst_mc_duihuanma",array('statu'=>-1),"duihuanma=".$res['duihuanma']);
	$ticket = $res['duihuanma'];
	print_r(json_encode(array('ticket'=>$ticket)));
	}