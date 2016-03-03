<?php

/**
* Open $fileName & append $line at the end of the file
*
*/
function append_to_file($fileName, $line)
{
	//	Open file 
	$myfile = fopen($fileName, "a") or die("Unable to open file!");

	//	Write line
	fputs($myfile, $line);
				
	fclose($myfile);
}

/**
* Open $fileName & append $content at the end of the file
*
*/
function append_to_file_json($fileName, $content)
{
	//	Open file 
	$myfile = fopen($fileName, "a") or die("Unable to open file!");

	//	Write content in JSON to the file
	fputs($myfile, json_encode($content));
	//var_dump($res);
				
	fclose($myfile);
}

