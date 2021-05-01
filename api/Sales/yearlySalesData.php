<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/yearlySalesData.php';

  $productId = NULL;
  if (isset($_GET['productId']))
  {
    $productId = $_GET['productId'];
  }
  $limit = $_GET['limit'];
  $offset = $_GET['offset'];

  $database = new Database();
  $db = $database->connect();
  $yearlySalesData = new YearlySalesData($db);
  $result = $yearlySalesData->getYearlySalesData($productId, $limit, $offset);
  $num = $result->rowCount();

  if($num > 0) {
    
    $row = $result->fetch(PDO::FETCH_ASSOC);
    extract($row);
    $response = array(
        'productId' => $ProductId,
        'numberOfDays' => $NumberOfDays,
        'sales' => $Sales,
        'quantity' => $Quantity,
        'averageQuantity' => $AverageQuantity,
        'averageSales' => $AverageSales
    );

    echo json_encode($response);
  } else {
 
    echo json_encode(
      array('message' => 'No Yearly Sales Data Found')
    );
  }