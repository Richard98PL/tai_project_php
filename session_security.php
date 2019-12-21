<?php 
  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "Aby korzystać z serwisu w pełni, najpierw się zaloguj. </br>";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>
