<div class="medium-<?php echo $field['columns'];?> columns">
	<h5><?php echo $field['name'];?></h5>
	<ul class="medium-block-grid-1 catlist">
	<?php
	
	if (isset($r[$field['field']]) AND $r[$field['field']] != '') $vals = json_decode($r[$field['field']]); else $vals = array();
//	print_r($v);
	foreach($field['values'] as $k => $v) {
		
	?>
	<li class="field">

		<label for="check_<?php echo $k;?>">
		<input type='checkbox' name='<?php echo $field['field'];?>[]' value='<?php echo $k;?>' <?php if(in_array($k, $vals)) echo 'checked="checked"'; ?> id='check_<?php echo $k;?>' />
		<?php echo $v['label'];?></label>

		<?php
		if ( isset( $v['subvalues'] ) AND count($v['subvalues']) > 0 ) {
			foreach ( $v['subvalues'] as $kk => $vv) {
				?>
				<div class="subfield">
					<input type='checkbox' name='<?php echo $field['field'];?>[]' value='<?php echo $kk;?>' <?php if(in_array($kk, $vals)) echo 'checked="checked"'; ?> id='check_<?php echo $kk;?>' />
					<label for="check_<?php echo $kk;?>"><?php echo $vv;?></label>
				</div>
				<?php
			}
		}?>
	</li>
<?php } ?>
</ul>
<hr>
</div>


<style>
.catlist{
	height: 300px;
	overflow-y: auto;
}
.subfield{
	padding-left:  20px;
}
.catlist input{
	margin-bottom: 0;
}
.catlist li{
	padding-bottom: 5px !important;
}
</style>