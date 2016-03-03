<?php
	
include_once('model/pointGPS/PointGpsService.php');
include_once('model/pointGPS/PointGPS.class.php');

function process_closer_point()
{
	// TODO
}

function display_points($limit)
{
	$nb = count_points();
	echo 'Number of segments = '.$nb[0]['count'].'<br/><br/>';
	echo 'Number displayed = '.$limit.'<br/><br/>';

	// Query 10 points from database
	$pointsGPS = get_pointGPS($limit);
	//$pointsGPS = get_closer_point(47,6,4);

	// Data processing
	$points = array();
	foreach($pointsGPS as $point) 
	{
		$points[] = new PointGPS($point['idosm'],$point['lat'],$point['lon']);
	}

	return $points;
}

// Test get_by_coord
// $pointFound = get_by_coord($points[0]->getLat(), $points[0]->getLon());
// foreach($pointFound as $point) 
// {
// 	$pt = new PointGPS($point['idosm'],$point['lat'],$point['lon']);
// 	$pt->display();
// }

// Display view
include_once(dirname(__DIR__).'/../view/pointGPS/index.php');
