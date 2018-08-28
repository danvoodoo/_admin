<?php
$menu_active = 'options'; 
include('includes/header.php');


/***************** EDIT PARAMETERS ***************/

$fields = array();


if (!isset($_GET['id']) OR isset($_GET['edit'])) {
    $fields[] = array(
    'name' => 'Title',
    'field' => 'post_title',
    'type' => 'text'
    //'encrypted' => 1
    );


    $fields[] = array(
    'name' => 'Field Name',
    'field' => 'post_url',
    'type' => 'text'
    //'encrypted' => 1
    );

    $options = array(
        'text' => 'Text',
        'textarea' => 'Textarea',
        'wysywyg' => 'Wysywyg',
        'image' => 'Image',
        );

        $fields[] = array(
        'name' => 'Type',
        'field' => 'post_excerpt',
        'type' => 'select',
        'values' => $options,
        'columns' => 12
        );

         $fields[] = array(
            'name' => 'Content',
            'field' => 'post_content',
            'type' => 'text',
            'height' => 300
            //'encrypted' => 1
            );

        $fields[] = array(
            'name' => 'Image',
            'field' => 'post_photo',
            'type' => 'photo'
            //'encrypted' => 1
            );

} else {
    $data = new Database();
    $where = 'post_type = "option" AND  post_id = '.$_GET['id'];
    $count  =  $data->select(" * ", " post ", $where);
    $r = $data->getObjectResults();


    if ( $r->post_excerpt == 'text' ) {
        $fields[] = array(
            'name' => 'Content',
            'field' => 'post_content',
            'type' => 'text',
            'height' => 300
            //'encrypted' => 1
            );
    }

    if ( $r->post_excerpt == 'textarea' ) {
        $fields[] = array(
            'name' => 'Content',
            'field' => 'post_content',
            'type' => 'textarea',
            'height' => 300
            //'encrypted' => 1
            );
    }

     if ( $r->post_excerpt == 'wysywyg' ) {
        $fields[] = array(
            'name' => 'Content',
            'field' => 'post_content',
            'type' => 'textareamce',
            'height' => 300
            //'encrypted' => 1
            );
    }

    if ( $r->post_excerpt == 'image' ) {
        $fields[] = array(
            'name' => 'Image',
            'field' => 'post_photo',
            'type' => 'photo'
            //'encrypted' => 1
            );

    }
}




$fields[] = array(
'name' => 'Type',
'field' => 'post_type',
'type' => 'hidden',
'value' => 'option'
//'encrypted' => 1
);

/***************** EDIT PARAMETERS ***************/


/***************** LIST PARAMETERS ***************/

        $list = array();


        $list[] =  array(
                        'name' => 'Name',
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
$title = 'Options';
$title_singular = 'Option';

$extras = array();
$extras['table'] = 'post';
$extras['id'] = 'post_id';
$extras['table_state'] = 'post_state';
$extras['table_date'] = 'post_date';
$extras['per_page'] = 20;
$extras['order'] = 'post_title ASC';
               /* $extras['table_order'] = 'post_order';*/

$extras['list_where'] = ' post_type = "option" '; //
$extras['post_type'] = 'option' ;

$extras['page'] = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0;




/***************** DO NOT TOUCH THIS ***************/      
makeallhappend();
/***************** DO NOT TOUCH THIS ***************/      

?>
<!--  spac for custom scripts  -->
<?php include('includes/footer.php');