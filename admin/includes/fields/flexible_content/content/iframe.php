<?php
include_once('../functions.php');
fieldtop( pathinfo(__FILE__, PATHINFO_FILENAME) );
?>
<div class="panel">
	<?php flex_buttons(0,$field);?> 
	
	<?php 
	field( [
			'label' => 'Title',
			'name' => 'title',
			'type' => 'text',
			'isrepeater' => 0
			]
		);
	?>

	<?php 
	field( [
			'label' => 'URL',
			'name' => 'url',
			'type' => 'text',
			'isrepeater' => 0
			]
		);
	?>


</div>