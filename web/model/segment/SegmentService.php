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
	/*
	$qry = $bdd->prepare('SELECT s.id, distance, note, idnodea, pa.lat as lata,
						  	     pa.lon as lona, idnodeb, pb.lat as latb,
							     pb.lon as lonb

						    FROM segments s, pointgps pa, pointgps pb

						   WHERE EXISTS(SELECT NULL
						                  FROM segments2pointgps s2p, pointgps p
						                 WHERE s.id=s2p.idsegment AND s2p.idpointgps = p.idosm
						                HAVING MIN(p.lat) > '.$latMin.' AND MAX(p.lat) < '.$latMax.' AND
						                	   MIN(p.lon) > '.$lonMin.' AND MAX(p.lon) < '.$lonMax.')

						 		  AND idnodea=pa.idosm AND idnodeb=pb.idosm');*/
	$qry = $bdd->prepare('SELECT s.id, distance, note, idnodea, pa.lat as lata,
										 		pa.lon as lona, idnodeb, pb.lat as latb,
									 			pb.lon as lonb

												FROM segments s, pointgps pa, pointgps pb

								 				WHERE s.idnodea=pa.idosm AND s.idnodeb=pb.idosm AND
															pa.lat > '.$latMin.' AND pa.lat < '.$latMax.' AND
															pa.lon > '.$lonMin.' AND pa.lon < '.$lonMax.' AND
															pb.lat > '.$latMin.' AND pb.lat < '.$latMax.' AND
															pb.lon > '.$lonMin.' AND pb.lon < '.$lonMax);

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
	$qry = $bdd->prepare('SELECT idosm, lat, lon
 						    FROM segments2pointgps s2p, pointgps
						   WHERE s2p.idsegment='.$idSegment.' AND s2p.idpointgps=idosm');

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


/********************************************************************/
//					TABLES S2P/S - INSERT/DELETE/UPDATE
/********************************************************************/

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

/**
*	Sets the distance for a segment
*
*/
function set_distance($anIdsegment, $aDistance)
{
	global $webDir;

	//query to get ALL GPS points from database
	$line='UPDATE segments SET distance='.$aDistance.' WHERE id='.$anIdsegment.';';
	append_to_file($webDir.'/../scripts/setDistances.sql', $line);
}


/********************************************************************/
//					TABLE S2P - STATISTICS
/********************************************************************/


/**
*	For each node, returns the number of segments it links
*
*/
function find_intersection_in_s2p($limit)
{
	//link to the global database connexion
	global $bdd;

	//query to get ALL GPS points from database
	$qry = $bdd->prepare('SELECT idpointgps, COUNT(*) as nb
						  FROM segments2pointgps
						  WHERE isnode=true
						  GROUP BY idpointgps
						  ORDER BY nb DESC
						  LIMIT '.$limit);

	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$rows = $qry->fetchAll();

	return $rows;
}

/**
*	Returns the number of rows in table segments2pointgps
*
*/
function count_rows_in_s2p()
{
	//link to the global database connexion
	global $bdd;

	//query to get ALL GPS points from database
	$qry = $bdd->prepare('SELECT COUNT(*) FROM segments2pointgps');

	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$rows = $qry->fetchAll();

	return $rows;
}

/**
*	Returns the number of rows in table segments2pointgps
*
*/
function count_nodes_in_s2p()
{
	//link to the global database connexion
	global $bdd;

	//query to get ALL GPS points from database
	$qry = $bdd->prepare('SELECT COUNT(*)
						  FROM segments2pointgps
						  WHERE isnode=true');

	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$rows = $qry->fetchAll();

	return $rows;
}


/**
*	Returns the number of rows in table segments
*
*/
function count_rows_in_segments()
{
	//link to the global database connexion
	global $bdd;

	//query to get ALL GPS points from database
	$qry = $bdd->prepare('SELECT COUNT(*) FROM segments');

	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$rows = $qry->fetchAll();

	return $rows;
}


/**********************************************************************************/
//							DatabaseSerializer - SERVICES
/**********************************************************************************/
/**
*	Returns all ways which are intersections matching idsegment
*
*/
function get_NDs_by_id($idsegment)
{
	//link to the global database connexion
	global $bdd;

	//query to get ALL GPS points from database
	$qry = $bdd->prepare('SELECT *
						  FROM segments2pointgps s2p
						  WHERE idsegment='.$idsegment.' AND isnode=true');

	$qry->setFetchMode(PDO::FETCH_ASSOC);
	$qry->execute();
	$rows = $qry->fetchAll();

	return $rows;
}
