<?php
include_once('../functions.php');
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
						'label' => 'Title',
						'name' => 'title',
						'type' => 'text',
						'isrepeater' => 1
						]
					);
				?>

				<?php 
				field( [
						'label' => 'Organisation',
						'name' => 'org',
						'type' => 'text',
						'isrepeater' => 1
						]
					);
				?>

				<?php 
				field( [
						'label' => 'Post',
						'name' => 'post',
						'type' => 'text',
						'isrepeater' => 1
						]
					);
				?>
				<?php 
				field( [
						'label' => 'Contract',
						'name' => 'contract',
						'type' => 'text',
						'isrepeater' => 1
						]
					);
				?>

				<?php 
				field( [
						'label' => 'Hours',
						'name' => 'hours',
						'type' => 'text',
						'isrepeater' => 1
						]
					);
				?>

				<?php 
				field( [
						'label' => 'Grade',
						'name' => 'grade',
						'type' => 'text',
						'isrepeater' => 1
						]
					);
				?>
				<?php 
				field( [
						'label' => 'Start Date',
						'name' => 'start',
						'type' => 'text',
						'isrepeater' => 1
						]
					);
				?>
				<?php 
				field( [
						'label' => 'Closing Date',
						'name' => 'closing',
						'type' => 'text',
						'isrepeater' => 1
						]
					);
				?>
				<?php 
				field( [
						'label' => 'Interview Date',
						'name' => 'interview',
						'type' => 'text',
						'isrepeater' => 1
						]
					);
				?>

				<?php 
				field( [
						'label' => 'Description',
						'name' => 'text',
						'type' => 'textarea',
						'isrepeater' => 1
						]
					);
				?>

				<?php 
						field( [
								'label' => 'File',
								'name' => 'file',
								'type' => 'upload',
								'isrepeater' => 1
								]
							);
						?>



			</div>
			<?php } ?>

		</div>

		<a href="#" class="button repeater-add tiny success">Add job</a>
	</div>

</div>