<?php
    include_once '../config/database.php';
    include_once '../models/authenticationData.php';

    $database = new Database();
    $db = $database->connect();
    $authenticate = new Authenticate($db);
    $result = $authenticate->getApiCall("/product/getReOrderProduct.php");
    $result = json_decode($result);
    $mailList = $authenticate->getAllEmail();
    while($row = $mailList->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $postdata = array(
            "subject" => "Source: Scheduler  Title: Reorder Data",
            "address" => $email,
            "data" => $result->data 
        );
        $mailResponse = $authenticate->makeApiCall("/mail_demo.php",$postdata);
        $mailResponse = json_decode($mailResponse);
        echo nl2br($email . "\n");
        echo nl2br($mailResponse->message . "\n");   
    }
?>