<?php
global $r, $page;

function getrepeater($r) {
    $repeater = current( json_decode( $r ) );
    return $repeater->repeater;
}

function showmenu($id) {
     
    $data = new Database();
    $where = 'menu_id = '.$id;
    $count  =  $data->select(" * ", " menus ", $where);
    $menu = $data->getObjectResults();
    $menuitems = json_decode($menu->menu_items);

    if ( isset($_SESSION['region']) ) {
        $data = new Database();
        $where = 'meta_posttype = "menu" AND meta_postid = 1 AND meta_key = "'.$_SESSION['lang'].'"';
        $count  =  $data->select(" * ", " meta ", $where);
        if ( $count == 1 ) {
            $r2 = $data->getObjectResults();  
            $menuitems = json_decode($r2->meta_value);
        }
    }

    if (count((array)$menuitems) > 0)
    foreach ($menuitems as $m) {?>
        <li <?php if ( isset($m->childs) AND count((array)$m->childs) > 0) { ?>class='dropdown'<?php } ?>>

        <?php if ( $m->url == '#' OR $m->url == '' ) {?>
            <span><?php echo $m->title;?></span>
        <?php }  else {
            if (strpos($m->url, '://') === false && substr($m->url, -1) != '/') {
                $m->url .= '/';
            }
            ?>
            <a href="<?php echo $m->url;?>" <?php if (isset($m->newwindow)) echo 'target="_blank"';?>><?php echo $m->title;?></a>
        <?php } ?>

        <?php if ( isset($m->childs) AND count((array)$m->childs) > 0) { ?>
        <ul>
        <?php foreach ($m->childs as $ii) {
            if (strpos($ii->url, '://') === false && substr($ii->url, -1) != '/') {
                $ii->url .= '/';
            }
            ?>
            <li>
                <a href="<?php echo $ii->url;?>"><?php echo $ii->title;?></a>
            </li>
        <?php } ?>
        </ul>

        <?php } ?>
        </li>
    <?php }
}



function getpost( $s, $posttype = "page", $column = "post_url" ) {
    global $r, $page, $count;
    $data = new Database();
    $where = $column.' = "'.$s.'" AND post_type = "'.$posttype.'"';
    if ( !isset($_GET['pv']) ) $where .= ' AND post_state = 1';
    $count  =  $data->select(" * ", " post ", $where);
    $r =  $page = $data->getObjectResults();
    $r = getmetas( $r->post_id, $r->post_type, $r );
}
