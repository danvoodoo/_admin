<?php
ini_set('session.save_path', 'session');
if (!isset($_SESSION)) @session_start();
if (!isset($_SESSION["admin"])) header("Location: login.php"); 

include("includes/style.cms.php");
include_once("config.php");
include_once("init.php");
include_once("functions/functions.php");

if (!isset($_POST["action"]) and !isset($_GET["action"])) { 
include_once("menuitems.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title><?php echo SITENAME;?> - Site Admin </title>

<link rel="stylesheet" href="css/foundation.css" />
<link rel="stylesheet" href="css/helpers.css" />
<link rel="stylesheet" href="css/font-awesome.css" />
<link href="css/styles.css?h=<?php echo time();?>" rel="stylesheet" type="text/css">
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />


<script src="js/jquery.js"></script>
<script type="text/javascript" src="js/plupload/moxie.min.js"></script>
<script type="text/javascript" src="js/plupload/plupload.dev.js"></script>
<script type="text/javascript" src="js/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDktEavPJhrxbghkc0vCtFzd-SoTcp1Ioo"></script>
<script type="text/javascript" src="js/jquery.gomap-1.3.2.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>

<script>
	SITEURL = '<?php echo SITEURL; ?>';
</script>


</head>

<body>


<div id="wrapper">

    <div class="sidebar">

        <div class="inner">

            <div class="logo">

                <a href="<?php echo SITEURL;?>admin/"><img src="img/logo.png" width="177" height="59" alt="<?php echo SITENAME;?>" /></a>

            </div><!--fin logo-->

			<ul >
			<?php

			foreach ($menuitems as $k => $v) {?>
				<li class="closed" id='<?php echo $k; ?>'>
				<a href="javascript:void(0) "><span><?php echo $v['title']; ?></span></a>
					<ul>
					<?php
					foreach ($v['items'] as $kk => $vv) { ?>
						<li>
							<?php if ( isset( $vv['customurl'] ) AND $vv['customurl'] == 1 ) {?>
								<a href="<?php echo $vv['url']; ?>"><span><?php echo $vv['name']; ?></span></a>
							<?php } else {?>
								<a href="<?php echo $vv['url']; ?>?list=1"><span><?php echo $vv['name']; ?></span></a>
							<?php } ?>

							<?php if ( $vv['new_item'] == 1 ) {?>
								<a href="<?php echo $vv['url']; ?>" class='new'>New</a>
							<?php } ?>
						</li>
					<?php } ?>
					</ul>

				</li>
			<?php 
			}
			?>
			</ul>

			<script type="text/javascript">
			$(document).ready(function () {

				$('#wrapper').on('click','.closed a',function () {
					$('.expanded ul').slideUp(300, function () {
						$(this).parent().removeClass('expanded');
						$(this).parent().addClass('closed');
					});

					$(this).parent().addClass('expanded');
					$(this).parent().removeClass('closed');
					$(this).next().slideDown();
				});

				$('#wrapper').on('click','.expanded a',function () {


					$(this).next().slideUp(300, function () {
						$(this).parent().removeClass('expanded');
						$(this).parent().addClass('closed');
					});

				});


				<?php if (isset($menu_active)) {?>
				$('#<?php echo $menu_active;?>').addClass('expanded active');
				$('#<?php echo $menu_active;?>').removeClass('closed');
				$('ul','#<?php echo $menu_active;?>').show();
				<?php } ?>

			});
			</script>



			<ul>

                <li class="logout"><a href="login.php?out=1" title="Log Out"><span>Log Out</span></a></li>
            </ul>
            <div class="version"><a href="logfile.php"><?php echo SITENAME;?> CMS Version <?php echo $version ?></a></div>



			</div><!--fin inner-->

</div><!--fin sidebar-->
<?php } 
require("includes/messages.php");
?>