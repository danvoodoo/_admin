<?php
$_GET['debug'] = 1;
$htmlemail = 1;
include_once('../admin/includes/init.php');
//include_once('../admin/functions/functions.php');
include_once('init.php');


ini_set('log_errors', true);
ini_set('error_log', dirname(__FILE__).'/ipn_errors.log');

include('ipnlistener.php');
$listener = new IpnListener();

if ($sandbox)
    $listener->use_sandbox = true;
else
    $listener->use_sandbox = false;

try {
    $listener->requirePostMethod();
    $verified = $listener->processIpn();
} catch (Exception $e) {
    error_log($e->getMessage());
    //exit(0);
}




if ( isset($_GET['id']) ) {
    $data = new Database();
    $where = 'res_id = '.$_GET['id'];
    $count  =  $data->select(" * ", " ipnresponse ", $where);
    $r = $data->getObjectResults();
    $_POST = print_r_reverse($r->res_post);
    print_r($_POST);
} else {
    
    $data = new Database();
    $arr = array(
       'res_response' => print_r($listener, true),
       'res_post' => print_r($_POST, true),
       'res_get' => print_r($_GET, true),
       'res_date' => date('c'),
       //'verified' => print_r($verified, true)
    );
    $count  =  $data->insert(" ipnresponse ", $arr);
    $id = $data->lastid();
}
//mail($dev_email, 'Invalid IPN', $listener->getTextReport());

$confirmed = 0;
if ($sandbox) {
    if ( $_POST['payment_status'] )  $confirmed = 1;
} else {
    if ( 
        $_POST['payment_status'] == 'Completed'  ) $confirmed = 1;
}

if ( $confirmed ) {   

    $output = print_r($listener, true);
    $errmsg = '';

    // get order
    $data = new Database();
    $where = 'or_id = '.$_POST['custom'];
    $count  =  $data->select(" * ", " orders ", $where);
    $order = $data->getObjectResults();
    $output .= print_r($order,true); //debug

    $where = 'us_id = '.$order->or_user;
    $count  =  $data->select(" * ", " site_users ", $where);
    $user = $data->getObjectResults();
    $output .= print_r($user,true); //debug

    
 

    if ($_POST['payment_status'] != 'Completed' && !$sandbox) { // simply ignore any IPN that is not completed
        exit(0); 
    }

    if ($_POST['receiver_email'] != $receiveremail) { //security measure
        $errmsg .= "'receiver_email' does not match: ";
        $errmsg .= $_POST['receiver_email']."\n";
    }


    $ordertotal = $order->or_total + $order->or_shippingtotal;
    if (number_format($_POST['mc_gross']) != number_format($ordertotal)) { //security measure
        $errmsg .= "'mc_gross' does not match: ";
        $errmsg .= $ordertotal."\n";
        $errmsg .= $_POST['mc_gross']."\n";
    } 



    if (!empty($errmsg)) {
        // manually investigate errors from the fraud checking
        $output .= $errmsg; //debug
        $body = "IPN failed fraud checks: \n$errmsg\n\n";
        $body .= $listener->getTextReport();
        mail($email, 'IPN Fraud Warning', $body);
        
    } else {

        /* *************************** PROCESS ORDER ********************* */
        if ($order->or_state != 0) die('Order already procesed'); //i dont think this is going to happend ever.

        // change order status
        $data = new Database();
        $arr = array(
                   'or_confirm' => 1
                   );
        $count  =  $data->update(" orders ", $arr, "or_id = ".$order->or_id);


        if ( MANAGESTOCK  ){

            $cart = json_decode($order->or_cart);
            foreach ($cart as $k => $c) {
       
                $data = new Database();
                $where = 'prod_id = '.$k;
                $count  =  $data->select(" * ", " products ", $where);
                $r = $data->getObjectResults();

                $data = new Database();
                $where = 'prod_id = '.$r->prod_parent;
                $count  =  $data->select(" * ", " products ", $where);
                $par = $data->getObjectResults();

                $stock = $r->prod_stock - $c->q;
                if ( $stock < 0 ) $stock = 0;

                $data = new Database();
                $arr = array(
                    'prod_stock' => $stock
                );
                $count  =  $data->update(" products ", $arr, "prod_id = ".$k);

                if ( $stock == 0 ){
                    $data = new Database();
                    $where = 'prod_id = '.$r->prod_parent;
                    $count  =  $data->select(" * ", " products ", $where);
                    $par = $data->getObjectResults();
                    
                    $msgSub = SITENAME.' - '.$par->prod_title.' - '.$r->prod_title.' ran out of stock.';
                    $msg = $par->prod_title.' - '.$r->prod_title.' ran out of stock. <br>
                    <a href="'.SITEURL.'admin/shop-products.php?id='.$par->prod_id.'">See product in admin</a>
                    ';
                    $msgTo = get_option( 'outofstocknotification' );
                    include("../admin/notify/index.php");
                }
                

            }
        }



        //email user here

        $details = cartstring( $order );



        $msg = '<h1>Thank you for your purchase. </h1>
                '.$details.'<br>
                <a href="'.SITEURL.'contact/">Contact Us</a>
                <p><strong>Please do not reply to this email.</strong></p>
                ';
        $msgSub  = SITENAME.' - Purchase confirmation';
        $msgTo = $order->or_email;
        
        include("../admin/notify/index.php");


        $msg = $details.'<br>
                <a href="'.SITEURL.'admin/orders.php?id='.$order->or_id.'">View order in admin</a>
                <p><strong>Please do not reply to this email.</strong></p>
                ';
        $msgTo = get_option( 'ordernotification' );
        
        $msgSub  = $order->or_bill_name.' '.$order->or_bill_lastname.' #'.$order->or_id.' - Purchase confirmation';
        include("../admin/notify/index.php");


        /*

        $details = cartstring( $order );
        $details .= '<hr>';
        $details .= '<h4>Shipping info</h4>';
        $details .= 'Name: '.$order->or_name.' '.$order->or_lastname.'<br>';
        $details .= 'Email: '.$order->or_email.'<br>';
        $details .= 'Address: '.$order->or_address.'<br>';
        $details .= 'Postcode: '.$order->or_cp.'<br>';
        $details .= 'City: '.$order->or_city.'<br>';
        $details .= 'County: '.$order->or_county.'<br>';
        $details .= 'Phone: '.$order->or_phone.'<br>';

        $details .= '<h4><br>Billing info</h4>';
        $details .= 'Name: '.$order->or_bill_name.' '.$order->or_bill_lastname.'<br>';
        $details .= 'Email: '.$order->or_bill_email.'<br>';
        $details .= 'Address: '.$order->or_bill_address.'<br>';
        $details .= 'Postcode: '.$order->or_bill_cp.'<br>';
        $details .= 'City: '.$order->or_bill_city.'<br>';
        $details .= 'County: '.$order->or_bill_county.'<br>';
        $details .= 'Phone: '.$order->or_bill_phone.'<br>';


        $details .= '<h4>Delivery notes</h4>';
        $details .= 'Instructions: '.$order->or_notes.'<br>';
        $details .= 'Additional comments: '.$order->or_addnotes.'<br>';




        $msg = '<h1>New Purchase - #'.$order->or_id.'</h1>
            <a href="'.SITEURL.'admin/orders.php?id='.$order->or_id.'">See order in admin</a>
            <br>----------------------------------<br><h3>Product List</h3> 
        '.$details;
        $msgSub  = SITENAME.' - Purchase confirmation';
        $msgTo = get_option( 'ordernotification' );
        include("../admin/notify/index.php");
        */

        /* *************************** PROCESS ORDER ********************* */
    }



} else {

    mail($dev_email, 'Invalid IPN', $listener->getTextReport());
}























