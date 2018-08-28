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
						'label' => 'Group Title',
						'name' => 'title',
						'type' => 'text',
						'isrepeater' => 1
						]
					);
				?>






				<div class="repeater">
				<div class="items row">
					<?php
					global $re2, $cc;
					$cc = 0;
					if ( !isset($re['repeater']) ) $re['repeater'] = array(array());
					foreach ($re['repeater'] as $re2) { $cc++;
						
					?>
				<div class="item">
					<div class="row">
						<div class="columns medium-6">
							<?php 
							field( [
									'label' => 'Position',
									'name' => 'position',
									'type' => 'text',
									'isrepeater' => 1,
									'isrepeaterinsiderepeater' => 1
									]
								);
							?>
						</div>
						<div class="columns medium-6">
							<?php 
							field( [
									'label' => 'Names (one per lin)',
									'name' => 'names',
									'type' => 'textarea',
									'row' => 3,
									'isrepeater' => 1,
									'isrepeaterinsiderepeater' => 1
									]
								);
							?>
						</div>
					</div>
					
					
					</div>
					<?php } ?>

				</div>
				<a href="#" class="button repeater-add tiny success">Add position</a>
				</div>



			</div>
			<?php } ?>

		</div>

		<a href="#" class="button repeater-add tiny success">Add group</a>
	</div>

</div>
 