<?php
	global $p_edit;
	global $db_salt;
	

	if (isset($extras['widelist'])) {?>
		<style> 
		    #wrapper{
				width: auto;
			}
		</style> 
		<div class="content list row wide">	
	<?php } else { ?>
		<div class="content list row">	
	<?php }



	$url = strtok($_SERVER["REQUEST_URI"],'?');
	?>	
	<h2 class="title">
		<?php echo $title;?> <i class="fa fa-angle-right"></i> List <br> 
		<?php if ( !isset($extras['hidenew']) ) {?>
		<a href="<?php echo $url; ?>" class="button tiny"><i class="fa fa-plus" aria-hidden="true"></i> Add new <?php echo $title_singular;?></a>
		<?php } ?>
	</h2>
	<?php

	include('functions.list.search.php');
	include('functions.list.filter.php');
	
	showmessage(); 

	$where = ' 1 = 1 ';
	if (isset($extras['list_where']) AND $extras['list_where'] != '') {
		$where .= ' AND '.$extras['list_where'];
	}

	if ( isset($activefilterwhere) AND $activefilterwhere != '' ){
		$where .= $activefilterwhere;
	}

	if (isset($extras['page_parent'])) {
		$where .= ' AND '.$extras['page_parent'].' = 0';
	}

	$datafields = '*';
	foreach($fields as $field){ // encrypted fields
		if (isset($field['encrypted']) and $field['encrypted'] == 1) 
			$datafields.= ', DECODE('.$field['field'].', "'.$db_salt.'")';
	}


	$tableselect = ''; //for aditional meta tables
	if (isset($_GET['s'])) {
		$where .= ' AND ( 1 = 2 ';
		foreach ($extras['search']['fields'] as $k => $s) {
			if ( isset($extras['metasearch']) AND $extras['metasearch'][$k] == 1 ) {
				$where .= ' OR m'.$k.'.meta_key = "'.$s.'" AND m'.$k.'.meta_value LIKE "%'.$_GET['s'].'%" AND post_id = m'.$k.'.meta_postid';
				$tableselect .= ', meta AS m'.$k;
			} else {
				$where .= ' OR '.$s.' LIKE "%'.$_GET['s'].'%"';	
			}
			
		}
		$where .= ' ) ';
	}


	if ( $tableselect != '') { //meta search
		$where .= ' GROUP BY post_id';
	}

	$data = new Database();
	$totalrecords = $data->select( $datafields,  $extras['table'] , $where, $extras['order']);
	$totalpages = ceil($totalrecords / $extras['per_page']);

	$_SESSION['page'] = $extras['page'];

	$pagg = $extras['page'] * $extras['per_page'] ;
	$pagsig = (($extras['page']  + 1) > $totalpages) ? $totalpages : ($extras['page']  + 1);
	$pagant = (($extras['page']  - 1) < 0) ? 0 : ($extras['page']  - 1);

	if ($totalrecords == 0 ) {?>
	<div data-alert class="alert-box alert">
	  No records found.
	</div>
	<?php }


	$limit = " LIMIT ".$pagg.','.( $extras['per_page']+5 );
	$total  =  $data->select( $datafields,  $extras['table'].$tableselect , $where, $extras['order'].$limit);

	//$total = ceil($total / $extras['per_page']);
	
	$count = 0;
	$ancho = 0;
	echo '<style>';
	foreach($fields as $field){
		echo '.'.$field['field'] .' {width:'.$field['width'].'px !important} ';
		$ancho+= $field['width'];
	}
	$ancho = $ancho+100;
	echo '</style>';

	if (isset($extras['table_order'])) { // if there is order table, show help 
		if ( ( isset($extras['orderonlyfiltered']) AND $extras['orderonlyfiltered'] == 1 AND  $activefilterwhere != '' ) OR ! isset($extras['orderonlyfiltered']) OR $extras['orderonlyfiltered']  == 0 ){ 
		?>
		<div data-alert class="alert-box orderalert">
		  	Drag up and down the items to sort.

		  	<div class='orden' id='orden' >
				<a href='javascript:void(0)' id='saveorder' class='btn' style='display:none;'>Save Order</a>
				<img src="img/ajax-loader.gif"  style='display:none;'/>
				<div style='display:none;'>Order Saved</div>
			</div>

		</div>
	<?php } else { ?>
		<div data-alert class="alert-box orderalert ">
		  	To order, first filter the list
		</div>
	<?php } }


	?>
	<table class='listtable'>
		<thead>
			<tr>
				<?php
				foreach($fields as $field){
					echo '<th class="'.$field['field'] .'">'.$field['name'].'</th> ';
				}?>
				<th ></th>
			</tr>
		</thead>
		


	<?php





	$a=0;
	while($r = $data->getObjectResults()){

		if ( isset($extras['post_type']) ) {
			getmetas( $r->{ $extras['id'] }, $r->{ $extras['post_type'] } );
		}

		$r =  (array) $r;

		if (isset($extras['table_order'])) { // si hay tabla orden me fijo cual es
			if (isset($r[$extras['table_order']]) and $r[$extras['table_order']] != '' and $r[$extras['table_order']] != 0 )
				$orden = $r[$extras['table_order']];
			else
				$orden = $r[$extras['id']];
		} else //sino el orden es el id
			$orden = $r[$extras['id']];

	?>
	<tbody>
	<tr id='<?php echo $r[$extras['id']]?>' title='<?php echo $orden;?>'>

		<?php
		foreach($fields as $field){
			include('includes/fields-list/'.$field['type'].'.php');
		}?>

		<td class='edit'>
		<?php
		$edit = '';
		if (isset($_GET['t'])) $edit.= '&t='.$_GET['t'];
		if (isset($_GET['c'])) $edit.= '&c='.$_GET['c'];

		if (isset($extras['table_state'])) {//si paso parametro de state muestro el boton
		?>

			<div class="switch round small">
			  <input id="state<?php echo $r[$extras['id']]?>" type="checkbox" value="1"
			  <?php if($r[$extras['table_state']] == 1 ) echo 'checked';?> name="<?php echo $extras['table_state'];?>" data-id='<?php echo $r[$extras['id']]?>' class='stateswitch'>
			  <label for="state<?php echo $r[$extras['id']]?>"></label>
			</div>

		<?php }?>

		<?php if (!isset($extras['noedita'])) {//if exists, hide the buttons ?>
			<a href="<?php echo $p_edit;?>?id=<?php echo $r[$extras['id']].$edit?>" title="Edit" class="button">
				<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
			</a>

			<?php if (!isset($extras['parent_lock']) or isset($extras['parent_lock']) and $r[$extras['parent_table']] != 0 ) {//si paso oculto los botones ?>
			<?php if (!isset($extras['content_lock'])
				  OR isset($extras['content_lock']) AND $_SESSION['level'] == 10
				  OR isset($extras['content_lock']) AND $r[$extras['content_lock']] == 0 ) {//if conten lock is not set, or is set, but level is 10, or is set, and lock is 0 ?>
				<a href="<?php echo $p_edit;?>?id=<?php echo $r[$extras['id']].$edit?>&action=delete" class="button red" onclick=' return confirm("Are you sure you want to delete this item?"); '>
					<i class="fa fa-trash-o" aria-hidden="true"></i>
				</a>
				
			<?php }} ?>


		<?php } ?>
		</td>
	</tr>

		<?php
		if (isset($extras['page_parent'])) include('functions.list.parent.php');
		    ?>
		    </tbody>
	<?php
	}?>
	
	</table>



	
	<div class="pag">
		<?php
		$qs = '';
		if (!isset($_GET['p'])) $_GET['p'] = 0;
		foreach ($_GET as $key => $value){
		    if ($key  == 'p'){
		        $qs .= $key  . '=' . $pagant . '&';
		    } elseif ($key  != 'edit'){
		        $qs .= $key  . '=' . urlencode($value) . '&';
		    }
		}
		?>
		<?php if ($pagant<>$extras['page']) { ?>
			<a href="<?php echo $p_edit.'?'.$qs;?>" class="btn ant" title="Anterior"><span class="ico"></span>Previous</a>
		<?php }?>

		<?php
		$qs = '';
		foreach ($_GET as $key => $value){
		    if ($key  == 'p'){
		        $qs .= $key  . '=' . $pagsig . '&';
		    } elseif ($key  != 'edit'){
		        $qs .= $key  . '=' . urlencode($value) . '&';
		    }
		}
		?>
		<?php if ($pagsig<>$totalpages) { ?>
			<a href="<?php echo $p_edit.'?'.$qs;?>" class="btn sig" title="Siguiente"><span class="ico"></span>Next</a>
		<?php }?>

		<div>
			<form>
				<span>Showing Page</span>
				<select name="pagina" onchange="document.location.href='?list=1&p='+this.value;">
				<?php for($i=1;$i<=$totalpages;$i++){ ?>
				<option <?php if ($extras['page'] == ($i-1)) { echo "selected"; } ?> value="<?php echo ($i-1)?>"><?php echo $i?></option>
				<?php } ?>
				</select>
				<span>of <?php echo $totalpages?></span>
			</form>
        </div>
	</div>
	

	<script type="text/javascript">
	$(document).ready(function () {
			$('.stateswitch').change(function() {
				if ($(this).is(':checked')){
					val = 1;
				} else {
					val = 0;
				}
				id = $(this).data('id');

				$.post("<?php echo $p_edit;?>?action=state&table=<?php echo $extras['table'];?>&table_state=<?php echo $extras['table_state'];?>&table_id=<?php echo $extras['id'];?>", 
					    { 
					          val: val,
					          id: id
					          },
					              function(data){
	              	                console.log(data); //  2pm
             	                    });

			});
	});
	</script>
	
	<?php if (isset($extras['table_order'])) { if ( ( isset($extras['orderonlyfiltered']) AND $extras['orderonlyfiltered'] == 1 AND  $activefilterwhere != '' ) OR ! isset($extras['orderonlyfiltered']) OR $extras['orderonlyfiltered']  == 0 ){  ?>
	<script type="text/javascript" language="javascript">
		$(document).ready(function(){
	
			txt = '';
			$('.nota').not('child').each( 
				function(index) { 
					txt+= $(this).attr('title') + ','; 
					});
			$('#peso').html(txt);
	
			
			$('.listtable').sortable({ 
				opacity: 0.8, 
				stop: verificarDatos,
				items: "tbody"
			});


			$('.listtable tbody').each(function() {
				$(this).sortable({ 
					opacity: 0.8, 
					stop: verificarDatos,
					items: ".child"
				});
			});


			
			
			$('#saveorder').click(function () {
			
				ids = [];
				$('.listtable tbody tr').each(function() {
					ids.push($(this).attr('id'));
				});	
				console.log(ids);
				$.post("includes/actions/actions.php?action=order&table=<?php echo $extras['table'];?>&table_order=<?php echo $extras['table_order'];?>&table_id=<?php echo $extras['id'];?>", 
					    { 
					          ids: ids
					          },
					              function(data){
	              	                console.log(data); //  2pm

	              	                alert('Order saved');
             	                    });
			});
		});
	
		function verificarDatos(){
			
			txt = '';
			$('#orden img').hide();
			$('#orden div').hide();
			
			$('#saveorder').show();
			$('.nota').each( 
				function(index) { 
					
					txt+= $(this).attr('id') + ','; 
					//alert($(this).attr('id'));
					
					});
			$('#ids').html(txt);
		}
		
	</script>
	<div id='peso' style='display:none'></div>
	<div id='ids' style='display:none'></div>
	<?php } } ?>
	
