<?php 
include("includes/init.php");


function escapeJsonString($value) { # list from www.json.org: (\b backspace, \f formfeed)
    $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
    $result = str_replace($escapers, $replacements, $value);
    return $result;
}

function addmenuitem($menuid, $parent, $url, $title, $newwindow = 0, $id = 0) {

	
	if ( isset($_GET['lang']) ) {
		$data = new Database();
		$where = 'meta_posttype = "menu" AND meta_postid = '.$menuid.' AND meta_key = "'.$_GET['lang'].'"';
		$count  =  $data->select(" * ", " meta ", $where);
		$r = $data->getObjectResults();	
		$r->menu_items = $r->meta_value;
	} else {
		$data = new Database();
		$where = 'menu_id = '.$menuid;
		$count  =  $data->select(" * ", " menus ", $where);
		$r = $data->getObjectResults();	
	}
	

	if ($r->menu_items != '') {
		$menu = json_decode($r->menu_items,true);
	} else {
		$menu = array();
	}

	$menuitem =  array('title' => $title, 'url' => $url, 'id' => $id);
	if ($newwindow == 1) $menuitem['newwindow'] = 1;

	if ($parent != '') { //third  level
		if ( strpos($parent, '|') !== false )  {

			$parent = explode('|', $parent);

			if (!isset($menu[$parent[0]]['childs'])) {
				$menu[$parent[0]]['childs'] = array();
			}
			if (!isset($menu[$parent[0]]['childs'][$parent[1]]['childs'] )) {
				$menu[$parent[0]]['childs'][$parent[1]]['childs'] = array();
			}
			$menu[$parent[0]]['childs'][$parent[1]]['childs'][slugify($title)] = $menuitem;	

		} else {//seecond level
			if (!isset($menu[$parent]['childs'])) {
				$menu[$parent]['childs'] = array();
			}
			$menu[$parent]['childs'][slugify($title)] = $menuitem;		
		}
		
	} else {//no parent
		$menu[slugify($title)] = $menuitem;	
	}
	

	$menu = escapeJsonString(json_encode($menu));

	if ( isset($_GET['lang']) ) { //if its not the default language, save it in a meta
		$data = new Database();
		$arr = array(
		    'meta_value' => $menu
		);
		
		$where = 'meta_posttype = "menu" AND meta_postid = '.$menuid.' AND meta_key = "'.$_GET['lang'].'"';
		$data->update(" meta ", $arr, $where);
		
	} else { //default alnguage, update table

		$data = new Database();
		$arr = array(
			       'menu_items' => $menu
			       );
		$count  =  $data->update(" menus ", $arr, "menu_id = $menuid");
		$id = $data->lastid();
	}
	//echo $menu;

}

if (isset($_POST['action']) AND $_POST['action'] == 'savemenu') {

	

	
	foreach($_POST as $nombre_campo => $valor){ if (!is_array($valor)) $asignacion = "\$" . $nombre_campo . "='" . addslashes(htmlspecialchars($valor)) . "';"; eval($asignacion); }//end foreach

	$menuid = $_POST['menu'];
	$menudata = json_decode( stripslashes($_POST['menudata']));
	$menudata = escapeJsonString(json_encode($menudata));

	if ( isset($_GET['lang']) ) {
		$data = new Database();
		$arr = array(
		    'meta_value' => $menudata
		);
		
		$where = 'meta_posttype = "menu" AND meta_postid = '.$menuid.' AND meta_key = "'.$_GET['lang'].'"';
		$data->update(" meta ", $arr, $where);
	} else {
		$data = new Database();
		$arr = array(
			       'menu_items' => $menudata
			       );
		$count  =  $data->update(" menus ", $arr, "menu_id = $menuid");
	}

	

	
	exit;

}


if (isset($_POST['action']) AND $_POST['action'] == 'addmenu-custom') {
	
	foreach($_POST as $nombre_campo => $valor){ if (!is_array($valor)) $asignacion = "\$" . $nombre_campo . "='" . addslashes(htmlspecialchars($valor)) . "';"; eval($asignacion); }//end foreach

	addmenuitem($menu, $parent, $customurl,  $title,  $newwindow);
	header('Location: '.$_POST['location']);
	exit;

}





