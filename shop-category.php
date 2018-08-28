<?php
$bodyclass='';
include('includes/header.php');

$page = addslashes($_GET['cat']);
$data = new Database();
$where = 'cat_url = "'.$page.'" AND cat_state = 1 AND cat_parent = 0';
$count  =  $data->select(" * ", " categories ", $where);
if ( $count == 0 ){
	include('404.php');
	include('includes/footer.php');
	exit;
}
$cat = $data->getObjectResults();

?>

<div class="shopheader small">
	<ul>
		<li>
			<div class="bg"  style="background-image: url('photos/<?php echo $cat->cat_image2; ?>')"></div>
		</li>
	</ul>
	<div class="text">
		<h2>
			<?php echo $cat->cat_name;?>
		</h2>
		<p>
			<?php echo $cat->cat_description;?>
		</p>
		
	</div>
</div>

<div class="subcats">
	<div class="row">
		<div class="columns medium-12">
			<?php
			$data = new Database();
			$where = 'cat_state = 1 AND cat_parent = '.$cat->cat_id;
			$count  =  $data->select(" * ", " categories ", $where);
			while($sc = $data->getObjectResults()){
			?>
			<a href="#" data-url='<?php echo $sc->cat_url; ?>'><?php echo $sc->cat_name;?></a>
			<?php } ?>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function () {

$('.subcats a').click(function(event) {
	event.preventDefault();
	$('.subcats a.active').removeClass('active');
	$(this).addClass('active');

	var t = this;
	$('.products li').fadeOut(300, function() {
		$('.'+$(t).data('url')).fadeIn(300);	
	});
	

});

});
</script>

<div class="productslist">
	<div class="row">
		<div class="columns medium-12">
			
			<ul class="medium-block-grid-4">
				<?php 
				$data = new Database();
				$where = ' prod_category LIKE "%'.$cat->cat_url.'%" AND prod_state = 1 ';
				$count  =  $data->select(" * ", " products ", $where,'prod_order DESC');
				while($r = $data->getObjectResults()){
					$cats = json_decode($r->prod_category);
					$catstext = '';
					foreach ($cats as $t) {
						$catstext .= ' '.$t;
		
					}
				?>
				<li class='<?php echo $catstext; ?>'>
					<a href="shop/<?php echo $cat->cat_url; ?>/<?php echo $r->prod_url;?>/">
						<figure>
							<div class="valignout">
								<div class="valignin">
									<img src="photos/450_450_<?php echo $r->prod_photo;?>" alt="">
								</div>
							</div>
							<div class="h">
								<div class="valignout">
									<div class="valignin">
										View Details
									</div>
								</div>
							</div>
						</figure>
						<span class="text">
							<?php echo $r->prod_title;?>
						</span>
						
						
						<span class="price">
						
								<?php if ( getvarscount($r->prod_id) > 1 ) echo 'From'; ?>
								&pound;<?php echo number_format( pricefrom($r->prod_id),2);?>
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

<script type="text/javascript">
$(document).ready(function () {

$(window).load(function () {
	$(window).resize(function () {

		equalHeight( $('li .text') );
		});
	equalHeight( $('li .text') );
});
function equalHeight(group) {
	$(group).css('height','auto');
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
