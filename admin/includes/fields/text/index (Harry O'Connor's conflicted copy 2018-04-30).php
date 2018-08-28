<?php if (!isset($field['columns'])) $field['columns'] = 12;?>
<div class="medium-<?php echo $field['columns'];?> columns">
	<label for=""><?php echo $field['name'];?></label>
	<?php
	if (isset($field['encrypted']))
					{
					$index = 'DECODE('.$field['field'].', "'.$db_salt.'")';
					if (isset($r)) $v = $r[$index]; else $v ='';
					}
				else
					if (isset($r)) $v = htmlentities(htmlspecialchars_decode ($r[$field['field']])); else $v ='';


				//print_r($field);
	if (isset($field['value']) AND $v == '') $v = $field['value'];

	$readonly = '';
	if (isset($field['readonly'])) $readonly = 'readonly';

	echo '<input '.$readonly.' class="txt" name="'.$field['field'].'" type="text" value="'.$v.'">'; 
	?>
</div>