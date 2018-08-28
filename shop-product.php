<?php
$bodyclass='';
include('includes/header.php');
$page = addslashes($_GET['url']);
$data = new Database();
$where = 'prod_url = "'.$page.'" AND prod_state = 1';
$count  =  $data->select(" * ", " products ", $where);
if ( $count == 0 ){
	include('404.php');
	include('includes/footer.php');
	exit;
}
$r = $data->getObjectResults();
getmetas( $r->prod_id, 'product' );




$cats = json_decode($r->prod_category);
$cats = current($cats);

$page = $cats;
$data = new Database();
$where = 'cat_url = "'.$page.'" AND cat_state = 1';
$count  =  $data->select(" * ", " categories ", $where);
$cat = $data->getObjectResults();


?>


<div class="pageheader small">
	<div class="bg"  style="background-image: url('photos/1600_650_<?php echo $cat->cat_image; ?>')"></div>
	<div class="t">
		<h2>
			<span><span><?php echo $cat->cat_name;?></span></span>
		</h2>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function () {
setTimeout(function () {
	$('.pageheader').addClass('in');	
});
});
</script>


<?php if ( get_option('shopmessage') ) {?>
<div class="shopmessage">
	<div class="row">
		<div class="columns medium-12">
			<?php echo get_option('shopmessage');?>
		</div>
	</div>
</div>
<?php } ?>



<div class="content">

			
			

			


			<div class="row singleproductwor">
				
				<div class="columns medium-7">
					<h2>
						<?php echo $r->prod_title;?>

						<?php
						if ($r->prod_prizes) {
							$p = json_decode($r->prod_prizes);
							$p = current($p);
							foreach ($p->repeater as $pr) {
								?>
								<img data-tooltip src="photos/80_80_<?php echo $pr->image; ?>" title="<?php echo $pr->text; ?>">
								<?php
							}
						}?>
					</h2>	
					<?php echo $r->prod_excerpt;?>	

				</div>

				<div class="columns medium-5 ">
					<div class="addform">
						<div class="vars">
							<?php
							$data = new Database();
							$where = 'prod_parent = '.$r->prod_id.'';
							$count  =  $data->select(" * ", " products ", $where,'prod_order DESC');
							$a = 0;
							while($rr = $data->getObjectResults()){ $a++?>
							<a href="#" class='<?php if ($a == 1 AND $rr->prod_stock > 0) echo 'active'; ?> <?php if ($rr->prod_stock==0) echo 'outofstock';?>' data-id='<?php echo $rr->prod_id; ?>' data-price='<?php echo number_format( $rr->prod_price,2);?>'>
								<span class="c"></span>
								<span class="p">
									&pound;<?php echo number_format( $rr->prod_price,2);?> 
								</span>
								<?php echo $rr->prod_title;?>
								
								<?php if ( $rr->prod_stock == 0 AND MANAGESTOCK) echo '  - Out of stock';?>
								 
							</a>
							<?php } ?>
						</div>
					
						<div class="row collapse">
							<div class="columns medium-5">
								<div class="quantout">
								<label for="" class='l1'>
									Quantity
								</label>
								<label for="" class='l2'>
									Qty
								</label>		
								<input type="number" min='0' value='1' class='quant' id='quant' <?php if ( MANAGESTOCK ) {?>max='<?php echo $rr->prod_stock; ?>'<?php } ?>>
								</div>		
							</div>
							<div class="columns medium-7">
								<a href="#" class="button addtocart expand" data-id='<?php echo $r->prod_id;?>'>
									<i class="fa fa-shopping-basket" aria-hidden="true"></i>
									<span>Add to cart (&pound;<span id="addtotal"></span>)</span>
								</a>		
							</div>
						</div>
					</div>
					
				</div>
			</div>
			
	<div class="row">
		<div class="columns medium-12">
			<div class="prodgallery">
			<ul>
				
					<?php 
					$prod_gallery = json_decode($r->prod_gallery);
					$prod_gallery = current($prod_gallery);
					foreach ($prod_gallery->repeater as $g) {
						?>
						<li>
							<div class="bg"  style="background-image: url('photos/1000_1000_<?php echo $g->image; ?>')"></div>
							<div class="span"><?php echo $g->title; ?></div>
						</li>
					<?php } ?>
				
			</ul>
			</div>
		</div>
	</div>


