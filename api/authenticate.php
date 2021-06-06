<?php
	session_start();
    
    include_once '../config/database.php';
    include_once '../models/authenticationData.php';

    $database = new Database();
    $db = $database->connect();
 
	$username= $_POST["userEmail"];
	$password= $_POST["password"];

    $authenticate = new Authenticate($db);
    $result = $authenticate->authorizeData($username, $password);
	$num = $result->rowCount();     
	if($num >0)
	{
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $_SESSION['userName']=$row['username'];
        $_SESSION['userEmail']=$row['useremail'];
	}
    header("Location:../site/page/product.php");
?>