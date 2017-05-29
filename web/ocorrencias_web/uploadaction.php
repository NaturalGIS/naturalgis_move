<?php
session_start(); // Starting Session

$conn = pg_connect("host=localhost dbname=*** user=*** password=***");

$target_dir = "/home/mapserver/www/vertebrados_uploads/";
$target_file = $target_dir . basename(utf8_encode($_FILES["fileToUpload"]["name"]));
$uploadOk = 1;
$FileType = pathinfo($target_file,PATHINFO_EXTENSION);

$new = $target_dir . $_SESSION['login_user'] . '_' . date("YmdHi") . '.' . $FileType;
$newfilename = $_SESSION['login_user'] . '_' . date("YmdHi") . '.' . $FileType;
$newfilename_noext = $_SESSION['login_user'] . '_' . date("YmdHi");

// Check if file already exists
//if (file_exists($target_file)) {
//    $_SESSION['message']= "Um ficheiro com o mesmo nome já existe";
//    $uploadOk = 0;
//            header("location: upload.php");
//}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    $errormessage = "Ficheiro demasiado grande.";
    $uploadOk = 0;
}

// Allow certain file formats
if($FileType != "csv") {
    $errormessage = "O ficheiro enviado não é um CSV.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $_SESSION['message']= $errormessage;
    header("location: upload.php");

// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $new)) {
    $insertSql = "COPY dados.ocorrencias (observador,projecto,metodo,tipo,local1,local2,reino,filo,subfilo,superclasse,classe,ordem,familia,genero,especie_comum,nome_vulgar,data,dia,mes,ano,hora,minutos,x_utm,y_utm,coordenada_exacta,codigo_utm10,codigo_utm2,codigo_utm1,utm10,utm2,utm1,biotopo,fenologia,idade,sexo,comportamento,n_individuos,n_individuos_aproximando,notas,fotografia_nome_ficheiro,fotografia_percurso,valido,ec,data_envio,biotopo_clc5) 
    FROM '" . $new . "' WITH DELIMITER ',' csv HEADER;";
    $insertQuery = pg_query($conn, $insertSql);
    if (pg_affected_rows($insertQuery) > 0) {
    $_SESSION['message'] = "Ficheiro <i><b>" . basename(utf8_encode($_FILES["fileToUpload"]["name"])) . "</b></i> enviado com sucesso. O envio ficou registado como<br><i><b>" . $newfilename_noext . "</b></i><br> Número de novos registos na base de dados: <b>" . pg_affected_rows($insertQuery) . "</b>";    
    $Sqlu1 = "UPDATE dados.ocorrencias SET geom = ST_SetSRID(ST_MakePoint(x_utm,y_utm),32629) WHERE ocorrencias.x_utm IS NOT NULL AND ocorrencias.y_utm IS NOT NULL AND ocorrencias.geom IS NULL;";
    $updateSqlu1 = pg_query($conn, $Sqlu1);
    $Sqlu2 = "UPDATE dados.ocorrencias SET local1 = freguesia FROM dados.freguesias WHERE ST_Intersects(freguesias.geom, ocorrencias.geom) AND local1 IS NULL;";
    $updateSqlu2 = pg_query($conn, $Sqlu2);
    $Sqlu3 = "UPDATE dados.ocorrencias SET biotopo_clc5 = descri FROM dados.clc5_evora WHERE ST_Intersects(clc5_evora.geom, ocorrencias.geom) AND biotopo_clc5 IS NULL;";
    $updateSqlu3 = pg_query($conn, $Sqlu3);
    $Sqlu4 = "UPDATE dados.ocorrencias SET biotopo = legenda FROM dados.clc3_2006 WHERE ST_Intersects(clc3_2006.geom, ocorrencias.geom) AND biotopo IS NULL;";
    $updateSqlu4 = pg_query($conn, $Sqlu4);    
    $Sqlu5 = "UPDATE dados.ocorrencias SET codigo_utm10 = utm FROM dados.grelha_utm_10 WHERE ST_Intersects(grelha_utm_10.geom, ocorrencias.geom) AND codigo_utm10 IS NULL;";
    $updateSqlu5 = pg_query($conn, $Sqlu5);    
    $Sqlu6 = "UPDATE dados.ocorrencias SET codigo_utm2 = tetrada FROM dados.grelha_utm_2 WHERE ST_Intersects(grelha_utm_2.geom, ocorrencias.geom) AND codigo_utm2 IS NULL;";
    $updateSqlu6 = pg_query($conn, $Sqlu6);    
    $Sqlu7 = "UPDATE dados.ocorrencias SET x_utm = xcoord, y_utm = ycoord, geom = ST_SetSRID(ST_MakePoint(xcoord,ycoord),32629) FROM dados.centroides_grelha_utm_10 WHERE ocorrencias.codigo_utm10 = centroides_grelha_utm_10.utm AND ocorrencias.x_utm IS NULL AND ocorrencias.y_utm IS NULL AND utm10 IS TRUE AND utm2 IS FALSE AND coordenada_exacta IS FALSE;";
    $updateSqlu7 = pg_query($conn, $Sqlu7);    
    $Sqlu8 = "UPDATE dados.ocorrencias SET x_utm = xcoord, y_utm = ycoord, geom = ST_SetSRID(ST_MakePoint(xcoord,ycoord),32629) FROM dados.centroides_grelha_utm_2 WHERE ocorrencias.codigo_utm2 = centroides_grelha_utm_2.tetrada AND ocorrencias.x_utm IS NULL AND ocorrencias.y_utm IS NULL AND utm10 IS FALSE AND utm2 IS TRUE AND coordenada_exacta IS FALSE;";
    $updateSqlu8 = pg_query($conn, $Sqlu8);    
    $Sqlu9 = "UPDATE dados.ocorrencias SET x_utm = ST_X(geom), y_utm = ST_Y(geom) WHERE ocorrencias.geom IS NOT NULL AND x_utm IS NULL AND y_utm IS NULL AND coordenada_exacta IS TRUE;";
    $updateSqlu9 = pg_query($conn, $Sqlu9);    
    $Sqlu10 = "UPDATE dados.ocorrencias SET reino = especies.reino, filo = especies.reino, subfilo = especies.reino, superclasse = especies.reino, classe = especies.reino, ordem = especies.reino, familia = especies.reino, genero = especies.reino, especie_comum = especies.reino, nome_vulgar = especies.reino FROM dados.especies WHERE upper(ocorrencias.ec) = especies.reino AND ocorrencias.especie_comum IS NULL AND ocorrencias.nome_vulgar IS NULL;";
    $updateSqlu10 = pg_query($conn, $Sqlu10);    
    $Sqlu11 = "UPDATE dados.ocorrencias SET reino = especies.reino, filo = especies.filo, subfilo = especies.filo, superclasse = especies.filo, classe = especies.filo, ordem = especies.filo, familia = especies.filo, genero = especies.filo, especie_comum = especies.filo, nome_vulgar = especies.filo FROM dados.especies WHERE upper(ocorrencias.ec) = especies.filo AND ocorrencias.especie_comum IS NULL AND ocorrencias.nome_vulgar IS NULL;";
    $updateSqlu11 = pg_query($conn, $Sqlu11);    
    $Sqlu12 = "UPDATE dados.ocorrencias SET reino = especies.reino, filo = especies.filo, subfilo = especies.subfilo, superclasse = especies.subfilo, classe = especies.subfilo, ordem = especies.subfilo, familia = especies.subfilo, genero = especies.subfilo, especie_comum = especies.subfilo, nome_vulgar = especies.subfilo FROM dados.especies WHERE upper(ocorrencias.ec) = especies.subfilo AND ocorrencias.especie_comum IS NULL AND ocorrencias.nome_vulgar IS NULL;";
    $updateSqlu12 = pg_query($conn, $Sqlu12);    
    $Sqlu13 = "UPDATE dados.ocorrencias SET reino = especies.reino, filo = especies.filo, subfilo = especies.subfilo, superclasse = especies.superclasse, classe = especies.superclasse, ordem = especies.superclasse, familia = especies.superclasse, genero = especies.superclasse, especie_comum = especies.superclasse, nome_vulgar = especies.superclasse FROM dados.especies WHERE upper(ocorrencias.ec) = especies.superclasse AND ocorrencias.especie_comum IS NULL AND ocorrencias.nome_vulgar IS NULL;";
    $updateSqlu13 = pg_query($conn, $Sqlu13);    
    $Sqlu14 = "UPDATE dados.ocorrencias SET reino = especies.reino, filo = especies.filo, subfilo = especies.subfilo, superclasse = especies.superclasse, classe = especies.classe, ordem = especies.classe, familia = especies.classe, genero = especies.classe, especie_comum = especies.classe, nome_vulgar = especies.classe FROM dados.especies WHERE upper(ocorrencias.ec) = especies.classe AND ocorrencias.especie_comum IS NULL AND ocorrencias.nome_vulgar IS NULL;";
    $updateSqlu14 = pg_query($conn, $Sqlu14);    
    $Sqlu15 = "UPDATE dados.ocorrencias SET reino = especies.reino, filo = especies.filo, subfilo = especies.subfilo, superclasse = especies.superclasse, classe = especies.classe, ordem = especies.ordem, familia = especies.ordem, genero = especies.ordem, especie_comum = especies.ordem, nome_vulgar = especies.ordem FROM dados.especies WHERE upper(ocorrencias.ec) = especies.ordem AND ocorrencias.especie_comum IS NULL AND ocorrencias.nome_vulgar IS NULL;";
    $updateSqlu15 = pg_query($conn, $Sqlu15);    
    $Sqlu16 = "UPDATE dados.ocorrencias SET reino = especies.reino, filo = especies.filo, subfilo = especies.subfilo, superclasse = especies.superclasse, classe = especies.classe, ordem = especies.ordem, familia = especies.familia, genero = especies.familia, especie_comum = especies.familia, nome_vulgar = especies.familia FROM dados.especies WHERE upper(ocorrencias.ec) = especies.familia AND ocorrencias.especie_comum IS NULL AND ocorrencias.nome_vulgar IS NULL;";
    $updateSqlu16 = pg_query($conn, $Sqlu16);    
    $Sqlu17 = "UPDATE dados.ocorrencias SET reino = especies.reino, filo = especies.filo, subfilo = especies.subfilo, superclasse = especies.superclasse, classe = especies.classe, ordem = especies.ordem, familia = especies.familia, genero = especies.genero, especie_comum = especies.genero, nome_vulgar = especies.genero FROM dados.especies WHERE upper(ocorrencias.ec) = especies.genero AND ocorrencias.especie_comum IS NULL AND ocorrencias.nome_vulgar IS NULL;";
    $updateSqlu17 = pg_query($conn, $Sqlu17);    
    $Sqlu18 = "UPDATE dados.ocorrencias SET reino = especies.reino, filo = especies.filo, subfilo = especies.subfilo, superclasse = especies.superclasse, classe = especies.classe, ordem = especies.ordem, familia = especies.familia, genero = especies.genero, especie_comum = especies.especie, nome_vulgar = especies.nome_vulgar FROM dados.especies WHERE ocorrencias.ec = especies.ec AND ocorrencias.especie_comum IS NULL AND ocorrencias.nome_vulgar IS NULL;";
    $updateSqlu18 = pg_query($conn, $Sqlu18);    
    $Sqlu19 = "UPDATE dados.ocorrencias SET data = to_timestamp(ano||'-'||mes||'-'||dia|| ' '||hora||':'||minutos,'YYYY-MM-DD HH24:MI') WHERE dia IS NOT NULL AND mes IS NOT NULL AND ano IS NOT NULL AND hora IS NOT NULL AND minutos IS NOT NULL AND data IS NULL;";
    $updateSqlu19 = pg_query($conn, $Sqlu19);    
    $Sqlu20 = "UPDATE dados.ocorrencias SET data = to_date(ano||'-'||mes||'-'||dia,'YYYY-MM-DD') WHERE dia IS NOT NULL AND mes IS NOT NULL AND ano IS NOT NULL AND hora IS NULL AND minutos IS NULL AND data IS NULL;";
    $updateSqlu20 = pg_query($conn, $Sqlu20);    
    $Sqludrop = "DROP TABLE dados.buffer_ocorrencias;";
    $updateSqludrop = pg_query($conn, $Sqludrop);  
    $Sqlubuffer = "CREATE TABLE dados.buffer_ocorrencias AS SELECT gid AS gid, coordenada_exacta, ST_Buffer(geom,25)::geometry(Polygon,32629) AS geom FROM dados.ocorrencias;";
    $updateSqlubuffer = pg_query($conn, $Sqlubuffer);      
    $Sqluindex = "CREATE INDEX sidx_buffer_ocorrencias_geom ON dados.buffer_ocorrencias USING gist (geom);";
    $updateSqluindex = pg_query($conn, $Sqluindex); 
    $Sqlu21 = "WITH lista AS (SELECT b.gid AS gid, a.osm_id AS osm_id FROM dados.estradas_osm a, dados.buffer_ocorrencias b WHERE ST_Intersects(a.geom,b.geom) AND b.coordenada_exacta IS TRUE) UPDATE dados.ocorrencias SET local2 = osm_id FROM lista WHERE dados.ocorrencias.gid = lista.gid  AND coordenada_exacta IS TRUE AND local2 IS NULL;";
    $updateSqlu21 = pg_query($conn, $Sqlu21);    
    include 'services/mail_table.php';
    }
    else {
    unlink($new);
    $_SESSION['message'] = "Houve um problema no registo das ocorrências, verificar estructura e formatação da tabela CSV.";
    }
    header("location: upload.php");
    } else {
        $_SESSION['message']= "Erro no envio do ficheiro.";
        header("location: upload.php");
    }
}
?>