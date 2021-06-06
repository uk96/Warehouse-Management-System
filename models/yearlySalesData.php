<?php 
  class YearlySalesData {

    private $conn;
    private $tableName;
  
    public function __construct($db) {
      $this->conn = $db;
    }

    public function getCount($productId) {
        $query = "SELECT COUNT(*) FROM `yearlysalesdata`";
        if ($productId) {
            $query .= " WHERE ProductId = '$productId' ";
        }
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getYearlySalesData($productId, $limit, $offset) {
        $query = "SELECT * FROM `yearlysalesdata`";
        if ($productId) {
            $query .= " WHERE ProductId = '$productId' ";
        }
        $query .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function insertYearlySalesData($yearlyData) {
      try{
        $query = 'INSERT INTO yearlysalesdata(ProductId, NumberOfDays, Sales, Quantity, AverageQuantity, AverageSales) VALUES ("'.$yearlyData["productId"].'", "'.$yearlyData["numberOfDays"].'", "'.$yearlyData["sales"].'", "'.$yearlyData["quantity"].'","'.$yearlyData["averageQuantity"].'", "'.$yearlyData["averageSales"].'")';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return 1;
      } catch(PDOException $e) {
        return 0;
      }
    }

    public function updateQuantityYearSales($yearlySalesData){
      try{
          $query = 'UPDATE yearlysalesdata SET Quantity="'.$yearlySalesData['Quantity'].'" , AverageQuantity="'.$yearlySalesData['AverageQuantity'].'" , Sales="'.$yearlySalesData['Sales'].'" , AverageSales="'.$yearlySalesData['AverageSales'].'" , NumberOfDays="'.$yearlySalesData['NumberOfDays'].'" WHERE ProductId = "'.$yearlySalesData['ProductId'].'"';
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          return 1;
      } catch(PDOException $e) {
          return 0;
      }
    }
  }

?>