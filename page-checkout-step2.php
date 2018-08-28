<?php
$bodyclass='';
$activemenu='shop';
 
//$_GET['debug'] = 1;
include('includes/header.php');
include('paypal/init.php');


if ( isset($_GET['pay']) ) {
  $data = new Database();
  $id = addslashes($_SESSION['orderid']);
  $arr = array(
           'or_confirm' => 1
           );
  $count  =  $data->update(" orders ", $arr, "or_id = $id");
  
  header('Location: '.SITEURL.'thank-you/');
  exit;
}


$id = addslashes($_SESSION['orderid']);
$data = new Database();
$where = 'or_id = '.$id;
$count  =  $data->select(" * ", " orders ", $where);
$order = $data->getObjectResults();
$cart = json_decode($order->or_cart);



$title = 'Checkout';
include('includes/defaultheader.inc.php');
?>

<div class="content single">
  <div class="row">
    <div class="columns medium-12 ppform">
      <p>
            <?php echo get_option('paypalredirect') ;?>
          </p>
          <?php
          paypalformcart( array(
              'cart' => $_SESSION['cart'],
              'return' => SITEURL.'purchase-confirmed/',
              'orderid' => $id,
              'currency' => 'GBP',
              'shipping' => $order->or_shippingtotal
          )  );
          ?>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function () {

setTimeout(function () {
$('.ppform form').submit()
},1000);

});
</script>

<?php include('includes/footer.php');?> 