<td>
	<?php
	$cats = json_decode( $r[$field['field']] );
	echo ucwords( implode(', ', $cats) );
	?>
</td>