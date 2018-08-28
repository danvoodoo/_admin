<iframe height='0' id='actions' name='actions' frameborder="0" width='100'></iframe>
<div class="clearfix"></div>
</div><!--FIN WRAPPER-->






<script>
$(document).ready(function () {

<?php global $flexiblefield, $flexiblecount;
if ( isset($flexiblecount) AND $flexiblecount > -1 ) {
?>

var a = <?php echo $flexiblecount;?>;

$('#addcontent a').click(function(e) {

  a++;
  var datatype = $(this).data('type');
  field = <?php echo json_encode($flexiblefield);?>;

  //col = $(this).closest('.flexiblecontainer');
  col = $('.flexiblecontainer');

  $.post("includes/fields/flexible_content/content/"+datatype,
    {
      a: a,
      field: field
    },
    function(data){
       $('.flexiblecontent',col).append(data);
       tinymceinit();
       $('#addcontentmodal').foundation('reveal', 'close');
       $('html,body').animate({scrollTop: $('.flexiblecontent .panel:last-child').offset().top });
       $('.flexiblecontent .panel:last-child').addClass('new');
   	}
	);

  console.log(e);
  e.preventDefault();
});

<?php } ?>

});
</script>

<script src='js/scripts.js' ></script>

<?php
include_once("tinymce.php");
?>


<script src="js/foundation.min.js"></script>
<script>
$(document).foundation();
</script>


</body>
</html>
