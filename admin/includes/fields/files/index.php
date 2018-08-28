<?php
include('includes/fields/files/functions.php');


if (!isset($field['columns'])) $field['columns'] = 12;?>
<div class="medium-<?php echo $field['columns'];?> columns">
	<hr>
	<h4><?php echo $field['name'];?></h4>

	<?php
	global $fixed, $co;
	$fixed = 0;
	if (isset($field['fixed']) AND $field['fixed'] == 1) $fixed = 1;


	if (isset($r)) $v = $r[$field['field']]; else $v ='';

	?>

	<div id="flexiblecontent">
		<?php
		$a = 0;


		//$v = preg_replace( "/\r|\n/", "", $v );
		if (isset($_GET['debug'])) print_r($v);



		$contents = json_decode( $v , true);

		if (isset($_GET['debug'])) print_r($contents);

		if (is_array($contents))
		foreach ($contents as $co) {
			//print_r($co);
			$a++;
			include('includes/fields/files/content/file.php');
		} else {
			include('includes/fields/files/content/file.php');
		}
		?>

	</div>


	</ul>
	

</div>


<script>
$(document).ready(function () {

var a = <?php echo $a;?>

$('#addcontent a').click(function(e) {

  a++;
  var datatype = $(this).data('type');

  $.post("includes/fields/flexible_content/content/"+datatype,
    {
      a: a
    },
    function(data){
       $('#flexiblecontent').append(data);
       tinymceinit();
   	}
	);

  console.log(e);
  e.preventDefault();
});

$('#flexiblecontent').on('click',' .flex_buttons .del', function(e) {
  $(this).closest('.panel').remove();
  e.preventDefault();
});

$('#flexiblecontent').on('click',' .flex_buttons .up', function(e) {
  item = $(this).closest('.panel');
  before = item.prev();
  item.insertBefore(before);
  e.preventDefault();
});

$('#flexiblecontent').on('click',' .flex_buttons .down', function(e) {
  item = $(this).closest('.panel');
  after = item.next();
  item.insertAfter(after);
  e.preventDefault();
});

$('#flexiblecontent').on('click',' .repeater-add', function(e) {
  repeater = $(this).closest('.repeater');
  item = $('.items',repeater);
  //console.log($('.item::last-child',item));
  var newitem = $('.item:last-child',item).clone();
  $('input, textarea',newitem).val('');
  $('.preview',newitem).remove();

  $('input, textarea, select',newitem).each(function() {
  	console.log(this);
  	if ($(this).attr('name')) {
	  	var name = $(this).attr('name');
	  	name = name.split('][');
	  	name[2] ++;
	  	name = name.join('][');
	  	$(this).attr('name',name);
  	}
  });

  $(newitem).appendTo(item);
  //$('.item:eq(0)',item).clone().reset().appendTo(item);
  e.preventDefault();
});




$('#flexiblecontent').on('click',' .repeater-column-add', function(e) {
  repeater = $(this).closest('.repeater');

  $('.item',repeater).each(function() {
  		var newitem = $('td:last-child',this).clone();
  		$('input, textarea',newitem).val('');
  		$(newitem).appendTo(this);
  });

  e.preventDefault();
});








/*
var uploader = new plupload.Uploader({
  browse_button: 'upload-6-1', // this can be an id of a DOM element or the DOM element itself
  url : 'includes/upload.php'
});


uploader.init();

*/




	$('.repeater .item').each(function() {
		$(this).prepend('<a href="#" class="up button tiny"><i class="fa fa-chevron-up"></i></a>\
		<a href="#" class="down button tiny"><i class="fa fa-chevron-down"></i></a>\
		<a href="#" class="del button tiny alert"><i class="fa fa-trash-o"></i></a>');
	});

	$('#flexiblecontent').on('click',' .repeater .del', function(e) {
	  $(this).closest('.item').remove();
	  e.preventDefault();
	});

	$('#flexiblecontent').on('click',' .repeater .up', function(e) {
	  item = $(this).closest('.item');
	  before = item.prev();
	  item.insertBefore(before);
	  e.preventDefault();
	});

	$('#flexiblecontent').on('click',' .repeater .down', function(e) {
	  item = $(this).closest('.item');
	  after = item.next();
	  item.insertAfter(after);
	  e.preventDefault();
	});

});
</script>

<style>
	.flex_buttons{
		position: absolute;
		top: 0;
		right: 0;
		z-index: 1;
	}
	#flexiblecontent .panel{
		position: relative;
	}
	.flex_buttons .type{
		  height: 32px;
		  padding: 0 10px;
		  background: #333;
		  line-height: 32px;
		  display: inline-block;
		  vertical-align: top;
		  font-size: 12px;
		  color: #fff;
	}
	.repeater table{
		width: 100%;
	}
	.mceEditor {
		display: block;
		margin-bottom: 20px;
	}
	.flex_buttons input{
		  height: 32px;
		  width: 50px;
		  display: inline-block;
		  vertical-align: top;
	}
</style>
