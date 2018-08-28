<td>
	<?php
	if (isset($field['encrypted'])) {
		$index = 'DECODE('.$field['field'].', "'.$db_salt.'")';
		echo $r[$index]; 
	} else
		echo $r[$field['field']]; 
	?>
</td>