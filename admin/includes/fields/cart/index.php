<div class="columns medium-12">
<div class="panel">
	<h3>Basket</h3>
	

	<?php 
	$cart = json_decode($r['or_cart'],true);
	
	if ( count( $cart ) >0 ) {?>
			<table class='cart' style='width: 100%;'>
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

				if ( isset($product->prod_price_sale) AND $product->prod_price_sale > 0 ){
	                $product->prod_price = $product->prod_price_sale;
	            }

	            $data = new Database();
	            $where = 'prod_id = '.$product->prod_parent;
	            $count  =  $data->select(" * ", " products ", $where);
	            $par = $data->getObjectResults();


				$subtotal = ($product->prod_price + $product->prod_shipping) *$c['q'];
				$total += $subtotal;
				?>
				<tr>
					<td>
						<img src="../photos/200_200_<?php echo $par->prod_photo;?>" alt="">		
					</td>
					<td>
						<strong>
							<?php echo $par->prod_title;?>
						</strong> <br>
						<span>
							<?php echo $product->prod_title;?>
						</span>
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
				<tr>
					<td>Sub Total</td>
					<td colspan="3"></td>
					
					<td>&pound;<?php echo number_format($r['or_total'],2);?>	</td>
				</tr>
				<tr>
					<?php
					$data = new Database();
					$where = 'post_id = '.$r['or_shipping'];
					$count  =  $data->select(" * ", " post ", $where);
					$ship = $data->getObjectResults();
					?>

					<td colspan="3">Shipping</td>
					<td><?php echo $ship->post_title;?></td>
					<td>&pound;<?php echo number_format($r['or_shippingtotal'],2);?>	</td>
				</tr>

				<tr>
					<td>Total</td>
					<td colspan="3"></td>
					
					<td>&pound;<?php echo number_format($r['or_total']+$r['or_shippingtotal'],2);?>	</td>
				</tr>
			</tfoot>
			</table>
			<?php } ?>
</div>
</div>