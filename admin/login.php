<?php
ini_set('session.save_path', 'session');
@session_start();
$msjerror = 0;

include("includes/config.php");

if (isset($_GET["out"])) {
    session_destroy();
    header ("Location: login.php"); 
    exit;
}
if (isset($_POST["action"]) AND $_POST['action'] == 'login' ) {


	if ( DEV == 0 ) { //dot add captcha for localhost

		$key = '6LfQWwgUAAAAABXqPB9otnCvbRNCiSsL1s1ZTNbs';
		$secret = '6LfQWwgUAAAAAE13PQV9I2FB2nI40BDBnB4aEVdS';

		if ( $_POST['g-recaptcha-response'] == '' ) {
			header('Location: login.php?error=2');
			exit;
		}

		$captcha=$_POST['g-recaptcha-response'];
		$response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);

	    if($response['success'] == false) {
	        header('Location: login.php?error=2');
			exit;
	    }

	}


	include("includes/init.php");
	
	$user = addslashes(trim(($_POST['user'])));
	$pass = addslashes(trim($_POST['pass']));
	$pass = sha1($pass.SALT);

	$data = new Database();
	$where = "u_user = '$user' AND u_pass = '$pass'";
	if ( LOCAL == 1 ) { //login with only user for localhost
		$where = "u_user = '$user'";
	}
	$count  =  $data->select(" * ", " users ", $where);
	
	if ($count == 1 ) {
		$r = $data->getObjectResults();
		
		$_SESSION["admin"] = true;
		$_SESSION["iduser"] = $r->u_id;
		$_SESSION["user"] = $r->u_user;
		$_SESSION["level"] = $r->u_level;
		header ("Location: index.php"); 
		exit;
	} else {
		unset($usuario,$password,$_POST["action"],$dia);
		session_destroy();
		header('Location: login.php?error=1');
		exit;
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html class="login">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo SITENAME;?></title>
<link rel="stylesheet" href="css/foundation.css" />
<link href="css/styles.css" rel="stylesheet" type="text/css">
<script src='https://www.google.com/recaptcha/api.js'></script>


</head>

<body class='login'>

	<div class="logo">
    	<img src="img/logo.png" width="177" height="59" alt="<?php echo SITENAME;?>" />
    </div><!--fin logo-->

	<form action="login.php" id="formlogin" name="formlogin" method="post" >

		<label>User</label>
		<input type="text" aria-required="true" tabindex="1"  name="user" required>

		<label>Password</label>
		<input type="password" aria-required="true" tabindex="1"   name="pass" required>

		<input name="action" value="login" type="hidden">

		<?php if ( DEV == 0 ) {?>
		<div class="g-recaptcha" data-sitekey="6LfQWwgUAAAAABXqPB9otnCvbRNCiSsL1s1ZTNbs" ></div>	
		<?php } ?>

		<br>

		<input class="button expand"  type="submit" value="Enter">
		
	
		<?php if (isset($_GET['error']) AND $_GET['error'] == 1) {?>
			<br><br>
			<div data-alert class="alert-box alert">
			  The user and/or password are incorrect.
			</div>
		<?php } ?>

		<?php if (isset($_GET['error']) AND $_GET['error'] == 2) {?>
			<br><br>
			<div data-alert class="alert-box alert">
			  Please check the captcha
			</div>
		<?php } ?>

	</form>


</body>
</html>

	