<?php
require "lib/lessc.inc.php";
$less = new lessc;
try {
  $less->checkedCompile("css/styles.less", "css/styles.css");
} catch (exception $e) {
  echo "fatal error: " . $e->getMessage();
}

?>