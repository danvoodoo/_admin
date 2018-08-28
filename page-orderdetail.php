<?php
$bodyclass='';
include('includes/header.php');

$order = addslashes($_GET['id']);
$data = new Database();
$where = 'or_user = '.$_SESSION['id'].' AND or_id = '.$order;
$count  =  $data->select(" * ", " orders ", $where);
$r = $data->getObjectResults();

$title = 'My Orders';
include('includes/defaultheader.inc.php'); ?>


<div class="pagecontent">
	<div class="row">

		<div class="columns medium-8 medium-offset-2  end ">
			<h2 class='text-center'>Order # <?php echo $r->or_id;?></h2>
			<h5>Date: <?php echo date('d/m/Y', strtotime($r->or_date)) ;?></h5>
			<p>
				Name: <?php echo $r->or_name;?> <?php echo $r->or_lastname;?> <br>
				Email: <?php echo $r->or_email;?> <br>
				Address: <?php echo $r->or_address;?> <br>
				Postcode: <?php echo $r->or_cp;?> <br>
				City: <?php echo $r->or_city;?> <br>
				County: <?php echo $r->or_county;?> 
			</p>	
			<p>
				Notes: <br>
				<?php echo $r->or_notes;?>
			</p>

			<hr>
			<h3>Cart</h3>

			<?php 
			$cart = json_decode($r->or_cart,true);
			
			if ( count( $cart ) >0 ) {?>
					<table class='cart cartdetail' style='width: 100%;'>
						<thead>
							<tr>
								<th>Image</th>
								<th>Product</th>
								<th>Price</th>
								<th>Subtotal</th>
								<th>Quantity</th>
								
							</tr>
						</thead>
						<tbody>
							
						
					<?php
					$total = 0;
					foreach ($cart as $k => $c) {
						$data = new Database();
						$where = 'prod_id = '.$k;
						$count  =  $data->select(" * ", " products ", $where);
						$product = $data->getObjectResults();


						$data = new Database();
			            $where = 'prod_id = '.$product->prod_parent;
			            $count  =  $data->select(" * ", " products ", $where);
			            $par = $data->getObjectResults();



						$subtotal = $product->prod_price*$c['q'];
						$total += $subtotal;
						?>
						<tr>
							<td>
								<img src="photos/200_200_<?php echo $par->prod_photo;?>" alt="">		
							</td>
							<td>
								<span>
									<?php echo $par->prod_title;?>
								</span> <br>
								<strong>
									<?php echo $product->prod_title;?>
								</strong>
							</td>
							<td>
								&pound;<?php echo number_format($product->prod_price,2);?>	
							</td>
							<td>
								&pound;<?php echo number_format($subtotal,2);?>	
							</td>
							<td>
								<?php echo $c['q'];?>
							</td>
						</tr>
					<?php } ?>				

					</tbody>
					<tfoot>
						<?php if ( SHIPPING == 1 ) {?>
						<tr>
							<td>Sub Total</td>
							<td colspan="3"></td>
							
							<td>&pound;<?php echo number_format($r->or_total,2);?>	</td>
						</tr>
						<tr>
							<?php
							$data = new Database();
							$where = 'post_id = '.$r->or_shipping;
							$count  =  $data->select(" * ", " post ", $where);
							$ship = $data->getObjectResults();
							?>

							<td colspan="3">Shipping</td>
							<td><?php echo $ship->post_title;?></td>
							<td>&pound;<?php echo number_format($r->or_shippingtotal,2);?>	</td>
						</tr>
						<?php } ?>
						<tr>
							<td>Total</td>
							<td colspan="3"></td>							
							<td>&pound;<?php echo number_format($r->or_total+$r->or_shippingtotal,2);?>	</td>
						</tr>
					</tfoot>
					</table>
					<?php } ?>
		</div>
	</div>



</div>


<?php include('includes/footer.php');?>
