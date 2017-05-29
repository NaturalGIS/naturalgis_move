<?php 
	include 'utils.php';
	
	$conn = getDbConnection();
	
	$safeInputs = makeSafeArray($_REQUEST);
	
	if (strlen($safeInputs['behavior']) > 0){
		$sql = "SELECT gid as id, comportamento as text FROM dados.comportamentos WHERE comportamento ILIKE '%".$safeInputs['behavior']."%' ORDER BY comportamento;";
	} else {
		$sql = "SELECT gid as id, comportamento as text FROM dados.comportamentos ORDER BY gid";
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
