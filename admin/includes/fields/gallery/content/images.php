<?php
include_once('../../flexible_content/functions.php');
fieldtop( pathinfo(__FILE__, PATHINFO_FILENAME) );
?>
<div class="panel">
	<?php flex_buttons(0,$field);?> 

	<div class="repeater">
		<div class="items">
			<?php
			if (!isset($co['repeater']))  $co['repeater'] = array( array() );
			$bb = 0;
			foreach ($co['repeater'] as $re) { $bb++;
				
			?>
			<div class="item">

				<?php 
				field( [
						'label' => 'Image',
						'name' => 'image',
						'type' => 'image',
						'size' => '200_200',
						'isrepeater' => 1
						]
					);
				?>

				<?php 
				field( [
						'label' => 'Title',
						'name' => 'text',
						'type' => 'text',
						'isrepeater' => 1
						]
					);
				?>
			</div>
			<?php } ?>

		</div>

		<a href="#" class="button repeater-add tiny success">Add image</a>
	</div>

</div>
