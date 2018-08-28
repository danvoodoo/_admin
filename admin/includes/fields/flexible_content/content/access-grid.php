<?php
include_once('../functions.php');
fieldtop( pathinfo(__FILE__, PATHINFO_FILENAME) );
?>
<div class="panel">
	<?php flex_buttons(0,$field);?> 
	

	<div class="row">
		<div class="columns medium-5">
			<?php 
			field( [
					'label' => 'Title',
					'name' => 'title1',
					'type' => 'text',
					'isrepeater' => 0
					]
				);
			?>
			<?php 
			field( [
					'label' => 'Link',
					'name' => 'link1',
					'type' => 'link',
					'isrepeater' => 0
					]
				);
			?>
			<?php 
					field( [
							'label' => 'File',
							'name' => 'file1',
							'type' => 'upload',
							'isrepeater' => 0
							]
						);
					?>
			<?php 
			field( [
					'label' => 'Image',
					'name' => 'image1',
					'type' => 'image',
					'isrepeater' => 0
					]
				);
			?>
		</div>
		<div class="columns medium-7">
			<div class="row">
				<div class="columns medium-6">
					<?php 
					field( [
							'label' => 'Title',
							'name' => 'title2',
							'type' => 'text',
							'isrepeater' => 0
							]
						);
					?>
					<?php 
					field( [
							'label' => 'Link',
							'name' => 'link2',
							'type' => 'link',
							'isrepeater' => 0
							]
						);
					?>
					<?php 
					field( [
							'label' => 'File',
							'name' => 'file2',
							'type' => 'upload',
							'isrepeater' => 0
							]
						);
					?>
					<?php 
					field( [
							'label' => 'Image',
							'name' => 'image2',
							'type' => 'image',
							'isrepeater' => 0
							]
						);
					?>
				</div>
				<div class="columns medium-6">
					<?php 
					field( [
							'label' => 'Title',
							'name' => 'title3',
							'type' => 'text',
							'isrepeater' => 0
							]
						);
					?>
					<?php 
					field( [
							'label' => 'Link',
							'name' => 'link3',
							'type' => 'link',
							'isrepeater' => 0
							]
						);
					?>
					<?php 
					field( [
							'label' => 'File',
							'name' => 'file3',
							'type' => 'upload',
							'isrepeater' => 0
							]
						);
					?>
					<?php 
					field( [
							'label' => 'Image',
							'name' => 'image3',
							'type' => 'image',
							'isrepeater' => 0
							]
						);
					?>
				</div>
				<div class="columns medium-12"> <hr></div>
				<div class="columns medium-6">
					<?php 
					field( [
							'label' => 'Title',
							'name' => 'title4',
							'type' => 'text',
							'isrepeater' => 0
							]
						);
					?>
					<?php 
					field( [
							'label' => 'Link',
							'name' => 'link4',
							'type' => 'link',
							'isrepeater' => 0
							]
						);
					?>
					<?php 
					field( [
							'label' => 'File',
							'name' => 'file4',
							'type' => 'upload',
							'isrepeater' => 0
							]
						);
					?>
					<?php 
					field( [
							'label' => 'Image',
							'name' => 'image4',
							'type' => 'image',
							'isrepeater' => 0
							]
						);
					?>
				</div>
				<div class="columns medium-6">
					<?php 
					field( [
							'label' => 'Title',
							'name' => 'title5',
							'type' => 'text',
							'isrepeater' => 0
							]
						);
					?>
					<?php 
					field( [
							'label' => 'Link',
							'name' => 'link5',
							'type' => 'link',
							'isrepeater' => 0
							]
						);
					?>
					<?php 
					field( [
							'label' => 'File',
							'name' => 'file5',
							'type' => 'upload',
							'isrepeater' => 0
							]
						);
					?>
					<?php 
					field( [
							'label' => 'Image',
							'name' => 'image5',
							'type' => 'image',
							'isrepeater' => 0
							]
						);
					?>
				</div>
			</div>
		</div>



	</div>

	


</div>