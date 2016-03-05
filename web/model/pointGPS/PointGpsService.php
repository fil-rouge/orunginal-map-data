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
	$qry = $bdd->prepare('SELECT idosm, lat, lon FROM pointGPS LIMIT '.$limit);

	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$pointGPS = $qry->fetchAll();
	
	return $pointGPS;
}

/**
*	Returns the number of gps points in database
*
*/
function count_points()
{
	//link to the global database connexion
	global $bdd;

	//query to get ALL GPS points from database
	$qry = $bdd->prepare('SELECT COUNT(*) FROM pointGPS');

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
	$qry = $bdd->prepare('SELECT idosm, lat, lon FROM pointGPS 
						  WHERE pointGPS.idosm='.$id);

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
	$qry = $bdd->prepare('SELECT idosm, lat, lon FROM pointGPS po
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
function insert_pointgps($anIdosm, $aLat, $aLon)
{
	global $webDir;

	//query to get ALL GPS points from database
	$line='INSERT INTO pointGPS values ('.$anIdosm.','.$aLat.','.$aLon.');';
	append_to_file($webDir.'/../scripts/insertPoints.sql', $line);
	
}


/**
*	Returns a gps point matching the $id from table segments2pointgps
*
*/
function get_point_by_id_from_s2p($id)
{
	//link to the global database connexion
	global $bdd;

	//query to get ALL GPS points from database
	$qry = $bdd->prepare('SELECT * FROM segments2pointgps 
						  WHERE idpointgps='.$id);

	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$pointGPS = $qry->fetchAll();
	
	return $pointGPS;
}

/**********************************************************************************/
//							DatabaseSerializer - SERVICES
/**********************************************************************************/
/**
*	Returns all GPS points which are intersections with limit
*
*/
function get_intersections($limit)
{
	//link to the global database connexion
	global $bdd;

	//query to get ALL GPS points from database
	$qry = $bdd->prepare('SELECT DISTINCT idosm, lat, lon 
						  FROM pointGPS p, segments2pointgps s2p
						  WHERE isnode=true AND s2p.idpointgps=p.idosm
						  LIMIT '.$limit);

	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$pointGPS = $qry->fetchAll();
	
	return $pointGPS;
}

/**********************************************************************************/
//					SERVICES USED WHEN ENDPOINT getParcours() CALLED
/**********************************************************************************/

/**
*	Returns the closest gps points to 
*	$targetLat & $targetLon 
*/
function get_closer_point($targetLat, $targetLon)
{
	//link to the global database connexion
	global $bdd;

	//query to get ALL GPS points from database
	$qry = $bdd->prepare('SELECT idosm, lat, lon
						  FROM pointgps
						  WHERE (ABS(lat-'.$targetLat.')+
								 ABS(lon-'.$targetLon.'))=

						  	(SELECT MIN(ABS(lat-'.$targetLat.')+
								 ABS(lon-'.$targetLon.'))
							FROM pointgps)');

	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$pointGPS = $qry->fetchAll();
	
	return $pointGPS;
}
