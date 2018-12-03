#!/usr/bin/php
<?php
require_once('/home/roydem/database/path.inc');
require_once('/home/roydem/database/get_host_info.inc');
require_once('/home/roydem/database/rabbitMQLib.inc');

#This script creates the tar file
exec('./tar_gen.sh ');


#Connect to mysql
$mydb = new mysqli('192.168.1.4','test','4321password','test');
if ($mydb->errno != 0){
	echo "Failed to connect to database: ".$mydb->error.PHP_EOL;
	exit(0);
}


#Variables that can be set......
$type = 	readline("Enter Type: ");		#IE.. bundle
$package = 	readline("Enter Package: ");		#IE.. backend
$tier = 	readline("Enter Tier: ");		#IE.. QA
$packageName =	readline("Enter PackageName: ");	#IE.. filename


#You can only set rollback version if type == rollback
if ($type == 'rollback'){
	$rollbackVersion = readline("Enter version to rollback to: ");
}

if ($type =='rollback' OR 'deploy'){
        $ipAddress = readline("Enter IP Address: ");
}

#Starting Version Number
$increment_value = "1";


#Find filename is exists from user input
$query = mysqli_query($mydb, "SELECT * FROM Builds WHERE filename = '$packageName'");
$count = mysqli_num_rows($query);


#If type is bundle do
if ($type == 'bundle'){
	if ($count){
        	#Get last version number
        	$check = mysqli_query($mydb, "SELECT * FROM Builds WHERE filename = '$packageName' ORDER BY (version+0) DESC LIMIT 1");
        	$row = mysqli_fetch_assoc($check);
        	$version = $row['version'];
        	echo "File Already Exists! Creating next version #" . ($version + $increment_value);
	}else{
        	echo "Unknown File! Creating Version #1";
        	$version = "0";
	}
}

#If type is deploy do
if ($type == 'deploy'){
	#Get last version number
	$check = mysqli_query($mydb, "SELECT * FROM Builds WHERE filename = '$packageName' ORDER BY (version+0) DESC LIMIT 1");
	$row = mysqli_fetch_assoc($check);
	$version = $row['version'];
	echo "Deploying " .  $packageName . "-" . $version;
}

if ($type == 'rollback'){
	$check = mysqli_query($mydb, "SELECT * FROM Builds WHERE filename = '$packageName' AND version = '$rollbackVersion'");
	$row = mysqli_fetch_assoc($check);
	if ($row){
		echo "File Found! Rolling back!";
	}
}


#RabbitMQ Stuff
$client = new rabbitMQClient("deployclientrabbitMQServer.ini","testServer");
$request = array();
$request['type'] = $type;
$request['package'] = $package;
$request['tier'] = $tier;
$request['packageName'] = $packageName;

if ($type == 'bundle'){
	$request['version'] = $version + $increment_value;
}
if ($type == 'deploy'){
        $request['version'] = $version;
}

if ($type == 'rollback'){
	$request['rollbackversion'] = $rollbackVersion;
}

if ($type == 'deploy' OR 'rollback'){
	$request['ipAddress'] = $ipAddress;
}

$response = $client->send_request($request);


//print_r($response);
echo "\n";

#renames tar based on user input if type is bundle, then scps to deploy
if ($type == 'bundle'){
	#rename the generated tar file
	rename("/home/roydem/backups/database-backup.tgz","/home/roydem/backups/".$request['packageName']."-".$request['version'].".tgz");
	#scp tar to deploy server
	exec('./scp_tar.sh ');

}


?>