if (isset($_POST['action']) AND $_POST['action'] == 'addmenu-page') {
	
	foreach($_POST as $nombre_campo => $valor){ if (!is_array($valor)) $asignacion = "\$" . $nombre_campo . "='" . addslashes(htmlspecialchars($valor)) . "';"; eval($asignacion); }//end foreach

	$data = new Database();
	$where = 'post_id = '.$page;
	$count  =  $data->select(" * ", " post ", $where);
	$r = $data->getObjectResults();

	addmenuitem($menu, $parent, $r->post_url, $r->post_title, 0, $r->post_id);
	header('Location: '.$_POST['location']);
	exit;

}




if (isset($_POST['action']) AND $_POST['action'] == 'addmenu-cat') {
	
	foreach($_POST as $nombre_campo => $valor){ if (!is_array($valor)) $asignacion = "\$" . $nombre_campo . "='" . addslashes(htmlspecialchars($valor)) . "';"; eval($asignacion); }//end foreach

	$data = new Database();
	$where = 'cat_id = '.$page;
	$count  =  $data->select(" * ", " categories ", $where);
	$r = $data->getObjectResults();

	addmenuitem($menu, $parent, 'shop/'.$r->cat_url, $r->cat_name, 0, $r->cat_id);
	header('Location: '.$_POST['location']);
	exit;

}



include('includes/header.php');



$data = new Database();
$where = 'menu_id = '.$_GET['id'];
$count  =  $data->select(" * ", " menus ", $where);
if ( $count == 0 ){
	$data = new Database();
	$arr = array(
		       'menu_id' => $_GET['id']
		       );
	$count  =  $data->insert(" menus ", $arr);
} else {
	$r = $data->getObjectResults();
}


