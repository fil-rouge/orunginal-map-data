<?php
	
	include_once('model/segment/SegmentService.php');
	include_once('model/segment/Segment.class.php');

	echo 'includes ok';
	// Test insert
	//$insert = insert_pointgps(48.4546 , 7.554959);

	// Query 10 points from database
	$segmentsDB = get_segment(10);

	// Data processing
	$segments = array();
	foreach($segmentsDB as $segment) 
	{
		$segments[] = new Segment($segment['id'],$segment['distance'],
								  $segment['note'], $segment['idNoeudA'],
								  $segment['idNoeudB'], null);
	}


	// Display view
	include_once(dirname(__DIR__).'/../view/segment/index.php');
