#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doLogin($username,$password)
{
    $mydb = new mysqli('127.0.0.1', 'testuser', '12345', 'testdb');

    if ($mydb->errno != 0){
        echo "failed to connect to database: " . $mydb->error . PHP_EOL;
	exit(0);
    }

    //check if user exists in database
    $query = "select * from users where username = " . $username;//change to correct database column names
    $response = $mydb->query($query);
    if ($mydb->errno != 0){
        echo "failed to execute query: " . PHP_EOL;
	echo __FILE__ . ':' . __LINE__ . ":error: " . $mydb->error . PHP_EOL;
	exit(0);//replace with return false?? or a message that says user not found
    }
    //if user exists check if passwords match
    $query = "select * from users where username = " . $username . " and password = " . $password;//makes sure that the username and password match, eliminates cases where different people use the same password
    $response = $mydb->query($query);
    //check if query works
    if ($mydb->errno != 0){
        echo "failed to execute query: " . PHP_EOL;
	echo __FILE . ':' . __LINE__ . ":error: " . $mydb->error . PHP_EOL;
	exit(0);//replace with return false?? or a message that says wrong password
    } else {
	return true;
    }
    // lookup username in databas
    // check password
    //return true;
    //return false if not valid
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
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

$server->process_requests('requestProcessor');
exit();
?>

