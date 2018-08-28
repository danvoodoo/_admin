<?php
$bodyclass='noheader inner';
include('includes/header.php');



$month = addslashes($_GET['month']);
$month = str_pad($month, 2, '0', STR_PAD_LEFT);
$year = addslashes($_GET['year']);
$dateObj   = DateTime::createFromFormat('!m', $month);

$s = addslashes($_GET['s']);

$data = new Database();
$where = 'post_url = "blog" AND post_state = 1';
$count  =  $data->select(" * ", " post ", $where);
$page = $data->getObjectResults();
?>


<div class="pageheader">
	<div class="bg"  style="background-image: url('photos/1980_400_<?php echo $page->post_photo;?>')"></div>
	<div class="valignout">
		<div class="valignin">
			<div class="row">
				<div class="columns medium-12">
					<h2><span>Blog Search "<?php echo $s; ?>"</span></h2>	
					<p><?php echo $page->subtitle;?></p>
				</div>
			</div>		
		</div>
	</div>
</div>




	<div class="pagecontent singlepost">


<div class="row newsandtwitter alt">

	<div class="large-8 columns medium-8">


<?php
$data = new Database();
if (!isset($_GET['p'])) {
	$p = 1;
} else {
	$p = addslashes($_GET['p']);
}



$productsperpage = 5;
$where = 'post_type = "post" AND (post_title LIKE "%'.$s.'%"  OR post_content LIKE "%'.$s.'%" )';
$count  =  $data->select(" * ", " post ", $where,'post_date DESC');
$ps = ceil($count/$productsperpage);
$offset = ($p-1) * $productsperpage;


$count  =  $data->select(" * ", " post ", $where,'post_date DESC LIMIT '.$offset.' ,'.$productsperpage);
while($r = $data->getObjectResults()){
?>
				
		<div class="row">
			<div class="columns medium-3">
				<?php if ( $r->post_photo != '' ) {?>
				<a href="blog/<?php echo $r->post_url;?>" class="img"><img src="photos/200_200_<?php echo $r->post_photo;?>" alt=""></a>
				<?php } ?>
			</div>
			<div class="columns medium-9">
				<h3><a href="blog/<?php echo $r->post_url;?>"><?php echo $r->post_title;?></a></h3>
				<p><?php echo $r->post_excerpt;?></p>
				<a href="blog/<?php echo $r->post_url;?>" class="button tiny">see more</a>
			</div>
		</div>
				
			
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


	<?php include('includes/news-sidebar.php');?>
	
	</div>
	</div>





   
    
<?php include('includes/footer.php');?>

  </body>
</html>
