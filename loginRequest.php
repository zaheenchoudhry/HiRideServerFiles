<?php
	require "connectionRequest.php";
	
	$user_email = $_POST["email"];
	$user_password = $_POST["password"];
	$user_isPasswordEncrypted = (int)$_POST["isPasswordEncrypted"];

	if (strlen($user_password) >= 8) {
		$encryptedPassword = $user_password;
		if ($user_isPasswordEncrypted == 0) {
			// encrypt password
		}
		
		$account_query_result = $mysql_connection->query("SELECT * FROM Users WHERE EmailId = '".$user_email."' and password = '".$encryptedPassword."' LIMIT 1");
		
		if ($account_query_result->num_rows > 0) {
			while ($row = mysqli_fetch_array($account_query_result)) {
				$rows[] = $row;
			}
			echo json_encode(array("AppUserAccount"=>$rows));
		} else {
			echo "invalid";
		}
	}
	
	mysqli_close($mysql_connection);
?>