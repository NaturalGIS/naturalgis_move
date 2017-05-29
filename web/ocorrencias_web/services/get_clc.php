<?php 
	include 'utils.php';
	
	$conn = getDbConnection();
	
	$safeInputs = makeSafeArray($_REQUEST);
	
	if (strlen($safeInputs['legend']) > 0){
		$sql = "SELECT distinct(legenda) as text FROM dados.clc3_2006 WHERE legenda ILIKE '%".$safeInputs['legend']."%' ORDER BY legenda;";
	} else {
		$sql = "SELECT distinct(legenda) as text FROM dados.clc3_2006 ORDER BY legenda;";
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
