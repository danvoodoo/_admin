<div class="medium-<?php echo $field['columns'];?> columns">
	<h5><?php echo $field['name'];?></h5>
	
	<div class="taxonomies">
	<?php
	//print_r($field['values']);
	if (isset($r[$field['field']]) AND $r[$field['field']] != '') $vals = json_decode($r[$field['field']]); else $vals = array();
//	print_r($v);
	foreach($field['values'] as $k => $v) {
		if (!is_array($v)) {
	?>
	
	<div class="tag">
		<input type='checkbox' name='<?php echo $field['field'];?>[]' value='<?php echo $k;?>' <?php if(in_array($k, $vals)) echo 'checked="checked"'; ?> id='check_<?php echo $k;?>' />
		<label for="check_<?php echo $k;?>" >
			<?php echo $v;?>
		</label>
	</div>
	<?php } }?>
	</div>

	<div class="row collapse addtaxrow" style='max-width: 300px'>
		<div class="columns medium-9">
			<input type="text" class="newtax" data-type=<?php echo $field['taxtype']; ?>>		
		</div>
		<div class="columns medium-3">
			<a href="#" class="button addtax expand small">Add </a>
		</div>
	</div>
	

<hr>
</div>


<script type="text/javascript">
$(document).ready(function () {


$('.addtax').click(function(e){
	e.preventDefault();
	p = $(this).closest('.row');
	$.post("includes/actions/actions.php", 
	    { 
	      action: "addtax",
	      taxtype: $('input',p).data('type'),
	      val: $('input',p).val() 
	    },
	    function(data){
	    	data = JSON.parse(data);
	    	p.prev().append('<div class="tag"><input type="checkbox" name="<?php echo $field['field'];?>[]" value="'+data.cat_url+'" id="check_'+data.cat_url+'" /><label for="check_'+data.cat_url+'" >'+data.cat_name+'</label></div>');
	        console.log(data);
	    }
	);
});



});
</script>