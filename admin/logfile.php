<?php 
include('includes/header.php');
?>


  
            
    <div class="content">	
	
		<div class="inner">
    	
         
         <h2>Version <?php echo $version ?></h2><br />
         <ul>
         <?php include("includes/logfile.txt");?>
		</ul>
        <br />
        <p> Last updated on <?php echo $updated ?></p>
		
		</div>
		
    </div><!--fin content-->


   <?php include('includes/footer.php');?>

	