<?php 
$menu_active = 'shop'; // menu id
include('includes/header.php');

/***************** EDIT ***************/

$fields = array();

$fields[] = array(
'name' => 'Status',
'field' => 'post_title',
'type' => 'checkbox',
'columns' => 12,
//'meta' => true,
//'encrypted' => 1
);

$fields[] = array(
'name' => 'Message',
'field' => 'post_content',
'type' => 'text',
'columns' => 12,
//'meta' => true,
//'encrypted' => 1
);




$fields[] = array(
'field' => 'post_type',
'type' => 'hidden',
'value' => 'shopstatus'
);




        
/***************** END EDIT ***************/


/***************** LIST ***************/

$list = array();

/***************** END LIST ***************/
    
    
/***************** GLOBAL ***************/  
    
$title = 'Shop Status';
$title_singular = 'Shop Status';
        

$extras = array();
$extras['table'] = 'post';
$extras['id'] = 'post_id';
//$extras['table_state'] = 'post_state';
$extras['table_date'] = 'post_date';
$extras['per_page'] = 20;
$extras['order'] = 'post_order DESC';

$extras['table_order'] = 'post_order'; // activate drag and drop order
$extras['list_where'] = ' post_type = "shopstatus" '; //custom where for listings
//$extras['widelist'] = 1; // fluid container
//$extras['readonly'] = 1;
        
$extras['page'] = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0;


$extras['singlepage'] = 1; //make sure posttype is unique and list_where is set


/************* search ***************/

/***************** END GLOBAL ***************/              
        
    
  
/***************** DO NOT TOUCH THIS ***************/      
makeallhappend();
/***************** DO NOT TOUCH THIS ***************/      

?>
<!--  spac for custom scripts  -->
<?php include('includes/footer.php');