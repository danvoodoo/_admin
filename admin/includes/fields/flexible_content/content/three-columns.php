<?php
include_once('../functions.php');
fieldtop( pathinfo(__FILE__, PATHINFO_FILENAME) );
?>
<div class="panel">
	<?php flex_buttons(0,$field);?> 
	

	<div class="row">
		<div class="columns medium-4">
			
			<?php 
			field( [
					'label' => '',
					'name' => 'text1',
					'type' => 'mce',
					'isrepeater' => 0
					]
				);
			?>
		</div>

		<div class="columns medium-4">
			
			<?php 
			field( [
					'label' => '',
					'name' => 'text2',
					'type' => 'mce',
					'isrepeater' => 0
					]
				);
			?>
		</div>

		<div class="columns medium-4">
			
			<?php 
			field( [
					'label' => '',
					'name' => 'text3',
					'type' => 'mce',
					'isrepeater' => 0
					]
				);
			?>
		</div>
	</div>

	


</div>