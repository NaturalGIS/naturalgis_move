<?php
session_start(); // Starting Session
$conn = pg_connect("host=localhost dbname=*** user=*** password=***");

$percurso=$_POST['percurso'];
//$sentido=$_POST['sentido'];
$ceu=$_POST['ceu'];
$ch_anterior=$_POST['ch_anterior'];
$chuva=$_POST['chuva'];
$nevoeiro=$_POST['nevoeiro'];
$geada=$_POST['geada'];
$vento=$_POST['vento'];
$temperatura=$_POST['temperatura'];
$hora_inicio=$_POST['hora_inicio'];
$hora_fim=$_POST['hora_fim'];
$gps=$_POST['gps'];
$notas=$_POST['notas'];
$data=date("d-m-Y");

$query = pg_query($conn,"SELECT * FROM dados.move_daily WHERE data='$data'");
$rows = pg_num_rows($query);
if ($rows == 1) {
while ($row = pg_fetch_row($query)) {
	$insertSql = "UPDATE dados.move_daily SET percurso = (NULLIF('{$percurso}', '')), sentido = NULLIF('{$sentido}', ''), ceu = NULLIF('{$ceu}', ''),
	ch_anterior = {$ch_anterior},
	chuva = {$chuva},
	nevoeiro = {$nevoeiro},
	geada = {$geada}, 
	vento = NULLIF('{$vento}', ''),
	temperatura = {$temperatura},
	hora_inicio = '{$hora_inicio}',
	hora_fim = '{$hora_fim}',
	gps = NULLIF('{$gps}', ''),
	notas = NULLIF('{$notas}', '')	
	WHERE data ='$data' RETURNING gid";
					
	$insertQuery = pg_query($conn, $insertSql);

	if (pg_num_rows($insertQuery) > 0) {
		$_SESSION['errormessage']= "Dados gravados com sucesso";
	} else {
		$_SESSION['errormessage']= "Não foi possível gravar os dados.";
	}
}
}
else {
	$insertSql = "INSERT INTO dados.move_daily (percurso,sentido,ceu,ch_anterior,chuva,nevoeiro,geada,vento,temperatura,hora_inicio,hora_fim,gps,notas,data)
					VALUES (NULLIF('{$percurso}', ''), NULLIF('{$sentido}', ''), NULLIF('{$ceu}', ''), $ch_anterior, $chuva					
					, $nevoeiro,$geada, NULLIF('{$vento}', ''), $temperatura, '$hora_inicio', '$hora_fim', NULLIF('{$gps}', '')
					, NULLIF('{$notas}', ''), '{$data}')
					RETURNING gid";
					
	$insertQuery = pg_query($conn, $insertSql);

	if (pg_num_rows($insertQuery) > 0) {
		$_SESSION['errormessage']= "Dados gravados com sucesso";
	} else {
		$_SESSION['errormessage']= "Não foi possível gravar os dados.";
	}
}

pg_close($conn);
header("location: move_daily.php");

//$query = pg_query($conn,"SELECT * FROM dados.utilizadores WHERE palavra_chave='$password' AND email='$username'");
//$rows = pg_num_rows($query);
//if ($rows == 1) {
//$_SESSION['login_user']=$username;
//while ($row = pg_fetch_row($query)) {
//$_SESSION['name_user']=$row[1];
//}
//$_SESSION['errormessage']= "Dados gravados correctamente";
//header("location: move_daily.php");
//} else {
//$_SESSION['errormessage']= "Username or Password is invalid";
//header("location: start.php");
//}
//pg_close($conn);
?>



