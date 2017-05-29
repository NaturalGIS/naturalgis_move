<?php 
	include 'utils.php';
	
	$conn = getDbConnection();
	
	$safeInputs = makeSafeArray($_REQUEST);
	
	$sql = "SELECT gid as id, especie, nome_vulgar from dados.especies WHERE especie ilike '%".$safeInputs['especie']."%' or nome_vulgar ilike '%".$safeInputs['especie']."%' ORDER BY especie";
	$query = pg_query($conn, $sql);
	if (pg_num_rows($query) > 0){
		$srcData = pg_fetch_all($query);
		$finalData = Array();
		for ($i = 0; $i < count($srcData); $i++){
			$finalData[$i]['id'] = $srcData[$i]['id'];
			if ($srcData[$i]['nome_vulgar'] == ''){
				$finalData[$i]['text'] = $srcData[$i]['especie'];
			} else {
				$finalData[$i]['text'] = $srcData[$i]['especie'].' | '.$srcData[$i]['nome_vulgar'];
			}
		}
		echo json_encode($finalData);
	} else {
		echo '{}';
	}
	
	pg_close($conn);
?>