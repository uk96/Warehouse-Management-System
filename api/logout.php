<?php
    session_start();
	$_SESSION["userName"]="";
	$_SESSION["userEmail"]="";
	header("Location:../site/page/home.php");
?>