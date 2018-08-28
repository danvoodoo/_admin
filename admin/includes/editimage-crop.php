<?php
//$_GET['debug'] = 1;
include('init.php');
include('lib/SimpleImage2.php');

foreach($_POST as $nombre_campo => $valor){ if (!is_array($valor)) $asignacion = "\$" . $nombre_campo . "='" . addslashes(htmlspecialchars($valor)) . "';"; eval($asignacion); }//end foreach

$jpeg_quality = 90;
$src = '../../photos/'.$image;
if (!isset($_POST['free'])) {
  $output_filename = '../../photos/'.$wt.'_'.$ht.'_'.$image;
} else {
  $output_filename = '../../photos/crop_'.$image;
  $wt = $w;
  $ht = $h;
}
list($original_width, $original_height) = getimagesize($src);



$imagesize = getimagesize($src);
if ( $imagesize[0] < $wt ) { //upscale image to fill the full width
	$img = new abeautifulsite\SimpleImage($src);
	$img->fit_to_width($wt);
	$img->save($src, 90);
}


$ext = pathinfo($src, PATHINFO_EXTENSION);

if ( $ext == 'png' )
	$img_r = imageCreateFromPng($src);
else
$img_r = imagecreatefromjpeg($src);
$dst_r = ImageCreateTrueColor( $wt, $ht );





if ( $ext == 'png' ){

  imagealphablending($dst_r, false);
  imagesavealpha($dst_r, true);

  imagealphablending($img_r, false);
  imagesavealpha($img_r, true);

  imagecopyresampled($dst_r,$img_r,0,0,$x,$y, $wt,$ht,$w,$h);
  imagepng ($dst_r, $output_filename, 9);
} else {
  imagecopyresampled($dst_r,$img_r,0,0,$x,$y, $wt,$ht,$w,$h);
  imagejpeg($dst_r, $output_filename, $jpeg_quality);
}

?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="format-detection" content="telephone=no">
    <title>Gallery</title>
    <link rel="stylesheet" href="../css/foundation.css" />
    <link rel="stylesheet" href="../css/helpers.css" />
    <link rel="stylesheet" href="../css/jquery.Jcrop.css" type="text/css" />

    <script src="../js/modernizr.js"></script>
    <script src="../js/jquery.js"></script>
    <script src="../js/jquery.Jcrop.js"></script>

  </head>
  <body>

<div class="row">
  <div class="columns medium-12 text-center">

		<img src="<?php echo $output_filename;?>?cache=<?php echo time();?>" alt="">
		<hr>
		<a href="#" class="button close">Close</a>
		<a href="#" class="back button">Back</a>
	</div>
</div>

<script>
$(document).ready(function () {
$('.close').click(function(e) {
  window.parent.jQuery.colorbox.close();
  e.preventDefault();
});

$('.back').click(function(e) {
  window.history.back();
  e.preventDefault();
});

});
</script>

</body>
</html>
