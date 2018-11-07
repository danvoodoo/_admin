<?php
include_once("includes/init.php");

function update_product_meta($id, $posttype, $key, $value) {
	$data = new Database();
	$where = 'meta_postid = '.$id.' AND meta_posttype = "'.$posttype.'" AND meta_key = "'.$key.'"';
	$count  =  $data->select(" * ", " meta ", $where);

	if ($count == 0) { //doesnt exist, creat
		$data = new Database();
		$arr = array(
			       'meta_postid' => $id,
			       'meta_posttype' => $posttype,
			       'meta_key' => $key,
			       'meta_value' => $value
			       );
		$count  =  $data->insert(" meta ", $arr);
		$id = $data->lastid();
	} else { //exist, create
		$meta = $data->getObjectResults();
		$data = new Database();
		$arr = array(
			       'meta_value' => $value
			       );
		$count  =  $data->update(" meta ", $arr, "meta_id = ".$meta->meta_id);
		$id = $data->lastid();
	}
	return $id;
}

function utf8_converter($array)
{
    array_walk_recursive($array, function(&$item, $key){
        if(!mb_detect_encoding($item, 'utf-8', true)){
                $item = utf8_encode($item);
        }
    });
 
    return $array;
}

function escapeJsonString($value) { # list from www.json.org: (\b backspace, \f formfeed)
    $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c", "'");
    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b", "\'");
    $result = str_replace($escapers, $replacements, $value);
    return $result;
}


if (isset($_POST["action"]) AND ( $_POST["action"] == 'save' OR $_POST["action"] == 'update' ) ) {

	if ( isset($_GET['lang']) AND $_GET['lang'] != '' ) {
		foreach ($fields as $k => $field) {
			if ( isset($field['field']) ){
				$fields[$k]['field'] = $field['field'].'_'.$_GET['lang'];
				$fields[$k]['meta'] = 1;
			}
		}
	}


	$arr = array();
	foreach($fields as $field){
		if (isset($field['field']) AND !isset($field['meta']) AND isset($_POST[$field['field']]) ) {


			if (isset($_POST[$field['field']]) AND !is_array($_POST[$field['field']]) )
				$value =addslashes(stripcslashes($_POST[$field['field']])); //default
			else
				$value = '';

			if ($field['type'] == 'text' and isset($field['encrypted']) and $field['encrypted'] == 1) //encrypted
				$value = 'ENCODE("'.addslashes($_POST[$field['field']]).'", "'.SALT.'")';

			if ($field['type'] == 'password') //password
				$value = sha1(addslashes($_POST[$field['field']]).SALT);

			/*
			if ($field['type'] == 'url' AND $_POST[$field['field']] == '') //slug
			{
				$posttype = '';
				if (isset($field['posttype'])) $posttype = $field['posttype'];

				if (isset($_GET['id']))
					$value = slugify($_POST[$field['name_field']],$_GET['id'], $posttype);
				else
					$value = slugify($_POST[$field['name_field']],0,$posttype);
			} else if ( $field['type'] == 'url' ) {
				$value = slugify($_POST[$field['name_field']],0,$posttype);
			}
			*/
			
			if ($field['type'] == 'datepicker') //slug
				$value = date('Y-m-d', strtotime($_POST[$field['field']]));

			if (is_array($_POST[$field['field']])) {
				
				$value = escapeJsonString(json_encode( utf8_converter($_POST[$field['field']]) ));
				$value = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $value);
			}


			if ( ( $field['type'] == 'password' AND $_POST[$field['field']] != '' ) OR $field['type'] != 'password' )
				$arr[$field['field']] = $value;

		}
		if ( isset($field['field']) AND $field['type'] == 'checkbox' AND !isset($_POST[$field['field']]) AND !isset($field['meta']) ){
			$arr[$field['field']] = 0;		
		}
	}

	if ( $extras['table_date'] != '' AND $_POST["action"] == 'save') {
		$arr[ $extras['table_date'] ] = date('Y-m-d H-i');
	}
	if ( $extras['table_date_update'] != '' AND $_POST["action"] == 'update') {
		$arr[ $extras['table_date_update'] ] = date('Y-m-d H-i');
	}

	if (isset( $extras['table_state'] ) ) {
		if (isset($_POST[ $extras['table_state'] ]))
			$arr[ $extras['table_state'] ] = $_POST[ $extras['table_state'] ];
		else
			$arr[ $extras['table_state'] ] = 0;
	}

	$data = new Database();

	if($_POST["action"] == 'save') {
		$count  =  $data->insert( $extras['table'] , $arr);
		$id = $data->lastid();

		if ( isset($extras['table_order']) ) {
			$arr = array( $extras['table_order'] => $id );
			$count  =  $data->update( $extras['table'] , $arr, $extras['id'].'='.$id);
		}
	}

	if($_POST["action"] == 'update') {
		$count  =  $data->update( $extras['table'] , $arr, $extras['id'].'='.$_GET['id']);
		$id = $_GET['id'];
	}


	//save metas
	global $extras;
	if (isset($_POST['meta']) AND is_array($_POST['meta'])) {
	foreach ($_POST['meta'] as $k => $v) {

		if (is_array($v)) {
			
			$v = escapeJsonString(json_encode( utf8_converter($v) ));
			$v = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $v);
		}
		update_product_meta($id, $extras['post_type'], $k, $v);
	}
	}

	

	foreach($fields as $field){
		//print_r($field);
	if (isset($field['field']) AND isset($field['meta']) ) {

		$v = $_POST[$field['field']];
		if (is_array($v)) {
			
			$v = escapeJsonString(json_encode( utf8_converter($v) ));
			$v = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $v);
		} else {
			$v =addslashes(stripcslashes( $v )); //default
		}
		//echo $field['field'];
		update_product_meta($id, $extras['post_type'], $field['field'], $v );
	}
	}

	

	if ( function_exists('aftersave') ) aftersave($id);


	$url = strtok($_SERVER["REQUEST_URI"],'?');
	if  (isset($_POST['saveandcontinue']) AND $_POST['saveandcontinue'] != '') {
		if($_POST["action"] == 'save') {
			$headernew = $url.'?id='.$id.'&msg=insert';
		} else {
			$headernew = $url.'?id='.$id.'&msg=update';
		}
	} else {
		if($_POST["action"] == 'save') {
			$headernew = $url.'?list=1&msg=insert';
		} else {
			$headernew = $url.'?list=1&msg=update';
		}
	}

	if ( isset($_GET['lang']) AND $_GET['lang'] != '' ) {
		$headernew .= '&lang='.$_GET['lang'];
	}


	header ("Location: ".$headernew );
	exit;


} //end if post action


?>