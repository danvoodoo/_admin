<td>
	<?php
	foreach($field['values'] as $k => $v) {
		if ($k == $r[$field['field']]) echo $v;
	}
	?>
</td>