<?php

function dbConnect(){

	$hostname = '127.0.0.1';
	$username = 'test';
	$password = '4321password';
	$dbname = 'test';

/*

	$con = mysqli_connect($hostname, $username, $password, $dbname);

	if (!$con){
		echo "Error connecint got database: ".$con->connect_errno.PHP_EOL;
		exit(1);
	}
	echo "Connection established to database".PHP_EOL;
	return $con;

 */


	$con = new mysqli($servername, $username, $password, $dbname);

	if (mysqli_connect_errno()){
        	echo "<br><br>Failed to connect to MySQL: " . mysqli_connect_error();
	}


	echo " Succesfully connected to MySql.<br><br><br>";




}

?>
