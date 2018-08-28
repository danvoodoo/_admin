<?php if (!isset($field['columns'])) $field['columns'] = 12;?>
<div class="medium-<?php echo $field['columns'];?> columns">
	<label for=""><?php echo $field['name'];?></label>
	<?php
	if (isset($r)) $v = $r[$field['field']]; else $v ='';

	echo '<textarea class="txt"  name="'.$field['field'].'" style="height:'.$field['height'].'px">'.$v.'</textarea>'; 
	?>
	<?php
	if (isset($field['help'])) echo '<p>'.$field['help'].'</p>';
	?>
</div>