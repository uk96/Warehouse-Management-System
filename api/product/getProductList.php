<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/ProductData.php';

  $productId = $_GET['productId'];
  $productName = $_GET['productName'];
  $rakeNumber = $_GET['rakeNumber'];
  $limit = $_GET['limit'];
  $offset = $_GET['offset'];

  $database = new Database();
  $db = $database->connect();
  $product = new ProductData($db);
  $result = $product->getProductList($productId, $productName, $rakeNumber, $limit, $offset);
  $num = $result->rowCount();

  if($num > 0) {
    
    $productList = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $product = array(
        'productId' => $ProductId,
        'productName' => $ProductName,
        'expiryDate' => $ExpiryDate,
        'rackNumber' => $RackNumber,
        'quantity' => $Quantity
      );
      array_push($productList, $product);
    }

    $response = array(
        'total' => $num,
        'data' => $productList
    );
    echo json_encode($response);
  } else {
 
    echo json_encode(
      array('message' => 'No Products Found')
    );
  }