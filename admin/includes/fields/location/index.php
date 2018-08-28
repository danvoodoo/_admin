<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" language="javascript" src="<?php echo SITEURL;?>admin/includes/fields/location/jquery.gomap-1.3.2.js"></script>

<?php
if (isset($r)) $v = $r[$field['field']]; else $v ='';
?>
<?php if (!isset($field['columns'])) $field['columns'] = 12;?>
<div class="medium-<?php echo $field['columns'];?> columns">
	<label for=""><?php echo $field['name'];?></label>
	
	<div class='mapselect' id="map_<?php echo $field['field'];?>"></div>

    <textarea name="<?php echo $field['field'];?>" id="" cols="30" rows="10"><?php echo $v;?></textarea>
	
</div>


<style>
.mapselect{
	height: 300px;
}
</style>
<script>
$(document).ready(function () {

    $("#map_<?php echo $field['field'];?>").goMap({ 
        address: '<?php echo $field['center'];?>', 
        zoom: 10
        <?php
        if ( $v != '' ) { 

            $maps = str_replace("'", '"', stripslashes($v));
            $maps = json_decode( $maps , true);
            if ( isset( $maps['markers'][0] )  ) { 
                $mapcoor = explode(',',$maps['markers'][0]);
                
                ?>
                ,
                 markers: [{  
                    latitude: <?php echo $mapcoor[0];?>, 
                    longitude: <?php echo $mapcoor[1];?>,
                    draggable: true
                }]
            <?php } else { //has record, but dont have the coordinates?> 
                , addMarker: 'single' <?php  }
         } else { //new record?>
        , addMarker: 'single'
        <?php } ?>
    }); 

$('.save.btn').click(function () {
    $('[name="<?php echo $field['field'];?>"]').val($.goMap.getMarkers("json")); 
    });
    



    

});
</script>