<?php
// REMEMBER TO SET THE IP IN SAGEPAY ADMIN

include('admin/includes/init.php');  
session_name(SESSIONNAME);
if (!isset($_SESSION)) session_start();


$id = addslashes($_GET['order']);
$data = new Database();
$where = 'or_id = '.$id;
$count  =  $data->select(" * ", " orders ", $where);
$r = $data->getObjectResults();
$cart = json_decode($r->or_cart);

$VendorTxCode = time().'-'.$id;

unset($_SESSION['code']);
unset($_SESSION['cart']);



$url = 'https://test.sagepay.com/gateway/service/vspserver-register.vsp';

$fields = array(
      'VPSProtocol' => '3.00',
      'TxType' => 'PAYMENT',
      'Currency' => 'GBP',
      'Amount' => $r->or_total+$r->or_shippingtotal,
      'Vendor' => 'verdorsname',
      'VendorTxCode' => $VendorTxCode,
      'Description' => 'Cart Items',
      'NotificationURL' => str_replace('http','https',SITEURL).'ordernotify.php',
      'RedirectURL' => str_replace('http','https',SITEURL).'checkout/confirm/',

      

      'BillingFirstnames' => $r->or_name,
      'BillingSurname' => $r->or_lastname,
      'BillingAddress1' => $r->or_address,
      'BillingCity' => $r->or_city,
      'BillingPostCode' => $r->or_cp,
      'BillingCountry' => $r->or_country,

      'DeliverySurname' => $r->or_lastname,
      'DeliveryFirstnames' => $r->or_name,
      'DeliveryAddress1' => $r->or_address,
      'DeliveryCity' => $r->or_city,
      'DeliveryPostCode' => $r->or_cp,
      'DeliveryCountry' => $r->or_country,
);


foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

$ch = curl_init();

curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch);

curl_close($ch);

$responses = array();
$response_array = explode("\r\n", $result);


for ($i=0; $i < sizeof($response_array); $i++) {
      $key = substr($response_array[$i],0, strpos($response_array[$i], '='));
      $responses[$key] = substr(strstr($response_array[$i], '='), 1);
}

if ( $responses['Status'] == 'OK' ){
      $data = new Database();
      $arr = array(
                   'or_checkoutcode1' => $responses['VPSTxId'],
                   'or_checkoutcode2' => $responses['SecurityKey'],
                   'or_checkoutcode3' => $VendorTxCode,
                   );
      $count  =  $data->update(" orders ", $arr, "or_id = $id");
      $id = $data->lastid();
      header('Location: '.$responses['NextURL']);
      exit;
} else {
      print_r($responses);
}

