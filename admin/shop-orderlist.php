<?php 
include("includes/init.php");

// check if theres a very recent order, and if so, send an audio alert

$data = new Database();

/*

$where = '  DATE_ADD(or_date, INTERVAL 10 MINUTE) >= NOW() AND or_confirm = 1 AND or_status ="" ';
$count  =  $data->select(" * ", " orders ", $where,'or_id ASC');
while($r = $data->getObjectResults()){

*/


$where = '  DATE_ADD(or_date, INTERVAL 1440 MINUTE) >= NOW()  AND or_status ="" AND or_confirm = 1';
$count  =  $data->select(" * ", " orders ", $where,'or_id ASC');
$orders = array();
while($r = $data->getObjectResults()){

if ($r->or_date) $alert = 1;
}
$refresh = 1;
include('includes/header.php');

?>
    
<div class="content">	
<div class="inner">

<h2>New Unprocessed Orders (within 1 day)</h2>

<style>
	.listtable.undelivered thead th{
		background: #f3ac00;
	}
	.listtable thead th{
		background: #8861b9;
	}
	.listtable .button{
		font-size: 14px;
	}
	h3.today{
		background: #e04848;
		margin-bottom: -1px;
		padding: 10px;
		color: #fff;
		position: relative;
	}
	h3.tomorrow{
		background: #8861b9;
		margin-bottom: -1px;
		padding: 10px;
		color: #fff;
		position: relative;
	}
</style>

<table class='listtable'>
		<thead>
			<th style="width: 10%">
				ID
			</th>
			<th style="width: 20%">
				Name
			</th>
			<th style="width: 15%">
				Amount
			</th>
			<th style="width: 20%">
				Address
			</th>
			<th style="width: 15%">
				Postcode
			</th>
			<th style="width: 10%">
			</th>
		</thead>
		<tbody>
<?php
$data = new Database();
$where = '  DATE_ADD(or_date, INTERVAL 1440 MINUTE) >= NOW()  AND or_status ="" AND or_confirm = 1';
$count  =  $data->select(" * ", " orders ", $where,'or_id ASC');
$orders = array();
while($r = $data->getObjectResults()){
	$r->or_deliverydate = str_replace('/', '-', $r->or_deliverydate);
	if ( !isset( $orders[ date('Y-m-d', strtotime($r->or_deliverydate)) ] ) ) $orders[ date('Y-m-d', strtotime($r->or_deliverydate)) ] = array();

	$orders[ date('Y-m-d', strtotime($r->or_deliverydate)) ][] = $r;
		?>
		<tr>
				<td>
					<?php echo $r->or_id;?>
				</td>
				<td>
					<?php echo $r->or_name;?> <?php echo $r->or_lastname;?>
				</td>
				<td>
					&pound;<?php echo $r->or_total;?>
				</td>
				<td>
					<?php echo $r->or_address;?>
				</td>
				<td>
					<?php echo $r->or_cp;?>
				</td>
				<td>
					<a href="orders.php?id=<?php echo $r->or_id;?>" class="button small">View order</a>
				</td>
			</tr>
			<?php
}
ksort($orders);
//print_r($orders);
?>
	</tbody>
			
	</table>
	<hr>


<h2>Undelivered Orders</h2>



<table class='listtable undelivered'>
		<thead>
			<th style="width: 10%">
				ID
			</th>
			<th style="width: 20%">
				Name
			</th>
			<th style="width: 15%">
				Amount
			</th>
			<th style="width: 20%">
				Address
			</th>
			<th style="width: 15%">
				Postcode
			</th>
			<th style="width: 10%">
			</th>
		</thead>
		<tbody>
<?php
$data = new Database();
$where = 'or_status != "delivered" AND or_deliverydate > "'.date('m/d/Y').'" AND or_confirm = 1';
$count  =  $data->select(" * ", " orders ", $where,'or_id ASC');
$orders = array();
while($r = $data->getObjectResults()){
	$r->or_deliverydate = str_replace('/', '-', $r->or_deliverydate);
	if ( !isset( $orders[ date('Y-m-d', strtotime($r->or_deliverydate)) ] ) ) $orders[ date('Y-m-d', strtotime($r->or_deliverydate)) ] = array();

	$orders[ date('Y-m-d', strtotime($r->or_deliverydate)) ][] = $r;
		?>
		<tr>
				<td>
					<?php echo $r->or_id;?>
				</td>
				<td>
					<?php echo $r->or_name;?> <?php echo $r->or_lastname;?>
				</td>
				<td>
					&pound;<?php echo $r->or_total;?>
				</td>
				<td>
					<?php echo $r->or_address;?>
				</td>
				<td>
					<?php echo $r->or_cp;?>
				</td>
				<td>
					<a href="orders.php?id=<?php echo $r->or_id;?>" class="button small">View order</a>
				</td>
			</tr>
			<?php
}
ksort($orders);
//print_r($orders);
?>
	</tbody>
			
	</table>
	<hr>

<?php

foreach ($orders as $date => $items) {
	?>
	<h3 class="<?php if ( date('d/m/Y',strtotime($date)) == date('d/m/Y') ) echo 'today'; ?> <?php if ( date('d/m/Y',strtotime($date)) == date('d/m/Y', strtotime('+1 day')) ) echo 'tomorrow'; ?>">
		<?php if ( date('d/m/Y',strtotime($date)) == date('d/m/Y') ) echo '<strong>Today</strong>'; ?>
		<?php if ( date('d/m/Y',strtotime($date)) == date('d/m/Y', strtotime('+1 day')) ) echo '<strong>Tomorrow</strong>'; ?>
		<?php echo date('d/m/Y',strtotime($date)); ?>
	</h3>

	<table class='listtable'>
		<thead>
			<th style="width: 10%">
				ID
			</th>
			<th style="width: 20%">
				Name
			</th>
			<th style="width: 15%">
				Amount
			</th>
			<th style="width: 20%">
				Address
			</th>
			<th style="width: 15%">
				Postcode
			</th>
			<th style="width: 10%">
			</th>
		</thead>
		<tbody>
		<?php
		foreach ($items as $r) { ?>
			<tr>
				<td>
					<?php echo $r->or_id;?>
				</td>
				<td>
					<?php echo $r->or_name;?> <?php echo $r->or_lastname;?>
				</td>
				<td>
					&pound;<?php echo $r->or_total;?>
				</td>
				<td>
					<?php echo $r->or_address;?>
				</td>
				<td>
					<?php echo $r->or_cp;?>
				</td>
				<td>
					<a href="orders.php?id=<?php echo $r->or_id;?>" class="button tiny">View order</a>
				</td>
			</tr>
		<?php } ?>
		</tbody>
			
	</table>
<?php
}
?>




</div>
</div><!--fin content-->


<script type="text/javascript">
$(document).ready(function () {

setTimeout(function () {
    window.location.reload();
},120000);

$('#shop').addClass('expanded active');
				$('#shop').removeClass('closed');
				$('ul','#shop').show();
				
});
</script>

   <?php include('includes/footer.php');?>

	