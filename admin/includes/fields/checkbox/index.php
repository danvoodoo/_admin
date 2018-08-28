<div class="medium-<?php echo $field['columns'];?> columns">
	<?php
	if (isset($r)) $v = $r[$field['field']]; else $v ='';
	?>
	<label><?php echo $field['name'];?></label>
	<div class="hide-for-print">
		<div class="switch round small">
			<input type='checkbox' name='<?php echo $field['field'];?>' id='<?php echo $field['field'];?>' value='1' <?php if($v == 1) echo 'checked="checked"'; ?> />
			<label for="<?php echo $field['field'];?>"></label>

			
		</div>
	</div>
	<div class="print-only">
			<?php if($v == 1) echo 'Yes'; else echo 'No'; ?>
			</div>
</div>