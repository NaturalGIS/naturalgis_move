<?php 
	include 'utils.php';
	
	$conn = getDbConnection();
	
	$safeInputs = makeSafeArray($_REQUEST);
	
	if (count($safeInputs) != 3){
		exit ('{"success": false, "msg": "Não foram passados parâmetros suficientes no pedido."}');
	}
	
	if ($safeInputs['grid'] == 10){
		$sql = "SELECT utm as folha, st_x(st_centroid(geom)) as x, st_y(st_centroid(geom)) as y
				FROM dados.grelha_utm_10 
				WHERE st_intersects(geom, st_setsrid(st_point(".$safeInputs['x'].",".$safeInputs['y']."), 32629));";
	} else {
		$sql = "SELECT tetrada as folha, st_x(st_centroid(geom)) as x, st_y(st_centroid(geom)) as y
				FROM dados.grelha_utm_2 
				WHERE st_intersects(geom, st_setsrid(st_point(".$safeInputs['x'].",".$safeInputs['y']."), 32629));";
	}
		
	$query = pg_query($conn, $sql);
	$data = array();
	if (pg_num_rows($query) > 0){
		$data = pg_fetch_all($query);
		echo '{"success": true , "data": '.json_encode($data).'}';
	} else {
		echo '{"success": false, "msg": "Não foi possível cruzar o seu ponto com as grelhas existentes. Certifique-se que o seu ponto está localizado dentro das grelhas mostradas no mapa."}';
	}
	
	pg_close($conn);
?>