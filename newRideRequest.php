<?php
	require "connectionRequest.php";
	
	$ride_owner_user_id = (int)$_POST["ownerUserId"];
	$ride_day = (int)$_POST["day"];
	$ride_date = (int)$_POST["date"];
	$ride_month = (int)$_POST["month"];
	$ride_year = (int)$_POST["year"];
	$ride_hour = (int)$_POST["hour"];
	$ride_minute = (int)$_POST["minute"];
	$ride_seats = (int)$_POST["seats"];
	$ride_price = floatval($_POST["price"]);
	$ride_pickup_address_full = $_POST["pickupAddressFull"];
	$ride_dropoff_address_full = $_POST["dropoffAddressFull"];
	$ride_pickup_address_display = $_POST["pickupAddressDisplay"];
	$ride_dropoff_address_display = $_POST["dropoffAddressDisplay"];
	$ride_pickup_city = $_POST["pickupCity"];
	$ride_dropoff_city = $_POST["dropoffCity"];
	$ride_pickup_latitude = $_POST["pickupLatitude"];
	$ride_pickup_longitude = $_POST["pickupLongitude"];
	$ride_dropoff_latitude = $_POST["dropoffLatitude"];
	$ride_dropoff_longitude = $_POST["dropoffLongitude"];
	$ride_id = (int)$_POST["rideId"];
	
	$result = "";
	if (isset($_POST["rideId"])) {
		$result = $mysql_connection->query("UPDATE Rides SET 
			Day = '".$ride_day."', 
			Date = '".$ride_date."', 
			Month = '".$ride_month."', 
			Year = '".$ride_year."', 
			Hour = '".$ride_hour."', 
			Minute = '".$ride_minute."', 
			SeatsTotal = '".$ride_seats."', 
			Price = '".$ride_price."', 
			PickupAddressFull = '".$ride_pickup_address_full."', 
			DropoffAddressFull = '".$ride_dropoff_address_full."', 
			PickupAddressDisplay = '".$ride_pickup_address_display."', 
			DropoffAddressDisplay = '".$ride_dropoff_address_display."', 
			PickupCity = '".$ride_pickup_city."', 
			DropoffCity = '".$ride_dropoff_city."', 
			PickupLatitude = '".$ride_pickup_latitude."', 
			PickupLongitude = '".$ride_pickup_longitude."', 
			DropoffLatitude = '".$ride_dropoff_latitude."', 
			DropoffLongitude = '".$ride_dropoff_longitude."' 
			WHERE RideId = ".$ride_id."");
	} else {
		$result = $mysql_connection->query("INSERT INTO Rides(
			RideId,
			OwnerUserId,
			RideActive,
			Day,
			Date,
			Month,
			Year,
			Hour,
			Minute,
			SeatsTotal,
			SeatsBooked,
			Price,
			PickupAddressFull,
			DropoffAddressFull,
			PickupAddressDisplay,
			DropoffAddressDisplay,
			PickupCity,
			DropoffCity,
			PickupLatitude,
			PickupLongitude,
			DropoffLatitude,
			DropoffLongitude)
		VALUES(
			DEFAULT,
			'".$ride_owner_user_id."',
			'1',
			'".$ride_day."',
			'".$ride_date."',
			'".$ride_month."',
			'".$ride_year."',
			'".$ride_hour."',
			'".$ride_minute."',
			'".$ride_seats."',
			'0',
			'".$ride_price."',
			'".$ride_pickup_address_full."',
			'".$ride_dropoff_address_full."',
			'".$ride_pickup_address_display."',
			'".$ride_dropoff_address_display."',
			'".$ride_pickup_city."',
			'".$ride_dropoff_city."',
			CAST('".$ride_pickup_latitude."' AS DECIMAL(10,7)),
			CAST('".$ride_pickup_longitude."' AS DECIMAL(10,7)),
			CAST('".$ride_dropoff_latitude."' AS DECIMAL(10,7)),
			CAST('".$ride_dropoff_longitude."' AS DECIMAL(10,7)))
		");
	}
	
	if ($result) {
		$inserted_ride_id = -1;
		if (isset($_POST["rideId"])) {
			$inserted_ride_id = $ride_id;
		} else {
			$inserted_ride_id = $mysql_connection->insert_id;
		}
		
		$should_update = false;
		$query_statement = "UPDATE Users SET ";
		
		if (isset($_POST["acceptsCash"])) {
			$query_statement .= "AcceptsCash=".(int)$_POST["acceptsCash"]."";
			$should_update = true;
		}
		
		if (isset($_POST["acceptsInappPayments"])) {
			if ($should_update) {
				$query_statement .= ", ";
			}
			$query_statement .= "AcceptsInAppPayments=".(int)$_POST["acceptsInappPayments"]."";
			$should_update = true;
		}
		
		if (isset($_POST["prefersMusic"])) {
			if ($should_update) {
				$query_statement .= ", ";
			}
			$query_statement .= "PrefersMusic=".(int)$_POST["prefersMusic"]."";
			$should_update = true;
		}
		
		if (isset($_POST["prefersDrinks"])) {
			if ($should_update) {
				$query_statement .= ", ";
			}
			$query_statement .= "PrefersDrinks=".(int)$_POST["prefersDrinks"]."";
			$should_update = true;
		}
		
		if (isset($_POST["prefersExtraLuggage"])) {
			if ($should_update) {
				$query_statement .= ", ";
			}
			$query_statement .= "PrefersExtraLuggage=".(int)$_POST["prefersExtraLuggage"]."";
			$should_update = true;
		}
		
		if (isset($_POST["prefersPets"])) {
			if ($should_update) {
				$query_statement .= ", ";
			}
			$query_statement .= "PrefersPets=".(int)$_POST["prefersPets"]."";
			$should_update = true;
		}
		
		$query_statement .= " WHERE UserId=".$ride_owner_user_id."";
		
		if ($should_update) {
			$prefs_update_result = $mysql_connection->query($query_statement);
		}
		
		$booked_seats_query_result = $mysql_connection->query("SELECT SeatsBooked FROM Rides WHERE RideId = ".$inserted_ride_id."");
		$booked_seats = $booked_seats_query_result->fetch_object()->SeatsBooked;
		
		$result_to_echo = "success " . $inserted_ride_id . " " . $booked_seats;
		echo $result_to_echo;
	} else {
		echo "failed";
		//echo "failed " . $mysql_connection->error;
	}
	
	mysqli_close($mysql_connection);
?>