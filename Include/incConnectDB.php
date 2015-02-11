<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

	//* Open a MySQL connection - includes file to do this
	$connection = new mysqli("[type host URL here for database","type user name here", "type password here", "type database name here");
	if(!$connection) {
			die('Connection failed: ' . $connection->error());
	}
?>
