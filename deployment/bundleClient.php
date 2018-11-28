#!/usr/bin/php
<?php
require_once('/home/roydem/database/path.inc');
require_once('/home/roydem/database/get_host_info.inc');
require_once('/home/roydem/database/rabbitMQLib.inc');


#execute script to make a tar file of database
//shell_exec('sh backuptest.sh');

$version = "1";
//putenv("version=$version_num");
//$version = escapeshellarg($version);

exec('./backuptest.sh ');



$client = new rabbitMQClient("deployclientrabbitMQServer.ini","testServer");
$request = array();
$request['type'] = "bundle";
$request['package'] = "BE";
$request['tier'] = "QA";
$request['packageName'] = "backendPackage";
$request['version'] = $version;
$response = $client->send_request($request);
//print_r($response);
echo "\n";
?>
