<?php
include_once('../functions.php');
fieldtop( pathinfo(__FILE__, PATHINFO_FILENAME) );
?>
<div class="panel">
	<?php flex_buttons(0,$field);?> 
	
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

	<div class="columns medium-12">
		<?php 
		field( [
				'label' => 'Image Position',
				'name' => 'align',
				'type' => 'radio',
				'values' => array(
					'l' => 'Left',
					'r' => 'Right',
					),
				'isrepeater' => 0
				]
			);
		?>

		<?php 
			field([
				'label' => 'Image Size',
				'name' => 'size',
				'type' => 'radio',
				'values' => array(
					'25' => '1/4',
					'50' => '1/2',
					'75' => '3/4',
				),
				'isrepeater' => 0
			]);
		?>

		<?php 
		field( [
				'label' => 'Image Shadow',
				'name' => 'image_shadow',
				'type' => 'checkbox',
				'isrepeater' => 0
				]
			);
		?>
	</div>
	
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
			'type' => 'mce',
			'isrepeater' => 0
			]
		);
	?>

	<?php 
	field( [
			'label' => 'Vertically Center Text',
			'name' => 'vertical_align',
			'type' => 'checkbox',
			'isrepeater' => 0
			]
		);
	?>


	


	





</div>