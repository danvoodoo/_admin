<?php 
//ini_set('error_reporting', E_ALL);
$ip = $_SERVER['REMOTE_ADDR'];
$mins = 15;//number of mins to consider an active session


//first delete inactive records
$datastat = new Database();
$count  =  $datastat->delete(" visitors_online ", "visitor_time < NOW() - INTERVAL 20 MINUTE");


$where = "visitor_ip = '$ip' and visitor_time >= '". date('c', strtotime( '-'.$mins.' min' )) ."' ";
$count  =  $datastat->select(" * ", " visitors_online ", $where);

if ( $count == 0){// no entry found for this ip and time

	$arr = array(
		       'visitor_ip' => $ip,
		       'visitor_time' => date('c')
		       );
	$count  =  $datastat->insert(" visitors_online ", $arr);

} else{

	$arr = array(
		       'visitor_ip' => $ip,
		       'visitor_time' => date('c')
		       );
	$count  =  $datastat->update(" visitors_online ", $arr, "visitor_ip = '$ip'");

}


?>