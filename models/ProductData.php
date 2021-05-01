<?php 
  class ProductData {

    private $conn;
    private $tableName;
  
    public function __construct($db) {
      $this->conn = $db;
    }

    public function readExpiredProducts() {
      $query = 'SELECT * FROM `productdata` WHERE ExpiryDate <= CURDATE()';
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }

    public function getProductList($productId, $productName, $rakeNumber, $limit, $offset) {
      if ($productId) {
        $sql[] = " ProductId = '$productId' ";
      }
      if ($productName) {
        $sql[] = " ProductName LIKE '%$productName%' ";
      }
      if ($rakeNumber) {
        $sql[] = " RakeNumber = '$rakeNumber' ";
      }
      $query = "SELECT * FROM `productdata`";
      if (!empty($sql)) {
          $query .= ' WHERE ' . implode(' AND ', $sql);
      }
      $query .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;

      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }
  }

?>