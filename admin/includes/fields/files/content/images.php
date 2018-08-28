<?php
global $type, $aa,$a,$co;

if (isset($_POST['a'])) {
	$aa = $_POST['a'];
	include_once('../functions.php');
} else
	$aa = $a;

$type = 'images';
?>
<div class="panel">
	<?php //flex_buttons();?>

	<?php
	//print_r($r);
	?>

	<div class="repeater">
		<div class="items">

			<?php
			if (isset($co['repeater'])) {
			$bb = 0;
			foreach ($co['repeater'] as $re) { $bb++;
			?>
			<div class="item">

				<?php
				imagefield('Image',$field['field'].'['.$aa.'][repeater]['.$bb.'][image]',$re['image']);
				?>

				<label for="" >Title</label>
				<input type="text" name='<?php echo $field['field'];?>[<?php echo $aa;?>][repeater][<?php echo $bb;?>][title]' value='<?php echo $re['title'];?>'>



			</div>
			<?php } } else { $bb=0;?>
			<div class="item">
				<?php
				imagefield('Image',$field['field'].'['.$aa.'][repeater]['.$bb.'][image]');
				?>

				<label for="" >Title</label>
				<input type="text" name='<?php echo $field['field'];?>[<?php echo $aa;?>][repeater][<?php echo $bb;?>][title]' >

			</div>
			<?php } ?>
		</div>

		<div class="uploader"></div>

		<a href="#" class="button repeater-add tiny success">Add image</a>
	</div>

	<ul id="filelist"></ul>



</div>
