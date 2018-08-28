<?php if (!isset($field['columns'])) $field['columns'] = 12;?>
<div class="medium-<?php echo $field['columns'];?> columns">

	<?php
	linkfield(array(
		'name' => $field['field'],
		'label' => $field['name'],
		'value' => $r[$field['field']]
		));
	?>
</div>



