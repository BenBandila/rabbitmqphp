<?php


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
		//$response = "login, yeah we can do that";
		$connection = new AMQPStreamConnection('localhost', 5672, 'test', 'test');//change localhost to broker host
	        $channel = $connection->channel();
	        $username = $_POST['username'];
	        $password = $_POST['password'];
	        $array = Array( "username" => $username, "password" => $password );
	        //$json = json_encode($array);
	        //file_put_content("login.json", $json);

	        $msg = new AMQPMessage($array);
	        $channel->basic_publish($msg);
		break;
}
echo json_encode($response);
exit(0);

?>
