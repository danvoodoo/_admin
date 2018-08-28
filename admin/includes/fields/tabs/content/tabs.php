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


				<label for="" >Title</label>
				<input type="text" name='<?php echo $field['field'];?>[<?php echo $aa;?>][repeater][<?php echo $bb;?>][title]' value='<?php echo $re['title'];?>'>

				<div class="row">
				<div class="columns medium-6">
					
					<textarea class='mce' name='<?php echo $field['field'];?>[<?php echo $aa;?>][repeater][<?php echo $bb;?>][textl]' id="" cols="30" rows="10"><?php echo $re['textl'];?></textarea>

				</div>

				<div class="columns medium-6">
					
					<textarea class='mce' name='<?php echo $field['field'];?>[<?php echo $aa;?>][repeater][<?php echo $bb;?>][textr]' id="" cols="30" rows="10"><?php echo $re['textr'];?></textarea>

				</div>
				</div>
				




			</div>
			<?php } } else { $bb=0;?>
			<div class="item">


				<label for="" >Title</label>
				<input type="text" name='<?php echo $field['field'];?>[<?php echo $aa;?>][repeater][<?php echo $bb;?>][title]' >

				<div class="row">
				<div class="columns medium-6">
					
					<textarea class='mce' name='<?php echo $field['field'];?>[<?php echo $aa;?>][repeater][<?php echo $bb;?>][textl]' id="" cols="30" rows="10"></textarea>

				</div>

				<div class="columns medium-6">
					
					<textarea class='mce' name='<?php echo $field['field'];?>[<?php echo $aa;?>][repeater][<?php echo $bb;?>][textr]' id="" cols="30" rows="10"></textarea>

				</div>
				</div>
				
	

			</div>
			<?php } ?>
		</div>

		<div class="uploader"></div>

		<a href="#" class="button repeater-add tiny success">Add tab</a>
	</div>

	<ul id="filelist"></ul>



</div>
