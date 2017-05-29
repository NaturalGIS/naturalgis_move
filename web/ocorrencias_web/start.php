<?php
session_start(); // Starting Session

if(isset($_SESSION['login_user']))
{
header("location: index.php");
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
<h3>Ocorrências de espécies</h3>
<form action="login.php" method="post">
<label>e-mail:</label>
<input id="name" name="username" placeholder="e-mail" type="text">
<br><br>
<label>password:</label>
<input id="password" name="password" placeholder="**********" type="password">
<br><br>
<label>Projecto:</label>
 <select id="projecto" name="projecto">
  <option value="MOVE" selected>MOVE</option>
  <option value="LIFE LINES">LIFE LINES</option>
  <option value="REFER">REFER</option>
</select>
<br><br>
<input name="submit" type="submit" value=" Login ">
 
<span style="text-align:center;">
<?php
echo $_SESSION['errormessage'];
?>
</span>

</form>
</div>
</div>
</body>
</html>