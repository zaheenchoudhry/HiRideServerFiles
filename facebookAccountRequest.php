<?php
	require "connectionRequest.php";
	
	$user_account_type = (int)$_POST["accountType"];
	$user_name = $_POST["name"];
	$user_fb_account_number = $_POST["facebookAccountNumber"];
	$user_fb_profile_link_uri = $_POST["facebookProfileLinkURI"];
	$user_fb_profile_pic_uri = $_POST["facebookProfilePicURI"];
	
	if (strlen($user_fb_account_number) > 1) {
		$account_query_result = $mysql_connection->query("SELECT * FROM Users WHERE FacebookAccountNumber = '".$user_fb_account_number."' LIMIT 1");
		if ($account_query_result->num_rows <= 0) {
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
				'0',
				'',
				'',
				'".$user_fb_account_number."',
				'".$user_fb_profile_link_uri."',
				'".$user_fb_profile_pic_uri."',
				'1',
				'1',
				'1',
				'0',
				'0',
				'0')
			");
			
			if ($result) {
				$account_query_result = $mysql_connection->query("SELECT * FROM Users WHERE FacebookAccountNumber = '".$user_fb_account_number."' LIMIT 1");
			}
		}
		
		if ($account_query_result->num_rows > 0) {}
			while ($row = mysqli_fetch_array($account_query_result)) {
				$rows[] = $row;
			}
			echo json_encode(array("FacebookUserAccount"=>$rows));
		} else {
			echo "";
		}
	}
	
	mysqli_close($mysql_connection);
?>