<?php
	
	require_once('../util/helpers.php');
	parse_str(file_get_contents('php://input'), $post);
	var_dump($post);
	var_dump(json_decode($post));
	//$decoded = json_decode($data);
	//echo $decoded.userName;
	$req = Helpers::checkParams ( array ("userName","password","ngoUserName","userAddress","userCity","userDesc","userLatitude","userLongitude" ),json_decode($data) );
	extract ( $req );
	$insert_query = <<<SQL
	
	INSERT INTO ngo_user VALUES ("",'$userName','$password','$ngoUserName','$userAddress','$userCity','$userDesc',$userLatitude,$userLongitude)

SQL;
	//INSERT INTO user_calander_data VALUES($userId,$messageid,$period,$subperiod,"$eventName",$eventDay,$eventHour);
	echo $insert_query;
	$insert_query_result = mysql_query ( $insert_query ) or Helpers::errKill ( 10, "Here - Error while inserting user register data.", true );


?>