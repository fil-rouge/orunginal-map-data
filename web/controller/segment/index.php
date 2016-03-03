<?php
	
include_once('model/segment/SegmentService.php');
include_once('model/segment/Segment.class.php');
include_once('model/node/Node.class.php');
include_once('model/pointGPS/PointGPS.class.php');

//echo 'includes ok';
// Test insert

$idseg = insert_segment_into_segments(12, 9, 2.9, 126079, 1472874878);

//insert_segment_into_s2p(1, array(0 => 1472874878, 1 => 126079, 2 => 143412), true);


print_delete_s2p(2);
//$points = get_segment_points_ordered(3,4);



function display_s2p($limit)
{
	echo "<h2>----- DISPLAY TABLE S2P ------</h2>";
	$segments = get_s2p($limit);
	echo 'Number of segments = '.count($segments).'<br/>';
	print json_encode($segments);
}

function print_delete_s2p($anIdSegment)
{
	echo "<h2>----- DELETE SEGMENT FROM S2P ------</h2>";
	$deletedItem = delete_from_s2p_by_id($anIdSegment);
	print json_encode($deletedItem);
}

function display_segments($limit)
{
	echo "<h2>----- DISPLAY TABLE SEGMENTS ------</h2>";
	$segments = get_segment($limit);
	echo 'Number of segments = '.count($segments).'<br/>';
	print json_encode($segments);
}

function print_delete_segments($anIdSegment)
{
	echo "<h2>----- DELETE SEGMENT FROM SEGMENTS ------</h2>";
	$deletedItem = delete_from_s2p_by_id($anIdSegment);
	print json_encode($deletedItem);
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

/**
* 	Returns the distance between two gps points
* 	
*/
function update_distance($idPointA, $idPointB)
{
	$pointA = get_point_by_id($idPointA);
	$pointA = get_point_by_id($idPointB);

	// TODO
} 


// Display view
include_once(dirname(__DIR__).'/../view/segment/index.php');
