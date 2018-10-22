#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


//ERROR LOGGING

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('log_errors', TRUE);
ini_set('error_log', dirname(__FILE__). '/../logging/log.txt');
ini_set('log_errors_max_len', 1024);



function doLogin($userName,$userPass)
{
        //lookup username and password in database

	//Connect to DB
	$mydb = new mysqli('127.0.0.1','test','4321password','test');
	
	if ($mydb->errno != 0){

		echo "Failed to connect to database: ".$mydb->error.PHP_EOL;
		exit(0);
	}

	echo "Successfully connected to database".PHP_EOL;

	//Check DB if username and password match
	$query = mysqli_query($mydb,"SELECT * FROM Users WHERE username = '$userName' AND password = '$userPass'");
	$count = mysqli_num_rows($query);
	
	if ($count == 1){
		//Match	
		echo "USERS CREDENTIALS VERIFIED";
		return true;
	}else{
		//No Match
		echo "WHO THE FUCK ARE YOU";
		return false;
	}
	
	//$response = $mydb->query($query);
	if ($mydb->errno !=0){
		echo "Failed to execute query: ".PHP_EOL;
		echo __FILE__.':'.__LINE__.":error: ".$mydb->error.PHP_EOL;
		exit(0);
	}

}
	

function doRegister($userName,$userPass)
{
        //lookup username in database

	//Connect to DB
        $mydb = new mysqli('127.0.0.1','test','4321password','test');

        if ($mydb->errno != 0){

                echo "Failed to connect to database: ".$mydb->error.PHP_EOL;
                exit(0);
        }
        echo "Successfully connected to database".PHP_EOL;

	//Check is user already exists
        $query = mysqli_query($mydb,"SELECT * FROM Users WHERE username = '$userName' AND password = '$userPass'");
        $count = mysqli_num_rows($query);

        if ($count == 1){
		//Credentials match existing database records
                echo "YOU ALREADY HAVE AN ACCOUNT";
                return true;
        }else{
		//Create new user account if its unique 
	        $query = mysqli_query($mydb,"INSERT INTO Users (username, password) VALUES ('$userName', '$userPass'");
                echo "ACCOUNT HAS BEEN MADE";
                //return false;
        }

        if ($mydb->errno !=0){
                echo "Failed to execute query: ".PHP_EOL;
                echo __FILE__.':'.__LINE__.":error: ".$mydb->error.PHP_EOL;
                exit(0);
        }




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
    case "login":
      return doLogin($request['username'],$request['password']);
    case "validate_session":
      return doValidate($request['sessionId']);
    case "register":
      return doRegister($request['username'],$request['password']);
	    
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}



$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>

