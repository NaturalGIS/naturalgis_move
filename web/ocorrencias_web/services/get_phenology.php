<?php 
	include 'utils.php';
	
	$conn = getDbConnection();
	
	$safeInputs = makeSafeArray($_REQUEST);
	
	if (strlen($safeInputs['phenology']) > 0){
		$sql = "SELECT gid as id, fenologia as text FROM dados.fenologias WHERE fenologia ILIKE '%".$safeInputs['phenology']."%' ORDER BY fenologia";
	} else {
		$sql = "SELECT gid as id, fenologia as text FROM dados.fenologias ORDER BY gid";
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
