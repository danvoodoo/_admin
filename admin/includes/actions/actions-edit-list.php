<?php
if (isset($_GET["action"]) and $_GET["action"] == 'state') { 
	$id = $_POST["id"];
	$state = $_POST["val"];

	$data = new Database();
	$arr = array(
		       $_GET['table_state'] => $state
		       );
	$count  =  $data->update( $_GET['table'] , $arr, $_GET['table_id']." = ".$id);
	$id = $data->lastid();
	exit;
}
 

if (isset($_GET["action"]) and $_GET["action"] == 'delete') { 
	$id = $_GET["id"];
	$data = new Database();
	$count  =  $data->delete( $extras['table'] , $extras['id']." = ".$id);


	if ( isset($extras['page_parent']) ){
		$data = new Database();
		$arr = array(
			       $extras['page_parent'] => 0
			       );
		$count  =  $data->update( $extras['table'] , $arr, $extras['page_parent']." = ".$id );
		$id = $data->lastid();
	}

	$url = strtok($_SERVER["REQUEST_URI"],'?');
	$headernew = $url.'?list=1&msg=delete';
	header ("Location: ".$headernew );
	exit;
}	





if (isset($_GET["action"]) and $_GET["action"] == 'duplicate') { 
	$id = $_GET["id"];
	$data = new Database();
	$where = 'post_id = '.$id;
	$count  =  $data->select(" * ", " post ", $where);
	$r = $data->getObjectResults();

	$arr = array();
	foreach ($r as $key => $value) {
		$arr[ $key ] = addslashes( $value );
	}

	$arr[ 'post_title' ] .= ' - duplicate';
	$arr[ 'post_url' ] .= '-duplicate';

	//$arr[ 'post_content' ] = addslashes($arr[ 'post_content' ]);

	unset( $arr[ 'post_id' ] );

	$data = new Database();
	$count  =  $data->insert(" post ", $arr);
	$newid = $data->lastid();

	$data = new Database();
	$where = 'meta_postid = '.$id.' AND meta_posttype = "'.$r->post_type.'"';
	$count  =  $data->select(" * ", " meta ", $where);

	while($rr = $data->getObjectResults()){
		$data2 = new Database();
		$arr = array(
			       'meta_posttype' => $r->post_type,
			       'meta_postid' => $newid,
			       'meta_key' => $rr->meta_key,
			       'meta_value' => $rr->meta_value,
			       );
		$count  =  $data2->insert(" meta ", $arr);
	}

	if ( isset($_GET['includechilds']) ) {
		$data = new Database();
		$where = 'post_parent = '.$id;
		$count  =  $data->select(" * ", " post ", $where);
		while($r = $data->getObjectResults()){
			$arr = array();
			foreach ($r as $key => $value) {
				$arr[ $key ] = addslashes( $value );
			}
			$arr[ 'post_parent' ] = $newid;
			unset( $arr[ 'post_id' ] );
			$datainsert = new Database();
			$datainsert->insert(" post ", $arr);
		}
	}


	$url = strtok($_SERVER["REQUEST_URI"],'?');
	$headernew = $url.'?id='.$newid.'&msg=duplicated';
	header ("Location: ".$headernew );
	exit;
}	



	        
?>