<?php

/**************** ALL SERVICES FOR THE OBJECT POINTGPS ***************/

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

/**
*	Returns all GPS points with limit
*
*/
function get_by_coord($aLat, $aLon)
{
	//link to the global database connexion
	global $bdd;

	//query to get ALL GPS points from database
	$qry = $bdd->prepare('SELECT id, lat, lon FROM pointGPS po
		WHERE po.lat='.$aLat.' AND po.lon='.$aLon);

	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$pointGPS = $qry->fetchAll();
	
	return $pointGPS;
}