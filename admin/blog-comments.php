<?php 
$menu_active = 'post'; // menu id

include('includes/header.php');



/***************** EDIT ***************/

		$fields = array();
		
		$fields[] = array(
                        'name' => 'Name',
                        'field' => 'co_name',
                        'type' => 'text',
                        'default' => $_SESSION['name']
                        //'encrypted' => 1
                        );


        $fields[] = array(
                        'name' => 'Email',
                        'field' => 'co_email',
                        'type' => 'text',
                        'default' => $_SESSION['email']
                        //'encrypted' => 1
                        );


		
                
                $fields[] = array(
                        'name' => 'Comment',
                        'field' => 'co_comment',
                        'type' => 'textarea',
                        'height' => 100
                        //'encrypted' => 1
                        );


                $options = array();
$data = new Database();
$where = 'post_type = "post"';
$count  =  $data->select(" * ", " post ", $where, 'post_id DESC');
while($r = $data->getObjectResults()){
    $options [$r->post_id] = $r->post_title;
}

$fields[] = array(
'name' => 'Post',
'field' => 'co_post',
'type' => 'select',
'values' => $options,
'first_item_label' => 'Select Product',
'columns' => 12
);

                

                
/***************** END EDIT ***************/


/***************** LIST ***************/

		$list = array();
                
		$list[] =  array(
                        'name' => 'Name',
                        'field' => 'co_name',
                        'type' => 'text',
                        'width' => 300
                        );

        $list[] =  array(
                        'name' => 'Email',
                        'field' => 'co_email',
                        'type' => 'text',
                        'width' => 300
                        );
		
		
/***************** END LIST ***************/
	
	
/***************** GLOBAL ***************/	
	
                $title = 'Comments';
                $title_singular = 'Comment';
        

		$extras = array();
		$extras['table'] = 'comments';
		$extras['id'] = 'co_id';
		$extras['table_state'] = 'co_state';
		$extras['table_date'] = 'co_date';
		$extras['per_page'] = 20;
		$extras['order'] = 'co_id DESC';

        $extras['page_parent'] = 'co_parent'; 

                //$extras['table_order'] = 'post_order'; // activate drag and drop order
                //$extras['widelist'] = 1; // fluid container
        if ( isset($_GET['post']) ) {
                $extras['list_where'] = ' co_post = '.$_GET['post'].' '; //custom where for 
            }
                //$extras['readonly'] = 1;
		
		$extras['page'] = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0;




                /************* search ***************/
                $extras['search'] = array(
                        'placeholder' => 'Search by name or comment',
                        'fields' => array('co_name', 'co_comment')
                        );

/***************** END GLOBAL ***************/      		
		
	
		

/***************** DO NOT TOUCH THIS ***************/      
makeallhappend();
/***************** DO NOT TOUCH THIS ***************/      

?>
<!--  spac for custom scripts  -->
<?php include('includes/footer.php');