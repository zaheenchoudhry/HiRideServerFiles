<?php
	require "connectionRequest.php";
	
	$ride_owner_user_id = (int)$_GET["ownerUserId"];
	
	$query_result = $mysql_connection->query("SELECT * FROM Users WHERE UserId = '".$ride_owner_user_id."');
	
	while($row = mysqli_fetch_array($query_result)){
		$rows[] = $row;
	}
 
	echo json_encode(array("user"=>$rows));
  
	mysqli_close($mysql_connection);
?>
