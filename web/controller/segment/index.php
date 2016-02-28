<?php
	
include_once('model/segment/SegmentService.php');
include_once('model/segment/Segment.class.php');
include_once('model/node/Node.class.php');
include_once('model/pointGPS/PointGPS.class.php');

echo 'includes ok';
// Test insert
//$insert = insert_pointgps(48.4546 , 7.554959);

$points = get_segment_points_ordered(3,4);

// Query 10 points from database
$segmentsDB = get_segment_from_position(46,49,4.5,8);
//$segmentsDB = get_segment_points_by_id(1);

// Data processing
$segments = array();
foreach($segmentsDB as $segment) 
{
	$pointA = new PointGPS($segment['idpointa'],$segment['lata'],$segment['lona']);
	$nodeA = new Node($segment['idnodea'], $pointA);
	
	$pointB = new PointGPS($segment['idpointb'],$segment['latb'],$segment['lonb']);
	$nodeB = new Node($segment['idnodeb'], $pointB);
	
	$segments[] = new Segment($segment['id'],$segment['distance'],
							  $segment['note'], $nodeA,
							  $nodeB, null);

	// TODO !!!!!
}

/**
*	Returns the gps points for a segment in the right order
* 	starting with the $startpoint
*/
function get_segment_points_ordered($idSegment, $idStartPoint)
{
	// Call sql request
	$pointsDB = get_segment_points_by_id($idSegment);

	// Data processing
	$points = array();
	$pointsLength = count($pointsDB);
	
	if ($pointsDB[0]['id']==$idStartPoint)
	{
		// GPS points are in the RIGHT ORDER
		foreach($pointsDB as $point) 
		{
			$points[] = new PointGPS($point['id'],$point['lat'],$point['lon']);
		}
	}
	else if ($pointsDB[$pointsLength-1]['id']==$idStartPoint)
	{
		// GPS points are in the REVERSE ORDER
		$i = pointsLength - 1;
		foreach($pointsDB as $point) 
		{
			$points[$i] = new PointGPS($point['id'],$point['lat'],$point['lon']);
			$i--;
		}
	}
	else
	{
		echo '<br/><strong>ERROR:[get_segment_points_by_id] idStartPoint incorrect !!</strong><br/>';
	}

	return $points;
}


// Display view
include_once(dirname(__DIR__).'/../view/segment/index.php');
