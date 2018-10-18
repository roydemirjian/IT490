#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


//ERROR LOGGING

//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('log_errors', TRUE);
//ini_set('error_log', dirname(__FILE__). '/../logging/log.txt');
//ini_set('log_errors_max_len', 1024);


function writeError($error, $filename){
	$fileopen = fopen($filename . '.txt', "a");
	for ($i = 0; $i < count ($error); $i++){
		fwrite ($fileopen, $error[$i]);
	}
	return true;
}


function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);

  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "frontend":
	echo "FRONT END: ";
	$response = writeError($request['error_string'], 'frontend_error');
	echo "Results: " . $response;
	break;
    case "db":
	echo "DATABASE: ";
	$response = writeError($request['error_string'], 'database_error');
	echo "Results: " . $response;
	break;
    case "dmz":
	echo "DMZ: ";
	$response = writeError($request['error_string'], 'dmz_error');
	echo "Results: " . $response;
	break;
    
  }
  echo $response;
  return $response;
}



$server = new rabbitMQServer("rabbitMQ_error.ini","testServer");

echo "ErrorLogging BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "ErrorLogging END".PHP_EOL;
exit();
?>

