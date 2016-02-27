<?php
/**
*	Returns all GPS points with limit
*
*/
function get_pointGPS($limit)
{
	//link to the global database connexion
	global $bdd;

	//query to get ALL GPS points from database
	$qry = $bdd->prepare('SELECT id, lat, lon FROM pointGPS LIMIT '.$limit);


	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$pointGPS = $qry->fetchAll();
	
	return $pointGPS;
}