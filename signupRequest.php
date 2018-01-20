<?php
	require "connectionRequest.php";
	
	$user_name = $_POST["name"];
	$user_email = $_POST["email"];
	$user_password = $_POST["password"];
	
	$result = $mysql_connection->query("INSERT INTO User(number, name, email, password)
	VALUES(DEFAULT, '".$user_name."', '".$user_email."', '".$user_password."')");
	
	if ($result) {
		echo "New User Created";
	} else {
		echo "User Not created";
	}
	
	mysqli_close($mysql_connection);
?>