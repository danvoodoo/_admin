<?php
$bodyclass='';
include('includes/header.php');


$title = 'My Orders';
include('includes/defaultheader.inc.php');
?>

<div class="pagecontent single">
	<div class="row">
		<div class="medium-12 columns text-center">

			<?php
			$data = new Database();
			$where = 'or_user = '.$_SESSION['id'].' AND or_confirm = 1';
			$count  =  $data->select(" * ", " orders ", $where, 'or_id DESC');
			if ($count>0) {?>
			<table class='cart cartdetail'>
				<thead>
				<tr>
					<th>#</th>
					<th>Date</th>
					<th class='text-center'>Total</th>
					<th class='text-center'>Item quantity</th>
					<th></th>
				</tr>
				</thead>
				<tbody>

			<?php
			while($r = $data->getObjectResults()){?>
				<tr>
					<td><?php echo $r->or_id;?></td>
					<td><?php echo date('d/m/Y', strtotime($r->or_date)) ;?></td>
					<td class='text-center'>&pound;<?php echo $r->or_total+$r->or_shippingtotal;?></td>
					<td class='text-center'>
						<?php
						$cart = json_decode($r->or_cart, true);
						echo count($cart);
						?>
					</td>
					<td class="text-right">
						<a href="orderdetail/?id=<?php echo $r->or_id;?>" class="button tiny">View order</a>
					</td>
				</tr>		
			<?php } ?>
				</tbody>

			</table>
			<?php }
			else {?>
			<p class="text-center">You don't have any previous orders on file with this account.</p>
			<?php } ?>
		</div>
	</div>
</div>


<?php include('includes/footer.php');?>
