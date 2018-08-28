<?php
include_once('../functions.php');
fieldtop( pathinfo(__FILE__, PATHINFO_FILENAME) );
?>
<div class="panel">
	<?php flex_buttons(0,$field);?> 
	<?php 
				field( [
						'label' => 'Main Title',
						'name' => 'title',
						'type' => 'text',
						'isrepeater' => 0
						]
					);
				?>
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
						'label' => 'Title',
						'name' => 'title',
						'type' => 'text',
						'isrepeater' => 1
						]
					);
				?>
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






				<div class="repeater">
				<div class="items row">
					<?php
					$cc = 0;
					//print_r($re);
					if ( !isset($re['repeater']) ) $re['repeater'] = array(array());
					foreach ($re['repeater'] as $re2) { $cc++;
						
					?>
				<div class="item columns medium-4 end">
					<?php 
						field( [
								'label' => 'Title',
								'name' => 'title',
								'type' => 'text',
								'isrepeater' => 1,
								'isrepeaterinsiderepeater' => 1
								]
							);
						?>
						<?php 
						field( [
								'label' => 'Image',
								'name' => 'image',
								'type' => 'image',
								'size' => '200_200',
								'isrepeater' => 1,
								'isrepeaterinsiderepeater' => 1
								]
							);
						?>
					</div>
					<?php } ?>

				</div>
				<a href="#" class="button repeater-add tiny success">Add image</a>
				</div>



			</div>
			<?php } ?>

		</div>

		<a href="#" class="button repeater-add tiny success">Add group</a>
	</div>

</div>
 