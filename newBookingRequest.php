<?php
	require "connectionRequest.php";

	$ride_owner_user_id = (int)$_POST["ownerUserId"];
	$booking_id = (int)$_POST["bookingId"];
	$ride_id = (int)$_POST["rideId"];
	$passenger_user_id = (int)$_POST["passengerUserId"];
	$seats_booked = (int)$_POST["seatsBookedByPassenger"];
	$payment_type = (int)$_POST["PaymentType"];
	$has_payed = (int)$_POST["HasPayed"];
	$phone_number = (int)$_POST["bookingUserPhoneNumber"];

	$result = "";

	if (isset($_POST["bookingId"])) {
		$result = $mysql_connection->query("UPDATE Bookings SET
			RideId = '".$ride_id."',
			OwnerUserId = '".$ride_owner_user_id."',
			PassengerUserId = '".$passenger_user_id."',
			SeatsBookedByPassenger = '".$seats_booked."',
			PaymentType = '".$payment_type."',
			HasPayed = '".$has_payed."',
			WHERE BookingId = ".$booking_id."");
	} else {
		$result = $mysql_connection->query("INSERT INTO Bookings(
			BookingId,
			RideId,
			OwnerUserId,
			PassengerUserId,
			SeatsBookedByPassenger,
			PaymentType,
			HasPayed
			)
		VALUES(
			DEFAULT,
			'".$ride_id."',
			'".$ride_owner_user_id."',
			'".$passenger_user_id."',
			'".$seats_booked."',
			'".$payment_type."',
			'0')
		");
	}

	if ($result) {
		$inserted_booking_id = -1;
		if (isset($_POST["bookingId"])) {
			$inserted_booking_id = $booking_id;
		} else {
			$inserted_booking_id = $mysql_connection->insert_id;
		}

		$should_update = false;
		$query_statement = "UPDATE Users SET ";

		if (isset($_POST["bookingUserPhoneNumber"])) {
			if ($should_update) {
				$query_statement .= ", ";
			}
			$query_statement .= "bookingUserPhoneNumber=".(int)$_POST["bookingUserPhoneNumber"]."";
			$should_update = true;
		}

		$query_statement .= " WHERE UserId=".$passenger_user_id."";

		if ($should_update) {
			$prefs_update_result = $mysql_connection->query($query_statement);
		}

		// $booked_seats_query_result = $mysql_connection->query("SELECT SeatsBooked FROM Rides WHERE RideId = ".$inserted_ride_id."");
		// $booked_seats = $booked_seats_query_result->fetch_object()->SeatsBooked;

		$result_to_echo = "success " . $inserted_booking_id . " " . $booked_seats;
		echo $result_to_echo;
	} else {
		echo "failed";
		//echo "failed " . $mysql_connection->error;
	}

	mysqli_close($mysql_connection);
?>
