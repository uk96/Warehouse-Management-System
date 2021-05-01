<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/orderData.php';

  $invoiceNumber = NULL;
  $productId = NULL;
  $productName = NULL;
  $customerId = NULL;
  if (isset($_GET['invoiceNumber']))
  {
    $invoiceNumber = $_GET['invoiceNumber'];
  }
  if (isset($_GET['productId']))
  {
    $productId = $_GET['productId'];
  }
  if (isset($_GET['productName']))
  {
    $productName = $_GET['productName'];
  }
  if (isset($_GET['customerId']))
  {
    $customerId = $_GET['customerId'];
  }
  $limit = $_GET['limit'];
  $offset = $_GET['offset'];

  $database = new Database();
  $db = $database->connect();
  $orderData = new OrderData($db);
  $totalResult = $orderData->getCount($invoiceNumber, $productId, $productName, $customerId);
  $total = (int)$totalResult->fetch(PDO::FETCH_ASSOC)['COUNT(*)'];
  $result = $orderData->getOrderData($invoiceNumber, $productId, $productName, $customerId, $limit, $offset);
  $num = $result->rowCount();

  if($num > 0) {
    
    $orderList = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $order = array(
        'invoiceNumber' => $InvoiceNumber,
        'productId' => $ProductId,
        'productName' => $ProductName,
        'quantity' => $Quantity,
        'invoiceDate' => $InvoiceDate,
        'unitPrice' => $UnitPrice,
        'customerId' => $CustomerId,
        'country' => $Country
      );
      array_push($orderList, $order);
    }

    $response = array(
        'total' => $total,
        'count' => $num,
        'data' => $orderList
    );
    echo json_encode($response);
  } else {
 
    echo json_encode(
      array('message' => 'No Orders Found')
    );
  }