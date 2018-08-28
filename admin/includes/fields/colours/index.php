<?php 
if (isset($_POST['action']) AND $_POST['action'] == 'updatecolours') {
	include('../../conexion.php');
	//print_r($_POST);
	$col = json_decode($_POST['colours']);
	//print_r($col);
	$ids = array();
	foreach ($col as $r) {
		//print_r($r);
		if ($r->idd == '') {
			//echo 'new';
			$data = new Database();
			$arr = array(
				       'colour_productid' => $_POST['postid'],
				       'colour_value1' => $r->col1,
				       'colour_value2' => $r->col2,
				       );
			$count  =  $data->insert(" colour ", $arr);
			$id = $data->lastid();
		} else {
			//echo 'update';
			$data = new Database();
			$arr = array(
				       'colour_value1' => $r->col1,
				       'colour_value2' => $r->col2,
				       );
			$count  =  $data->update(" colour ", $arr, 'colour_id = '.$r->idd);
			$id = $r->idd;
		}
		$ids[] = $id;
	}
	echo json_encode($ids);
	exit;

}

if (isset($_POST['action']) AND $_POST['action'] == 'deletecolours') {
	include('../../conexion.php');
	$data = new Database();
	$count  =  $data->delete(" colour ", "colour_id = ".$_POST['colid']);
	echo 1;
	exit;
}

?>
<div class="medium-12 columns">
	<hr>
</div>
<div class="medium-12 columns" id='colours'>
	<div class="panel">
		
		<a href="#" class="button tiny right save">Save Colours</a>	
		<a href="#" class="button tiny right add">Add Colour</a>	
		<h3>Colours</h3>
		
		<div class="clear"></div>
		<?php 
		$data = new Database();
		$where = 'colour_productid = '.$_GET['id'];
		$count  =  $data->select(" * ", " colour ", $where);
		while($r = $data->getObjectResults()){ ?>
			<div class="color medium-3 columns end">
				<div class="row collapse">
						<div class="medium-3 columns">
							<input type="color" class="color1" value='<?php echo $r->colour_value1;?>'>
						</div>
						<div class="medium-3 columns end">
							<input type="color" class="color2" value='<?php echo $r->colour_value2;?>'>
						</div>
						<div class="medium-3 columns">
							<a href="#" class="button tiny alert">Delete</a>
						</div>
						<input type="hidden" class="id" value='<?php echo $r->colour_id;?>'>
				</div>
			</div>
		<?php }
		?>

		
		<div class='row' id="colourscontent"></div>
		

	</div>
	
</div>

<script src='includes/fields/colours/spectrum.js'></script>
<link rel='stylesheet' href='includes/fields/colours/spectrum.css' />
<script>
$(".color1").spectrum({
	preferredFormat: "hex"
});
$(".color2").spectrum({
	preferredFormat: "hex"
});

$('#colours').on('click','.alert',function (e) {
	var col = $(this).parents('.color');
	var id = $('.id',col).val();
	e.preventDefault();
	$.post("includes/fields/colours/index.php", 
	    { 
	      action: "deletecolours",
	      colid: id
	    },
	    function(data){
	        alert('Colour deleted'); // John
	        $(col).slideUp();
	        console.log(data); //  2pm
	    }
	);
});


$('#colours .add').click(function (e) {
	$('#colourscontent').append('\
		<div class="color medium-3 columns end">\
			<div class="row collapse">\
					<div class="medium-3 columns">\
						<input type="color" class="color1">\
					</div>\
					<div class="medium-3 columns end">\
						<input type="color" class="color2">\
					</div>\
					<input type="hidden" class="id">\
			</div>\
		</div>');
	$(".color1").spectrum({
		preferredFormat: "hex"
	});
	$(".color2").spectrum({
		preferredFormat: "hex"
	});
	e.preventDefault();
});
$('#colours .save').click(function (e) {
	colours = [];
	$('.color').each(function() {
		var col = {};
		col.col1 = $('.color1',this).val();
		col.col2 = $('.color2',this).val();
		col.idd = $('.id',this).val();
		colours.push(col);
	});
	//console.log(colours);

	e.preventDefault();
	$.post("includes/fields/colours/index.php", 
	    { 
	      action: "updatecolours",
	      colours:  JSON.stringify(colours),
	      postid: <?php echo $_GET['id'];?>
	    },
	    function(data){
	        alert('Colours updated'); // John
	        
	        obj = JSON.parse(data);
	        //console.log(obj); //  2pm
	        var a = 0;
	        $(obj).each(function() {
	        	a++;
	        	console.log(this);
	        	$('.color:eq('+a+') .id').val(this);
	        });
	    }
	);
});
</script>