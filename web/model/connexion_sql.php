<?php

	include_once(dirname(__DIR__).'/../dbconf.php');

	// Connexion à la base de données
	try
	{
		$dbopts = parse_url(getenv('DATABASE_URL'));

        $bdd = new PDO('pgsql:host=' . $dbopts["host"] . ';port='. $dbopts["port"] .';dbname=' . ltrim($dbopts["path"],'/') .
        			   ';user=' . $dbopts["user"] . ';password=' . $dbopts["pass"] );

	    //$bdd = new PDO('pgsql:host=' . $host . ';port=5432;dbname=' . $db . ';user=' . $username . ';password=' . $password );
	}
	catch(Exception $e)
	{
	    die('Erreur : '.$e->getMessage());
	}
