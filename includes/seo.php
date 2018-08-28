<?php

$seo =  $protocol.'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$seo = str_replace(SITEURL, '', $seo);
$seo = explode('?',$seo);
$seo = trim($seo[0]);
$seo = str_replace("-" , " " , $seo);
$seo = str_replace("/" , " | " , $seo);
$seo = str_replace("%20" , " " , $seo);
$seo = str_replace("| |" , "|" , $seo);
$seo = ucwords($seo);
$seo_array = explode( "|" , $seo);


$seo_array = array_reverse($seo_array);
$seo_array = remove_empty($seo_array);
$seo = implode(' | ', $seo_array);

$seo = trim($seo);
if ( $seo != '' ) $seo .= ' - ';

?>
<title><?php echo $seo ?> <?php echo SITENAME;?></title>