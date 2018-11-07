<?php 
include('init.php'); 
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
    <link rel="stylesheet" href="../css/styles.css" />
    
    <script src="../js/modernizr.js"></script>
    <script src="../js/jquery.js"></script>
  </head>
  <body class="urlmanager">

<div class="row ">
<div class="columns medium-12">
  
  <form action="" id='customurl'>
    <label for="">
      Custom url
    </label>
    <div class="row">
      <div class="columns medium-6">
        <input type="text" name="custom">    
      </div>
      <div class="columns medium-4">
        <select name="target" id=""> 
          <option value="">Opens in...</option>
          <option value="">Same window</option>
          <option value="_blank">New Tab</option>
        </select>    
      </div>
      <div class="columns medium-2">
        <button class="small">Send</button>    
      </div>
    </div>
  </form>

  <hr>

	<div id="pages">
		
		
		<?php 
			foreach ($urlstructure as $type => $value) {
		?>
			<h4><?php echo ucwords($type); ?></h4>
		
			<p>
			<?php
				$data = new Database();
				$where = 'post_parent = 0 AND post_type = "'. $type .'" AND post_state = 1 ORDER BY post_order DESC';
				$count = $data->select("*", "post", $where);
			
				while($r = $data->getObjectResults()) {
					
			?>
					<a href="#"  data-url='<?php // if($prefix != '') echo ''. $prefix .'/'; ?><?php echo get_url($r); ?>'><?php echo $r->post_title; ?></a><br>

					<?php
						$data2 = new Database();
						$where = 'post_parent = '. $r->post_id .' AND post_type = "'. $type .'" AND post_state = 1';
						$count = $data2->select("*", "post", $where);
					
						while($r2 = $data2->getObjectResults()) {
							
					?>
							&nbsp;&nbsp; - <a href="#"  class="child" data-url='<?php // if($prefix != '') echo ''. $prefix .'/'; ?><?php echo get_url($r2); ?>'><?php echo $r2->post_title; ?></a><br>
					<?php
						}
					?>

		<?php
				}
			}
		?>
		</p>
	</div>


<script type="text/javascript">
$(document).ready(function () {

$('#customurl').submit(function(e) {
  var target = $( window.parent.linktarget ).closest('.field');
  urlobject = {};
  urlobject.url = $('[name="custom"]').val();
  urlobject.target = $('[name="target"]').val();
  $('input',target).val(  JSON.stringify(urlobject) );
  $('.url',target).html(  urlobject.url );
  window.parent.jQuery.colorbox.close();
  e.preventDefault();
});



$('#pages a').click(function(e) {
  var target = $( window.parent.linktarget ).closest('.field');
  urlobject = {};
  urlobject.url = $(this).data('url');
  urlobject.target = '';
  urlobject.title = $(this).html();
  $('input',target).val(  JSON.stringify(urlobject) );
  $('.url',target).html(  urlobject.url );
  $('.title',target).html(  urlobject.title );
  window.parent.jQuery.colorbox.close();
  e.preventDefault();
});





});
</script>

</div>
</div>
</body>
</html>