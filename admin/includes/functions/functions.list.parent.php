<?php

	global $p_edit;
	global $db_salt;
	$order= $extras['order'];

	
	
	$where = ' 1 = 1 ';
	if (isset($extras['list_where'])) $where .= ' AND '.$extras['list_where'];
	
	if (isset($activefilter)) $where.= 'AND '.$activefilterwhere;
	
	$where.= 'AND '.$extras['page_parent'].' = '.$r[$extras['id']];
	
	if (isset($extras['customsql'])) $sql = $extras['customsql'];
	
	$dataparent = new Database();
	$count  =  $dataparent->select(" * ",  $extras['table'] , $where, $extras['order']);

	
	$a=0;
	while($r_parent = $dataparent->getObjectResults()){

		$r_parent =  (array) $r_parent;

	
		if (isset($extras['table_order'])) { // si hay tabla orden me fijo cual es
		
			if (isset($r_parent[$extras['table_order']]) and $r_parent[$extras['table_order']] != '' and $r_parent[$extras['table_order']] != 0 ) 
				$orden = $r_parent[$extras['table_order']];
			else 
				$orden = $r_parent[$extras['id']];
				
		} else //sino el orden es el id
			$orden = $r_parent[$extras['id']];
	?>
	<tr id='<?php echo $r_parent[$extras['id']]?>' class="child" title='<?php echo $orden;?>'>

		
		<?php
		$r = $r_parent;
		foreach($fields as $field){
			include('includes/fields-list/'.$field['type'].'.php');			
			}
		?>
		
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

	</tr><!--fin nota-->
	<?php
	}?>
	</ul>
	

	