<?php if (!isset($field['columns'])) $field['columns'] = 12;?>
<div class="medium-<?php echo $field['columns'];?> columns">
	<?php
	if (isset($r)) $v = $r[$field['field']]; else $v ='';
	$id = slug($field['name']).generateRandomString(5);
	?>

	<span class="field fileupload">
		<label for="" ><?php echo $field['name'];?></label>
		<span class="in">
			<input type="text" class='file_allfiles' name='<?php echo $field['field'];?>' value='<?php echo $v;?>' readonly id='<?php echo $id;?>' id='<?php echo $id; ?>'>
			<a href="includes/filemanager/dialog.php?type=0" class="button uploadbutton tiny ">Upload</a>
			<a href="#" class="remove button tiny alert" title='Remove' style='right:0' ><i class="fa fa-times"></i></a>
		</span>
	</span>


</div>