<?php

/**************** ALL SERVICES FOR THE OBJECT SEGMENT ***************/

/**
*	Returns all segments with limit
*
*/
function get_segment($limit)
{
	//link to the global database connexion
	global $bdd;

	//query to get ALL GPS points from database
	$qry = $bdd->prepare('SELECT * FROM segments LIMIT '.$limit);

	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$segments = $qry->fetchAll();
	
	return $segments;
}

/**
*	Returns segment with matching id
*
*/
function get_segment_by_id($id)
{
	//link to the global database connexion
	global $bdd;

	//query 
	$qry = $bdd->prepare('SELECT * FROM segments 
						  WHERE segments.id='.$id);

	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$segments = $qry->fetchAll();
	
	return $segments;
}