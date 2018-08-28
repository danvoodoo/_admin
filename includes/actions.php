<?php
//$_GET['debug'] = 1;
include_once('../admin/includes/init.php');

session_name(SESSIONNAME);
if (!isset($_SESSION)) session_start();



if (isset($_POST['action']) AND $_POST['action'] == 'deletecartitem') {
  unset( $_SESSION['cart'][ $_POST['key'] ] );
  echo cartquantity();
  exit;
}



if (isset($_POST['action']) AND $_POST['action'] == 'login') {

  foreach($_POST as $nombre_campo => $valor){ if (!is_array($valor)) $asignacion = "\$" . $nombre_campo . "='" . addslashes(htmlspecialchars($valor)) . "';"; eval($asignacion); }//end foreach

    if (!isset($_SESSION)) session_start();
    if (DEV == 1) unset($_SESSION['bruteforce']);
    if (!isset($_SESSION['bruteforce']) OR $_SESSION['bruteforce_timestamp'] < time() ) {
      $_SESSION['bruteforce'] = 0;
      $_SESSION['bruteforce_timestamp'] = time()+600;
    } else{
      $_SESSION['bruteforce']++;
      if ($_SESSION['bruteforce'] >= 10 AND $_SESSION['bruteforce_timestamp'] > time()) die('Brute force prevention. Wait 10 minutes and try again.');
    }

    global $db_salt;
    $p = sha1($p.$db_salt);

    $data = new Database();
    $where = 'us_email = "'.$u.'" AND us_state = 1 AND us_password = "'.$p.'"';
    $count  =  $data->select(" * ", " site_users ", $where);
    $r = $data->getObjectResults();
    
    $_SESSION['id'] = $r->us_id;
    $_SESSION['emaul'] = $r->us_email;
    $_SESSION['level'] = $r->us_level;
    $_SESSION['time'] = time();

    echo $count;
    /*
    if ($count == 0)
      echo 0;
    else
      echo $r->us_level;
      */
    exit;
}



if (isset($_POST['action']) AND $_POST['action'] == 'addtocart') {
    
    foreach($_POST as $fieldname => $value){ if (!is_array($value)) $ev = "\$" . $fieldname . "='" . addslashes(htmlspecialchars($value)) . "';"; eval($ev); }//end foreach
    
    
    if (isset($_SESSION['cart'][$id]) ) { //existing product in cart

        $_SESSION['cart'][$id]['q'] += $q;    

    } else { //new product in cart

        $_SESSION['cart'][$id] = array(
          'q' => $q,
          'id' => $id
          );
          
    }
   
    $output = array(
                    'q'=> cartquantity(),
                    't' => carttotal()
                    );
    echo json_encode($output);
    exit;
    
}




if (isset($_POST['action']) AND $_POST['action'] == 'contact') {

  unset( $_POST['action'] );
  $emailto = openssl_decrypt ($_POST['formaction'], 'AES-128-CBC', 'cms-key');
  unset($_POST['formaction']);
  $redirect = openssl_decrypt ($_POST['formred'], 'AES-128-CBC', 'cms-key');
  unset($_POST['formred']);

  $subject = addslashes( $_POST['subject'] );
  unset($_POST['subject']);

  $url = addslashes( $_POST['formurl'] );
  unset($_POST['formurl']);

  $msg = '';
  foreach ($_POST as $k => $r) {
    $k = ucfirst( str_replace('-', ' ', $k) );
    $msg .= '
    ';
    if ( is_array( $r ) ){
      foreach ($r as $rr) {
        $msg .= $r.'
        ';  
      }
      $msg .= '
      ';
    } else {
      $msg .= $k.': '.$r;  
    }
    
  }


  

  $msg .= '
  Sent from: '.$url;
  $msg = nl2br( trim( $msg ) );


  $msgSub = $subject;
  $msgTo = $emailto;
  include('../admin/notify/index.php');
  header('location: '.SITEURL.$redirect);
  exit;


}







if (isset($_POST['action']) AND $_POST['action'] == 'getshipping') {

  foreach($_POST as $fieldname => $value){ if (!is_array($value)) $ev = "\$" . $fieldname . "='" . addslashes(htmlspecialchars($value)) . "';"; eval($ev); }//end foreach

  if (isset($_SESSION['code']) AND $_SESSION['code']->post_category == 'shipping') {
    ?>
    <option value="0" data-val='0'>Free Shipping</option>
    <?php
    exit;
  }

  $total = carttotal();
  $data = new Database();
  $where = 'post_type = "shipping" AND post_state = 1 ' ;
  $count  =  $data->select(" * ", " post ", $where, 'post_content ASC');

  $total = carttotal(0);
  $_SESSION['shippingpostcode'] = $postcode;  

  $a = 0;
  while($r = $data->getObjectResults()){ 
 
    getmetas( $r->post_id, $r->post_type );
    $valid = 1;

    if (  $r->post_weightto > 0 AND $r->post_weightto < $weight) $valid = 0; //if weights more, is invalid
    if (  $r->post_weightfrom > 0 AND $r->post_weightfrom > $weight) $valid = 0; //if weight less is invalid

    if (  $r->post_to > 0 AND $r->post_to < $total) $valid = 0; //if total is more is invalid
    if (  $r->post_from > 0 AND $r->post_from > $total) $valid = 0; //if total is less, is invalid
  
    $validlength = 0;

    if ( $r->post_postcodes != '' ) {
      $postcodevalid = 0;
      $postcodes = explode(',', str_replace(' ', '',  $r->post_postcodes));
    
      foreach ($postcodes as $p) {
        $postcodetocompare = substr( $postcode, 0, strlen($p) ); //trim the postdoe to he same lenthg as the shipping postcode
    
        if ( strtoupper($p) == strtoupper($postcodetocompare) ) {
          $validlength = strlen($p);
          $postcodevalid = 1;
        }
      }


      if ( $r->post_excludepostcodes != '' ) {
        $excludepostcodes = explode(',', str_replace(' ', '',  $r->post_excludepostcodes));
        foreach ($excludepostcodes as $p) {
          $postcodetocompare = substr( $postcode, 0, strlen($p) ); //trim the postdoe to he same lenthg as the shipping postcode
      
          if ( strtoupper($p) == strtoupper($postcodetocompare) && strlen($p) > $validlength ) {
            $postcodevalid = 0;
          }
        }
      }

    if ( $postcodevalid == 0 ) $valid = 0; //if it doesnt match any postcode, this shipping method doesnt apply
  }

  if ( $valid ) {
    $a++;
    if ( $a==1 ) {?>
    <option value="-1">Select shipping method</option>
    <?php
    }
  ?>
  <option data-val="<?php echo $r->post_content*VAT+$r->post_content;?>" value='<?php echo $r->post_id;?>' <?php if ( $r->post_content == 0 ){?>selected<?php } ?>>
    <?php echo $r->post_title;?>
    <?php if ( $r->post_content > 0 ){?>
     - &pound;<?php echo number_format($r->post_content*VAT+$r->post_content,2);?>  (inc. VAT)
    <?php } ?>
  </option>
  <?php } 
  }
  exit;
} //getshipping



if (isset($_POST['action']) AND $_POST['action'] == 'setshippingoption') {
  if ( $_POST['shipping'] == '' ){
    unset($_POST['shipping']);
  } else {
    $_SESSION['shipping'] = addslashes($_POST['shipping']); 
  } 
  echo $_SESSION['shipping']; 
  exit;
}
