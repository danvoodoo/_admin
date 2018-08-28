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


				<label for="" >Text</label>
				<input type="text" name='<?php echo $field['field'];?>[<?php echo $aa;?>][repeater][<?php echo $bb;?>][text]' value='<?php echo $re['text'];?>'>

				<label for="" >Link</label>
				<input type="text" name='<?php echo $field['field'];?>[<?php echo $aa;?>][repeater][<?php echo $bb;?>][link]' value='<?php echo $re['link'];?>'>

			


			</div>
			<?php } } else { $bb=0;?>
			<div class="item">


				<label for="" >Text</label>
				<input type="text" name='<?php echo $field['field'];?>[<?php echo $aa;?>][repeater][<?php echo $bb;?>][text]' >


				<label for="" >Link</label>
				<input type="text" name='<?php echo $field['field'];?>[<?php echo $aa;?>][repeater][<?php echo $bb;?>][link]' >

			</div>
			<?php } ?>
		</div>

		<div class="uploader"></div>

		<a href="#" class="button repeater-add tiny success">Add button</a>
	</div>

	<ul id="filelist"></ul>



</div>
