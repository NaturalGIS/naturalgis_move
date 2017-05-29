<?php 
	include 'utils.php';
	
	$conn = getDbConnection();
	
	$safeInputs = makeSafeArray($_REQUEST);
	
	if (strlen($safeInputs['sys_class']) > 0){
		$sql = "SELECT row_number() over() as id, column_name as text FROM information_schema.columns WHERE table_schema = 'dados' AND table_name = 'especies' AND column_name != 'gid' AND column_name ILIKE '%".$safeInputs['sys_class']."%';";
	} else {
		$sql = "SELECT row_number() over() as id, column_name as text FROM information_schema.columns WHERE table_schema = 'dados' AND table_name = 'especies' AND column_name != 'gid';";
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