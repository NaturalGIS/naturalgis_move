<?php
session_start();
if(session_destroy()) // Destroying All Sessions
{
header("Location: start.php"); // Redirecting To Home Page
}
?>
