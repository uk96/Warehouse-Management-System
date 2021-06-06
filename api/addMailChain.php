<?php
    session_start();

    include_once '../config/database.php';
    include_once '../models/authenticationData.php';

    $database = new Database();
    $db = $database->connect();
    $postData = json_decode(file_get_contents('php://input'), true);
    $userEmail= $postData["userEmail"];
    $authenticate = new Authenticate($db);
    $result = $authenticate->insertMailChain($userEmail);     
	if($result)
    {
        echo json_encode(
            array(
                'status' => 200,
                'message' => 'Email added'
            )
        );
    } else {
        $result = $authenticate->deleteMailChain($userEmail);
        if($result) {
            echo json_encode(
                array(
                    'status' => 200,
                    'message' => 'Email removed'
                )
            );
        } else {
            echo json_encode(
                array(
                    'status' => 400,
                    'message' => 'Something went wrong'
                )
            );
        }
    }
?>