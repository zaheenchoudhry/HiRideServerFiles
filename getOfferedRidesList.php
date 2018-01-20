<?php
	require "connectionRequest.php";

	$ride_owner_user_id = (int)$_POST["ownerUserId"];

	$get_rides_query_result = $mysql_connection->query("SELECT *
		FROM Rides
		WHERE Rides.OwnerUserId = '".$ride_owner_user_id."' AND Rides.RideActive = '1'");

	$rides = array();
	
	while($ride = mysqli_fetch_assoc($get_rides_query_result)){
		$rides[] = $ride;
	}

	foreach (array_keys($rides) as $i) {

		$get_passengers_query_result = $mysql_connection->query("
			SELECT Users.UserId, Users.AccountType, Users.Name, Users.PhoneNumber, Users.FacebookAccountNumber, Users.FacebookProfileLinkURI, Users.FacebookProfilePicURI, Bookings.BookingId, Bookings.SeatsBookedByPassenger, Bookings.PaymentType, Bookings.HasPayed
			FROM Users, Bookings
			WHERE Bookings.RideId = '".$rides[$i]["RideId"]."' AND Users.UserId = Bookings.PassengerUserId");

		$passengers = array();

		while($passenger = mysqli_fetch_assoc($get_passengers_query_result)){
			$passengers[] = $passenger;
		}

		$rides[$i]["PassengerList"] = $passengers;
	}
 
	echo json_encode(array("offeredRidesList"=>$rides));

	mysqli_close($mysql_connection);
?>