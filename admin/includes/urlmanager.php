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
		<p style="font-size: small;"><strong>PLEASE NOTE:</strong> the bold text before the Page Name is for REFERENCE only <i>(indicating which school the page belongs to)</i>, this will not be shown on the actual website.</p>
		
		<?php 
			foreach ($urlstructure as $type => $value) {
		?>
			<h4><?php echo ucwords($type); ?></h4>
		
			<?php
				$data = new Database();
				$where = 'post_parent = 0 AND post_type = "'. $type .'" AND post_state = 1 ORDER BY post_school ASC';
				$count = $data->select("*", "post", $where);
			
				while($r = $data->getObjectResults()) {
					if($r->post_school == 'high') {
						$style = 'background-color: rgb(11, 48, 134); color: #ffffff;';
						$prefix = 'high';
					} if($r->post_school == 'primary') {
						$style = 'background-color: rgb(16, 74, 211); color: #ffffff;';
						$prefix = 'primary';
					} if($r->post_school == 'nursery') {
						$style = 'background-color: rgb(51, 153, 204); color: #ffffff;';
						$prefix = 'nursery';
					} if($r->post_school == 'general') {
						$style = '';
						$prefix = '';
					}
			?>
					<a href="#" <?php if($style != '') { echo 'style="'. $style .'"'; } ?> data-url='<?php // if($prefix != '') echo ''. $prefix .'/'; ?><?php echo get_url($r); ?>'><strong><?php echo $r->post_school; ?></strong> - <?php echo $r->post_title; ?></a><br>

					<?php
						$data2 = new Database();
						$where = 'post_parent = '. $r->post_id .' AND post_type = "'. $type .'" AND post_state = 1';
						$count = $data2->select("*", "post", $where);
					
						while($r2 = $data2->getObjectResults()) {
							if($r2->post_school == 'high') {
								$style = 'background-color: rgb(11, 48, 134); color: #ffffff;';
								$prefix = 'high';
							} if($r2->post_school == 'primary') {
								$style = 'background-color: rgb(16, 74, 211); color: #ffffff;';
								$prefix = 'primary';
							} if($r2->post_school == 'nursery') {
								$style = 'background-color: rgb(51, 153, 204); color: #ffffff;';
								$prefix = 'nursery';
							}
					?>
							<a href="#" <?php if($style != '') { echo 'style="'. $style .'"'; } ?> class="child" data-url='<?php // if($prefix != '') echo ''. $prefix .'/'; ?><?php echo get_url($r2); ?>'><strong><?php echo $r2->post_school; ?></strong> - <?php echo $r2->post_title; ?></a><br>
					<?php
						}
					?>

		<?php
				}
			}
		?>
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