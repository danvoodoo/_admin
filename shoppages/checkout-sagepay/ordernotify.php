<?php
$dev_email = 'gabitondw@gmail.com';

function text_to_array($str) {

        //Initialize arrays
        $keys = array();
        $values = array();
        $output = array();

        //Is it an array?
        if( substr($str, 0, 5) == 'Array' ) {

            //Let's parse it (hopefully it won't clash)
            $array_contents = substr($str, 7, -2);
            $array_contents = str_replace(array('[', ']', '=>'), array('#!#', '#?#', ''), $array_contents);
            $array_fields = explode("#!#", $array_contents);

            //For each array-field, we need to explode on the delimiters I've set and make it look funny.
            for($i = 0; $i < count($array_fields); $i++ ) {

                //First run is glitched, so let's pass on that one.
                if( $i != 0 ) {

                    $bits = explode('#?#', $array_fields[$i]);
                    if( $bits[0] != '' ) $output[$bits[0]] = trim($bits[1]);

                }
            }

            //Return the output.
            return $output;

        } else {

            //Duh, not an array.
            echo 'The given parameter is not an array.';
            return null;
        }

    }


$bodyclass='';
if ( isset($_GET['id']) ) { $_GET['debug'] = 1; }
include('admin/includes/init.php');	

if ( isset($_GET['id']) ) {
	$data = new Database();
	$where = 'res_id = '.$_GET['id'];
	$count  =  $data->select(" * ", " ipnresponse ", $where);
	$r = $data->getObjectResults();
	$_POST = text_to_array($r->res_post);
} else {

$data = new Database();
$arr = array(
	       'res_post' => print_r($_POST, true),
	       'res_get' => print_r($_GET, true),
	       'res_date' => date('c')
	       );
$count  =  $data->insert(" ipnresponse ", $arr);
$id = $data->lastid();
}


if ( $_POST['Status'] == 'OK' ) {

	$data = new Database();
	if ( isset($_GET['id']) ) {
		$where = 'or_txcode = "'.trim($_POST['VendorTxCode']).'" '; //AND or_confirm = 0';
	} else {
		$where = 'or_txcode = "'.trim($_POST['VendorTxCode']).'" AND or_confirm = 0';
	}
	$count  =  $data->select(" * ", " orders ", $where);
	$r = $data->getObjectResults();
	$order = $r;

	if ($count == 1) {

		$data = new Database();
		$arr = array(
			       'or_confirm' => 1,
			       'or_response' => print_r($_POST, true)
			       );
		$count  =  $data->update(" orders ", $arr, "or_id = ".$r->or_id);
		$id = $data->lastid();

		if ( $r->or_user != '' AND $r->or_user > 0) {
			$data = new Database();
			$where = 'us_id = '.$r->or_user;
			$count  =  $data->select(" * ", " site_users ", $where);
			$u = $data->getObjectResults();
			$emailuser = $u->us_email;
			$lastnameuser = $u->us_lastname;
			$nameuser = $u->us_name;

		} else {
			$emailuser = $r->or_email;
			$lastnameuser = $r->or_lastname;
			$nameuser = $r->or_name;



		}
		$address = $r->or_city.', '.$r->or_county.', '.$r->or_cp;




		//send emails here


		$cart = json_decode($order->or_cart);
        $subtotal = 0;
        $details = '';
        foreach ($cart as $k => $c) {
       
            $data = new Database();
            $where = 'prod_id = '.$k;
            $count  =  $data->select(" * ", " products ", $where);
            $r = $data->getObjectResults();



            $stock = $r->prod_stock - $c->q;
            if ( $stock < 0 ) $stock = 0;

            $data = new Database();
            $arr = array(
                       'prod_stock' => $stock
                       );
            $count  =  $data->update(" products ", $arr, "prod_id = ".$k);
             $id = $data->lastid();

            if ( isset($r->prod_price_sale) AND $r->prod_price_sale > 0 ){
                $r->prod_price = $r->prod_price_sale;
            }

           // print_r($r);
           // print_r($c);
            
            $subtotal = $subtotal + $r->prod_price*$c->q;
            $details .= $r->prod_title.'.................. &pound;'.number_format($r->prod_price,2).' x '.$c->q.'<br>';
            $details .= '&pound;'.number_format($r->prod_price*$c->q,2).'<br>----------------------------------<br>';
        }
        $details .= '<strong>Order Total: &pound;'.number_format($subtotal,2).'</strong>';

        $data = new Database();
		$where = 'post_type = "shipping" AND post_id = '.$order->or_shipping;
		$count  =  $data->select(" * ", " post ", $where);
		$ship = $data->getObjectResults();

        $details .= '<br>Shipping: '.$ship->post_title.' - &pound;'.number_format($order->or_shippingtotal,2).'<br>
        <strong>Total: &pound;'.number_format($subtotal+$order->or_shippingtotal,2).'</strong>
        ';



        $msj = '<h1>Thank you for your purchase. </h1><br>
                Here are the details: <br><br>'.$details.'<br><br>
                
                
                <strong>Please do not reply to this email.</strong>
                ';
        $msgSub  = SITENAME.' - Purchase confirmation';
        $msgTo = $dev_email;
        $msgTo = $emailuser;

        if ( isset($_GET['id']) ) $msgTo = 'gabitondw@gmail.com';

        $htmlemail = 1;
        $emaillog = 0;
        include("admin/notify/index.php");




        $cart = json_decode($order->or_cart);
        $subtotal = 0;
        $details = '';
        foreach ($cart as $k => $c) {
       
            $data = new Database();
            $where = 'prod_id = '.$k;
            $count  =  $data->select(" * ", " products ", $where);
            $r = $data->getObjectResults();

            if ( isset($r->prod_price_sale) AND $r->prod_price_sale > 0 ){
                $r->prod_price = $r->prod_price_sale;
            }
            
           // print_r($r);
            
            $subtotal = $subtotal + $r->prod_price*$c->q;
            $details .= $r->prod_title.'.................. &pound;'.number_format($r->prod_price,2).' x '.$c->q.'<br>'.$r->prod_code.'<br><br>';
            $details .= '&pound;'.number_format($r->prod_price*$c->q,2).'<br>----------------------------------<br>';
        }
        $details .= '<br>Shipping: '.$ship->post_title.' - &pound;'.number_format($order->or_shippingtotal,2).'<br>
        <strong>Total: &pound;'.number_format($subtotal+$order->or_shippingtotal,2).'</strong>
        ';



        $msj = '<h1>New Purchase - #'.$order->or_id.'</h1>
        	User: '.$nameuser.' '.$lastnameuser.' <br> Email: '.$emailuser.' <br>
        	Address: '.$order->or_address.'<br>
        	Postcode: '.$order->or_cp.'<br>
        	City: '.$order->or_city.'<br>
        	County: '.$order->or_county.'<br>
        	Phone: '.$order->or_phone.'<br>
			Order Notes: '.$order->or_notes.'<br><br>----------------------------------<br>
			<a href="'.SITEURL.'admin/orders.php?id='.$order->or_id.'">See order in admin</a>
			<br>----------------------------------<br><h3>Product List</h3> 
        '.$details;
        //echo $msj;
        $msgSub  = SITENAME.' - Purchase confirmation - #'.$order->or_id;
        $msgTo = ORDERNITIFY;

        include("admin/notify/index.php");


		//$url = 'https://test.sagepay.com/gateway/service/vspserver-register.vsp';
		$fields = array(
			'Status' => 'OK',
			'RedirectURL' => SITEURL.'checkout/confirm/'
		);
foreach ($fields as $key => $value) {
echo $key.'='.$value.'
';
}


	}
}
