<?php
include_once('../functions.php');
fieldtop( pathinfo(__FILE__, PATHINFO_FILENAME) );
?>
<div class="panel">
	<?php flex_buttons(0,$field);?> 
	

	<div class="row">
		<div class="columns medium-12">
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
					'label' => '',
					'name' => 'text',
					'type' => 'mce',
					'isrepeater' => 0
					]
				);
			?>
		</div>
		
	</div>

	

 
</div>