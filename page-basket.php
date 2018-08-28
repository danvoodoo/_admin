<?php
//$_GET['debug'] = 1;
include_once('admin/includes/init.php'); 

session_name(SESSIONNAME);
if (!isset($_SESSION)) session_start();
if (isset($_GET['clear'])) {
	$_SESSION['cart'] = array();
}

if (isset($_POST['action']) AND $_POST['action'] == 'discountcode') {
    foreach($_POST as $nombre_campo => $valor){ if (!is_array($valor)) $asignacion = "\$" . $nombre_campo . "='" . addslashes(htmlspecialchars($valor)) . "';"; eval($asignacion); }//end foreach
    $data = new Database();
    $where = 'post_title = "'.$code.'" AND post_state = 1 AND post_type = "coupon"';
    $count  =  $data->select(" * ", " post ", $where);
    $r = $data->getObjectResults();

    if ( $r->post_excerpt > 0 AND $r->post_excerpt > carttotal() ){
    	$count = 0;
    }
    if ($count>0) {
        $_SESSION['code'] = $r;
    } else {
        $codeerror = 1;
    }
}

if (isset($_POST['action']) AND $_POST['action'] == 'updatecart') {
	foreach ($_POST['q'] as $key => $value) {
		$_SESSION['cart'][$key]['q'] = $value;
	}
	
	$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
	$url =  $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	header('Location: '.$url);
	exit;
}


$bodyclass='';
include('includes/header.php');

$title = 'Basket';
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



