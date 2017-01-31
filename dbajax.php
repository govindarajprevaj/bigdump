<?php
error_reporting(0);

$dbhost   = isset($_POST["dbhost"]) ? $_POST["dbhost"] : 'localhost';
$db_name     = isset($_POST["dbname"]) ? $_POST["dbname"] : 'test';
$dbusername = isset($_POST["dbuser"]) ? $_POST["dbuser"] : 'root';
$dbpassword = isset($_POST["dbpass"]) ? $_POST["dbpass"] : ''; 
try 
{
	$link = mysqli_connect ($dbhost, $dbusername, $dbpassword); 
	if ($link) {
		$query = "SHOW DATABASES";
		$result = mysqli_query($link , $query);
		$row = mysqli_fetch_array($result);
		$database = array();
		while($result_val = mysqli_fetch_array($result))
		{
				array_push($database,$result_val['Database']);
		}
		mysqli_close($link);
		$resultjson['status'] = true;
		$resultjson['db'] = $database;
	}
	else
	{
		throw new Exception('cannot connect to db.');
	}
}
catch (Exception $e)
{
	$resultjson['status'] = false;
	$resultjson['message'] = $e->getMessage();
}
echo json_encode($resultjson);