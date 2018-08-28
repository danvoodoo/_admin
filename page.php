<?php
$bodyclass='';
include('includes/header.php');

$page = addslashes($_GET['url']);
getpost($page);
if ( $count == 0 ){
	include('404.php');
	include('includes/footer.php');
	exit;
}
?>

<div class="pageheader">
	<div class="bg"  style="background-image: url('photos/1600_500_<?php echo $r->post_photo;?>')"></div>
	<div class="valignout">
		<div class="valignin">
			<div class="row">
				<div class="columns medium-12">
					<h2><span><?php echo $r->post_title;?></span></h2>	
					<p><?php echo $r->subtitle;?></p>
				</div>
			</div>		
		</div>
	</div>
</div>


<?php
if ( $r->sidebar ) {
?>
<div class="pagecontent">
	<div class="row">
		<div class="columns medium-12 large-8">
			<?php include('includes/flexiblecontent.php') ;  ?>
		</div>

		<div class="columns medium-12 large-4">
			<?php include('includes/sidebarcontent.php') ;  ?>
		</div>

	</div>
</div>
<?php } else { ?>
<div class="pagecontent">
	<div class="row">
		<div class="columns medium-10 medium-offset-1">
			<?php include('includes/flexiblecontent.php') ;  ?>
		</div>

	</div>
</div>
<?php } ?>

    
<?php include('includes/footer.php');?>
