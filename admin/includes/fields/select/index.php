<?php if (!isset($field['columns'])) $field['columns'] = 12;?>
<div class="medium-<?php echo $field['columns'];?> columns">
	<label><?php echo $field['name'];?></label>
	<select name="<?php echo $field['field'];?>" id="" <?php if (isset($field['required'])) echo 'required';?>>
		<?php 
		if (isset($r[$field['field']]) AND $r[$field['field']] != '') $vals = $r[$field['field']]; else $vals = '';
		foreach($field['values'] as $k => $v) {?>
		<option value="<?php echo $k;?>" <?php if ($k == $vals) echo 'selected';?>><?php echo $v;?></option>
		<?php } ?>
	</select>

	
</div>
