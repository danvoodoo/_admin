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
						'label' => 'Image',
						'name' => 'image',
						'type' => 'image',
						'size' => '200_200',
						'isrepeater' => 1
						]
					);
				?>

				<div class="row">
					<div class="columns medium-6">
						<?php 
						field( [
								'label' => 'Title',
								'name' => 'title',
								'type' => 'text',
								'isrepeater' => 1
								]
							);
						?>
					</div>
					<div class="columns medium-6">
						<?php 
						field( [
								'label' => 'Link',
								'name' => 'link',
								'type' => 'text',
								'isrepeater' => 1
								]
							);
						?>
					</div>
					<div class="columns medium-12">
						<?php 
						field( [
								'label' => 'Description',
								'name' => 'description',
								'type' => 'text',
								'isrepeater' => 1
								]
							);
						?>
					</div>
				</div>


			</div>
			<?php } ?>

		</div>

		<a href="#" class="button repeater-add tiny success">Add item</a>
	</div>

</div>
