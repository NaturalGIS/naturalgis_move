<?php 
	include 'utils.php';
	
	$conn = getDbConnection();
	
	$safeInputs = makeSafeArray($_REQUEST);
	
	if (strlen($safeInputs['method']) > 0){
		$sql = "SELECT gid as id, metodo as text FROM dados.metodos WHERE metodo ILIKE '%".$safeInputs['method']."%' ORDER BY metodo ASC;";
	} else {
		$sql = "SELECT gid as id, metodo as text FROM dados.metodos ORDER BY  metodo ASC;";
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
