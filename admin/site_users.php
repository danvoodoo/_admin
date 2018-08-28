<?php

$menu_active = 'siteusers'; 

include('includes/header.php');


function aftersave($id) {
    $data = new Database();
    $where = 'us_id = '.$id;
    $count  =  $data->select(" * ", " site_users ", $where);
    $r = $data->getObjectResults();

    if ( $r->us_laststate != $r->us_state  ) {
        //if status didnt change, do nothing

        $data = new Database();
        $arr = array(
            'us_laststate' => $r->us_state
        );
        $count  =  $data->update(" site_users ", $arr, $where);

        if (  $r->us_state == 1 ) { //send mail for approved

        $data = new Database();
        $where = 'post_type = "optionemail" AND post_state = 1 AND post_url = "userapproved"';
        $count  =  $data->select(" * ", " post ", $where);
        if ( $count == 1 ){
            $emailtemplate = $data->getObjectResults();

            foreach ( array_keys((array)$r) as $value) {
                $value = str_replace('us_', '', $value);
                $emailtemplate->post_title = str_replace('{'.$value.'}', $r->{'us_'.$value}, $emailtemplate->post_title);
                $emailtemplate->post_content = str_replace('{'.$value.'}', $r->{'us_'.$value}, $emailtemplate->post_content);                    
            }
            $msgSub  = $emailtemplate->post_title;
            $msg = nl2br($emailtemplate->post_content);
            $msgTo = $r->us_email;  
            $htmlemail = 1;
            $emaillog = 1;
            
            include("notify/index.php");
        }
        }
       // exit;

    }

}

/***************** PARAMETROS PARA FORM DE EDICION ***************/

		$fields = array();
		
                
		/*INPUT DE TEXTO*/
        $fields[] = array(
                        'name' => 'Name',
                        'field' => 'us_name',
                        'type' => 'text'
                        //'encrypted' => 1
                        );


                $fields[] = array(
                        'name' => 'Last Name',
                        'field' => 'us_lastname',
                        'type' => 'text'
                        //'encrypted' => 1
                        );
		
                

		

		$fields[] = array(
                        'name' => 'Email',
                        'field' => 'us_email',
                        'type' => 'text'
                        //'encrypted' => 1
                        );
		
		$fields[] = array(
                        'name' => 'Address',
                        'field' => 'us_address',
                        'type' => 'text'
                        //'encrypted' => 1
                        );

        $fields[] = array(
                        'name' => 'City',
                        'field' => 'us_city',
                        'type' => 'text'
                        //'encrypted' => 1
                        );

         $fields[] = array(
                        'name' => 'County',
                        'field' => 'us_county',
                        'type' => 'text'
                        //'encrypted' => 1
                        );

          $fields[] = array(
                        'name' => 'Country',
                        'field' => 'us_country',
                        'type' => 'text'
                        //'encrypted' => 1
                        );
                
                
                $fields[] = array(
                        'name' => 'Phone',
                        'field' => 'us_phone',
                        'type' => 'text'
                        //'encrypted' => 1
                        );


                 $fields[] = array(
                        'name' => 'Postcode',
                        'field' => 'us_postcode',
                        'type' => 'text'
                        //'encrypted' => 1
                        );

              

$fields[] = array(
'name' => 'Password (empty for no change)',
'field' => 'us_password',
'type' => 'password',
'columns' => 12,
//'meta' => true,
//'encrypted' => 1
);

                

		
		
/***************** PARAMETROS PARA FORM DE EDICION ***************/


/***************** PARAMETROS PARA LISTA ***************/

		$list = array();
                
                $list[] =  array(
                        'name' => 'Name',
                        'field' => 'us_name',
                        'type' => 'text',
                        'width' => 150
                        );
                
		
		$list[] =  array(
                        'name' => 'Email',
                        'field' => 'us_email',
                        'type' => 'text',
                        'width' => 200
                        );
                
 

		
/***************** PARAMETROS PARA LISTA ***************/
	
	
/***************** PARAMETROS GENERALES ***************/

        $title = 'Users';
        $title_singular = 'User';	
	
		$extras = array();
		$extras['table'] = 'site_users';
		$extras['id'] = 'us_id';
		$extras['table_state'] = 'us_state';
		$extras['table_date'] = 'us_date';
		$extras['per_page'] = 20;
		$extras['order'] = 'us_date DESC';
        //        $extras['table_order'] = 'prod_order';
		
		$extras['page'] = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0;
		
		

               
                     $extras['search'] = array(
                        'placeholder' => 'Search by name and email ',
                        'fields' => array('us_name','us_email')
                        );
		/*filtro para lista
		$extras['filtro'] = array();
		$extras['filtro'][] = array('Category','prod_category','db','2013_category','cat_id','cat_name','');
		//label, campo, tipo, tabla de parametro, valor de parametro, label de parametro, WHERE para filtrar parametros
		*/
		

/***************** DO NOT TOUCH THIS ***************/      
makeallhappend();
/***************** DO NOT TOUCH THIS ***************/      

?>
<!--  spac for custom scripts  -->
<?php include('includes/footer.php');