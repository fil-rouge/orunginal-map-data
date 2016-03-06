<?php

/**
* 	Call algorithm to create routes in output.json file
*/
function call_algo()
{
	$param = dirname(__DIR__).'/files/json/param.json';
	$output = dirname(__DIR__).'/files/json/output.json';

	$ret = shell_exec("./algo ".$param." ".$output);
}