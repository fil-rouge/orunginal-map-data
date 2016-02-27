<?php

	include_once(dirname(__DIR__).'/../dbconf.php');

	// Connexion à la base de données
	try
	{
	    $bdd = new PDO('pgsql:host=' . $host . ';port=5432;dbname=' . $db . ';user=' . $username . ';password=' . $password );
	}
	catch(Exception $e)
	{
	    die('Erreur : '.$e->getMessage());
	}
