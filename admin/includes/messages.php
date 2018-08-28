<?php
$message = array();

$message['insert'] = array(
		'type' => 'success',
		'message' => 'The content has been successfully inserted'
		);

$message['update'] = array(
		'type' => 'success',
		'message' => 'The content has been successfully updated'
		);

$message['delete'] = array(
		'type' => 'alert',
		'message' => 'The content has been deleted'
		);

$message['duplicated'] = array(
		'type' => 'success',
		'message' => 'The content was duplicated correctly'
		);



function showmessage() {
if (isset($_GET['msg'])) 
	{
		global $message;
		?>
		<div data-alert class="alert-box <?php echo $message[$_GET['msg']]['type'];?> ">
		  	<?php echo $message[$_GET['msg']]['message'];?>
		  	<a href="#" class="close">&times;</a>
		</div>
		<?php

	}
}



?>