<?php 
$menu_active = 'post'; // menu id

include('includes/header.php');


/***************** EDIT ***************/

$fields = array();

$fields[] = array(
'name' => 'Name',
'field' => 'cat_name',
'type' => 'text',
'columns' => 12,
//'meta' => true,
//'encrypted' => 1
);

$fields[] = array(
'name' => 'URL',
'field' => 'cat_url',
'type' => 'url',
'columns' => 12,
'name_field' => 'cat_name'
);

$fields[] = array(
'name' => 'Description',
'field' => 'cat_description',
'type' => 'textarea',
'height' => 100,
'columns' => 12,
//'meta' => true
);

$options = array(''=>'Parent Category');
$data = new Database();
$where = 'cat_type = "category"';
if ( isset($_GET['id']) ) { $where .= ' AND cat_id != '.$_GET['id']; }
$count  =  $data->select(" * ", " categories ", $where);
while($r = $data->getObjectResults()){
    $options [$r->cat_id] = $r->cat_name;
}

$fields[] = array(
'name' => 'Parent',
'field' => 'cat_parent',
'type' => 'select', // checkboxes
'values' => $options,
'columns' => 12
);


$fields[] = array(
'field' => 'cat_type',
'type' => 'hidden',
'value' => 'category'
);



		
/***************** END EDIT ***************/


/***************** LIST ***************/


$list = array();
$list[] = array(
'name' => 'Name',
'field' => 'cat_name',
'type' => 'text',
'width' => 300
);

		
		
/***************** END LIST ***************/
	
	
/***************** GLOBAL ***************/	

$title = 'Categories';
$title_singular = 'Category';
      
$extras = array();
$extras['table'] = 'categories';
$extras['id'] = 'cat_id';
$extras['table_state'] = 'cat_state';
$extras['table_date'] = 'cat_date';
$extras['per_page'] = 20;
$extras['order'] = 'cat_order DESC';
$extras['table_order'] = 'cat_order';
$extras['list_where'] = ' cat_type = "category" ';


$extras['page'] = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0;
		



/************* search ***************/
$extras['search'] = array(
        'placeholder' => 'Search by title and content',
        'fields' => array('cat_title')
        );

/***************** END GLOBAL ***************/      		
		


/***************** DO NOT TOUCH THIS ***************/      
makeallhappend();
/***************** DO NOT TOUCH THIS ***************/      

?>
<!--  spac for custom scripts  -->
<?php include('includes/footer.php');?>