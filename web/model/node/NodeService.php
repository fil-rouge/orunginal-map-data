<?php

/**************** ALL SERVICES FOR THE OBJECT NODE ***************/

/**
*	Returns all nodes with limit
*
*/
function get_node($limit)
{
	//link to the global database connexion
	global $bdd;

	//query to get ALL nodes with their GPS points from database
	$qry = $bdd->prepare('SELECT nodes.id, nodes.idpoint, 
								 pointgps.lat, pointgps.lon 
						  FROM nodes, pointgps 
						  WHERE nodes.idpoint=pointgps.id
						  LIMIT '.$limit);

	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$nodes = $qry->fetchAll();
	
	return $nodes;
}

/**
*	Returns node with matching id
*
*/
function get_node_by_id($id)
{
	//link to the global database connexion
	global $bdd;

	//query 
	$qry = $bdd->prepare('SELECT id, idpoint FROM nodes 
						  WHERE nodes.id='.$id);

	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$nodes = $qry->fetchAll();
	
	return $nodes;
}