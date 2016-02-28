<?php
	
	include_once('model/segment/SegmentService.php');
	include_once('model/segment/Segment.class.php');
	include_once('model/node/Node.class.php');
	include_once('model/pointGPS/PointGPS.class.php');

	echo 'includes ok';
	// Test insert
	//$insert = insert_pointgps(48.4546 , 7.554959);

	// Query 10 points from database
	$segmentsDB = get_segment(10);

	// Data processing
	$segments = array();
	foreach($segmentsDB as $segment) 
	{
		$pointA = new PointGPS($segment['idpointa'],$segment['lata'],$segment['lona']);
		$nodeA = new Node($segment['ida'], $pointA);
		
		$pointB = new PointGPS($segment['idpointb'],$segment['latb'],$segment['lonb']);
		$nodeB = new Node($segment['idb'], $pointB);
		
		$segments[] = new Segment($segment['id'],$segment['distance'],
								  $segment['note'], $nodeA,
								  $nodeB, null);

		// TODO !!!!!
	}


	// Display view
	include_once(dirname(__DIR__).'/../view/segment/index.php');
