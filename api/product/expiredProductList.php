<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/ProductData.php';

  $database = new Database();
  $db = $database->connect();
  $product = new ProductData($db);
  $startDate = NULL;
  $endDate = NULL;
  if (isset($_GET['startDate']))
  {
    $startDate = $_GET['startDate'];
  }
  if (isset($_GET['endDate']))
  {
    $endDate = $_GET['endDate'];
  }
  $result = $product->readExpiredProducts($startDate,$endDate);
  $num = $result->rowCount();

  if($num > 0) {
    
    $expiredList = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $expiredItem = array(
        'productId' => $ProductId,
        'productName' => $ProductName,
        'expiryDate' => $ExpiryDate,
        'rackNumber' => $RackNumber,
        'quantity' => $Quantity
      );
      array_push($expiredList, $expiredItem);
    }

    $response = array(
        'total' => $num,
        'data' => $expiredList
    );
    echo json_encode($response);
  } else {
 
    echo json_encode(
      array('message' => 'No Expired Products Found')
    );
  }