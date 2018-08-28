<?php
if (isset($_POST['action']) AND $_POST['action'] == 'order') {

	
	include('admin/includes/init.php');	
	session_name(SESSIONNAME);
	if (!isset($_SESSION)) session_start();


	


	foreach($_POST as $fieldname => $value){ if (!is_array($value)) $ev = "\$" . $fieldname . "='" . addslashes(htmlspecialchars($value,ENT_QUOTES)) . "';"; eval($ev); }//end foreach
	

	if (!isset($msg)) { //no message, no errors
		global $db_salt;


		if ( isset($_SESSION['id']) ) {
			$data = new Database();
			$where = 'us_id = '.$_SESSION['id'];
			$count  =  $data->select(" * ", " site_users ", $where);
			$u = $data->getObjectResults();


			if ($name == '') $name = $u->us_name;
			if ($lastname == '') $lastname = $u->us_lastname;

		}

		
		if ( SHIPPING == 1 ) {
			if (isset($_SESSION['code']) AND $_SESSION['code']->post_category == 'shipping') {
				$shipping = 0;
				$shippingtotal = 0;
			} else {
				$data = new Database();
				$where = 'post_type = "shipping" AND post_id = '.$_SESSION['shipping'];
				$count  =  $data->select(" * ", " post ", $where);
				$ship = $data->getObjectResults();	
				$shippingtotal = $ship->post_content*VAT+$ship->post_content;
			}
		}


		$total = carttotal(0);

		if ( DISCOUNTCODE == 1 ) {
			if (isset($_SESSION['code']) AND $_SESSION['code']->post_category == 'value') {
				$total = $total - $_SESSION['code']->post_content;
			}
			if (isset($_SESSION['code']) AND $_SESSION['code']->post_category == 'percent') {
				$total = $total - $total * $_SESSION['code']->post_content/100;
			}
		}

		if ( isset($_POST['billingsame'] ) AND $_POST['billingsame'] == 1 ) {
			$bill_name = $name;
			$bill_lastname = $lastname;
			$bill_email = $email;
			$bill_phone = $phone;
			$bill_address = $address;
			$bill_city = $city;
			$bill_county = $county;
			$bill_cp = $cp;
		}


		$data = new Database();
		$arr = array(
			'or_cart' => json_encode($_SESSION['cart']),
			'or_date' => date('c'),

			'or_name' => $name,
			'or_lastname' => $lastname,
			'or_email' => $email,
			'or_phone' => $phone,
			'or_address' => $address,
			'or_city' => $city,
			'or_county' => $county,
			'or_cp' => $cp,			
			'or_country' => 'GB',

			'or_gift' => $gift,			



			'or_bill_name' => $bill_name,
			'or_bill_lastname' => $bill_lastname,
			'or_bill_email' => $bill_email,
			'or_bill_phone' => $bill_phone,
			'or_bill_address' => $bill_address,
			'or_bill_city' => $bill_city,
			'or_bill_county' => $bill_county,
			'or_bill_cp' => $bill_cp,			
			'or_bill_country' => 'GB',



			'or_notes' => $notes,
			'or_addnotes' => $additional_notes,
			
			'or_confirm' => 0,
			'or_total' => number_format($total,2,'.',''),
			'or_country' => 'GB',
						
			
		);

		

		if ( isset($_SESSION['id']) ) {
			$arr['or_user'] = $_SESSION['id'];
		}


		if ( SHIPPING == 1 ) {
			$arr['or_shipping'] = $_SESSION['shipping'];
			$arr['or_shippingtotal'] = $shippingtotal;
		}

		if ( DISCOUNTCODE == 1 ) {
			$arr['or_code'] = json_encode($_SESSION['code']);
		}

		
		
		
		$count  =  $data->insert(" orders ", $arr);
		$id = $data->lastid();

	
		$_SESSION['orderid'] = $id;
		header('Location: '.SITEURL.'checkout/step2/');
		exit;
	}
	
}


include('includes/header.php');
$title = 'Checkout';
include('includes/defaultheader.inc.php');
?>


<?php if ( get_option('shopmessage') ) {?>
<div class="shopmessage">
	<div class="row">
		<div class="columns medium-12">
			<?php echo get_option('shopmessage');?>
		</div>
	</div>
</div>
<?php } ?>


