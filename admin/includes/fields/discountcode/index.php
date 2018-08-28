<?php if (!isset($field['columns'])) $field['columns'] = 12;?>
<div class="medium-<?php echo $field['columns'];?> columns">
	<hr>
	<h5><?php echo $field['name'];?></h5>
	<p><?php
		if ( $r[$field['field']] != '' ) {
			$code = json_decode($r[$field['field']]);
			?>
			Code: <strong><?php echo $code->post_title; ?></strong><br>
			Type: <?php echo $code->post_category; ?>
			<?php if (  $code->post_content > 0 ) {?>- Value: Type: <?php echo $code->post_content; ?> <?php } ?>
		<?php }	?></p>

</div>