if ( isset($_GET['lang']) ) {
	$data = new Database();
	$where = 'meta_posttype = "menu" AND meta_postid = '.$_GET['id'].' AND meta_key = "'.$_GET['lang'].'"';
	$count  =  $data->select(" * ", " meta ", $where);
	if ( $count == 1) {
		$r2 = $data->getObjectResults();	
		$r->menu_items = $r2->meta_value;	
	} else {
		$data = new Database();
		$arr = array(
			       'meta_postid' => $_GET['id'],
			       'meta_value' => $r->menu_items, //save default language items as starting point
			       'meta_posttype' => 'menu',
			       'meta_key' => $_GET['lang'],
			       );
		$count  =  $data->insert(" meta ", $arr);
	}	
}
?>

            
<div class="content list row menumanager">

	<h2 class="title">Menu manager </h2>

	<?php
	global $languages;
	if ( isset($languages) ) {
		?>
		<div class="columns medium-12">
		<h5>Language</h5>
		<a href="?id=<?php echo $_GET['id']; ?>&posttype=<?php echo $_GET['posttype']; ?>" class="button tiny  <?php if (isset($_GET['lang'])) echo 'secondary';?> ">Default</a>
		<?php 
		foreach ($languages as $key => $value) {
			?>
			<a href="?id=<?php echo $_GET['id']; ?>&posttype=<?php echo $_GET['posttype']; ?>&lang=<?php echo $key; ?>" class="button tiny <?php if (!isset($_GET['lang']) OR isset($_GET['lang']) && $_GET['lang'] != $key ) echo 'secondary';?>"><?php echo $value; ?></a>
		<?php } ?>
		</div>
		<?php
	}
	?>



	<?php if ( isset($_GET['title']) ) {?>
	<label for="">Menu title</label>
	<input type="text" name='menutitle' value='<?php echo $r->menu_title;?>'>
	<?php } ?>

	<div class="row">
		<div class="large-4 columns">
			<h3>Add item</h3>

			<?php 
			if ($_GET['posttype'] != '') {

				$types = explode(',', $_GET['posttype']);
				foreach ($types as $v) {
					
				?>
			<form action="" class='panel pageadd' id='' method='post'>
				<h4><?php echo ucwords($v); ?></h4>
				<input type="hidden" name='action' value='addmenu-page'>
				<?php
				$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
				$url =  $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				?>
				<input type="hidden" name='location' value='<?php echo $url; ?>'>
				<input type="hidden" name='menu' value='<?php echo $_GET['id']; ?>'>

				<?php
				$data = new Database();
				$where = 'post_type = "'.$v.'" AND post_parent = 0';
				$count  =  $data->select(" * ", " post ", $where);
				?>
				<select name="page" id="">
					<option value="">Select</option>
					<?php
					while($r = $data->getObjectResults()){?>
					<option value="<?php echo $r->post_id;?>">
						<?php echo $r->post_title;?>
					</option>

					<?php
					$data2 = new Database();
					$where = 'post_type = "page" AND post_parent = '.$r->post_id;
					$count  =  $data2->select(" * ", " post ", $where);
					?>
					<?php
					while($r2 = $data2->getObjectResults()){?>
					<option value="<?php echo $r2->post_id;?>">
						--- <?php echo $r2->post_title;?>
					</option>

						<?php
						$data3 = new Database();
						$where = 'post_type = "page" AND post_parent = '.$r2->post_id;
						$count  =  $data3->select(" * ", " post ", $where);
						?>
						<?php
						while($r3 = $data3->getObjectResults()){?>
						<option value="<?php echo $r3->post_id;?>">
							--- --- <?php echo $r3->post_title;?>
						</option>
						<?php } ?>
					<?php } ?>

					<?php } ?>
				</select>

				<?php
				if ($_GET['par'] ==1) {
				$data = new Database();
				$where = 'post_type = "menu" AND post_parent = 0';
				$count  =  $data->select(" * ", " post ", $where);
				?>
				<select name="parent" id="">
					<option value="">Parent element</option>
					<?php
					$data = new Database();
					$where = 'menu_id = '.$_GET['id'];
					$count  =  $data->select(" * ", " menus ", $where);
					$r = $data->getObjectResults();

					if ($r->menu_items != '') {
						$menu = json_decode($r->menu_items);
					} else {
						$menu = array();
					}
					if (count($menu) > 0)
					foreach ($menu as $k => $r) {
					?>
					<option value="<?php echo $k;?>">
						<?php echo $r->title;?>
					</option>
					<?php
					if ( count($r->childs) > 0 ) {
						foreach ($r->childs as $kk =>  $rr) {
							?>
							<option value="<?php echo $k;?>|<?php echo $kk;?>">
								- <?php echo $rr->title;?>
							</option>
							<?php
						}
					}
					?>
					<?php } ?>
				</select>
				<?php } ?>
				

				

				<input type="submit" value='Add <?php echo ucwords($v);?>' class="button tiny">
			</form>
			<?php } //foreeach ?>
			<?php } ?>










			<?php 
			if ($_GET['cat'] != '') {

				$types = explode(',', $_GET['cat']);
				foreach ($types as $v) {
					
				?>
			<form action="" class='panel ' id='' method='post'>
				<?php
				$data = new Database();
				$where = 'cat_type = "'.$v.'" AND cat_parent = 0';
				$count  =  $data->select(" * ", " categories ", $where);
				?>
				<h4><?php echo ucwords( str_replace('-', ' ', $v) );?> Categories</h4>
				<input type="hidden" name='action' value='addmenu-cat'>
				<?php
				$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
				$url =  $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				?>
				<input type="hidden" name='location' value='<?php echo $url; ?>'>
				<input type="hidden" name='menu' value='<?php echo $_GET['id']; ?>'>

				<select name="page" id="">
					<option value="">Select</option>
					<?php
					while($r = $data->getObjectResults()){?>
					<option value="<?php echo $r->cat_id;?>">
						<?php echo $r->cat_name;?>
					</option>

					<?php
					$data2 = new Database();
					$where = 'cat_type = "'.$v.'" AND cat_parent = '.$r->cat_id;
					$count  =  $data2->select(" * ", " categories ", $where);
					?>
					<?php
					while($r2 = $data2->getObjectResults()){?>
					<option value="<?php echo $r2->post_id;?>">
						--- <?php echo $r2->post_title;?>
					</option>
					<?php } ?>

					<?php } ?>
				</select>

				<?php
				if ($_GET['par'] ==1) {
				$data = new Database();
				$where = 'post_type = "menu" AND post_parent = 0';
				$count  =  $data->select(" * ", " post ", $where);
				?>
				<select name="parent" id="">
					<option value="">Parent element</option>
					<?php
					$data = new Database();
					$where = 'menu_id = '.$_GET['id'];
					$count  =  $data->select(" * ", " menus ", $where);
					$r = $data->getObjectResults();

					if ($r->menu_items != '') {
						$menu = json_decode($r->menu_items);
					} else {
						$menu = array();
					}
					if (count($menu) > 0)
					foreach ($menu as $k => $r) {
					?>
					<option value="<?php echo $k;?>">
						<?php echo $r->title;?>
					</option>
					<?php
					if ( count($r->childs) > 0 ) {
						foreach ($r->childs as $kk =>  $rr) {
							?>
							<option value="<?php echo $k;?>|<?php echo $kk;?>">
								- <?php echo $rr->title;?>
							</option>
							<?php
						}
					}
					?>
					<?php } ?>
				</select>
				<?php } ?>
				

				

				<input type="submit" value='Add <?php echo ucwords($v);?>' class="button tiny">
			</form>
			<?php } //foreeach ?>
			<?php } ?>















			<form action="" class='panel ' id='' method='post'>
				<input type="hidden" name='action' value='addmenu-custom'>
				<?php
				$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
				$url =  $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				?>
				<input type="hidden" name='location' value='<?php echo $url; ?>'>
				<input type="hidden" name='menu' value='<?php echo $_GET['id']; ?>'>

				<h4>Custom URL</h4>
			
				<label for="">Title</label>
				<input type="text" name='title' name='title'>

				<label for="">URL</label>
				<input type="text" name='customurl' name='customurl'>

				<input type="checkbox" class="newwindow" value='1' name='newwindow'>
				<label for="">New window</label>

				<?php
				if ($_GET['par'] ==1) {
				$data = new Database();
				$where = 'post_type = "menu" AND post_parent = 0';
				$count  =  $data->select(" * ", " post ", $where);
				?>
				<select name="parent" id="">
					<option value="">Parent element</option>
					<?php
					$data = new Database();
					$where = 'menu_id = '.$_GET['id'];
					$count  =  $data->select(" * ", " menus ", $where);
					$r = $data->getObjectResults();

					if ($r->menu_items != '') {
						$menu = json_decode($r->menu_items);
					} else {
						$menu = array();
					}
					if (count($menu) > 0)
					foreach ($menu as $k => $r) {
					?>
					<option value="<?php echo $k;?>">
						<?php echo $r->title;?>
					</option>
					<?php
					if ( count($r->childs) > 0 ) {
						foreach ($r->childs as $kk =>  $rr) {
							?>
							<option value="<?php echo $k;?>|<?php echo $kk;?>">
								- <?php echo $rr->title;?>
							</option>
							<?php
						}
					}
					?>
					<?php } ?>
				</select>
				<?php } ?>

				

				<input type="submit" value='Add' class="button tiny">
			</form>


		</div>


		<div class="large-8 columns">
			<a href="#" class="button tiny right" id="saveorder">Save menu</a>
			<h3>Menu</h3>
			<table class="listtable top">
				<tbody>
				<?php
				$data = new Database();
				$where = 'menu_id = '.$_GET['id'];
				$count  =  $data->select(" * ", " menus ", $where);
				if ($count > 0) $r = $data->getObjectResults();


				if ( isset($_GET['lang']) ) {
					$data = new Database();
					$where = 'meta_posttype = "menu" AND meta_postid = '.$_GET['id'].' AND meta_key = "'.$_GET['lang'].'"';
					$count  =  $data->select(" * ", " meta ", $where);
					if ( $count == 1 ) {
						$r2 = $data->getObjectResults();	
						$r->menu_items = $r2->meta_value;	
					}
				}

				if ($r->menu_items != '') {
					$menu = json_decode($r->menu_items);
				} else {
					$menu = array();
				}

				//print_r($menu);

				if (count($menu) > 0)
				foreach ($menu as $k => $r) {
				?>
				<tr >
					<td data-key='<?php echo $k;?>' class='menutop'>
						<a href="#" class="del button alert tiny">X</a>
						<h5>
							<input type="text" class="title" value='<?php echo $r->title;?>'>
							<input type="text" class="small" value='<?php echo $r->url;?>'>
							<input type="hidden" class="id" value='<?php echo $r->id;?>'>
							<input type="checkbox" class="newwindow" value='1' <?php if (isset($r->newwindow) AND $r->newwindow == 1) echo 'checked';?>>
							<label for="">New window</label>
						</h5>
						<div class="drag">
							<div class="valignout">
								<div class="valignin">
									<i class="fa fa-arrows-v"></i>
								</div>
							</div>
						</div>

						<?php
						//print_r($r->childs);
						if (isset($r->childs) AND count($r->childs) > 0 ) {?>
						<table class="childs listtable">
							<tbody>
							<?php
							
							foreach ($r->childs as $ck => $c) {
								?>
							<tr  class='child' data-key='<?php echo $ck;?>'>
								<td>
									<a href="#" class="del button alert tiny">x</a>
									<input type="text" class="childtitle" value='<?php echo $c->title;?>'>
									<input type="text" class="small" value='<?php echo $c->url;?>'>
									<input type="checkbox" class="newwindow" value='1' <?php if (isset($c->newwindow)) echo 'checked';?>>
									<label for="">New window</label>
									<div class="drag">
										<div class="valignout">
											<div class="valignin">
											<i class="fa fa-arrows-v"></i>
											</div>
										</div>
									</div>

									<?php
									//print_r($r->childs);
									if (isset($c->childs) ) {?>
									<table class="childs listtable">
										<tbody>
										<?php
										
										foreach ($c->childs as $cck => $cc) {
											?>
										<tr  class='child2' data-key='<?php echo $cck;?>'>
											<td>
												<a href="#" class="del button alert tiny">X</a>
												<input type="text" class="childtitle" value='<?php echo $cc->title;?>'>
												<input type="text" class="small" value='<?php echo $cc->url;?>'>
												<input type="checkbox" class="newwindow" value='1' <?php if (isset($cc->newwindow)) echo 'checked';?>>
												<label for="">New window</label>
												<?php /* <div class="drag"><i class="fa fa-arrows-v"></i></div> */ ?>


											</td>
										</tr>
										<?php } ?>
										</tbody>
									</table>
									<?php } ?>


								</td>
							</tr>
							<?php } ?>
							</tbody>
						</table>
						<?php } ?>
						

					</td>
				</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	
</div>



 <script>
  $(function() {

  	function convertToSlug(Text)
	{
		console.log(Text);
	    return Text
	        .toLowerCase()
	        .replace(/[^\w ]+/g,'')
	        .replace(/ +/g,'-')
	        ;
	}

  	$('#saveorder').click(function(e) {
  		
  		var menuobj = {};
  		$('.menutop').each(function () {
  			var k = $(this).data('key');
  			var obj = {};
  			obj.title = $('h5 .title',this).val();
  			obj.url = $('h5 .small',this).val();
  			obj.id = $('h5 .id',this).val();
  			if ( $('.newwindow',this).is(':checked') ) obj.newwindow = 1;
  			
  			obj.childs = {};
  			$('.child',this).each(function () {
  				var kchild = $(this).data('key');
  				var objchild = {};
	  			objchild.title = $('.childtitle',this).val();
	  			objchild.url = $('.small',this).val();
	  			if ( $('.newwindow',this).is(':checked') ) objchild.newwindow = 1;

	  			obj.childs[convertToSlug(objchild.title)] = objchild;
  			});

  			menuobj[k] = obj;
  		});
  		console.log(menuobj);

  		$.post("includes/actions/actions.php", 
			    { 
			      action: "savemenu",
			      menudata: JSON.stringify(menuobj) ,
			      <?php if ( isset($_GET['title']) ) {?>
			      menutitle: $('input[name="menutitle"]').val() ,
			      <?php } ?>
			      menu: <?php echo $_GET['id'];?>
			      <?php if ( isset($_GET['lang']) ) {?>
			      ,lang: '<?php echo $_GET['lang'];?>'
			      <?php } ?>
			    },
			    function(data){
			        console.log(data); 
			        alert('Menu saved');
			    }
			);


	  	e.preventDefault();
	});

  	$('.listtable .del').click(function(e) {
  		$(this).parent().parent().remove();
	  	e.preventDefault();
	});

    $( ".listtable.top tbody" ).sortable();
    $( ".listtable.childs tbody" ).sortable();

    

  });
  </script>

<?php include('includes/footer.php');?>