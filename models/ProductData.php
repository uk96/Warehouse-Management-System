<?php 
  class ProductData {

    private $conn;
    private $tableName;
  
    public function __construct($db) {
      $this->conn = $db;
    }

    public function readExpiredProducts($startDate, $endDate) {
      $query = '';
      if($startDate && $endDate){
        $query = 'SELECT * FROM productdata WHERE ExpiryDate >= "' . $startDate . '" && ExpiryDate <= "' . $endDate . '" ORDER BY ExpiryDate ASC';
      } else  {
        $query = 'SELECT * FROM productdata WHERE ExpiryDate <= CURDATE() ORDER BY ExpiryDate ASC';
      }
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }

    public function thresholdProductList() {
      $query = 'SELECT * , X.Quantity AS SalesQuantity, Y.Quantity AS ProductQuantity FROM yearlysalesdata X JOIN productdata Y ON X.ProductId = Y.ProductId';
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }

    public function getCount($productId, $productName, $rackNumber) {
      if ($productId) {
        $sql[] = " ProductId = '$productId' ";
      }
      if ($productName) {
        $sql[] = " ProductName LIKE '%$productName%' ";
      }
      if ($rackNumber) {
        $sql[] = " RackNumber = '$rackNumber' ";
      }
      $query = "SELECT COUNT(*) FROM productdata";
      if (!empty($sql)) {
        $query .= ' WHERE ' . implode(' AND ', $sql);
      }
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }

    public function getProductList($productId, $productName, $rackNumber, $limit, $offset) {
      if ($productId) {
        $sql[] = " ProductId = '$productId' ";
      }
      if ($productName) {
        $sql[] = " ProductName LIKE '%$productName%' ";
      }
      if ($rackNumber) {
        $sql[] = " RackNumber = '$rackNumber' ";
      }
      $query = "SELECT * FROM productdata";
      if (!empty($sql)) {
          $query .= ' WHERE ' . implode(' AND ', $sql);
      }
      $query .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;

      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }

    public function insertProduct($productData){
      try{
        $query = 'INSERT INTO productdata (ProductId, ProductName, LeadTime, DesiredServiceLevel, ZScore, ExpiryDate, RackNumber, Quantity) VALUES ("'.$productData['productId'].'", "'.$productData['productName'].'", "'.$productData['leadTime'].'", "85", "1.04", "'.$productData['expiredDate'].'", "'.$productData['rackNumber'].'", "'.$productData['quantity'].'")';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return 1;
      } catch(PDOException $e) {
        return 0;
      } 
    }

    public function editProduct($productData){
      try{
        $query = 'UPDATE productdata SET ProductName="'.$productData['productName'].'",LeadTime="'.$productData['leadTime'].'",ExpiryDate="'.$productData['expiredDate'].'",RackNumber="'.$productData['rackNumber'].'",Quantity="'.$productData['quantity'].'" WHERE ProductId = "'.$productData['productId'].'"';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return 1;
      } catch(PDOException $e) {
        return 0;
      } 
    }

    public function deleteProduct($productData){
      try{
        $query = 'DELETE FROM productdata WHERE ProductId ="'.$productData['productId'].'"';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return 1;   
      } catch(PDOException $e) {
        return 0;
      } 
    }
  }

?>