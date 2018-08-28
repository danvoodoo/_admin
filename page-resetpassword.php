<?php 
//$_GET['debug'] = 1;
include('admin/includes/init.php');

if (isset($_POST['email'])) {
    
    $email = addslashes($_POST['email']);

    $data = new Database();
    $where = 'us_email = "'.$email.'"';
    $count  =  $data->select(" * ", " site_users ", $where);

    
    if ( $count==0) {
        header('Location: '.SITEURL.'resetpassword/?e=1');
        exit;
    }
    
    $string = time().'cvs';
    $hash = md5($string);

    $data = new Database();
    $arr = array(
               'us_hash' => $hash
               );
    $count  =  $data->update(" site_users ", $arr, 'us_email = "'.$email.'"');
    $id = $data->lastid();


    $msgTo  = $_POST['email'];
    
    $msgSub = SITENAME.' - Password Reset';

    $msg = '<h2>'.SITENAME.'</h2>To reset your password, please follow <a href="'.SITEURL.'resetpassword2/?h='.$hash.'">this link</a>';

    //mail($to, $title, $message, $headers);
    /*
    echo $msgTo.'
    ';
    echo $msgSub.'
    ';
    echo $msj.'
    ';
    */
    include("admin/notify/index.php");
   // exit;

    header('Location: '.SITEURL.'resetpassword/?m=1');
    exit;

}



$bodyclass='inner footersep';
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
            
     
            
        <?php if (isset($_GET['e']) AND $_GET['e'] == 1) {?>
        <div data-alert class="alert-box warning alert">
            The email doesn't correspond to any registered user.
        </div>
        <?php } ?>
        
        <?php if (isset($_GET['e']) AND $_GET['e'] == 2) {?>
        <div data-alert class="alert-box alert ">
            The link used is old or incorrect. Please enter your email again to reset your password.
        </div>
        <?php } ?>
        
         <?php if (isset($_GET['m']) AND $_GET['m'] == 1) {?>
        <div data-alert class="alert-box success ">
            An email has been sent to your email address with instructions on how to reset your password.
        </div>
        <?php } ?>
        

        
        
        <form action="" class='contactform' method='post' data-abide>
            

            
            <label for="">Enter your email</label>
            <input type="text" class="text" name='email' required />
            <div class="clear"></div>
            
            <button>Send</button>
            
        </form>

        </div>
        </div>
			
			
			
		</div>
		
		
	</div>


<div class="row">
    <div class="large-12 columns">
        <hr>
    </div>
</div>

<?php include('includes/footer.php');?>