function print_r_reverse($in) { 

    $lines = explode("\n", trim($in)); 

    if (trim($lines[0]) != 'Array') { 

        // bottomed out to something that isn't an array 

        return $in; 

    } else { 

        // this is an array, lets parse it 

        if (preg_match("/(\s{5,})\(/", $lines[1], $match)) { 

            // this is a tested array/recursive call to this function 

            // take a set of spaces off the beginning 

            $spaces = $match[1]; 

            $spaces_length = strlen($spaces); 

            $lines_total = count($lines); 

            for ($i = 0; $i < $lines_total; $i++) { 

                if (substr($lines[$i], 0, $spaces_length) == $spaces) { 

                    $lines[$i] = substr($lines[$i], $spaces_length); 

                } 

            } 

        } 

        array_shift($lines); // Array 

        array_shift($lines); // ( 

        array_pop($lines); // ) 

        $in = implode("\n", $lines); 

        // make sure we only match stuff with 4 preceding spaces (stuff for this array and not a nested one) 

        preg_match_all("/^\s{4}\[(.+?)\] \=\> /m", $in, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER); 

        $pos = array(); 

        $previous_key = ''; 

        $in_length = strlen($in); 

        // store the following in $pos: 

        // array with key = key of the parsed array's item 

        // value = array(start position in $in, $end position in $in) 

        foreach ($matches as $match) { 

            $key = $match[1][0]; 

            $start = $match[0][1] + strlen($match[0][0]); 

            $pos[$key] = array($start, $in_length); 

            if ($previous_key != '') $pos[$previous_key][1] = $match[0][1] - 1; 

            $previous_key = $key; 

        } 

        $ret = array(); 

        foreach ($pos as $key => $where) { 

            // recursively see if the parsed out value is an array too 

            $ret[$key] = print_r_reverse(substr($in, $where[0], $where[1] - $where[0])); 

        } 

        return $ret; 

    } 

} 
