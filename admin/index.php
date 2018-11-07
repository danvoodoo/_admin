<?php 
include("includes/init.php");
include('includes/header.php');

?>


  
            
    <div class="content">	
	
		<div class="inner">

		<?php
		if (version_compare(PHP_VERSION, '5.3.0' , '<')) {
		?>
		    <div data-alert class="alert-box alert ">
		    	<p>
		  		<strong>The server PHP version is OLD.</strong> <br>
		  		PHP Version required: 5.3 <br>
		  		Server PHP Version: <?php echo PHP_VERSION;?>
		  		</p>
			</div>
			<hr>
		<?php } ?>
    	
    	<h2>Welcome to <?php echo SITENAME;?> Site Admin<div class="title">
		<span class="last">
         	<div class="siteInfo">
			  	<p>You are logged in using <?php echo $_SERVER['REMOTE_ADDR']?>. <br />
				CMS version <?php echo $version ?> which was last updated <?php echo $updated ?></p>
	          	<p>Please select a menu item on the left to continue.</p>
				



				<hr>


				<div class="statsTitle"><h2>Website Stats</h2></div>
				<?php //stats
				$time = time() - (60*15);
				$data = new Database();
				$where = 'visitor_time >= '. $time;
				$count  =  $data->select(" * ", " visitors_online ", $where);

				?>
				<?php if ( $count == "0"){?>
				<p>There aren't currently any visitors on the site.</p>
				<?php } else if ( $count == 1) {?>
				<p>The site has 1 visitor online at present</p>
				<?php } else{ ?>
				<p>There are <?php echo $count ?> visitors online.</p>
				<?php } ?>
				<p><a href="?refresh=<?php echo rand(0,99999); ?>">Click here to refresh these stats</a></p>

				<?php if ($count>0) { //list the users ?>
				<hr>
				<table width="500">
				<tr>
				<td><strong>Visitor IP</strong></td>
				<td><strong>Last Activity</strong></td>
				</tr>
				<?php  
				while($r = $data->getObjectResults()){

					
					
				echo "<tr>";
				echo "<td>" . $r->visitor_ip . "</td>";
				echo "<td>" . nicetime($r->visitor_time) . "</td>";
				echo "</tr>";
				}

				}
				?>


			</div>
			</div>


			<?php
			$data = new Database();
			$where = 'back_date = "'.date('Y-m-d').'"';
			$count  =  $data->select(" * ", " backups ", $where);
			if ($count == 0) {
				echo 'Building Database Backup...';
			  	$bu = backup_database_tables('*');
			  	$data = new Database();
			 	 $arr = array(
			           'back_date' => date('Ymd')
			           );
			  	$count  =  $data->insert(" backups ", $arr);
			  	$id = $data->lastid();
			  	?>
			  	<hr>
			  	<div data-alert class="alert-box success ">
			  		Database backup created  	
				</div>
				<?php

			  	$msgTo = get_option('backupemail');
			  	if ( $msgTo!= '' ) {
				  	$msgSub = 'Backup '.SITENAME.' '.date('Y-m-d');
				  	$msj = '<a href="'.SITEURL.'admin/'.$bu.'">'.$bu.'</a>';
				 	include('notify/index.php');
				}

			}

			$path = 'backup/';
				if ($handle = opendir($path)) {
					$files = array();
					$a=0;
				    while (false !== ($file = readdir($handle))) {
				    	$a++;
				    	if ($file != "." && $file != "..") {
			           		$files[filemtime($path.$file).$a] = $file;
			        	}
				    }
				    
				    ksort($files);
				    $files = array_reverse($files, true);
				    $files = array_slice($files, 30);
				    foreach ($files as $f) {
				    	unlink($path.$f);
				    }
				}
			?>		
		
    </div><!--fin content-->


   <?php include('includes/footer.php');?>

	