<?php if (!isset($field['columns'])) $field['columns'] = 12;?>
<div class="medium-<?php echo $field['columns'];?> columns">
	<?php
	if (isset($r)) $v = $r[$field['field']]; else $v ='';

	if ( !isset( $field['size'] ) ) $field['size'] = '200_200';
	?>

	<?php
	imageupload(array(
		'name' => $field['field'],
		'label' => $field['name'],
		'size' => $field['size'],
		'value' => $v
		));
	?>

</div>