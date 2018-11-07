<?php
global $type, $aa,$a,$co;	


if (isset($_POST['a'])) {
	$aa = $_POST['a'];
	$field = $_POST['field'];
	include_once('../functions.php');
} else {
	$aa = $flexiblecount;
}

$type = 'form';
?>
<div class="panel">
	<?php flex_buttons(0,$field);?> 
	
	<label for="">Map address (leve empty for no map)</label>
	<input type="text" name='<?php echo $field['field'];?>[<?php echo $aa;?>][address]' value='<?php flex_value('address',$co);?>'>
	
	<hr>

	<label for="">Title</label>
	<input type="text" name='<?php echo $field['field'];?>[<?php echo $aa;?>][title]' value='<?php flex_value('title',$co);?>'>
	
	<label for="">Text</label>
	<textarea class='mce' name='<?php echo $field['field'];?>[<?php echo $aa;?>][text]' id="" cols="30" rows="10"><?php flex_value('text',$co);?></textarea>

	<div class="row">
		<div class="columns medium-4">
			<label for="">Recipient email address</label>
			<input type="text" name='<?php echo $field['field'];?>[<?php echo $aa;?>][emailto]' value='<?php flex_value('emailto',$co);?>'>
		</div>
		<div class="columns medium-4">
			<label for="">Subject</label>
			<input type="text" name='<?php echo $field['field'];?>[<?php echo $aa;?>][subject]' value='<?php flex_value('subject',$co);?>'>
		</div>
		<div class="columns medium-4">
			<label for="">Button text</label>
			<input type="text" name='<?php echo $field['field'];?>[<?php echo $aa;?>][button]' value='<?php flex_value('button',$co);?>'>
		</div>
	</div>

	<label for="">Redirects to (relative to sites root)</label>
	<input type="text" name='<?php echo $field['field'];?>[<?php echo $aa;?>][redirect]' value='<?php flex_value('redirect',$co);?>'>

	

	

	


	<div class="repeater">
		<div class="items">

			<?php
			if ( !isset($co['repeater']) ) $co['repeater'] = array( [] ); 
			$bb = 0;
			foreach ($co['repeater'] as $re) { $bb++;
			?>
			<div class="item">

				<label for="" >Label</label>
				<input type="text" name='<?php echo $field['field'];?>[<?php echo $aa;?>][repeater][<?php echo $bb;?>][label]' value='<?php echo $re['label'];?>'>

				<div class="row">
					<div class="columns medium-4">
						<label for="">Type</label>
						<select name="<?php echo $field['field'];?>[<?php echo $aa;?>][repeater][<?php echo $bb;?>][type]" id="">
							<option value="">Select type</option>
							<option <?php if ( $re['type'] == 'text' ) echo 'selected' ?> value="text">Text</option>
							<option <?php if ( $re['type'] == 'email' ) echo 'selected' ?> value="email">Email</option>
							<option <?php if ( $re['type'] == 'textarea' ) echo 'selected' ?> value="textarea">Textarea</option>
							<option <?php if ( $re['type'] == 'select' ) echo 'selected' ?> value="select">Select (Drop down)</option>
							<option <?php if ( $re['type'] == 'checkbox' ) echo 'selected' ?> value="checkbox">Chekboxes (multiple choice)</option>
							<option <?php if ( $re['type'] == 'radio' ) echo 'selected' ?> value="radio">Radio buttons (single choice)</option>
						</select>
					</div>
					<div class="columns medium-4">
						<label for="">Sizes</label>
						<select name="<?php echo $field['field'];?>[<?php echo $aa;?>][repeater][<?php echo $bb;?>][size]" id="">
							<option value="">Select size</option>
							<option <?php if ( $re['size'] == '12' ) echo 'selected' ?> value="12">Full column</option>
							<option <?php if ( $re['size'] == '6' ) echo 'selected' ?> value="6">Half column</option>
							<option <?php if ( $re['size'] == '4' ) echo 'selected' ?> value="4">Thirth Column</option>
							<option <?php if ( $re['size'] == '3' ) echo 'selected' ?> value="3">Quarter column</option>
						</select>
					</div>
					<div class="columns medium-4">
						<label for="" >Required</label>
						<input type="checkbox" name='<?php echo $field['field'];?>[<?php echo $aa;?>][repeater][<?php echo $bb;?>][required]' <?php if ($re['required'])  echo 'checked';?> value='1'>
					</div>
				</div>

				

				

				<label for="">
					Options (only for selects, checkboxes and radio buttons. One per line)
				</label>
				<textarea name="<?php echo $field['field'];?>[<?php echo $aa;?>][repeater][<?php echo $bb;?>][options]" id="" cols="30" rows="10"><?php echo $re['options'];?></textarea>


				


			</div>
			<?php } ?>
		</div>

		<div class="uploader"></div>

		<a href="#" class="button repeater-add tiny success">Add field</a>
	</div>

	<ul id="filelist"></ul>



</div>
