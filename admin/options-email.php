<?php
$menu_active = 'options'; 
include('includes/header.php');


/***************** EDIT PARAMETERS ***************/

$fields = array();


if (!isset($_GET['id'])) {



    $fields[] = array(
    'name' => 'Field Name',
    'field' => 'post_url',
    'type' => 'text'
    //'encrypted' => 1
    );

}


    $fields[] = array(
    'name' => 'Subject',
    'field' => 'post_title',
    'type' => 'text'
    //'encrypted' => 1
    );

$fields[] = array(
'name' => 'Content. You can use {name} {lastname} {email} {id} {notes} {shippingcode} tags.',
'field' => 'post_content',
'type' => 'textarea',
'height' => 300
//'encrypted' => 1
);



$fields[] = array(
'name' => 'Type',
'field' => 'post_type',
'type' => 'hidden',
'value' => 'optionemail'
//'encrypted' => 1
);

/***************** EDIT PARAMETERS ***************/


/***************** LIST PARAMETERS ***************/

        $list = array();


        $list[] =  array(
                        'name' => 'Subject',
                        'field' => 'post_title',
                        'type' => 'text',
                        'width' => 300
                        );

                $list[] =  array(
                        'name' => 'Field name',
                        'field' => 'post_url',
                        'type' => 'text',
                        'width' => 100
                        );


/***************** LIST PARAMETERS ***************/


/***************** GENERAL PARAMETERS ***************/
$title = 'Email options';
$title_singular = 'Email options';

$extras = array();
$extras['table'] = 'post';
$extras['id'] = 'post_id';
$extras['table_state'] = 'post_state';
$extras['table_date'] = 'post_date';
$extras['per_page'] = 20;
$extras['order'] = 'post_title ASC';
               /* $extras['table_order'] = 'post_order';*/

$extras['list_where'] = ' post_type = "optionemail" '; //
$extras['post_type'] = 'option' ;

$extras['page'] = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0;




/***************** DO NOT TOUCH THIS ***************/      
makeallhappend();
/***************** DO NOT TOUCH THIS ***************/      

?>
<!--  spac for custom scripts  -->
<?php include('includes/footer.php');