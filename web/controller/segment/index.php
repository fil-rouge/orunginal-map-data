<?php
	
include_once('model/segment/SegmentService.php');
include_once('model/segment/Segment.class.php');
include_once('model/node/Node.class.php');
include_once('model/pointGPS/PointGPS.class.php');

//echo 'includes ok';
// Test insert

$idseg = insert_segment_into_segments(12, 9, 2.9, 126079, 1472874878);
//echo "Last id=".$idseg["id"]."<br/>";
var_dump($idseg);
//insert_segment_into_s2p(1, array(0 => 1472874878, 1 => 126079, 2 => 143412), true);

display_s2p(1000);
//$points = get_segment_points_ordered(3,4);

// Query 10 points from database
$segmentsDB = get_segment(100);
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
}

function display_s2p($limit)
{
	print json_encode(get_s2p($limit));
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
		$i = $pointsLength - 1;
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

	print json_encode($pointsDB);
	return $points;
}


// Display view
include_once(dirname(__DIR__).'/../view/segment/index.php');
