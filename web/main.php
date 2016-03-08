<?php

include_once('controller/Controller.php');

header("Access-Control-Allow-Origin: *");

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if ((isset($_GET["action"])))
{
	analyzeRequest($_GET["action"], (!empty($_GET["params"]))?$_GET["params"]:"");
}
else
{
	echo 'fail the Get..<br/>';
}