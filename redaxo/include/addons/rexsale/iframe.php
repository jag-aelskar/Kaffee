<?php
$load=stripslashes($_GET['iframe']);
$load=strip_tags($load);
$load=urldecode($load);
$load=str_replace("/","",$load);
$load=str_replace("\\","",$load);
$load=str_replace("..","",$load);

include $REX['INCLUDE_PATH']."/addons/rexsale/pages/".$load.".php";

exit();

?>