<?php 
	include 'utils.php';
	
	$conn = getDbConnection();
	
	$safeInputs = makeSafeArray($_REQUEST);
	
	if (strlen($safeInputs['val']) > 0){
		$sql = "SELECT distinct(".$safeInputs['sys_class_val'].") as text FROM dados.especies WHERE ".$safeInputs['sys_class_val']." ILIKE '%".$safeInputs['val']."%' AND ".$safeInputs['sys_class_val']." IS NOT NULL ORDER BY " . $safeInputs['sys_class_val'] . ";";
	} else {
		$sql = "SELECT distinct(".$safeInputs['sys_class_val'].") as text FROM dados.especies WHERE ".$safeInputs['sys_class_val']." IS NOT NULL ORDER BY " . $safeInputs['sys_class_val'] . ";";
	}
		
	$query = pg_query($conn, $sql);
	$data = array();
	if (pg_num_rows($query) > 0){
		$srcData = pg_fetch_all($query);
		$counter = 1;
		for ($i = 0; $i < count($srcData); $i++){
			$data[$i]['id'] = $counter;
			$data[$i]['text'] = $srcData[$i]['text'];
			$counter += 1;
		}
		echo json_encode($data);
	} else {
		echo '{}';
	}
	
	pg_close($conn);
?>
