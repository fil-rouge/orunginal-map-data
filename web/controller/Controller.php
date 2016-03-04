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

/**
*	Returns the routes matching the criterias from $params
*	
*	0. Extract the parameters
*	1. Get closer point to $deb & closer point to $fin
*	2. Get segments contained in the rectangle area
*	3. Print the located segments to param.json file
*	4. Call algorithm to find solutions
*	5. Fill the solutions with the GPS points for the app to display the solutions
*	6. Return the solutions to the app
*/
function getRoutes($params)
{
	//format the params to get only the name
	$paramsFormatted = explode(";", $params, 9);
	
	//	START & END POINTS
	$latDeb = $paramsFormatted[0];
	$lonDeb = $paramsFormatted[1];
	$latFin = $paramsFormatted[2];
	$lonFin = $paramsFormatted[3];
	
	//	RECTANGLE COORDINATES
	$lat1 = $paramsFormatted[4];
	$lat2 = $paramsFormatted[5];
	$long1 = $paramsFormatted[6];
	$long2 = $paramsFormatted[7];

	//	DISTANCE
	$distance = $paramsFormatted[8];


}