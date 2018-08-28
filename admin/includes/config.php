<?php
$url =  $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if ( strpos($url, 'localhost') > -1 ) {
  define("DATABASE","admindemo");
  define("HOST","localhost");
  define("USER","root");
  define("PASS","");
  define("SALT","6LfQWwgUAA");
  define("LOCAL",1);
  $dev = 1;
  $siteurl = 'http://localhost/_admin/';
} else {
  define("DATABASE","dbname");
  define("HOST","localhost");
  define("USER","dbuser");
  define("PASS","password");
  define("SALT","6LfQWwgUAA");
  define("LOCAL",0);
  $siteurl = 'http://siteurl';
  $dev = 0;
}


if ( strpos($url, '88.150.145.131') > -1 ) {
  $dev = 1;
}

/*global*/
define('SITEURL',$siteurl);
define('PRODUCTION',0);
define('DEVEMAIL','gabitondw@gmail.com');
//$whitelabel = 1;// uncomment this for sites that should not show the name Voodoochilli
define('UPLOADROOT','/photos' );
define('SITENAME', 'Site name' );
define('SESSIONNAME','cmsfront' );
define('EMAILFROM','noreply@siteurl.com' );
define("DEV",$dev);

$version = "2.2"; //add 0.1 to each major change and 0.01 to a bug fix and update /includes/logfile.txt
date_default_timezone_set('Europe/Lisbon');

  $logfile = $_SERVER['DOCUMENT_ROOT'].parse_url($siteurl."admin/includes/logfile.txt",PHP_URL_PATH);
if (file_exists( $logfile)) {  
  $updated = date ("l jS \of F Y h:i:s A", filemtime($logfile));//dont comment this out gabriel! If you get an error, check the paths
}

if (isset($_GET['debug']))
    define("DEBUG",1);
else
    define("DEBUG",0);

error_reporting(0);
if (DEBUG == 1 AND PRODUCTION == 0) {
    error_reporting(E_ALL);
    ini_set("display_errors","stdout");
}

$imagesizes = array(
    'Header Images'=> array(1600,650,true),
    'Highlight'=> array(1600,500,true),
    'Full column'=> array(1100,500,true),
    'Gallery Thumbnail'=> array(280,280,true),
    'Product large'=> array(1000,1000,false),
    'News thumbnail'=> array(320,200,true),
    'Prize'=> array(80,80,false),
    'Prize Home'=> array(120,120,false),
);



$urlstructure = array(
  'page' => array(
      'urlstructure' => '%parent/%url',
      'viewonsite' => true
      ),
  'faq' => array(
      'urlstructure' => 'faqs/%url',
      'viewonsite' => false
      ),
  'post' => array(
      'urlstructure' => 'news/%url',
      'viewonsite' => true
      ),
  'product' => array(
      'urlstructure' => 'product/%url',
      'viewonsite' => true
      ),
);


/*** config for shop ***/
define('VAT', 0);
define('SHIPPING', 1);
define('DISCOUNTCODE', 1);
define('SHOPHASUSERS', 0);
define('MANAGESTOCK', 1);
define('LOWSTOCKWARNING', 3);
define('REGISTERREQUIRECONFIRM', 1);


