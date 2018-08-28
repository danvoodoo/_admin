<?php 
$menu_active = 'post'; // menu id

include('includes/header.php');

/***************** EDIT ***************/

$fields = array();

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

$options = array(''=>'Category');
$data = new Database();
$where = 'cat_type = "category"';
$count  =  $data->select(" * ", " categories ", $where);
while($r = $data->getObjectResults()){
    $options [$r->cat_slug] = $r->cat_name;
}
$fields[] = array(
'name' => 'Category',
'field' => 'post_category',
'type' => 'select', // checkboxes
'values' => $options,
'columns' => 12
);


$options = array();
$data = new Database();
$where = 'cat_type = "tag"';
$count  =  $data->select(" * ", " categories ", $where);
while($r = $data->getObjectResults()){
    $options [$r->cat_url] = $r->cat_name;
}
$fields[] = array(
'name' => 'Tags',
'field' => 'post_category',
'type' => 'taxonomy',
'taxtype' => 'tag', 
'values' => $options,
'columns' => 6
);


$fields[] = array(
'name' => 'Extract',
'field' => 'post_excerpt',
'type' => 'textarea',
'height' => 100,
'columns' => 12,
//'meta' => true
);

$fields[] = array(
'name' => 'Content',
'field' => 'post_content',
'type' => 'textareamce',
'height' => 100,
'columns' => 12,
//'meta' => true
);



$fields[] = array(
'field' => 'post_type',
'type' => 'hidden',
'value' => 'post'
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
        'name' => 'Comments',
        'field' => 'post_id',
        'type' => 'comments',
        'width' => 200
);
	
/***************** END LIST ***************/
	
	
/***************** GLOBAL ***************/	
	
$title = 'Posts';
$title_singular = 'Post';
        

$extras = array();
$extras['table'] = 'post';
$extras['id'] = 'post_id';
$extras['table_state'] = 'post_state';
$extras['table_date'] = 'post_date';
$extras['table_date_update'] = 'post_dateupdate';
$extras['per_page'] = 20;
$extras['order'] = 'post_order DESC';

$extras['table_order'] = 'post_order'; // activate drag and drop order
$extras['list_where'] = ' post_type = "post" '; //custom where for listings
//$extras['widelist'] = 1; // fluid container
//$extras['readonly'] = 1;
$extras['post_type'] = 'post';

$extras['preview'] = 'blog/%url';
		
$extras['page'] = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0;
		


/************ filters ***************/
$extras['filters'] = array();

//getting filter options from database
$values = array();
$data = new Database();
$where = '';
$count  =  $data->select(" * ", " categories ", $where);
while($r = $data->getObjectResults()){
        $values[ $r->cat_id ] = $r->cat_name;
}
$extras['filters'][] = array(
        'label' => 'Category',
        'column_name' => 'post_category',
        'equal' => '=',
        'values' => $values
);

//manual filter options
$values = array(
        'a%' => 'A',
        'b%' => 'B',
);
$extras['filters'][] = array(
        'label' => 'Title',
        'column_name' => 'post_title',
        'equal' => 'LIKE',
        'values' => $values
);

//datepicker filter
$extras['filters'][] = array( 
        'label' => 'Date',
        'column_name' => 'b_date',
        'equal' => '=',
        'datepicker' => true
);

/************ filters ***************/

/************* search ***************/
$extras['search'] = array(
        'placeholder' => 'Search by title and content',
        'fields' => array('post_title', 'post_content')
);

$extras['metasearch'] = array(0,1); //by key, if its a meta field or not

/***************** END GLOBAL ***************/      		
		
	
		

/***************** DO NOT TOUCH THIS ***************/      
makeallhappend();
/***************** DO NOT TOUCH THIS ***************/      

?>
<!--  spac for custom scripts  -->
<?php include('includes/footer.php');