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
	    
	    <!-- Custom CSS -->
	    <link href="resources/custom.css" rel="stylesheet"/>
</head>
<body>
<div id="main">
<div id="login">
<h3>Ocorrências de espécies: envio de tabela (CSV) de registos</h3>
    <br>
    <form action="uploadaction.php" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload">
    <br><br>
    <input type="submit" value="Enviar ocorrências" name="submit">

    
<span style="text-align: center; font-size: 12px;">
<?php
echo $_SESSION['message'];
?>
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
                <a href="move_daily.php"><strong>[Dados diarios MOVE]</strong></a>
                </div>
        	</div>

</body>
</html> 
