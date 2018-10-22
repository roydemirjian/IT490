#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


//ERROR LOGGING

//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('log_errors', TRUE);
//ini_set('error_log', '/home/roydem/database/logging/dbLog.txt');
//ini_set('log_errors_max_len', 1024);


//$filename = '/home/roydem/database/logging/rmqDatabase_error.txt';


function writeError($error, $filename){
      $fp = fopen($filename . '.txt', "a");
      for ($i = 0; $i < count ($error); $i++){
              fwrite ($fp, $error[$i]);
      }
      return true;
}



function requestProcessor($request)
{
  echo "received request".PHP_EOL;

  echo $request['type'];

  var_dump($request);

  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "frontend":
	echo "FRONT END: ";
	$message = writeError($request['error_string'], '/home/roydem/database/logging/rmqFrontend_error');
	echo "Results: ";
	break;
    case "db":
	echo "DATABASE: ";
	$message = writeError($request['error_string'], '/home/roydem/database/logging/rmqDatabase_error');
	//echo "Results: " . $message;
	break;
    case "dmz":
	echo "DMZ: ";
        $message = writeError($request['error_string'], '/home/roydem/database/logging/rmqDmz_error');
	echo "Results: "; 
	break;
    
  }

  //echo $message;
  return $message;
}



$server = new rabbitMQServer("rabbitMQ_error.ini","testServer");

echo "ErrorLogging BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "ErrorLogging END".PHP_EOL;
exit();
?>

