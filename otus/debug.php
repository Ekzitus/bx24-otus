<?php
define('DEBUG_FILE_NAME', $_SERVER["DOCUMENT_ROOT"] .'/logs/'.date("Y-m-d").'.log');
$log = "\n------------------------\n";
$log .= date("Y.m.d G:i:s");
$log .= "\n------------------------\n";
file_put_contents(DEBUG_FILE_NAME, $log, FILE_APPEND);