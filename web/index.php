<?php
	
	require_once 'db_conf/dbconfig.php';

	echo "Test access BDD locale</br>";

	$dsn = "pgsql:host=$host;port=5432;dbname=$db;user=$username;password=$password";

	try{
		// create a PostgreSQL database connection
		$conn = new PDO($dsn);

		// display a message if connected to the PostgreSQL successfully
		if($conn){
			echo "Connected to the <strong>$db</strong> database successfully!</br>";

			$qry = $conn->prepare('SELECT name FROM test_table');
			$qry->setFetchMode(PDO::FETCH_ASSOC);
			$qry->execute();
			$rows = $qry->fetchAll();
			foreach($rows as $row) {
			  echo 'Nom: '    . $row['name']    . '<br/>';
			}
		}
	}catch (PDOException $e){
		// report error message
		echo $e->getMessage();
	}
?>