<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/database.php';
    include_once '../../models/orderData.php';
    include_once '../../models/ProductData.php';
    include_once '../../models/dailySalesData.php';
    include_once '../../models/yearlySalesData.php';
    $database = new Database();
    $db = $database->connect();
    $order = new OrderData($db);
    $product = new ProductData($db);
    $dailySales = new DailySalesData($db);
    $yearlySales = new YearlySalesData($db);
    $postData = json_decode(file_get_contents('php://input'), true);
    $productId = $postData["productId"];
    $quantity = $postData["quantity"];
    $invoiceNumber = $postData["invoiceNumber"];
    $customerId = $postData['customerId'];
    $country = "United Kingdom";
    $productList = $product->getProductList($productId,  null, null, 1, 0);
    $num = $productList->rowCount();
    if($num > 0) {
        $productData = array();
        while($row = $productList->fetch(PDO::FETCH_ASSOC)) {
            $productData = $row;
        }
        if($quantity <= $productData["Quantity"]) {
            $productData["Quantity"] = $productData["Quantity"] - $quantity;
            $updateData = array(
                "productName" => $productData["ProductName"],
                "leadTime" => $productData["LeadTime"],
                "expiredDate" => $productData["ExpiryDate"],
                "rackNumber" => $productData["RackNumber"],
                "quantity" => $productData["Quantity"],
                "productId" => $productData["ProductId"]
            );
            $updateQuantityResult = $product->editProduct($updateData);
            if($updateQuantityResult) {
                date_default_timezone_set('Asia/Kolkata');
                $currentDate = date("m/d/Y H:i");
                $updateOrderData = array(
                   'invoiceNumber' => $invoiceNumber,
                   'productId' => $productData["ProductId"],
                   'productName' => $productData["ProductName"],
                   'quantity' => $quantity,
                   'invoiceDate' => $currentDate,
                   'unitPrice' => "4.25",
                   'customerId' => $customerId,
                   'country' => "United Kingdom"  
                );
                $updateOrderResult = $order->insertOrder($updateOrderData);
                $isNewDay = 0;
                if($updateOrderData){
                    $dailySalesDataList = $dailySales->getDailySalesData($productData["ProductId"], date("n/j/Y"), 1, 0);
                    $num = $dailySalesDataList->rowCount();
                    if($num == 0) {
                        $createOrderData = array(
                            'productId'=> $productId,
                            'salesDate' => date("n/j/Y"),
                            'sales' => 4.25 * $quantity,
                            'quantity' => $quantity
                        );
                        $createDailySalesResult = $dailySales->insertDailySalesData($createOrderData);
                        if($createDailySalesResult) {
                            $isNewDay = 1;
                        } else {
                            echo json_encode(
                                array(
                                    'status' => 404,
                                    'message' => 'Error in creating daily sales.'
                                )
                            ); 
                            return;           
                        }
                    } else {
                        $dailySalesData = array();
                        while($row = $dailySalesDataList->fetch(PDO::FETCH_ASSOC)) {
                            $dailySalesData = $row;
                        }
                        $dailySalesData['Quantity'] += $quantity;
                        $dailySalesData['Sales'] += 4.25 * $quantity;
                        $updateDailySalesResult = $dailySales->updateQuantityDailySales($dailySalesData);
                        if($updateDailySalesResult) {
                            $isNewDay = 0;
                        } else {
                            echo json_encode(
                                array(
                                    'status' => 404,
                                    'message' => 'Error in updating daily sales.'
                                )
                            );
                            return;
                        }
                    }  
                    $yearlySalesDataList = $yearlySales->getYearlySalesData($productData["ProductId"], 1, 0);
                    $num = $yearlySalesDataList->rowCount();
                    if($num == 0) {
                        $createOrderData = array(
                            'productId'=> $productId,
                            'numberOfDays' => 1,
                            'sales' => 4.25 * $quantity,
                            'quantity' => $quantity,
                            'averageSales' => 4.25 * $quantity,
                            'averageQuantity' => $quantity
                        );
                        $createYearlySalesResult = $yearlySales->insertYearlySalesData($createOrderData);
                        if($createYearlySalesResult) {
                            echo json_encode(
                                array(
                                    'status' => 200,
                                    'message' => 'Order placed.'
                                )
                            );
                        } else {
                            echo json_encode(
                                array(
                                    'status' => 404,
                                    'message' => 'Error in creating yearly sales.'
                                )
                            ); 
                            return;           
                        }
                    } else {
                        $yearlySalesData = array();
                        while($row = $yearlySalesDataList->fetch(PDO::FETCH_ASSOC)) {
                            $yearlySalesData = $row;
                        }
                        $yearlySalesData['NumberOfDays'] += $isNewDay;
                        $yearlySalesData['Quantity'] += $quantity;
                        $yearlySalesData['AverageQuantity'] = ($yearlySalesData['Quantity'])/$yearlySalesData['NumberOfDays'];
                        $yearlySalesData['Sales'] += ($quantity * 4.25);
                        $yearlySalesData['AverageSales'] = ($yearlySalesData['Sales'])/$yearlySalesData['NumberOfDays'];    
                        $updateYearlySalesResult = $yearlySales->updateQuantityYearSales($yearlySalesData);
                        if($updateYearlySalesResult) {
                            echo json_encode(
                                array(
                                    'status' => 200,
                                    'message' => 'Order placed.'
                                )
                            );
                        } else {
                            echo json_encode(
                                array(
                                    'status' => 404,
                                    'message' => 'Error in updating yearly sales.'
                                )
                            );
                            return;
                        }
                    }
                } else {
                    echo json_encode(
                        array(
                            'status' => 404,
                            'message' => 'Error in creating order.'
                        )
                    ); 
                }
            } else {
                echo json_encode(
                    array(
                        'status' => 404,
                        'message' => 'Quantity deduction failed.'
                    )
                );    
            }
        } else {
            echo json_encode(
                array(
                    'status' => 404,
                    'message' => 'Insufficient quantity'
                )
            );       
        }

  } else {
    echo json_encode(
        array(
            'status' => 404,
            'message' => 'No Products Found'
        )
    );
  }
?>  