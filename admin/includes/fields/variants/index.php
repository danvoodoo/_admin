<?php 
function prodvariant( $rr ) {
	global $a;
	?>
	<div class="panel">
		<div class="row">
			<div class="columns medium-4">
				<label for="">Title</label>
				<input type="text" name="products[<?php echo $a; ?>][title]" value='<?php if (isset($rr->prod_title)) echo $rr->prod_title;?>'>
			</div>
			<div class="columns medium-1">
				<label for="">Price</label>
				<input type="text" name="products[<?php echo $a; ?>][price]" value='<?php if (isset($rr->prod_price)) echo $rr->prod_price;?>'>
			</div>
			<div class="columns medium-1">
				<label for="">SKU</label>
				<input type="text" name="products[<?php echo $a; ?>][code]" value='<?php if (isset($rr->prod_code)) echo $rr->prod_code;?>'>
			</div>
			<div class="columns medium-1">
				<label for="">Order</label>
				<input type="text" name="products[<?php echo $a; ?>][order]" value='<?php if (isset($rr->prod_order)) echo $rr->prod_order;?>'>
			</div>
			<div class="columns medium-2">
				<label for="">Stock</label>
				<input type="number" name="products[<?php echo $a; ?>][stock]" value='<?php if (isset($rr->prod_stock)) echo $rr->prod_stock;?>' min='0'>
			</div>
			<div class="columns medium-2">
				<?php
				imageupload(array(
					'name' => 'products['.$a.'][photo]',
					'label' => 'Image',
					'size' => '200_200',
					'value' => $rr->prod_photo
					));
				?>
			</div>
			<div class="columns medium-1">
				<label for="">&nbsp;</label>
				<a href="#" class="remove button tiny expand alert">X</a>
			</div>
			
			<?php 
			if ( isset($rr->prod_id) ) {?>
			<input type="hidden" name="products[<?php echo $a; ?>][type]" value='update' class='type'>
			<input type="hidden" name="products[<?php echo $a; ?>][id]" value='<?php echo $rr->prod_id;?>' >
			<?php } else { ?>
			<input type="hidden" name="products[<?php echo $a; ?>][type]" value='new' class='type'>
			<?php } ?>
		</div>
	</div>
<?php } ?>

<div class="columns medium-12">
	<hr>
	<h2>Variant</h2>

	<div id="variants">

	<?php
	$data2 = new Database();
	if ( isset( $_GET['id'] ) ) {
		$where = 'prod_parent = '.$_GET['id'];
		$count  =  $data2->select(" * ", " products ", $where,'prod_order DESC');
	} else {
		$count = 0;
	}

	global $a;
	if ( $count > 0 ) {
		$a = -1 ;
		while($rr = $data2->getObjectResults()){ $a++; 

			prodvariant( $rr );
		}
	} else {
		prodvariant();
	}
	?>

	

	</div>

	<a href="#" class="button addvariante">Add Variant</a>

	<p>
		<strong>Order:</strong> Bigger numbers go first
	</p>

</div>
<hr>

<script type="text/javascript">
$(document).ready(function () {

$('#variants').on('click', '.remove', function (e) {
	var p = $(this).closest('.panel');
	$('.type',p).val('remove');
	$(p).slideUp();
	e.preventDefault();
});

$('.addvariante').click(function (e) {
	var c = $('#variants .panel:last-child').clone();

	$('input,textarea',c).each(function() {
		var name = $(this).attr('name');
		var index = name.split('products[').pop().split('][').shift();
		newindex = parseInt(index) + 1;
		name = name.replace('products['+index+']', 'products['+newindex+']');
		$(this).attr('name',name);

		if ( $(this).hasClass('type') ) $(this).val('new');
	});

	$('#variants').append(c);
	e.preventDefault();

});

});
</script>
<style>
#variants .image .button.tiny{
	padding: 5px;
	font-size: 14px;
	height: 25px;
}
#variants .field.image .button.editimage{ right: 26px }
#variants .field.image .button.upload{ right: 51px }
#variants .field.image .button.deleteimage{ right: 75px }
</style>