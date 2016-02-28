<?php

	//Ouverture du fichier en écriture
	$fichier = fopen(Controller::NOM_FICHIER_Input, 'a');

	ftruncate($fichier, 0);
	
	//Insertion dans le fichier des résultat. 
	$res = new ContenerResultat();
	$res->data = array($paramToAlgo, $resPoints, $resArete);
	
	fputs($fichier, json_encode($res));
	//var_dump($res);
				
	fclose($fichier);
