<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/database.php';
    include_once '../../models/ProductData.php';

    $database = new Database();
    $db = $database->connect();
    $product = new ProductData($db);
    $postData = json_decode(file_get_contents('php://input'), true); 
    $result = $product->deleteProduct($postData);
    if($result)
    {
        echo json_encode(
            array(
                'status' => 200,
                'message' => 'Products Deleted'
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
?>