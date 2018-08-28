<?php
if (!isset($co)) $co = '';

function flex_value($name, $co) {
	if (isset($co[$name]))
		echo $co[$name];
}

function get_flex_value($name, $co) {
	if (isset($co[$name]))
		return $co[$name];
}


function flex_value_select($name, $co, $value) {
	if (isset($co[$name]) AND $co[$name] == $value)
		echo 'selected';
}

function flex_value_checkbox($name, $co, $value) {
	if (isset($co[$name]) AND $co[$name] == $value)
		echo 'checked';
}

function flex_buttons($color = 0) {
	global $type;
	global $aa;
	global $co;
	global $field;
	?>
	<div class="flex_buttons">


		<input type="hidden" name='<?php echo $field['field'];?>[<?php echo $aa;?>][type]' value='<?php echo $type;?>'>


		<?php
		global $fixed;
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
	?>
	<span class="field">
		<a href="#" class="gal button tiny" ><i class="fa fa-picture-o"></i></a>
		<a href="#" class="editimage button tiny" ><i class="fa fa-pencil-square-o"></i></a>
	</span>
	<label for="" ><?php echo $label;?></label>
	<input type="text" class='file' name='<?php echo $name;?>' value='<?php echo $value;?>' readonly>
	<?php
}

?>
