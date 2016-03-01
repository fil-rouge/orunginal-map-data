<?php

include_once(dirname(__DIR__).'/model/connexion_sql.php');

/**
 * Process action corresponding to http get from main
 * @param unknown $request
 * @param unknown $params
 */
function analyzeRequest($request, $params)
{
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
			include_once(dirname(__DIR__).'/model/pointGPS/PointGpsService.php');
			include_once('parserOsm.php');
			break;

		case "getRoutes":
			// if (!empty($params))
			// {
			// 	$this->getByLocalisation($params);
			// }
			// else
			// 	print "erreur, paramétres non renseigner pour la requête getByLocalisation";
			break;
		case "dessinerGraphe":
			// $this->dessinerGraphe();
			break;
		default:
			print "Action not found";
			break;			
	}
}