<?php
function carttotal($format=1) {
    
    $ids = array();
    foreach ($_SESSION['cart'] as $id => $v) {
        $ids[] = $id;
    }

    $data = new Database();
    $where = 'prod_id IN ('.implode(',', $ids).')';
    $count  =  $data->select(" prod_price, prod_id ", " products ", $where);

    $total = 0;
    while($r = $data->getObjectResults()){
        $total += $r->prod_price  * $_SESSION['cart'][$r->prod_id]['q'];
    }
    if ( VAT > 0 ) $total += $total * VAT;

    if ( $format == 1 ) 
        return number_format($total,2);
    else
        return $total;

}

function cartquantity() {
    $q = 0;
    foreach ($_SESSION['cart'] as $id => $v) {
        $q += $v['q'];
    }
    return $q;
}


function pricefrom($id) {
    $data = new Database();
    $where = 'prod_parent = '.$id;
    $count  =  $data->select(" prod_price ", " products ", $where, 'prod_price ASC');
    $r = $data->getObjectResults();
    return $r->prod_price;
}

function getvarscount($id) {
    $data = new Database();
    $where = 'prod_parent = '.$id;
    $count  =  $data->select(" prod_price ", " products ", $where, 'prod_price ASC');
    return $count;
}

function shopstatus($showmessage) {
    $data = new Database();
    $where = 'post_type = "shopstatus" ';
    $count  =  $data->select(" * ", " post ", $where);
    $r = $data->getObjectResults();
    if ( $showmessage ) {
        echo $r->post_content;
    } else {
        return $r->post_title;  
    }
    
}