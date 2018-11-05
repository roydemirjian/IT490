#!/usr/bin/php
<?php
$mydb =  mysqli_connect('192.168.1.6','newuser','4321password','users');
 
if ($mydb->errno != 0){

	echo "Failed to connect to database: ".$mydb->error.PHP_EOL;
	exit(0);
}

echo "<br><br>Successfully connected to database".PHP_EOL;


$query = mysqli_query($mydb,"SELECT * FROM users");

while ($row = mysqli_fetch_assoc($query)){
	echo $row['id'];
	echo "\n";
	echo $row['user_name'];
	echo"\n";
	echo $row['password'];
	echo "\n\n";
}



?>
