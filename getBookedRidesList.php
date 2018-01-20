<?php
	require "connectionRequest.php";

	$passenger_user_id = (int)$_POST["passengerUserId"];

	$get_passenger_rides_query_result = $mysql_connection->query("
		SELECT Bookings.RideId, Bookings.BookingId, Bookings.SeatsBookedByPassenger, Bookings.PaymentType, Bookings.HasPayed, Rides.*
		FROM Bookings, Rides
		WHERE Bookings.PassengerUserId = '".$passenger_user_id."' AND Bookings.RideId = Rides.RideId");

	$rides = array();
	
	while($ride = mysqli_fetch_assoc($get_passenger_rides_query_result)){
		$rides[] = $ride;
	}

	foreach (array_keys($rides) as $i) {

		$get_driver_query_result = $mysql_connection->query("
			SELECT Users.UserId, Users.AccountType, Users.Name, Users.PhoneNumber, Users.FacebookAccountNumber, Users.FacebookProfileLinkURI, Users.FacebookProfilePicURI, Users.AcceptsCash, Users.AcceptsInAppPayments, Users.PrefersMusic, Users.PrefersDrinks, Users.PrefersExtraLuggage, Users.PrefersPets
			FROM Users
			WHERE Users.UserId = '".$rides[$i]["OwnerUserId"]."'
			LIMIT 1");

		$drivers = array();

		while($driver = mysqli_fetch_assoc($get_driver_query_result)){
			$drivers[] = $driver;
		}

		$rides[$i]["Driver"] = $drivers;
	}
 
	echo json_encode(array("bookedRidesList"=>$rides));

	mysqli_close($mysql_connection);
?>