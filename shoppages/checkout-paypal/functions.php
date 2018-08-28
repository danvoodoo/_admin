<?php

function paypalform($args) {

global $sandbox, $receiveremail;
if ($sandbox) {
  $url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
} else {
  $url = 'https://www.paypal.com/cgi-bin/webscr';
}
  ?>

<form name="_xclick" action="<?php echo $url;?>" method="post">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="business" value="<?php echo $receiveremail;?>">
        <input type="hidden" name="currency_code" value="<?php echo $args['currency'];?>">
        <input type="hidden" name="item_name" value="<?php echo $args['description'];?>">
        <input type="hidden" name="amount" value="<?php echo $args['ammount'];?>">
      <input type="hidden" name="quantity" value="<?php echo $args['quantity'];?>">
        
        <input type="hidden" name="return" value="<?php echo $args['return'];?>">
        <input type="hidden" name="notify_url" value="<?php echo SITEURL;?>paypal-ipn/ipn.php">
        <input type="submit" class='button paypal-btn' value='Continue'>
        <input type="hidden" name='custom' value="<?php echo $args['orderid'];?>">
    </form>
<?php
}



function paypalformcart($args) {

global $sandbox, $receiveremail;
if ($sandbox) {
  $url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
} else {
  $url = 'https://www.paypal.com/cgi-bin/webscr';
}

if (!isset($args['button'])) $args['button'] = 'Continue';
  ?>

<form name="_xclick" action="<?php echo $url;?>" method="post">
        <input type="hidden" name="cmd" value="_cart">
        <input type="hidden" name="upload" value="1">
        <input type="hidden" name="business" value="<?php echo $receiveremail;?>">
        <input type="hidden" name="currency_code" value="<?php echo $args['currency'];?>">
        
        <?php
        $a=0;
        $total = 0;
        foreach ($args['cart'] as $id => $c) {

          $a++;
          $data = new Database();
          $where = 'prod_id = '.$id;
          $count  =  $data->select(" * ", " products ", $where);
          $product = $data->getObjectResults();
          $total += $product->prod_price*$c['q'];

          $data = new Database();
          $where = 'prod_id = '.$product->prod_parent;
          $count  =  $data->select(" * ", " products ", $where);
          $par = $data->getObjectResults();

          $price = $product->prod_price;
          //if ($product->prod_pricesale > 0 ) $price = $product->prod_pricesale;


          $data = new Database();
          $where = 'prod_parent = '.$product->prod_parent;;
          $count  =  $data->select(" * ", " products ", $where);
          if ( $count == 1 ) { //only one variant
            $variant = '';
          } else {
            $variant = ' - '.$product->prod_title;
          }

        ?>
          <input type="hidden" name='item_name_<?php echo $a;?>' value='<?php echo $par->prod_title.$variant;?>'>
          <input type="hidden" name='item_number_<?php echo $a;?>' value='<?php echo $product->prod_id;?>'>
          <input type="hidden" name='amount_<?php echo $a;?>' value='<?php echo $price;?>'>
          
          <input type="hidden" name='quantity_<?php echo $a;?>' value='<?php echo $c['q'];?>'>
          
          
        <?php } 
        /*
        if ($total < 100) { $a++; ?>
          <input type="hidden" name='item_name_<?php echo $a;?>' value='Postage'>
          <input type="hidden" name='item_number_<?php echo $a;?>' value='Postage'>
          <input type="hidden" name='amount_<?php echo $a;?>' value='2.99'>
          <input type="hidden" name='shipping_<?php echo $a;?>' value='0'>
          <input type="hidden" name='quantity_<?php echo $a;?>' value='1'>
        <?php }*/
         ?>

         <?php if (isset($args['shipping'])) {?>
          <input type="hidden" name="shipping_1" value="<?php echo $args['shipping'];?>">
         <?php } ?>


        <?php 
        if ( DISCOUNTCODE == 1 ) {
        if (isset($_SESSION['code'])) {
          if ($_SESSION['code']->post_category == 'value') $discount = $_SESSION['code']->post_content;
          if ($_SESSION['code']->post_category == 'percent') $discount = $total*$_SESSION['code']->post_content/100;
          ?>
          <input type="hidden" name='discount_amount_cart' value='<?php echo $discount; ?>'>
        <?php } ?>
        <?php } ?>

        
        <input type="hidden" name="return" value="<?php echo $args['return'];?>">
        <input type="hidden" name="notify_url" value="<?php echo SITEURL;?>paypal/ipn.php">
        <input type="submit" class='button paypal-btn' value='<?php echo $args['button'] ;?>'>
        <input type="hidden" name='custom' value="<?php echo $args['orderid'];?>">
    </form>
<?php
}