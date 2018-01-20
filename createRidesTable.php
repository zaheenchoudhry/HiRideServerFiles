<?php
	require "connectionRequest.php";
	
	$result = $mysql_connection->query("CREATE TABLE Rides (
		RideId BIGINT(18) NOT NULL AUTO_INCREMENT,
		OwnerUserId BIGINT(18) NOT NULL,
		RideActive TINYINT NOT NULL,
		Day TINYINT NOT NULL,
		Date TINYINT NOT NULL,
		Month TINYINT NOT NULL,
		Year SMALLINT NOT NULL,
		Hour TINYINT NOT NULL,
		Minute TINYINT NOT NULL,
		SeatsTotal SMALLINT NOT NULL,
		SeatsBooked SMALLINT NOT NULL,
		Price FLOAT NOT NULL,
		PickupAddressFull TEXT NOT NULL,
		DropoffAddressFull TEXT NOT NULL,
		PickupAddressDisplay TEXT NOT NULL,
		DropoffAddressDisplay TEXT NOT NULL,
		PickupCity TINYTEXT NOT NULL,
		DropoffCity TINYTEXT NOT NULL,
		PickupLatitude DECIMAL(10,7) NOT NULL,
		PickupLongitude DECIMAL(10,7) NOT NULL,
		DropoffLatitude DECIMAL(10,7) NOT NULL,
		DropoffLongitude DECIMAL(10,7) NOT NULL,
		PRIMARY KEY (RideId),
		FOREIGN KEY (OwnerUserId) REFERENCES Users(UserId))");
	
	if ($result) {
		echo "Rides table created";
	} else {
		echo "Rides table not created";
	}
	
	mysqli_close($mysql_connection);
?>