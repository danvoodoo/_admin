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
					if (isset($r)) $v = $r[$field['field']]; else $v ='';


				//print_r($field);
	if (isset($field['value']) AND $v == '') $v = $field['value'];

	$readonly = '';
	if (isset($field['readonly'])) $readonly = 'readonly';

	echo '<input '.$readonly.' class="colorpicker" name="'.$field['field'].'" type="text" value="'.$v.'">'; 
	?>
</div>




<script src='includes/fields/colours/spectrum.js'></script>
<link rel='stylesheet' href='includes/fields/colours/spectrum.css' />
<script>
$(".colorpicker").spectrum({
	preferredFormat: "hex"
});
</script>