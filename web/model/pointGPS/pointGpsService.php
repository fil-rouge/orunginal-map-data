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
*	Returns a gps point matching the $id
*
*/
function get_pointGPS_by_id($id)
{
	//link to the global database connexion
	global $bdd;

	//query to get ALL GPS points from database
	$qry = $bdd->prepare('SELECT id, lat, lon FROM pointGPS 
						  WHERE pointGPS.id='.$id);

	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$pointGPS = $qry->fetchAll();
	
	return $pointGPS;
}


/**
*	Returns all GPS points with aLat & aLon
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

/**
*	Insert into table pointgps a point
*
*/
function insert_pointgps($aLat, $aLon)
{
	//link to the global database connexion
	global $bdd;
	
	try
	{
	    $qry = $bdd->prepare('INSERT INTO pointGPS (lat,lon) values ('.$aLat.','.$aLon.')');
		$qry->execute();
		return true;
	}
	catch(Exception $e)
	{
	    die('Erreur : '.$e->getMessage());
	}
	return false;
}