</div>


<div class="productlist related content">
	<div class="row">
		<div class="columns medium-12">
			<h2>Related products</h2>
			
			<ul class="medium-block-grid-4 small-block-grid-1 productlist">
				<?php 
				$data = new Database();
				$where = ' prod_category LIKE "%'.$cat->cat_url.'%" AND prod_state = 1  AND prod_id != '.$r->prod_id;
				$count  =  $data->select(" * ", " products ", $where,'RAND() LIMIT 0,4');
				while($r = $data->getObjectResults()){
				?>
				<li class="<?php echo $catstext; ?>">
					<a href="shop/<?php echo $r->prod_url;?>/">
						<div class="bg"  style="background-image: url('photos/280_280_<?php echo $r->prod_photo;?>')"></div>
						<span class="title">
							<?php echo $r->prod_title;?>
							<span class="p"><?php if ( getvarscount($r->prod_id) > 1 ) echo 'From'; ?>
						&pound;<?php echo number_format( pricefrom($r->prod_id),2);?></span>
						</span>
					</a>
				</li>
				<?php } ?>
			</ul>

			<div class="text-center">
				<a href="shop/" class='button'>
					<i class="fa fa-chevron-left" aria-hidden="true"></i>
					<span>Back to shop</span>
				</a>
			</div>
		</div>
	</div>
</div>




<script>
$(document).ready(function () {

$('.prodgallery ul').bxSlider({
	pager: true,
	auto: true,
	pause: 4000,
	controls: true

});

$('#quant').change(function () {
	if ( $('.vars .active').length > 0 ) {
		total = $('#quant').val()*$('.vars .active').data('price');
		$('#addtotal').html( total.toFixed(2)  );	
	}
});
$('#quant').change();


$('.vars a').click(function(e){
	e.preventDefault();
	if ( !$(this).hasClass('outofstock') ) {
		$('.vars .active').removeClass('active');
		$(this).addClass('active');
		$('#quant').change();
	}
})

$('.addtocart').click(function (e) {
	e.preventDefault();
        var id = $('.vars .active').data('id');
        var q = $('.quant').val();
        var qinput = $('.quant');

        if ( !id ){
        	 swal({   
                          title: "You need to select a variant",     
                          type: "error",   
                          showCancelButton: false,   
                          closeOnConfirm: false,   
                          showLoaderOnConfirm: true, 
                          cancelButtonText: 'Close'
                        });
        	 return false;
        }

        if (q>0) {
            $.post("<?php echo SITEURL;?>/includes/actions.php", 
                { 
                  action: "addtocart",
                  id: id,
                  q: q
                },
                function(data){
                  console.log('data');
                  console.log(data);

                    data = JSON.parse(data);
                    $('#basketq, #basketq2').html(data.q);
                    $('#total').html(data.t);
                    $(qinput).val(0);
                      

                       swal({   
                          title: "Product added",     
                          type: "info",   
                          showCancelButton: true,   
                          closeOnConfirm: false,   
                          showLoaderOnConfirm: true, 
                          confirmButtonText: 'Go to shopping basket',
                          cancelButtonText: 'Close'
                        }, 
                        function(){   
                          window.location = '<?php echo SITEURL;?>/basket/' ;
                        });

                    
                    
                }
            );
        } else {

             swal({   
                          title: "You need to put a quantity",     
                          type: "error",   
                          showCancelButton: false,   
                          closeOnConfirm: false,   
                          showLoaderOnConfirm: true, 
                          cancelButtonText: 'Close'
                        });

        }
        
});

   $('#messagebox .close').click(function (e) {
    console.log('close');
    $('#messagebox').fadeOut();
    e.preventDefault();
   });



});
</script>


<script type="text/javascript">
$(document).ready(function () {

$(window).load(function () {
	$(window).resize(function () {
		$('li .text').css('height','auto');
		equalHeight( $('li .text') );
		});
	equalHeight($('li .text'));
});
function equalHeight(group) {
	var tallest = 0;
	group.each(function() {
		var thisHeight = $(this).height();
		if(thisHeight > tallest) {
			tallest = thisHeight;
		}
	});
	group.height(tallest);
}



});
</script>

    
<?php include('includes/footer.php');?>