<div class="pagecontent">
	
	<div class="row">

		<div class="columns large-8 large-offset-2  end ">

		
			<?php 
			if (isset($_GET['msg']) AND $_GET['msg'] == 1)  {?>
			<div data-alert class="alert-box warning alert">
				You need to select a shipping method.
				<a href="#" class="close">&times;</a>
			</div>
			<?php } ?>
						
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
			
			<form action="" class="custom" data-abide  id='checkoutform' method='POST'>
				
				<div class="row">
					<div class="columns medium-12">
						<h3>Shipping Information</h3>	
					</div>
					

					<?php
					if (!isset($_SESSION['id'])) {?>
					
					<div class="large-6 columns">
						<div class="field">
							<label for="">First Name</label>
							<input type="text" name='name' required  value="<?php if ( isset($_SESSION['checkoutpost']) ) echo $_SESSION['checkoutpost']['name'];?>">
						</div>
					</div>

					<div class="large-6 columns">
						<div class="field">
							<label for="">Last Name</label>
							<input type="text" name='lastname' required  value="<?php if ( isset($_SESSION['checkoutpost']) ) echo $_SESSION['checkoutpost']['lastname'];?>">
						</div>
					</div>

					<div class="large-6 columns">
						<div class="field">
							<label for="">Email</label>
							<input type="email" name='email' required  value="<?php if ( isset($_SESSION['checkoutpost']) ) echo $_SESSION['checkoutpost']['email'];?>">
						</div>
					</div>
					
					<div class="clear"></div>

					
					<?php } else {?>

					<?php
					$data = new Database();
					$where = 'us_id = '.$_SESSION['id'];
					$count  =  $data->select(" * ", " site_users ", $where);
					$u = $data->getObjectResults();
					
					if ( isset($_SESSION['checkoutpost']) ) {
						$u->us_phone = $_SESSION['checkoutpost']['phone'];
						$u->us_address = $_SESSION['checkoutpost']['address'];
						$u->us_city = $_SESSION['checkoutpost']['city'];
						$u->us_county = $_SESSION['checkoutpost']['county'];
						$u->us_postcode = $_SESSION['checkoutpost']['cp'];
					}
					?>

					<?php } 

					if ( !isset($u) ) $u = new stdClass();
					if ( isset($_SESSION['checkoutpost']) ) {
						$u->us_phone = $_SESSION['checkoutpost']['phone'];
						$u->us_address = $_SESSION['checkoutpost']['address'];
						$u->us_city = $_SESSION['checkoutpost']['city'];
						$u->us_county = $_SESSION['checkoutpost']['county'];
						$u->us_postcode = $_SESSION['checkoutpost']['cp'];
					}
					?>

					<div class="medium-6 columns">
						<div class="field">
							<label for="">Phone</label>
							<input type="text" name='phone' required value='<?php if (isset($u)) echo $u->us_phone;?>' maxlength='15'>
						</div>
					</div>

					<div class="medium-6 columns">
						<div class="field">
							<label for="">Address</label>
							<input type="text" name='address' required value='<?php if (isset($u)) echo $u->us_address;?>'maxlength='30'  >
						</div>
					</div>

					

					

					<div class="medium-6 columns">
						<div class="field">
							<label for="">City</label>
							<input type="text" name='city' required value='<?php if (isset($u)) echo $u->us_city;?>' maxlength='30'>
						</div>
					</div>

					<div class="medium-6 columns">
						<div class="field">
							<label for="">County</label>
							<input type="text" name='county' required value='<?php if (isset($u)) echo $u->us_county;?>' maxlength='20'>
						</div>
					</div>

					<div class="medium-6 columns">
						<div class="field">
							<label for="">Postcode</label>
							<input type="text" name='cp' readonly value='<?php if (isset($_SESSION['shippingpostcode'])) echo $_SESSION['shippingpostcode'];?>' maxlength='10' >
						</div>
					</div>


					<div class="medium-12 columns">
						<div class="field">
							<label for="">Gift message</label>
							<input type="text" name='gift'  value='' >
						</div>
					</div>





















					

					<div class="medium-12 columns">
						<hr>
						<h3>Billing Information</h3>
						<div class="field">
							<label for="">Same as shipping</label>
							<input type="checkbox" name='billingsame' checked value='1'>
						</div>
					</div>

					<div class="billinginfo" style='display: none'>


					<?php
					if (!isset($_SESSION['id'])) {?>
					
					<div class="large-6 columns">
						<div class="field">
							<label for="">First Name</label>
							<input type="text" name='bill_name' required  value="<?php if ( isset($_SESSION['checkoutpost']) ) echo $_SESSION['checkoutpost']['bill_name'];?>">
						</div>
					</div>

					<div class="large-6 columns">
						<div class="field">
							<label for="">Last Name</label>
							<input type="text" name='bill_lastname' required  value="<?php if ( isset($_SESSION['checkoutpost']) ) echo $_SESSION['checkoutpost']['bill_lastname'];?>">
						</div>
					</div>

					<div class="large-6 columns">
						<div class="field">
							<label for="">Email</label>
							<input type="email" name='bill_email' required  value="<?php if ( isset($_SESSION['checkoutpost']) ) echo $_SESSION['checkoutpost']['bill_email'];?>">
						</div>
					</div>
					
					<div class="clear"></div>

					
					<?php } else {?>

					<?php
					$data = new Database();
					$where = 'us_id = '.$_SESSION['id'];
					$count  =  $data->select(" * ", " site_users ", $where);
					$u = $data->getObjectResults();
					
					if ( isset($_SESSION['checkoutpost']) ) {
						$u->us_phone = $_SESSION['checkoutpost']['phone'];
						$u->us_address = $_SESSION['checkoutpost']['address'];
						$u->us_city = $_SESSION['checkoutpost']['city'];
						$u->us_county = $_SESSION['checkoutpost']['county'];
						$u->us_postcode = $_SESSION['checkoutpost']['cp'];
					}
					?>

					<?php } 

					if ( !isset($u) ) $u = new stdClass();
					if ( isset($_SESSION['checkoutpost']) ) {
						$u->us_phone = $_SESSION['checkoutpost']['phone'];
						$u->us_address = $_SESSION['checkoutpost']['address'];
						$u->us_city = $_SESSION['checkoutpost']['city'];
						$u->us_county = $_SESSION['checkoutpost']['county'];
						$u->us_postcode = $_SESSION['checkoutpost']['cp'];
					}
					?>

					<div class="medium-6 columns">
						<div class="field">
							<label for="">Phone</label>
							<input type="text" name='bill_phone' required value='<?php if (isset($u)) echo $u->us_phone;?>' maxlength='15'>
						</div>
					</div>

					<div class="medium-6 columns">
						<div class="field">
							<label for="">Address</label>
							<input type="text" name='bill_address' required value='<?php if (isset($u)) echo $u->us_address;?>'maxlength='30'  >
						</div>
					</div>

					

					

					<div class="medium-6 columns">
						<div class="field">
							<label for="">City</label>
							<input type="text" name='bill_city' required value='<?php if (isset($u)) echo $u->us_city;?>' maxlength='30'>
						</div>
					</div>

					<div class="medium-6 columns">
						<div class="field">
							<label for="">County</label>
							<input type="text" name='bill_county' required value='<?php if (isset($u)) echo $u->us_county;?>' maxlength='20'>
						</div>
					</div>

					<div class="medium-6 columns">
						<div class="field">
							<label for="">Postcode</label>
							<input type="text" name='bill_cp' value='' required maxlength='10' >
						</div>
					</div>

					</div>


















					<div class="medium-12 columns">
						<hr>
						<h3>Delivery notes</h3>
						<div class="field">
							<label for="">Special instructions (ie: leave it in the shed)</label>
							<textarea name="notes" id="" cols="30" rows="3" class="text"><?php if ( isset($_SESSION['checkoutpost']) ) echo $_SESSION['checkoutpost']['notes'];?></textarea>
						</div>
					</div>

					<div class="medium-12 columns">
						<div class="field">
							<label for="">Additional comments</label>
							<textarea name="additional_notes" id="" cols="30" rows="3" class="text"><?php if ( isset($_SESSION['checkoutpost']) ) echo $_SESSION['checkoutpost']['notes'];?></textarea>
						</div>
					</div>
					
				
				
				</div><!--  row  -->


				<hr>

				<h4>Order Total: &pound;<strong id="total"><?php echo number_format(carttotal(0),2,'.','');?></strong></h4>

				<hr>

				<?php
				$weight = 0;
				$hascoupon = 0;
				foreach ($_SESSION['cart'] as $k => $c) {
					$data = new Database();
					$where = 'prod_id = '.$k;
					$count  =  $data->select(" * ", " products ", $where);
					$product = $data->getObjectResults();

					$weight += $product->prod_weight;


					$data = new Database();
					$where = 'prod_id = '.$product->prod_parent;
					$count  =  $data->select(" * ", " products ", $where);
					$par = $data->getObjectResults();

					if ( $par->prod_id == 175 ) { //175 is the coupon product
						$hascoupon = 1;
					}
				}
				
				?>
				
				
				<?php
				if ( SHIPPING == 1 ) {
				if (isset($_SESSION['code']) AND $_SESSION['code']->post_category == 'shipping') {?>
					<h3>Free Shipping</h3> <hr>
				<?php } else { 
			
					$data = new Database();
					$where = ' post_type = "shipping" AND post_id = '.$_SESSION['shipping'];
					$count  =  $data->select(" * ", " post ", $where);
					$ship = $data->getObjectResults();
					
					echo '<h4>Shipping: '.$ship->post_title.'<strong>';
					if ($ship->post_content) echo ' - &pound;'. $ship->post_content.'</strong></h4>';
					echo '<hr>';
				} 
				}?>

				


				<?php 
				if ( DISCOUNTCODE == 1 ) {
				if (isset($_SESSION['code'])) {?>
				<h4>
					Active Code: <strong><?php echo $_SESSION['code']->post_title; ?>
                            <?php if ($_SESSION['code']->post_category == 'value') echo '- $'.$_SESSION['code']->post_content; ?>
                            <?php if ($_SESSION['code']->post_category == 'percent') echo $_SESSION['code']->post_content.'% OFF'; ?>
                            <?php if ($_SESSION['code']->post_category == 'shipping') { echo 'FREE SHIPPING!'; $_SESSION['postage'] = 0; $defaultshipping = 0; }?>
				</h4>
				<hr>
				<?php 
				}
				}
				?>

				
				<?php
				$total = carttotal(0);

				if ( DISCOUNTCODE == 1 ) {
					if (isset($_SESSION['code']) AND $_SESSION['code']->post_category == 'value') {
				      $total = $total - $_SESSION['code']->post_content;
				    }
				    if (isset($_SESSION['code']) AND $_SESSION['code']->post_category == 'percent') {
				      $total = $total - $total * $_SESSION['code']->post_content/100;
				    }
				}

				$total += $ship->post_content;

			    
			    ?> 








				



				<?php  if ( $hascoupon == 1 ) {?>
			
				<div data-alert class="alert-box">
				  
				  <label for="hardcopy">
				  <input type="checkbox" name='hardcopy' id='hardcopy'>
				  	Please send me a hard copy of the coupons.
				  </label>
				  <a href="#" class="close">&times;</a>
				</div>
				<?php }  ?>














			    <input type="hidden" value='<?php echo number_format($total,2);?>' id='ordertotal'>

				



				<div class="text-center">
					<h2>Total: &pound;<strong id="grandtotal"><?php echo number_format($total,2);?></strong></h2>
					<button class='large'><span>Buy</span></button>
				</div>
				
				
				<input type="hidden" value='order' name='action'>
				
			</form>
			
		</div>
	</div>



</div>


<script type="text/javascript">
$(document).ready(function () {

$('#checkoutform').on('invalid.fndtn.abide', function () {
    swal('Please complete the required fields marked in red');
});	

$('[name="billingsame"]').change(function () {
	if ( $(this).is(':checked') ){
		$('.billinginfo').slideUp();
	} else {
		$('.billinginfo').slideDown();
	}
});

});
</script>
	
	
	
<?php 
unset($_SESSION['checkoutpost']);
include('includes/footer.php');?>
