<?php
function makeallhappend() {
  global $extras, $list, $fields, $title, $title_singular, $r;
  include('includes/actions/actions-edit-list.php');  

  if ( isset($extras['singlepage']) AND $extras['singlepage'] == 1 ){
    unset($_GET['list']);
    $data = new Database();
    $where = $extras['list_where'];
    $count  =  $data->select(" * ", 'post' , $where);
    if ( $count == 1 ) {
      $r = $data->getObjectResults();
      $_GET['id'] = $r->post_id;
    }
  }

  if (!isset($_GET["list"])) {
          include('includes/functions/functions.save.php');
          include('includes/functions/functions.edit.php');
  } else {
          $fields = $list;
          include('includes/functions/functions.list.php');        
  }    
}

function get_option($fieldname) {
  $data = new Database();
  $where = 'post_state = 1 AND post_type = "option" AND post_url = "'.$fieldname.'"';
  $data->select(" * ", " post ", $where);
  $r = $data->getObjectResults();
  return $r->post_content;
}

function get_option_image($fieldname) {
	$data = new Database();
	$where = 'post_state = 1 AND post_type = "option" AND post_url = "'.$fieldname.'"';
	$data->select(" * ", " post ", $where);
	$r = $data->getObjectResults();
	return $r->post_photo;
}


function slug($text)
{ 
  // replace non letter or digits by -
   $text = str_replace("'s","",  $text);//take off apostropes
  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

  // trim
  $text = trim($text, '-');

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // lowercase
  $text = strtolower($text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  if (empty($text))
  {
    return 'n-a';
  }
  return $text;
}


function slugify($text, $id=0, $posttype='')
{ 
  
  $a = 0;
    $loop = 1;
    
    while ($loop == 1) {
      $a++;
      
      if ($a==1)
          $slug = slug($text);
          else
          $slug = slug($text).'-'.$a;
          
    $data = new Database();
    $where = 'post_url = "'.$slug.'"';
    if ($id > 0) $where .= ' AND post_id != '.$id;
    if ($posttype != '') $where .= ' AND post_type = "'.$posttype.'"';

    $count  =  $data->select(" * ", " post ", $where);    
  
      if ( $count == 0) {
        $loop = 2;
      } 
    }

  return $slug;
}



function FetchPage($url)
{
$user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

        $options = array(

            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
          //  CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
}




function backup_database_tables($tables)
{
     
    $data = new Database();
     
    //get all of the tables
    if($tables == '*')
    {
        $tables = array();
        
        $data->query('SHOW TABLES');
        while($r = $data->getObjectResults()){
            $tables[] = current( (array)$r );
        }
    }
    else
    {
        $tables = is_array($tables) ? $tables : explode(',',$tables);
    }

    $return = '';
     
    //cycle through each table and format the data
    foreach($tables as $table)
    {
        
         
        $return.= 'DROP TABLE IF EXISTS '.$table.';';

        $data->query('SHOW CREATE TABLE '.$table);
        $r = $data->getObjectResults();
        $return.= "\n\n".$r->{'Create Table'}.";\n\n";

        $data->query('SELECT * FROM '.$table);
         
        while($r = $data->getObjectResults()){
       
              $return.= 'INSERT INTO '.$table.' VALUES(';

              $a=0;
              foreach ($r as $key => $value) {
                $a++;
                if ($a>1) { $return.= ','; }

                    $value = addslashes($value);
                    $value = str_replace ("\n","\\n",$value);
                    if (isset($value)) { $return.= '"'.$value.'"' ; } else { $return.= '""'; }


              }
              $return.= ");\n";
            
        }
        $return.="\n\n\n";
    }
     
    //save the file
    $handle = fopen('backup/db-backup-'.date('Ymd').'.sql','w+');
    fwrite($handle,$return);
    fclose($handle);
    return 'backup/db-backup-'.date('Ymd').'.sql';

    

}




// clean up any number string. Good for imports
function tofloat($num) {
    $dotPos = strrpos($num, '.');
    $commaPos = strrpos($num, ',');
    $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos : 
        ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);
   
    if (!$sep) {
        return floatval(preg_replace("/[^0-9]/", "", $num));
    } 

    return floatval(
        preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
        preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
    );
}



function get_post_url($id) {
    $data = new Database();
    $where = 'post_id = '.$id;
    $count  =  $data->select(" post_url ", " post ", $where);
    if ($count>0) {
        $r = $data->getObjectResults();
        return $r->post_url;
    }
}


function getmetas( $id, $posttype, $object='' ) {
  
  if ( $object != '' ) {
    $r = $object;
  } else {
    global $r;  
  }
  $data = new Database();
  $where = 'meta_postid = '.$id.' AND meta_posttype = "'.$posttype.'"';
  $count  =  $data->select(" * ", " meta ", $where);
  if ( $count > 0 ) {
    while($m = $data->getObjectResults()){
      $key = $m->meta_key;
      $r->$key = $m->meta_value;
    }
  }


  if ( isset($_SESSION['lang']) ){
    foreach ($r as $key => $value) {
      if ( isset( $r->{$key.'_'.$_SESSION['lang']} ) ){
        $r->{$key} = $r->{$key.'_'.$_SESSION['lang']};
      }
    }
  }

  return $object;
}



function getmetas_array( $id, $posttype ) {
  global $r;
  $data = new Database();
  $where = 'meta_postid = '.$id.' AND meta_posttype = "'.$posttype.'"';
  $count  =  $data->select(" * ", " meta ", $where);
  if ( $count > 0 ) {
    while($m = $data->getObjectResults()){
      $key = $m->meta_key;
      $r[$key] = $m->meta_value;
    }
  }
}



function nicetime($date)
{
    if(empty($date)) {
        return "No date provided";
    }
   
    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths         = array("60","60","24","7","4.35","12","10");
   
    $now             = time();
    $unix_date         = strtotime($date);
   
       // check validity of date
    if(empty($unix_date)) {   
        return "Bad date";
    }

    // is it future date or past date
    if($now > $unix_date) {   
        $difference     = $now - $unix_date;
        $tense         = "ago";
       
    } else {
        $difference     = $unix_date - $now;
        $tense         = "from now";
    }
   
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
   
    $difference = round($difference);
   
    if($difference != 1) {
        $periods[$j].= "s";
    }
   
    return "$difference $periods[$j] {$tense}";
}


function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}


