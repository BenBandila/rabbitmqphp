<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
/*
if (!isset($_POST))
{
	$msg = "NO POST MESSAGE SET, POLITELY FUCK OFF";
        echo json_encode($msg);
        exit(0);
}
 */

//$username = $_POST["username"];
//$password = $_POST["password"];
$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
$request = array();
$request['type'] = "login";
$request['username'] = "ben";
$request['password'] = "password";
$request['message'] = "HI";
$response = $client->send_request($request);
print_r($response);
if ($response == 1)
{
	$msg = "Login Successful";
}
echo json_encode($msg);
exit(0);



/*
if (!isset($_POST))
{
	$msg = "NO POST MESSAGE SET, POLITELY FUCK OFF";
	echo json_encode($msg);
	exit(0);
}
$request = $_POST;
$response = "unsupported request type, politely FUCK OFF";
switch ($request["type"])
{
	case "login":
		$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
		$toSend = array();
		$toSend['type'] = "login";
		$toSend['username'] = $request["uname"];
		$toSend['password'] = $request["pword"];
		$request['message'] = "HI";
		$rabbitResponse = $client->send_request($toSend);
		if ($rabbitResponse == 1)
		{
			$response = "Login Successful!");
		} else {
			$response = "Invalid Login, Try Again");
		}
		//$response = "login, yeah we can do that";
		
		$connection = new AMQPStreamConnection('127.0.0.1', 5672, 'test', 'test', 'testHost');//change localhost to broker host
	        $channel = $connection->channel();
	        $username = $request["uname"];
		$password = $request["pword"];
		$channel->exchange_declare('testExchange', 'direct', false, false, false);
		$channel->queue_declare('testQueue', false, false, false, false);
		$channel->queue_bind('testQueue', 'testExchange', 'test_key');
	        $array = Array( "username" => $username, "password" => $password );
	        $json = json_encode($array);
	        //file_put_content("login.json", $json);

	        $msg = new AMQPMessage($json);
		$channel->basic_publish($msg, 'testExchange', 'test_key');

		$channel->close();
		$connection->close();
		
		break;
}
echo json_encode($response);
exit(0);
 */
?>
