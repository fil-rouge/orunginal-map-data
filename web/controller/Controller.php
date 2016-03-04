<?php
$webDir = dirname(__DIR__);
include_once($webDir.'/model/connexion_sql.php');

/**
 * Process action corresponding to http get from main
 * @param unknown $request
 * @param unknown $params
 */
function analyzeRequest($request, $params)
{
	global $webDir;

	switch($request)
	{
		case "displayPoints":
			include_once('pointGPS/index.php');
			break;

		case "displaySegments":
			include_once('segment/index.php');
			break;

		case "displayNodes":
			include_once('node/index.php');
			break;

		case "parse":
			include_once($webDir.'/model/pointGPS/PointGpsService.php');
			include_once($webDir.'/model/pointGPS/PointGPS.class.php');
			include_once($webDir.'/model/segment/SegmentService.php');
			include_once('Writer.php');
			include_once('parserOsm.php');
			break;

		case "getDistances":
			include_once($webDir.'/controller/segment/index.php');
			update_distances(10000);
			echo "DONE : Check file scripts/setDistance.sql !<br/>";
			break;

		case "getRoutes":
			if (!empty($params))
			{
				getRoutes($params);
			}
			else
				print "ERROR: No parameters !";
			break;
		case "serializeDB":
			include_once($webDir.'/model/pointGPS/PointGpsService.php');
			include_once($webDir.'/model/segment/SegmentService.php');
			include_once('Writer.php');
			include_once('DatabaseSerializer.php');
			break;
		default:
			print "Action not found";
			break;			
	}
}