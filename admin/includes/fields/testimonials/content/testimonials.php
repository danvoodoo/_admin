<?php
global $type, $flexiblecount,$co;

if (isset($_POST['a'])) {
	$aa = $_POST['a'];
	include_once('../functions.php');
} else
	$aa = $flexiblecount;



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
			if ( !isset($co['repeater']) ) $co['repeater'] = array(); 
			$bb = 0;
			foreach ($co['repeater'] as $re) { $bb++;
			?>
			<div class="item">

				<?php
				imagefield('Image',$field['field'].'['.$aa.'][repeater]['.$bb.'][image]',$re['image']);
				?>

				<label for="" >Text</label>
				<input type="text" name='<?php echo $field['field'];?>[<?php echo $aa;?>][repeater][<?php echo $bb;?>][text]' value='<?php echo $re['text'];?>'>

				<label for="" >Author</label>
				<input type="text" name='<?php echo $field['field'];?>[<?php echo $aa;?>][repeater][<?php echo $bb;?>][author]' value='<?php echo $re['author'];?>'>

				<label for="" >Date</label>
				<input type="text" name='<?php echo $field['field'];?>[<?php echo $aa;?>][repeater][<?php echo $bb;?>][date]' value='<?php echo $re['date'];?>'>



			</div>
			<?php } ?>
		</div>

		<div class="uploader"></div>

		<a href="#" class="button repeater-add tiny success">Add testimonial</a>
	</div>

	<ul id="filelist"></ul>



</div>
