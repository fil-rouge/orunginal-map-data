<?php
	
	include_once('model/pointGPS/PointGpsService.php');
	include_once('model/pointGPS/PointGPS.class.php');


	// Test insert
	//$insert = insert_pointgps(48.4546 , 7.554959);

	// Query 10 points from database
	$pointsGPS = get_pointGPS_by_id(10);

	// Data processing
	$points = array();
	foreach($pointsGPS as $point) 
	{
		$points[] = new PointGPS($point['id'],$point['lat'],$point['lon']);
	}

	// Test get_by_coord
	$pointFound = get_by_coord($points[0]->getLat(), $points[0]->getLon());
	foreach($pointFound as $point) 
	{
		$pt = new PointGPS($point['id'],$point['lat'],$point['lon']);
		$pt->display();
	}

	// Display view
	include_once(dirname(__DIR__).'/../view/pointGPS/index.php');
