<?php 
$menu_active = 'shop'; // menu id

include('includes/header.php');

/***************** PARAMETROS PARA FORM DE EDICION ***************/

        $fields = array();
        
                
        /*INPUT DE TEXTO*/
        $fields[] = array(
                        'name' => 'Title',
                        'field' => 'post_title',
                        'type' => 'text'
                        //'encrypted' => 1
                        );


                
                $fields[] = array(
                        'name' => 'Price',
                        'field' => 'post_content',
                        'type' => 'text',
                        'height' => 300
                        //'encrypted' => 1
                        );


                $fields[] = array(
                    'name' => 'Applies to orders from',
                    'field' => 'post_from',
                    'type' => 'text',
                    'columns' => 12,
                    'meta' => 1
                    //'encrypted' => 1
                    );



                 $fields[] = array(
                    'name' => 'Applies to orders to',
                    'field' => 'post_to',
                    'type' => 'text',
                    'columns' => 12,
                    'meta' => 1
                    //'encrypted' => 1
                    );



                 $fields[] = array(
                    'name' => 'Weight from',
                    'field' => 'post_weightfrom',
                    'type' => 'text',
                    'columns' => 6,
                    'meta' => 1
                    //'encrypted' => 1
                    );

                 $fields[] = array(
                    'name' => 'Weight to',
                    'field' => 'post_weightto',
                    'type' => 'text',
                    'columns' => 6,
                    'meta' => 1
                    //'encrypted' => 1
                    );



                $fields[] = array(
                        'name' => 'Valid for postcodes (comma separated, leave empty for any postcode)',
                        'field' => 'post_postcodes',
                        'type' => 'text',
                        'height' => 300,
                        'meta' => 1
                        //'encrypted' => 1
                        );
                
                /*INPUT DE TEXTO*/
        $fields[] = array(
                        'name' => 'Type',
                        'field' => 'post_type',
                        'type' => 'hidden',
                        'value' => 'shipping'
                        //'encrypted' => 1
                        );
        
/***************** PARAMETROS PARA FORM DE EDICION ***************/


/***************** PARAMETROS PARA LISTA ***************/

        $list = array();

        $list[] =  array(
                        'name' => 'Name',
                        'field' => 'post_title',
                        'type' => 'text',
                        'width' => 200
                        );


          $list[] = array(
                        'name' => 'Price',
                        'field' => 'post_content',
                        'type' => 'text',
                        'height' => 300
                        ,'width' => 100
                        //'encrypted' => 1
                        );


                $list[] = array(
                    'name' => 'Applies to orders from',
                    'field' => 'post_from',
                    'type' => 'text',
                    'columns' => 12,
                    'meta' => 1
                    ,'width' => 100
                    //'encrypted' => 1
                    );



                 $list[] = array(
                    'name' => 'Applies to orders to',
                    'field' => 'post_to',
                    'type' => 'text',
                    'columns' => 12,
                    'meta' => 1
                    ,'width' => 100
                    //'encrypted' => 1
                    );



                 $list[] = array(
                    'name' => 'Weight from',
                    'field' => 'post_weightfrom',
                    'type' => 'text',
                    'columns' => 6,
                    'meta' => 1
                    ,'width' => 100
                    //'encrypted' => 1
                    );

                 $list[] = array(
                    'name' => 'Weight to',
                    'field' => 'post_weightto',
                    'type' => 'text',
                    'columns' => 6,
                    'meta' => 1
                    ,'width' => 100
                    //'encrypted' => 1
                    );



                $list[] = array(
                        'name' => 'Valid for postcodes',
                        'field' => 'post_postcodes',
                        'type' => 'text',
                        'height' => 300,
                        'meta' => 1
                        ,'width' => 100
                        //'encrypted' => 1
                        );
/***************** PARAMETROS PARA LISTA ***************/
    
    
/***************** PARAMETROS GENERALES ***************/    
    
$title = 'Shipping';
$title_singular = 'Shipping';

        $extras = array();
        $extras['table'] = 'post';
        $extras['id'] = 'post_id';
        $extras['table_state'] = 'post_state';
        /*$extras['table_fecha'] = 'post_date';*/
        $extras['per_page'] = 20;
        $extras['order'] = 'post_date DESC';
        $extras['post_type'] = 'shipping';
                
        $extras['list_where'] = ' post_type = "shipping"'; //custom where para listados
        
        $extras['page'] = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0;
        
        
        /*filtro para lista*/
        //$extras['filtro'] = array();
        //$extras['filtro'][] = array('Area','sectores_idArea','db','pos_area','area_id','area_detalle','');
        //label, campo, tipo, tabla de parametro, valor de parametro, label de parametro, WHERE para filtrar parametros
        
        
/***************** PARAMETROS GENERALES ***************/            
       

/***************** DO NOT TOUCH THIS ***************/      
makeallhappend();
/***************** DO NOT TOUCH THIS ***************/      

?>
<!--  spac for custom scripts  -->
<?php include('includes/footer.php');?>