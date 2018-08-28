<?php 
$_GET['id'] = 37;
unset($_GET['list']);

$menu_active = 'shop'; // menu id

include('includes/header.php');

/***************** EDIT ***************/

$fields = array();

$fields[] = array(
'name' => 'Delivery days',
'field' => 'post_content',
'type' => 'deliverydays',
'columns' => 12,
//'meta' => true,
//'encrypted' => 1
);





$fields[] = array(
'field' => 'post_type',
'type' => 'hidden',
'value' => 'deliveryday'
);




        
/***************** END EDIT ***************/


/***************** LIST ***************/

$list = array();

/***************** END LIST ***************/
    
    
/***************** GLOBAL ***************/  
    
$title = 'Delivery days';
$title_singular = 'Delivery days';
        

$extras = array();
$extras['table'] = 'post';
$extras['id'] = 'post_id';
//$extras['table_state'] = 'post_state';
$extras['table_date'] = 'post_date';
$extras['per_page'] = 20;
$extras['order'] = 'post_order DESC';

$extras['table_order'] = 'post_order'; // activate drag and drop order
$extras['list_where'] = ' post_type = "deliveryday" '; //custom where for listings
//$extras['widelist'] = 1; // fluid container
//$extras['readonly'] = 1;

        
$extras['page'] = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0;
        


/************* search ***************/

/***************** END GLOBAL ***************/              
        
    
  
/***************** DO NOT TOUCH THIS ***************/      
makeallhappend();
/***************** DO NOT TOUCH THIS ***************/      

?>
<!--  spac for custom scripts  -->
<?php include('includes/footer.php');