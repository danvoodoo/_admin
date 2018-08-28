<td>
	<?php
	if ($r[$field['field']] == 1) 
		echo $field['labels']['true']; 
	else 
		echo $field['labels']['false'];
	?>
</td>