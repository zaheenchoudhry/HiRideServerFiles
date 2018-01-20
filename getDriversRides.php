<?php
	require "connectionRequest.php";
	
	$ride_owner_user_id = (int)$_POST["ownerUserId"];
	
	$query_result = $mysql_connection->query("SELECT * FROM Rides WHERE OwnerUserId = '".$ride_owner_user_id."' AND RideActive = '1'");
	
	while($row = mysqli_fetch_array($query_result)){
		$rows[] = $row;
	}
 
	echo json_encode(array("rideList"=>$rows));
 
	mysqli_close($mysql_connection);
?>