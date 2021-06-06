<?php 
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/database.php';
  include_once '../../models/ProductData.php';

  $database = new Database();
  $db = $database->connect();
  $product = new ProductData($db);
  $result = $product->thresholdProductList();
  $num = 0;
  $reOrderList = array();
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $safetyStock = (int)(($ZScore) * $LeadTime * $AverageQuantity);
    $leadTimeDemand = (int)($LeadTime * $AverageQuantity);
    $reOrderPoint = $safetyStock + $leadTimeDemand;
    if($reOrderPoint >= $ProductQuantity) {
        $reOrderItem = array(
            'productId' => $ProductId,
            'productName' => $ProductName,
            'expiryDate' => $ExpiryDate,
            'rackNumber' => $RackNumber,
            'productQuantity' => $ProductQuantity,
            'safetyStock' => $safetyStock,
            'leadTimeDemand' => $leadTimeDemand,
            'reorderPoint' => $reOrderPoint,
            'leadTime' => $LeadTime
        );
        $num++;
        array_push($reOrderList, $reOrderItem);
    }
  }

  $response = array(
      'total' => $num,
      'data' => $reOrderList
  );

  
  if($num > 0) {
    echo json_encode($response);
  } else {
 
    echo json_encode(
      array('message' => 'No reorder Products Found')
    );
  }
?>