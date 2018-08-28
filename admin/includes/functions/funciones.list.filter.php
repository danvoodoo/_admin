<?php
if ( isset( $_POST['act'] ) AND $_POST['act'] == 'filters' ) {
	foreach($extras['filters'] as $f){
		$key = $extras['table'].'_'.$f['column_name'].'_filter' ;
		if ( $_POST[ $key ] == '' )
			unset( $_SESSION['filters'][ $key ] );
		else 
			$_SESSION['filters'][$key] = $_POST[ $key ];
	}
}

$activefilterwhere = '';
foreach($extras['filters'] as $f){
	$key = $extras['table'].'_'.$f['column_name'].'_filter' ;
	if (isset($_SESSION['filters'][$key]) AND $_SESSION['filters'][$key] != '' ) {
		$activefilterwhere .= ' AND '.$f['column_name'].' '.$f['equal'].' "'.$_SESSION['filters'][$key].'"';
	}
}

		
if (isset($extras['filters'])) {
?>
<div class="filtro">     	    
    <form action='<?php echo $_SERVER['PHP_SELF'];?>?list=1' method='post'>
    	<input type='hidden' value='filters' name='act' />
        <span class="tit">Filter <span class="ico"></span></span>
	<?php
	
		foreach($extras['filters'] as $f){

			$key = $extras['table'].'_'.$f['column_name'].'_filter' ;
			echo '<label>'.$f['label'].'</label>';

			if (isset($f['datepicker'])) {
				$v = '';
				if (isset($_SESSION['filters'][$key]) ) $v = $_SESSION['filters'][$key];
				echo '<input name="'.$key.'" class="datepicker" type="text" value="'.$v.'">';	
			} else {
				
				echo '<select name="'.$key.'">';
				
				echo '<option value="" >All</option>';
				
				foreach ($f['values'] as $k => $v) {
					
					$selected = '';
					if (isset($_SESSION['filters'][$key]) and $_SESSION['filters'][$key] == $k ) $selected = 'selected';

					echo '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
				
				}
				echo '</select>';
			}
			
		}
	?>
		<input type="submit" class="btn" value="Send" />
    </form>
</div><!--fin filtro-->	
<?php } ?>