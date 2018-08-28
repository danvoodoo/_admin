<?php 
if ( !defined(SITEURL) ) include_once('admin/includes/init.php');

if ( !isset($emaillog) )  {
	$post = $_POST;
	unset( $post['action'] );
	$data = new Database();
	$arr = array(
		       'post_content' => addslashes(json_encode($_POST)),
		       'post_excerpt' => addslashes( $msg ),
		       'post_type' => 'contact',
		       'post_title' => $name.' - '.$email,
		       'post_date' => date('c')
		       );
	$count  =  $data->insert(" post ", $arr);
	$id = $data->lastid();
}


$header = "From: ".EMAILFROM."\r\n"; 
if ( isset($email) ) {
	$header .= "Reply-To: ".$email."\r\n"; 
}
$header.= "MIME-Version: 1.0\r\n"; 
if ( isset($htmlemail) )
	$header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
else
	$header.= "Content-Type: text/plain; charset=utf-8\r\n"; 


//mail($msgTo, $msgSub, $msg, $header);





/************* HTML EMAIL */ 
$msj = $msg;
$header = SITEURL.'/img/emailtop.jpg';
 $msg  = "<table style='background: #ccc;' width='100%; font-family: sans-serif'>
 <tr><td colspan='3' height='10'></td></tr>
 <tr><td><td height='100'><img src='".$header."' alt='".SITENAME."' /></td></td><td></td></tr>
 <tr><td></td> <td width='480' style='background: #fff; padding: 10px'>";
 
 $msg  .= $msj;
 
 $msg  .= "</td><td></td></tr><tr><td colspan='3' height='10'></td></tr><tr><td></td></table>";
 
if ( isset($testemail) ) {
 	echo $msg;
 	exit;
}

require_once "includes/class.phpmailer.php";

$mail = new PHPMailer();
$mail->IsSMTP(); 

$mail->SMTPAuth = true;
$mail->Host = "mail.voodoochilli.com"; 
$mail->Username =  'webserver@voodoochilli.com';
$mail->Password =  'gabgab1155';
$mail->Port = 587; 
if ( isset($email) ) {
	$mail->AddReplyTo($email); 
}

if ($_GET['debug'] == 1) $mail->SMTPDebug  = 4;
	else
	$mail->SMTPDebug  = 0;


$mail->SetFrom('webserver@voodoochilli.com', SITENAME);

$mail->Subject    =  $msgSub;
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; 

$mail->MsgHTML($msg);

$msgTo = explode(',', $msgTo);
foreach ($msgTo as $m) {
	$mail->AddAddress(trim($m), trim($m));
}


$exito = $mail->Send();

$intentos=1; 
while ((!$exito) && ($intentos < 5)) {
	sleep(5);
     	//echo $mail->ErrorInfo;
     	$exito = $mail->Send();
     	$intentos=$intentos+1;	// hey Gab, you know you can just put $intentos++;
   }
 if ((!$exito)) return $mail->ErrorInfo;
 else 
 	return 1;
  

?>