#!/usr/bin/php
<?php
$mydb =  mysqli_connect("192.168.1.7","newuser","4321password","test");
 
if ($mydb->errno != 0){

	echo "Failed to connect to database: ".$mydb->error.PHP_EOL;
	exit(0);
}

echo "<br><br>Successfully connected to database".PHP_EOL;

$query = mysqli_query($mydb, "INSERT INTO Builds VALUES('test','123')");




?>
