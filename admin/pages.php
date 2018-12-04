<?php 
$menu_active = 'pages'; // menu id

include('includes/header.php');

/***************** EDIT ***************/

$fields = array();

$fields[] = array(
'name' => 'Meta Title',
'field' => 'meta_title',
'type' => 'text',
'columns' => 6
);

$fields[] = array(
'name' => 'Meta Description',
'field' => 'meta_desc',
'type' => 'textarea',
'columns' => 6
);

$fields[] = array(
'name' => 'Title',
'field' => 'post_title',
'type' => 'text',
'columns' => 12,
//'meta' => true,
//'encrypted' => 1
);


$fields[] = array(
'name' => 'URL',
'field' => 'post_url',
'type' => 'url',
'columns' => 12,
'name_field' => 'post_title'
);

$fields[] = array(
'name' => 'Photo',
'field' => 'post_photo',
'type' => 'photo',
//'meta' => true
);

$options = array(''=>'Page parent');
$data = new Database();
$where = 'post_type = "page"';
$count  =  $data->select(" * ", " post ", $where);
if ( isset($_GET['id']) ) { $where .= ' AND post_id != '.$_GET['id']; }
while($r = $data->getObjectResults()){
    $options [$r->post_id] = $r->post_title;
}
$fields[] = array(
'name' => 'Parent',
'field' => 'post_parent',
'type' => 'select', // checkboxes
'values' => $options,
'columns' => 12
);



$fields[] = array(
'name' => 'Content',
'field' => 'post_content',
'type' => 'flexible_content',
'height' => 100,
'columns' => 12,
//'meta' => true
);



$fields[] = array(
'field' => 'post_type',
'type' => 'hidden',
'value' => 'page'
);




        
/***************** END EDIT ***************/


/***************** LIST ***************/

$list = array();
$list[] =  array(
        'name' => 'Photo',
        'field' => 'post_photo',
        'type' => 'photo',
        'width' => 150,
        'folder' => '../photos',
        'prefix' => '200_200_'
);
              
$list[] =  array(
        'name' => 'Name',
        'field' => 'post_title',
        'type' => 'text',
        'width' => 300
);

$list[] =  array(
        'name' => 'URL',
        'field' => 'post_url',
        'type' => 'url',
        'width' => 200
);



$list[] =  array(
        'name' => 'Duplicate',
        'field' => 'post_id',
        'type' => 'duplicate',
        'width' => 200
);
    
/***************** END LIST ***************/
    
    
/***************** GLOBAL ***************/  
    
$title = 'Pages';
$title_singular = 'Page';
        

$extras = array();
$extras['table'] = 'post';
$extras['id'] = 'post_id';
$extras['table_state'] = 'post_state';
$extras['table_date'] = 'post_date';
$extras['per_page'] = 20;
$extras['order'] = 'post_order DESC';

$extras['table_order'] = 'post_order'; // activate drag and drop order
$extras['list_where'] = ' post_type = "page" '; //custom where for listings
//$extras['widelist'] = 1; // fluid container
//$extras['readonly'] = 1;
$extras['post_type'] = 'page'; //for using metas, post_type must be specified
$extras['page_parent'] = 'post_parent';
        
$extras['page'] = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0;
        


/************* search ***************/
$extras['search'] = array(
        'placeholder' => 'Search by title and content',
        'fields' => array('post_title', 'post_content')
);

/***************** END GLOBAL ***************/              
        
    
  
/***************** DO NOT TOUCH THIS ***************/      
makeallhappend();
/***************** DO NOT TOUCH THIS ***************/      

?>
<!--  spac for custom scripts  -->
<?php include('includes/footer.php');
