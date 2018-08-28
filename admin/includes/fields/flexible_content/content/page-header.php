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
			'label' => 'Text',
			'name' => 'text',
			'type' => 'mcesimple',
			'isrepeater' => 0
			]
		);
	?>

	<?php 
	field( [
			'label' => 'Image',
			'name' => 'image',
			'type' => 'image',
			'size' => '1600_650',
			'isrepeater' => 0
			]
		);
	?>


</div>