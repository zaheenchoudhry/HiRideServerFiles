<?php
	require "connectionRequest.php";
	
	$result = $mysql_connection->query("CREATE TABLE Users (
		UserId BIGINT(18) NOT NULL AUTO_INCREMENT,
		AccountType TINYINT NOT NULL,
		Name TEXT NOT NULL,
		PhoneNumber VARCHAR(20),
		EmailId TEXT,
		Password CHAR(64),
		FacebookAccountNumber VARCHAR(40),
		FacebookProfileLinkURI TEXT,
		FacebookProfilePicURI TEXT,
		AcceptsCash TINYINT NOT NULL,
		AcceptsInAppPayments TINYINT NOT NULL,
		PrefersMusic TINYINT NOT NULL,
		PrefersDrinks TINYINT NOT NULL,
		PrefersExtraLuggage TINYINT NOT NULL,
		PrefersPets TINYINT NOT NULL,
		PRIMARY KEY(UserId))");
	
	if ($result) {
		echo "Users table created";
	} else {
		echo "Users table not created";
	}
	
	mysqli_close($mysql_connection);
?>