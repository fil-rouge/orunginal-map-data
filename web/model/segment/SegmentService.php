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
	$qry = $bdd->prepare('SELECT segments.id, distance, note, na.id as ida, 
								 na.idpoint as idpointa, pa.lat as lata, 
								 pa.lon as lona, nb.id as idb, 
								 nb.idpoint as idpointb, pb.lat as latb, 
								 pb.lon as lonb 

						  FROM   segments, nodes as na, nodes as nb, 
						  	     pointgps as pa, pointgps as pb 

						  WHERE  segments.idnodea=na.id AND 
						  		 segments.idnodeb=nb.id AND 
						  		 na.idpoint=pa.id AND nb.idpoint=pb.id
						  
						  LIMIT '.$limit);

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