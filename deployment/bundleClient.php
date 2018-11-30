#!/usr/bin/php
<?php
require_once('/home/roydem/database/path.inc');
require_once('/home/roydem/database/get_host_info.inc');
require_once('/home/roydem/database/rabbitMQLib.inc');

#This script creates the tar file
exec('./tar_gen.sh ');

#Connect to mysql
$mydb = new mysqli('192.168.1.186','test','4321password','test');
if ($mydb->errno != 0){
	echo "Failed to connect to database: ".$mydb->error.PHP_EOL;
	exit(0);
}

#Variables that can be set......
$type = 	readline("Enter Type: ");		#IE.. bundle
$package = 	readline("Enter Package: ");		#IE.. backend
$tier = 	readline("Enter Tier: ");		#IE.. QA
$packageName =	readline("Enter PackageName: ");	#IE.. filename


#Starting Version Number
$increment_value = "1";

#Find filename is exists from user input
$query = mysqli_query($mydb, "SELECT * FROM Builds WHERE filename = '$packageName'");
$count = mysqli_num_rows($query);


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

if ($type == 'deploy'){
	#Get last version number
	$check = mysqli_query($mydb, "SELECT * FROM Builds WHERE filename = '$packageName' ORDER BY (version+0) DESC LIMIT 1");
	$row = mysqli_fetch_assoc($check);
	$version = $row['version'];
	echo "Deploying " .  $packageName . "-" . $version;
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

$response = $client->send_request($request);


//print_r($response);
echo "\n";

if ($type == 'bundle'){
	#rename the generated tar file
	rename("/home/roydem/backups/database-backup.tgz","/home/roydem/backups/".$request['packageName']."-".$request['version'].".tgz");
	#scp tar to deploy server
	exec('./scp_tar.sh ');

}


?>
