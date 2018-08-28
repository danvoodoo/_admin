<?php 
include_once('admin/includes/init.php'); 
session_name(SESSIONNAME);
if (!isset($_SESSION)) session_start();


if ( isset($languages) ) {
  if ( isset($_GET['lang']) ) $_SESSION['lang'] = $_GET['lang'];
  if ( $_GET['lang'] == 'en' ) unset($_SESSION['lang']);
}
if ( isset($regions) ) {
  if ( isset($_GET['region']) AND isset($regions[$_GET['region']]) ) {
    $_SESSION['region'] = $_GET['region'];
     $_SESSION['lang'] = $regions[$_GET['region']]['language'];
  }
  if ( !isset($_SESSION['region']) ) $_SESSION['region'] = 'uk';
}

//include_once('includes/stats-online.php') ;
include_once('includes/style.cms.php') ;

$url = strtok($_SERVER["REQUEST_URI"],'?');
$seo = trim($url);
$seo = explode('/',$seo);
$seo = array_reverse($seo);
$seo = array_filter($seo);
$seo = implode(' | ', $seo);
$seo = ucwords($seo);
global $seotitle;
if (isset( $seotitle )) $seo = $seotitle;
$seo = str_replace("-" , " " , $seo);
 
if ($seo != '') $seo = $seo.' | '; 
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <base href='<?php echo SITEURL;?>'>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="format-detection" content="telephone=no">
    <title><?php echo $seo.SITENAME ?></title>
    <link rel="stylesheet" href="css/foundation.css" />
    <link rel="stylesheet" href="css/style.css" />
    
    <script src="js/modernizr.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/jquery.bxslider.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.colorbox-min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=XXXX"></script>
    <script src="js/jquery.gomap-1.3.2.js"></script>   
    <script src="js/scripts.js"></script>   
    <script>ajaxurl = "<?php echo SITEURL; ?>includes/actions.php";</script>

  </head>
  <body <?php global $bodyclass; echo 'class="'.$bodyclass.'"';?>>

<header>


  <div class="locationchanger">
    <div class="current">
      <?php echo $regions[$_SESSION['region']]['name'] ; ?>
      <img src="img/flags/<?php echo $_SESSION['region'] ; ?>.png" alt="">
      </div>

      <div class="change">
        <div class="a">
          change location
        </div>
        <div class="locdrop">
          <?php 
          
          $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
          $url = 'http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0];

          foreach ($regions as $key => $value) { ?>
          <a class="l" href="<?php echo $url; ?>?region=<?php echo $key; ?>">
            <img src="img/flags/<?php echo $key; ?>.png" alt=""> <?php echo $value['name']; ?>
          </a>          
          <?php } ?>
                
        </div>
      </div>
    
  </div>
  
  <nav>
  <ul>
       <?php showmenu(1); ?>
  </ul>
  </nav>



  <ul class="usermenunav">
  <?php if (!isset($_SESSION['id'])) {?>
    <li><a href="#" data-reveal-id="login">Login</a></li>
    <li><a href="register/">Register</a></li>
  <?php } else {?>
    <li><a href="myaccount/" class="login">My Account</a></li>
    <li><a href="myorders/" class="orders" >My Orders</a></li>
    <li><a href="myaccount/?lo=1" class="logout" >Log Out</a></li>
  <?php } ?>
  </ul>

  <?php include('includes/loginform.inc.php'); ?>