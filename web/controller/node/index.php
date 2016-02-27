<?php
	
	include_once('model/node/NodeService.php');
	include_once('model/node/Node.class.php');
	include_once('model/pointGPS/PointGPS.class.php');

	echo 'includes ok';
	// Test insert
	//$insert = insert_pointgps(48.4546 , 7.554959);

	// Query 10 points from database
	$nodesDB = get_node(10);

	// Data processing
	$nodes = array();
	foreach($nodesDB as $node) 
	{
		$point = new PointGPS($node['idpoint'],$node['lat'],$node['lon']);
		$nodes[] = new Node($node['id'], $point);
	}


	// Display view
	include_once(dirname(__DIR__).'/../view/node/index.php');
