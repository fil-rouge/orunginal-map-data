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
	$qry = $bdd->prepare('SELECT *
						  FROM   segments
						  LIMIT '.$limit);

	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$segments = $qry->fetchAll();
	
	return $segments;
}

/**
*	Returns all segments from table segments2pointgps
*
*/
function get_s2p($limit)
{
	//link to the global database connexion
	global $bdd;

	//query 
	$qry = $bdd->prepare('SELECT * FROM segments2pointgps
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

/**
*	Returns ALL segments contained in a rectangle defined
*	by four points : latMin, latMax, lonMin, lonMax
*
*/
function get_segment_from_position($latMin, $latMax, $lonMin, $lonMax)
{
	//link to the global database connexion
	global $bdd;

	//query 
	$qry = $bdd->prepare('SELECT s.id, distance, note, idnodea, pa.lat as lata, 
						  	     pa.lon as lona, idnodeb, pb.lat as latb, 
							     pb.lon as lonb

						    FROM segments s, pointgps pa, pointgps pb

						   WHERE EXISTS(SELECT NULL
						                  FROM segments2pointgps s2p, pointgps p
						                 WHERE s.id=s2p.idsegment AND s2p.idpointgps = p.id
						                HAVING MIN(p.lat) > '.$latMin.' AND MAX(p.lat) < '.$latMax.' AND
						                	   MIN(p.lon) > '.$lonMin.' AND MAX(p.lon) < '.$lonMax.')

						 		  AND idnodea=pa.id AND idnodeb=pb.id');

	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$segments = $qry->fetchAll();
	
	return $segments;
}

/**
*	Returns all the points for a segment matching the id
*	 
*/
function get_segment_points_by_id($idSegment)
{
	//link to the global database connexion
	global $bdd;

	//query 
	$qry = $bdd->prepare('SELECT p.id, p.lat, p.lon
 						    FROM segments2pointgps s2p, pointgps p
						   WHERE s2p.idsegment='.$idSegment.' AND s2p.idpointgps=p.id');

	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$segments = $qry->fetchAll();
	
	return $segments;
}

/**
*	Returns all the segments with the osm segment id
*	 
*/
function get_segment_by_idosm($idSegment)
{
	//link to the global database connexion
	global $bdd;

	//query 
	$qry = $bdd->prepare('SELECT *
 						    FROM segments
						   WHERE idsegosm='.$idSegment);

	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$segments = $qry->fetchAll();
	
	return $segments;
}

/**
*	Insert into DB a segment
*
*/
function insert_segment_into_segments($anIdsegosm, $aDistance, 
									  $aNote, $anIdnodea, $anIdnodeb)
{
	//link to the global database connexion
	global $bdd;
	
	try
	{
	    $qry = $bdd->prepare('INSERT INTO segments (idsegosm, distance, note,
	    								  idnodea, idnodeb)
	    			     values ('.$anIdsegosm.','.$aDistance.','
	    					  	 .$aNote.','.$anIdnodea.','.$anIdnodeb.')
	    			  RETURNING id');

		$qry->setFetchMode(PDO::FETCH_ASSOC);
		$qry->execute();
		$id = $qry->fetchAll();

		return $id;
	}
	catch(Exception $e)
	{
	    die('Erreur : '.$e->getMessage());
	}
	return null;
}

/**
*	Insert into DB a segment list of gps points
*	The first & last points are nodes
*/
function insert_segment_into_s2p($anIdsegment, $listPoints)
{
	//link to the global database connexion
	global $bdd;

	$arrayLength = count($listPoints)-1;
	try
	{
		$bdd->beginTransaction();

		foreach ($listPoints as $key => $idpoint) 
		{
			if ($key==0 OR $key==$arrayLength) 
			{
				//	NODE
				$bdd->exec('INSERT INTO segments2pointgps 
		    				values ('.$anIdsegment.','.$listPoints[$key].',true);');
			}
		    else
		    {
		    	//	NOT A NODE
		    	$bdd->exec('INSERT INTO segments2pointgps 
		    				values ('.$anIdsegment.','.$listPoints[$key].',false);');
		    }
	    }
	    $bdd->commit();


		return true;
	}
	catch(Exception $e)
	{
	    die('Erreur : '.$e->getMessage());
	}
	return false;
}

/**
*	Delete segment by id from s2p & return deleted item
*
*/
function delete_from_s2p_by_id($anIdsegment)
{
	//link to the global database connexion
	global $bdd;

	try
	{
	    $qry = $bdd->prepare('DELETE FROM segments2pointgps
	    			     	  WHERE idsegment='.$anIdsegment.'
	    			          RETURNING *');
	    
		$qry->setFetchMode(PDO::FETCH_ASSOC);
		$qry->execute();
		$deletedItem = $qry->fetchAll();

		return $deletedItem;
	}
	catch(Exception $e)
	{
	    die('Erreur : '.$e->getMessage());
	}
	return null;
}

/**
*	Delete segment by id from table segments & return deleted item
*
*/
function delete_from_segments_by_id($anIdsegment)
{
	//link to the global database connexion
	global $bdd;

	try
	{
	    $qry = $bdd->prepare('DELETE FROM segments
	    			     	  WHERE id='.$anIdsegment.'
	    			          RETURNING *');
	    
		$qry->setFetchMode(PDO::FETCH_ASSOC);
		$qry->execute();
		$deletedItem = $qry->fetchAll();

		return $deletedItem;
	}
	catch(Exception $e)
	{
	    die('Erreur : '.$e->getMessage());
	}
	return null;
}