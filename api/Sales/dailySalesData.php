<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/dailySalesData.php';

  $productId = NULL;
  $salesDate = NULL;
  if (isset($_GET['productId']))
  {
    $productId = $_GET['productId'];
  }
  if (isset($_GET['salesDate']))
  {
    $salesDate = $_GET['salesDate'];
  }
  $limit = $_GET['limit'];
  $offset = $_GET['offset'];

  $database = new Database();
  $db = $database->connect();
  $dailySalesData = new DailySalesData($db);
  $totalResult = $dailySalesData->getCount($productId, $salesDate);
  $total = (int)$totalResult->fetch(PDO::FETCH_ASSOC)['COUNT(*)'];
  $result = $dailySalesData->getDailySalesData($productId, $salesDate, $limit, $offset);
  $num = $result->rowCount();

  if($num > 0) {

    $dailySalesDataList = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $dailySales = array(
            'productId' => $ProductId,
            'salesDate' => $SalesDate,
            'sales' => $Sales,
            'quantity' => $Quantity
        );
        array_push($dailySalesDataList, $dailySales);
    }
    $response = array(
        'total' => $total,
        'count' => $num,
        'data' => $dailySalesDataList
    );
    echo json_encode($response);
  } else {
 
    echo json_encode(
      array('message' => 'No Daily Sales Data Found')
    );
  }