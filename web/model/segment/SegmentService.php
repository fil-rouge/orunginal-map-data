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
	$qry = $bdd->prepare('SELECT segments.id, distance, note, na.id as idnodea, 
								 na.idpoint as idpointa, pa.lat as lata, 
								 pa.lon as lona, nb.id as idnodeb, 
								 nb.idpoint as idpointb, pb.lat as latb, 
								 pb.lon as lonb, idpointgps 

						  FROM   segments, nodes as na, nodes as nb, 
						  	     pointgps as pa, pointgps as pb, segments2pointgps 

						  WHERE  segments.idnodea=na.id AND 
						  		 segments.idnodeb=nb.id AND 
						  		 na.idpoint=pa.id AND nb.idpoint=pb.id
						  		 AND segments.id=idsegment
						  
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
	    					  		  .$aNote.','.$anIdnodea.','.$anIdnodeb.')');
		$qry->execute();
		return true;
	}
	catch(Exception $e)
	{
	    die('Erreur : '.$e->getMessage());
	}
	return false;
}

/**
*	Insert into DB a segment list of gps points
*
*/
function insert_segment_into_s2p($anIdsegment, $listPoints, $isnode)
{
	//link to the global database connexion
	global $bdd;
	var_dump($listPoints);
	echo "<br/>";
	var_dump($isnode);
	try
	{
		if ($isnode) {
			$qry = $bdd->prepare('INSERT INTO segments2pointgps 
	    					      values ('.$anIdsegment.','.$listPoints.',
	    					  		  		true)');
		}
	    else
	    {
	    	$qry = $bdd->prepare('INSERT INTO segments2pointgps 
	    					  	  values ('.$anIdsegment.','.$listPoints.',
	    					  		  		false)');
	    }
	    
	    $qry->execute();
		echo "Executed ok !";
		return true;
	}
	catch(Exception $e)
	{
	    die('Erreur : '.$e->getMessage());
	}
	return false;
}