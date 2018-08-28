<?php

if ( isset($_GET['id']) ) {

	$data = new Database();
	$where = $extras['id'] .' = '.$_GET['id'];
	$count  =  $data->select(" * ", $extras['table'] , $where);
	$r = $data->getObjectResults();
	$r =  (array) $r;

	global $r;
	if ( isset($extras['post_type']) )
		getmetas_array( $_GET['id'], $extras['post_type'] );

}

if ( isset($_GET['lang']) AND $_GET['lang'] != '' ) {
	foreach ($fields as $k => $field) {
		if ( isset($field['field']) ){
			$fields[$k]['field'] = $field['field'].'_'.$_GET['lang'];
			$fields[$k]['meta'] = 1;
		}

		if ( isset($field['nontranslatable']) ){
			unset($fields[$k]);
		}
	}
}


?>
<form action="" method="post">
<div class="top">
	<div class="inner">
	<?php
	if (!isset($extras['readonly'])) {?>
	<button class="save small"  type="submit">Save</button>
	<button class="save small saveandcontinue" >Save & Continue</button>
	<input type="hidden" name='saveandcontinue' value=''>

	<?php
	if ( isset( $urlstructure[ $extras['post_type'] ]['viewonsite'] ) AND $urlstructure[ $extras['post_type'] ]['viewonsite'] ){ ?>
	<?php if ( $r[ $extras['table_state']] == 1  ) {?>
		<a href="<?php echo SITEURL.get_url( $r );?>" target='_blank' class="save btn">View <?php echo $title_singular; ?></a>
	<?php } else { ?>
		<a href="<?php echo SITEURL.get_url( $r );?>?pv=1" target='_blank' class="save btn">Preview <?php echo $title_singular; ?></a>
	<?php } ?>
	<?php } ?>
	

	<script>
	$(document).ready(function () {
	$('.saveandcontinue').click(function(e) {
	  	$('input[name="saveandcontinue"]').val(1);
	});
	});
	</script>
	<?php } ?>

	<?php

	if (isset($extras['table_date'])) echo '<span class="block"><strong>Published:</strong> '.$r[$extras['table_date']].'</span>';

	if (isset($extras['table_date_update'])) echo '<span class="block"><strong>Updated:</strong> '.$r[$extras['table_date_update']].'</span>';

	if (isset($extras['table_state'])) {
		?>
		<div class="switch round small">
		  	<input id="state" type="checkbox" value="1" <?php if($r[$extras['table_state']] == 1 ) echo 'checked';?> name='<?php echo $extras['table_state'];?>' >
			<label for="state"></label>
		</div>
	<?php } ?>

	
	</div>
</div>
<div class="content edit row">	

	<?php showmessage();  ?>
    	
	<h2 class="title">
		<?php if ( $extras['print'] == 1 ) {?>
		<a href="#" onclick='window.print()' class="button small right"><i class="fa fa-print"></i> Print</a>
		<?php } ?>
		<?php if ( isset( $extras['printfile'] ) ) {?>
		<a href="<?php echo $extras['printfile']; ?>" target='_blank' class="button small right"><i class="fa fa-print"></i> Print</a>
		<?php } ?>
		
		<?php echo $title;?> <i class="fa fa-angle-right"></i> <?php if (isset($_GET['id'])) echo 'Edit'; else echo 'New';?>
	</h2>

	<?php
	global $languages;
	if ( isset($languages) ) {
		?>
		<h5>Language</h5>
		<a href="?id=<?php echo $_GET['id']; ?>" class="button tiny  <?php if (isset($_GET['lang'])) echo 'secondary';?> ">Default</a>
		<?php 
		foreach ($languages as $key => $value) {
			?>
			<a href="?id=<?php echo $_GET['id']; ?>&lang=<?php echo $key; ?>" class="button tiny <?php if (!isset($_GET['lang']) OR isset($_GET['lang']) && $_GET['lang'] != $key ) echo 'secondary';?>"><?php echo $value; ?></a>
		<?php }
	}
	?>

	<input type="hidden" value="<?php if(isset($_GET['id'])) echo $_GET['id'];?>" name="id">
	<input type="hidden" value="<?php if(isset($_GET['id'])) echo 'update'; else echo 'save';?>" name="action">	

	<?php
	foreach ($fields as $field) {

		global $r;
		global $db_salt;

		include('includes/fields/'.$field['type'].'/index.php');
	}
	?>
</div>


<?php if (isset($extras['readonly'])) {?>
<script type="text/javascript">
$(document).ready(function () {

$('.content input, .content textarea').attr('disabled','disabled');
$('.content select').attr('disabled','disabled');

});
</script>
<?php } ?>