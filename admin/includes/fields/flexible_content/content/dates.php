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


				<div class="row">
					<div class="columns medium-6">
						<?php 
						field( [
								'label' => 'Date (single date) /From',
								'name' => 'from',
								'type' => 'datepicker',
								'isrepeater' => 1
								]
							);
						?>
					</div>
					<div class="columns medium-6">
						<?php 
						field( [
								'label' => 'To (leave empty for single date)',
								'name' => 'to',
								'type' => 'datepicker',
								'isrepeater' => 1
								]
							);
						?>
					</div>
				</div>

			</div>
			<?php } ?>

		</div>

		<a href="#" class="button repeater-add tiny success">Add date</a>
	</div>

</div>