<?php
	$db_name = "hiridedb";
	$mysql_username = "root";
	$mysql_password = "dodopenguin2";
	$server_name = "35.190.135.214";
	
	$mysql_connection = mysqli_connect($server_name, $mysql_username, $mysql_password, $db_name);
	
	if (mysqli_connect_errno($mysql_connection)) {
		echo "failed connection";
		//echo "Failed to connect: " . mysqli_connect_error();
	}
?>