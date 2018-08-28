<?php

$menu_active = 'shop';
include('includes/header.php');



function aftersave($id) {
    $data = new Database();
    $where = 'or_id = '.$id;
    $count  =  $data->select(" * ", " orders ", $where);
    $r = $data->getObjectResults();

    if ( $r->or_laststatus != $r->or_status ) {
        //if status didnt change, do nothing

        $data = new Database();
        $arr = array(
            'or_laststatus' => $r->or_status
        );
        $count  =  $data->update(" orders ", $arr, $where);

        $data = new Database();
        $where = 'post_type = "optionemail" AND post_state = 1 AND post_url = "order_'.$r->or_status.'"';
        $count  =  $data->select(" * ", " post ", $where);
        if ( $count == 1 ){
            $emailtemplate = $data->getObjectResults();

            foreach ( array_keys((array)$r) as $value) {
                $value = str_replace('or_', '', $value);
                $emailtemplate->post_title = str_replace('{'.$value.'}', $r->{'or_'.$value}, $emailtemplate->post_title);
                $emailtemplate->post_content = str_replace('{'.$value.'}', $r->{'or_'.$value}, $emailtemplate->post_content);                    
            }
            $msgSub  = $emailtemplate->post_title;
            $msg = nl2br($emailtemplate->post_content);
            $msgTo = $r->or_email;  
            $htmlemail = 1;
            include("notify/index.php");
        }
       // exit;

    }

}


/***************** PARAMETROS PARA FORM DE EDICION ***************/

        $fields = array();




global $status;
        $fields[] = array(
            'name' => 'Status',
            'field' => 'or_status',
            'type' => 'select',
            'values' => $status,
            'columns' => 4
            );






$options = array(''=>'Guest');
$data = new Database();
$where = '';
$count  =  $data->select(" * ", " site_users ", $where);
while($r = $data->getObjectResults()){
    $options [$r->us_id] = $r->us_name.' - '.$r->us_email;
}

$fields[] = array(
'name' => 'User',
'field' => 'or_user',
'type' => 'select', // checkboxes
'values' => $options,
'columns' => 4,
'width' => 150
);



$fields[] = array(
'name' => 'Tracking number',
'field' => 'or_shippingcode',
'type' => 'text',
'columns' => 4,
//'meta' => true,
//'encrypted' => 1
);
       


        $fields[] = array(
            'title' => 'Recipient info',
            'type' => 'title',
            'columns' => 12
        );
        
                
        /*INPUT DE TEXTO*/
        $fields[] = array(
                        'name' => 'Name',
                        'field' => 'or_name',
                        'type' => 'text',
                        'columns' => 4
                        //'encrypted' => 1
                        );

                        $fields[] = array(
                        'name' => 'Surname',
                        'field' => 'or_lastname',
                        'type' => 'text',
                        'columns' => 4
                        //'encrypted' => 1
                        );




                $fields[] = array(
'name' => 'Email',
'field' => 'or_email',
'type' => 'text',
'columns' => 4
//'encrypted' => 1
);


                $fields[] = array(
'name' => 'Recipient Address',
'field' => 'or_address',
'type' => 'text',
'columns' => 4
//'encrypted' => 1
);

                $fields[] = array(
'name' => 'City',
'field' => 'or_city',
'type' => 'text',
'columns' => 4
//'encrypted' => 1
);

                $fields[] = array(
'name' => 'Postcode',
'field' => 'or_cp',
'type' => 'text',
'columns' => 4
//'encrypted' => 1
);




                $fields[] = array(
'name' => 'County',
'field' => 'or_county',
'type' => 'text',
'columns' => 4
//'encrypted' => 1
);

                 $fields[] = array(
'name' => 'Country',
'field' => 'or_country',
'type' => 'text',
'columns' => 4
//'encrypted' => 1
);
                $fields[] = array(
'name' => 'Phone',
'field' => 'or_phone',
'type' => 'text',
'columns' => 4
//'encrypted' => 1
);








                                $fields[] = array(
'name' => 'Registration documents',
'field' => 'or_documents',
'type' => 'regdocs',
'columns' => 12
//'encrypted' => 1
);




                                $fields[] = array(
'name' => 'Special instructions',
'field' => 'or_notes',
'type' => 'text',
'columns' => 12
//'encrypted' => 1
);


                                        $options = array(''=>'Select shipping');
