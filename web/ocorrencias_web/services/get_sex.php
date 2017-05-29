<?php 
	include 'utils.php';
	
	$conn = getDbConnection();
	
	$safeInputs = makeSafeArray($_REQUEST);
	
	if (strlen($safeInputs['sex']) > 0){
		$sql = "SELECT gid as id, sexo as text FROM dados.sexos WHERE sexo ILIKE '%".$safeInputs['sex']."%'";
	} else {
		$sql = "SELECT gid as id, sexo as text FROM dados.sexos ORDER BY gid";
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