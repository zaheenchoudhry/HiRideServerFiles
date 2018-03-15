<?php
	require "connectionRequest.php";
	$filter = '';

	if (isset($_GET['PickupCity'])) {
		$filter = 'WHERE PickupCity=\'' . htmlspecialchars($_GET['PickupCity']) . '\'';
	}	
	
	if (isset($_GET['DropOffCity'])) {
		if ($filter != ';) {
			$filter .= " AND ";
		} else {
			$filter .= "WHERE";
		}
		$filter = "DropOffCity='" . htmlspecialchars($_GET['DropOffCity']) . "'";
	}	

	$query_result = $mysql_connection->query("SELECT * FROM Rides $filter");
	
	$rows = array();

	while($row[0] = mysqli_fetch_array($query_result)){
		$get_driver_query_result = $mysql_connection->query("
			SELECT * FROM Users
			WHERE Users.UserId = '".$row[0]["OwnerUserId"]."'
			LIMIT 1");
		$row[1] = $get_driver_query_result
		$rows[] = $row;
	}
 
	echo json_encode(array("rideList"=>$rows));
 
	mysqli_close($mysql_connection);
?>
