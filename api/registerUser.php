<?php
    session_start();

    include_once '../config/database.php';
    include_once '../models/authenticationData.php';

    $database = new Database();
    $db = $database->connect();
 
	$userName= $_POST["fullName"];
    $userEmail= $_POST["userEmail"];
	$password= $_POST["password"];

    $authenticate = new Authenticate($db);
    $result = $authenticate->insertData($userName, $userEmail, $password);     
	if($result)
	{
        $_SESSION['userName']=$userName;
        $_SESSION['userEmail']=$userEmail;
        header("Location:../site/page/product.php");
	} else {
        header("Location:../site/page/home.php");
    }
?>