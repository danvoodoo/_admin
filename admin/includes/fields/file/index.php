<?php if (!isset($field['columns'])) $field['columns'] = 12;?>
<div class="medium-<?php echo $field['columns'];?> columns">
	<?php
	if (isset($r)) $v = $r[$field['field']]; else $v ='';
	?>

	
	<span class="field">
		
		<a href="#" class="deleteimage button tiny alert" title='Remove image' style='right:0' ><i class="fa fa-times"></i></a>
	</span>
	<label for="" ><?php echo $field['name'];?></label>
	<input type="text" class='file_allfiles' name='<?php echo $field['field'];?>' value='<?php echo $v;?>' readonly placeholder='Click to upload image'>


</div>