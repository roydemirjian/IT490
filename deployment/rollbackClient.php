#!/usr/bin/php
<?php
require_once('/home/roydem/database/path.inc');
require_once('/home/roydem/database/get_host_info.inc');
require_once('/home/roydem/database/rabbitMQLib.inc');

$client = new rabbitMQClient("deployrabbitMQServer.ini","testServer");
$request = array();
$request['type'] = "rollback";
$request['package'] = "BE";
$request['tier'] = "QA";
$request['packageName'] = "backendPackage-v";
$response = $client->send_request($request);
//print_r($response);
echo "\n";
?>
