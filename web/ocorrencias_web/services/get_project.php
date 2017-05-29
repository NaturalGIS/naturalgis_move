<?php 
	include 'utils.php';
	
	$conn = getDbConnection();
	
	$safeInputs = makeSafeArray($_REQUEST);
	
	if (strlen($safeInputs['project']) > 0){
		$sql = "SELECT gid as id, projecto as text FROM dados.projectos WHERE projecto ILIKE '%".$safeInputs['project']."%' ORDER BY projecto ASC;";
	} else {
		$sql = "SELECT gid as id, projecto as text FROM dados.projectos ORDER BY projecto ASC;";
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
