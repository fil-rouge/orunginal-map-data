<?php
	
	include_once('model/node/NodeService.php');
	include_once('model/node/Node.class.php');

	echo 'includes ok';
	// Test insert
	//$insert = insert_pointgps(48.4546 , 7.554959);

	// Query 10 points from database
	$nodesDB = get_node_by_id(4);

	// Data processing
	$nodes = array();
	foreach($nodesDB as $node) 
	{
		$nodes[] = new Node($node['id'],$node['idpoint']);
	}


	// Display view
	include_once(dirname(__DIR__).'/../view/node/index.php');
