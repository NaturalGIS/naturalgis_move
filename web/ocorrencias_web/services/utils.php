<?php 
	$globalConfigs = array(
		'server' => 'localhost',
		'port' => '5432',
		'dbname' => '***',
		'user' => '***',
		'password' => '***'
	);
	
	function getDbConnection(){
		$configs = $GLOBALS['globalConfigs'];
		$conn = pg_connect("host=".$configs['server']." dbname=".$configs['dbname']." user=".$configs['user']." password=".$configs['password']."");
		if ( !$conn){
			exit('{"success": false, "msg": "Não foi possível estabelecer a ligação à base de dados"}');
		}
		return $conn;
	}
	
	function makeSafeArray($unsafe){
		$safe = array();
		foreach ($unsafe as $key => $value){
			$safe[$key] = preg_replace('/[^-a-zA-Z0-9_@\/\.\:\,"[]\ ]/', '', $value);
		}
		return $safe;
	}
	
	function checkLength($inputs) {
		for ($i = 0; $i < count($inputs); $i++){
			$inputs[$i] = "$inputs[$i]";
			if( strlen($inputs[$i]) < 1 ){
				exit('{"success": false, "msg": "Existem alguns parâmetros obrigatórios que não foram passados no pedido."}');
			}	
		}
	}
?>
