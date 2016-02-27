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

	//query to get ALL GPS points from database
	$qry = $bdd->prepare('SELECT id, idpoint FROM nodes LIMIT '.$limit);

	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$nodes = $qry->fetchAll();
	
	return $nodes;
}