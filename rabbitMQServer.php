#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


//ERROR LOGGING

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('log_errors', TRUE);
ini_set('error_log', '/home/roydem/database/logging/dbLog.txt');
ini_set('log_errors_max_len', 1024);



function doLogin($userName,$userPass)
{
        //lookup username and password in database

	//Connect to DB
	$mydb = new mysqli('192.168.1.4','newuser','4321password','users');
	
	if ($mydb->errno != 0){

		echo "Failed to connect to database: ".$mydb->error.PHP_EOL;
		exit(0);
	}

	echo "<br><br>Successfully connected to database".PHP_EOL;

	//Select username and password from the database 
	$query = mysqli_query($mydb,"SELECT * FROM users WHERE user_name = '$userName' AND password = '$userPass'");
	$count = mysqli_num_rows($query);

	//Check if credentials match the database
	if ($count == 1){
		//Match	
		echo "<br><br>USERS CREDENTIALS VERIFIED";
		return true;
	}else{
		//No Match
		echo "<br><br>WHO THE FUCK ARE YOU";
		return false;
	}
	
	//$response = $mydb->query($query);
	if ($mydb->errno !=0){
		echo "<br><br>Failed to execute query: ".PHP_EOL;
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

                echo "<br><br>Failed to connect to database: ".$mydb->error.PHP_EOL;
                exit(0);
        }
        echo "<br><br>Successfully connected to database".PHP_EOL;

	//Check is user already exists
        $query = mysqli_query($mydb,"SELECT * FROM Users WHERE username = '$userName' ");
        $count = mysqli_num_rows($query);

	//Check if credentials match the database....if there is a match then the user already has an account 
        if ($count == 1){
		//Credentials match existing database records
                echo "<br><br>YOU ALREADY HAVE AN ACCOUNT";
                return true;
        }else{
		//Create new user account if its unique 
	        $query2 = mysqli_query($mydb,"INSERT INTO Users VALUES (NULL,'$userName', '$userPass')");
                echo "<br><br>ACCOUNT HAS BEEN MADE";
                //return false;
        }

        if ($mydb->errno !=0){
                echo "<br><br>Failed to execute query: ".PHP_EOL;
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



$server = new rabbitMQServer("rabbitMQ_database.ini","testServer");

echo "rabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "rabbitMQServer END".PHP_EOL;
exit();
?>

