<?php

function dbConnection(){

	$hostname = '127.0.0.1';
	$user = 'test';
	$pass = '4321password';
	$dbname = 'test';

	$connection = mysqli_connect($hostname, $user, $pass, $dbname);

	if (!$connection){
		echo "Error connecint got database: ".$connection->connect_errno.PHP_EOL;
		exit(1);
	}
	echo "Connection established to database".PHP_EOL;
	return $connection;
}

?>
