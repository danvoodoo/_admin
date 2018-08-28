<?php
$menu_active = 'users'; // menu id

include('includes/header.php');

/***************** PARAMETROS PARA FORM DE EDICION ***************/

		$fields = array();
		
                
		/*INPUT DE TEXTO*/
		$fields[] = array(
                        'name' => 'Username',
                        'field' => 'u_user',
                        'type' => 'text'
                        //'encrypted' => 1
                        );
		
		
		$fields[] = array(
                        'name' => 'Email',
                        'field' => 'u_email',
                        'type' => 'text'
                        //'encrypted' => 1
                        );
		
		$fields[] = array(
                        'name' => 'Name',
                        'field' => 'u_name',
                        'type' => 'text'
                        //'encrypted' => 1
                        );
		
		
		$fields[] = array(
                        'name' => 'Password',
                        'field' => 'u_pass',
                        'type' => 'password'
                        //'encrypted' => 1
                        );
		
		
                

		
		
/***************** PARAMETROS PARA FORM DE EDICION ***************/


/***************** PARAMETROS PARA LISTA ***************/

		$list = array();
                
                $list[] =  array(
                        'name' => 'Username',
                        'field' => 'u_user',
                        'type' => 'text',
                        'width' => 150
                        );
                
		$list[] =  array(
                        'name' => 'Name',
                        'field' => 'u_name',
                        'type' => 'text',
                        'width' => 150
                        );
		
		$list[] =  array(
                        'name' => 'Email',
                        'field' => 'u_email',
                        'type' => 'text',
                        'width' => 200
                        );
                
 
                

		
/***************** PARAMETROS PARA LISTA ***************/
	
	
/***************** PARAMETROS GENERALES ***************/	

                $title = 'Users';
                $title_singular = 'User';
	
		$extras = array();
		$extras['table'] = 'users';
		$extras['id'] = 'u_id';
		$extras['per_page'] = 20;
		$extras['order'] = 'u_id DESC';
        //        $extras['table_order'] = 'prod_order';
		
		$extras['page'] = isset($_GET["p"]) ? (is_numeric($_GET["p"]) ? $_GET["p"] : 0) : 0;
		
		
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