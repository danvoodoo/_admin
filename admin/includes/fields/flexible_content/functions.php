<?php
if (!isset($co)) $co = '';

function flex_value($name, $co) {
	if (isset($co[$name])) 
		echo stripslashes( $co[$name] );
}

function get_flex_value($name, $co) {
	if (isset($co[$name])) 
		return stripslashes($co[$name]);
}


function flex_value_select($name, $co, $value) {
	if (isset($co[$name]) AND $co[$name] == $value) 
		echo 'selected';
}

function flex_value_checkbox($name, $co, $value) {
	if (isset($co[$name]) AND $co[$name] == $value) 
		echo 'checked';
}

function flex_buttons($color = 0,$field) {
	global $type;
	global $aa;
	global $co;
	global $fixed;
	?>
	<div class="flex_buttons">
		<?php
		if ($fixed == 0) {?>
		<div class="type"><?php echo $type;?></div>
		<?php } ?>
		<input type="hidden" name='<?php echo $field['field'];?>[<?php echo $aa;?>][type]' value='<?php echo $type;?>'>

		<?php if ($color==1) {?>
		<input type="color" name='<?php echo $field['field'];?>[<?php echo $aa;?>][color]' value='<?php flex_value('color',$co);?>'>
		<?php } ?>

		<?php
		
		if ($fixed == 0) {
		?>
		<a href="#" class="up button tiny"><i class="fa fa-chevron-up"></i></a>
		<a href="#" class="down button tiny"><i class="fa fa-chevron-down"></i></a>
		<a href="#" class="del button tiny alert"><i class="fa fa-trash-o"></i></a>
		<?php } ?>
	</div>
	<?php
}


function imagefield($label, $name, $value='') {
	global $field;
	?>
	<div class="row">
		<div class="columns medium-12">
	<span class="field">
		<a href="#" class="gal button tiny" ><i class="fa fa-picture-o"></i></a>
		<a href="#" class="editimage button tiny" ><i class="fa fa-pencil-square-o"></i></a>
		<a href="#" class="deleteimage button tiny alert" title='Remove image' ><i class="fa fa-times"></i></a>
	</span>
	<label for="" ><?php echo $label;?></label>
	<input type="text" class='file' name='<?php echo $name;?>' value='<?php echo $value;?>' readonly>
	</div>
	</div>
	<?php
}

function fieldtop($t) {
	global $type, $aa,$a,$co, $field, $flexiblecount,$flexiblefield ;	
	$type = $t;

	if (isset($_POST['a'])) {
		$aa = $_POST['a'];
		$field = $_POST['field'];
		include_once('../../../functions/functions.php');
		include_once('../functions.php');
	} else {
		$aa = $flexiblecount;
		$field = $flexiblefield;
	}
}



function field($attr) {
	global $field, $co, $aa, $r, $bb, $re, $cc, $re2;

	//print_r($field);

	$name = $field['field'].'['.$aa.']';

	if ( isset($attr['isrepeaterinsiderepeater']) AND $attr['isrepeaterinsiderepeater'] == 1) { 
		$name .= '[repeater]['.$bb.'][repeater]['.$cc.']['.$attr['name'].']';
		$content = $re2;
	} else if ($attr['isrepeater'] == 1) {
		$name .= '[repeater]['.$bb.']['.$attr['name'].']';
		$content = $re;
	} else {
		$name .= '['.$attr['name'].']';
		$content = $co;
	}


	$id = slug($attr['label']).generateRandomString(5);
	if ( $attr['label'] != '' && $attr['type'] != 'image' && $attr['type'] != 'link' && $attr['type'] != 'upload' ) {
	?>
	<label for="<?php echo $id; ?>" ><?php echo $attr['label'];?></label>
	<?php } 

	switch ($attr['type']) {
		case 'mce':
			?>
			<textarea class='mce' name='<?php echo $name;?>' id="<?php echo $id; ?>" cols="30" rows="10"><?php echo get_flex_value($attr['name'],$content) ;?></textarea>
			<?php
		break;


		case 'textarea':
			if ( !isset($attr['row']) ) $attr['row'] = 10;
			?>
			<textarea name='<?php echo $name;?>' id="<?php echo $id; ?>" cols="30" rows="<?php echo $attr['row']; ?>"><?php echo get_flex_value($attr['name'],$content) ;?></textarea>
			<?php
		break;

		case 'mcesimple':
			?>
			<textarea class='mcesimple' name='<?php echo $name;?>' id="<?php echo $id; ?>" cols="30" rows="10"><?php echo get_flex_value($attr['name'],$content) ;?></textarea>
			<?php
		break;

		case 'text':
			?>
			<input type='text' name='<?php echo $name;?>' id='<?php echo $id; ?>' value='<?php echo  htmlentities( get_flex_value($attr['name'],$content), ENT_QUOTES );?>' >
			<?php
		break;

		case 'datepicker':
			?>
			<input class="datepicker" type='text' name='<?php echo $name;?>' id='<?php echo $id; ?>' value='<?php echo  htmlentities( get_flex_value($attr['name'],$content), ENT_QUOTES );?>' >
			<?php
		break;

		case 'color':
			?>
			<input type='color' name='<?php echo $name;?>' id='<?php echo $id; ?>' value='<?php echo get_flex_value($attr['name'],$content) ;?>' >
			<?php
		break;

		case 'checkbox':
			?>
			<input type='checkbox' id='<?php echo $id; ?>' name='<?php echo $name;?>' value='1'  <?php flex_value_checkbox($attr['name'],$content,1);?> >
			<?php
		break;

		case 'image':
			if ( !isset( $attr['size'] ) ) $attr['size'] = '200_200';
			imageupload(array(
				'name' => $name,
				'label' => $attr['label'],
				'size' => $attr['size'],
				'value' => get_flex_value($attr['name'],$content)
				));
		break;



		case 'link':
			linkfield(array(
				'name' => $name,
				'label' => $attr['label'],
				'value' => get_flex_value($attr['name'],$content)
				));
		break;


		case 'radio':
			foreach ($attr['values'] as $key => $value) {
				?>
				
					<input id="<?php echo $id.slug($key); ?>" type="radio" name='<?php echo $name;?>' value='<?php echo $key; ?>' <?php flex_value_checkbox($attr['name'],$content,$key);?>>
					<label for="<?php echo $id.slug($key); ?>"><?php echo $value; ?>
				</label>
			<?php }

		break;



		case 'select':
			?>
			<select name="<?php echo $name;?>" id="">
				<option value="">Select</option>
			<?php
			foreach ($attr['values'] as $key => $value) {
				?>
				<option value="<?php echo $key; ?>" <?php flex_value_select($attr['name'],$content,$key);?>>
					<?php echo $value; ?>
				</option>					
			<?php } ?>
			</select>
			<?php 
		break;



		case 'upload':
			?>
			<span class="field fileupload">
				<label for="" ><?php echo $attr['label'];?></label>
				<span class="in">
					<input type="text" class='file_allfiles' name='<?php echo $name;?>' value='<?php echo get_flex_value($attr['name'],$content) ;?>' readonly id='<?php echo $id;?>' id='<?php echo $id; ?>'>
					<a href="includes/filemanager/dialog.php?type=0" class="button uploadbutton tiny ">Upload</a>
					<a href="#" class="remove button tiny alert" title='Remove' style='right:0' ><i class="fa fa-times"></i></a>
				</span>
			</span>


			
			<?php
		break;
		
		default:
			# code...
		break;
	}
	
}


?>