<?php
session_start(); // Starting Session

//include('login.php'); // Includes Login Script

if(!isset($_SESSION['login_user'])){
header("location: start.php");
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<title>Ocorrências de espécies</title>
            <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="Ocorrências de espécies">
	    <meta name="author" content="Ocorrências de espécies">
            <link href="form.css" rel="stylesheet" type="text/css">

	    <!-- Bootstrap core CSS -->
	    <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	    <link href="libs/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	    <link href="libs/datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	    <link href="libs/touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
	    <link href="libs/select2/select2.min.css" rel="stylesheet"/>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>	    

	    <!-- Custom CSS -->
	    <link href="resources/custom.css" rel="stylesheet"/>

  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>

  </head>
<body>
<?php
$data=date("Y-m-d");
$conn = pg_connect("host=localhost dbname=*** user=*** password=***");
$query = pg_query($conn,"SELECT * FROM dados.move_daily WHERE data='$data'");
$rows = pg_num_rows($query);
if ($rows == 1) {
while ($row = pg_fetch_row($query)) {
    $percurso = $row[1];
    $sentido = $row[3];
    $ceu = $row[4];
    $ch_anterior = $row[5];
    $chuva = $row[6]; 
    $nevoeiro = $row[7];
    $geada = $row[8];
    $vento = $row[9];
    $temperatura = $row[10];
    $hora_inicio = $row[11];
    $hora_fim = $row[12];
    $gps = $row[13];
    $notas = $row[14];     
}
}
else {
   $percurso = '';
}
pg_close($conn);
?>

<div id="main">
<div id="login">
<h3>Dados diarios MOVE:
<br><br>
<b>
<form action="move_daily.php" method="post">
<?php echo date("d/m/Y"); ?>
<input type="text" id="datepicker" value="<?php echo date("d/m/Y"); ?>"><br><br><input type="submit" value="mudar data">
</form>
</b></h3>
<span><?php echo $_SESSION['errormessage']; unset($_SESSION['errormessage']); ?></span><br><br>
<form action="move_daily_upload.php" method="post">
<label>Percurso:</label>
 <select id="percurso" name="percurso">
  <option value="Évora – Évoramonte" <?php if($percurso == 'Évora – Évoramonte' OR $percurso == '') {echo "selected";} ?>>Évora – Évoramonte</option>
  <option value="Évoramonte (N4) - Montemor" <?php if($percurso == 'Évoramonte (N4) - Montemor') {echo "selected";} ?>>Évoramonte (N4) - Montemor</option>
  <option value="Montemor- Évora" <?php if($percurso == 'Montemor- Évora') {echo "selected";} ?>>Montemor- Évora</option>  
</select> 
<br><br>
<!--
<label>Sentido:</label>
<input id="sentido" name="sentido" placeholder="" value="<?php echo $sentido; ?>" type="text">
<br><br>
-->
<label>Céu:</label><br>
 <select id="ceu" name="ceu">
  <option value="limpo" <?php if($ceu == 'limpo' OR $ceu == '') {echo "selected";} ?>>limpo</option>
  <option value="pouco nubolado" <?php if($ceu == 'pouco nubolado') {echo "selected";} ?>>pouco nubolado</option>
  <option value="muito nubolado" <?php if($ceu == 'muito nubolado') {echo "selected";} ?>>muito nubolado</option>
</select> 
<br><br>
<label>Chuva noite anterior:</label><br>
 <select id="ch_anterior" name="ch_anterior">
  <option value="true" <?php if($ch_anterior == 't') {echo "selected";} ?>>Sim</option>
  <option value="false" <?php if($ch_anterior == 'f' OR $ch_anterior == '') {echo "selected";} ?>>Não</option>
</select> 
<br><br>
<label>Chuva percurso:</label><br>
 <select id="chuva" name="chuva">
  <option value="true" <?php if($chuva == 't') {echo "selected";} ?>>Sim</option>
  <option value="false" <?php if($chuva == 'f' OR $chuva == '') {echo "selected";} ?>>Não</option>
</select> 
<br><br>
<label>Nevoeiro:</label><br>
 <select id="nevoeiro" name="nevoeiro">
  <option value="true" <?php if($nevoeiro == 't') {echo "selected";} ?>>Sim</option>
  <option value="false" <?php if($nevoeiro == 'f' OR $nevoeiro == '') {echo "selected";} ?>>Não</option>
</select> 
<br><br>
<label>Geada:</label><br>
 <select id="geada" name="geada">
  <option value="true" <?php if($geada == 't') {echo "selected";} ?>>Sim</option>
  <option value="false" <?php if($geada == 'f' OR $geada == '') {echo "selected";} ?>>Não</option>
</select> 
<br><br>
<label>Vento:</label><br>
 <select id="vento" name="vento">
  <option value="sem" <?php if($vento == 'sem' OR $vento == '') {echo "selected";} ?>>sem</option>
  <option value="fraco" <?php if($vento == 'fraco') {echo "selected";} ?>>fraco</option>
  <option value="moderado" <?php if($vento == 'moderado') {echo "selected";} ?>>moderado</option>
  <option value="forte" <?php if($vento == 'forte') {echo "selected";} ?>>forte</option>  
</select> 
<br><br>
<label>Temperatura:</label><br>
<input id="temperatura" name="temperatura" value="<?php if($temperatura != '') {echo $temperatura;} else {echo "20";} ?>" type="number"  step=0.1>
<br><br>
<label>Hora inicio:</label><br>
<input id="hora_inicio" name="hora_inicio" placeholder="8:30" value="<?php if($hora_inicio != '') {echo $hora_inicio;} else {print date('H:i');} ?>" type="time">
<br><br>
<label>Hora fim:</label><br>
<input id="hora_fim" name="hora_fim" placeholder="13:30" value="<?php if($hora_fim != '') {echo $hora_fim;} else {print date('H:i');} ?>" type="time">
<br><br>
<label>GPS:</label>
 <select id="gps" name="gps">
  <option value="id1" <?php if($gps == 'id1' OR $gps == '') {echo "selected";} ?>>id1</option>
  <option value="id2" <?php if($gps == 'id2') {echo "selected";} ?>>id2</option>
  <option value="id3" <?php if($gps == 'id3') {echo "selected";} ?>>id3</option>
</select> 
<br><br>
<label>Observações:</label>
<textarea id="notas" name="notas" value="" rows="10">
<?php if($notas != '') {echo $notas;} ?>
</textarea>

    <br><br>
    <input type="submit" value="MOVE" name="submit">

<span style="text-align:center;">
</span>

</form>
</div>
</div>

        	<div class="container form-btns">
                <div class="row pull-right" style="text-align: right;">
		<strong>
		<?php
                echo $_SESSION['name_user'];
                echo " (";
		echo $_SESSION['login_user'];
                echo ") ";
                ?>
		</strong>
                <a href="logout.php"><strong>[LOGOUT]</strong></a>
                <br>
                <a href="downloads/template.zip"><strong>[Tabela template e instruções]</strong></a>
                <br>
                <a href="index.php"><strong>[Envio de ocorrência simples]</strong></a>
                <br>                
                <a href="upload.php"><strong>[Envio de ocorrências múltiplas]</strong></a>
                <br>       
                <a href="move_daily.php"><strong>[Dados diarios MOVE]</strong></a>
                </div>
        	</div>

</body>
</html> 