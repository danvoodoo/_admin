<?php include('init.php');?>
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
  <div class="columns medium-12">
    Crop to:

    <a href="editimage.php?image=<?php echo $_GET['image'];?>&free=1" class="button tiny">Free crop</a>

    <?php
    foreach ($imagesizes as $k => $r) {
      if ($r[2] == true) {
      ?>
    <a href="editimage.php?image=<?php echo $_GET['image'];?>&w=<?php echo $r[0];?>&h=<?php echo $r[1];?>" class="button tiny"><?php echo $k;?></a>
    <?php } }?>
  </div>
  <div class="columns medium-12">
    <hr>
  </div>
  <div class="columns medium-12 text-center">


      <img src="../../photos/<?php echo $_GET['image'];?>" alt="" id='cropbox'>

      <?php if (isset($_GET['w']) AND $_GET['w'] != 0 OR isset($_GET['free'])) { ?>
      <form action="editimage-crop.php" method="post">
      <input type="hidden" size="4" id="x" name="x" />
      <input type="hidden" size="4" id="y" name="y" />
      <input type="hidden" size="4" id="x2" name="x2" />

      <input type="hidden" size="4" id="y2" name="y2" />
      <input type="hidden" size="4" id="w" name="w" />
      <input type="hidden" size="4" id="h" name="h" />

      <input type="hidden" name="image" value="<?php echo $_GET['image'];?>"/>
      <?php if (!isset($_GET['free'])) {?>
      <input type="hidden" value="<?php echo $_GET['w'];?>" name="wt" />
      <input type="hidden" value="<?php echo $_GET['h'];?>" name="ht" />
      <?php } else {?>
      <input type="hidden" value="1" name="free" />
      <?php } ?>
      <input type="submit" value="Send" class='button'/>
    </form>
    <?php } ?>


  </div>
</div>

<?php
$src = '../../photos/'.$_GET['image'];
$imagesize = getimagesize($src);

if (isset($_GET['w']) AND $_GET['w'] != 0 OR isset($_GET['free'])) { ?>
<script language="Javascript">
//jQuery(document).ready(function(){

$(window).load(function(){

jQuery('#cropbox').Jcrop({
  onChange: showCoords,
  onSelect: showCoords,
  <?php if (!isset($_GET['free'])) {?>
  aspectRatio: <?php echo $_GET['w'];?>/<?php echo $_GET['h'];?>,
  <?php } ?>
  boxHeight : 600,
  boxWidth: 970,
  trueSize: [<?php echo $imagesize[0];?>,<?php echo $imagesize[1];?>]
});
});

      // Our simple event handler, called from onChange and onSelect
      // event handlers, as per the Jcrop invocation above
      function showCoords(c)
      {
        jQuery('#x').val(c.x);
        jQuery('#y').val(c.y);
        jQuery('#x2').val(c.x2);
        jQuery('#y2').val(c.y2);
        jQuery('#w').val(c.w);
        jQuery('#h').val(c.h);
      };

    </script>
<?php } ?>


    <script src="../js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
