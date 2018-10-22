#!/usr/bin/php
<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$filename = '/home/roydem/database/logging/dbLog.txt';


//Open dbLog file and append contents to an array
if (file_exists($filename)){
	echo "This file $filename exists"."<br>";
	$file = fopen("/home/roydem/database/logging/dbLog.txt","r");
$errorArray = [];
while(! feof($file)){
        array_push($errorArray, fgets($file));
}

fclose($file);

//
$request = array();
$request['type'] = "db";
$request['error_string'] = $errorArray;
$returnedValue = createClientForRmq($request);

//Append contents to a history file that will not be deleted after sending
$fp = fopen("/home/roydem/database/logging/dbLogHistory.txt", "a");
for($i = 0; $i < count($errorArray); $i++){
        fwrite($fp, $errorArray[$i]);
}


file_put_contents("/home/roydem/database/logging/dbLog.txt", "");

//If file to append to does not exists, create one
} else {
	echo "The file $filename does not exist." . "<br>" . "Creating now.". "<br>";
	$create = fopen($filename, 'w') or die ('Cannot create file');
}


//RMQ client function
function createClientForRmq($request){
        $client = new rabbitMQClient("rabbitMQ_error.ini", "testServer");
       
        if(isset($argv[1])){
            $msg = $argv[1];
        }
        else{
            $msg = "client";
        }
        $response = $client->send_request($request);
        return $response;
}
    
    
?>
