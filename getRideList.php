<?php
	require "connectionRequest.php";
	
	$query_result = $mysql_connection->query("SELECT * FROM Rides");
	
	while($row = mysqli_fetch_array($query_result)){
		$rows[] = $row;
	}
 
	echo json_encode(array("rideList"=>$rows));
 
	mysqli_close($mysql_connection);
?>