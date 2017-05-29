<?php
session_start(); // Starting Session

	include 'utils.php';
	
	$conn = getDbConnection();
	
	$safeInputs = makeSafeArray($_REQUEST);

	$utilizador = $_SESSION['login_user'];
        $nome_utilizador = $_SESSION['name_user'];
        $nome_projecto = $_SESSION['project'];

	$finaData = array();
	$freguesia = '';
	$osm = '';
	
	checkLength(array($safeInputs['obs'], $safeInputs['individuals_type'], $safeInputs['individuals'], $safeInputs['project'], $safeInputs['method'], $safeInputs['type'], $safeInputs['ano'], $safeInputs['dia'], $safeInputs['mes'], $safeInputs['hora'], $safeInputs['minutos'], $safeInputs['local_type'], $safeInputs['xcoord'], $safeInputs['ycoord'], $safeInputs['zona_atr'], $safeInputs['cons'], $safeInputs['anti']
	, $safeInputs['estrada']));
	
	$estradaoca=$safeInputs['estrada'];
	$_SESSION['estrada']=$estradaoca;
	$kmfloat = (float)$safeInputs['km'];
	
	$observation = $safeInputs['obs'];
	$indType = 'false';
	if ( $safeInputs['individuals_type'] != 'Exacto'){
		$indType = 'true';
	}
	
	$local_type = $safeInputs['local_type'];

	if ($observation == 'exacta'){
		//ec old
		//$ec = str_replace(' ', '_',strtolower($safeInputs['especie']));
		//ec new
		$ec1 = substr($safeInputs['especie'], 0, strpos($safeInputs['especie'], ' ', strpos($safeInputs['especie'], ' ')+1));
		$ec = str_replace(' ', '_',strtolower($ec1));
		//ec new end
		checkLength(array($safeInputs['phenology'], $safeInputs['especie'], $safeInputs['age'], $safeInputs['sex'], $safeInputs['behavior']));
		$finaData['phenology'] = $safeInputs['phenology'];
		$finaData['age'] = $safeInputs['age'];
		$finaData['sex'] = $safeInputs['sex'];
		$finaData['behavior'] = $safeInputs['behavior'];
		//especies with getPHP
		//$classSql = "SELECT reino, filo, subfilo, superclasse, classe, ordem, familia, genero, especie, nome_vulgar
		//			 FROM
		//				dados.especies
		//			 WHERE
		//				
		//				especie = '".$safeInputs['especie']."'";
		//especies with JSON
		$classSql = "SELECT reino, filo, subfilo, superclasse, classe, ordem, familia, genero, especie, nome_vulgar
					 FROM
						dados.especies
					 WHERE	
						especie = '".$ec1."'";						
		
		$classQuery = pg_query($conn, $classSql);
		if (pg_num_rows($classQuery) > 0){
			$class = pg_fetch_array($classQuery);
		} else {
			exit ('{"success": false, "msg": "Não foi possível obter a espécie equivalente à seleccionada"}');
		}
	} else { //observation == aproximate
		$ec = str_replace(' ', '_',strtolower($safeInputs['sys_class_val']));
		checkLength(array($safeInputs['phenology_aproximate'], $safeInputs['age_aproximate'], $safeInputs['sex_aproximate'], $safeInputs['behavior_aproximate'], $safeInputs['sys_class'], $safeInputs['sys_class_val']));
		$finaData['phenology'] = $safeInputs['phenology_aproximate'];
		$finaData['age'] = $safeInputs['age_aproximate'];
		$finaData['sex'] = $safeInputs['sex_aproximate'];
		$finaData['behavior'] = $safeInputs['behavior_aproximate'];
		
		$columSql = "SELECT row_number() over() as id, column_name as text FROM information_schema.columns
					 WHERE
						table_schema = 'dados' AND table_name = 'especies' AND column_name != 'gid'
					 ORDER BY id ASC";
		
		$columnQuery = pg_query($conn, $columSql);
		$srcColumns = pg_fetch_all($columnQuery);
		
		$found = false;
		$columns = array();
		$lastColumn = '';
		for ($i = 0; $i < count($srcColumns); $i++){
			if ($found == false){
				if ($safeInputs['sys_class'] == $srcColumns[$i]['text']){
					$found = true;
					$lastColumn = $srcColumns[$i]['text'];
				}
				$columns[$i] = $srcColumns[$i]['text'];
			} else {
				$columns[$i] = $lastColumn;
			}
		}
		
		$value = pg_escape_string($conn, $safeInputs['sys_class_val']);
		$classSql = "SELECT reino, filo, subfilo, superclasse, classe, ordem, familia, genero, especie, nome_vulgar
					 FROM
						dados.especies
					 WHERE
						".$safeInputs['sys_class']." = '".$value."'
					 LIMIT 1";
		$classQuery = pg_query($conn, $classSql);
		$class = array();
		$lastValue = '';
		$lastKey = '';
		$counter = 0;
		if (pg_num_rows($classQuery) > 0){
			$tmpClass = pg_fetch_assoc($classQuery);
			reset($tmpClass);
			
			while (list($key, $val) = each($tmpClass)){
				if ($key == $columns[$counter]){
					$class[$key] = $tmpClass[$key];
					$lastKey = $key;
					$lastValue = $tmpClass[$key];
					$counter += 1;
				} else {
					$class[$key] = $lastValue; 
				}
			}
			
			if ($lastKey == 'especie'){
				if ($tmpClass['nome_vulgar'] == ''){
					$class['nome_vulgar'] = $tmpClass['especie'];
				} else {
					$class['nome_vulgar'] = $tmpClass['nome_vulgar'];
				}
			}
		} else {
			exit ('{"success": false, "msg": "Não foi possível obter a espécie equivalente à seleccionada"}');
		}
		
	}
	
	$data = date('Y-m-d H:i:s', mktime($safeInputs['hora'], $safeInputs['minutos'], 0, ($safeInputs['mes'] + 1), $safeInputs['dia'], $safeInputs['ano']));
	
	//Localization
	if ($local_type != 'grid'){
		$coordenada_exacta = 'true';
		$intersectSql = "SELECT utm FROM dados.grelha_utm_10 WHERE st_intersects(geom, st_setsrid(st_point({$safeInputs['xcoord']}, {$safeInputs['ycoord']}), 32629));";
		$intersectQuery = pg_query($conn, $intersectSql);
		$utm10 = 'false';
		$utm2 = 'false';
		if (pg_num_rows($intersectQuery) != 1){
			exit ('{"success": false, "msg": "As coordenadas da observação não são coincidentes com as grelhas. Por favor corrija a localização do ponto da sua observação e submeta o formulário novamente."}');
		} else {
			$utm10Data = pg_fetch_assoc($intersectQuery);
		}
		
		$utm2Sql = "SELECT tetrada AS utm FROM dados.grelha_utm_2 WHERE st_intersects(geom, st_setsrid(st_point({$safeInputs['xcoord']}, {$safeInputs['ycoord']}), 32629));";
		$utm2Query = pg_query($conn, $utm2Sql);
		if (pg_num_rows($utm2Query) != 1){
			exit ('{"success": false, "msg": "As coordenadas da observação não são coincidentes com as grelhas. Por favor corrija a localização do ponto da sua observação e submeta o formulário novamente."}');
		} else {
			$utm2Data = pg_fetch_assoc($utm2Query);
		}
		
		$biotopoSql = "SELECT legenda FROM dados.clc3_2006 WHERE st_intersects(geom, st_setsrid(st_point({$safeInputs['xcoord']}, {$safeInputs['ycoord']}), 32629));";
		$biotopoQuery = pg_query($conn, $biotopoSql);
		if (pg_num_rows($biotopoQuery) != 1){
			exit ('{"success": false, "msg": "As coordenadas da observação não são coincidentes com nenhuma classe de ocupaçao do solo. Por favor corrija a localização do ponto da sua observação e submeta o formulário novamente."}');
		} else {
			$biotopo = pg_fetch_assoc($biotopoQuery);
		}

                $biotopoclc5Sql = "SELECT descri FROM dados.clc5_evora WHERE st_intersects(geom, st_setsrid(st_point({$safeInputs['xcoord']}, {$safeInputs['ycoord']}), 32629));";
                $biotopoclc5Query = pg_query($conn, $biotopoclc5Sql);
                $biotopoclc5 = pg_fetch_assoc($biotopoclc5Query);

		$estradamovesql = "SELECT a.nome AS move_estrada_auto, ((ST_Length(a.geom)/1000)*ST_LineLocatePoint(a.geom, ST_SetSRID(ST_MakePoint({$safeInputs['xcoord']},{$safeInputs['ycoord']}),32629))*100)/100 AS move_km_auto,
ST_Distance(a.geom, ST_SetSRID(ST_MakePoint({$safeInputs['xcoord']},{$safeInputs['ycoord']}),32629)) AS move_distancia_estrada_auto
FROM estradas_move.estradas_move a
WHERE ST_DWithin(a.geom, ST_SetSRID(ST_MakePoint({$safeInputs['xcoord']},{$safeInputs['ycoord']}),32629), 25) ORDER BY ST_Distance(a.geom, ST_SetSRID(ST_MakePoint({$safeInputs['xcoord']},{$safeInputs['ycoord']}),32629)) ASC LIMIT 1;";
                $estradamoveQuery = pg_query($conn, $estradamovesql);
                $estradamove = pg_fetch_assoc($estradamoveQuery);
		if (pg_num_rows($estradamoveQuery) != 0){
		$move_estrada_auto = $estradamove['move_estrada_auto'];
		$move_km_auto = $estradamove['move_km_auto'];
		$move_distancia_estrada_auto = $estradamove['move_distancia_estrada_auto'];
		} else {
		$move_estrada_auto = '';
		$move_km_auto = -1;
		$move_distancia_estrada_auto = -1;
		}
		
		$fregSql = "SELECT freguesia FROM dados.freguesias WHERE st_intersects(geom, st_setsrid(st_point({$safeInputs['xcoord']}, {$safeInputs['ycoord']}), 32629));";
		$fregQuery = pg_query($conn, $fregSql);
		if (pg_num_rows($fregQuery) != 1){
			exit ('{"success": false, "msg": "As coordenadas da observação não são coincidentes com nenhuma freguesia. Por favor corrija a localização do ponto da sua observação e submeta o formulário novamente."}');
		} else {
			$fregData = pg_fetch_assoc($fregQuery);
			$freguesia = $fregData['freguesia'];
		}
		
		$osmSql = "SELECT final.id, st_distance(final.geom, st_setsrid(st_point({$safeInputs['xcoord']}, {$safeInputs['ycoord']}), 32629)) AS distance
				   FROM (
				   		SELECT osm_id AS id, geom
				   		FROM
				   			dados.estradas_osm as a,
				   			(SELECT st_buffer(st_setsrid(st_point({$safeInputs['xcoord']}, {$safeInputs['ycoord']}), 32629), 25) as buffer) as b
				   		WHERE
				   			st_intersects(a.geom, b.buffer)
				   ) as final
				   ORDER BY distance ASC LIMIT 1";
		
		$osmQuery = pg_query($conn, $osmSql);
		if (pg_num_rows($osmQuery) > 0){
			$osmData = pg_fetch_assoc($osmQuery);
			$osm = $osmData['id'];
		}
	} else {
		//validate folha, grid
		checkLength(array($safeInputs['grid'], $safeInputs['folha']));
		$coordenada_exacta = 'false';
		$biotopo['legenda'] = $safeInputs['biotopo'];
		$biotopoclc5['descri'] = $safeInputs['biotopoclc5'];

	        $fregSql = "SELECT freguesia FROM dados.freguesias WHERE st_intersects(geom, st_setsrid(st_point({$safeInputs['xcoord']}, {$safeInputs['ycoord']}), 32629));";
		$fregQuery = pg_query($conn, $fregSql);
		$fregData = pg_fetch_assoc($fregQuery);
		$freguesia = $fregData['freguesia'];
	
		if ($safeInputs['grid'] == 'Grelha 10 km'){
			$utm10 = 'true';
			$utm2 = 'false';
			$utm10Data['utm'] = $safeInputs['folha'];
			$utm2Data['utm'] = '';
		} else {
			$utm10 = 'false';
			$utm2 = 'true';
			$utm2Data['utm'] = $safeInputs['folha'];
			
			$intersectSql = "SELECT utm FROM dados.grelha_utm_10 WHERE st_intersects(geom, st_setsrid(st_point({$safeInputs['xcoord']}, {$safeInputs['ycoord']}), 32629));";
			$intersectQuery = pg_query($conn, $intersectSql);
			if (pg_num_rows($intersectQuery) != 1){
				exit ('{"success": false, "msg": "As coordenadas da observação não são coincidentes com as grelhas. Por favor corrija a localização do ponto da sua observação e submeta o formulário novamente."}');
			} else {
				$utm10Data = pg_fetch_assoc($intersectQuery);
			}
		}
	}
	
	$nome_vulgar = pg_escape_string($conn, $class['nome_vulgar']);
	
	$insertSql = "INSERT INTO dados.ocorrencias (
						geom, x_utm, y_utm, coordenada_exacta, utm10, utm2,
						codigo_utm10, codigo_utm2, biotopo, biotopo_clc5, local1, local2, 
						observador, projecto, metodo, tipo, notas,
						reino, filo, subfilo, superclasse, classe, ordem, familia, genero, especie_comum, nome_vulgar, 
						fenologia, idade, sexo, comportamento, n_individuos, n_individuos_aproximando,
						data, dia, mes, ano, hora, minutos, valido, ec, fotografia_nome_ficheiro, move_zone,
						move_cons, move_anti, move_estrada, move_dna, move_km, move_estrada_auto,
						move_km_auto,move_distancia_estrada_auto)
					VALUES (
						st_setsrid(st_point({$safeInputs['xcoord']}, {$safeInputs['ycoord']}), 32629), {$safeInputs['xcoord']}, {$safeInputs['ycoord']}, {$coordenada_exacta}, {$utm10}, {$utm2},
						NULLIF('{$utm10Data['utm']}', ''), NULLIF('{$utm2Data['utm']}', ''), NULLIF('{$biotopo['legenda']}', ''), NULLIF('{$biotopoclc5['descri']}', ''), NULLIF('{$freguesia}', ''), NULLIF('{$osm}', ''),
						'$utilizador', '$nome_projecto', '{$safeInputs['method']}', '{$safeInputs['type']}', NULLIF('{$safeInputs['notas']}', ''),
						'{$class['reino']}', '{$class['filo']}', '{$class['subfilo']}', '{$class['superclasse']}', '{$class['classe']}', '{$class['ordem']}', '{$class['familia']}', '{$class['genero']}', '{$class['especie']}', '{$nome_vulgar}', 
						NULLIF('{$finaData['phenology']}', ''), NULLIF('{$finaData['age']}', ''), NULLIF('{$finaData['sex']}', ''), NULLIF('{$finaData['behavior']}', ''), {$safeInputs['individuals']}, {$indType},
						'{$data}', {$safeInputs['dia']}, ".($safeInputs['mes'] + 1).", {$safeInputs['ano']}, {$safeInputs['hora']}, {$safeInputs['minutos']}, TRUE, NULLIF('{$ec}', ''), NULLIF('{$safeInputs['foto']}', ''), '{$safeInputs['zona_atr']}'
						, '{$safeInputs['cons']}', '{$safeInputs['anti']}', '{$safeInputs['estrada']}', NULLIF('{$safeInputs['adn']}', '')
						, $kmfloat, '$move_estrada_auto', $move_km_auto, $move_distancia_estrada_auto)
					RETURNING gid";
	
	$insertQuery = pg_query($conn, $insertSql);
	if (pg_num_rows($insertQuery) > 0){
		echo '{"success": true, "msg": "Os seus dados foram inseridos com sucesso!"}';
		include 'mail.php';
	} else {
		exit ('{"success": false, "msg": "Não foi possível inserir os seus dados. Por favor tente novamente."}');
	}
	
	pg_close($conn);
?>
