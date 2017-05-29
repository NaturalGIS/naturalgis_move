<?php 
	include 'utils.php';
	
	$conn = getDbConnection();
	
	$safeInputs = makeSafeArray($_REQUEST);
	
	if (strlen($safeInputs['age']) > 0){
		$sql = "SELECT gid as id, idade as text FROM dados.idades WHERE idade ILIKE '%".$safeInputs['age']."%'";
	} else {
		$sql = "SELECT gid as id, idade as text FROM dados.idades ORDER BY gid";
	}
	
	$query = pg_query($conn, $sql);
	if (pg_num_rows($query) > 0){
		$data = pg_fetch_all($query);
		echo json_encode($data);
	} else {
		echo '{}';
	}
	
	pg_close($conn);
?>