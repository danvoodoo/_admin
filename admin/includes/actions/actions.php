<?php
$_GET['debug'] = 1;
include("../init.php");
function escapeJsonString($value) { # list from www.json.org: (\b backspace, \f formfeed)
	    $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
	    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
	    $result = str_replace($escapers, $replacements, $value);
	    return $result;
	}

if (isset($_POST['action']) AND $_POST['action'] == 'savemenu') {

	

	
	foreach($_POST as $nombre_campo => $valor){ if (!is_array($valor)) $asignacion = "\$" . $nombre_campo . "='" . addslashes(htmlspecialchars($valor)) . "';"; eval($asignacion); }//end foreach

	print_r($_POST);
	$menuid = $_POST['menu'];
	$menudata = json_decode( stripslashes($_POST['menudata']));
	print_r($menudata);
	$menudata = escapeJsonString(json_encode($menudata));

	$data = new Database();
	$arr = array(
		       'menu_items' => $menudata
		       );
	$count  =  $data->update(" menus ", $arr, "menu_id = $menuid");
	$id = $data->lastid();

	
	exit;

}


if (isset($_POST['action']) AND $_POST['action'] == 'addmenu-custom') {
	
	foreach($_POST as $nombre_campo => $valor){ if (!is_array($valor)) $asignacion = "\$" . $nombre_campo . "='" . addslashes(htmlspecialchars($valor)) . "';"; eval($asignacion); }//end foreach

	$title = str_replace( "'", "’", $title);
	addmenuitem($menu, $parent, $customurl, $title,  $newwindow);

	exit;

}




if (isset($_POST['action']) AND $_POST['action'] == 'addmenu-page') {
	
	foreach($_POST as $nombre_campo => $valor){ if (!is_array($valor)) $asignacion = "\$" . $nombre_campo . "='" . addslashes(htmlspecialchars($valor)) . "';"; eval($asignacion); }//end foreach

	$data = new Database();
	$where = 'post_id = '.$page;
	$count  =  $data->select(" * ", " post ", $where);
	$r = $data->getObjectResults();

	addmenuitem($menu, $parent, $r->post_url, $r->post_title, 0, $r->post_id);
	exit;

}



function addmenuitem($menuid, $parent, $url, $title, $newwindow = 0, $id = 0) {

	

	$data = new Database();
	$where = 'menu_id = '.$menuid;
	$count  =  $data->select(" * ", " menus ", $where);
	$r = $data->getObjectResults();

	if ($r->menu_items != '') {
		$menu = json_decode($r->menu_items,true);
	} else {
		$menu = array();
	}

	$menuitem =  array('title' => $title, 'url' => $url, 'id' => $id);
	if ($newwindow == 1) $menuitem['newwindow'] = 1;

	if ($parent != '') {
		if (!isset($menu[$parent]['childs'])) $menu[$parent]['childs'] = array();
		$menu[$parent]['childs'][slugify($title)] = $menuitem;	
	} else {
		$menu[slugify($title)] = $menuitem;	
	}
	

	$menu = escapeJsonString(json_encode($menu));

	$data = new Database();
	$arr = array(
		       'menu_items' => $menu
		       );
	$count  =  $data->update(" menus ", $arr, "menu_id = $menuid");
	$id = $data->lastid();
	echo $menu;

}





if (isset($_GET["action"]) and $_GET["action"] == 'order') { /* es cambio de estad del item */	

		
		$ids = $_POST['ids'];
		
		$c = count($ids);
		$a=0;
		foreach ($ids as $id) {
			

			if ($id>0) {
				$data = new Database();
				$arr = array(
						       $_GET['table_order'] => $c-$a
						       	       );
				$count  =  $data->update( $_GET['table'] , $arr, $_GET['table_id'].' = '.$id);
				$data->lastid();
				$a++;
			}
		}
		exit;


	}



if (isset($_GET["action"]) and $_GET["action"]=='populate') { /* popular select...*/
		include ('conexion.php');
		
		$order='';
		if (isset($_GET["order"])) $order = ' ORDER BY '.$_GET["order"];
		
		$sql = "SELECT ".$_GET['id'].", ".$_GET['detalle']." FROM ".$_GET['table']." WHERE ".$_GET['campo']." = '".$_GET['value'] ."'".$order;
		$c_populate = query($sql,$conexion);
		echo $sql;
		$opt = '';
		while ($r_populate = result($c_populate)) {
			$opt .= '<option value="'.$r_populate[$_GET['id']].'">'.$r_populate[$_GET['detalle']].'</option>';
		}		
		echo $opt;
		exit;
	}	
	  
	  
	  
if (isset($_POST['action']) AND $_POST['action'] == 'autocomplete') {
	include ('conexion.php');
	$str = addslashes($_POST['str']);
	$sql = 'SELECT * FROM '.$_POST['paramater_table'].' WHERE
		'.$_POST['parameter_label'].' LIKE "'.$str.'%";
		';
		//echo $sql;
	$c = query($sql, CONNECTION);
	?>
	<?php
	while ($r = result($c)) {
	?>
	<a href='javascript:void(0)' data-id='<?php echo $r[$_POST['parameter_value']];?>'><?php echo $r[$_POST['parameter_label']];?></a>
	<?php }
	exit;	
	
}