<?php
	require "connectionRequest.php";
	
	$user_account_type = (int)$_POST["accountType"];
	$user_name = $_POST["name"];
	$user_phone_number = (int)$_POST["phoneNumber"];
	$user_email = $_POST["email"];
	$user_password = $_POST["password"];
	
	if (strlen($user_password) >= 8) {
		$id = $mysql_connection->query("SELECT UserId FROM Users WHERE EmailId = '".$user_email."' LIMIT 1");
		if ($id->num_rows > 0) {
			echo "exists";
			exit;
		}
		
		$result = $mysql_connection->query("INSERT INTO Users(
			UserId,
			AccountType,
			Name,
			PhoneNumber,
			EmailId,
			Password,
			FacebookAccountNumber,
			FacebookProfileLinkURI,
			FacebookProfilePicURI,
			AcceptsCash,
			AcceptsInAppPayments,
			PrefersMusic,
			PrefersDrinks,
			PrefersExtraLuggage,
			PrefersPets)
		VALUES(
			DEFAULT,
			'".$user_account_type."',
			'".$user_name."',
			'".$user_phone_number."',
			'".$user_email."',
			'".$user_password."',
			'-1',
			'',
			'',
			'1',
			'1',
			'1',
			'0',
			'0',
			'0')
		");
		
		if ($result) {
			$account_query_result = $mysql_connection->query("SELECT * FROM Users WHERE EmailId = '".$user_email."' LIMIT 1");
		
			while ($row = mysqli_fetch_array($account_query_result)) {
				$rows[] = $row;
			}
		 
			echo json_encode(array("AppUserAccount"=>$rows));
		} else {
			echo "failed";
		}
	} else {
		echo "failed";
	}
	
	mysqli_close($mysql_connection);
?>