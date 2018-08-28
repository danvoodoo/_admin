<?php
$bodyclass='inner footersep';
include('includes/header.php');
$caturl = addslashes($_GET['url']);
$data = new Database();
$where = 'cat_url = "'.$caturl.'"  AND cat_type = "blog"';
$count  =  $data->select(" * ", " categories ", $where);
$cat = $data->getObjectResults();
?>
    
<div class="row pagecontent">
<div class="columns medium-12">
	<ul class="breadcrumb">


			<h2 class='sectiontitle big'><?php echo $cat->cat_name;?></h2>
		</div>
	

	<div class="large-8 columns medium-8">


<?php
$data = new Database();
if (!isset($_GET['p'])) {
	$p = 1;
} else {
	$p = addslashes($_GET['p']);
}
$productsperpage = 5;
$where = 'post_type = "post" AND post_state = 1 AND post_category LIKE "%'.$cat->cat_url.'%"';
$count  =  $data->select(" * ", " post ", $where,'post_date DESC');
$ps = ceil($count/$productsperpage);
$offset = ($p-1) * $productsperpage;

$where = 'post_type = "post" AND post_state = 1 AND post_category LIKE "%'.$cat->cat_url.'%"';
$count  =  $data->select(" * ", " post ", $where,'post_date DESC LIMIT '.$offset.' ,'.$productsperpage);
while($r = $data->getObjectResults()){
?>
		<article class="post">
			<div class="row">
				<div class="large-4 columns medium-4">

					<?php 
					if ($r->post_photo != '') {?>
					<a href="blog/<?php echo $r->post_url;?>/">
						<img src="photos/280_280_<?php echo $r->post_photo;?>" alt="">
					</a>
					<?php } else echo '&nbsp;' ?>
				</div>
				<div class="large-8 columns medium-8">
					<h3><a href="blog/<?php echo $r->post_url;?>/"><?php echo $r->post_title;?></a></h3>
					<div class="blog"><?php echo date('d F Y', strtotime($r->post_date));?></div>
					<p><?php echo $r->post_excerpt;?></p>
					<a href="blog/<?php echo $r->post_url;?>/" class="button tiny">Read More</a>
				</div>
				<div class="large-12 columns"><hr></div>
			</div>
		</article>
		<?php } ?>

<?php if ($count > 0 AND $ps > 1) { 
$protocol = 'http';
$url =  $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$url = explode('?', $url);
$url = $url[0];
?>
		<div class="navigation">
			<div class="row">
				<div class="columns medium-4">
					<?php
				    if ($p > 1) {?>
				    <a href="<?php echo $url;?>?p=<?php echo $p-1;?>" class="button small left">Prev</a>
				    <?php } else echo '&nbsp;' ?>
		    		
				</div>
				<div class="columns medium-4 text-center">
					<p>Page <?php echo $p;?> of <?php echo $ps;?> </p>
				</div>
				<div class="columns medium-4">
					<?php if ($p < $ps) {?>
				    <a href="<?php echo $url;?>?p=<?php echo $p+1;?>" class="button small right">Next</a>
				    <?php } else echo '&nbsp;' ?>
				</div>
			</div>
			
			
			
		</div>
<?php } ?>	

	</div>


	<?php include('includes/blog.sidebar.php');?>
	
</div>




<?php include('includes/footer.php');?>
