<?php 
	include 'utils.php';
	
	$conn = getDbConnection();
	
	$safeInputs = makeSafeArray($_REQUEST);
	
	if (strlen($safeInputs['legendclc5']) > 0){
		$sql = "SELECT distinct(descri) as text FROM dados.clc5_evora WHERE descri ILIKE '%".$safeInputs['legendclc5']."%' ORDER BY descri;";
	} else {
		$sql = "SELECT distinct(descri) as text FROM dados.clc5_evora ORDER BY descri;";
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
