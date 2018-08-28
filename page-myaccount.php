<?php
include_once('admin/includes/init.php') ;
session_name(SESSIONNAME);
session_start();

if ( $_SESSION['id'] <1 ) header ("Location:../");

if (isset($_POST['action']) AND $_POST['action'] == 'update') {

	foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . addslashes(htmlspecialchars($valor)) . "';"; eval($asignacion); }//end foreach
        
        if ($name == "" OR $address == '') { //required fields, somehow skip the js verification
            $msg = 4;
            $_GET['msg'] = 4;
	    /*header ("Location: register.php?msg=4" );
	    exit;*/
        }
	
	if (!isset($msg)) { //no message, no errors
		global $db_salt;
		$password = sha1($password.$db_salt);
		
		$data = new Database();
		$arr = array(
			'us_name' => $name,
			'us_lastname' => $lastname,
			'us_address' => $address,
			'us_city' => $city,
			'us_county' => $county,
			'us_country' => $country,
			'us_phone' => $telephone,
			'us_postcode' => $postcode
		);
		if ($_POST['password'] != ''){
			$arr['us_password'] = $password;
		}

		$where = 'us_id = '.$_SESSION['id'];
		$count  =  $data->update(" site_users ", $arr,  $where);
		$id = $data->lastid();
		
		header('Location: '.SITEURL.'myaccount/?msg=1');
		exit;
	}
	
}


if (isset($_GET['lo'])) {
	include('admin/includes/conexion.php');		
	session_destroy();
	header('Location: '.SITEURL);
	exit;
	
}


$bodyclass='';
include('includes/header.php');
$title = 'My Account';
include('includes/defaultheader.inc.php');

$data = new Database();
$where = 'us_id = '.$_SESSION['id'];
$count  =  $data->select(" * ", " site_users ", $where);
$r = $data->getObjectResults();
?>

<div class="pagecontent">
	<div class="single row">
		<div class="columns large-8 large-offset-2  end pagecontent">
            
        <p>Please review your account details:</p>

		<?php if (isset($_GET['msg']) AND $_GET['msg'] == 1) {?>
		<div data-alert class="alert-box success">
			Your details has been updated.
			<a href="#" class="close">&times;</a>
		</div>
		<?php } ?>
		

		<form action="" class="custom"  id='registrologin' method='POST' enctype="multipart/form-data">
				
				<div class="row">
					<div class="medium-6 columns">
						<div class="field">
							<label for="">Name</label>
							<input type="text" name='name' required  value='<?php echo $r->us_name;?>'>
						</div>
					</div>

					<div class="medium-6 columns">
						<div class="field">
							<label for="">Lastname</label>
							<input type="text" name='lastname' required value='<?php echo $r->us_lastname;?>'>
						</div>
					</div>

					<div class="medium-6 columns">
						<div class="field">
							<label for="">Email</label>
							<input type="email" name='email' required  value='<?php echo $r->us_email;?>' disabled>
						</div>
					</div>

					<div class="medium-6 columns">
						<div class="field">
							<label for="">Telephone</label>
							<input type="text" name='telephone' value='<?php echo $r->us_phone;?>'>
						</div>
					</div>

					<div class="clearfix"></div>



					<div class="clearfix"></div>
					
					<div class="medium-6 columns">
						<div class="field">
							<label for="">Address</label>
							<input type="text" name='address' value='<?php echo $r->us_address;?>' required>
							
						</div>
					</div>


					<div class="medium-6 columns">
						<div class="field">
							<label for="">Postcode</label>
							<input type='text' name="postcode" required value='<?php echo $r->us_postcode;?>'>		
								
						</div>
					</div>
					
					


					<div class="clearfix"></div>

					<div class="medium-6 columns">
						<div class="field">
							<label for="">Town</label>
							<input type="text" name='city' value='<?php echo $r->us_city;?>'>
						</div>

					</div>
					<div class="medium-6 columns">
                        
                        <div class="field">
							<label for="">County</label>
							<input type="text" name='county' value='<?php echo $r->us_county;?>'>
						</div>

					</div>
					<div class="medium-6 columns">
                        
                        <div class="field">
							<label for="">Country</label>
							<input type="text" name='country' value='<?php echo $r->us_country;?>'>
						</div>
					</div>

		
					<div class="clearfix"></div>
					<hr>

					<div class="clearfix"></div>

					<div class="medium-6 columns">
						<div class="field">
							
							<label for="">Password (Leave empty for no change)</label>
							<small class="right">More than 8 characters.</small>
							<input type="password" name='password' id='password'  >
						</div>
					</div>
					<div class="medium-6 columns">
						<div class="field">
							
							<label for="">Repeat Password</label>
							<small class="right">More than 6 characters.</small>
							<input type="password" name='password2' data-equalto="password" pattern=".{6,}">
						</div>
					</div>

				
				
				</div><!--  row  -->
				
				
				
				<button>Send</button>
				<input type="hidden" value='update' name='action'>
				
			</form>
		</div>
	</div>
</div>



<?php include('includes/footer.php');?>
