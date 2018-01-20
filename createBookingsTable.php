<?php
	require "connectionRequest.php";

	$result = $mysql_connection->query("CREATE TABLE Bookings (
		BookingId BIGINT(18) NOT NULL AUTO_INCREMENT,
		RideId BIGINT(18) NOT NULL,
		OwnerUserId BIGINT(18) NOT NULL,
		PassengerUserId BIGINT(18) NOT NULL,
		SeatsBookedByPassenger SMALLINT NOT NULL,
		PaymentType TINYINT NOT NULL,
		HasPayed TINYINT NOT NULL DEFAULT '0',
		PRIMARY KEY (BookingId),
		FOREIGN KEY (RideId) REFERENCES Rides(RideId),
		FOREIGN KEY (OwnerUserId) REFERENCES Users(UserId),
		FOREIGN KEY (PassengerUserId) REFERENCES Users(UserId))");

	if ($result) {
		echo "Bookings table created";
	} else {
		echo "Bookings table not created";
	}

	mysqli_close($mysql_connection);
?>