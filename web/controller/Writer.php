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



