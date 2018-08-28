<?php if (!isset($field['columns'])) $field['columns'] = 12;?>
<div class="medium-<?php echo $field['columns'];?> columns">
	<label for=""><?php echo $field['name'];?></label>
	<?php
	if (isset($r)) $v = $r[$field['field']]; else $v ='';
	echo '<input '.$readonly.' class="number" name="'.$field['field'].'" type="number" value="'.$v.'">'; 
	?>
</div>