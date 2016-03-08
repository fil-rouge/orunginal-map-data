<?php

/*********************************************************************************/
//									  DISPLAY METHODS
/*********************************************************************************/

function display_points($limit)
{
	$nb = count_points();
	echo 'Number of segments = '.$nb[0]['count'].'<br/><br/>';
	echo 'Number displayed = '.$limit.'<br/><br/>';

	// Query 10 points from database
	$pointsGPS = get_pointGPS($limit);

	// Data processing
	$points = array();
	foreach($pointsGPS as $point) 
	{
		$points[] = new PointGPS($point['idosm'],$point['lat'],$point['lon']);
	}

	return $points;
}

/*********************************************************************************/
//					METHODES USED WHEN ENDPOINT getParcours() CALLED
/*********************************************************************************/

/**
*	Returns the lat, lon of the closest point to $aLat, $aLon
*
*/
function process_closer_point($aLat, $aLon)
{
	$closestPoint = get_closer_point($aLat, $aLon);
	return $closestPoint;
}

//process_closer_point(45.7405571, 4.8638673);


