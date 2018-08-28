<?php 
include('init.php');

if (isset($_POST['page']) ) {

    $page = addslashes($_POST['page']);
    $data = new Database();
    $where = '';
    $from = $page * 50;
    $count  =  $data->select(" * ", " medialibrary ", $where, 'media_id DESC LIMIT '.$from.',50');
    while($r = $data->getObjectResults()){
      if (file_exists('../../photos/200_200_'. $r->media_url)) {

        $filedata = getimagesize( '../../photos/'. $r->media_url );
        $size = filesize ( '../../photos/'. $r->media_url );
        
        $tooltip = $filedata[0].'x'.$filedata[1].' - '.human_filesize($size).' <br>Uploaded in '.date('d/m/Y',strtotime($r->media_date));
      ?>
    <li><a href="#" data-image='<?php echo $r->media_url;?>' class='galitem tip-bottom ' data-tooltip title='<?php echo $tooltip; ?>'>
      <img src="<?php echo SITEURL;?>photos/200_200_<?php echo $r->media_url;?>" alt="">
    </a>
    <a href="#" class="delete button alert" data-id='<?php echo $r->media_id;?>'><i class="fa fa-trash-o"></i></a>
    </li>
    <?php } } 
    exit;
}

if (isset($_POST['action']) AND $_POST['action'] == 'delete') {
  $data = new Database();
  foreach($_POST as $nombre_campo => $valor){ if (!is_array($valor)) $asignacion = "\$" . $nombre_campo . "='" . addslashes(htmlspecialchars($valor)) . "';"; eval($asignacion); }//end foreach
  $where = 'media_id = '.$id;
  $count  =  $data->select(" * ", " medialibrary ", $where);  
  $r = $data->getObjectResults();

  if ( file_exists('../../photos/'. $r->media_url) ) {
    $fileName = $r->media_url;
    $unset = unlink('../../photos/'. $r->media_url);
    $data = new Database();
    $count  =  $data->delete(" medialibrary ", "media_id = $id");

    foreach ($imagesizes as $size) {
  
        if ( file_exists('../../photos/'. $size[0].'_'.$size[1].'_'.$fileName) ) {
          unlink('../../'.$folder.'/'.$size[0].'_'.$size[1].'_'.$fileName);
        }
        unlink('../../'.$folder.'/200_200_'.$fileName);
         
      }
    exit;
  }
}


function human_filesize($bytes, $decimals = 2) {
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
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
    <link rel="stylesheet" href="../css/font-awesome.css" />
    
    <script src="../js/modernizr.js"></script>
    <script src="../js/jquery.js"></script>
  </head>
  <body>

<div class="row">
  <div class="columns medium-12">
  <ul class="medium-block-grid-6" id='images'>
    <?php
    $data = new Database();
    $where = '';
    $count  =  $data->select(" * ", " medialibrary ", $where, 'media_id DESC LIMIT 0,50');
    while($r = $data->getObjectResults()){
      if (file_exists('../../photos/200_200_'. $r->media_url)) {

        $filedata = getimagesize( '../../photos/'. $r->media_url );
        $size = filesize ( '../../photos/'. $r->media_url );
        
        $tooltip = $filedata[0].'x'.$filedata[1].' - '.human_filesize($size).' <br>Uploaded in '.date('d/m/Y',strtotime($r->media_date));
      ?>
    <li><a href="#" data-image='<?php echo $r->media_url;?>' class='galitem tip-bottom ' data-tooltip title='<?php echo $tooltip; ?>'>
      <img src="<?php echo SITEURL;?>photos/200_200_<?php echo $r->media_url;?>" alt="">
    </a>
    <a href="#" class="delete button alert" data-id='<?php echo $r->media_id;?>'><i class="fa fa-trash-o"></i></a>
    </li>
    <?php } } ?>

  </ul>
  <div id="loading" style='display: none; padding: 20px' class="text-center">Loading...</div>
  </div>
</div>



<style>
.galitem {
  display: block
}
.medium-block-grid-6 li{
  position: relative;
}  
.medium-block-grid-6 li .delete{
    padding: 0;
    width: 36px;
    top: 0;
    right: 0;
    height: 36px;
    position: absolute;
    line-height: 36px;
}
</style>

<script>
$(document).ready(function () {

loading = 0;
page = 1;
$(window).scroll(function () {

  dh = $(document).height() - $(window).height() - 300;
  st = $(window).scrollTop();

  if ( st > dh && loading == 0 ){
    loading = 1;
    page++;
    $('#loading').show();
    $.post("gallery.php", 
      { 
          page: page
      },
      function(data){
          console.log(data);
          if ( data == '' ){
            $('#loading').hide();
          } else {
            $('#images').append(data);
            $('#loading').hide();
            loading = 0;  
          }

          
      }
  );
  }

});  

$('#images').on('click','.delete',function(e) {
  var id = $(this).data('id');
  var p = $(this).parent();
  $.post(window.url, 
    { 
      action: "delete",
      id: id
    },
    function(data){
       console.log(data); 
      $(p).slideUp();
     }
  );
  e.preventDefault();
});

$('#images').on('click','.galitem',function(e) {
  
  console.log(window.parent.imagetarget);
  var file = $(this).data('image');
  var target = $( window.parent.imagetarget ).closest('.field.image');
  $('.filename', target).val(file);

  if ( $('.filename',target).data('previewsize') )
        size = $('.filename',target).data('previewsize');
      else
        size = "200_200";

  $('.preview',target).remove();
  $('<img src="../photos/'+size+file+'" class="preview" />').insertAfter( $('.filename',target) );

  window.parent.jQuery.colorbox.close();

  e.preventDefault();
});
});
</script>

    
    <script src="../js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
