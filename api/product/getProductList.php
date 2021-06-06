<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/ProductData.php';

  $productId = NULL;
  $productName = NULL;
  $rackNumber = NULL;
  if (isset($_GET['productId']))
  {
    $productId = $_GET['productId'];
  }
  if (isset($_GET['productName']))
  {
    $productName = $_GET['productName'];
  }
  if (isset($_GET['rackNumber']))
  {
    $rackNumber = $_GET['rackNumber'];
  }
  $limit = $_GET['limit'];
  $offset = $_GET['offset'];

  $database = new Database();
  $db = $database->connect();
  $product = new ProductData($db);
  $totalResult = $product->getCount($productId, $productName, $rackNumber);
  $total = (int)$totalResult->fetch(PDO::FETCH_ASSOC)['COUNT(*)'];
  $result = $product->getProductList($productId, $productName, $rackNumber, $limit, $offset);
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
        'quantity' => $Quantity,
        'leadTime' => $LeadTime
      );
      array_push($productList, $product);
    }

    $response = array(
        'total' => $total,
        'count' => $num,
        'data' => $productList
    );
    echo json_encode($response);
  } else {
 
    echo json_encode(
      array('message' => 'No Products Found')
    );
  }