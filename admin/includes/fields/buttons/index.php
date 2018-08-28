<?php
include_once('includes/fields/flexible_content/functions.php');


if (!isset($field['columns'])) $field['columns'] = 12;?>
<div class="medium-<?php echo $field['columns'];?> columns">
	<hr>
	<h4><?php echo $field['name'];?></h4>

	<?php
	global $fixed, $co;
	$fixed = 0;
	if (isset($field['fixed']) AND $field['fixed'] == 1) $fixed = 1;


	if (isset($r)) $v = $r[$field['field']]; else $v ='';

	?>

	<div class="flexiblecontent">
		<?php
		$a = 0;


		//$v = preg_replace( "/\r|\n/", "", $v );
		if (isset($_GET['debug'])) print_r($v);



		$contents = json_decode( $v , true);

		if (isset($_GET['debug'])) print_r($contents);

		if (is_array($contents))
		foreach ($contents as $co) {
			//print_r($co);
			$a++;
			include('includes/fields/buttons/content/testimonials.php');
		} else {
			include('includes/fields/buttons/content/testimonials.php');
		}
		?>

	</div>

	

</div>