$data = new Database();
$where = 'post_type = "shipping"';
$count  =  $data->select(" * ", " post ", $where);
while($r = $data->getObjectResults()){
    $options [$r->post_id] = $r->post_title;
}

$fields[] = array(
'name' => 'Shipping method',
'field' => 'or_shipping',
'type' => 'select', // checkboxes
'values' => $options,
'columns' => 12,
'width' => 150
);





/*
                                                $fields[] = array(
'name' => 'Card message',
'field' => 'or_message',
'type' => 'text',
'columns' => 12
//'encrypted' => 1
);
*/

$fields[] = array(
'name' => 'Cart',
'type' => 'cart',
'columns' => 12
//'encrypted' => 1
);

          

            
    


                $fields[] = array(
            'title' => 'Billing info',
            'type' => 'title',
            'columns' => 12
        );
        
                
        /*INPUT DE TEXTO*/
        $fields[] = array(
                        'name' => 'Name',
                        'field' => 'or_bill_name',
                        'type' => 'text',
                        'columns' => 4
                        //'encrypted' => 1
                        );

                        $fields[] = array(
                        'name' => 'Surname',
                        'field' => 'or_bill_lastname',
                        'type' => 'text',
                        'columns' => 4
                        //'encrypted' => 1
                        );


                


                $fields[] = array(
'name' => 'Email',
'field' => 'or_bill_email',
'type' => 'text',
'columns' => 4
//'encrypted' => 1
);


                $fields[] = array(
'name' => 'Address',
'field' => 'or_bill_address',
'type' => 'text',
'columns' => 4
//'encrypted' => 1
);

                $fields[] = array(
'name' => 'City',
'field' => 'or_bill_city',
'type' => 'text',
'columns' => 4
//'encrypted' => 1
);

                $fields[] = array(
'name' => 'Postcode',
'field' => 'or_bill_cp',
'type' => 'text',
'columns' => 4
//'encrypted' => 1
);

                $fields[] = array(
'name' => 'County',
'field' => 'or_bill_county',
'type' => 'text',
'columns' => 4
//'encrypted' => 1
);

                 $fields[] = array(
'name' => 'Country',
'field' => 'or_bill_country',
'type' => 'text',
'columns' => 4
//'encrypted' => 1
);
                $fields[] = array(
'name' => 'Phone',
'field' => 'or_bill_phone',
'type' => 'text',
'columns' => 4
//'encrypted' => 1
);
            

    

        
/***************** PARAMETROS PARA FORM DE EDICION ***************/


/***************** PARAMETROS PARA LISTA ***************/

        $list = array();
          
           $list[] =  array(
                        'name' => 'ID',
                        'field' => 'or_id',
                        'type' => 'text',
                        'width' => 50
                        );

        
        $list[] =  array(
                        'name' => 'Name',
                        'field' => 'or_name',
                        'type' => 'text',
                        'width' => 100
                        );
        
        $list[] =  array(
                        'name' => 'Surname',
                        'field' => 'or_lastname',
                        'type' => 'text',
                        'width' => 100
                        );
        
                
        $list[] =  array(
                        'name' => 'Amount',
                        'field' => 'or_total',
                        'type' => 'text',
                        'width' => 60
                        );


              
    
        
                
        $list[] =  array(
                        'name' => 'Date',
                        'field' => 'or_date',
                        'type' => 'date',
                        'width' => 100
                        );

/*
        $list[] = array(
'name' => 'Delivery date',
'field' => 'or_deliverydate',
'type' => 'date',
'width' => 100,
//'meta' => true,
//'encrypted' => 1
);
*/

