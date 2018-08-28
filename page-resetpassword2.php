<?php 

include_once('admin/includes/init.php');

if (isset($_GET['h'])) {

    $hash = addslashes($_GET['h']);
    $data = new Database();
    $where = 'us_hash = "'.$hash.'"';
    $count  =  $data->select(" * ", " site_users ", $where);
   // print_r($r);
    
    if ($count==0) {
        header('Location: '.SITEURL.'resetpassword/?e=2');
        exit;
    }
    
} else if (!isset($_GET['m'])) {
    exit;
}


if (isset($_POST['pass1'])) {

    
    if ($_POST['pass1'] != $_POST['pass2']) {
        header('Location: '.SITEURL.'resetpassword2/?h='.$_GET['h'].'&e=1');
        exit;
    }
    
    global $db_salt;
    $password = sha1($_POST['pass1'].$db_salt);
//    $password = sha1($_POST['pass1']);

    $hash = addslashes($_GET['h']);
    

    $data = new Database();
    $where = 'us_hash = "'.$hash.'"';
    $count  =  $data->select(" * ", " site_users ", $where);
    $r = $data->getObjectResults();


    $data = new Database();
    $arr = array(
               'us_password' => $password
               );
    $count  =  $data->update(" site_users ", $arr, 'us_id = '.$r->us_id);
    $id = $data->lastid();

    

    header('Location: '.SITEURL.'resetpassword2/?m=1');
    exit;
    
}




$bodyclass='inner';
include('includes/header.php');?>




<div class="row">
    <div class="columns medium-12">
        <ul class="breadcrumbs">
            <li><a href="<?php echo SITEURL;?>">Home</a></li>
            <li class="active"><strong>Password Reset</strong></li>
        </ul>
    </div>
</div>



<div class="single row">
        <div class="columns medium-12 end pagecontent">

        <h2 class="text-center">Password Reset</h2>
        <hr>
        
        <div class="row">
            <div class="columns medium-6 medium-offset-3">
		
        
        <?php if (isset($_GET['e']) AND $_GET['e']) {?>
        <div data-alert class="alert-box error ">
            The passwords don't match.
        </div>
        <?php } ?>
        
         <?php if (isset($_GET['m']) AND $_GET['m'] == 1) {?>
        <div data-alert class="alert-box success ">
            Your password has been successfully changed. 
        </div>
        <?php } ?>
        
        
        <form action="" class='contactform' method='post'>
            

            
            <label for="">New password</label>
            <input type="password" class="text" name='pass1' />
            <div class="clear"></div>
            
            <label for="">New password again</label>
            <input type="password" class="text" name='pass2' />
            <div class="clear"></div>
            
            <input type="hidden" name='hash' value='<?php echo addslashes($_GET['h']);?>' />
            
            
            <button>Send</button>
            
        </form>	
			
			
		</div>

	</div>
    </div>



	

<div class="row">
    <div class="large-12 columns">
        <hr>
    </div>
</div>


  
<?php include('includes/footer.php');?>