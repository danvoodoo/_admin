<td>
<?php 
if ($field['folder'] != "")
	$folder = $field['folder']."/";
else
	$folder = "";
						
if (isset($field['prefix']))	$folder.= $field['prefix'];
				
if ($r[$field['field']] != '')
	echo '<span class="'.$field['field'] .'"><img src="'.$folder.$r[$field['field']].'" width="'.$field['width'].'"/></span> ';
else
echo "<div style='width: ".$field['width']."px; height: 50px; float: left; padding: 5px 5px 0 0'></div>";
?>
</td>