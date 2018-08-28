<?php if (!isset($field['columns'])) $field['columns'] = 12;?>
<div class="medium-<?php echo $field['columns'];?> columns">
	<label for="">
		<?php echo $field['name'];?>
		<?php if ( $r[$field['field']] != '' ) {?>
			<a href="#" class="editurl right">Edit URL</a>
		<?php } ?>		
	</label>
	<?php
	if ( $r[$field['field']] != '' ) {
		$value = $r[$field['field']];
		$readonly = 'readonly';
	} else {
		$value='';
		$readonly = '';
	}
	?>


	<input  class="txt" name="<?php echo $field['field'];?>" type="text" value="<?php echo $value;?>" <?php echo $readonly; ?>>
	
</div>

<script type="text/javascript">
$(document).ready(function () {

function convertToSlug( str ) {
	
  //replace all special characters | symbols with a space
  str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();
	
  // trim spaces at start and end of string
  str = str.replace(/^\s+|\s+$/gm,'');
	
  // replace space with dash/hyphen
  str = str.replace(/\s+/g, '-');
	
  return str;
}

<?php if ( $r[$field['field']] == '' ) {?>
$('input[name="<?php echo $field['name_field']; ?>"]').blur(function () {
	string = convertToSlug($('input[name="<?php echo $field['name_field']; ?>"]').val());
	$('input[name="<?php echo $field['field']; ?>"]').val(string);
});
<?php } ?>


$('input[name="<?php echo $field['field']; ?>"]').blur(function () {
	if ( !$('input[name="<?php echo $field['field']; ?>"]').attr('readonly') ) {
		string = convertToSlug($('input[name="<?php echo $field['field']; ?>"]').val());
		$('input[name="<?php echo $field['field']; ?>"]').val(string);
	}
});

$('.editurl').click(function () {
	$('input[name="<?php echo $field['field']; ?>"]').removeAttr('readonly').focus();
});

});
</script>