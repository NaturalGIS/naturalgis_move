<?php 
	include 'utils.php';
	
	$conn = getDbConnection();
	
	$safeInputs = makeSafeArray($_REQUEST);
	
	if (strlen($safeInputs['type']) > 0){
		$sql = "SELECT gid as id, tipo as text FROM dados.tipos WHERE tipo ILIKE '%".$safeInputs['type']."%' ORDER BY tipo;";
	} else {
		$sql = "SELECT gid as id, tipo as text FROM dados.tipos ORDER BY gid;";
	}
		
	$query = pg_query($conn, $sql);
	$data = array();
	if (pg_num_rows($query) > 0){
		$data = pg_fetch_all($query);
		echo json_encode($data);
	} else {
		echo '{}';
	}
	
	pg_close($conn);
?>