<div class="pagecontent cart">	
	<div class="row">
		<div class="columns medium-12">
			<?php
			if (isset($_GET['clear']) ) {?>
				<div data-alert class="alert-box success">
				  Your basket has been cleared.
				</div>
			<?php }

			if (isset($_POST['action']) AND $_POST['action'] == 'updatecart') { ?>
				<div data-alert class="alert-box success">
				  Your basket has been updated.
				</div>
			<?php } ?>
		</div>
		<div class="columns medium-12 ">
		<form action="" method='post'>
			<input type="hidden" name='action' value='updatecart' >

			<?php if ( count($_SESSION['cart'] ) >0 ) {?>
			<table class=''>
				<thead>
					<tr>
						<th>Image</th>
						<th>Product</th>
						<th>Price</th>
						<?php if ( VAT > 0 ) {?>
						<th>VAT</th>
						<?php } ?>
						<th>Subtotal</th>
						<th>Quantity</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					
				
			<?php
			$total = 0;
			
			foreach ($_SESSION['cart'] as $k => $c) {
				$data = new Database();
				$where = 'prod_id = '.$k;
				$count  =  $data->select(" * ", " products ", $where);
				$product = $data->getObjectResults();

				$data = new Database();
				$where = 'prod_id = '.$product->prod_parent;
				$count  =  $data->select(" * ", " products ", $where);
				$par = $data->getObjectResults();

				
				$subtotal = $c['q'] * ($product->prod_price + $product->prod_price * VAT);
				
				?>
				<tr>
					<td class='figurecol'>
						<?php if ( $par->prod_photo ) {?>
						<figure>
						<img src="photos/200_200_<?php echo $par->prod_photo;?>" alt="">		
						</figure>
						<?php } ?>
					</td>
					<td>
						<h4>
							<?php echo $par->prod_title;?>
						</h4>
						<?php /*
						<h5><?php echo $product->prod_title;?></h5>
						*/ ?>
					</td>
					<td class="iprice">
						&pound;<?php echo number_format($product->prod_price,2);?>	
					</td>
					<?php if ( VAT > 0 ) {?>
					<td class="iprice">
						&pound;<?php echo number_format($product->prod_price * VAT,2);?>	
					</td>
					<?php } ?>
					<td class="fprice">
						&pound;<?php echo number_format($subtotal,2);?>	
					</td>
					<td class="qua">
						<input type="number" min='0'  name='q[<?php echo $k;?>]' value='<?php echo $c['q'];?>' <?php if ( MANAGESTOCK ) {?>max='<?php echo $product->prod_stock; ?>'<?php } ?>>
					</td>
					<td class="del">
						<a href="#" class="button tiny delete" data-id='<?php echo $k;?>'><span>X</span></a>
					</td>
				</tr>
				
				
				
				

				

				

				

			<?php } ?>
		

			</tbody>
			<tfoot>
				<?php if ( SHIPPING == 1 ) {?>
				<tr>
					<td colspan="4"></td>
					<td class="totalcol"><h3>Subtotal</h3></td>
					
					<td class="totalcol"><h3>&pound;<span id=""><?php echo number_format(carttotal(),2);?></span></h3>	</td>
					
				</tr>

				
				<tr class='distance'>
					<td colspan="1">
						
					</td>
					<td colspan="2">
						<h4>Enter delivery postcode</h4>
					</td>
					<td>
						<div class="row collapse">
							<div class="columns small-8">
								<input type="text" name='postcode' value='<?php if (isset($_SESSION['shippingpostcode'])) echo $_SESSION['shippingpostcode'];?>' placeholder='Enter your postcode' style='width: 100%; background: #fff;'>		
							</div>
							<div class="columns small-4">
								<a href="#" class="button tiny expand" style='width: auto; padding: 0 10px;'>Calculate</a>
							</div>
						</div>
						
					</td>
					
					<td colspan="2">
						<select name="shipping" id="shipping">
						<option value=""></option>
						</select>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="4"></td>
					<td class="totalcol"><h3>Total</h3></td>



					
					<td class="totalcol">
						<?php
						$total = $oldtotal = carttotal(0);

						if ( DISCOUNTCODE == 1 ) {
							if (isset($_SESSION['code']) AND $_SESSION['code']->post_category == 'value') {
						      $total = $total - $_SESSION['code']->post_content;
						    }
						    if (isset($_SESSION['code']) AND $_SESSION['code']->post_category == 'percent') {
						      $total = $total - $total * $_SESSION['code']->post_content/100;
						    }
						}
						if ( $oldtotal != $total ) {?>

						<h5 style='text-decoration: line-through;'>&pound;<?php echo number_format( $oldtotal ,2); ?></h5>
						<?php } ?>
						<h3>&pound;<span id="carttotal"><?php echo number_format($total,2);?></span></h3>	
					</td>
					
				</tr>
			</tfoot>
			</table>
			<?php } ?>





			

			<?php 
			
			if ( count($_SESSION['cart'] ) == 0 ) {?>
			<p class="text-center">Your basket is empty</p>
			<?php } ?>

			<?php if ( count($_SESSION['cart'] ) > 0 ) {?>
				<div class="row">
					<div class="columns medium-6 hide-for-small-only">
						<a href="basket/?clear=1" class="button "><i class="fa fa-times" aria-hidden="true"></i><span>Clear Basket</span></a>
						<a href="shop/" class="button">Continue Shopping</a>
					</div>
					<div class="columns medium-6 text-right">

						<a href="basket/?clear=1" class="button   show-for-small-only"><i class="fa fa-times" aria-hidden="true"></i><span>Clear Basket</span></a>

						<button class=''><i class="fa fa-refresh" aria-hidden="true"></i><span>Update</span></button>	
						<a href="checkout/" class="button <?php if ( SHIPPING == 1 ) echo 'disabled';?> " id='checkoutbutton'><span>Checkout</span></a>
						
					</div>
				
				</form>

				<?php 
				if ( DISCOUNTCODE == 1 ) {
					?>
				<div class="columns medium-8 medium-offset-2 end">
					<hr>
				<div class="panel coupon">
					<form action="basket/" method='post'>
			 		
	                        <div class="row">
	                        	<div class="columns medium-4">
	                        		<h4>Discount Code</h4>
	                        	</div>
	                            <div class="columns medium-4">
	                                <input type="text" name='code'>        
	                            </div>
	                            <div class="columns medium-4">
	                                <button class='medium expand'>Apply</button>
	                                <input type="hidden" value='discountcode' name='action'>
	                            </div>
	                           </div>
	                        
	        		</form>

	        		<?php
	                    if (isset($codeerror)) {?>
	                        <div data-alert class="alert-box alert">This discount code could not be applied</div>
	                    <?php } 
	                    if (isset($_SESSION['code'])) {?>
	                        <div data-alert class="alert-box success ">
	                            Active Code: <strong><?php echo $_SESSION['code']->post_title; ?></strong> 
	                            <div class="code">
	                            <?php if ($_SESSION['code']->post_category == 'value') echo '- &pound;'.$_SESSION['code']->post_content; ?>
	                            <?php if ($_SESSION['code']->post_category == 'percent') echo $_SESSION['code']->post_content.'% OFF'; ?>
	                            <?php if ($_SESSION['code']->post_category == 'shipping') { echo 'FREE SHIPPING!'; $_SESSION['postage'] = 0; $defaultshipping = 0; }?>
	                            </div>
	                        </div>
	                <?php } ?>
				</div>	
				</div>
				<?php } ?>

			</div>			
					
			<?php }  ?>

			<?php /*
			<!-- Optional classes: [success alert secondary] [radius round] -->
			<div data-alert class="alert-box alert">
			  We are currently working for putting our store online. <br>
			  Sorry for the inconvenience
			</div>
			*/ ?>

		
		</div>
	</div>



</div>



<script>
$(document).ready(function () {

$('.delete').click(function(e) {
	var t = this;
	$.post(ajaxurl, 
		{ 
	      	action: "deletecartitem" ,
	      	key: $(this).data('id')
	    },
	    function(data){
	       	window.location.reload();
	 	}
	);
	e.preventDefault();
});


$('body').on('click','a.disabled',function(event) {
	event.preventDefault();
});

carttotal = <?php echo $total;?>;


$('.distance .button').click(function(e) {
	if ( $('input[name="postcode"]').val() != '' ) {
	  	$.post(ajaxurl, 
		    { 
		      	action: "getshipping" ,
		      	postcode: $('input[name="postcode"]').val()
		    },
		    function(data){
		       	console.log(data);     
		       	if ( data == '' ) {
					 swal({   
	                    title: "<?php echo get_option('noshippingmessage');?>",     
	                    type: "error",   
	                    showCancelButton: false,   
	                    closeOnConfirm: false,   
	                    showLoaderOnConfirm: true, 
	                    cancelButtonText: 'Close'
	                });
					$('#checkoutbutton').addClass('disabled');
					$('#shipping').html('');
				} else {
					$('#checkoutbutton').removeClass('disabled');
					$('#shipping').html(data);
					//$('#shipping option[value!=""]:eq(0)').attr('selected', 'selected');
					$('#shipping').change();
				}
		   }
		);
	} else {
	  	alert('You need to input your postcode');
	}
	e.preventDefault();
});


$('#shipping').change(function () {
	if ( $('#shipping').val() > -1 ) {
		val = parseFloat($('#shipping option:selected').data('val'));	
		$('#checkoutbutton').removeClass('disabled');
		$.post(ajaxurl, 
		    { 
		      	action: "setshippingoption" ,
		      	shipping: $('#shipping').val()
		    },
		    function(data){
		        console.log(data);
		    }
		);
	} else {
		val = 0;
		$('#checkoutbutton').addClass('disabled');
		$.post(ajaxurl, 
		    { 
		      	action: "setshippingoption" ,
		      	postcode: $('#shipping').val()
		    },
		    function(data){
		        console.log(data);
		    }
		);
	}	
	$('#carttotal').html( (carttotal + val).toFixed(2) );
});


<?php if (isset($_SESSION['shippingpostcode'])) {?>
$('.distance .button').click();
<?php } ?>

});
</script>
<?php include('includes/footer.php');?>