function imageupload( $attrs ){
    ?>
    <span class="field image">
      <label for="" >
        <?php echo $attrs['label'];?>
        <span class="prog"></span>      
      </label>
      <input type="hidden" class='filename' name='<?php echo $attrs['name'];?>' value='<?php echo $attrs['value'];?>' readonly data-previewsize='<?php echo $attrs['size'];?>_'>

      <span></span>
      <a href="#" class="upload button tiny" ><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
      <a href="#" class="gal button tiny" ><i class="fa fa-picture-o"></i></a>
      <a href="#" class="editimage button tiny" ><i class="fa fa-pencil-square-o"></i></a>
      <a href="#" class="deleteimage button tiny alert" title='Remove image' ><i class="fa fa-times"></i></a>
    </span>
    <?php
}


function linkfield( $attrs ) {
  ?>
  <div class="field linkfield">
    <label for=""><?php echo $attrs['label'];?></label>
    <input type="hidden" value='<?php echo $attrs['value']; ?>' name='<?php echo $attrs['name']; ?>'>
    
    <?php 
    if ( $attrs['value']!= '' ) {
      $link = json_decode( $attrs['value'] );
      ?>
      <div class="title"><?php echo $link->title; ?></div>
      <div class="url"><?php echo $link->url; ?></div>
    <?php } else {?>
      <div class="title"></div>
      <div class="url"></div>
    <?php } ?>

    <button class="tiny selectlink">Select Link</button>
  </div>
  <?php
}




