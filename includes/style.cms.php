<?php
require "lessc.inc.php";
$less = new lessc;
$less->setFormatter("compressed");
try {
  $less->checkedCompile("css/style.less", "css/style.css");
} catch (exception $e) {
  echo "fatal error: " . $e->getMessage();
}


?>