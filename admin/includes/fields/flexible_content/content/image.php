<?php
include_once('../functions.php');
fieldtop( pathinfo(__FILE__, PATHINFO_FILENAME) );
?>
<div class="panel">
	<?php flex_buttons(0,$field);?> 


	<?php 
	field( [
			'label' => 'Text',
			'name' => 'text',
			'type' => 'text',
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

	<div class="row">
		<div class="columns medium-6">
			<?php 
			field( [
					'label' => 'Button text',
					'name' => 'button',
					'type' => 'text',
					'isrepeater' => 0
					]
				);
			?>		
		</div>
		<div class="columns medium-6">
			<?php 
			field( [
					'label' => 'Button Link',
					'name' => 'link',
					'type' => 'text',
					'isrepeater' => 0
					]
				);
			?>		
		</div>
	</div>

	


	

</div>