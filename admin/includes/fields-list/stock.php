<td>
	<p>
	<?php
	$data2 = new Database();
	$where = 'prod_parent = '.$r['prod_id'];
	$count  =  $data2->select(" * ", " products ", $where,'prod_order DESC');
	while($rr = $data2->getObjectResults()){
	?>
	<span  class='stock '><?php echo $rr->prod_title;?> - <span class='<?php if ($rr->prod_stock<LOWSTOCKWARNING) echo 'lowstock';?>'>Stock: <?php echo $rr->prod_stock;?></span></span>
	<br>
	<?php } ?> 
	</p>

</td>
<style>
.stock {
	font-size: 13px;
}
.lowstock{
	font-weight: bold;
	color: #f00;
}
</style>