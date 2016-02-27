<?php
	
	include_once('model/pointGPS/pointGpsService.php');
	include_once('model/pointGPS/PointGPS.class.php');

	//query 2 points from database
	$pointsGPS = get_pointGPS(2);

	// Data processing
	$points = array();
	foreach($pointsGPS as $point) 
	{
		$points[] = new PointGPS($point['id'],$point['lat'],$point['lon']);
	}

	$pointFound = get_by_coord($points[1]->getLat(), $points[1]->getLon());
	foreach($pointFound as $point) 
	{
		$pt = new PointGPS($point['id'],$point['lat'],$point['lon']);
		$pt->display();
	}

	// Display view
	include_once(dirname(__DIR__).'/../view/pointGPS/index.php');
