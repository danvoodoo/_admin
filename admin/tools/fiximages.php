<?php
$_GET['debug'] = 1;
include('../includes/init.php');
include('../includes/lib/SimpleImage2.php');

global  $imagesizes;


$data = new Database();
// third argument is WHERE clause
$count  =  $data->select(" * ", " medialibrary ");
$folder = 'photos';
while($r = $data->getObjectResults()){


  $fileName = $r->media_url;
if (file_exists('../../'.$folder.'/'.$fileName)) {

    
  $folder = 'photos';

  if (!file_exists('../../'.$folder.'/200_200_'.$fileName)) {
    $img = new abeautifulsite\SimpleImage('../../'.$folder.'/'.$fileName);
    $img->thumbnail(200, 200);
    $img->save('../../'.$folder.'/200_200_'.$fileName, 90);
  }

  
  foreach ($imagesizes as $size) {
    

    if (!file_exists('../../'.$folder.'/'.$size[0].'_'.$size[1].'_'.$fileName)) {
        $img = new abeautifulsite\SimpleImage('../../'.$folder.'/'.$fileName);
        if ($size[2]) {
          $img->thumbnail($size[0], $size[1]);
        } else {
          $img->best_fit($size[0], $size[1]);
        }
        $img->save('../../'.$folder.'/'.$size[0].'_'.$size[1].'_'.$fileName, 90);
        echo $size[0].'_'.$size[1].'_'.$fileName.'<br>';
    }
      
  }


}


}
exit;
    
    ?>
