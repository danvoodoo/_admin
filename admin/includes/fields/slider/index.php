<?php
include_once('includes/fields/flexible_content/functions.php');


if (!isset($field['columns'])) $field['columns'] = 12;?>
<div class="medium-<?php echo $field['columns'];?> columns">
	<hr>
	<h4><?php echo $field['name'];?></h4>

	<?php
	global $fixed, $co, $flexiblecount, $flexiblefield, $re, $bb;
	$flexiblefield = $field;
	$fixed = 0;
	if (isset($field['fixed']) AND $field['fixed'] == 1) $fixed = 1;


	if (isset($r)) $v = $r[$field['field']]; else $v ='';

	?>

	<div class="flexiblecontent">
		<?php
		$flexiblecount = 0;
		$co = '';


		//$v = preg_replace( "/\r|\n/", "", $v );
		if (isset($_GET['debug'])) print_r($v);



		$contents = json_decode( $v , true);
		//print_r($contents);
		$co = current($contents);

		if (isset($_GET['debug'])) print_r($contents);

		include('includes/fields/slider/content/slider.php');
		?>

	</div>



</div>


