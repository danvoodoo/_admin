<?php
//$_GET['debug'] = 1;
if (isset($_POST['action']) AND $_POST['action'] == 'register') {
	include_once('admin/includes/init.php');		

	
	foreach($_POST as $nombre_campo => $valor){ $asignacion = "\$" . $nombre_campo . "='" . addslashes(htmlspecialchars($valor)) . "';"; eval($asignacion); }//end foreach
	
	
	$data = new Database();
	$where = ' us_email = "'.$email.'"';
	$count  =  $data->select(" us_id ", " site_users ", $where);

	
	if ( $count > 0) { //email already register
		$msg = 2;
		//header ("Location: register.php?msg=2" );
		//exit;
	}
        
        if ($email == "" or $name == "" or $password== "" ) { //required fields, somehow skip the js verification
            $msg = 4;
	    /*header ("Location: register.php?msg=4" );
	    exit;*/
        }
	
	if (!isset($msg)) { //no message, no errors
		global $db_salt;
		$password = sha1($password.$db_salt);



		$hash = md5(time());
		$data = new Database();
		$arr = array(
			       	'us_name' => $name,
			       	'us_lastname' => $lastname,
			       	'us_email' => $email,
			       	'us_postcode' => $postcode,
			       	'us_address' => $address1,
				 	'us_city' => $city,
				 	'us_county' => $county,
				 	'us_country' => $country,
			       	'us_phone' => $telephone,
			       	'us_state' => 0,
			       	'us_level' => 'consumer',
			       	'us_hash' => $hash,
			       	'us_password' => $password,
			       	'us_date' => date('Ymd')
			    );
		$count  =  $data->insert(" site_users ", $arr);
		$id = $data->lastid();
		
		if ( REGISTERREQUIRECONFIRM == 1 ) { //if register requires confirmation, sent email
			$link = SITEURL.'register/confirm/?email='.$email.'&hash='.$hash;
			$msj = 'You have registered on '.SITENAME.' 
				, thank you. Please visit the link to confirm your subscription.
				<a href="'.$link.'">'.$link.'</a>';
			$msgSub  = 'Welcome to '.SITENAME;

			
			$msgTo = $email;  
			if (PRODUCTION == 0)  $msgTo = DEVEMAIL;
			include("admin/notify/index.php");
		} else { //if not, login the user
			session_start();
			$_SESSION['id'] = $id;
			$_SESSION['email'] = $email;
			$_SESSION['name'] = $name;
			$_SESSION['state'] = 0;
		}
		
		
		$msj = 'Name: '.$name.' '.$lastname.' &lt;'.$email.'&gt; <br>
			Address: '.$address1.'<br>
			City: '.$city.'<br>
			County: '.$county.'<br>
			Country: '.$country.'<br>
			Telephone'.$telephone.'<br>';
		$msgSub  = 'New user registered - '.SITENAME;
		
		$msgTo = get_option('notificationemail');
		if (PRODUCTION == 0)  $msgTo = DEVEMAIL;
		include("admin/notify/index.php");
		
		
		header('Location: '.SITEURL.'register/thanks/');
		exit;
	}
	
}

$bodyclass='';

include('includes/header.php');

$title = 'Register';
include('includes/defaultheader.inc.php');
?>


<div class="pagecontent">
	<div class="row">
		<div class="columns medium-8 medium-offset-2  end">


			<p>Registering with us is fast, free and saves you time ordering with us. </p>
			
						
			<?php
			if (isset($msg) AND $msg == 4)  {?>
			<div data-alert class="alert-box warning alert">
				Some required fields are empty.
				<a href="#" class="close">&times;</a>
			</div>
			<?php } ?>
			
			<?php
			if (isset($msg) AND $msg == 2)  {?>
			<div data-alert class="alert-box warning alert">
				The email is already registered.
				<a href="#" class="close">&times;</a>
			</div>
			<?php } ?>
			
			<form action="" class="custom"  data-abide id='registrologin' method='POST'>
				
				<div class="row">
					<div class="large-6 columns">
						<div class="field">
							<label for="">Name</label>
							<input type="text" name='name' required  value='<?php if (isset($_POST['name'])) echo $name;?>'>
						</div>
					</div>

					<div class="large-6 columns">
						<div class="field">
							<label for="">Lastname</label>
							<input type="text" name='lastname' required  value='<?php if (isset($_POST['lastname'])) echo $lastname;?>'>
						</div>
					</div>

					


					<div class="large-6 columns">
						<div class="field">
							<label for="">Email</label>
							<input type="email" name='email' required  value='<?php if (isset($_POST['email'])) echo $email;?>'>
						</div>
					</div>
					<div class="large-6 columns">
						<div class="field">
							<label for="">Telephone</label>
							<input type="text" name='telephone' value='<?php if (isset($_POST['telephone'])) echo addslashes($_POST['telephone']);?>'>
						</div>
					</div>

					<div class="clearfix"></div>


					<div class="large-6 columns">
						<div class="field">
							<label for="">Address</label>
							<input type="text" name='address1' value='<?php if (isset($_POST['address1'])) echo addslashes($_POST['address1']);?>' required>
						</div>
					</div>

					<div class="medium-6 columns">
						<div class="field">
							<label for="">Postcode</label>

							<input type='text' name="postcode" required value='<?php if (isset($_POST['postcode'])) echo addslashes($_POST['postcode']);?>'>		

						</div>
					</div>
					
					


					<div class="clearfix"></div>

					<div class="medium-6 columns">
						<div class="field">
							<label for="">Town</label>
							<input type="text" name='city'  value='<?php if (isset($_POST['city'])) echo addslashes($_POST['city']);?>'>
						</div>
					</div>

					<div class="clearfix"></div>
                        
                        	<div class="medium-6 columns">
                        		<div class="field">
							<label for="">County</label>
							<input type="text" name='county'  value='<?php if (isset($_POST['county'])) echo addslashes($_POST['county']);?>'>
						</div>
					</div>

					<div class="clearfix"></div>

					<div class="medium-6 columns">
                        
                        		<div class="field">
							<label for="">Country</label>
							<input type="text" name='country'  value='<?php if (isset($_POST['country'])) echo addslashes($_POST['country']);?>'>
						</div>
					</div>

		
					<div class="clearfix"></div>


					<div class="large-6 columns">
						<div class="field">
							<small class="right">Minimun 6 characters</small>
							<label for="">Password</label>
							<input type="password" name='password' required >
						</div>
					</div>
					<div class="large-6 columns">
						<div class="field">
							<small class="right">Minimun 6 characters</small>
							<label for="">Repeat Password</label>
							<input type="password" name='password' required >
						</div>
					</div>
				
				
				</div><!--  row  -->
				
				
				<div class="text-center">
					<button class='button pink'>Submit</button>
					<input type="hidden" value='register' name='action'>
				</div>
				
			</form>
			
		</div>
		

	</div>
</div>


	
<?php include('includes/footer.php');?>
