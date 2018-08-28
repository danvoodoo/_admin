<?php if (!isset($field['columns'])) $field['columns'] = 12;?>
<div class="medium-<?php echo $field['columns'];?> columns">
	<label for=""><?php echo $field['name'];?></label>
	<ul class="fa-icon">
	<?php
	$css = file_get_contents('http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');
	preg_match_all( '/\.(icon-|fa-)([^,}]*)\s*:before\s*{\s*(content:)\s*"(\\\\[^"]+)"/s', $css, $matches );
	$icons = $matches[2];
	//print_r($icons);

	//echo '<input class="txt" name="'.$field['field'].'" type="text" value="'.$r[$field['field']];.'">'; 
	foreach ($icons as $i) {
		?>
		<li>
		<a href='#' data-val="fa-<?php echo $i;?>" class='<?php if ( $r[$field['field']] == 'fa-'.$i) echo 'active';?>'><i class="fa fa-<?php echo $i;?>"></i> <?php echo $i;?> </a>
		</li>
		<?php	}
	?>
	</ul>
	<input type="hidden" name='<?php echo $field['field'];?>' value='<?php echo $r[$field['field']];?>'>
	<p>Current icon: <span class="currentico"><i class="fa <?php echo $r[$field['field']];?>"></i> <?php echo $r[$field['field']];?></span></p>
</div>
<style>
	.fa-icon{
		height: 200px;
		overflow-y: scroll;
	}
	.fa-icon a{
		color: #111;
		display: block;
		padding: 3px;
	}
	.fa-icon a i{
		color: #008cba;
		margin-right: 5px;
	}
	.fa-icon a.active, .fa-icon a.active i{
		color: #fff;
		background: #008cba;
	}
</style>
<script>
$(document).ready(function () {
$('.fa-icon a').click(function(e) {
  val = $(this).data('val');
  $('.currentico').html('<i class="fa '+val+'"></i>'+val);
  $('[name="<?php echo $field['field'];?>"]').val(val);
  $('.fa-icon .active').removeClass('active');
  $(this).addClass('active');
  e.preventDefault();
});
});
</script>