<?php
	
	include_once('model/pointGPS/get_pointGPS.php');
	include_once('model/pointGPS/PointGPS.class.php');

	//query 2 points from database
	$pointsGPS = get_pointGPS(2);

	// Data processing
	$points = array();
	foreach($pointsGPS as $point) 
	{
		$points[] = new PointGPS($point['id'],$point['lat'],$point['lon']);
	}

	// Display view
	include_once(dirname(__DIR__).'/../view/pointGPS/index.php');
