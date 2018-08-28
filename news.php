<?php
$bodyclass='noheader inner';
include('includes/header.php');



$page = addslashes($_GET['url']);
$data = new Database();
$where = 'post_url = "'.$page.'" AND post_state = 1 AND post_type = "post"';
$count  =  $data->select(" * ", " post ", $where);
$r = $data->getObjectResults();
getmetas( $r->post_id, $r->post_type );



$data = new Database();
$where = 'post_url = "blog" AND post_state = 1';
$count  =  $data->select(" * ", " post ", $where);
$page = $data->getObjectResults();
?>


<div class="pageheader">
	<div class="bg"  style="background-image: url('photos/1600_500_<?php echo $page->post_photo;?>')"></div>
	<div class="valignout">
		<div class="valignin">
			<div class="row">
				<div class="columns medium-12">
					<h2><span><?php echo $page->post_title;?></span></h2>	
					<p><?php echo $page->subtitle;?></p>
				</div>
			</div>		
		</div>
	</div>
</div>


<div class="pagecontent singlepost">
	<div class="row">
		<div class="columns medium-8">
			<h2><?php echo $r->post_title;?></h2>
		
			<?php
			if ($r->post_photo){?>
			<figure>
			<img src="photos/800_800_<?php echo $r->post_photo;?>" alt="">
			</figure>	
			<?php } ?>

			<!-- AddToAny BEGIN -->
			<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
			<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
			<a class="a2a_button_facebook"></a>
			<a class="a2a_button_twitter"></a>
			<a class="a2a_button_google_plus"></a>
			</div>
			<script async src="https://static.addtoany.com/menu/page.js"></script>
			<!-- AddToAny END -->
			<hr>

			<?php echo $r->post_content;?>
		</div>

		<?php include('includes/news-sidebar.php');?>
	</div>
</div>
   

<div class="footerline"></div>
    
<?php include('includes/footer.php');?>