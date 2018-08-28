<div class="medium-<?php echo $field['columns'];?> columns">
	<h5><?php echo $field['name'];?></h5>
	<ul class="medium-block-grid-4">
	<?php
	//print_r($field['values']);
	if (isset($r[$field['field']]) AND $r[$field['field']] != '') $vals = json_decode($r[$field['field']]); else $vals = array();
//	print_r($v);
	foreach($field['values'] as $k => $v) {
		if (!is_array($v)) {
	?>
	<li class="field">


		<input type='checkbox' name='<?php echo $field['field'];?>[]' value='<?php echo $k;?>' <?php if(in_array($k, $vals)) echo 'checked="checked"'; ?> id='check_<?php echo $k;?>' />
		<label for="check_<?php echo $k;?>"><?php echo $v;?></label>

		<?php
		if ( isset( $field['values']['suboptions'][$k] ) ) {
			foreach ($field['values']['suboptions'][$k] as $k => $v) {
				?>
				<div class="subfield">
					<input type='checkbox' name='<?php echo $field['field'];?>[]' value='<?php echo $k;?>' <?php if(in_array($k, $vals)) echo 'checked="checked"'; ?> id='check_<?php echo $k;?>' />
					<label for="check_<?php echo $k;?>"><?php echo $v;?></label>
				</div>
				<?php
			}
		}?>
	</li>
<?php } }?>
</ul>
<hr>
</div>
