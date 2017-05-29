<?php
ini_set('session.gc_maxlifetime', 36000);
session_set_cookie_params(36000);
session_start(); // Starting Session

$username=$_POST['username'];
$password=$_POST['password'];
$projecto=$_POST['projecto'];
$_SESSION['project']=$projecto;


$conn = pg_connect("host=localhost dbname=*** user=*** password=***");
$query = pg_query($conn,"SELECT gid,metodo_padrao FROM dados.projectos WHERE projecto='$projecto'");
$rows = pg_num_rows($query);
while ($row = pg_fetch_row($query)) {
$_SESSION['project_id']=$row[0];
$_SESSION['project_method_default']=$row[1];
}

$username = stripslashes($username);
$password = stripslashes($password);
$query = pg_query($conn,"SELECT * FROM dados.utilizadores WHERE palavra_chave='$password' AND email='$username'");
$rows = pg_num_rows($query);
if ($rows == 1) {
$_SESSION['login_user']=$username;
while ($row = pg_fetch_row($query)) {
$_SESSION['name_user']=$row[1];
}
header("location: index.php");
} else {
$_SESSION['errormessage']= "Username or Password is invalid";
header("location: start.php");
}
pg_close($conn);
?>
