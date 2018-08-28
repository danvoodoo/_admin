<div class="medium-<?php echo $field['columns'];?> columns">
	<hr>
	<h5><?php echo $field['name'];?></h5>
	<ul class="medium-block-grid-6 imageselect">
	<?php
	//print_r($field['values']);
	if (isset($r[$field['field']]) AND $r[$field['field']] != '') $vals = json_decode($r[$field['field']]); else $vals = array();
//	print_r($v);
	foreach($field['values'] as $k => $v) {
		//if (!is_array($v)) {
	?>
	<li class="field">

		
		<label for="check_<?php echo $k;?>">
			<input type='checkbox' name='<?php echo $field['field'];?>[]' value='<?php echo $k;?>' <?php if(in_array($k, $vals)) echo 'checked="checked"'; ?> id='check_<?php echo $k;?>' />
			<img src="<?php echo $v[1];?>" alt="">
			<?php echo $v[0];?>
		</label>


	</li>
<?php //}
	 }?>
</ul>
<hr>
</div>

<style>
	.imageselect li{
		position: relative;
	}
	.imageselect input{
		position: absolute;
		top: 10px;
		left: 20px;
	}
</style>