/*
         $list[] = array(
'name' => 'Collect in person',
'field' => 'or_collect',
'type' => 'checkbox',
                        'labels'=> array('true'=> 'Yes', 'false'=>'No'),
'width' => 100,
//'meta' => true,
//'encrypted' => 1
);
*/
        
        
        $options = array();
$data = new Database();
$where = 'post_type = "shipping"';
$count  =  $data->select(" * ", " post ", $where);
while($r = $data->getObjectResults()){
    $options [$r->post_id] = $r->post_title;
}

$list[] = array(
'name' => 'Shipping',
'field' => 'or_shipping',
'type' => 'select', // checkboxes
'values' => $options,
'columns' => 12,
'width' => 150
);


        

        $list[] =  array(
                        'name' => 'Confirmed',
                        'field' => 'or_confirm',
                        'type' => 'checkbox',
                        'labels'=> array('true'=> 'Yes', 'false'=>'No'),
                        'width' => 100
                        );


         $list[] = array(
            'name' => 'Status',
            'field' => 'or_status',
            'type' => 'status',
            'values' => $options,
            'width' => 150
            );
    
     
                
                

/***************** LIST PARAMETERS ***************/


/***************** GENERAL PARAMETERS ***************/
    

$title = 'Orders';
$title_singular = 'Order';

$extras = array();
$extras['table'] = 'orders';
$extras['id'] = 'or_id';
//$extras['table_state'] = 'post_state';
$extras['table_date'] = 'or_date';
$extras['per_page'] = 20;
$extras['order'] = 'or_date DESC';
$extras['hidenew'] = 1;
               /* $extras['table_order'] = 'post_order';*/


if ( isset($_GET['uid']) )
    $extras['list_where'] = ' or_user = '.$_GET['uid'];
//$extras['post_type'] = 'option' ;

$extras['page'] = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0;


//$extras['print'] = 1;
$data = new Database();
$where = 'or_id = '.$_GET[ 'id'];
$count  =  $data->select(" * ", " orders ", $where);
$r = $data->getObjectResults();
$extras['printfile'] = '../invoices/'.$r->or_invoicefile;



$extras['filters'][] = array(
        'label' => 'Status',
        'column_name' => 'or_status',
        'equal' => 'like',
        'values' => $status
);


 $values = array(
            '0' => 'No',
            '1' => 'Yes',
            );

$extras['filters'][] = array(
        'label' => 'Confirmed',
        'column_name' => 'or_confirm',
        'equal' => '=',
        'values' => $values
);



$options = array();
$data = new Database();
$where = '';
$count  =  $data->select(" * ", " site_users ", $where);
while($r = $data->getObjectResults()){
    $options [$r->us_id] = $r->us_name.' - '.$r->us_email;
}
$extras['filters'][] = array(
        'label' => 'User',
        'column_name' => 'or_user',
        'equal' => '=',
        'values' => $options
);


$extras['search'] = array(
        'placeholder' => 'Search by number, email or name',
        'fields' => array('or_id', 'or_email', 'or_name', 'or_lastname')
);


/***************** DO NOT TOUCH THIS ***************/      
makeallhappend();
/***************** DO NOT TOUCH THIS ***************/      

?>
<script type="text/javascript">
$(document).ready(function () {
/*
<?php if ( isset($_GET['list']) ) {?>
window.location = 'orderlist.php';
<?php } ?>
*/
});
</script>
<style>
@media only print  {
    p{
        font-size: 13px;
        margin-bottom: 5px;
        margin-top: 0;    
    }
    p:last-child{
        margin-bottom: 0;
    }
    table thead tr th, table tfoot tr th, table tfoot tr td, table tbody tr th, table tbody tr td, table tr td{
        padding: 5px;
    }
    table tr td p{
        font-size: 13px;
        margin-top: 0;
    }
    table thead tr th, table tfoot tr th, table tfoot tr td, table tbody tr th, table tbody tr td, table tr td{
        line-height: 100%;
    }
    label, span{
        font-size: 14px;
    }
}    
</style>
<!--  spac for custom scripts  -->
<?php include('includes/footer.php');