function cartstring( $order ) {


  $cart = json_decode( $order->or_cart );
  $subtotal = 0;
  
   $details = '';

  $details .= '<h3>Order number: '.$order->or_id.'</h3>';
  $details .= '<p>Order Date: '.date('d/m/Y',strtotime($order->or_date)).'</p>';
  if ( $order->or_deliverydate ){
    $details .= '<p>Delivery Date: '.date('d/m/Y',strtotime($order->or_deliverydate)).'</p>';    
  }
  $details .= '<p>Shipping Address: '.$order->or_address.', '.$order->or_city.', '.$order->or_cp.'</p>';
  if ( $order->or_gift ){
    $details .= '<p>Card Message: '.$order->or_gift.'</p>';    
  }
  if ( $order->or_notes ){
    $details .= '<p>Delivery instructions: '.$order->or_notes.'</p>';    
  }
  if ( $order->or_addnotes ){
    $details .= '<p>Additional info: '.$order->or_addnotes.'</p>';    
  }

  
  $details .= '<hr><h2>Order details</h2>';
  
  foreach ($cart as $k => $c) {
       
    $data = new Database();
    $where = 'prod_id = '.$k;
    $count  =  $data->select(" * ", " products ", $where);
    $r = $data->getObjectResults();

    $data = new Database();
    $where = 'prod_id = '.$r->prod_parent;
    $count  =  $data->select(" * ", " products ", $where);
    $par = $data->getObjectResults();

    $data = new Database();
    $where = 'prod_parent = '.$r->prod_parent;;
    $count  =  $data->select(" * ", " products ", $where);
    if ( $count == 1 ) { //only one variant
      $variant = '';
    } else {
      $variant = ' - '.$r->prod_title;
    }
     
    $subtotal = $subtotal + $r->prod_price*$c->q;
    $details .= '<table style="width: 100%;border-collapse: collapse; border: 1px solid #ddd; margin-bottom: 20px"><tr><td style="border: 1px solid #ddd; padding: 10px "><img style="width:100px" src="'.SITEURL.'photos/200_200_'.$par->prod_photo.'" alt=""></td><td style="border: 1px solid #ddd; padding: 10px ">
    <h4>'.$par->prod_title.$variant.'</h4><p>Value: &pound;'.number_format($r->prod_price,2).' <br>Quantity: '.$c->q.'</tr><tr><td colspan="2" style="border: 1px solid #ddd; padding: 10px ">';
    $details .= '<h3>Subtotal: &pound;'.number_format($r->prod_price*$c->q,2).'</h3></td></tr></table>';
    

  }


  if ( $order->or_code ) {
    $code = json_decode($order->or_code);
    //print_r($code);
    $details .= '<p><strong>Discount:</strong> '.$code->post_title;
    if ( $code->post_category == 'value' ) $details .= ' - &pound;'.$code->post_content;
    if ( $code->post_category == 'percent' ) $details .= ' - %'.$code->post_content;
    if ( $code->post_category == 'shipping' ) $details .= ' - Free Shipping';
    $details .= '</p>';
  }


  $data = new Database();
  $where = 'post_type = "shipping" AND post_id = '.$order->or_shipping;
  $count  =  $data->select(" * ", " post ", $where);
  $ship = $data->getObjectResults();

  $details .= 'Subtotal: &pound;'.number_format($subtotal,2);
  $details .= '<br>Shipping: '.htmlentities($ship->post_title).' - &pound;'.number_format($order->or_shippingtotal,2).'
        <h2>Total: &pound;'.number_format($subtotal+$order->or_shippingtotal,2).'</h2>
        
        ';

  return $details;
}



function nl2p($string, $line_breaks = true, $xml = true) {

$string = str_replace(array('<p>', '</p>', '<br>', '<br />'), '', $string);

// It is conceivable that people might still want single line-breaks
// without breaking into a new paragraph.
if ($line_breaks == true)
    return '<p>'.preg_replace(array("/([\n]{2,})/i", "/([^>])\n([^<])/i"), array("</p>\n<p>", '$1<br'.($xml == true ? ' /' : '').'>$2'), trim($string)).'</p>';
else 
    return '<p>'.preg_replace(
    array("/([\n]{2,})/i", "/([\r\n]{3,})/i","/([^>])\n([^<])/i"),
    array("</p>\n<p>", "</p>\n<p>", '$1<br'.($xml == true ? ' /' : '').'>$2'),

    trim($string)).'</p>'; 
}






function get_url( $r ){

    if ( is_array($r) ) $r = (object) $r;

    global $urlstructure;
    $urls = $urlstructure[ $r->post_type ] ['urlstructure'];
    
    $urls = explode( '/' , $urls);

    $url = '';
    foreach ($urls as $u) {
      switch ($u) {
        case '%url':
          $url .= $r->post_url;
          $url .= '/';
        break;

        case '%parent':
          if ( get_post_url( $r->post_parent ) ) {
            $url .= get_post_url( $r->post_parent );            
            $url .= '/';
          }
          
        break;

        case '%parent2':
          if ( get_post_url( $r->post_parent ) ) {
            $data = new Database();
            $where = 'psot_id = '.$r->post_parent;
            $count  =  $data->select(" * ", " post ", $where);
            if ( $count > 0 ) {
              $parent = $data->getObjectResults();  
              $url .= get_post_url( $parent->post_parent );
              $url .= '/';
            }
          }   
        break;
        
        default:
          $url .= $u;
          $url .= '/';
        break;
      }
      
    }

    return $url;

}