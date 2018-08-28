<?php 

$menu_active = 'shop'; // menu id

include('includes/header.php');




function aftersave($id) {

    foreach ($_POST['products'] as $p) {
        
        $data = new Database();
        $arr = array(
                   'prod_parent' => $id,
                   'prod_title' => $p['title'],
                   'prod_price' => $p['price'],
                   'prod_stock' => $p['stock'],
                   );
        if ( $p['type'] == 'new' )  {
            $count  =  $data->insert(" products ", $arr);    
        } else if ( $p['type'] == 'update' )  {
            $count  =  $data->update(" products ", $arr, 'prod_id = '.$p['id']);    
        } else if ( $p['type'] == 'remove' AND isset($p['id']) )  {
            $count  =  $data->delete(" products ", 'prod_id = '.$p['id']);    

        }

    }
    

}

/***************** EDIT ***************/

$fields = array();

$fields[] = array(
'name' => 'Title',
'field' => 'prod_title',
'type' => 'text',
'columns' => 12,
//'meta' => true,
//'encrypted' => 1
);



$fields[] = array(
'name' => 'URL',
'field' => 'prod_url',
'type' => 'url',
'columns' => 12,
'name_field' => 'prod_title'
);

$fields[] = array(
'name' => 'Photo',
'field' => 'prod_photo',
'type' => 'photo',
//'meta' => true
);
/*
$fields[] = array(
'name' => 'Show picture notice',
'field' => 'showpicturenotice',
'type' => 'checkbox',
'columns' => 12,
'meta' => true
//'encrypted' => 1
);
*/

$options = [];
$data = new Database();
$where = 'cat_type = "shop" AND cat_parent = 0';
$count  =  $data->select(" * ", " categories ", $where);
while($r = $data->getObjectResults()){
    $options [$r->cat_url] = [
        'label' => $r->cat_name,
        'subvalues' => []
        ];
    $data2 = new Database();
    $where = 'cat_type = "shop" AND cat_parent = '.$r->cat_id;
    $count  =  $data2->select(" * ", " categories ", $where);
    while($rr = $data2->getObjectResults()){
        $options[$r->cat_url]['subvalues'][$rr->cat_url] = $rr->cat_name;
    }

}

$fields[] = array(
'name' => 'Category',
'field' => 'prod_category',
'type' => 'checkboxesmultiple', // checkboxes
'values' => $options,
'columns' => 12
);


$fields[] = array(
'name' => 'Description',
'field' => 'prod_excerpt',
'type' => 'textareamce',
'height' => 100,
'columns' => 12,
//'meta' => true
);



/*
$fields[] = array(
'name' => 'Show delivery charge notice',
'field' => 'showdeliverynotice',
'type' => 'checkbox',
'columns' => 12,
'meta' => true,
//'encrypted' => 1
);
*/

$fields[] = array(
'name' => 'Variants',
'type' => 'variants',
'columns' => 12,
//'meta' => true
);







		
/***************** END EDIT ***************/


/***************** LIST ***************/

$list = array();
$list[] =  array(
        'name' => 'Photo',
        'field' => 'prod_photo',
        'type' => 'photo',
        'width' => 100,
        'folder' => '../photos',
        'prefix' => '200_200_'
);
              
$list[] =  array(
        'name' => 'Name',
        'field' => 'prod_title',
        'type' => 'text',
        'width' => 200
);

$list[] =  array(
        'name' => 'Stock',
        'field' => 'prod_stock',
        'type' => 'text',
        'width' => 200
);


$list[] =  array(
        'name' => 'URL',
        'field' => 'prod_url',
        'type' => 'url',
        'width' => 200
);



/***************** END LIST ***************/
	
	
/***************** GLOBAL ***************/	
	
$title = 'Products';
$title_singular = 'Product';
        

$extras = array();
$extras['table'] = 'products';
$extras['id'] = 'prod_id';
$extras['table_state'] = 'prod_state';
$extras['table_date'] = 'prod_date';
$extras['per_page'] = 20;
$extras['order'] = 'prod_order DESC';

$extras['table_order'] = 'prod_order'; // activate drag and drop order
$extras['list_where'] = ' prod_parent = 0 '; //custom where for listings
//$extras['widelist'] = 1; // fluid container
//$extras['readonly'] = 1;
$extras['post_type'] = 'product';

//$extras['preview'] = 'blog/%url';
		
$extras['page'] = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0;
		


/************ filters ***************/
$extras['filters'] = array();

//getting filter options from database
$values = array();
$data = new Database();
$where = 'cat_type="shop" AND cat_parent = 0';
$count  =  $data->select(" * ", " categories ", $where);
while($r = $data->getObjectResults()){
        $values[ $r->cat_url ] = $r->cat_name;

        $data2 = new Database();
        $where = 'cat_type="shop" AND cat_parent = '.$r->cat_id;
        $count  =  $data2->select(" * ", " categories ", $where);
        while($rr = $data2->getObjectResults()){
            $values[ $rr->cat_url ] = ' - '.$rr->cat_name;
        }

}
$extras['filters'][] = array(
        'label' => 'Category',
        'column_name' => 'prod_category',
        'equal' => 'JSONLIKE',
        'values' => $values
);



/************ filters ***************/

/************* search ***************/
$extras['search'] = array(
        'placeholder' => 'Search by title and content',
        'fields' => array('prod_title', 'prod_excerpt')
);

/***************** END GLOBAL ***************/      		
		
	
		

/***************** DO NOT TOUCH THIS ***************/      
makeallhappend();
/***************** DO NOT TOUCH THIS ***************/      

?>
<!--  spac for custom scripts  -->
<?php include('includes/footer.php');