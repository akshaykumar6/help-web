<?php
	
	require_once('../util/helpers.php');

	var_dump($_GET);
	$req = Helpers::checkParams ( array ("ngoID","eventTitle","eventDesc","eventDate","eventTime","eventVenueDesc","eventVenueLatitude","eventVenueLongitude" ), $_REQUEST );
	extract ( $req );
	$insert_query = <<<SQL
	
	INSERT INTO ngo_event VALUES ("",$ngoID,'$eventTitle','$eventDesc','$eventDate',$eventTime,'$eventVenueDesc',$eventVenueLatitude,$eventVenueLongitude)

SQL;
	//INSERT INTO user_calander_data VALUES($userId,$messageid,$period,$subperiod,"$eventName",$eventDay,$eventHour);
	echo $insert_query;
	$insert_query_result = mysql_query ( $insert_query ) or Helpers::errKill ( 10, "Here - Error while creating new event data.", true );


?>