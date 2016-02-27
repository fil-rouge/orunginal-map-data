<?php
	
	include_once('model/service/get_pointGPS.php');

	//query 2 points from database
	$pointsGPS = get_pointGPS(2);

	// Data processing
	$points = array();
	foreach($pointsGPS as $point) 
	{
		$points[] = $point;
	}

	// Display view
	include_once(dirname(__DIR__).'/../views/pointGPS/index.php');
