<?php
if (isset($_GET['email'])) {
	//$_GET['debug'] = 1;
	include_once('admin/includes/init.php');		
	foreach($_GET as $fieldname => $value){ if (!is_array($value)) $ev = "\$" . $fieldname . "='" . addslashes(htmlspecialchars($value)) . "';"; eval($ev); }//end foreach

	
	$data = new Database();
	$where = 'us_email = "'.$email.'" AND us_hash = "'.$hash.'"';
	$count  =  $data->select(" * ", " site_users ", $where);

	if ($count == 0) {
		header('Location: '.SITEURL.'/register/confirm/?msg=6');
		exit;
	} else {
		$data = new Database();
		$arr = array(
			       'us_state' => 1, 
			       'us_hash' => ''
			       );
		$count  =  $data->update(" site_users ", $arr, 'us_email = "'.$email.'"');
		$id = $data->lastid();
		header('Location: '.SITEURL.'/register/confirm/?msg=7');
		exit;
	}
}

include('includes/header.php');
$title = 'Registration Confirmed';
include('includes/defaultheader.inc.php');
?>

<div class="pagecontent">
	<div class="single row">
		<div class="columns medium-8 medium-offset-2  end pagecontent">
        
        	<?php if ( REGISTERREQUIRECONFIRM == 1 ) { ?>
			<p>A verification email has being sent to your email address.</p>
        	<?php } else { ?>
        	<p>Your registration is complete. </p>
        	<a href="<?php echo SITEURL; ?>" class="button small">Back to home</a>
        	<?php } ?>

		</div>
	</div>
</div>



    
<?php include('includes/footer.php');?>
